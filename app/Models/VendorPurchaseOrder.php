<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorPurchaseOrder extends Model
{
    //

    protected $fillable = [
        'vendor_id',
        'po_number',
        'invoice_number',
        'invoice_pdf',
        'purchase_date',
        'po_amount_due_date',
        'po_amount',
        'po_amount_paid',
        'po_amount_pending',
        'po_status',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
