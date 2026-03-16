<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AmcScheduleMeeting extends Model
{
    //
    use LogsActivity;

    protected $fillable = [
        'service_request_id',
        'amc_id',
        'scheduled_at',
        'completed_at',
        'remarks',
        'report',
        'visits_count',
        'status',
    ];


    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'service_request_id',
                'amc_id',
                'scheduled_at',
                'completed_at',
                'remarks',
                'report',
                'visits_count',
                'status',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "AMC {$eventName}");
    }

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    }

    public function activeAssignment()
    {
        return $this->hasOne(AssignedEngineer::class, 'amc_schedule_meeting_id')
            ->where('status', 'active');
    }

    public function remoteSupportJob()
    {
        return $this->hasOne(RemoteSupportJob::class, 'amc_schedule_meeting_id');
    }
}
