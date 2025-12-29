<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldIssue extends Model
{
    //
    protected $fillable = [
        'issue_id',
        'field_executive_id',
        'issue_type',
        'issue_description',
        'priority',
        'status',
        'assigned_remote_engineer_id',
        'resolved_at',
        'resolution_notes',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];
}
