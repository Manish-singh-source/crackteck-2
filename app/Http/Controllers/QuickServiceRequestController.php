<?php

namespace App\Http\Controllers;

use App\Models\Engineer;
use App\Models\QuickServiceEngineerAssignment;
use App\Models\QuickServiceGroupEngineer;
use App\Models\QuickServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class QuickServiceRequestController extends Controller
{
    /**
     * Display a listing of quick service requests.
     */
    public function index()
    {
        try {
            $quickServiceRequests = QuickServiceRequest::with([
                'quickService',
                'customer',
                'activeAssignment.engineer',
                'activeAssignment.supervisor',
                'activeAssignment.groupEngineers',
            ])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('crm/quick-service-requests/index', compact('quickServiceRequests'));
        } catch (\Exception $e) {
            Log::error('Quick Service Requests Index Error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Error loading quick service requests: '.$e->getMessage());
        }
    }

    /**
     * Display the specified quick service request.
     */
    public function view($id)
    {
        try {
            $request = QuickServiceRequest::with([
                'quickService',
                'customer',
                'activeAssignment.engineer',
                'activeAssignment.supervisor',
                'activeAssignment.groupEngineers',
                'engineerAssignments.engineer',
                'engineerAssignments.supervisor',
                'engineerAssignments.groupEngineers',
            ])->findOrFail($id);

            $engineers = Engineer::select('id', 'first_name', 'last_name', 'designation', 'department')
                ->orderBy('first_name')
                ->get();

            return view('crm/quick-service-requests/view', compact('request', 'engineers'));
        } catch (\Exception $e) {
            Log::error('Quick Service Request View Error: '.$e->getMessage());

            return redirect()->route('quick-service-requests.index')->with('error', 'Quick Service Request not found.');
        }
    }

    /**
     * Show the form for editing the specified quick service request.
     */
    public function edit($id)
    {
        try {
            $request = QuickServiceRequest::with(['quickService', 'customer'])->findOrFail($id);

            return view('crm/quick-service-requests/edit', compact('request'));
        } catch (\Exception $e) {
            Log::error('Quick Service Request Edit Error: '.$e->getMessage());

            return redirect()->route('quick-service-requests.index')->with('error', 'Quick Service Request not found.');
        }
    }

    /**
     * Update the specified quick service request in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,processing,active,cancel,completed',
            'product_name' => 'nullable|string|max:255',
            'model_no' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:255',
            'hsn' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'issue' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $quickServiceRequest = QuickServiceRequest::findOrFail($id);

            $data = [
                'status' => $request->status,
            ];

            if ($request->filled('product_name')) {
                $data['product_name'] = $request->product_name;
            }
            if ($request->filled('model_no')) {
                $data['model_no'] = $request->model_no;
            }
            if ($request->filled('sku')) {
                $data['sku'] = $request->sku;
            }
            if ($request->filled('hsn')) {
                $data['hsn'] = $request->hsn;
            }
            if ($request->filled('brand')) {
                $data['brand'] = $request->brand;
            }
            if ($request->filled('issue')) {
                $data['issue'] = $request->issue;
            }

            $quickServiceRequest->update($data);

            DB::commit();
            activity()->performedOn($quickServiceRequest)->causedBy(Auth::user())->log('Quick Service Request updated');

            return redirect()->route('service-request.index')->with('success', 'Quick Service Request updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quick Service Request Update Error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Error: '.$e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified quick service request from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $quickServiceRequest = QuickServiceRequest::findOrFail($id);

            activity()->performedOn($quickServiceRequest)->causedBy(Auth::user())->log('Quick Service Request deleted');

            $quickServiceRequest->delete();

            DB::commit();

            return redirect()->route('service-request.index')->with('success', 'Quick Service Request deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quick Service Request Delete Error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Error: '.$e->getMessage());
        }
    }

    /**
     * Assign engineer(s) to Quick Service Request
     */
    public function assignEngineer(Request $request)
    {
        // Remove engineer_id if assignment_type is Group to avoid validation error
        if ($request->assignment_type === 'Group') {
            $request->request->remove('engineer_id');
        }

        $validator = Validator::make($request->all(), [
            'quick_service_request_id' => 'required|exists:quick_service_requests,id',
            'assignment_type' => 'required|in:Individual,Group',
            'engineer_id' => 'required_if:assignment_type,Individual|exists:engineers,id',
            'group_name' => 'required_if:assignment_type,Group',
            'engineer_ids' => 'required_if:assignment_type,Group|array',
            'engineer_ids.*' => 'exists:engineers,id',
            'supervisor_id' => 'required_if:assignment_type,Group|exists:engineers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Deactivate previous assignments
            QuickServiceEngineerAssignment::where('quick_service_request_id', $request->quick_service_request_id)
                ->where('status', 'Active')
                ->update(['status' => 'Inactive']);

            if ($request->assignment_type === 'Individual') {
                // Individual assignment
                $assignment = QuickServiceEngineerAssignment::create([
                    'quick_service_request_id' => $request->quick_service_request_id,
                    'assignment_type' => 'Individual',
                    'engineer_id' => $request->engineer_id,
                    'status' => 'Active',
                    'assigned_at' => now(),
                ]);

                $engineer = Engineer::find($request->engineer_id);
                $message = 'Engineer '.$engineer->first_name.' '.$engineer->last_name.' assigned successfully';
            } else {
                // Group assignment
                $assignment = QuickServiceEngineerAssignment::create([
                    'quick_service_request_id' => $request->quick_service_request_id,
                    'assignment_type' => 'Group',
                    'group_name' => $request->group_name,
                    'supervisor_id' => $request->supervisor_id,
                    'status' => 'Active',
                    'assigned_at' => now(),
                ]);

                // Add group members
                foreach ($request->engineer_ids as $engineerId) {
                    QuickServiceGroupEngineer::create([
                        'assignment_id' => $assignment->id,
                        'engineer_id' => $engineerId,
                        'is_supervisor' => ($engineerId == $request->supervisor_id),
                    ]);
                }

                $message = 'Group "'.$request->group_name.'" assigned successfully with '.count($request->engineer_ids).' engineers';
            }

            DB::commit();

            // Load relationships for response
            $assignment->load(['engineer', 'supervisor', 'groupEngineers']);

            activity()->performedOn($assignment)->causedBy(Auth::user())->log('Engineer assigned to Quick Service Request');

            return response()->json([
                'success' => true,
                'message' => $message,
                'assignment' => $assignment,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quick Service Request Engineer Assignment Error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error: '.$e->getMessage(),
            ], 500);
        }
    }
}
