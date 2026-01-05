<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FollowUp extends Model
{
    use HasFactory;

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

    public function setStatusAttribute($value)
    {
        $map = [
            'pending' => '0',
            'completed' => '1',
            'rescheduled' => '2',
            'cancelled' => '3',
        ];

        $this->attributes['status'] = is_numeric($value)
            ? $value
            : ($map[strtolower($value)] ?? null);
    }
    
    public function setFollowupTypeAttribute($value)
    {
        $map = [
            'call' => '0',
            'email' => '1',
            'meeting' => '2',
            'sms' => '3',
        ];

        $this->attributes['followup_type'] = is_numeric($value)
            ? $value
            : ($map[strtolower($value)] ?? null);
    }

    public function leadDetails()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }
}
