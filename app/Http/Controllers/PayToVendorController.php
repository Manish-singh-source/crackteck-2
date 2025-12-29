<?php

namespace App\Http\Controllers;

class PayToVendorController extends Controller
{
    //
    public function index()
    {
        return view('/crm/accounts/payments-to-vendors/index');
    }

    public function create()
    {
        return view('/crm/accounts/payments-to-vendors/create');
    }
}
