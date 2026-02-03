<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequestProductPickup;
use Illuminate\Support\Facades\DB;

class PickupRequestController extends Controller
{
    public function index()
    {
        $status = request()->get('status', 'all');
        
        $query = ServiceRequestProductPickup::with([
            'serviceRequestProduct',
            'serviceRequest',
            'assignedPerson',
            'assignedEngineer.engineer'
        ])->whereHas('serviceRequest');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $pickups = $query->orderBy('created_at', 'desc')->get();

        return view('/crm/pickup-requests/index', compact('pickups'));
    }

    public function view($id)
    {
        $pickup = ServiceRequestProductPickup::with([
            'serviceRequestProduct',
            'serviceRequest.customer',
            'assignedPerson',
            'assignedEngineer.engineer'
        ])->findOrFail($id);

        return view('/crm/pickup-requests/view', compact('pickup'));
    }
}
