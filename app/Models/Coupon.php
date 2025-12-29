<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'description',
        'type',
        'discount_value',
        'max_discount',
        'min_purchase_amount',
        'start_date',
        'end_date',
        'usage_limit',
        'usage_per_customer',
        'is_active',
        'applicable_categories',
        'applicable_brands',
        'excluded_products',
        'stackable',
    ];

    protected $casts = [
        'applicable_categories' => 'array',
        'applicable_brands' => 'array',
        'excluded_products' => 'array',
    ];
}
