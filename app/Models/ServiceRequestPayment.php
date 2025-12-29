<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequestPayment extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'service_request_id',
        'transaction_id',
        'total_amount',
        'payment_gateway',
        'payment_method',
        'payment_date',
        'payment_status',
    ];
}
