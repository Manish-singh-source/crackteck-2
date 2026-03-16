<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
     * Type: 0 - Percentage, 1 - Fixed, 2 - Buy X Get Y
     */
    public function getFormattedDiscountAttribute()
    {
        if ($this->type == 'percentage') { // Percentage
            return $this->discount_value.'%';
        } elseif ($this->type == 'fixed') { // Fixed
            return '₹'.number_format($this->discount_value, 2);
        } else { // Buy X Get Y
            return 'Buy X Get Y';
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
        return $this->status == 'active' && ! $this->status == 'expired' && now()->gte($this->start_date);
    }

    public function hasReachedTotalLimit()
    {
        return $this->usage_limit && $this->used_count >= $this->usage_limit;
    }

    public function hasUserReachedLimit(int $userId)
    {
        if (!$this->usage_per_customer) {
            return false;
        }

        $usageCount = CouponUsage::where('coupon_id', $this->id)
            ->where('customer_id', $userId)
            ->count();

        return $usageCount >= $this->usage_per_customer;
    }

    public function meetsMinimumPurchase(float $cartTotal)
    {
        return $cartTotal >= $this->min_purchase_amount;
    }

    public function appliesToProduct(EcommerceProduct $product)
    {
        // If no restrictions, coupon applies to all products
        if (empty($this->applicable_categories) && empty($this->applicable_brands) && empty($this->excluded_products)) {
            return true;
        }

        // Check if product is excluded
        if ($this->excluded_products && in_array($product->id, $this->excluded_products)) {
            return false;
        }

        // Check applicable categories
        if ($this->applicable_categories) {
            $productCategoryId = $product->category_id;
            if (!in_array($productCategoryId, $this->applicable_categories)) {
                return false;
            }
        }

        // Check applicable brands
        if ($this->applicable_brands) {
            $productBrandId = $product->brand_id;
            if (!in_array($productBrandId, $this->applicable_brands)) {
                return false;
            }
        }

        return true;
    }

    public function calculateDiscount($cartItems)
    {
        $totalDiscount = 0;
        $applicableAmount = 0;

        foreach ($cartItems as $item) {
            $product = $item->ecommerceProduct ?? null;
            
            if (!$product) {
                continue;
            }

            // Check if coupon applies to this product
            if (!$this->appliesToProduct($product)) {
                continue;
            }

            // Get the price based on cart item or direct product
            $price = 0;
            if (isset($item->ecommerceProduct->warehouseProduct)) {
                $price = $item->ecommerceProduct->warehouseProduct->selling_price ?? 0;
            } elseif (isset($product->warehouseProduct)) {
                $price = $product->warehouseProduct->selling_price ?? 0;
            }

            $quantity = $item->quantity ?? 1;
            $itemTotal = $price * $quantity;
            $applicableAmount += $itemTotal;
        }

        // Calculate discount based on type
        if ($this->type == 'percentage') {
            $discount = ($applicableAmount * $this->discount_value) / 100;
        } elseif ($this->type == 'fixed') {
            $discount = $this->discount_value;
        } else {
            $discount = 0;
        }

        // Apply max discount cap if set
        // if ($this->max_discount && $discount > $this->max_discount) {
        //     $discount = $this->max_discount;
        // }

        return $discount;
    }

}
