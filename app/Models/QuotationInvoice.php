<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationInvoice extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(QuotationInvoiceItem::class);
    }

    public function leadDetails()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }

    public function quoteDetails()
    {
        return $this->belongsTo(Quotation::class, 'quote_id', 'id');
    }
}


