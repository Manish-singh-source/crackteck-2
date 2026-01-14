<?php

namespace App\Http\Controllers;

use App\Models\StockInHand;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\AssignedEngineer;
use App\Models\StockInHandProduct;
use App\Models\CaseTransferRequest;
use App\Models\ServiceRequestProduct;
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
            ->where('is_engineer_assigned', 'assigned')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['serviceRequests' => $serviceRequests], 200);

    }

    public function serviceRequestDetails(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
        ]);
        
        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $serviceRequest = ServiceRequest::with([
            'customer',
            'customerAddress',
            'customerCompany',
            'products',
        ])->findOrFail($id);

        // Get active assignment
        $activeAssignment = AssignedEngineer::with(['engineer', 'groupEngineers'])
            ->where('service_request_id', $id)
            ->where('status', 'active')
            ->first();

        return response()->json(['serviceRequest' => $serviceRequest, 'activeAssignment' => $activeAssignment], 200);
    }

    public function serviceRequestProductDetails(Request $request, $id, $product_id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        
        $serviceRequestProduct = ServiceRequestProduct::with(['itemCode'])
            ->where('service_requests_id', $id)
            ->where('id', $product_id)
            ->first();

        return response()->json(['serviceRequestProduct' => $serviceRequestProduct], 200);
    }

    public function acceptServiceRequest(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        
        $serviceRequest = ServiceRequest::findOrFail($id);

        // Update service request status to In Progress (status = 3)
        $serviceRequest->status = 'engineer_approved';
        $serviceRequest->save();

        return response()->json(['message' => 'Service request accepted successfully.'], 200);
    }

    public function caseTransfer(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
            'engineer_reason' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        // return response()->json(['message' => 'Case transfer API is working.', 'id' => $id, 'request' => $validated], 200);
        
        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->is_engineer_assigned = 'not_assigned';
        $serviceRequest->status = 'in_transfer';
        $serviceRequest->save();

        // Create case transfer request
        $caseTransferRequest = CaseTransferRequest::create([
            'transfer_id' => 'CTR-' . date('Ymd') . '-' . random_int(100, 999),
            'service_request_id' => $id,
            'requesting_engineer_id' => $validated['user_id'],
            'engineer_reason' => $validated['engineer_reason'],
        ]);

        if (! $caseTransferRequest) {
            return response()->json(['success' => false, 'message' => 'Failed to create case transfer request.'], 500);
        }

        return response()->json(['message' => 'Case transfer request created successfully.'], 200);
    }

    public function rescheduleServiceRequest(Request $request, $id)
    {   
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
            'reschedule_date' => 'required|date',
            'engineer_reason' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }   

        $validated = $validated->validated();

        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->request_date = $validated['reschedule_date'];
        $serviceRequest->save();

        if(!$serviceRequest){
            return response()->json(['success' => false, 'message' => 'Failed to reschedule service request.'], 500);
        }

        return response()->json(['message' => 'Service request rescheduled successfully.'], 200);
    }

    public function diagnosisList(Request $request, $id, $product_id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        
        $serviceRequestProduct = ServiceRequestProduct::with(['itemCode'])
            ->where('service_requests_id', $id)
            ->where('id', $product_id)
            ->first();

        $diagnosisList = $serviceRequestProduct->itemCode->diagnosis_list;

        return response()->json(['diagnosisList' => $diagnosisList], 200);
    }

    public function submitDiagnosis(Request $request, $id, $product_id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
            'diagnosis_list' => 'required|array',
            'diagnosis_notes' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        
        $serviceRequestProduct = ServiceRequestProduct::with(['itemCode'])
            ->where('service_requests_id', $id)
            ->where('id', $product_id)
            ->first();

        // TODO: Save diagnosis details 
        // diagnosis photos 
        // diagnosis videos 
        // diagnosis notes 
        // diagnosis report 
        // after photos 
        // before photos 
        // completed at 

        return response()->json(['message' => 'Diagnosis submitted successfully.'], 200);
    }

    public function stockInHand(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        
        // $stockInHandProducts = StockInHand::with(['products'])->where('engineer_id', $validated['user_id'])->get();
        $stockInHandProducts = StockInHandProduct::with(['product', 'stockInHand' => function($query) use ($validated) {
            return $query->where('engineer_id', $validated['user_id']);
        }])->get();

        if (!$stockInHandProducts) {
            return response()->json(['success' => false, 'message' => 'No stock in hand products found.'], 404);
        }

        return response()->json(['stockInHandProducts' => $stockInHandProducts], 200);

    }

    public function requestPart(Request $request, $id, $product_id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
            'part_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        
        // TODO: Request part logic 
        // 1. Check if part is in stock 
        // 2. If part is in stock then reduce quantity from stock in hand 
        // 3. If part is not in stock then request from warehouse 
        // 4. Create request part entry 

        return response()->json(['message' => 'Request part API is working.'], 200);
    }
}
