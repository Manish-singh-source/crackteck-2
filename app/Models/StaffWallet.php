<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffWallet extends Model
{
    use HasFactory;

    protected $table = 'staff_wallet';

    protected $fillable = [
        'staff_type',
        'staff_id',
        'amount',
        'reason',
        'receipt',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the staff member associated with this wallet entry.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }

    /**
     * Scope to filter by staff type.
     */
    public function scopeByStaffType($query, $staffType)
    {
        return $query->where('staff_type', $staffType);
    }

    /**
     * Scope to filter by staff ID.
     */
    public function scopeByStaffId($query, $staffId)
    {
        return $query->where('staff_id', $staffId);
    }

    /**
     * Scope to filter by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check if the status is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the status is admin_approved.
     */
    public function isAdminApproved()
    {
        return $this->status === 'admin_approved';
    }

    /**
     * Check if the status is admin_rejected.
     */
    public function isAdminRejected()
    {
        return $this->status === 'admin_rejected';
    }

    /**
     * Check if the status is payed.
     */
    public function isPayed()
    {
        return $this->status === 'payed';
    }
}
