<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffVehicleDetail extends Model
{
    //
    protected $fillable = [
        'staff_id',
        'vehicle_type',
        'vehicle_number',
        'driving_license_no',
        'driving_license_front_path',
        'driving_license_back_path',
    ];
}
