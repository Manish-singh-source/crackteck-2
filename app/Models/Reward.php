<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Reward extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'coupon_id',
        'customer_id',
        'start_date',
        'end_date',
        'order_id',
        'service_request_id',
        'status',
        'used_order_id',
        'used_service_request_id',
        'used_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'used_at' => 'datetime',
    ];

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_USED = 'used';
    const STATUS_EXPIRED = 'expired';

    /**
     * Get the coupon associated with this reward.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the customer who owns this reward.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the order that triggered this reward.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the service request that triggered this reward.
     */
    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    }

    /**
     * Get the order where this reward was used.
     */
    public function usedOrder(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'used_order_id');
    }

    /**
     * Get the service request where this reward was used.
     */
    public function usedServiceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class, 'used_service_request_id');
    }

    /**
     * Scope for active rewards
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope for used rewards
     */
    public function scopeUsed($query)
    {
        return $query->where('status', self::STATUS_USED);
    }

    /**
     * Scope for expired rewards
     */
    public function scopeExpired($query)
    {
        return $query->where('status', self::STATUS_EXPIRED);
    }

    /**
     * Scope for valid (active and not expired) rewards
     */
    public function scopeValid($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)
            ->where('end_date', '>=', Carbon::today());
    }

    /**
     * Scope for rewards by customer
     */
    public function scopeForCustomer($query, int $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Check if the reward is expired
     */
    public function getIsExpiredAttribute(): bool
    {
        return now()->gt($this->end_date);
    }

    /**
     * Check if the reward is valid (active and not expired)
     */
    public function getIsValidAttribute(): bool
    {
        return $this->status === self::STATUS_ACTIVE && !$this->is_expired;
    }

    /**
     * Check if the reward can be used
     */
    public function canBeUsed(): bool
    {
        return $this->status === self::STATUS_ACTIVE && !$this->is_expired;
    }

    /**
     * Mark the reward as used
     */
    public function markAsUsed(?int $orderId = null, ?int $serviceRequestId = null): bool
    {
        $this->status = self::STATUS_USED;
        $this->used_order_id = $orderId;
        $this->used_service_request_id = $serviceRequestId;
        $this->used_at = now();

        return $this->save();
    }

    /**
     * Mark the reward as expired
     */
    public function markAsExpired(): bool
    {
        $this->status = self::STATUS_EXPIRED;
        return $this->save();
    }

    /**
     * Sync status with coupon usage
     * This method is called when checking or updating reward status
     */
    public function syncStatusWithCouponUsage(): void
    {
        // Check if the coupon has been used by this customer
        $couponUsage = CouponUsage::where('coupon_id', $this->coupon_id)
            ->where('customer_id', $this->customer_id)
            ->first();

        if ($couponUsage) {
            // Coupon has been used, update the reward status
            if ($this->status !== self::STATUS_USED) {
                $this->markAsUsed($couponUsage->order_id);
            }
        } elseif ($this->is_expired && $this->status !== self::STATUS_EXPIRED) {
            // Coupon has expired, update the reward status
            $this->markAsExpired();
        }
    }

    /**
     * Check if a reward already exists for this customer, coupon, and order combination
     */
    public static function existsForOrder(int $customerId, int $couponId, int $orderId): bool
    {
        return self::where('customer_id', $customerId)
            ->where('coupon_id', $couponId)
            ->where('order_id', $orderId)
            ->exists();
    }

    /**
     * Check if a reward already exists for this customer, coupon, and service request combination
     */
    public static function existsForServiceRequest(int $customerId, int $couponId, int $serviceRequestId): bool
    {
        return self::where('customer_id', $customerId)
            ->where('coupon_id', $couponId)
            ->where('service_request_id', $serviceRequestId)
            ->exists();
    }

    /**
     * Check if any reward exists for this customer and order
     */
    public static function existsForCustomerOrder(int $customerId, int $orderId): bool
    {
        return self::where('customer_id', $customerId)
            ->where('order_id', $orderId)
            ->exists();
    }

    /**
     * Check if any reward exists for this customer and service request
     */
    public static function existsForCustomerServiceRequest(int $customerId, int $serviceRequestId): bool
    {
        return self::where('customer_id', $customerId)
            ->where('service_request_id', $serviceRequestId)
            ->exists();
    }

    /**
     * Get reward for a specific order
     */
    public static function getForOrder(int $customerId, int $orderId): ?self
    {
        return self::where('customer_id', $customerId)
            ->where('order_id', $orderId)
            ->first();
    }

    /**
     * Get reward for a specific service request
     */
    public static function getForServiceRequest(int $customerId, int $serviceRequestId): ?self
    {
        return self::where('customer_id', $customerId)
            ->where('service_request_id', $serviceRequestId)
            ->first();
    }
}
