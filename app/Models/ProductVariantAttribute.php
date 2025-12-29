<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantAttribute extends Model
{
    //
    protected $fillable = [
        'name',
        'status',
    ];

    public function values()
    {
        return $this->hasMany(ProductVariantAttributeValue::class, 'attribute_id');
    }
}
