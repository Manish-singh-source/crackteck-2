<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDealItem extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'product_deal_id',
        'ecommerce_product_id',
        'original_price',
        'discount_type',
        'discount_value',
        'offer_price',
    ];

    public function productDeal()
    {
        return $this->belongsTo(ProductDeal::class);
    }

    public function ecommerceProduct()
    {
        return $this->belongsTo(EcommerceProduct::class);
    }
}
