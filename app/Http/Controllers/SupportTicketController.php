<?php

namespace App\Http\Controllers;

use App\Models\AmcTicket;

class SupportTicketController extends Controller
{
    //
    public function index()
    {
        $amcTickets = AmcTicket::with(['customer', 'amc'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('/crm/support-ticket/index', compact('amcTickets'));
    }

    public function view()
    {
        return view('/crm/support-ticket/view');
    }
}
