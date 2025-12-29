<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequestProductPickup extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'service_request_id',
        'service_request_product_id',
        'assigned_engineer_id',
        'reason',

        'assigned_person_type',
        'assigned_person_id',

        'status',

        'otp',
        'otp_expiry',
        
        'assigned_at',
        'approved_at',
        'picked_at',
        'received_at',
        'cancelled_at',
        'returned_at',
    ];
}
