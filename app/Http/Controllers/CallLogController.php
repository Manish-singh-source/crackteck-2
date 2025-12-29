<?php

namespace App\Http\Controllers;

class CallLogController extends Controller
{
    //
    public function index()
    {
        return view('/crm/call-logs/index');
    }

    public function view()
    {
        return view('/crm/call-logs/view');
    }
}
