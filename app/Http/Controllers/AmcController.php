<?php

namespace App\Http\Controllers;

use App\Models\Amc;
use App\Models\AmcPlan;
use App\Models\CoveredItem;
use App\Models\DeviceSpecificDiagnosis;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AmcController extends Controller
{
    //
    public function index()
    {
        $amcPlans = AmcPlan::query();
        if ($status = request()->get('status')) {
            $amcPlans->where('status', $status);
        }
        $amcPlans = $amcPlans->get();

        $coveredItems = CoveredItem::all();

        return view('/crm/amc-plans/index', compact('amcPlans', 'coveredItems'));
    }

    public function create()
    {
        $coveredItems = CoveredItem::where('status', 'active')
            ->orderBy('service_type')
            ->orderBy('service_name')
            ->get();
        return view('/crm/amc-plans/create', compact('coveredItems'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_name' => 'required|string|max:255',
            'plan_code' => 'required',
            'description' => 'nullable|string|max:255',
            'duration' => 'required|numeric|min:1',
            'total_visits' => 'required|numeric|min:1',
            'plan_cost' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'pay_terms' => 'required|string|max:255',
            'support_type' => 'required|string|max:255',
            'tandc' => 'nullable|string|max:255',
            'replacement_policy' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $amc = new AmcPlan;
            $amc->plan_name = $request->plan_name;
            $amc->plan_code = $request->plan_code;
            $amc->description = $request->description;
            $amc->duration = $request->duration;
            $amc->total_visits = $request->total_visits;
            $amc->plan_cost = $request->plan_cost;
            $amc->tax = $request->tax;
            $amc->total_cost = $request->total_cost;
            $amc->pay_terms = $request->pay_terms;
            $amc->support_type = $request->support_type;
            $amc->covered_items = $request->covered_items_ids ?? [];

            if ($request->hasFile('brochure')) {
                $file = $request->file('brochure');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/amc/brochure'), $filename);
                $amc->brochure = 'uploads/crm/amc/brochure/' . $filename;
            }

            $amc->tandc = $request->tandc;
            $amc->replacement_policy = $request->replacement_policy;
            $amc->status = $request->status;

            $amc->save();

            return redirect()->route('amc-plans.index')->with('success', 'AMC Plan added successfully.');
        } catch (\Exception $e) {
            Log::error('AMC Plan Store Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating AMC Plan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $amcPlan = AmcPlan::findOrFail($id);
        $coveredItems = CoveredItem::where('status', 'active')
            ->orderBy('service_type')
            ->orderBy('service_name')
            ->get();

        // Normalize covered_items to array
        $selectedCoveredItems = [];

        if (is_string($amcPlan->covered_items)) {
            $decoded = json_decode($amcPlan->covered_items, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $selectedCoveredItems = $decoded;
            }
        } elseif (is_array($amcPlan->covered_items)) {
            $selectedCoveredItems = $amcPlan->covered_items;
        }

        return view('/crm/amc-plans/edit', compact('amcPlan', 'coveredItems', 'selectedCoveredItems'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'plan_name' => 'required|string|max:255',
            'plan_code' => 'required',
            'description' => 'nullable|string|max:255',
            'duration' => 'required|numeric|min:1',
            'total_visits' => 'required|numeric|min:1',
            'plan_cost' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'pay_terms' => 'required|string|max:255',
            'support_type' => 'required|string|max:255',
            'tandc' => 'nullable|string|max:255',
            'replacement_policy' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $amc = AmcPlan::findOrFail($id);

            $amc->plan_name = $request->plan_name;
            $amc->plan_code = $request->plan_code;
            $amc->description = $request->description;
            $amc->duration = $request->duration;          // already months from form
            $amc->total_visits = $request->total_visits;
            $amc->plan_cost = $request->plan_cost;
            $amc->tax = $request->tax;
            $amc->total_cost = $request->total_cost;
            $amc->pay_terms = $request->pay_terms;
            $amc->support_type = $request->support_type;

            // covered_items_ids: JSON string of IDs from hidden input
            $coveredIds = [];
            if ($request->filled('covered_items_ids')) {
                $decoded = json_decode($request->input('covered_items_ids'), true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $coveredIds = array_values(
                        array_filter(
                            array_map('intval', $decoded),
                            fn($id) => $id > 0
                        )
                    );
                }
            }
            $amc->covered_items = json_encode($coveredIds);

            // Brochure upload (replace old if new uploaded)
            if ($request->hasFile('brochure')) {
                // optionally delete old file
                if ($amc->brochure && file_exists(public_path($amc->brochure))) {
                    @unlink(public_path($amc->brochure));
                }

                $file = $request->file('brochure');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/amc/brochure'), $filename);
                $amc->brochure = 'uploads/crm/amc/brochure/' . $filename;
            }

            $amc->tandc = $request->tandc;
            $amc->replacement_policy = $request->replacement_policy;
            $amc->status = $request->status;

            $amc->save();

            return redirect()
                ->route('amc-plans.index')
                ->with('success', 'AMC Plan updated successfully.');
        } catch (\Exception $e) {
            Log::error('AMC Plan Update Error: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Error updating AMC Plan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function delete($id)
    {
        $amc = AmcPlan::findOrFail($id);
        $amc->delete();

        return redirect()->route('amc-plans.index')->with('success', 'AMC Plan deleted successfully.');
    }



    public function coveredItems()
    {
        $coveredItems = CoveredItem::query();

        if ($status = request()->get('status')) {
            $coveredItems->where('status', $status);
        }

        $coveredItems = $coveredItems->get();

        return view('/crm/amc-plans/covered-items/index', compact('coveredItems'));
    }

    public function createCoveredItems()
    {
        $deviceSpecificDiagnosis = DeviceSpecificDiagnosis::where('status', 'active')
            ->orderBy('device_type')
            ->get();
        return view('/crm/amc-plans/covered-items/create', compact('deviceSpecificDiagnosis'));
    }

    public function storeCoveredItems(Request $request)
    {
        // 1) Validate input
        $validated = $request->validate([
            'service_type' => 'required|in:amc,quick_service,installation,repair',
            'service_name' => 'required|string|max:255',
            // service_charge required only when type is NOT 0 (AMC)
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'service_charge' => 'nullable|numeric|min:0|required_unless:service_type,0',
            'status' => 'nullable|in:active,inactive',
            'diagnosis_list' => 'nullable|string', // JSON string from hidden field
            'device_specific_diagnosis_id' => 'nullable|exists:device_specific_diagnoses,id',
        ]);

        try {
            DB::beginTransaction();

            $data = $validated;


            // Default status = Active (1) if not sent
            $data['status'] = $request->input('status', 'active');

            // Decode diagnosis_list JSON to array and clean it
            $diagnosis = [];
            if ($request->filled('diagnosis_list')) {
                $raw = $request->input('diagnosis_list');
                $decoded = json_decode($raw, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $diagnosis = array_values(array_filter($decoded));
                }
            }

            // 
            // Handle image upload
            $filePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_covered_item.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/covered-items'), $filename);
                $filePath = 'uploads/crm/covered-items/' . $filename;
            }

            // Create record (CoveredItem model with JSON cast for diagnosis_list)
            $coveredItem = CoveredItem::create([
                'item_code' => CoveredItem::generateItemCode($data['service_type']),
                'service_type' => $data['service_type'],            // 0,1,2,3
                'image' => $filePath,
                'service_name' => $data['service_name'],
                'service_charge' => $data['service_type'] === 'amc'
                    ? null
                    : ($data['service_charge'] ?? null),
                'status' => $data['status'],                 // 0/1
                'diagnosis_list' => $diagnosis,                      // array, casted as JSON
                'device_specific_diagnosis_id' => $data['device_specific_diagnosis_id'] ?? null,
            ]);

            if (!$coveredItem) {
                DB::rollBack();

                return redirect()
                    ->back()
                    ->with('error', 'An error occurred while creating the service.')
                    ->withInput();
            }

            DB::commit();

            return redirect()
                ->route('covered-items.index')
                ->with('success', 'Service created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Error creating covered item: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'An error occurred while creating the service: ' . $e->getMessage(),
                ]);
        }
    }

    public function editCoveredItems($id)
    {
        $coveredItem = CoveredItem::findOrFail($id);
        $deviceSpecificDiagnosis = DeviceSpecificDiagnosis::where('status', 'active')
            ->orderBy('device_type')
            ->get();
        return view('/crm/amc-plans/covered-items/edit', compact('coveredItem', 'deviceSpecificDiagnosis'));
    }

    public function updateCoveredItems(Request $request, $id)
    {
        // 1) Validate input
        $validated = $request->validate([
            'service_type' => 'required|in:amc,quick_service,installation,repair',
            'service_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'service_charge' => 'nullable|numeric|min:0|required_unless:service_type,0',
            'status' => 'nullable|in:active,inactive',
            'diagnosis_list' => 'nullable|string',
            'device_specific_diagnosis_id' => 'nullable|exists:device_specific_diagnoses,id',
        ]);

        $coveredItem = CoveredItem::findOrFail($id);

        $data = $validated;
        $data['status'] = $request->input('status', 'active');

        // Decode diagnosis_list JSON to array and clean it
        $diagnosis = [];
        if ($request->filled('diagnosis_list')) {
            $raw = $request->input('diagnosis_list');
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $diagnosis = array_values(array_filter($decoded));
            }
        }

        // Handle image upload
        $filePath = $coveredItem->image; // keep existing if no new upload
        if ($request->hasFile('image')) {
            if ($coveredItem->image && File::exists(public_path($coveredItem->image))) {
                File::delete(public_path($coveredItem->image));
            }

            $file = $request->file('image');
            $filename = time() . '_covered_item.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/crm/covered-items'), $filename);
            $filePath = 'uploads/crm/covered-items/' . $filename;
        }

        $coveredItem->update([
            'service_type' => $data['service_type'],
            'image' => $filePath,
            'service_name' => $data['service_name'],
            'service_charge' => $data['service_type'] === 'amc'
                ? null
                : ($data['service_charge'] ?? null),
            'status' => $data['status'],
            'diagnosis_list' => $diagnosis,
            'device_specific_diagnosis_id' => $data['device_specific_diagnosis_id'] ?? null,
        ]);

        return redirect()
            ->route('covered-items.index')
            ->with('success', 'Service updated successfully.');
    }

    public function deleteCoveredItems($id)
    {
        $coveredItem = CoveredItem::findOrFail($id);
        $coveredItem->delete();

        return redirect()->route('covered-items.index')->with('success', 'Covered Item deleted successfully.');
    }


    // Device Specific Diagnosis methods will be similar to Covered Items, but using DeviceSpecificDiagnosis model and views
    public function deviceSpecificDiagnosis()
    {
        $query = DeviceSpecificDiagnosis::query();

        if ($status = request()->get('status')) {
            if (in_array($status, ['active', 'inactive'])) {
                $query->where('status', $status);
            }
        }

        $diagnosis = $query->get();

        return view('/crm/amc-plans/device-specific-diagnosis/index', compact('diagnosis'));
    }

    public function createDeviceSpecificDiagnosis()
    {
        return view('/crm/amc-plans/device-specific-diagnosis/create');
    }

    public function storeDeviceSpecificDiagnosis(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'device_type' => 'required|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'diagnosis_list' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            return redirect()
                ->back()
                ->withErrors($validated)
                ->withInput();
        }

        $validated = $validated->validated();

        $diagnosis = DeviceSpecificDiagnosis::create([
            'device_type' => $validated['device_type'],
            'status' => $request->input('status', 'active'),
            'diagnosis_list' => $request->input('diagnosis_list') ? json_decode($request->input('diagnosis_list'), true) : [],
        ]);

        if (!$diagnosis) {
            return redirect()
                ->back()
                ->with('error', 'An error occurred while creating the diagnosis.')
                ->withInput();
        }

        return redirect()
            ->route('device-specific-diagnosis.index')
            ->with('success', 'Diagnosis created successfully.');
    }

    public function editDeviceSpecificDiagnosis($id)
    {
        $diagnosis = DeviceSpecificDiagnosis::findOrFail($id);
        return view('/crm/amc-plans/device-specific-diagnosis/edit', compact('diagnosis'));
    }

    public function updateDeviceSpecificDiagnosis(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'device_type' => 'required|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'diagnosis_list' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            return redirect()
                ->back()
                ->withErrors($validated)
                ->withInput();
        }

        $validated = $validated->validated();

        $diagnosis = DeviceSpecificDiagnosis::findOrFail($id);

        $diagnosis->update([
            'device_type' => $validated['device_type'],
            'status' => $request->input('status', 'active'),
            'diagnosis_list' => $request->input('diagnosis_list') ? json_decode($request->input('diagnosis_list'), true) : [],
        ]);

        return redirect()
            ->route('device-specific-diagnosis.index')
            ->with('success', 'Diagnosis updated successfully.');
    }

    public function deleteDeviceSpecificDiagnosis($id)
    {
        $diagnosis = DeviceSpecificDiagnosis::findOrFail($id);
        $diagnosis->delete();

        return redirect()
            ->route('device-specific-diagnosis.index')
            ->with('success', 'Diagnosis deleted successfully.');
    }

    /**
     * Fetch diagnoses for a specific device type via AJAX
     */
    public function getDiagnosisList($id)
    {
        try {
            $deviceDiagnosis = DeviceSpecificDiagnosis::findOrFail($id);

            return response()->json([
                'success' => true,
                'device_type' => $deviceDiagnosis->device_type,
                'diagnosis_list' => $deviceDiagnosis->diagnosis_list ?? [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Device diagnosis not found',
            ], 404);
        }
    }




    // AMC of customers 

    // 1. List AMC requests (with filters)
    public function listAmcRequests(Request $request)
    {
        $query = Amc::query();

        if ($request->filled('customer_name')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer_name . '%');
            });
        }

        if ($request->filled('plan_id')) {
            $query->where('amc_plan_id', $request->plan_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $amcRequests = $query->with(['customer', 'amcPlan', 'amcProducts'])->get();

        return view('/crm/active-amcs/index', compact('amcRequests'));
    }

    // 2. Delete AMC request (if needed)
    public function deleteAmcsRequest($id)
    {
        $amcRequest = Amc::findOrFail($id);
        $amcRequest->delete();

        return redirect()->route('active-amcs.index')->with('success', 'AMC Request deleted successfully.');
    }

    // 3. View AMC request details
    public function viewAmcsRequest($id)
    {
        $amcRequest = Amc::with([
            'customer',
            'customerAddress',
            'amcPlan',
            'amcProducts'
        ])->findOrFail($id);

        $engineers = Staff::where('staff_role', 'engineer')->where('status', 'active')->get();

        return view('/crm/active-amcs/view', compact('amcRequest', 'engineers'));
    }
}
