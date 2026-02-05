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
use App\Models\ParentCategory;
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
            $product = EcommerceProduct::with('warehouseProduct')->find($product_id);

            if (! $product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            // Store Order in Order Table
            $customer = Customer::with('addressDetails')->where('id', $request->customer_id)->first();
            if (! $customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }

            $quantity = $request->quantity;
            $price = $product->warehouseProduct->final_price;
            $total = $quantity * $price;

            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_number' => 'ORD-' . date('YmdHis') . '-' . $request->customer_id,
                'total_items' => $quantity,
                'subtotal' => $product->warehouseProduct->final_price,
                'discount_amount' => 0,
                'coupon_code' => null,
                'tax_amount' => $product->warehouseProduct->final_price * $product->warehouseProduct->tax / 100,
                'shipping_charges' => $product->shipping_charges ?? 0,
                'packaging_charges' => $product->packaging_charges ?? 0,
                'total_amount' => $total,
                'billing_address_id' => null,
                'shipping_address_id' => null,
                'billing_same_as_shipping' => true,
                'order_status' => "0",
                'payment_status' => "0",
                'delivery_status' => "0",
                'expected_delivery_date' => null,
                'customer_notes' => null,
                'admin_notes' => null,
                'source_platform' => '0',
                'tracking_number' => null,
                'tracking_url' => null,
                'is_returnable' => false,
                'return_days' => 0,
                'return_status' => null,
                'refund_amount' => 0,
                'refund_status' => null,
                'is_priority' => false,
                'requires_signature' => false,
                'is_gift' => false,
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
            $orders = Order::with('orderItems','orderItems.product')->where('customer_id', $request->customer_id)->get();

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
            $order = Order::with('orderItems','orderItems.product')->where('id', $order_id)->first();

            if (! $order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            return response()->json(['order' => $order], 200);
        }
    }
}
