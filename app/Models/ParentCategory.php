<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentCategory extends Model
{
    //
    protected $fillable = [
        'slug',
        'name',
        'image',
        'sort_order',
        'status_ecommerce',
        'status',
    ];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'parent_category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'parent_category_id');
    }
    
    public function ecommerceProducts()
    {
        return $this->hasMany(EcommerceProduct::class, 'parent_category_id');
    }
}
