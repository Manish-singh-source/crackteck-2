<?php

namespace App\Http\Controllers;

class InHandProductController extends Controller
{
    //
    public function index()
    {
        return view('/crm/assign-products/index');
    }

    public function view()
    {
        return view('/crm/assign-products/view');
    }
}
