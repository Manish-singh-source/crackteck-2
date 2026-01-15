<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequestProductRequestPart extends Model
{
    //
    use SoftDeletes;
    
    protected $fillable = [
        'service_request_id',
        'service_request_product_id',
        'assigned_engineer_id',
        'requested_part_id',
        'request_type',

        'assigned_person_type',
        'assigned_person_id',    

        'status',

        'otp',
        'otp_expiry',
        
        'assigned_at',
        'approved_at',
        'rejected_at',
        'customer_approved_at',
        'customer_rejected_at',
        'picked_at',
        'in_transit_at',
        'delivered_at',
        'used_at',
        'cancelled_at',
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'request_id');
    }

    public function serviceRequestProduct()
    {
        return $this->belongsTo(ServiceRequestProduct::class, 'product_id');
    }

    public function fromEngineer()
    {
        return $this->belongsTo(Staff::class, 'engineer_id');
    }


    public function assignedEngineer()
    {
        return $this->belongsTo(Staff::class, 'assigned_person_id');
    }

    public function requestedPart()
    {
        return $this->belongsTo(Product::class, 'part_id');
    }
}
