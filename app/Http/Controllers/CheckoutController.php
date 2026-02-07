<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CustomerAddressDetail;
use App\Models\EcommerceOrder;
use App\Models\EcommerceOrderItem;
use App\Models\EcommerceProduct;
use App\Models\InventoryUpdateLog;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to proceed with checkout.');
        }

        $user = Auth::user();

        // Determine checkout source and get items
        $checkoutData = $this->getCheckoutData($request);

        if (! $checkoutData['items'] || $checkoutData['items']->isEmpty()) {
            return redirect()->route('shop-cart')->with('error', 'No items found for checkout.');
        }

        // Store navigation source in session for coupon validation
        $source = $request->get('source', 'direct');
        Session::put('checkout_navigation_source', $source);

        // Get user's saved addresses
        $userAddresses = CustomerAddressDetail::with('customer')
            ->where('customer_id', $user->id)
            ->get();
        // dd($userAddresses);

        // Calculate totals
        $totals = $this->calculateTotals($checkoutData['items']);

        return view('frontend.checkout', compact(
            'checkoutData',
            'userAddresses',
            'totals',
            'user'
        ));
    }

    /**
     * Get checkout data based on source (cart or buy now).
     */
    private function getCheckoutData(Request $request)
    {
        $source = $request->get('source', 'cart');
        $userId = Auth::id();

        if ($source === 'buy_now') {
            // Single product checkout
            $productId = $request->get('product_id');
            $quantity = $request->get('quantity', 1);

            if (! $productId) {
                return ['source' => 'buy_now', 'items' => collect()];
            }

            $product = EcommerceProduct::with('warehouseProduct')
                ->where('id', $productId)
                ->where('status', 'active')
                ->first();

            if (! $product) {
                return ['source' => 'buy_now', 'items' => collect()];
            }

            // Create a cart-like structure for consistency
            $item = (object) [
                'id' => 'buy_now_' . $productId,
                'ecommerce_product_id' => $product->id,
                'quantity' => $quantity,
                'ecommerceProduct' => $product,
            ];

            return [
                'source' => 'buy_now',
                'items' => collect([$item]),
                'product_id' => $productId,
                'quantity' => $quantity,
            ];
        } else {
            // Cart checkout
            $cartItems = Cart::with([
                'ecommerceProduct.warehouseProduct.brand',
                'ecommerceProduct.warehouseProduct.parentCategorie',
                'ecommerceProduct.warehouseProduct.subCategorie',
            ])
                ->where('customer_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            return [
                'source' => 'cart',
                'items' => $cartItems,
            ];
        }
    }

    /**
     * Calculate checkout totals.
     */
    private function calculateTotals($items)
    {
        $subtotal = 0;
        $shippingCharges = 0;
        $freeShippingItems = 0;
        $discountAmount = 0;
        $appliedCoupon = null;

        foreach ($items as $item) {
            $product = $item->ecommerceProduct;
            $warehouseProduct = $product->warehouseProduct;

            // Use final_price for consistency with the view
            $itemPrice = $warehouseProduct->final_price ?? $warehouseProduct->selling_price ?? 0;
            $itemTotal = $itemPrice * $item->quantity;
            $subtotal += $itemTotal;

            // Calculate shipping for this item
            $itemShipping = $product->shipping_charges ?? 0;
            if ($itemShipping == 0) {
                $freeShippingItems++;
            } else {
                $shippingCharges += $itemShipping;
            }
        }

        // Check for applied coupon in session
        $appliedCouponData = Session::get('applied_coupon');
        if ($appliedCouponData) {
            $discountAmount = $appliedCouponData['discount_amount'] ?? 0;
            $appliedCoupon = $appliedCouponData;
        }

        $finalTotal = max(0, $subtotal + $shippingCharges - $discountAmount);

        return [
            'subtotal' => $subtotal,
            'shipping_charges' => $shippingCharges,
            'discount_amount' => $discountAmount,
            'total' => $finalTotal,
            'free_shipping_items' => $freeShippingItems,
            'has_free_shipping' => $shippingCharges == 0,
            'applied_coupon' => $appliedCoupon,
        ];
    }

    /**
     * Get user addresses via AJAX.
     */
    public function getUserAddresses(): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required',
            ], 401);
        }

        $addresses = CustomerAddressDetail::getUserAddresses(Auth::id());

        return response()->json([
            'success' => true,
            'addresses' => $addresses->map(function ($address) {
                return [
                    'id' => $address->id,
                    'label' => $address->label ?? 'Address ' . $address->id,
                    'full_name' => $address->full_name,
                    'formatted_address' => $address->formatted_address,
                    'first_name' => $address->first_name,
                    'last_name' => $address->last_name,
                    'country' => $address->country,
                    'state' => $address->state,
                    'city' => $address->city,
                    'zipcode' => $address->zipcode,
                    'address_line_1' => $address->address_line_1,
                    'address_line_2' => $address->address_line_2,
                    'is_default' => $address->is_default,
                ];
            }),
        ]);
    }

    /**
     * Process order placement.
     */
    public function store(Request $request)
    {
        if (! Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required',
            ], 401);
        }

        // Validate request
        $validated = $request->validate([

            'source' => 'required|in:cart,buy_now',
            'email' => 'required|email',

            // Shipping address
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_country' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_zipcode' => 'required|string|max:20',
            'shipping_address_line_1' => 'required|string',
            'shipping_address_line_2' => 'nullable|string',
            'shipping_phone' => 'required|string|max:20',

            'previous_address' => 'required|integer',


            // Billing address
            'billing_same_as_shipping' => 'boolean',
            'billing_first_name' => 'nullable|string|max:255',
            'billing_last_name' => 'nullable|string|max:255',
            'billing_country' => 'nullable|string|max:255',
            'billing_state' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:255',
            'billing_zipcode' => 'nullable|string|max:20',
            'billing_address_line_1' => 'nullable|string',
            'billing_address_line_2' => 'nullable|string',
            'billing_phone' => 'nullable|string|max:20',

            // Payment
            'payment_method' => 'required|in:mastercard,cod',
            'card_name' => 'nullable|string|max:255',
            'card_number' => 'nullable|string|max:19',
            'card_expiry' => 'nullable|string|max:7',
            'card_cvv' => 'nullable|string|max:4',

            // Buy now specific
            'product_id' => 'nullable|exists:ecommerce_products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Get checkout items
            $checkoutData = $this->getCheckoutData($request);

            if (! $checkoutData['items'] || $checkoutData['items']->isEmpty()) {
                throw new \Exception('No items found for checkout.');
            }

            // Calculate totals
            $totals = $this->calculateTotals($checkoutData['items']);

            // Create order
            $order = $this->createOrder($validated, $totals, $checkoutData['source'], $checkoutData);

            // Create order items
            $this->createOrderItems($order, $checkoutData);

            // Update product quantities in warehouse and e-commerce
            $this->updateProductQuantities($order);

            // Record coupon usage if coupon was applied
            if ($totals['applied_coupon']) {
                $couponController = new CouponApplicationController;
                $couponController->recordCouponUsage(
                    $totals['applied_coupon']['id'],
                    Auth::id(),
                    $order->id,
                    $totals['discount_amount']
                );

                // Clear applied coupon from session
                Session::forget('applied_coupon');
            }

            // Clear cart if checkout from cart
            if ($checkoutData['source'] === 'cart') {
                Cart::where('customer_id', Auth::id())->delete();
            }

            // Clear checkout navigation source from session
            Session::forget('checkout_navigation_source');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_number' => $order->order_number,
                'redirect' => route('order-details', ['orderNumber' => $order->order_number]),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout error: ' . $e->getMessage(), [
                'customer_id' => Auth::id(),
                'request_data' => $request->all(),
            ]);

            // dd($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => 'An error occurred while processing your order. Please try again.',
            ], 500);
        }
    }

    /**
     * Create order record.
     */
    private function createOrder($validated, $totals, $source, $checkoutData)
    {
        // Get first item for tax calculation
        $firstItem = $checkoutData['items']->first();
        $warehouseProduct = $firstItem->ecommerceProduct->warehouseProduct ?? null;
        $taxAmount = 0;

        if ($warehouseProduct) {
            $itemPrice = $warehouseProduct->final_price ?? $warehouseProduct->selling_price ?? 0;
            $taxAmount = $itemPrice * ($warehouseProduct->tax ?? 0) / 100;
        }

        // Calculate total items
        $totalItems = $checkoutData['items']->sum('quantity');

        $orderData = [
            'customer_id' => Auth::id(),
            'order_source' => $source,
            'email' => $validated['email'],

            // Totals
            'total_items' => $totalItems,
            'subtotal' => $totals['subtotal'],
            'tax_amount' => $taxAmount * $totalItems,
            'discount_amount' => $totals['discount_amount'],
            'coupon_code' => $totals['applied_coupon']['code'] ?? null,
            'coupon_id' => $totals['applied_coupon']['id'] ?? null,
            'shipping_charges' => $totals['shipping_charges'],
            'packaging_charges' => 0,
            'total_amount' => $totals['total'],

            // Shipping address
            'shipping_address_id' => $validated['previous_address'],

            // Billing address
            'billing_same_as_shipping' => $validated['billing_same_as_shipping'],

            // Payment
            'payment_method' => $validated['payment_method'],

            // Status
            'status' => 'pending',
            'payment_status' => 'pending',

            // Additional fields
            'expected_delivery_date' => null,
            'customer_notes' => null,
            'admin_notes' => null,
            'source_platform' => 'website',
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
            'assigned_person_type' => 'delivery_man',
            'assigned_person_id' => null,
            'billing_address_id' => null,
        ];

        // Add billing address if different from shipping
        if (! ($validated['billing_same_as_shipping'] ?? true)) {
            $orderData = array_merge($orderData, [
                'billing_first_name' => $validated['billing_first_name'],
                'billing_last_name' => $validated['billing_last_name'],
                'billing_country' => $validated['billing_country'],
                'billing_state' => $validated['billing_state'],
                'billing_city' => $validated['billing_city'],
                'billing_zipcode' => $validated['billing_zipcode'],
                'billing_address_line_1' => $validated['billing_address_line_1'],
                'billing_address_line_2' => $validated['billing_address_line_2'],
                'billing_phone' => $validated['billing_phone'],
            ]);
        } else {
            $orderData = array_merge($orderData, [
                'billing_first_name' => $validated['shipping_first_name'],
                'billing_last_name' => $validated['shipping_last_name'],
                'billing_country' => $validated['shipping_country'],
                'billing_state' => $validated['shipping_state'],
                'billing_city' => $validated['shipping_city'],
                'billing_zipcode' => $validated['shipping_zipcode'],
                'billing_address_line_1' => $validated['shipping_address_line_1'],
                'billing_address_line_2' => $validated['shipping_address_line_2'],
                'billing_phone' => $validated['shipping_phone'],
            ]);
        }

        // Add payment details for credit card
        if ($validated['payment_method'] === 'mastercard') {
            $orderData = array_merge($orderData, [
                'card_name' => $validated['card_name'],
                'card_last_four' => substr($validated['card_number'] ?? '', -4),
                'card_expiry' => $validated['card_expiry'],
            ]);
        }

        return Order::create($orderData);
    }

    /**
     * Create order items.
     */
    private function createOrderItems($order, $checkoutData)
    {
        foreach ($checkoutData['items'] as $item) {
            if ($checkoutData['source'] === 'buy_now') {
                OrderItem::createFromProduct(
                    $item->ecommerceProduct,
                    $item->quantity,
                    $order->id
                );
            } else {
                OrderItem::createFromCartItem($item, $order->id);
            }
        }
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
                'notes' => "Order placed by user ID: {$order->customer_id}",
            ]);

            Log::info('Product quantity updated', [
                'product_id' => $warehouseProduct->id,
                'product_name' => $warehouseProduct->product_name,
                'old_quantity' => $oldQuantity,
                'ordered_quantity' => $orderedQuantity,
                'new_quantity' => $newQuantity,
                'order_number' => $order->order_number,
            ]);
        }
    }

    /**
     * Save user address for future use.
     */
    public function saveAddress(Request $request): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required',
            ], 401);
        }

        $validated = $request->validate([
            'address_type' => 'required|in:shipping,billing,both',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zipcode' => 'required|string|max:20',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'label' => 'nullable|string|max:255',
            'is_default' => 'boolean',
        ]);

        try {
            $validated['customer_id'] = Auth::id();
            $address = CustomerAddressDetail::create($validated);

            if ($validated['is_default'] ?? false) {
                $address->setAsDefault();
            }

            return response()->json([
                'success' => true,
                'message' => 'Address saved successfully!',
                'address' => [
                    'id' => $address->id,
                    'label' => $address->label ?? 'Address ' . $address->id,
                    'formatted_address' => $address->formatted_address,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Address save error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to save address. Please try again.',
            ], 500);
        }
    }

    /**
     * Display order details page.
     */
    public function orderDetails($orderNumber)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view order details.');
        }

        // Find order by order number and ensure it belongs to the authenticated user
        $order = Order::with(['orderItems.ecommerceProduct.warehouseProduct', 'customer.addressDetails',])
            ->where('order_number', $orderNumber)
            ->where('customer_id', Auth::id())
            ->first();
        // dd($order);

        if (! $order) {
            return redirect()->route('my-account-orders')->with('error', 'Order not found.');
        }

        // Calculate totals
        $totals = $this->calculateOrderTotals($order);

        return view('frontend.order-details', compact('order', 'totals'));
    }

    /**
     * Calculate order totals including tax information.
     */
    private function calculateOrderTotals($order)
    {
        $subtotal = $order->orderItems->sum('taxable_value');
        $totalTax = $order->orderItems->sum('igst_amount');
        $totalAmount = $order->orderItems->sum('final_amount');
        $shippingCharges = $order->shipping_charges;
        $grandTotal = $totalAmount + $shippingCharges;

        // Calculate rounding off
        $roundedTotal = round($grandTotal);
        $roundingOff = $roundedTotal - $grandTotal;

        return [
            'subtotal' => $subtotal,
            'total_tax' => $totalTax,
            'total_amount' => $totalAmount,
            'shipping_charges' => $shippingCharges,
            'grand_total' => $grandTotal,
            'rounded_total' => $roundedTotal,
            'rounding_off' => $roundingOff,
            'total_in_words' => $this->convertNumberToWords($roundedTotal),
        ];
    }

    /**
     * Convert number to words (Indian format).
     */
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
            $crores = (int) ($number / 10000000);
            $result .= $this->convertNumberToWords($crores) . ' Crore ';
            $number %= 10000000;
        }

        if ($number >= 100000) { // Lakhs
            $lakhs = (int) ($number / 100000);
            $result .= $this->convertNumberToWords($lakhs) . ' Lakh ';
            $number %= 100000;
        }

        if ($number >= 1000) { // Thousands
            $thousands = (int) ($number / 1000);
            $result .= $this->convertNumberToWords($thousands) . ' Thousand ';
            $number %= 1000;
        }

        if ($number >= 100) { // Hundreds
            $hundreds = (int) ($number / 100);
            $result .= $words[$hundreds] . ' Hundred ';
            $number %= 100;
        }

        if ($number >= 20) {
            $tens = (int) ($number / 10) * 10;
            $result .= $words[$tens] . ' ';
            $number %= 10;
        }

        if ($number > 0) {
            $result .= $words[$number] . ' ';
        }

        return trim($result) . ' Rupees Only';
    }

    /**
     * Display user's order history page.
     */
    public function myAccountOrders()
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your orders.');
        }

        // Get user's orders with pagination
        $orders = Order::with(['orderItems'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.my-account-orders', compact('orders'));
    }
}
