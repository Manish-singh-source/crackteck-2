<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationInvoiceItem extends Model
{
    protected $fillable = [
        'quotation_invoice_id',
        'quotation_products_id',
        'name',
        'type',
        'model_no',
        'sku',
        'hsn',
        'purchase_date',
        'brand',
        'description',
        'images',
        'quantity',
        'unit_price',
        'discount_per_unit',
        'tax_rate',
        'tax_amount',
        'line_subtotal',
        'line_total',
    ];
}
