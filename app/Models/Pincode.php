<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    //
    protected $fillable = [
        'pincode',
        'delivery',
        'installation',
        'repair',
        'quick_service',
        'amc',
    ];
}
