<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPayment extends Model
{
    use SoftDeletes;

    //
    protected $fillable = [
        'order_id',
        'payment_id',
        'transaction_id',
        'payment_method',
        'payment_gateway',
        'amount',
        'currency',
        'status',
        'response_data',
        'processed_at',
        'failure_reason',
        'notes',
    ];

    protected $casts = [
        'response_data' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getPaymentMethodAttribute($value)
    {
        $methods = [
            0 => 'Online',
            1 => 'COD',
            2 => 'Cheque',
            3 => 'Bank Transfer',
        ];

        return $methods[$value] ?? 'N/A';
    }
}
