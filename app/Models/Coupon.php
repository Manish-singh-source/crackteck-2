<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Coupon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'description',
        'type',
        'discount_value',
        'max_discount',
        'min_purchase_amount',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'usage_per_customer',
        'status',
        'applicable_categories',
        'applicable_brands',
        'excluded_products',
        'stackable',
    ];

    protected $casts = [
        'applicable_categories' => 'array',
        'applicable_brands' => 'array',
        'excluded_products' => 'array',
        'stackable' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Scope for active coupons
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for inactive coupons
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope for expired coupons
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    /**
     * Get formatted discount value
     * Type: percentage, fixed
     */
    public function getFormattedDiscountAttribute()
    {
        if ($this->type == 'percentage') {
            return $this->discount_value.'%';
        } elseif ($this->type == 'fixed') {
            return '₹'.number_format($this->discount_value, 2);
        } else {
            return 'Fixed: ₹'.number_format($this->discount_value, 2);
        }
    }

    /**
     * Get usage percentage
     */
    public function getUsagePercentageAttribute()
    {
        if (! $this->usage_limit || $this->usage_limit == 0) {
            return 0;
        }

        return round(($this->used_count / $this->usage_limit) * 100, 2);
    }

    /**
     * Check if coupon is expired
     */
    public function getIsExpiredAttribute()
    {
        return now()->gt($this->end_date);
    }

    /**
     * Check if coupon is valid (active and not expired)
     */
    public function getIsValidAttribute()
    {
        return $this->status == 'active' && ! $this->is_expired && now()->gte($this->start_date);
    }

    /**
     * Check if discount value is valid
     */
    public function hasValidDiscountValue(): bool
    {
        return $this->discount_value !== null && $this->discount_value > 0;
    }

    /**
     * Check if coupon has reached total usage limit
     */
    public function hasReachedTotalLimit(): bool
    {
        if (! $this->usage_limit || $this->usage_limit == 0) {
            return false;
        }

        return $this->used_count >= $this->usage_limit;
    }

    /**
     * Check if user has reached usage limit for this coupon
     */
    public function hasUserReachedLimit(int $userId): bool
    {
        if (! $this->usage_per_customer || $this->usage_per_customer == 0) {
            return false;
        }

        $usageCount = CouponUsage::where('coupon_id', $this->id)
            ->where('customer_id', $userId)
            ->count();

        return $usageCount >= $this->usage_per_customer;
    }

    /**
     * Get user's usage count for this coupon
     */
    public function getUserUsageCount(int $userId): int
    {
        return CouponUsage::where('coupon_id', $this->id)
            ->where('customer_id', $userId)
            ->count();
    }

    /**
     * Check if minimum purchase amount is met
     */
    public function meetsMinimumPurchase(float $cartTotal): bool
    {
        if (! $this->min_purchase_amount || $this->min_purchase_amount == 0) {
            return true;
        }

        return $cartTotal >= $this->min_purchase_amount;
    }

    /**
     * Get product's category IDs (from warehouseProduct/Product)
     */
    public function getProductCategoryIds(EcommerceProduct $product): array
    {
        $categoryIds = [];

        // Get category from warehouseProduct (Product model)
        if ($product->warehouseProduct) {
            $productModel = $product->warehouseProduct;
            
            // Add parent_category_id
            if ($productModel->parent_category_id) {
                $categoryIds[] = (int) $productModel->parent_category_id;
            }
            
            // Add sub_category_id
            if ($productModel->sub_category_id) {
                $categoryIds[] = (int) $productModel->sub_category_id;
            }
        }

        return $categoryIds;
    }

    /**
     * Get product's brand ID (from warehouseProduct/Product)
     */
    public function getProductBrandId(EcommerceProduct $product): ?int
    {
        if ($product->warehouseProduct && $product->warehouseProduct->brand_id) {
            return (int) $product->warehouseProduct->brand_id;
        }

        return null;
    }

    /**
     * Check if coupon applies to a specific product
     * This handles:
     * - applicable_categories: product must be in one of these categories (OR logic)
     * - applicable_brands: product must be in one of these brands (OR logic)
     * - excluded_products: product must NOT be in this list
     * 
     * Business logic:
     * - If applicable_categories is set, product must match at least one category
     * - If applicable_brands is set, product must match at least one brand
     * - If excluded_products contains product, it always fails
     * - If both categories and brands are set, product must match at least one from EACH
     * - If no restrictions, coupon applies to all products (except excluded)
     */
    public function appliesToProduct(EcommerceProduct $product): bool
    {
        // Get product IDs that could be used for exclusion check
        $productId = (int) $product->id;
        
        // Check excluded_products first - highest priority
        $excludedProducts = $this->excluded_products ?? [];
        if (! empty($excludedProducts) && in_array($productId, array_map('intval', $excludedProducts))) {
            return false;
        }

        // Get product category and brand IDs
        $productCategoryIds = $this->getProductCategoryIds($product);
        $productBrandId = $this->getProductBrandId($product);

        // If no restrictions at all, coupon applies to all products
        $applicableCategories = $this->applicable_categories ?? [];
        $applicableBrands = $this->applicable_brands ?? [];
        
        if (empty($applicableCategories) && empty($applicableBrands)) {
            return true;
        }

        // Check applicable categories
        $categoryMatch = true;
        if (! empty($applicableCategories)) {
            $categoryMatch = false;
            if (! empty($productCategoryIds)) {
                foreach ($productCategoryIds as $catId) {
                    if (in_array($catId, array_map('intval', $applicableCategories))) {
                        $categoryMatch = true;
                        break;
                    }
                }
            }
        }

        // Check applicable brands
        $brandMatch = true;
        if (! empty($applicableBrands)) {
            $brandMatch = false;
            if ($productBrandId !== null) {
                $brandMatch = in_array($productBrandId, array_map('intval', $applicableBrands));
            }
        }

        // Both conditions must be met if both are set
        return $categoryMatch && $brandMatch;
    }

    /**
     * Calculate discount amount for given cart items
     */
    public function calculateDiscount($cartItems): float
    {
        $totalDiscount = 0;
        $applicableAmount = 0;

        foreach ($cartItems as $item) {
            $product = $item->ecommerceProduct ?? null;
            
            if (! $product) {
                continue;
            }

            // Check if coupon applies to this product
            if (! $this->appliesToProduct($product)) {
                continue;
            }

            // Get the price based on cart item or direct product
            $price = 0;
            if (isset($product->warehouseProduct)) {
                $price = $product->warehouseProduct->selling_price ?? 0;
            }

            $quantity = $item->quantity ?? 1;
            $itemTotal = $price * $quantity;
            $applicableAmount += $itemTotal;
        }

        // Validate discount_value
        if (! $this->hasValidDiscountValue()) {
            return 0;
        }

        // Calculate discount based on type
        if ($this->type == 'percentage') {
            $discount = ($applicableAmount * $this->discount_value) / 100;
        } elseif ($this->type == 'fixed') {
            // Fixed discount applies to the total applicable amount
            // But should not exceed the applicable amount
            $discount = min($this->discount_value, $applicableAmount);
        } else {
            // Default/fixed type
            $discount = min($this->discount_value, $applicableAmount);
        }

        // Apply max discount cap if set
        if ($this->max_discount && $this->max_discount > 0) {
            $discount = min($discount, $this->max_discount);
        }

        return round($discount, 2);
    }

    /**
     * Calculate the applicable amount (total price of items the coupon applies to)
     */
    public function calculateApplicableAmount($cartItems): float
    {
        $applicableAmount = 0;

        foreach ($cartItems as $item) {
            $product = $item->ecommerceProduct ?? null;
            
            if (! $product) {
                continue;
            }

            // Check if coupon applies to this product
            if (! $this->appliesToProduct($product)) {
                continue;
            }

            // Get the price based on cart item or direct product
            $price = 0;
            if (isset($product->warehouseProduct)) {
                $price = $product->warehouseProduct->selling_price ?? 0;
            }

            $quantity = $item->quantity ?? 1;
            $itemTotal = $price * $quantity;
            $applicableAmount += $itemTotal;
        }

        return $applicableAmount;
    }

    /**
     * Check if coupon is currently active and within valid date range
     */
    public function isCurrentlyValid(): bool
    {
        // Check status
        if ($this->status !== 'active') {
            return false;
        }

        $now = Carbon::now();

        // Check start date
        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        // Check end date
        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }

        return true;
    }

    /**
     * Get validation error messages for a coupon
     */
    public function getValidationErrors(int $userId, $cartItems, float $cartTotal): array
    {
        $errors = [];

        // Check if coupon is active
        if ($this->status !== 'active') {
            $errors[] = 'This coupon is currently inactive.';
        }

        // Check discount value
        if (! $this->hasValidDiscountValue()) {
            $errors[] = 'This coupon has an invalid discount value.';
        }

        // Check date validity
        $now = Carbon::now();
        
        if ($this->start_date && $now->lt($this->start_date)) {
            $errors[] = 'This coupon is not yet active. It will be valid from ' . $this->start_date->format('d M Y');
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            $errors[] = 'This coupon has expired on ' . $this->end_date->format('d M Y');
        }

        // Check total usage limit
        if ($this->hasReachedTotalLimit()) {
            $errors[] = 'This coupon has reached its maximum usage limit.';
        }

        // Check user usage limit
        if ($this->hasUserReachedLimit($userId)) {
            $userUsageCount = $this->getUserUsageCount($userId);
            $remainingUses = $this->usage_per_customer - $userUsageCount;
            if ($remainingUses <= 0) {
                $errors[] = 'You have already used this coupon the maximum number of times.';
            } else {
                $errors[] = "You can only use this coupon {$this->usage_per_customer} time(s). You have used it {$userUsageCount} time(s) already.";
            }
        }

        // Check minimum purchase amount
        if (! $this->meetsMinimumPurchase($cartTotal)) {
            $errors[] = 'Minimum purchase amount of ₹' . number_format($this->min_purchase_amount, 2) . ' required to use this coupon. Your current total: ₹' . number_format($cartTotal, 2);
        }

        // Check if coupon applies to any items in cart
        if ($cartItems && $cartItems->isNotEmpty()) {
            $hasApplicableItems = false;
            $applicableAmount = 0;
            
            foreach ($cartItems as $item) {
                $product = $item->ecommerceProduct ?? null;
                if ($product && $this->appliesToProduct($product)) {
                    $hasApplicableItems = true;
                    $price = 0;
                    if (isset($product->warehouseProduct)) {
                        $price = $product->warehouseProduct->selling_price ?? 0;
                    }
                    $quantity = $item->quantity ?? 1;
                    $applicableAmount += $price * $quantity;
                }
            }

            if (! $hasApplicableItems) {
                $errors[] = 'This coupon is not applicable to any items in your cart.';
            } elseif ($applicableAmount <= 0) {
                $errors[] = 'No valid items found for this coupon.';
            }
        }

        return $errors;
    }

}
