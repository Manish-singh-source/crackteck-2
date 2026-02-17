<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceSpecificDiagnosis extends Model
{
    //

    protected $table = 'device_specific_diagnoses';

    protected $fillable = [
        'device_type',
        'diagnosis_list',
        'status',
    ];

    protected $casts = [
        'diagnosis_list' => 'array',
    ];
}
