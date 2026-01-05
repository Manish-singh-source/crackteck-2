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

    public function setMeetingTypeAttribute($value)
    {
        $map = [
            'in_person' => '0',
            'virtual' => '1',
            'phone' => '2',
        ];

        $this->attributes['meeting_type'] = is_numeric($value)
            ? $value
            : ($map[strtolower($value)] ?? null);
    }
    
    public function setStatusAttribute($value)
    {
        $map = [
            'scheduled' => '0',
            'confirmed' => '1',
            'completed' => '2',
            'cancelled' => '3',
            'rescheduled' => '4',
        ];

        $this->attributes['status'] = is_numeric($value)
            ? $value
            : ($map[strtolower($value)] ?? null);
    }

    public function leadDetails()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }
}
