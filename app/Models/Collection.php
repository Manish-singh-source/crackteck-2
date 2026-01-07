<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'title',
        'name',
        'slug',
        'description',
        'image_url',
        'sort_order',
        'status',
        'is_active',
        'products_count',
    ];

    /**
     * Scope for active collections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Get the categories associated with this collection
     */
    public function categories()
    {
        return $this->belongsToMany(ParentCategory::class, 'collection_categories', 'collection_id', 'category_id')
            ->withPivot('sort_order')
            ->withTimestamps();
    }
}
