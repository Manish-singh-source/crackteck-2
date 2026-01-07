<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPanCardDetail extends Model
{
    //

    protected $table = 'customer_pan_card_details';

    protected $fillable = [
        'customer_id',
        'pan_number',
        'pan_card_front_path',
        'pan_card_back_path',
    ];
}
