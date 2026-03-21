<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemoteAmcPayment extends Model
{
    protected $fillable = [
        'amc_id',
        'customer_id',
        'amc_plan_id',
        'payment_reference',
        'gateway',
        'gateway_order_id',
        'gateway_payment_id',
        'gateway_signature',
        'amount',
        'currency',
        'status',
        'method',
        'paid_at',
        'failed_at',
        'gateway_payload',
    ];

    protected $casts = [
        'gateway_payload' => 'array',
        'paid_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    public function amc()
    {
        return $this->belongsTo(Amc::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function amcPlan()
    {
        return $this->belongsTo(AmcPlan::class);
    }
}
