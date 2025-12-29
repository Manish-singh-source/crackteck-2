<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestProduct extends Model
{
    //
    protected $fillable = [
        'service_requests_id',
        'name',
        'type',
        'brand',
        'model_no',
        'hsn',
        'purchase_date',
        'images',
        'item_code_id',
        'service_charge',
        'description',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
