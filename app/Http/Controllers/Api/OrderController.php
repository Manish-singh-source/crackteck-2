<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Engineer;
use App\Models\OrderItem;
use App\Models\DeliveryMan;
use App\Models\SalesPerson;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use App\Models\EcommerceOrder;
use App\Models\EcommerceProduct;
use App\Models\StockRequestItem;
use App\Models\EcommerceOrderItem;
use App\Http\Controllers\Controller;
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
            'role_id' => 'required|in:3,4',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid Role Id Provided.'], 400);
        }

        if ($staffRole == 'customers' || $staffRole == 'sales_person') {

            $products = EcommerceProduct::query();
            if ($request->filled('search')) {
                $products = $products->whereHas('warehouseProduct', function ($query) use ($request) {
                    $query->where('product_name', 'like', "%{$request->search}%");
                });
            }
            $products = $products->with('warehouseProduct')->get();

            return response()->json(['products' => $products], 200);
        }
    }

    public function product(Request $request, $product_id)
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
            $product = EcommerceProduct::find($product_id);

            if (! $product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            return response()->json(['product' => $product], 200);
        }
    }

    // Buy Product
    // role_id, product_id, quantity
    public function buyProduct(Request $request, $product_id)
    {
        // return response()->json(['message' => $request->all()], 501);
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:4',
            'quantity' => 'required|integer|min:1',
            'customer_id' => 'required',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $product = EcommerceProduct::find($product_id);

            if (! $product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            // Store Order in Order Table
            $customer = Customer::with('address')->where('id', $request->customer_id)->first();
            if (! $customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }

            $quantity = $request->quantity;
            $price = $product->selling_price;
            $total = $quantity * $price;

            $order = Order::create([
                'user_id' => 1,
                'customer_id' => $request->customer_id,
                'order_number' => 'ORD-' . date('YmdHis') . '-' . $request->customer_id,
                'order_source' => 'buy_now',
                'email' => $customer->email,

                'shipping_first_name' => $customer->first_name,
                'shipping_last_name' => $customer->last_name,
                'shipping_country' => $customer->address->country,
                'shipping_state' => $customer->address->state,
                'shipping_city' => $customer->address->city,
                'shipping_zipcode' => $customer->address->pincode,
                'shipping_address_line_1' => $customer->address->address,
                'shipping_address_line_2' => $customer->address->address2,
                'shipping_phone' => $customer->phone,
                'billing_same_as_shipping' => true,
                'billing_first_name' => $customer->first_name,
                'billing_last_name' => $customer->last_name,
                'billing_country' => $customer->country,
                'billing_state' => $customer->address->state,
                'billing_city' => $customer->address->city,
                'billing_zipcode' => $customer->address->pincode,
                'billing_address_line_1' => $customer->address->address,
                'billing_address_line_2' => $customer->address->address2,
                'billing_phone' => $customer->phone,
                'payment_method' => 'cod',
                'card_name' => null,
                'card_last_four' => null,
                'card_expiry' => null,
                'subtotal' => $total,
                'shipping_charges' => 0,
                'discount_amount' => 0,
                'coupon_code' => null,
                'total_amount' => $total,
                'status' => 'pending',
            ]);

            OrderItem::create([
                'ecommerce_order_id' => $order->id,
                'ecommerce_product_id' => $product->id,
                'product_name' => $product->product_name,
                'product_sku' => $product->sku,
                'product_image' => $product->main_product_image,
                'unit_price' => $product->selling_price,
                'quantity' => $quantity,
                'total_price' => $total,
                'hsn_sac_code' => $product->hsn_code,
                'tax_percentage' => $product->tax ?? 18,
                'taxable_value' => $total,  // Total price before tax
                'igst_amount' => 0,  // IGST amount
                'final_amount' => $total,  // Total price after tax
                'shipping_charges' => 0,  // Individual item shipping charges
                'free_shipping' => true,
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $total,
                'message' => 'Order placed successfully!',
            ], 200);
        }
    }

    public function listOrders(Request $request)
    {
        $roleValidated = Validator::make($request->all(), ([
            'customer_id' => 'required',
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
            $orders = Order::with('orderItems')->where('customer_id', $request->customer_id)->get();

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

    // Product requested by engineer
    // in this function engineer can request multiple products at once
    // and store in stock_requests table

    // but request submit by engineer so in by requested_by field store engineer_id
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
            $order = Order::with('orderItems')->where('id', $order_id)->first();

            if (! $order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            return response()->json(['order' => $order], 200);
        }
    }
}
