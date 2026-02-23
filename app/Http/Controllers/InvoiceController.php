<?php

namespace App\Http\Controllers;

use App\Models\QuotationInvoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //
    public function index()
    {
        $quotationInvoices = QuotationInvoice::with(['leadDetails', 'quoteDetails', 'items', 'customer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('/crm/invoice/index', compact('quotationInvoices'));
    }
}
