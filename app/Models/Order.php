<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // New status constants for delivery tracking
    const STATUS_PENDING = 'pending';
    const STATUS_ADMIN_APPROVED = 'admin_approved';
    const STATUS_ASSIGNED_DELIVERY_MAN = 'assigned_delivery_man';
    const STATUS_ORDER_ACCEPTED = 'order_accepted';
    const STATUS_PRODUCT_TAKEN = 'product_taken';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_RETURNED = 'returned';

    // Array of all status options
    const STATUS_OPTIONS = [
        self::STATUS_PENDING,
        self::STATUS_ADMIN_APPROVED,
        self::STATUS_ASSIGNED_DELIVERY_MAN,
        self::STATUS_ORDER_ACCEPTED,
        self::STATUS_PRODUCT_TAKEN,
        self::STATUS_DELIVERED,
        self::STATUS_CANCELLED,
        self::STATUS_RETURNED,
    ];

    // Status options for edit page (limited to initial statuses)
    const STATUS_OPTIONS_EDIT = [
        self::STATUS_PENDING,
        self::STATUS_ADMIN_APPROVED,
    ];

    protected $fillable = [
        'customer_id',
        'order_number',

        'total_items',
        'subtotal',
        'discount_amount',
        'coupon_code',
        'tax_amount',
        'shipping_charges',
        'packaging_charges',
        'total_amount',

        'billing_address_id',
        'shipping_address_id',
        'billing_same_as_shipping',

        'order_status',
        'payment_status',
        'delivery_status',

        // New status column for delivery tracking
        'status',

        'confirmed_at',
        'assigned_at',
        'accepted_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
        'expected_delivery_date',

        'otp',
        'otp_expiry',
        'otp_verified_at',

        'customer_notes',
        'admin_notes',
        'source_platform',
        'tracking_number',
        'tracking_url',

        'is_returnable',
        'return_days',
        'return_status',
        'refund_amount',
        'refund_status',

        'is_priority',
        'requires_signature',
        'is_gift',

        'assigned_person_type',
        'assigned_person_id',

        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'expected_delivery_date' => 'date',
        'confirmed_at' => 'datetime',
        'assigned_at' => 'datetime',
        'accepted_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'otp_expiry' => 'datetime',
        'otp_verified_at' => 'datetime',
    ];

    /**
     * Get the status display name
     */
    public function getStatusDisplayNameAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_ADMIN_APPROVED => 'Admin Approved',
            self::STATUS_ASSIGNED_DELIVERY_MAN => 'Assigned to Delivery Man',
            self::STATUS_ORDER_ACCEPTED => 'Order Accepted',
            self::STATUS_PRODUCT_TAKEN => 'Product Taken',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_RETURNED => 'Returned',
            default => 'Unknown',
        };
    }

    /**
     * Get the status badge color
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_ADMIN_APPROVED => 'info',
            self::STATUS_ASSIGNED_DELIVERY_MAN => 'primary',
            self::STATUS_ORDER_ACCEPTED => 'primary',
            self::STATUS_PRODUCT_TAKEN => 'primary',
            self::STATUS_DELIVERED => 'success',
            self::STATUS_CANCELLED => 'danger',
            self::STATUS_RETURNED => 'warning',
            default => 'secondary',
        };
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(CustomerAddressDetail::class, 'billing_address_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(CustomerAddressDetail::class, 'shipping_address_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderPayments()
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function deliveryMan()
    {
        return $this->belongsTo(Staff::class, 'delivery_man_id');
    }

    /**
     * Check if the order can have delivery man assigned
     */
    public function canAssignDeliveryMan(): bool
    {
        return in_array($this->status, [self::STATUS_ADMIN_APPROVED]);
    }

    /**
     * Check if the order is in an active delivery state
     */
    public function isInDeliveryProcess(): bool
    {
        return in_array($this->status, [
            self::STATUS_ASSIGNED_DELIVERY_MAN,
            self::STATUS_ORDER_ACCEPTED,
            self::STATUS_PRODUCT_TAKEN,
        ]);
    }
}
