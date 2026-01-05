<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuotationProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quotation_id',
        'product_name',
        'hsn_code',
        'sku',
        'product_description',
        'quantity',
        'unit_price',
        'discount_per_unit',
        'tax_rate',
        'line_total',
        'sort_order',
    ];
}
