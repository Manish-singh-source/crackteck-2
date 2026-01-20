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
            return $this->discount_value . '%';
        } elseif ($this->type == 'fixed') { // Fixed
            return '₹' . number_format($this->discount_value, 2);
        } else { // Buy X Get Y
            return 'Buy X Get Y';
        }
    }

    /**
     * Get usage percentage
     */
    public function getUsagePercentageAttribute()
    {
        if (!$this->usage_limit || $this->usage_limit == 0) {
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
        return $this->status == 'active' && !$this->status == 'expired' && now()->gte($this->start_date);
    }
}
