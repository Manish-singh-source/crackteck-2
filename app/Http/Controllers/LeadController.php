<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerAddressDetail;
use App\Models\Lead;
use App\Models\LeadBranch;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    //
    public function index()
    {
        $lead = Lead::with('staff')->get();
        return view('/crm/leads/index', compact('lead'));
    }

    public function create()
    {
        $salesPersons = Staff::where('staff_role', 'sales_person')->get();

        // dd($salesPersons);
        return view('/crm/leads/create', compact('salesPersons'));
    }

    public function store(Request $request)
    {
        //
        // i want to store customer id and customer address id in lead table from customer table and customer_address_details table
        // and also want to store lead details in lead table
        // i will send all the details from frontend in one request.

        dd($request->all());

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'shipping_address_id' => 'required',
            'requirement_type' => 'required',
            'budget_range' => 'required',
            'urgency' => 'required',
            'status' => 'required',
            'sales_person_id' => 'required|exists:staff,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $customer = Customer::find($request->customer_id);
        $customer_address = CustomerAddressDetail::find($request->shipping_address_id);

        if (! $customer || ! $customer_address) {
            return back()->with('error', 'Invalid customer or address selected.')->withInput();
        }

        $lead = new Lead;
        $lead->customer_id = $customer->id;
        $lead->customer_address_id = $customer_address->id;
        $lead->requirement_type = $request->requirement_type;
        $lead->budget_range = $request->budget_range;
        $lead->urgency = $request->urgency;
        $lead->staff_id = $request->sales_person_id;
        $lead->status = $request->status;

        $lead->save();

        return redirect()->route('leads.index')->with('success', 'Leads added successfully.');
    }

    public function view($id)
    {
        $lead = Lead::with('branches')->find($id);
        $salesPersons = Staff::where('staff_role', 'sales_person')->get();

        return view('/crm/leads/view', compact('lead', 'salesPersons'));
    }

    public function edit($id)
    {
        $lead = Lead::with('branches')->find($id);
        $salesPersons = Staff::where('staff_role', 'sales_person')->get();

        return view('/crm/leads/edit', compact('lead', 'salesPersons'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:leads,email,' . $id,
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
        $lead->staff_id = $request->sales_person_id;
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

    public function searchCustomers(Request $request)
    {
        $query = $request->query('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $customers = Customer::with('addressDetails')
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'LIKE', "%{$query}%")
                    ->orWhere('last_name', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->orWhere('phone', 'LIKE', "%{$query}%");
            })
            ->select('id', 'first_name', 'last_name', 'email', 'phone')
            ->get();

        if ($customers) {

            return response()->json($customers);
        }

        return response()->json(['error' => 'No customers found'], 404);
    }

    public function deleteBranch($id)
    {
        $branch = LeadBranch::findOrFail($id);
        $branch->delete();

        return response()->json([
            'success' => true,
            'message' => 'Branch deleted successfully.',
        ]);
    }

    public function getBranches($leadId)
    {
        $branches = LeadBranch::where('lead_id', $leadId)->get();

        return response()->json([
            'success' => true,
            'branches' => $branches,
        ]);
    }
}
