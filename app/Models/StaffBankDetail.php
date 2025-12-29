<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffBankDetail extends Model
{
    //
    protected $fillable = [
        'staff_id',
        'bank_acc_holder_name',
        'bank_acc_number',
        'bank_name',
        'ifsc_code',
        'passbook_pic',
    ];
}
