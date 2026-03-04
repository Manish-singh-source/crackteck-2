<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quotation_id',
        'sku',
        'quantity',
        'unit_price',
        'discount_per_unit',
        'tax_rate',
        'line_total',
        'sort_order',

        'name',
        'type',
        'model_no',
        'hsn',
        'purchase_date',
        'brand',
        'description',
        'images',
    ];
}
