<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'parent_category_id',
        'slug',
        'name',
        'image',
        'icon_image',
        'status_ecommerce',
        'status',
    ];

    // unique slug generation
    public static function boot()
    {
        parent::boot();

        static::creating(function ($subCategory) {
            $subCategory->slug = self::generateUniqueSlug($subCategory->name);
        });
    }

    private static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = self::withTrashed()
            ->where('slug', 'LIKE', "{$slug}%")
            ->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
