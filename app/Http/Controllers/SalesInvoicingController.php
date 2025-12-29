<?php

namespace App\Http\Controllers;

class SalesInvoicingController extends Controller
{
    //
    public function index()
    {
        return view('/crm/accounts/sales-invoicing/index');
    }

    public function create()
    {
        return view('/crm/accounts/sales-invoicing/create');
    }

    public function view()
    {
        return view('/crm/accounts/sales-invoicing/view');
    }
}
