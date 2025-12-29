<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemoteJob extends Model
{
    //
    protected $fillable = [
        'service_request_id',
        'field_executive_id',
        'assigned_engineer_id',
        'job_type',
        'job_description',
        'remote_access_details',
        'status',
        'started_at',
        'completed_at',
        'resolution_notes',
        'escalation_reason',
    ];

    protected $casts = [
        'remote_access_details' => 'array',
    ];
}
