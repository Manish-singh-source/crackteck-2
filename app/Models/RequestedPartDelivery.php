<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestedPartDelivery extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'service_request_id',
        'service_request_product_id',
        'service_request_product_request_part_id',
        'product_serial_id',
        'quantity',
        'unit_price',
        'total_price',
        'notes',
        'otp',
        'otp_expiry',
        'delivered_at',
    ];
}
