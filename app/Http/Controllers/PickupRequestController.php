<?php

namespace App\Http\Controllers;

class PickupRequestController extends Controller
{
    //
    public function index()
    {
        return view('/crm/pickup-requests/index');
    }

    public function view()
    {
        return view('/crm/pickup-requests/view');
    }
}
