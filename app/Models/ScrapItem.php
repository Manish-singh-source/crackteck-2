<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScrapItem extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'product_serial_id',
        'serial_number',
        'product_name',
        'product_sku',
        'quantity_scrapped',
        'reason_for_scrap',
        'scrap_notes',
        'photos',
        'scrapped_by',
        'scrapped_at',
    ];

    protected $casts = [
        'photos' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productSerial()
    {
        return $this->belongsTo(ProductSerial::class);
    }
}
