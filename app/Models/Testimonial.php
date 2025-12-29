<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'customer_name',
        'customer_image',
        'customer_designation',
        'testimonial_text',
        'rating',
        'source',
        'is_verified',
        'is_featured',
        'is_active',
        'display_order',
    ];
}
