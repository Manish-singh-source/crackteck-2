<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    //
    protected $fillable = [
        'lead_id',
        'staff_id',
        'followup_date',
        'followup_time',
        'followup_type',
        'status',
        'remarks',
        'next_action',
        'next_followup_date',
    ];
}
