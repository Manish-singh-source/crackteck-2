<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meet extends Model
{
    //
    protected $fillable = [
        'lead_id',
        'staff_id',
        'meet_title',
        'meeting_type',
        'date',
        'start_time',
        'end_time',
        'location',
        'meeting_link',
        'attendees',
        'attachment',
        'meet_agenda',
        'meeting_notes',
        'follow_up_action',
        'status',
    ];

    protected $casts = [
        'attendees' => 'array',
    ];
}
