<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class TrackRequestController extends Controller
{
    public function index()
    {
        return view('/crm/track-request/index');
    }

    public function track(Request $request)
    {
        $serviceId = $request->input('service_id');
        $serviceRequest = ServiceRequest::where('request_id', $serviceId)
            ->with(['customer.companyDetails', 'customer.primaryAddress', 'assignedEngineers.engineer', 'products'])
            ->first();

        return view('/crm/track-request/index', compact('serviceRequest'));
    }
}
