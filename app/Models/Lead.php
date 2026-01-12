<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'staff_id',
        'lead_number',
        'first_name',
        'last_name',
        'phone',
        'email',
        'dob',
        'gender',
        'company_name',
        'designation',
        'industry_type',
        'source',
        'requirement_type',
        'budget_range',
        'urgency',
        'status',
        'estimated_value',
        'notes',
    ];

    public function setGenderAttribute($value)
    {
        $map = [
            'male' => '0',
            'female' => '1',
            'other' => '2',
        ];

        $this->attributes['gender'] = is_numeric($value)
            ? $value
            : ($map[strtolower($value)] ?? null);
    }

    public function setSourceAttribute($value)
    {
        $map = [
            'website' => '0',
            'referral' => '1',
            'call' => '2',
            'walk_in' => '3',
            'event' => '4',
        ];

        $this->attributes['source'] = is_numeric($value)
            ? $value
            : ($map[strtolower($value)] ?? null);
    }

    public function setStatusAttribute($value)
    {
        $map = [
            'new' => '0',
            'qualified' => '1',
            'contacted' => '2',
            'converted' => '3',
            'lost' => '4',
        ];

        $this->attributes['status'] = is_numeric($value)
            ? $value
            : ($map[strtolower($value)] ?? null);
    }

    public function setUrgencyAttribute($value)
    {
        $map = [
            'low' => '0',
            'medium' => '1',
            'high' => '2',
            'critical' => '3',
        ];

        $this->attributes['urgency'] = is_numeric($value)
            ? $value
            : ($map[strtolower($value)] ?? null);
    }
}
