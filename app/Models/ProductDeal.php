<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDeal extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'deal_title',
        'offer_start_date',
        'offer_end_date',
        'status',
    ];

    public function dealItems()
    {
        return $this->hasMany(ProductDealItem::class);
    }
}
