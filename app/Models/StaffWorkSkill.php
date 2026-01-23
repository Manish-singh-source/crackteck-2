<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffWorkSkill extends Model
{
    //
    protected $fillable = [
        'staff_id',
        'primary_skills',
        'certifications',
        'experience',
        'languages_known',
    ];

    protected $casts = [
        'primary_skills' => 'array',
        'languages_known' => 'array',
    ];
}
