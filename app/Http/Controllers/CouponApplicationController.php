<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\EcommerceProduct;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CouponApplicationController extends Controller
{
    /**
     * Apply a coupon to the user's cart.
     * 
     * Validates all coupon conditions:
     * 1. Coupon code exists
     * 2. Coupon is active
     * 3. Current date is within start_date and end_date
     * 4. Minimum purchase amount is satisfied
     * 5. Usage limit has not been exceeded
     * 6. Used count is within allowed limit
     * 7. Usage per customer has not been exceeded
     * 8. Discount value is valid
     * 9. Applicable categories match (if set)
     * 10. Applicable brands match (if set)
     * 11. Product is not in excluded_products
     */
    public function applyCoupon(Request $request): JsonResponse
    {
        // Check if user is authenticated
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to apply coupons.',
            ], 401);
        }

        // Validate request
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $couponCode = strtoupper(trim($request->coupon_code));
        $userId = Auth::guard('customer_web')->id();

        // Check navigation source to determine cart validation approach
        $navigationSource = Session::get('checkout_navigation_source', 'cart');
        
        // Get cart items based on navigation source
        $cartItems = $this->getCartItems($request, $userId, $navigationSource);
        
        // For buy_now, we need to wrap the product in a collection-like object
        $isBuyNow = $navigationSource === 'buy_now';

        // If cart is empty (for cart navigation), return error
        if ($cartItems->isEmpty() && !$isBuyNow) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty. Add some products to apply a coupon.',
            ]);
        }

        // Find the coupon by code
        $coupon = Coupon::where('code', $couponCode)->first();

        // Check if coupon exists
        if (! $coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code. Please check and try again.',
            ]);
        }

        // Calculate cart total
        $cartTotal = $this->calculateCartTotal($cartItems, $isBuyNow);

        // Validate all coupon conditions
        $validationErrors = $coupon->getValidationErrors($userId, $cartItems, $cartTotal);

        if (! empty($validationErrors)) {
            return response()->json([
                'success' => false,
                'message' => $validationErrors[0],
                'errors' => $validationErrors, // Include all errors for debugging
            ]);
        }

        // Calculate discount
        $discountAmount = $coupon->calculateDiscount($cartItems);

        // Validate discount amount
        if ($discountAmount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon cannot be applied to your current order.',
            ]);
        }

        // Ensure discount doesn't exceed cart total
        $discountAmount = min($discountAmount, $cartTotal);

        // Store coupon in session
        Session::put('applied_coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'title' => $coupon->title,
            'discount_amount' => $discountAmount,
            'discount_type' => $coupon->type,
            'discount_value' => $coupon->discount_value,
            'max_discount' => $coupon->max_discount,
        ]);

        // Calculate totals with discount
        $totals = $this->getCartTotals($cartItems, $discountAmount, $isBuyNow);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully! You saved ₹' . number_format($discountAmount, 2),
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'title' => $coupon->title,
                'discount_amount' => $discountAmount,
                'formatted_discount' => '₹' . number_format($discountAmount, 2),
            ],
            'cart_total' => $totals,
        ]);
    }

    /**
     * Remove applied coupon from cart.
     */
    public function removeCoupon(): JsonResponse
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to manage coupons.',
            ], 401);
        }

        $userId = Auth::guard('customer_web')->id();

        // Remove coupon from session
        Session::forget('applied_coupon');

        // Get current cart total
        $navigationSource = Session::get('checkout_navigation_source', 'cart');
        $isBuyNow = $navigationSource === 'buy_now';
        
        $cartItems = $this->getCartItems(new Request(), $userId, $navigationSource);
        $cartTotal = $this->calculateCartTotal($cartItems, $isBuyNow);

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully.',
            'cart_total' => [
                'subtotal' => $cartTotal,
                'discount' => 0,
                'total' => $cartTotal,
                'formatted' => [
                    'subtotal' => '₹' . number_format($cartTotal, 2),
                    'discount' => '₹0.00',
                    'total' => '₹' . number_format($cartTotal, 2),
                ],
            ],
        ]);
    }

    /**
     * Get current applied coupon information.
     */
    public function getAppliedCoupon(): JsonResponse
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'applied_coupon' => null,
            ]);
        }

        $appliedCoupon = Session::get('applied_coupon');

        return response()->json([
            'success' => true,
            'applied_coupon' => $appliedCoupon,
        ]);
    }

    /**
     * Get cart items based on navigation source.
     * Properly loads warehouseProduct relationship.
     */
    private function getCartItems(Request $request, int $userId, string $navigationSource)
    {
        if ($navigationSource === 'cart') {
            // Get cart items from cart table
            return Cart::with(['ecommerceProduct.warehouseProduct'])
                ->where('customer_id', $userId)
                ->get();
        } elseif ($navigationSource === 'buy_now') {
            // Get single product for buy now
            $productId = $request->product_id ?? $request->productId ?? null;
            
            if ($productId) {
                $ecommerceProduct = EcommerceProduct::with('warehouseProduct')
                    ->where('id', $productId)
                    ->first();

                if ($ecommerceProduct) {
                    // Create a collection-like object for single product
                    return collect([
                        (object) [
                            'ecommerceProduct' => $ecommerceProduct,
                            'quantity' => (int) ($request->quantity ?? 1),
                        ]
                    ]);
                }
            }
            
            return collect([]);
        }

        // Default: get cart items
        return Cart::with(['ecommerceProduct.warehouseProduct'])
            ->where('customer_id', $userId)
            ->get();
    }

    /**
     * Calculate cart total amount.
     */
    private function calculateCartTotal($cartItems, bool $isBuyNow = false): float
    {
        $total = 0;

        foreach ($cartItems as $item) {
            $product = $item->ecommerceProduct ?? null;
            
            if (! $product || ! $product->warehouseProduct) {
                continue;
            }

            $price = $product->warehouseProduct->selling_price ?? 0;
            $price = is_numeric($price) ? (float) $price : 0;
            $quantity = isset($item->quantity) ? (int) $item->quantity : 1;
            
            $total += $price * $quantity;
        }

        return $total;
    }

    /**
     * Get cart totals with discount applied.
     */
    private function getCartTotals($cartItems, float $discountAmount, bool $isBuyNow = false): array
    {
        $subtotal = $this->calculateCartTotal($cartItems, $isBuyNow);
        $finalTotal = max(0, $subtotal - $discountAmount);

        return [
            'subtotal' => round($subtotal, 2),
            'discount' => round($discountAmount, 2),
            'total' => round($finalTotal, 2),
            'formatted' => [
                'subtotal' => '₹' . number_format($subtotal, 2),
                'discount' => '₹' . number_format($discountAmount, 2),
                'total' => '₹' . number_format($finalTotal, 2),
            ],
        ];
    }

    /**
     * Record coupon usage when order is placed.
     */
    public function recordCouponUsage(int $couponId, int $userId, int $orderId, float $discountAmount): void
    {
        // Create usage record
        CouponUsage::create([
            'coupon_id' => $couponId,
            'customer_id' => $userId,
            'order_id' => $orderId,
            'discount_amount' => $discountAmount,
            'used_at' => now(),
        ]);

        // Increment coupon usage count
        $coupon = Coupon::find($couponId);
        if ($coupon) {
            $coupon->increment('used_count');
        }
    }

    /**
     * Get cart count for AJAX requests.
     */
    public function getCartCount(): JsonResponse
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'cart_count' => 0,
            ]);
        }

        return response()->json([
            'cart_count' => Cart::getCartCount(Auth::id()),
        ]);
    }

    /**
     * Validate coupon without applying it.
     * Useful for showing validation errors before application.
     */
    public function validateCoupon(Request $request): JsonResponse
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'valid' => false,
                'message' => 'Please login to validate coupons.',
            ], 401);
        }

        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $couponCode = strtoupper(trim($request->coupon_code));
        $userId = Auth::guard('customer_web')->id();

        $coupon = Coupon::where('code', $couponCode)->first();

        if (! $coupon) {
            return response()->json([
                'success' => false,
                'valid' => false,
                'message' => 'Invalid coupon code.',
            ]);
        }

        $navigationSource = Session::get('checkout_navigation_source', 'cart');
        $cartItems = $this->getCartItems($request, $userId, $navigationSource);
        $isBuyNow = $navigationSource === 'buy_now';
        $cartTotal = $this->calculateCartTotal($cartItems, $isBuyNow);

        $errors = $coupon->getValidationErrors($userId, $cartItems, $cartTotal);

        if (! empty($errors)) {
            return response()->json([
                'success' => false,
                'valid' => false,
                'message' => $errors[0],
                'errors' => $errors,
            ]);
        }

        // Calculate potential discount
        $discountAmount = $coupon->calculateDiscount($cartItems);

        return response()->json([
            'success' => true,
            'valid' => true,
            'message' => 'Coupon is valid!',
            'potential_discount' => $discountAmount,
            'formatted_discount' => '₹' . number_format($discountAmount, 2),
        ]);
    }
}
