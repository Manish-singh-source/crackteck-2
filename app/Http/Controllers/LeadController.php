<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadBranch;
use App\Models\SalesPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    //
    public function index()
    {
        $lead = Lead::with('user')->get();

        return view('/crm/leads/index', compact('lead'));
    }

    public function create()
    {
        $salesPersons = SalesPerson::all();

        // dd($salesPersons);
        return view('/crm/leads/create', compact('salesPersons'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:leads,email',
            'dob' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }
        // dd($request->all());

        $lead = new Lead;
        $lead->first_name = $request->first_name;
        $lead->last_name = $request->last_name;
        $lead->phone = $request->phone;
        $lead->email = $request->email;
        $lead->dob = $request->dob;
        $lead->gender = $request->gender;

        $lead->company_name = $request->company_name;
        $lead->designation = $request->designation;
        $lead->industry_type = $request->industry_type;
        $lead->source = $request->source;
        $lead->requirement_type = $request->requirement_type;

        $lead->budget_range = $request->budget_range;
        $lead->urgency = $request->urgency;
        $lead->user_id = $request->sales_person_id;
        $lead->status = $request->status;

        $lead->save();

        if (! $lead) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong.',
                ], 500);
            }

            return back()->with('error', 'Something went wrong.');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'lead_id' => $lead->id,
                'message' => 'Lead added successfully.',
            ]);
        }

        return redirect()->route('leads.index')->with('success', 'Leads added successfully.');
    }

    public function view($id)
    {
        $lead = Lead::with('branches')->find($id);
        $salesPersons = SalesPerson::all();

        return view('/crm/leads/view', compact('lead', 'salesPersons'));
    }

    public function edit($id)
    {
        $lead = Lead::with('branches')->find($id);
        $salesPersons = SalesPerson::all();

        return view('/crm/leads/edit', compact('lead', 'salesPersons'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:leads,email,'.$id,
            'dob' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // dd($request->all());

        $lead = Lead::findOrFail($id);
        $lead->first_name = $request->first_name;
        $lead->last_name = $request->last_name;
        $lead->phone = $request->phone;
        $lead->email = $request->email;
        $lead->dob = $request->dob;
        $lead->gender = $request->gender;

        $lead->company_name = $request->company_name;
        $lead->designation = $request->designation;
        $lead->industry_type = $request->industry_type;
        $lead->source = $request->source;
        $lead->requirement_type = $request->requirement_type;

        $lead->budget_range = $request->budget_range;
        $lead->urgency = $request->urgency;
        $lead->user_id = $request->user_id;
        $lead->status = $request->status;

        $lead->save();

        return redirect()->route('leads.index')->with('success', 'Leads updated successfully.');
    }

    public function delete($id)
    {
        $lead = Lead::findOrFail($id);
        // Delete all related branches (cascade delete is also set in migration)
        $lead->branches()->delete();
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Leads deleted successfully.');
    }

    // Branch Management Methods

    /**
     * Store a new branch for a lead
     */
    public function storeBranch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lead_id' => 'required|exists:leads,id',
            'branch_name' => 'required|string|max:255',
            'address_line1' => 'required|string',
            'address_line2' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $branch = LeadBranch::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Branch added successfully.',
            'branch' => $branch,
        ]);
    }

    /**
     * Update an existing branch
     */
    public function updateBranch(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'branch_name' => 'required|string|max:255',
            'address_line1' => 'required|string',
            'address_line2' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $branch = LeadBranch::findOrFail($id);
        $branch->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Branch updated successfully.',
            'branch' => $branch,
        ]);
    }

    /**
     * Delete a branch
     */
    public function deleteBranch($id)
    {
        $branch = LeadBranch::findOrFail($id);
        $branch->delete();

        return response()->json([
            'success' => true,
            'message' => 'Branch deleted successfully.',
        ]);
    }

    /**
     * Get all branches for a lead
     */
    public function getBranches($leadId)
    {
        $branches = LeadBranch::where('lead_id', $leadId)->get();

        return response()->json([
            'success' => true,
            'branches' => $branches,
        ]);
    }
}
