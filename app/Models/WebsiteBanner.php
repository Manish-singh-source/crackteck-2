<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebsiteBanner extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image_url',
        'type',
        'channel',
        'promotion_type',
        'discount_value',
        'discount_type',
        'promo_code',
        'link_url',
        'link_target',
        'position',
        'display_order',
        'start_at',
        'end_at',
        'is_active',
        'click_count',
        'view_count',
        'metadata',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_active' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Scope for active banners
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Scope for inactive banners
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', 0);
    }

    /**
     * Scope for website banners (type = 0)
     */
    public function scopeWebsite($query)
    {
        return $query->where('type', '0');
    }

    /**
     * Scope for promotional banners (type = 1)
     */
    public function scopePromotional($query)
    {
        return $query->where('type', '1');
    }
}
