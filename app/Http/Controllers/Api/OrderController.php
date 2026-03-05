<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\EcommerceProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\ParentCategory;
use App\Models\Product;
use App\Models\ReturnOrder;
use App\Models\StockRequest;
use App\Models\StockRequestItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected function getRoleId($roleId)
    {
        return [
            1 => 'engineer',
            2 => 'delivery_man',
            3 => 'sales_person',
            4 => 'customers',
        ][$roleId] ?? null;
    }

    // Sales Person and Customer
    public function listProducts(Request $request)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:1,3,4',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid Role Id Provided.'], 400);
        }

        if ($staffRole == 'customers' || $staffRole == 'sales_person' || $staffRole == 'engineer') {

            $products = EcommerceProduct::query();
            if ($request->filled('search')) {
                $products = $products->whereHas('warehouseProduct', function ($query) use ($request) {
                    $query->where('product_name', 'like', "%{$request->search}%");
                });
            }
            if ($request->filled('category_name')) {
                $products = $products->whereHas('warehouseProduct.parentCategorie', function ($query) use ($request) {
                    $query->where('slug', $request->category_name);
                });
            }
            $products = $products->with('warehouseProduct.parentCategorie')->get();

            return response()->json(['products' => $products], 200);
        }
    }

    public function listProductCategories(Request $request)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:3,4',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers' || $staffRole == 'sales_person') {
            $categories = ParentCategory::where('status', 'active')
                ->where('status_ecommerce', 'active')
                ->get();

            return response()->json(['categories' => $categories], 200);
        }
    }

    public function product(Request $request, $product_id)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:1,3,4',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers' || $staffRole == 'sales_person' || $staffRole == 'engineer') {
            $product = EcommerceProduct::with('warehouseProduct.parentCategorie')->find($product_id);

            if (! $product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            return response()->json(['product' => $product], 200);
        }
    }

    // Buy Product
    public function buyProduct(Request $request, $product_id)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:4',
            'quantity' => 'required|integer|min:1',
            'user_id' => 'required',
            'shipping_address_id' => 'required',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $product = EcommerceProduct::with('warehouseProduct')->find($product_id);

            if (! $product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            // Store Order in Order Table
            $customer = Customer::with('addressDetails')->where('id', $request->user_id)->first();
            if (! $customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }

            $quantity = $request->quantity;
            $price = $product->warehouseProduct->final_price;
            $total = $quantity * $price;

            $order = Order::create([
                'customer_id' => $request->user_id,
                'order_number' => 'ORD-'.date('YmdHis').'-'.$request->user_id,
                'total_items' => $quantity,
                'subtotal' => $product->warehouseProduct->final_price,
                'discount_amount' => 0,
                'coupon_code' => null,
                'tax_amount' => $product->warehouseProduct->final_price * $product->warehouseProduct->tax / 100,
                'shipping_charges' => $product->shipping_charges ?? 0,
                'packaging_charges' => $product->packaging_charges ?? 0,
                'total_amount' => $total + $product->shipping_charges,
                'billing_address_id' => null,
                'shipping_address_id' => $request->shipping_address_id,
                'billing_same_as_shipping' => true,
                'status' => 'pending',
                'payment_status' => 'pending',
                'expected_delivery_date' => null,
                'customer_notes' => null,
                'admin_notes' => null,
                'source_platform' => 'mobile_app',
                'tracking_number' => null,
                'tracking_url' => null,
                'is_returnable' => $product->is_returnable ?? false,
                'return_days' => $product->is_returnable ? 7 : 0,
                'return_status' => null,
                'refund_amount' => 0,
                'refund_status' => null,
                'is_priority' => false,
                'requires_signature' => false,
                'is_gift' => false,
                'assigned_person_type' => 'delivery_man',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_serial_id' => null,
                'product_name' => $product->warehouseProduct->product_name,
                'product_sku' => $product->warehouseProduct->sku,
                'hsn_code' => $product->warehouseProduct->hsn_code,
                'quantity' => $quantity,
                'unit_price' => $price,
                'discount_per_unit' => 0,
                'tax_per_unit' => 0,
                'line_total' => $total,
                'variant_details' => null,
                'custom_options' => null,
                'item_status' => '0',
            ]);

            OrderPayment::create([
                'order_id' => $order->id,
                'payment_id' => 'PMT-'.strtoupper(uniqid()),
                'transaction_id' => 'TXN-'.strtoupper(uniqid()),
                'payment_method' => 'online',
                'payment_gateway' => 'phonepe',
                'amount' => $total,
                'currency' => 'INR',
                'status' => 'Completed',
                'processed_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $total + $product->shipping_charges,
                'message' => 'Order placed successfully!',
            ], 200);
        }
    }

    public function listOrders(Request $request)
    {
        $roleValidated = Validator::make($request->all(), ([
            'user_id' => 'required',
            'role_id' => 'required|in:4',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $orders = Order::with('orderItems', 'orderItems.product')->where('customer_id', $request->user_id)->get();

            return response()->json(['orders' => $orders], 200);
        }
    }

    // Engineer

    public function allListProducts(Request $request)
    {

        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:1',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'engineer') {
            if ($request->filled('search')) {
                $products = Product::select('id', 'product_name', 'final_price')
                    ->where('product_name', 'like', "%{$request->search}%")->get();
            } else {
                $products = Product::select('id', 'product_name', 'final_price')->get();
            }

            return response()->json(['products' => $products], 200);
        }
    }

    public function allProduct(Request $request, $product_id)
    {

        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:1',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'engineer') {
            $product = Product::select('id', 'product_name', 'hsn_code', 'sku', 'brand_id', 'model_no', 'serial_no', 'parent_category_id', 'sub_category_id', 'short_description', 'full_description', 'technical_specification', 'brand_warranty', 'cost_price', 'selling_price', 'discount_price', 'tax', 'final_price')->find($product_id);

            if (! $product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            return response()->json(['product' => $product], 200);
        }
    }

    
    public function requestProduct(Request $request)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:1',
            'user_id' => 'required|exists:engineers,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'engineer') {
            $stockRequest = StockRequest::create([
                'requested_by' => $request->user_id,
                'request_date' => date('Y-m-d'),
                'reason' => 'Requested by engineer',
                'urgency_level' => 'High',
                'approval_status' => 'Pending',
                'final_status' => 'Pending',
            ]);

            foreach ($request->products as $product) {
                StockRequestItem::create([
                    'stock_request_id' => $stockRequest->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Product request submitted successfully!', 'data' => $stockRequest]);
        }
    }

    public function order(Request $request, $order_id)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:4',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $order = Order::with('orderItems', 'orderItems.product')->where('id', $order_id)->first();

            if (! $order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            return response()->json(['order' => $order], 200);
        }
    }

    // Cancel Order API
    public function cancelOrder(Request $request, $order_id)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'customer_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $order = Order::where('id', $order_id)
            ->where('customer_id', $request->customer_id)
            ->first();

        if (! $order) {
            return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
        }

        // Check if order can be cancelled
        $cancellableStatuses = ['pending', 'admin_approved', 'assigned_delivery_man', 'order_accepted', 'product_taken'];

        if (! in_array($order->status, $cancellableStatuses)) {
            return response()->json(['success' => false, 'message' => 'This order cannot be cancelled. Current status: '.$order->status], 400);
        }

        // Update order status to cancelled
        $order->status = 'cancelled';
        $order->cancelled_at = now();
        $order->customer_notes = $request->customer_notes ?? null;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order cancelled successfully.',
            'data' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
            ],
        ]);
    }

    // Return Order API
    public function returnOrder(Request $request, $order_id)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'customer_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $order = Order::where('id', $order_id)
            ->where('customer_id', $request->customer_id)
            ->first();

        if (! $order) {
            return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
        }

        // Check if order status is delivered
        if ($order->status !== 'delivered') {
            return response()->json(['success' => false, 'message' => 'Only delivered orders can be returned.'], 400);
        }

        // Check if order is returnable
        if (! $order->is_returnable) {
            return response()->json(['success' => false, 'message' => 'This order is not returnable.'], 400);
        }

        // Check if return days have passed
        if ($order->delivered_at) {
            $returnDeadline = $order->delivered_at->addDays($order->return_days ?? 30);
            if (now()->greaterThan($returnDeadline)) {
                return response()->json(['success' => false, 'message' => 'Return period has expired. You can no longer return this order.'], 400);
            }
        }

        // Check if a return order already exists
        $existingReturn = ReturnOrder::where('order_number', $order->order_number)
            ->where('customer_id', $request->customer_id)
            ->first();

        if ($existingReturn) {
            return response()->json(['success' => false, 'message' => 'A return request already exists for this order.'], 400);
        }

        try {
            // Create return order
            $returnOrder = ReturnOrder::create([
                'return_order_number' => ReturnOrder::generateReturnOrderNumber(),
                'order_number' => $order->order_number,
                'customer_id' => $order->customer_id,
                'return_reason' => $request->customer_notes ?? null,
                'customer_notes' => $request->customer_notes ?? null,
                'refund_amount' => $order->total_amount,
                'refund_status' => 'pending',
                'status' => 'pending',
            ]);

            // Update order return status
            $order->return_status = 'pending';
            $order->customer_notes = $request->customer_notes ?? null;
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Return request initiated successfully.',
                'data' => [
                    'return_order_id' => $returnOrder->id,
                    'return_order_number' => $returnOrder->return_order_number,
                    'order_number' => $returnOrder->order_number,
                    'status' => $returnOrder->status,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to initiate return. Please try again.'], 500);
        }
    }
}
