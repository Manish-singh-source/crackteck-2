<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAadharDetail extends Model
{
    //
    protected $fillable = [
        'staff_id',
        'aadhar_number',
        'aadhar_front_path',
        'aadhar_back_path',
    ];
}
