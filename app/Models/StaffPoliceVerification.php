<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffPoliceVerification extends Model
{
    //
    protected $fillable = [
        'staff_id',
        'police_verification',
        'police_verification_status',
        'police_certificate',
    ];
}
