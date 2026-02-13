<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequestProductRequestPart extends Model
{
    //
    use SoftDeletes;
    
    protected $table = 'service_request_product_request_parts';
    
    protected $fillable = [
        'request_id',
        'product_id',
        'engineer_id',
        'part_id',
        'requested_quantity',
        'reason',
        'request_type',

        'assigned_person_type',
        'assigned_person_id',    

        'status',

        'otp',
        'otp_expiry',
        
        'admin_approved_at',
        'admin_rejected_at',
        'assigned_at',
        'assigned_approved_at',
        'assigned_rejected_at',
        'warehouse_approved_at',
        'warehouse_rejected_at',
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

    public function engineer()
    {
        return $this->belongsTo(Staff::class, 'engineer_id');
    }

    public function assignedEngineer()
    {
        return $this->belongsTo(Staff::class, 'assigned_person_id');
    }

    public function requestedPart()
    {
        return $this->belongsTo(ProductSerial::class, 'part_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'part_id');
    }
}
