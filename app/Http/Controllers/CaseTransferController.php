<?php

namespace App\Http\Controllers;

use App\Models\CaseTransferRequest;
use App\Models\ServiceRequest;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if ($request->has('search') && ! empty($request->search)) {
            $query->whereHas('serviceRequest', function ($q) use ($request) {
                $q->where('service_request_id', 'like', '%'.$request->search.'%');
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

    public function create(Request $request)
    {
        $serviceRequests = ServiceRequest::with(['customer', 'activeAssignment.engineer'])
            ->whereHas('activeAssignment')
            ->orderByDesc('created_at')
            ->get();

        $engineers = Staff::where('staff_role', 'engineer')
            ->where('status', 'active')
            ->orderBy('first_name')
            ->get();

        $selectedServiceRequest = null;
        if ($request->filled('service_request_id')) {
            $selectedServiceRequest = ServiceRequest::with([
                'customer',
                'amcPlan',
                'products.productType',
                'activeAssignment.engineer',
            ])->whereHas('activeAssignment')->findOrFail($request->service_request_id);
        }

        return view('/crm/case-transfer/create', compact('serviceRequests', 'engineers', 'selectedServiceRequest'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_request_id' => ['required', 'integer', 'exists:service_requests,id'],
            'new_engineer_id' => ['required', 'integer', 'exists:staff,id'],
            'engineer_reason' => ['required', 'string', 'max:2000'],
        ]);

        $serviceRequest = ServiceRequest::with('activeAssignment')->findOrFail($validated['service_request_id']);
        $currentAssignment = $serviceRequest->activeAssignment;
        $newEngineer = Staff::where('id', $validated['new_engineer_id'])
            ->where('staff_role', 'engineer')->where('status', 'active')->first();

        if (! $currentAssignment) {
            return back()->withInput()->withErrors(['service_request_id' => 'This service request has no active engineer assignment.']);
        }
        if (! $newEngineer) {
            return back()->withInput()->withErrors(['new_engineer_id' => 'Please select an active engineer.']);
        }
        if ((int) $currentAssignment->engineer_id === (int) $newEngineer->id) {
            return back()->withInput()->withErrors(['new_engineer_id' => 'Please select an engineer other than the currently assigned engineer.']);
        }
        if (CaseTransferRequest::where('service_request_id', $serviceRequest->id)->where('status', 'pending')->exists()) {
            return back()->withInput()->withErrors(['service_request_id' => 'A transfer request for this service request is already pending.']);
        }

        DB::transaction(function () use ($validated, $serviceRequest, $currentAssignment, $newEngineer) {
            CaseTransferRequest::create([
                'transfer_id' => 'CTR-'.now()->format('YmdHis').'-'.random_int(100, 999),
                'service_request_id' => $serviceRequest->id,
                'requesting_engineer_id' => $currentAssignment->engineer_id,
                'new_engineer_id' => $newEngineer->id,
                'engineer_reason' => $validated['engineer_reason'],
                'status' => 'pending',
            ]);
            $serviceRequest->update(['status' => 'in_transfer']);
        });

        return redirect()->route('case-transfer.index')->with('success', 'Case transfer request created successfully.');
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
            'coveredItems',
        ])->find($id);

        if (! $caseTransfer) {
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

        if (! $caseTransfer) {
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
