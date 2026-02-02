<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequestProductPickup extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'request_id',
        'product_id',
        'engineer_id',
        'reason',
        'assigned_person_type',
        'assigned_person_id',
        'status',
        'otp',
        'otp_expiry',
        'assigned_at',
        'approved_at',
        'picked_at',
        'received_at',
        'cancelled_at',
        'returned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'approved_at' => 'datetime',
        'picked_at' => 'datetime',
        'received_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'returned_at' => 'datetime',
        'otp_expiry' => 'datetime',
    ];

    /**
     * Get the service request that owns this pickup.
     */
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'request_id');
    }

    /**
     * Get the service request product.
     */
    public function serviceRequestProduct()
    {
        return $this->belongsTo(ServiceRequestProduct::class, 'product_id');
    }

    /**
     * Get the assigned engineer from assigned_engineers table.
     */
    public function assignedEngineer()
    {
        return $this->belongsTo(AssignedEngineer::class, 'engineer_id');
    }

    /**
     * Get the assigned person (Delivery Man or Engineer).
     */
    public function assignedPerson()
    {
        return $this->belongsTo(Staff::class, 'assigned_person_id');
    }

    /**
     * Scope for pending pickups.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for assigned pickups.
     */
    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }
}
