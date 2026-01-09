<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_serial_id',
        'product_name',
        'product_sku',
        'hsn_code',
        'quantity',
        'unit_price',
        'discount_per_unit',
        'tax_per_unit',
        'line_total',
        'variant_details',
        'custom_options',
        'item_status',
    ];

    protected $casts = [
        'variant_details' => 'array',
        'custom_options' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function ecommerceProduct()
    {
        return $this->belongsTo(EcommerceProduct::class);
    }
    
    public function productSerial()
    {
        return $this->belongsTo(ProductSerial::class);
    }
}
