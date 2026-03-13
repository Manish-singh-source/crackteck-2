<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemoteSupportJob extends Model
{
    //
    use SoftDeletes;
    
    protected $fillable = [
        'service_request_id',
        'amc_schedule_meeting_id',
        'staff_id',
        'assigned_at',
        'escalate_to',
        'escalate_at',
        'notes',
        'client_feedback',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    }

    public function amcScheduleMeeting()
    {
        return $this->belongsTo(AmcScheduleMeeting::class, 'amc_schedule_meeting_id');
    }

    public function engineer()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function diagnosis()
    {
        return $this->hasOne(RemoteSupportDiagnosis::class, 'remote_support_job_id');
    }

}

