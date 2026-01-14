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
        'model_no',
        'sku',
        'hsn',
        'purchase_date',
        'brand',
        'images',
        'description',
        'item_code_id',
        'service_charge',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_requests_id');
    }

    public function itemCode()
    {
        return $this->belongsTo(CoveredItem::class, 'item_code_id');
    }

}
