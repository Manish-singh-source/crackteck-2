<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meet extends Model
{
    use HasFactory;

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

    public function leadDetails()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }

    public function staffDetails()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
