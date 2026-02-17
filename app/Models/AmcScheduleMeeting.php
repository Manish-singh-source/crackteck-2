<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmcScheduleMeeting extends Model
{
    //
    protected $fillable = [
        'service_request_id',
        'scheduled_at',
        'completed_at',
        'remarks',
        'report',
        'visits_count',
        'status',
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    }

    public function activeAssignment()
    {
        return $this->hasOne(AssignedEngineer::class, 'service_request_id', 'service_request_id')
            ->where('status', 'active');
    }
}
