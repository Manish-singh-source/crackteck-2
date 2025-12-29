<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    //
    protected $fillable = [
        'parent_category_id',
        'slug',
        'name',
        'image',
        'icon_image',
        'status_ecommerce',
        'status',
    ];
}
