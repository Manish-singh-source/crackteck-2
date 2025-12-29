<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PickupRequest extends Model
{
    use SoftDeletes;

    //
    protected $fillable = [
        'service_request_id',
        'engineer_id',
        'customer_id',

        'pickup_person_id',
        'pickup_assigned_at',
        'pickup_completed_at',

        'delivery_person_id',
        'delivery_assigned_at',
        'delivery_completed_at',

        'status',
        'cancellation_reason',

        'before_photos',
        'after_photos',
    ];

    // Json Data
    protected $casts = [
        'before_photos' => 'array',
        'after_photos' => 'array',
    ];
}
