<?php

namespace App\Http\Controllers;

use App\Models\AMC;
use App\Models\AmcPlan;
use App\Models\CoveredItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AmcController extends Controller
{
    //
    public function index()
    {
        $amcPlans = AmcPlan::all();
        $coveredItems = CoveredItem::all();

        return view('/crm/amc-plans/index', compact('amcPlans', 'coveredItems'));
    }

    public function create()
    {
        $coveredItems = CoveredItem::all();
        // dd($coveredItems);
        return view('/crm/amc-plans/create', compact('coveredItems'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_name' => 'required',
            'plan_code' => 'required',
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
            $amc->covered_items = json_encode($request->covered_items_ids) ?? [];

            if ($request->hasFile('brochure')) {
                $file = $request->file('brochure');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/amc/brochure'), $filename);
                $amc->brochure = 'uploads/crm/amc/brochure/'.$filename;
            }

            $amc->tandc = $request->tandc;
            $amc->replacement_policy = $request->replacement_policy;
            $amc->status = $request->status;

            $amc->save();

            return redirect()->route('amc-plans.index')->with('success', 'AMC Plan added successfully.');
        } catch (\Exception $e) {
            Log::error('AMC Plan Store Error: '.$e->getMessage());
            return redirect()->back()->with('error', 'Error creating AMC Plan: '.$e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $amcPlan = AmcPlan::findOrFail($id);
        $coveredItems = CoveredItem::all();

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
            'plan_name' => 'required',
            'plan_code' => 'required',
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
                            fn ($id) => $id > 0
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
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/amc/brochure'), $filename);
                $amc->brochure = 'uploads/crm/amc/brochure/'.$filename;
            }

            $amc->tandc = $request->tandc;
            $amc->replacement_policy = $request->replacement_policy;
            $amc->status = $request->status;

            $amc->save();

            return redirect()
                ->route('amc-plans.index')
                ->with('success', 'AMC Plan updated successfully.');
        } catch (\Exception $e) {
            Log::error('AMC Plan Update Error: '.$e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Error updating AMC Plan: '.$e->getMessage())
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
        return view('/crm/amc-plans/covered-items/create');
    }

    public function storeCoveredItems(Request $request)
    {
        // 1) Validate input
        $validated = $request->validate([
            'service_type' => 'required|in:amc,quick_service,installation,repair',
            'service_name' => 'required|string|max:255',
            // service_charge required only when type is NOT 0 (AMC)
            'service_charge' => 'nullable|numeric|min:0|required_unless:service_type,0',
            'status' => 'nullable|in:active,inactive',
            'diagnosis_list' => 'nullable|string', // JSON string from hidden field
        ]);
    
        try {
            DB::beginTransaction();

            $data = $validated;

            // dd($data);

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

            // Create record (CoveredItem model with JSON cast for diagnosis_list)
            $coveredItem = CoveredItem::create([
                'item_code' => CoveredItem::generateItemCode($data['service_type']),
                'service_type' => $data['service_type'],            // 0,1,2,3
                'service_name' => $data['service_name'],
                'service_charge' => $data['service_type'] === 'amc'
                    ? null
                    : ($data['service_charge'] ?? null),
                'status' => $data['status'],                 // 0/1
                'diagnosis_list' => $diagnosis,                      // array, casted as JSON
            ]);

            if(!$coveredItem) {
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

            Log::error('Error creating covered item: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'An error occurred while creating the service: '.$e->getMessage(),
                ]);
        }
    }

    public function editCoveredItems($id)
    {
        $coveredItem = CoveredItem::findOrFail($id);
        return view('/crm/amc-plans/covered-items/edit', compact('coveredItem'));
    }

    public function updateCoveredItems(Request $request, $id)
    {
        // 1) Validate input
        $validated = $request->validate([
            'service_type' => 'required|in:amc,quick_service,installation,repair',
            'service_name' => 'required|string|max:255',
            'service_charge' => 'nullable|numeric|min:0|required_unless:service_type,0',
            'status' => 'nullable|in:active,inactive',
            'diagnosis_list' => 'nullable|string',
        ]);

        $coveredItem = CoveredItem::findOrFail($id);

        $data = $validated;
        $data['status'] = $request->input('status', 'active');

        $diagnosis = [];
        if ($request->filled('diagnosis_list')) {
            $raw = $request->input('diagnosis_list');
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $diagnosis = array_values(array_filter($decoded));
            }
        }

        $coveredItem->update([
            'service_type' => $data['service_type'],
            'service_name' => $data['service_name'],
            'service_charge' => $data['service_type'] === 'amc'
                ? null
                : ($data['service_charge'] ?? null),
            'status' => $data['status'],
            'diagnosis_list' => $diagnosis,
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
}
