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

    public function leadDetails()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }

    public function staffDetails()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
