<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockInHand extends Model
{
    //
    protected $fillable = [
        'stock_in_hand_id',
        'service_request_id',
        'engineer_id',
        'customer_id',
        'requested_at',
        'assigned_delivery_man_id',
        'assigned_at',
        'delivered_at',
        'status',
        'request_notes',
        'delivery_photos',
        'cancellation_reason',
        'requested_quantity',
        'delivered_quantity',
        'requested_date',
        'approved_at',
    ];
}
