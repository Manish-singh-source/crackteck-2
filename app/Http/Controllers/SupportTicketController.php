<?php

namespace App\Http\Controllers;

class SupportTicketController extends Controller
{
    //
    public function index()
    {
        return view('/crm/support-ticket/index');
    }

    public function view()
    {
        return view('/crm/support-ticket/view');
    }
}
