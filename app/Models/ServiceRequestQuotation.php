<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequestQuotation extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'service_request_id',
        'service_request_product_request_part_id',
        'requested_part_id',
        'product_price',
        'service_charge',
        'delivery_charge',
        'total_amount',
        'discount',
        'quotation_file',
        'quotation_status',
        'quotation_date',
    ];
}
