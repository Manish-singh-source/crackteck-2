<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
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

        'confirmed_at',
        'shipped_at',
        'delivered_at',
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
    
}
