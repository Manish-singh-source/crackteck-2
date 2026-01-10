<?php

namespace App\Http\Controllers;

use App\Models\AssignedEngineer;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Validator;

class FieldEngineerController extends Controller
{
    public function serviceRequests(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $serviceRequests = ServiceRequest::with(['customer', 'products'])
            ->whereHas('activeAssignment', function ($query) use ($request) {
                $query->where('engineer_id', $request->user_id);
            })
            ->where('is_engineer_assigned', '1')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['serviceRequests' => $serviceRequests], 200);

    }

    public function serviceRequestDetails(Request $request, $id)
    {
        $serviceRequest = ServiceRequest::with([
            'customer',
            'customerAddress',
            'customerCompany',
            'products',
        ])->findOrFail($id);

        // Get active assignment
        $activeAssignment = AssignedEngineer::with(['engineer', 'groupEngineers'])
            ->where('service_request_id', $id)
            ->where('status', '0')
            ->first();

        return response()->json(['serviceRequest' => $serviceRequest, 'activeAssignment' => $activeAssignment], 200);
    }
}
