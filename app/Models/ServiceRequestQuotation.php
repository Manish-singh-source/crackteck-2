<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequestQuotation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'request_id',
        'request_part_count',
        'service_charge_total',
        'part_count',
        'product_price_total',
        'subtotal',
        'delivery_charge',
        'total_discount',
        'total_tax',
        'round_off',
        'grand_total',
        'currency',
        'paid_amount',
        'payment_status',
        'payment_method',
        'paid_at',
        'billing_address_id',
        'shipping_address_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'invoice_pdf',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'request_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(CustomerAddressDetail::class, 'billing_address_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(CustomerAddressDetail::class, 'shipping_address_id');
    }
}
