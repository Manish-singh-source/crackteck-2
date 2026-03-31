<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Customer;
use App\Models\EcommerceProduct;
use App\Models\InventoryUpdateLog;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\ProductSerial;
use App\Models\ReturnOrder;
use App\Models\Staff;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use TCPDF;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'invoice', 'orderItems.ecommerceProduct.warehouseProduct']);

        // Status filter
        if ($request->has('status') && ! empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->has('date_from') && ! empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && ! empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Paginate orders
        $orders = $query->orderByDesc('created_at')->get();

        // Efficiently get status counts
        $statusCounts = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Ensure all statuses are represented, including 'all'
        $allStatuses = ['all', 'pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];
        $statusCounts = array_merge(array_fill_keys($allStatuses, 0), $statusCounts);
        $statusCounts['all'] = Order::count();

        return view('e-commerce.order.index', compact('orders', 'statusCounts'));
    }

    public function create()
    {
        return view('e-commerce.order.create');
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = collect($request->items)->sum('line_total');
            $taxAmount = collect($request->items)->sum('tax_per_unit');
            $shippingCharges = $request->shipping_charges ?? 0;
            $discountAmount = $request->discount_amount ?? 0;
            $couponCode = $request->coupon_code ?? 0;
            $packagingCharges = $request->packaging_charges ?? 0;
            $totalAmount = $subtotal + $taxAmount + $shippingCharges + $packagingCharges - $discountAmount - $couponCode;

            // Generate order number
            $orderNumber = 'ORD-'.date('Ymd').'-'.str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);

            // Create the order
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_number' => $orderNumber,
                'source_platform' => 'admin_panel',
                'total_items' => count($request->items),
                'shipping_address_id' => $request->shipping_address_id,
                'billing_same_as_shipping' => true,
                'billing_address_id' => $request->shipping_address_id,
                'payment_status' => $request->payment_status,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_charges' => $shippingCharges,
                'packaging_charges' => $packagingCharges,
                'discount_amount' => $discountAmount,
                'coupon_code' => $couponCode,
                'total_amount' => $totalAmount,
                'status' => $request->status,
                'assigned_person_type' => 'delivery_man',
                'assigned_person_id' => $request->assigned_person_id,
                'confirmed_at' => $request->status === 'confirmed' ? now() : null,
            ]);

            // Create order items
            foreach ($request->items as $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $itemData['product_id'],
                    'product_name' => $itemData['product_name'],
                    'product_sku' => $itemData['product_sku'],
                    'hsn_code' => $itemData['hsn_code'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'discount_per_unit' => $itemData['discount_per_unit'] ?? 0,
                    'tax_per_unit' => $itemData['tax_per_unit'] ?? 0,
                    'line_total' => $itemData['line_total'],
                ]);
            }

            // Create payment record
            OrderPayment::create([
                'order_id' => $order->id,
                'payment_id' => 'PMT-'.strtoupper(uniqid()),
                'transaction_id' => 'TXN-'.strtoupper(uniqid()),
                'payment_method' => $request->payment_method,
                'payment_gateway' => $request->payment_method === 'online' ? 'phonepe' : 'cash_on_delivery',
                'amount' => $totalAmount,
                'currency' => 'INR',
                'status' => $request->payment_status,
                'processed_at' => now(),
            ]);

            // Optional: Update product quantities after order confirmation
            $this->updateProductQuantities($order);

            DB::commit();

            return redirect()->route('order.index')
                ->with('success', 'E-commerce order created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Order creation failed', ['error' => $e->getMessage(), 'order_data' => $request->all()]);

            return redirect()->back()->withInput()->with('error', 'Failed to create order: '.$e->getMessage());
        }
    }

    public function edit($id)
    {
        $order = Order::with(['customer', 'orderItems.product.ecommerceProduct', 'shippingAddress'])
            ->findOrFail($id);

        return view('e-commerce.order.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address_line_1' => 'required|string|max:255',
            'shipping_address_line_2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_zipcode' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            // Check if order can be edited
            if (in_array($order->status, ['shipped', 'delivered'])) {
                return redirect()->back()
                    ->with('error', 'Cannot modify orders that have been shipped or delivered.');
            }

            $data = $request->only([
                'status',
                'shipping_first_name',
                'shipping_last_name',
                'shipping_phone',
                'shipping_address_line_1',
                'shipping_address_line_2',
                'shipping_city',
                'shipping_state',
                'shipping_zipcode',
                'notes',
            ]);

            // Update status timestamps
            if ($request->status !== $order->status) {
                if ($request->status === 'confirmed' && $order->status !== 'confirmed') {
                    $data['confirmed_at'] = now();
                } elseif ($request->status === 'shipped' && $order->status !== 'shipped') {
                    $data['shipped_at'] = now();
                } elseif ($request->status === 'delivered' && $order->status !== 'delivered') {
                    $data['delivered_at'] = now();
                }
            }

            $order->update($data);

            DB::commit();

            return redirect()->route('order.view', $order->id)
                ->with('success', 'Order updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating order: '.$e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while updating the order: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);

            // Check if order can be deleted (business logic)
            if (in_array($order->status, ['shipped', 'delivered'])) {
                return redirect()->back()->with('error', 'Cannot delete orders that have been shipped or delivered.');
            }

            // Delete order items first
            $order->orderItems()->delete();

            // Delete the order
            $order->delete();

            return redirect()->route('order.index')->with('success', 'Order deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting order: '.$e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while deleting the order: '.$e->getMessage());
        }
    }

    public function bulkDestroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_ids' => 'required|array|min:1',
            'order_ids.*' => 'required|integer|exists:ecommerce_orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid order selection.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $orderIds = $request->order_ids;
            $deletedCount = 0;
            $errors = [];

            foreach ($orderIds as $orderId) {
                try {
                    $order = Order::find($orderId);

                    if ($order) {
                        // Check if order can be deleted
                        if (in_array($order->status, ['shipped', 'delivered'])) {
                            $errors[] = "Cannot delete order #{$order->order_number} - already shipped/delivered";

                            continue;
                        }

                        // Delete order items first
                        $order->orderItems()->delete();

                        // Delete the order
                        $order->delete();
                        $deletedCount++;
                    }
                } catch (\Exception $e) {
                    $errors[] = "Failed to delete order ID {$orderId}: ".$e->getMessage();
                    Log::error("Error deleting order {$orderId}: ".$e->getMessage());
                }
            }

            DB::commit();

            if ($deletedCount > 0) {
                $message = $deletedCount === 1
                    ? '1 order deleted successfully!'
                    : "{$deletedCount} orders deleted successfully!";

                if (! empty($errors)) {
                    $message .= ' However, some orders could not be deleted.';
                }

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'deleted_count' => $deletedCount,
                    'errors' => $errors,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No orders were deleted.',
                    'errors' => $errors,
                ], 400);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in bulk delete: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting orders: '.$e->getMessage(),
            ], 500);
        }
    }

    public function searchProducts(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = EcommerceProduct::with(['warehouseProduct.brand'])
            ->whereHas('warehouseProduct', function ($q) use ($query) {
                $q->where('product_name', 'LIKE', "%{$query}%")
                    ->orWhere('sku', 'LIKE', "%{$query}%");
            })
            ->where('status', 'active')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'product_name' => $product->warehouseProduct->product_name,
                    'sku' => $product->warehouseProduct->sku,
                    'brand' => $product->warehouseProduct->brand->name ?? 'N/A',
                    'hsn_code' => $product->warehouseProduct->hsn_code,
                    'price' => $product->warehouseProduct->final_price,
                    'display' => $product->warehouseProduct->product_name.' ('.$product->warehouseProduct->sku.')',
                ];
            });

        return response()->json($products);
    }

    public function searchProductSerials(Request $request)
    {
        $query = $request->get('q', '');
        $productId = $request->get('product_id', null);

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $serialsQuery = ProductSerial::where(function ($q) use ($query) {
            $q->where('auto_generated_serial', 'LIKE', "%{$query}%")
                ->orWhere('manual_serial', 'LIKE', "%{$query}%");
        })->where('status', 'active');

        // If product_id is provided, filter by that product
        if ($productId) {
            $serialsQuery->where('product_id', $productId);
        }

        $serials = $serialsQuery->limit(20)->get()->map(function ($serial) {
            return [
                'id' => $serial->id,
                'auto_generated_serial' => $serial->auto_generated_serial,
                'manual_serial' => $serial->manual_serial,
                'product_id' => $serial->product_id,
                'status' => $serial->status,
                'display' => $serial->auto_generated_serial . ($serial->manual_serial ? ' (' . $serial->manual_serial . ')' : ''),
            ];
        });

        return response()->json($serials);
    }

    public function searchCustomers(Request $request)
    {
        $query = $request->query('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $customers = Customer::with('addressDetails')
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'LIKE', "%{$query}%")
                    ->orWhere('last_name', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->orWhere('phone', 'LIKE', "%{$query}%");
            })
            ->select('id', 'first_name', 'last_name', 'email', 'phone')
            ->get();

        return response()->json($customers);
    }

    /**
     * Mark return order as received in warehouse
     */
    public function returnReceive(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'warehouse_status' => 'required|in:received',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Invalid warehouse status');
        }

        try {
            $returnOrder = ReturnOrder::findOrFail($id);

            // Check if return order is in picked status
            if ($returnOrder->status !== 'picked') {
                return redirect()->back()->with('error', 'Return order must be in picked status to receive in warehouse');
            }

            // Update return order status to received
            $returnOrder->status = 'received';
            $returnOrder->return_delivered_at = now();
            $returnOrder->save();

            // Update main order status to 'returned'
            $order = Order::where('order_number', $returnOrder->order_number)->first();
            if ($order) {
                $order->status = 'returned';
                $order->save();
            }

            return redirect()->back()->with('success', 'Return order received in warehouse successfully');
        } catch (\Exception $e) {
            Log::error('Error receiving return order: '.$e->getMessage());

            return redirect()->back()->with('error', 'Failed to receive return order');
        }
    }

    /**
     * Complete the refund for return order
     */
    public function completeRefund(Request $request, $id)
    {
        try {
            $returnOrder = ReturnOrder::findOrFail($id);

            // Check if return order is in received status
            if ($returnOrder->status !== 'received') {
                return redirect()->back()->with('error', 'Return order must be received in warehouse to complete refund');
            }

            // Check if refund is not already completed
            if ($returnOrder->refund_status === 'completed') {
                return redirect()->back()->with('error', 'Refund already completed');
            }

            // Update refund status to completed
            $returnOrder->refund_status = 'completed';
            $returnOrder->return_completed_at = now();
            $returnOrder->save();

            return redirect()->back()->with('success', 'Refund completed successfully');
        } catch (\Exception $e) {
            Log::error('Error completing refund: '.$e->getMessage());

            return redirect()->back()->with('error', 'Failed to complete refund');
        }
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'orderItems.product.ecommerceProduct', 'orderPayments'])
            ->findOrFail($id);
        $deliveryMen = Staff::where('staff_role', 'delivery_man')->where('status', 'active')->get();
        $engineers = Staff::where('staff_role', 'engineer')->where('status', 'active')->get();
        $assignedPerson = Staff::find($order->assigned_person_id);

        // Get return order if exists for this order
        $returnOrder = ReturnOrder::where('order_number', $order->order_number)->first();

        // Calculate totals
        $totals = $this->calculateOrderTotals($order);

        return view('e-commerce.order.view', compact('order', 'totals', 'deliveryMen', 'engineers', 'assignedPerson', 'returnOrder'));
    }

    public function assignPerson(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'assigned_person_type' => 'required|in:engineer,delivery_man',
            'delivery_man_id' => 'nullable|exists:staff,id',
            'engineer_id' => 'nullable|exists:staff,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $order = Order::findOrFail($id);
            $order->assigned_person_type = $request->assigned_person_type;

            if ($request->assigned_person_type == 'engineer') {
                $order->assigned_person_id = $request->engineer_id;
                // Auto-update status to assigned_delivery_man when engineer is assigned
                if ($order->status === 'admin_approved') {
                    $order->status = 'assigned_delivery_man';
                }
                $order->assigned_at = now();
            } else {
                $order->assigned_person_id = $request->delivery_man_id;
                // Auto-update status to assigned_delivery_man when delivery man is assigned
                if ($order->status === 'admin_approved') {
                    $order->status = 'assigned_delivery_man';
                    $order->assigned_at = now();
                }

                // Also update return_orders table if return exists for this order
                $returnOrder = ReturnOrder::where('order_number', $order->order_number)->first();
                if ($returnOrder) {
                    $returnOrder->delivery_man_id = $request->delivery_man_id;
                    $returnOrder->return_assigned_at = now();
                    if ($returnOrder->status === 'pending') {
                        $returnOrder->status = 'assigned';
                    }
                    $returnOrder->save();
                }
            }
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Person assigned successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error assigning person: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to assign person',
            ], 500);
        }
    }

    private function calculateOrderTotals($order)
    {
        $subtotal = $order->orderItems->sum('line_total');
        $taxAmount = $order->orderItems->sum('tax_per_unit');
        $shippingCharges = $order->shipping_charges;
        $discountAmount = $order->discount_amount;
        $grandTotal = $order->total_amount;

        $roundingOff = round($grandTotal) - $grandTotal;

        return [
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total_tax' => $taxAmount,
            'shipping_charges' => $shippingCharges,
            'discount_amount' => $discountAmount,
            'grand_total' => $grandTotal,
            'rounded_total' => round($grandTotal),
            'rounding_off' => $roundingOff,
            'total_amount' => $grandTotal,
            'total_in_words' => $this->convertNumberToWords($grandTotal),
        ];
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|in:pending,admin_approved,assigned_delivery_man,order_accepted,product_taken,delivered,cancelled,returned',
            'expected_delivery_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $order = Order::findOrFail($id);
            $oldOrderStatus = $order->status;
            $oldStatus = $order->status;

            // Update status only if provided
            if ($request->has('status') && $request->status) {
                $newOrderStatus = $request->status;
                $order->status = $newOrderStatus;

                // Update status timestamps for status
                if ($newOrderStatus === 'confirmed' && $oldOrderStatus !== 'confirmed') {
                    $order->confirmed_at = now();
                } elseif ($newOrderStatus === 'shipped' && $oldOrderStatus !== 'shipped') {
                    $order->shipped_at = now();
                } elseif ($newOrderStatus === 'delivered' && $oldOrderStatus !== 'delivered') {
                    $order->delivered_at = now();
                } elseif ($newOrderStatus === 'cancelled' && $oldOrderStatus !== 'cancelled') {
                    $order->cancelled_at = now();
                }
            }

            // Update new delivery status if provided
            if ($request->has('status') && $request->status) {
                $newStatus = $request->status;
                $order->status = $newStatus;

                // Update status timestamps
                if ($newStatus === 'admin_approved' && $oldStatus !== 'admin_approved') {
                    // admin_approved doesn't have a timestamp field
                    $order->confirmed_at = now();
                } elseif ($newStatus === 'assigned_delivery_man' && $oldStatus !== 'assigned_delivery_man') {
                    $order->assigned_at = now();
                } elseif ($newStatus === 'order_accepted' && $oldStatus !== 'order_accepted') {
                    $order->accepted_at = now();
                } elseif ($newStatus === 'delivered' && $oldStatus !== 'delivered') {
                    $order->delivered_at = now();
                } elseif ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                    $order->cancelled_at = now();
                }
            }

            // Update expected_delivery_date if provided
            if ($request->has('expected_delivery_date') && $request->expected_delivery_date) {
                $order->expected_delivery_date = $request->expected_delivery_date;
            }

            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating order status: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status',
            ], 500);
        }
    }

    public function productPickup(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pickup_confirmation' => 'required|accepted',
            'order_item_id' => 'required|array',
            'product_serial_id' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Please confirm product pickup and assign serial numbers.');
        }

        try {
            $order = Order::findOrFail($id);

            // Check if order is in the correct status
            if ($order->status !== 'order_accepted') {
                return redirect()->back()->with('error', 'Order must be in order_accepted status to mark as product taken.');
            }

            // Update order items with serial numbers
            $orderItemIds = $request->order_item_id;
            $serialIds = $request->product_serial_id;
            $productIds = $request->product_id;

            foreach ($orderItemIds as $index => $orderItemId) {
                $orderItem = OrderItem::find($orderItemId);
                if ($orderItem && isset($serialIds[$index]) && $serialIds[$index]) {
                    // Update the order item with the serial ID
                    $orderItem->product_serial_id = $serialIds[$index];
                    // Update item status from pending to shipped
                    if ($orderItem->item_status === 'pending' || empty($orderItem->item_status)) {
                        $orderItem->item_status = 'shipped';
                    }
                    $orderItem->save();

                    // Update the serial status to sold
                    $productSerial = ProductSerial::find($serialIds[$index]);
                    if ($productSerial) {
                        $productSerial->status = 'sold';
                        $productSerial->save();
                    }
                }
            }

            // Update status to product_taken and set shipped_at
            $order->status = 'product_taken';
            $order->shipped_at = now();
            $order->save();

            return redirect()->back()->with('success', 'Product pickup confirmed with serial numbers. Order status updated to product_taken.');
        } catch (\Exception $e) {
            Log::error('Error updating product pickup: '.$e->getMessage());

            return redirect()->back()->with('error', 'Failed to update product pickup.');
        }
    }

    public function assignDeliveryMan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'delivery_man_id' => 'required|exists:delivery_men,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $order = Order::findOrFail($id);
            $order->delivery_man_id = $request->delivery_man_id;
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Delivery man assigned successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error assigning delivery man: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to assign delivery man',
            ], 500);
        }
    }

    public function generateInvoice($id)
    {
        try {

            $order = Order::with(['customer', 'orderItems', 'orderPayments', 'billingAddress', 'shippingAddress'])
                ->findOrFail($id);

            $totals = $this->calculateOrderTotals($order);

            $invoiceData = [
                'order' => $order,
                'totals' => $totals,
                'invoice_number' => 'INV-'.$order->order_number,
                'invoice_date' => $order->created_at->format('d/m/Y'),
                'amount_in_words' => $this->convertNumberToWords($totals['grand_total']),
                'company' => [
                    'name' => 'CrackTeck Solutions Pvt. Ltd.',
                    'address' => 'Tech Park, Mumbai - 400001',
                    'gstin' => '27AABCC1234M1Z2',
                    'phone' => '+91 98765 43210',
                    'email' => 'info@crackteck.com',
                ],
            ];

            return view('e-commerce.order.invoice', $invoiceData);
        } catch (\Exception $e) {

            Log::error('Invoice View Error: '.$e->getMessage(), [
                'order_id' => $id,
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate invoice',
                'debug' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function downloadInvoice($id)
    {
        try {

            $order = Order::with(['customer', 'orderItems', 'orderPayments', 'billingAddress', 'shippingAddress'])
                ->findOrFail($id);

            $totals = $this->calculateOrderTotals($order);

            $invoiceData = [
                'order' => $order,
                'totals' => $totals,
                'invoice_number' => 'INV-'.$order->order_number,
                'invoice_date' => $order->created_at->format('d/m/Y'),
                'amount_in_words' => $this->convertNumberToWords($totals['grand_total']),
                'company' => [
                    'name' => 'CrackTeck Solutions Pvt. Ltd.',
                    'address' => 'Tech Park, Mumbai - 400001',
                    'gstin' => '27AABCC1234M1Z2',
                    'phone' => '+91 98765 43210',
                    'email' => 'info@crackteck.com',
                ],
            ];

            // Render the HTML view
            $html = view('e-commerce.order.invoice-pdf', $invoiceData)->render();

            // Create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // Set document information
            $pdf->SetCreator('CrackTeck');
            $pdf->SetAuthor('CrackTeck Solutions');
            $pdf->SetTitle('Invoice '.$order->order_number);
            $pdf->SetSubject('Invoice');

            // Remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // Set margins
            $pdf->SetMargins(15, 15, 15);

            // Add a page
            $pdf->AddPage();

            // Output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');

            // Close and output PDF
            $filename = 'invoice-'.$order->order_number.'.pdf';

            return response()->make($pdf->Output($filename, 'I'), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            ]);
        } catch (\Exception $e) {

            Log::error('Invoice PDF Error: '.$e->getMessage(), [
                'order_id' => $id,
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate invoice',
                'debug' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    private function convertNumberToWords($number)
    {
        $number = (int) $number;

        if ($number == 0) {
            return 'Zero Rupees Only';
        }

        $words = [
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety',
        ];

        $result = '';

        if ($number >= 10000000) { // Crores
            $crores = intval($number / 10000000);
            $result .= $this->convertHundreds($crores, $words).' Crore ';
            $number %= 10000000;
        }

        if ($number >= 100000) { // Lakhs
            $lakhs = intval($number / 100000);
            $result .= $this->convertHundreds($lakhs, $words).' Lakh ';
            $number %= 100000;
        }

        if ($number >= 1000) { // Thousands
            $thousands = intval($number / 1000);
            $result .= $this->convertHundreds($thousands, $words).' Thousand ';
            $number %= 1000;
        }

        if ($number >= 100) { // Hundreds
            $hundreds = intval($number / 100);
            $result .= $words[$hundreds].' Hundred ';
            $number %= 100;
        }

        if ($number >= 20) {
            $tens = intval($number / 10) * 10;
            $result .= $words[$tens].' ';
            $number %= 10;
        }

        if ($number > 0) {
            $result .= $words[$number].' ';
        }

        return trim($result).' Rupees Only';
    }

    private function convertHundreds($number, $words)
    {
        $result = '';

        if ($number >= 100) {
            $hundreds = intval($number / 100);
            $result .= $words[$hundreds].' Hundred ';
            $number %= 100;
        }

        if ($number >= 20) {
            $tens = intval($number / 10) * 10;
            $result .= $words[$tens].' ';
            $number %= 10;
        }

        if ($number > 0) {
            $result .= $words[$number].' ';
        }

        return trim($result);
    }

    private function updateProductQuantities($order)
    {
        foreach ($order->orderItems as $orderItem) {
            $ecommerceProduct = $orderItem->ecommerceProduct;

            if (! $ecommerceProduct || ! $ecommerceProduct->warehouseProduct) {
                Log::warning('Product not found for order item', [
                    'order_item_id' => $orderItem->id,
                    'ecommerce_product_id' => $orderItem->ecommerce_product_id,
                ]);

                continue;
            }

            $warehouseProduct = $ecommerceProduct->warehouseProduct;
            $orderedQuantity = $orderItem->quantity;
            $oldQuantity = $warehouseProduct->stock_quantity;
            $newQuantity = max(0, $oldQuantity - $orderedQuantity);

            // Update warehouse product quantity
            $warehouseProduct->update([
                'stock_quantity' => $newQuantity,
                'stock_status' => $newQuantity > 0 ? 'In Stock' : 'Out of Stock',
            ]);

            // Log the inventory update
            InventoryUpdateLog::create([
                'product_id' => $warehouseProduct->id,
                'ecommerce_order_id' => $order->id,
                'old_quantity' => $oldQuantity,
                'ordered_quantity' => $orderedQuantity,
                'new_quantity' => $newQuantity,
                'order_number' => $order->order_number,
                'update_type' => 'order_placed',
                'notes' => "Admin order created for user ID: {$order->user_id}",
            ]);

            Log::info('Product quantity updated (admin order)', [
                'product_id' => $warehouseProduct->id,
                'product_name' => $warehouseProduct->product_name,
                'old_quantity' => $oldQuantity,
                'ordered_quantity' => $orderedQuantity,
                'new_quantity' => $newQuantity,
                'order_number' => $order->order_number,
            ]);
        }
    }
}
