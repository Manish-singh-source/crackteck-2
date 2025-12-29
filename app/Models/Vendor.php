<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    //
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'pincode',
        'pan_no',
        'gst_no',
        'status',
        'created_by',
    ];
}
