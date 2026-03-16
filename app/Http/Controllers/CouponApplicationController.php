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
     */
    public function applyCoupon(Request $request): JsonResponse
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to apply coupons.',
            ], 401);
        }

        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $couponCode = strtoupper(trim($request->coupon_code));
        $userId = Auth::guard('customer_web')->id();

        // Check navigation source to determine if cart validation should be skipped
        $navigationSource = Session::get('checkout_navigation_source');

        if ($navigationSource === 'cart') {
            // Get user's cart items
            $cartItems = Cart::with(['ecommerceProduct.warehouseProduct'])
                ->where('customer_id', $userId)
                ->get();
        } elseif ($navigationSource === 'buy_now') {
            $cartItems = EcommerceProduct::where('id', $request->productId)->get();
        } else {
            // Default: get cart items
            $cartItems = Cart::with(['ecommerceProduct.warehouseProduct'])
                ->where('customer_id', $userId)
                ->get();
        }

        $skipCartValidation = in_array($navigationSource, ['cart', 'buy_now']);

        if ($cartItems->isEmpty() && !$skipCartValidation) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.',
            ]);
        }

        // Find the coupon
        $coupon = Coupon::where('code', $couponCode)->first();

        if (! $coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code. Please check and try again.',
            ]);
        }

        // Validate coupon
        $validation = $this->validateCoupon($coupon, $userId, $cartItems, $skipCartValidation);
        if (! $validation['valid']) {
            return response()->json([
                'success' => false,
                'message' => $validation['message'],
            ]);
        }

        // Calculate discount
        $discountAmount = $coupon->calculateDiscount($cartItems);

        if ($discountAmount <= 0 && ! $skipCartValidation) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon is not applicable to items in your cart.',
            ]);
        }

        // Store coupon in session
        Session::put('applied_coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'title' => $coupon->title,
            'discount_amount' => $discountAmount,
            'discount_type' => $coupon->type,
            'discount_value' => $coupon->discount_value,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully! You saved ₹'.number_format($discountAmount, 2),
            'coupon' => [
                'code' => $coupon->code,
                'title' => $coupon->title,
                'discount_amount' => $discountAmount,
                'formatted_discount' => '₹'.number_format($discountAmount, 2),
            ],
            'cart_total' => $this->getCartTotalWithDiscount($cartItems, (float) $discountAmount),
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

        Session::forget('applied_coupon');

        $userId = Auth::guard('customer_web')->id();
        $cartItems = Cart::with(['ecommerceProduct.warehouseProduct'])
            ->where('customer_id', $userId)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully.',
            'cart_total' => Cart::getCartTotal($userId),
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
     * Validate if a coupon can be applied.
     */
    private function validateCoupon(Coupon $coupon, int $userId, $cartItems, bool $skipCartValidation = false): array
    {
        // Check if coupon is active
        if ($coupon->status !== 'active') {
            return ['valid' => false, 'message' => 'This coupon is currently inactive.'];
        }

        // Check date validity
        $now = Carbon::now();
        if ($coupon->start_date > $now) {
            return ['valid' => false, 'message' => 'This coupon is not yet active.'];
        }

        if ($coupon->end_date < $now) {
            return ['valid' => false, 'message' => 'This coupon has expired.'];
        }

        // Check total usage limit
        if ($coupon->hasReachedTotalLimit()) {
            return ['valid' => false, 'message' => 'This coupon has reached its usage limit.'];
        }

        // Check user usage limit
        if ($coupon->hasUserReachedLimit($userId)) {
            return ['valid' => false, 'message' => 'You have already used this coupon the maximum number of times.'];
        }

        // Check minimum purchase amount
        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $price = 0;
            if (isset($item->ecommerceProduct->warehouseProduct)) {
                $price = $item->ecommerceProduct->warehouseProduct->selling_price ?? 0;
            } elseif (isset($item->warehouseProduct)) {
                $price = $item->warehouseProduct->selling_price ?? 0;
            }
            $quantity = $item->quantity ?? 1;
            $cartTotal += $price * $quantity;
        }

        if (!$coupon->meetsMinimumPurchase($cartTotal)) {
            return [
                'valid' => false,
                'message' => 'Minimum purchase amount of ₹' . number_format($coupon->min_purchase_amount, 2) . ' required to use this coupon. Your cart total: ₹' . number_format($cartTotal, 2)
            ];
        }

        // Check if coupon applies to any cart items (skip if cart validation is disabled)
        if (! $skipCartValidation) {
            $hasApplicableItems = false;
            foreach ($cartItems as $item) {
                if ($coupon->appliesToProduct($item->ecommerceProduct)) {
                    $hasApplicableItems = true;
                    break;
                }
            }

            if (! $hasApplicableItems) {
                return ['valid' => false, 'message' => 'This coupon is not applicable to items in your cart.'];
            }
        }

        return ['valid' => true, 'message' => 'Coupon is valid.'];
    }

    /**
     * Calculate cart total with discount applied.
     */
    private function getCartTotalWithDiscount($cartItems, float $discountAmount): array
    {
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = $item->ecommerceProduct->warehouseProduct->selling_price ?? 0;
            $subtotal += $price * $item->quantity;
        }

        $finalTotal = max(0, $subtotal - $discountAmount);

        return [
            'subtotal' => $subtotal,
            'discount' => $discountAmount,
            'total' => $finalTotal,
            'formatted' => [
                'subtotal' => '₹'.number_format($subtotal, 2),
                'discount' => '₹'.number_format($discountAmount, 2),
                'total' => '₹'.number_format($finalTotal, 2),
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
}
