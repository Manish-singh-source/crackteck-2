<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffPanCardDetail extends Model
{
    //
    protected $fillable = [
        'staff_id',
        'pan_number',
        'pan_card_front_path',
        'pan_card_back_path',
    ];
}
