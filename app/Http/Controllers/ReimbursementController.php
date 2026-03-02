<?php

namespace App\Http\Controllers;

use App\Models\ReturnOrder;
use Illuminate\Http\Request;

class ReimbursementController extends Controller
{
    //
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = ReturnOrder::with('customer');
        
        if ($status !== 'all') {
            $query->where('refund_status', $status);
        }
        
        $returnOrders = $query->orderBy('created_at', 'desc')->get();
        
        return view('/crm/accounts/reimbursement', compact('returnOrders', 'status'));
    }
}
