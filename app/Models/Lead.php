<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
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
}
