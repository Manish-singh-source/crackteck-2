<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefundBankDetail extends Model
{
    protected $fillable = [
        'order_id',
        'return_order_id',
        'customer_id',
        'refund_context',
        'account_holder_name',
        'bank_name',
        'account_number',
        'ifsc_code',
        'branch_name',
        'upi_id',
        'submitted_at',
    ];

    protected $casts = [
        'account_holder_name' => 'encrypted',
        'bank_name' => 'encrypted',
        'account_number' => 'encrypted',
        'submitted_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function returnOrder()
    {
        return $this->belongsTo(ReturnOrder::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
