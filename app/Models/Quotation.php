<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'lead_id',
        'staff_id',
        'quote_id',
        'quote_number',
        'quote_date',
        'expiry_date',
        'total_items',
        'currency',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'total_amount',
        'status',
        'terms_conditions',
        'notes',
        'sent_at',
        'accepted_at',
        'quote_document_path',
    ];
    
    public function leadDetails()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(QuotationProduct::class, 'quotation_id', 'id');
    }
}
