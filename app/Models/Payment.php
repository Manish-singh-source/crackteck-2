<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'gateway',
        'gateway_order_id',
        'gateway_payment_id',
        'gateway_signature',
        'amount',
        'currency',
        'status',
        'method',
        'gateway_payload',
        'authorized_at',
        'captured_at',
        'failed_at',
        'refunded_at',
    ];

    protected $casts = [
        'gateway_payload' => 'array',
        'authorized_at' => 'datetime',
        'captured_at' => 'datetime',
        'failed_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function attempts()
    {
        return $this->hasMany(PaymentAttempt::class);
    }
}
