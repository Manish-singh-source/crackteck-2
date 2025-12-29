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
        'engineer_id',
        'assignment_type',
        'assigned_at',
        'transferred_to',
        'transferred_at',
        'group_name',
        'is_supervisor',
        'notes',
        'status',
    ];
}
