<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMan;
use App\Models\EcommerceOrder;
use App\Models\EcommerceOrderItem;
use App\Models\EcommerceProduct;
use App\Models\InventoryUpdateLog;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = EcommerceOrder::with(['user', 'orderItems.ecommerceProduct.warehouseProduct']);

        // Search functionality
        if ($request->has('search') && ! empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('total_amount', 'like', "%{$search}%")
                    ->orWhere('shipping_first_name', 'like', "%{$search}%")
                    ->orWhere('shipping_last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('shipping_phone', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

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

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get status counts for filter tabs
        $statusCounts = [
            'all' => EcommerceOrder::count(),
            'pending' => EcommerceOrder::where('status', 'pending')->count(),
            'confirmed' => EcommerceOrder::where('status', 'confirmed')->count(),
            'processing' => EcommerceOrder::where('status', 'processing')->count(),
            'shipped' => EcommerceOrder::where('status', 'shipped')->count(),
            'delivered' => EcommerceOrder::where('status', 'delivered')->count(),
            'cancelled' => EcommerceOrder::where('status', 'cancelled')->count(),
        ];

        return view('e-commerce.order.index', compact('orders', 'statusCounts'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        return view('e-commerce.order.create');
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address_line_1' => 'required|string|max:255',
            'shipping_address_line_2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_zipcode' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,visa,mastercard',
            'card_last_four' => 'nullable|string|size:4',
            'card_name' => 'nullable|string|max:255',
            'shipping_charges' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,confirmed,processing',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.product_name' => 'required|string',
            'items.*.product_sku' => 'required|string',
            'items.*.hsn_sac_code' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.tax_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.taxable_value' => 'required|numeric|min:0',
            'items.*.igst_amount' => 'required|numeric|min:0',
            'items.*.total_price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = collect($request->items)->sum('taxable_value');
            $taxAmount = collect($request->items)->sum('igst_amount');
            $shippingCharges = $request->shipping_charges ?? 0;
            $discountAmount = $request->discount_amount ?? 0;
            $totalAmount = $subtotal + $taxAmount + $shippingCharges - $discountAmount;

            // Generate order number
            $orderNumber = 'ORD-'.date('Ymd').'-'.str_pad(EcommerceOrder::count() + 1, 4, '0', STR_PAD_LEFT);

            // Create the order
            $order = EcommerceOrder::create([
                'user_id' => $request->user_id,
                'order_number' => $orderNumber,
                'order_source' => 'admin',
                'email' => $request->email,
                'shipping_first_name' => $request->shipping_first_name,
                'shipping_last_name' => $request->shipping_last_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address_line_1' => $request->shipping_address_line_1,
                'shipping_address_line_2' => $request->shipping_address_line_2,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_zipcode' => $request->shipping_zipcode,
                'shipping_country' => $request->shipping_country,
                'billing_same_as_shipping' => true, // Default for admin created orders
                'billing_first_name' => $request->shipping_first_name,
                'billing_last_name' => $request->shipping_last_name,
                'billing_address_line_1' => $request->shipping_address_line_1,
                'billing_address_line_2' => $request->shipping_address_line_2,
                'billing_city' => $request->shipping_city,
                'billing_state' => $request->shipping_state,
                'billing_zipcode' => $request->shipping_zipcode,
                'billing_country' => $request->shipping_country,
                'payment_method' => $request->payment_method,
                'card_name' => $request->card_name,
                'card_last_four' => $request->card_last_four,
                'subtotal' => $subtotal,
                'shipping_charges' => $shippingCharges,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'status' => $request->status,
                'confirmed_at' => $request->status === 'confirmed' ? now() : null,
            ]);

            // Create order items
            foreach ($request->items as $itemData) {
                EcommerceOrderItem::create([
                    'ecommerce_order_id' => $order->id,
                    'ecommerce_product_id' => $itemData['product_id'],
                    'product_name' => $itemData['product_name'],
                    'product_sku' => $itemData['product_sku'],
                    'hsn_sac_code' => $itemData['hsn_sac_code'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total_price' => $itemData['total_price'],
                    'tax_percentage' => $itemData['tax_percentage'] ?? 0,
                    'taxable_value' => $itemData['taxable_value'],
                    'igst_amount' => $itemData['igst_amount'],
                    'final_amount' => $itemData['total_price'],
                    'shipping_charges' => 0, // Individual item shipping charges
                    'free_shipping' => false,
                ]);
            }

            // Update product quantities in warehouse and e-commerce
            $this->updateProductQuantities($order);

            DB::commit();

            return redirect()->route('order.view', $order->id)
                ->with('success', 'E-commerce order created successfully!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create order: '.$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit($id)
    {
        $order = EcommerceOrder::with(['user', 'orderItems.ecommerceProduct.warehouseProduct'])
            ->findOrFail($id);

        return view('e-commerce.order.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, $id)
    {
        $order = EcommerceOrder::findOrFail($id);

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
                'status', 'shipping_first_name', 'shipping_last_name', 'shipping_phone',
                'shipping_address_line_1', 'shipping_address_line_2', 'shipping_city',
                'shipping_state', 'shipping_zipcode', 'notes',
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

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        try {
            $order = EcommerceOrder::findOrFail($id);

            // Check if order can be deleted (business logic)
            if (in_array($order->status, ['shipped', 'delivered'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete orders that have been shipped or delivered.',
                ], 400);
            }

            // Delete order items first
            $order->orderItems()->delete();

            // Delete the order
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully!',
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting order: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the order: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove multiple orders from storage.
     */
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
                    $order = EcommerceOrder::find($orderId);

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

    /**
     * Search products for Ajax autocomplete
     */
    public function searchProducts(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = EcommerceProduct::with(['warehouseProduct.brand'])
            ->whereHas('warehouseProduct', function ($q) use ($query) {
                $q->where('product_name', 'LIKE', "%{$query}%")
                    ->orWhere('sku', 'LIKE', "%{$query}%")
                    ->where('status', 'active');
            })
            ->where('ecommerce_status', 'active')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->warehouseProduct->product_name,
                    'sku' => $product->warehouseProduct->sku,
                    'brand' => $product->warehouseProduct->brand->brand_title ?? 'N/A',
                    'price' => $product->warehouseProduct->selling_price,
                    'display' => $product->warehouseProduct->product_name.' ('.$product->warehouseProduct->sku.')',
                ];
            });

        return response()->json($products);
    }

    /**
     * Search users for Ajax autocomplete
     */
    public function searchUsers(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $users = User::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%");
        })
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'display' => $user->name.' ('.$user->email.')',
                ];
            });

        return response()->json($users);
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = EcommerceOrder::with(['user', 'orderItems.ecommerceProduct.warehouseProduct'])
            ->findOrFail($id);
        $deliveryMen = DeliveryMan::where('status', 'Active')->get();
        // Calculate totals
        $totals = $this->calculateOrderTotals($order);

        return view('e-commerce.order.view', compact('order', 'totals', 'deliveryMen'));
    }

    /**
     * Calculate order totals.
     */
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

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $order = EcommerceOrder::findOrFail($id);
            $oldStatus = $order->status;
            $newStatus = $request->status;

            // Update status with timestamps
            $order->status = $newStatus;

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
            Log::error('Error updating order status: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status',
            ], 500);
        }
    }

    /**
     * Assign delivery man to an order
     */
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
            $order = EcommerceOrder::findOrFail($id);
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

    /**
     * Generate and download PDF invoice for an order
     */
    public function generateInvoice($id)
    {
        try {
            // Fetch order with all related data
            $order = EcommerceOrder::with(['user', 'orderItems.ecommerceProduct.warehouseProduct'])
                ->findOrFail($id);

            // Calculate totals
            $totals = $this->calculateOrderTotals($order);

            // Prepare data for the invoice template
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
            $filename = 'invoice-'.$order->order_number.'.pdf';

            // Return PDF download response
            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Error generating invoice: '.$e->getMessage());

            return redirect()->back()->with('error', 'Failed to generate invoice. Please try again.');
        }
    }

    /**
     * Convert number to words (Indian format)
     */
    private function convertNumberToWords($number)
    {
        $number = (int) $number;

        if ($number == 0) {
            return 'Zero Rupees Only';
        }

        $words = [
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
            6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
            11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty',
            30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
            80 => 'Eighty', 90 => 'Ninety',
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

    /**
     * Helper method to convert hundreds
     */
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

    /**
     * Update product quantities in warehouse and e-commerce after order placement.
     */
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
