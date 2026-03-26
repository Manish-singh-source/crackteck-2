<?php

namespace App\Http\Controllers;

use App\Actions\RefundPaymentAction;
use App\Models\Order;
use App\Models\ReplacementRequest;
use App\Models\ReturnOrder;
use App\Services\OrderSupportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminOrderSupportController extends Controller
{
    public function returnReceive(Request $request, int $id, OrderSupportService $supportService): RedirectResponse
    {
        $request->validate([
            'warehouse_status' => 'required|in:received',
        ]);

        try {
            $returnOrder = ReturnOrder::with(['order.customer'])->findOrFail($id);

            if ($returnOrder->status !== ReturnOrder::STATUS_PICKED) {
                return redirect()->back()->with('error', 'Return order must be in picked status to receive in warehouse.');
            }

            $returnOrder->status = ReturnOrder::STATUS_RECEIVED;
            $returnOrder->return_delivered_at = now();
            $returnOrder->save();

            if ($returnOrder->order) {
                $returnOrder->order->status = Order::STATUS_RETURNED;
                $returnOrder->order->return_status = 'received';
                $returnOrder->order->save();

                if ($supportService->isCod($returnOrder->order) && ! $supportService->getRefundBankDetail($returnOrder->order, $returnOrder)) {
                    $supportService->notifyCustomer(
                        $returnOrder->order->email ?? $returnOrder->order->customer?->email,
                        'Refund bank details required for your return',
                        'Share your refund bank details',
                        'We received your returned product. Please use the secure form below so we can process your COD refund.',
                        'Open refund form',
                        $supportService->bankDetailsFormUrl($returnOrder->order, 'returned_order', $returnOrder),
                    );
                }
            }

            return redirect()->back()->with('success', 'Return order received in warehouse successfully.');
        } catch (\Throwable $exception) {
            Log::error('Error receiving return order', ['return_order_id' => $id, 'error' => $exception->getMessage()]);

            return redirect()->back()->with('error', 'Failed to receive return order.');
        }
    }

    public function completeRefund(Request $request, int $id, RefundPaymentAction $refundAction, OrderSupportService $supportService): RedirectResponse
    {
        try {
            $returnOrder = ReturnOrder::with(['order.customer'])->findOrFail($id);

            if ($returnOrder->status !== ReturnOrder::STATUS_RECEIVED) {
                return redirect()->back()->with('error', 'Return order must be received in warehouse before refund.');
            }

            if ($returnOrder->refund_status === ReturnOrder::REFUND_STATUS_COMPLETED) {
                return redirect()->back()->with('error', 'Refund is already completed for this return request.');
            }

            $order = $returnOrder->order;
            if (! $order) {
                return redirect()->back()->with('error', 'Original order not found for this return request.');
            }

            if ($supportService->isPrepaid($order)) {
                $payment = $supportService->getRefundablePayment($order);
                if (! $payment) {
                    return redirect()->back()->with('error', 'No refundable Razorpay payment was found for this order.');
                }

                $refund = $refundAction->execute($payment, (int) round(((float) $returnOrder->refund_amount) * 100));
                $refundStatus = ($refund['status'] ?? null) === 'processed' ? ReturnOrder::REFUND_STATUS_COMPLETED : ReturnOrder::REFUND_STATUS_PROCESSING;

                $returnOrder->refund_status = $refundStatus;
                $returnOrder->refund_reference = $refund['id'] ?? null;
                $returnOrder->refund_notes = 'Razorpay refund processed through admin panel.';
                $returnOrder->return_completed_at = $refundStatus === ReturnOrder::REFUND_STATUS_COMPLETED ? now() : null;
                $returnOrder->save();

                $order->refund_status = $refundStatus === ReturnOrder::REFUND_STATUS_COMPLETED ? 'completed' : 'processing';
                $order->return_status = $refundStatus === ReturnOrder::REFUND_STATUS_COMPLETED ? 'refunded' : 'received';
                $order->save();
            } else {
                $bankDetail = $supportService->getRefundBankDetail($order, $returnOrder);
                if (! $bankDetail) {
                    $supportService->notifyCustomer(
                        $order->email ?? $order->customer?->email,
                        'Refund bank details required for your return',
                        'Share your refund bank details',
                        'We are ready to process your COD return refund, but we still need your bank details.',
                        'Open refund form',
                        $supportService->bankDetailsFormUrl($order, 'returned_order', $returnOrder),
                    );

                    return redirect()->back()->with('error', 'Bank details are required before a COD refund can be marked complete.');
                }

                $returnOrder->refund_status = ReturnOrder::REFUND_STATUS_COMPLETED;
                $returnOrder->refund_notes = 'Manual COD refund completed by admin.';
                $returnOrder->return_completed_at = now();
                $returnOrder->save();

                $order->refund_status = 'completed';
                $order->return_status = 'refunded';
                $order->save();
            }

            $supportService->notifyCustomer(
                $order->email ?? $order->customer?->email,
                'Refund update for your order',
                'Refund processed',
                'Your refund for order #' . $order->order_number . ' has been initiated/completed successfully.',
                'View order',
                route('order-details', $order->order_number),
            );

            return redirect()->back()->with('success', 'Refund processed successfully.');
        } catch (\Throwable $exception) {
            Log::error('Error completing refund', ['return_order_id' => $id, 'error' => $exception->getMessage()]);

            return redirect()->back()->with('error', 'Failed to complete refund.');
        }
    }

    public function replacementRequestsIndex()
    {
        $replacementRequests = ReplacementRequest::with([
            'order.customer',
            'orderItem',
            'originalProduct',
            'replacementProduct.warehouseProduct',
            'assignedPerson',
        ])->latest()->paginate(20);

        return view('e-commerce.order.replacement-requests', compact('replacementRequests'));
    }

    public function updateReplacementStatus(Request $request, int $id, OrderSupportService $supportService): RedirectResponse
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $replacementRequest = ReplacementRequest::with(['order.customer'])->findOrFail($id);

        if ($validated['action'] === 'approve') {
            $replacementRequest->status = ReplacementRequest::STATUS_APPROVED;
            $replacementRequest->approved_at = now();
            $replacementRequest->admin_notes = $validated['admin_notes'] ?? null;
            $replacementRequest->order->replacement_status = 'approved';

            $supportService->notifyCustomer(
                $replacementRequest->order->email ?? $replacementRequest->order->customer?->email,
                'Replacement request approved',
                'Your replacement request was approved',
                'Your replacement request for order #' . $replacementRequest->order->order_number . ' was approved. We will assign the next step soon.',
                'View order',
                route('order-details', $replacementRequest->order->order_number),
            );
        } else {
            $replacementRequest->status = ReplacementRequest::STATUS_REJECTED;
            $replacementRequest->rejected_at = now();
            $replacementRequest->admin_notes = $validated['admin_notes'] ?? null;
            $replacementRequest->order->replacement_status = 'rejected';

            $supportService->notifyCustomer(
                $replacementRequest->order->email ?? $replacementRequest->order->customer?->email,
                'Replacement request update',
                'Your replacement request was rejected',
                'Your replacement request for order #' . $replacementRequest->order->order_number . ' was not approved. Please contact support if you need help.',
                'View order',
                route('order-details', $replacementRequest->order->order_number),
            );
        }

        $replacementRequest->save();
        $replacementRequest->order->save();

        return redirect()->back()->with('success', 'Replacement request updated successfully.');
    }

    public function assignReplacementRequest(Request $request, int $id, OrderSupportService $supportService): RedirectResponse
    {
        $validated = $request->validate([
            'assigned_person_type' => 'required|in:engineer,delivery_man',
            'delivery_man_id' => 'nullable|exists:staff,id',
            'engineer_id' => 'nullable|exists:staff,id',
        ]);

        $replacementRequest = ReplacementRequest::with(['order.customer'])->findOrFail($id);

        if (! in_array($replacementRequest->status, [ReplacementRequest::STATUS_APPROVED, ReplacementRequest::STATUS_ASSIGNED], true)) {
            return redirect()->back()->with('error', 'Only approved replacement requests can be assigned.');
        }

        $replacementRequest->assigned_person_type = $validated['assigned_person_type'];
        $replacementRequest->assigned_person_id = $validated['assigned_person_type'] === 'engineer'
            ? ($validated['engineer_id'] ?? null)
            : ($validated['delivery_man_id'] ?? null);
        $replacementRequest->assigned_at = now();
        $replacementRequest->status = ReplacementRequest::STATUS_ASSIGNED;
        $replacementRequest->save();

        $replacementRequest->order->replacement_status = 'assigned';
        $replacementRequest->order->save();

        $supportService->notifyCustomer(
            $replacementRequest->order->email ?? $replacementRequest->order->customer?->email,
            'Replacement request assigned',
            'Your replacement request is moving forward',
            'We assigned your replacement request for order #' . $replacementRequest->order->order_number . ' to our team for the next step.',
            'View order',
            route('order-details', $replacementRequest->order->order_number),
        );

        return redirect()->back()->with('success', 'Replacement request assigned successfully.');
    }
}
