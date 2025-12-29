<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAadharDetail extends Model
{
    //

    protected $fillable = [
        'customer_id',
        'aadhar_number',
        'aadhar_front_path',
        'aadhar_back_path',
    ];
}
