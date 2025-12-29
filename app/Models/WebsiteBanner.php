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
}
