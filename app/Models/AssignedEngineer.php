<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignedEngineer extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'service_request_id',
        'amc_schedule_meeting_id',
        'engineer_id',
        'assignment_type',
        'assigned_at',
        'transferred_to',
        'transferred_at',
        'group_name',
        'is_supervisor',
        'notes',
        'status',
        'is_approved_by_engineer',
        'engineer_approved_at',
    ];

    protected $casts = [
        'is_approved_by_engineer' => 'boolean',
        'assigned_at' => 'datetime',
        'transferred_at' => 'datetime',
        'engineer_approved_at' => 'datetime',
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function engineer()
    {
        return $this->belongsTo(Staff::class, 'engineer_id');
    }

    public function transferredTo()
    {
        return $this->belongsTo(Staff::class, 'transferred_to');
    }

    public function groupEngineers()
    {
        return $this->belongsToMany(Staff::class, 'assigned_engineer_group', 'assignment_id', 'engineer_id')
            ->withPivot('is_supervisor')
            ->withTimestamps();
    }

    // Scope for pending approval
    public function scopePendingApproval($query)
    {
        return $query->where('is_approved_by_engineer', false)
            ->where('status', '0'); // Active assignments only
    }

    // Scope for approved tasks
    public function scopeApproved($query)
    {
        return $query->where('is_approved_by_engineer', true);
    }

    // Scope for tasks over 48 hours without approval
    public function scopeOverdue($query)
    {
        return $query->where('is_approved_by_engineer', false)
            ->where('status', '0')
            ->where('assigned_at', '<=', now()->subHours(48));
    }

    // Check if task is overdue (over 48 hours without approval)
    public function getIsOverdueAttribute()
    {
        if ($this->is_approved_by_engineer) {
            return false;
        }

        return $this->assigned_at && $this->assigned_at->addHours(48)->isPast();
    }
}
