<?php

namespace App\Http\Controllers;

use App\Actions\RefundPaymentAction;
use App\Models\EcommerceProduct;
use App\Models\Order;
use App\Models\RefundBankDetail;
use App\Models\ReplacementRequest;
use App\Models\ReturnOrder;
use App\Services\OrderSupportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderSupportController extends Controller
{
    public function cancelOrder(Request $request, OrderSupportService $supportService, RefundPaymentAction $refundAction): JsonResponse
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json(['success' => false, 'message' => 'Please login to cancel order.'], 401);
        }

        $validated = $request->validate([
            'order_number' => 'required|string|exists:orders,order_number',
            'customer_notes' => 'required|string|max:1000',
        ]);

        $order = Order::where('order_number', $validated['order_number'])
            ->where('customer_id', Auth::guard('customer_web')->id())
            ->first();

        if (! $order) {
            return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
        }

        if (! $supportService->canCustomerCancel($order)) {
            return response()->json([
                'success' => false,
                'message' => 'Cancellation is only available before the order is shipped.',
            ], 422);
        }

        try {
            DB::beginTransaction();

            $order->status = Order::STATUS_CANCELLED;
            $order->cancelled_at = now();
            $order->cancellation_reason = $validated['customer_notes'];
            $order->customer_notes = $validated['customer_notes'];
            $order->refund_amount = $order->total_amount;

            $message = 'Order cancelled successfully.';

            if ($supportService->isPrepaid($order)) {
                $payment = $supportService->getRefundablePayment($order);

                if ($payment) {
                    try {
                        $refund = $refundAction->execute($payment);
                        $refundStatus = ($refund['status'] ?? null) === 'processed' ? 'completed' : 'processing';
                        $order->refund_status = $refundStatus;
                        $message = $refundStatus === 'completed'
                            ? 'Order cancelled and your Razorpay refund was initiated successfully.'
                            : 'Order cancelled. Your Razorpay refund request was submitted and is being processed.';
                    } catch (\Throwable $exception) {
                        Log::error('Cancellation refund failed', ['order_id' => $order->id, 'error' => $exception->getMessage()]);
                        $order->refund_status = 'failed';
                        $message = 'Order cancelled, but we could not start the refund automatically. Our team has been notified.';
                    }
                } else {
                    $order->refund_status = 'not_required';
                }
            } else {
                $order->refund_status = 'pending';
                $formUrl = $supportService->bankDetailsFormUrl($order, 'cancelled_order');
                $supportService->notifyCustomer(
                    $order->email ?? $order->customer?->email,
                    'Refund details required for your cancelled order',
                    'Share your refund bank details',
                    'Your order was cancelled successfully. Please use the secure form below so our team can process your COD refund.',
                    'Open refund form',
                    $formUrl,
                );
                $message = 'Order cancelled successfully. We have emailed you a refund form for the COD refund process.';
            }

            $order->save();

            $supportService->notifyAdmin(
                'Order cancellation received',
                'A customer cancelled an order',
                'Order #' . $order->order_number . ' has been cancelled and may require refund follow-up.',
                'Open order',
                route('order.view', $order->id),
            );

            DB::commit();

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::error('Error cancelling order', ['order_id' => $order->id, 'error' => $exception->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Unable to cancel the order right now.'], 500);
        }
    }

    public function returnOrder(Request $request, OrderSupportService $supportService): JsonResponse
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json(['success' => false, 'message' => 'Please login to return product.'], 401);
        }

        $validated = $request->validate([
            'order_number' => 'required|string|exists:orders,order_number',
            'order_item_id' => 'required|integer|exists:order_items,id',
            'return_reason' => 'required|string|max:255',
            'return_description' => 'nullable|string|max:1000',
            'return_images' => 'nullable|array|max:4',
            'return_images.*' => 'image|max:4096',
        ]);

        $order = Order::with('orderItems.product')
            ->where('order_number', $validated['order_number'])
            ->where('customer_id', Auth::guard('customer_web')->id())
            ->first();

        if (! $order) {
            return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
        }

        if (! $supportService->isDelivered($order)) {
            return response()->json(['success' => false, 'message' => 'Only delivered orders can be returned.'], 422);
        }

        if (! $order->is_returnable) {
            return response()->json(['success' => false, 'message' => 'This order is not returnable.'], 422);
        }

        if ($order->delivered_at && now()->greaterThan($order->delivered_at->copy()->addDays($order->return_days ?? 30))) {
            return response()->json(['success' => false, 'message' => 'The return window for this order has expired.'], 422);
        }

        $orderItem = $order->orderItems->firstWhere('id', (int) $validated['order_item_id']);
        if (! $orderItem) {
            return response()->json(['success' => false, 'message' => 'The selected item does not belong to this order.'], 422);
        }

        $existingReturn = ReturnOrder::where('order_number', $order->order_number)
            ->where('order_item_id', $orderItem->id)
            ->whereNull('deleted_at')
            ->first();

        if ($existingReturn) {
            return response()->json(['success' => false, 'message' => 'A return request already exists for this product.'], 422);
        }

        try {
            DB::beginTransaction();

            $images = [];
            if ($request->hasFile('return_images')) {
                foreach ($request->file('return_images') as $image) {
                    $images[] = $image->store('returns', 'public');
                }
            }

            $returnOrder = ReturnOrder::create([
                'order_number' => $order->order_number,
                'order_item_id' => $orderItem->id,
                'product_id' => $orderItem->product_id,
                'customer_id' => $order->customer_id,
                'return_person_id' => $order->customer_id,
                'return_reason' => $validated['return_reason'],
                'return_description' => $validated['return_description'] ?? null,
                'return_images' => $images,
                'payment_method_snapshot' => $supportService->isCod($order) ? 'cod' : 'prepaid',
                'customer_notes' => $validated['return_description'] ?? null,
                'refund_amount' => $orderItem->line_total,
                'refund_status' => ReturnOrder::REFUND_STATUS_PENDING,
                'status' => ReturnOrder::STATUS_PENDING,
            ]);

            $order->return_status = 'pending';
            $order->save();

            $supportService->notifyCustomer(
                $order->email ?? $order->customer?->email,
                'Your return request has been created',
                'Return request submitted',
                'We received your return request for order #' . $order->order_number . '. Our team will review it and arrange pickup.',
                'View order',
                route('order-details', $order->order_number),
            );

            $supportService->notifyAdmin(
                'New return request received',
                'A return request needs review',
                'Return request #' . $returnOrder->return_order_number . ' was created for order #' . $order->order_number . '.',
                'Open order',
                route('order.view', $order->id),
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Return request submitted successfully.',
                'data' => ['return_order_number' => $returnOrder->return_order_number],
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::error('Error creating return request', ['order_id' => $order->id, 'error' => $exception->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Unable to create the return request right now.'], 500);
        }
    }

    public function startReplacement(Request $request, OrderSupportService $supportService): JsonResponse
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json(['success' => false, 'message' => 'Please login to replace product.'], 401);
        }

        $validated = $request->validate([
            'order_number' => 'required|string|exists:orders,order_number',
            'order_item_id' => 'required|integer|exists:order_items,id',
            'reason' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $order = Order::with('orderItems.product.ecommerceProduct')
            ->where('order_number', $validated['order_number'])
            ->where('customer_id', Auth::guard('customer_web')->id())
            ->first();

        if (! $order || ! $supportService->isDelivered($order)) {
            return response()->json(['success' => false, 'message' => 'Replacement is only available for delivered orders.'], 422);
        }

        $orderItem = $order->orderItems->firstWhere('id', (int) $validated['order_item_id']);
        if (! $orderItem) {
            return response()->json(['success' => false, 'message' => 'The selected item does not belong to this order.'], 422);
        }

        $existingRequest = ReplacementRequest::where('order_id', $order->id)
            ->where('order_item_id', $orderItem->id)
            ->whereNotIn('status', [ReplacementRequest::STATUS_REJECTED, ReplacementRequest::STATUS_COMPLETED])
            ->first();

        if ($existingRequest) {
            return response()->json(['success' => false, 'message' => 'A replacement request already exists for this product.'], 422);
        }

        session([
            'replacement_request_context' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'order_item_id' => $orderItem->id,
                'original_product_id' => $orderItem->product_id,
                'original_ecommerce_product_id' => optional($orderItem->product?->ecommerceProduct)->id,
                'reason' => $validated['reason'],
                'description' => $validated['description'] ?? null,
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Choose the replacement product from the shop.',
            'redirect' => route('shop', ['category' => optional($orderItem->product)->parentCategorie?->slug]),
        ]);
    }

    public function replacementCompare(int $productId)
    {
        $context = session('replacement_request_context');
        if (! $context) {
            return redirect()->route('my-account-orders')->with('error', 'Please start the replacement flow again.');
        }

        $order = Order::with(['orderItems.product.ecommerceProduct', 'customer'])
            ->where('id', $context['order_id'])
            ->where('customer_id', Auth::guard('customer_web')->id())
            ->firstOrFail();

        $orderItem = $order->orderItems->firstWhere('id', $context['order_item_id']);
        abort_unless($orderItem, 404);

        $replacementProduct = EcommerceProduct::with([
            'warehouseProduct.brand',
            'warehouseProduct.parentCategorie',
            'warehouseProduct.subCategorie',
        ])->where('status', 'active')->findOrFail($productId);

        if ((int) optional($orderItem->product?->ecommerceProduct)->id === (int) $replacementProduct->id) {
            return redirect()->route('shop')->with('error', 'Please choose a different replacement product.');
        }

        return view('frontend.replacement-compare', [
            'order' => $order,
            'orderItem' => $orderItem,
            'originalProduct' => $orderItem->product,
            'originalEcommerceProduct' => $orderItem->product?->ecommerceProduct,
            'replacementProduct' => $replacementProduct,
            'replacementContext' => $context,
        ]);
    }

    public function submitReplacement(Request $request, OrderSupportService $supportService)
    {
        $context = session('replacement_request_context');
        if (! $context) {
            return redirect()->route('my-account-orders')->with('error', 'Please start the replacement flow again.');
        }

        $validated = $request->validate([
            'replacement_product_id' => 'required|integer|exists:ecommerce_products,id',
        ]);

        $order = Order::with(['orderItems.product.ecommerceProduct', 'customer'])
            ->where('id', $context['order_id'])
            ->where('customer_id', Auth::guard('customer_web')->id())
            ->firstOrFail();

        $orderItem = $order->orderItems->firstWhere('id', $context['order_item_id']);
        abort_unless($orderItem, 404);

        try {
            DB::beginTransaction();

            $replacementRequest = ReplacementRequest::create([
                'order_id' => $order->id,
                'order_item_id' => $orderItem->id,
                'customer_id' => $order->customer_id,
                'original_product_id' => $orderItem->product_id,
                'replacement_product_id' => $validated['replacement_product_id'],
                'reason' => $context['reason'],
                'description' => $context['description'],
                'status' => ReplacementRequest::STATUS_PENDING,
            ]);

            $order->replacement_status = 'pending';
            $order->save();

            session()->forget('replacement_request_context');

            $supportService->notifyCustomer(
                $order->email ?? $order->customer?->email,
                'Your replacement request has been created',
                'Replacement request submitted',
                'We received your replacement request for order #' . $order->order_number . '. Our team will review it shortly.',
                'View order',
                route('order-details', $order->order_number),
            );

            $supportService->notifyAdmin(
                'New replacement request received',
                'A replacement request needs review',
                'Replacement request #' . $replacementRequest->request_number . ' was created for order #' . $order->order_number . '.',
                'Open replacement requests',
                route('order.replacement-requests.index'),
            );

            DB::commit();

            return redirect()->route('order-details', $order->order_number)
                ->with('success', 'Replacement request submitted successfully.');
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::error('Error submitting replacement request', ['order_id' => $order->id, 'error' => $exception->getMessage()]);

            return redirect()->back()->with('error', 'Unable to submit the replacement request right now.');
        }
    }

    public function refundBankDetailsForm(Request $request, Order $order, string $context)
    {
        $returnOrder = $request->filled('return_order') ? ReturnOrder::find($request->integer('return_order')) : null;
        $bankDetail = RefundBankDetail::where('order_id', $order->id)
            ->when($returnOrder, fn ($query) => $query->where('return_order_id', $returnOrder->id))
            ->latest('id')
            ->first();

        return view('frontend.refund-bank-details-form', compact('order', 'context', 'returnOrder', 'bankDetail'));
    }

    public function refundBankDetailsStore(Request $request, Order $order, string $context, OrderSupportService $supportService)
    {
        $validated = $request->validate([
            'return_order_id' => 'nullable|integer|exists:return_orders,id',
            'account_holder_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:30',
            'ifsc_code' => 'required|string|max:20',
            'branch_name' => 'nullable|string|max:255',
            'upi_id' => 'nullable|string|max:255',
        ]);

        $returnOrder = ! empty($validated['return_order_id']) ? ReturnOrder::find($validated['return_order_id']) : null;

        RefundBankDetail::updateOrCreate(
            [
                'order_id' => $order->id,
                'return_order_id' => $returnOrder?->id,
                'refund_context' => $context,
            ],
            [
                'customer_id' => $order->customer_id,
                'account_holder_name' => $validated['account_holder_name'],
                'bank_name' => $validated['bank_name'],
                'account_number' => $validated['account_number'],
                'ifsc_code' => strtoupper($validated['ifsc_code']),
                'branch_name' => $validated['branch_name'] ?? null,
                'upi_id' => $validated['upi_id'] ?? null,
                'submitted_at' => now(),
            ]
        );

        $supportService->notifyAdmin(
            'Refund bank details submitted',
            'Customer refund details are ready',
            'Bank details were submitted for order #' . $order->order_number . '.',
            'Open order',
            route('order.view', $order->id),
        );

        return redirect()->route('order-details', $order->order_number)
            ->with('success', 'Your refund bank details were submitted successfully.');
    }
}
