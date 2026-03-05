<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AssignedEngineerGroup extends Model
{

    use LogsActivity;

    protected $table = 'assigned_engineer_group';

    protected $fillable = [
        'assignment_id',
        'engineer_id',
        'is_supervisor',
    ];

    protected $casts = [
        'is_supervisor' => 'boolean',
    ];

    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'assignment_id',
                'engineer_id',
                'is_supervisor',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "AMC {$eventName}");
    }


    public function assignment()
    {
        return $this->belongsTo(AssignedEngineer::class, 'assignment_id');
    }

    public function engineer()
    {
        return $this->belongsTo(Staff::class, 'engineer_id');
    }
}
