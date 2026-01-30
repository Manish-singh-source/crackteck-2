<?php

namespace App\Http\Controllers;

use App\Models\CaseTransferRequest;
use Illuminate\Http\Request;

class CaseTransferController extends Controller
{
    public function index(Request $request)
    {
        $query = CaseTransferRequest::with(['serviceRequest', 'requestingEngineer']);

        // Filter by status for tabs
        $status = $request->get('status');
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // Search by service request ID
        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('serviceRequest', function ($q) use ($request) {
                $q->where('service_request_id', 'like', '%' . $request->search . '%');
            });
        }

        // Sort
        if ($request->has('sort')) {
            if ($request->sort == 'service_id') {
                $query->join('service_requests', 'case_transfer_requests.service_request_id', '=', 'service_requests.id')
                      ->orderBy('service_requests.service_request_id');
            } elseif ($request->sort == 'time') {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $caseTransferRequests = $query->paginate(10);

        return view('/crm/case-transfer/index', compact('caseTransferRequests'));
    }

    public function create()
    {
        return view('/crm/case-transfer/create');
    }

    public function view(Request $request, $id)
    {
        // Fetch the case transfer with relationships
        $caseTransfer = CaseTransferRequest::with([
            'serviceRequest.customer',
            'serviceRequest.customerAddress',
            'serviceRequest.customerCompany',
            'serviceRequest.customerPan',
            'serviceRequest.products.itemCode',
            'requestingEngineer',
            'engineer',
            'coveredItems'
        ])->find($id);

        if (!$caseTransfer) {
            return redirect()->back()->with('error', 'Case Transfer not found');
        }

        // Extract related data
        $serviceRequest = $caseTransfer->serviceRequest;
        $customer = $serviceRequest->customer ?? null;
        $customerAddress = $serviceRequest->customerAddress ?? null;
        $customerCompany = $serviceRequest->customerCompany ?? null;
        $customerPan = $serviceRequest->customerPan ?? null;
        $products = $serviceRequest->products ?? collect();

        // Fetch active engineers
        $engineers = \App\Models\Staff::where('staff_role', 'engineer')->where('status', 'active')->get();

        return view('/crm/case-transfer/view', compact(
            'caseTransfer',
            'serviceRequest',
            'customer',
            'customerAddress',
            'customerCompany',
            'customerPan',
            'products',
            'engineers'
        ));
    }

    public function approve(Request $request, $id)
    {
        $caseTransfer = CaseTransferRequest::find($id);

        if (!$caseTransfer) {
            return response()->json(['success' => false, 'message' => 'Case Transfer not found'], 404);
        }

        // Update case transfer status to approved
        $caseTransfer->status = 'approved';
        $caseTransfer->admin_reason = request('admin_reason');
        $caseTransfer->approved_at = now();
        $caseTransfer->save();

        // Update service request status to admin_approved
        $serviceRequest = $caseTransfer->serviceRequest;
        if ($serviceRequest) {
            $serviceRequest->status = 'admin_approved';
            $serviceRequest->save();
        }

        return response()->json(['success' => true, 'message' => 'Case transfer approved successfully']);
    }
}
