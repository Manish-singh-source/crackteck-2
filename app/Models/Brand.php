<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Brand extends Model
{
    //
    use LogsActivity, SoftDeletes;

    protected $fillable = [
        'slug',
        'name',
        'image',
        'status_ecommerce',
        'status',
    ];

    // unique slug generation
    public static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            $brand->slug = self::generateUniqueSlug($brand->name);
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }


    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'slug',
                'name',
                'image',
                'status_ecommerce',
                'status',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Brand {$eventName}");
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
