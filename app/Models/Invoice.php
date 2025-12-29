<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'customer_id',
        'invoice_number',
        'invoice_id',
        'invoice_date',
        'due_date',
        'currency',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'total_amount',
        'paid_amount',
        'status',
        'notes',
        'invoice_document_path',
        'sent_at',
        'viewed_at',
        'paid_at',
    ];
}
