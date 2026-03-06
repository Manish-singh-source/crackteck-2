<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\QuotationInvoice;
use App\Models\ServiceRequestQuotation;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //
    public function index()
    {
        $quotationInvoices = QuotationInvoice::with(['leadDetails', 'quoteDetails', 'items', 'customer'])
            ->orderBy('created_at', 'desc')
            ->get();

        $ecommerceOrders = Order::with(['customer', 'orderItems', 'orderPayments'])
            ->orderBy('created_at', 'desc')
            ->get();

        $serviceRequestQuotations = ServiceRequestQuotation::with(['serviceRequest', 'billingAddress', 'shippingAddress'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('/crm/invoice/index', compact('quotationInvoices', 'ecommerceOrders', 'serviceRequestQuotations'));
    }

    //
    public function viewServiceRequestInvoice($id)
    {
        $quotation = ServiceRequestQuotation::with([
            'serviceRequest.customer',
            'serviceRequest.products',
            'serviceRequest.products.requestParts' => function($query) {
                $query->where('status', 'used');
            },
            'serviceRequest.products.requestParts.product',
            'billingAddress',
            'shippingAddress'
        ])
            ->findOrFail($id);

        return view('/crm/invoice/service-request-invoice', compact('quotation'));
    }
}
