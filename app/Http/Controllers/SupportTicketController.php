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

    public function view($id)
    {
        $amcTicket = AmcTicket::with(['customer', 'amc'])->findOrFail($id);

        return view('/crm/support-ticket/view', compact('amcTicket'));
    }
}
