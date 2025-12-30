<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    protected $fillable = [
        'slug',
        'name',
        'image',
        'status_ecommerce',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    
}
