<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\EcommerceOrder;
use App\Models\EcommerceOrderItem;
use App\Models\EcommerceProduct;
use App\Models\InventoryUpdateLog;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\Staff;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'orderItems.ecommerceProduct.warehouseProduct']);

        // Status filter
        if ($request->has('order_status') && ! empty($request->order_status)) {
            $query->where('order_status', $request->order_status);
        }

        // Date range filter
        if ($request->has('date_from') && ! empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && ! empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Paginate orders
        $orders = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        // Efficiently get status counts
        $statusCounts = Order::selectRaw('order_status, COUNT(*) as count')
            ->groupBy('order_status')
            ->pluck('count', 'order_status')
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
            $orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);

            // Create the order
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_number' => $orderNumber,
                'source_platform' => 'admin_panel',
                'total_items' => count($request->items),
                'email' => $request->email,
                'shipping_first_name' => $request->shipping_first_name,
                'shipping_last_name' => $request->shipping_last_name,
                'shipping_phone' => $request->shipping_phone,
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
                'order_status' => $request->order_status,
                'assigned_person_type' => $request->assigned_person_type,
                'assigned_person_id' => $request->assigned_person_id,
                'confirmed_at' => $request->order_status === 'confirmed' ? now() : null,
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
                'payment_id' => 'PMT-' . strtoupper(uniqid()),
                'transaction_id' => 'TXN-' . strtoupper(uniqid()),
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
            return redirect()->back()->withInput()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $order = Order::with(['customer', 'orderItems.product.ecommerceProduct'])
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
            Log::error('Error updating order: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while updating the order: ' . $e->getMessage());
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
            Log::error('Error deleting order: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while deleting the order: ' . $e->getMessage());
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
                    $errors[] = "Failed to delete order ID {$orderId}: " . $e->getMessage();
                    Log::error("Error deleting order {$orderId}: " . $e->getMessage());
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
            Log::error('Error in bulk delete: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting orders: ' . $e->getMessage(),
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
                    'price' => $product->warehouseProduct->selling_price,
                    'display' => $product->warehouseProduct->product_name . ' (' . $product->warehouseProduct->sku . ')',
                ];
            });

        return response()->json($products);
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

    public function show($id)
    {
        $order = Order::with(['customer', 'orderItems.product.ecommerceProduct', 'orderPayments'])
            ->findOrFail($id);
        $deliveryMen = Staff::where('staff_role', 'delivery_man')->where('status', 'active')->get();
        $engineers = Staff::where('staff_role', 'engineer')->where('status', 'active')->get();
        $assignedPerson = Staff::find($order->assigned_person_id);
        // dd($assignedPerson);
        // Calculate totals
        $totals = $this->calculateOrderTotals($order);

        return view('e-commerce.order.view', compact('order', 'totals', 'deliveryMen', 'engineers', 'assignedPerson'));
    }

    public function assignPerson(Request $request, $id)
    {
        $request->validate([
            'assigned_person_type' => 'required|in:engineer,delivery_man',
            'delivery_man_id' => 'nullable|exists:staff,id',
            'engineer_id' => 'nullable|exists:staff,id',
        ]);

        try {
            $order = Order::findOrFail($id);
            $order->assigned_person_type = $request->assigned_person_type;
            if ($request->assigned_person_type == 'engineer') {
                $order->assigned_person_id = $request->engineer_id;
            } else {
                $order->assigned_person_id = $request->delivery_man_id;
            }
            $order->save();

            return redirect()->back()->with('success', 'Person assigned successfully');
        } catch (\Exception $e) {
            Log::error('Error assigning person: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to assign person');
        }
    }

    private function calculateOrderTotals($order)
    {
        $subtotal = $order->orderItems->sum('total_price');
        $taxAmount = $order->orderItems->sum('igst_amount');
        $shippingCharges = $order->shipping_charges;
        $discountAmount = $order->discount_amount;
        $grandTotal = $order->total_amount;

        return [
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'shipping_charges' => $shippingCharges,
            'discount_amount' => $discountAmount,
            'grand_total' => $grandTotal,
            'rounded_total' => round($grandTotal),
        ];
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'order_status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $order = Order::findOrFail($id);
            $oldStatus = $order->order_status;
            $newStatus = $request->order_status;

            // Update status with timestamps
            $order->order_status = $newStatus;

            if ($newStatus === 'confirmed' && $oldStatus !== 'confirmed') {
                $order->confirmed_at = now();
            } elseif ($newStatus === 'shipped' && $oldStatus !== 'shipped') {
                $order->shipped_at = now();
            } elseif ($newStatus === 'delivered' && $oldStatus !== 'delivered') {
                $order->delivered_at = now();
            }

            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status',
            ], 500);
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
            Log::error('Error assigning delivery man: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to assign delivery man',
            ], 500);
        }
    }

    public function generateInvoice($id)
    {
        try {
            // Fetch order with all related data
            $order = Order::with(['user', 'orderItems.product.warehouseProduct'])
                ->findOrFail($id);

            // Calculate totals
            $totals = $this->calculateOrderTotals($order);

            // Prepare data for the invoice template
            $invoiceData = [
                'order' => $order,
                'totals' => $totals,
                'invoice_number' => 'INV-' . $order->order_number,
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

            // Generate PDF using the existing invoice view
            $pdf = Pdf::loadView('e-commerce.ecommerce-orders.invoice', $invoiceData);

            // Set paper size and orientation
            $pdf->setPaper('A4', 'portrait');

            // Set options for better rendering
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'defaultFont' => 'Arial',
            ]);

            // Generate filename
            $filename = 'invoice-' . $order->order_number . '.pdf';

            // Return PDF download response
            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('Error generating invoice: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to generate invoice. Please try again.');
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
            $result .= $this->convertHundreds($crores, $words) . ' Crore ';
            $number %= 10000000;
        }

        if ($number >= 100000) { // Lakhs
            $lakhs = intval($number / 100000);
            $result .= $this->convertHundreds($lakhs, $words) . ' Lakh ';
            $number %= 100000;
        }

        if ($number >= 1000) { // Thousands
            $thousands = intval($number / 1000);
            $result .= $this->convertHundreds($thousands, $words) . ' Thousand ';
            $number %= 1000;
        }

        if ($number >= 100) { // Hundreds
            $hundreds = intval($number / 100);
            $result .= $words[$hundreds] . ' Hundred ';
            $number %= 100;
        }

        if ($number >= 20) {
            $tens = intval($number / 10) * 10;
            $result .= $words[$tens] . ' ';
            $number %= 10;
        }

        if ($number > 0) {
            $result .= $words[$number] . ' ';
        }

        return trim($result) . ' Rupees Only';
    }

    private function convertHundreds($number, $words)
    {
        $result = '';

        if ($number >= 100) {
            $hundreds = intval($number / 100);
            $result .= $words[$hundreds] . ' Hundred ';
            $number %= 100;
        }

        if ($number >= 20) {
            $tens = intval($number / 10) * 10;
            $result .= $words[$tens] . ' ';
            $number %= 10;
        }

        if ($number > 0) {
            $result .= $words[$number] . ' ';
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
