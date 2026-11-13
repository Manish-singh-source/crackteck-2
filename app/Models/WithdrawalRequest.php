<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    protected $fillable = ['withdrawal_no', 'staff_id', 'requester_role', 'amount', 'reason', 'payout_method', 'payout_details', 'status', 'rejection_reason', 'payment_reference', 'requested_at', 'approved_at', 'paid_at', 'processed_by'];

    protected $casts = ['amount' => 'decimal:2', 'requested_at' => 'datetime', 'approved_at' => 'datetime', 'paid_at' => 'datetime'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
