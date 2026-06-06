<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ParentCategory extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'name',
        'image',
        'sort_order',
        'status_ecommerce',
        'status',
    ];

    // unique slug generation
    public static function boot()
    {
        parent::boot();

        static::creating(function ($parentCategory) {
            $parentCategory->slug = self::generateUniqueSlug($parentCategory->name);
        });
    }
    
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

    private static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = self::where('slug', 'LIKE', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}

