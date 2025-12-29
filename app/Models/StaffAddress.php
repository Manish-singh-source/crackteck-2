<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAddress extends Model
{
    //
    protected $fillable = [
        'staff_id',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'pincode',
    ];
}
