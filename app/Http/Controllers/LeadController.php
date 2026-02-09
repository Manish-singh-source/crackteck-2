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
        $status = request()->get('status') ?? 'all';
        $query = Lead::query();
        if ($status != 'all') {
            $query->where('status', $status);
        }
        $leads = $query->with('staff', 'customer', 'customerAddress', 'companyDetails')->get();
        return view('/crm/leads/index', compact('leads'));
    }

    public function create()
    {
        $salesPersons = Staff::where('staff_role', 'sales_person')->get();

        // dd($salesPersons);
        return view('/crm/leads/create', compact('salesPersons'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'sales_person_id' => 'required|exists:staff,id',
            'shipping_address_id' => 'required',
            'requirement_type' => 'required',
            'budget_range' => 'required',
            'urgency' => 'required',
            'estimated_value' => 'required|numeric',
            'notes' => 'nullable',
            'status' => 'required',
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
        $lead->staff_id = $request->sales_person_id;
        $lead->customer_address_id = $request->shipping_address_id;
        $lead->lead_number = 'LEAD' . str_pad(Lead::count() + 1, 3, '0', STR_PAD_LEFT);
        $lead->requirement_type = $request->requirement_type;
        $lead->budget_range = $request->budget_range;
        $lead->urgency = $request->urgency;
        $lead->status = $request->status;
        $lead->estimated_value = $request->estimated_value;
        $lead->notes = $request->notes;

        $lead->save();

        return redirect()->route('leads.index')->with('success', 'Leads added successfully.');
    }

    public function view($id)
    {
        $lead = Lead::with('customerAddress', 'companyDetails')->find($id);
        $salesPersons = Staff::where('staff_role', 'sales_person')->get();

        return view('/crm/leads/view', compact('lead', 'salesPersons'));
    }

    public function edit($id)
    {
        $lead = Lead::with('customer', 'staff', 'customerAddress', 'companyDetails')->find($id);
        $salesPersons = Staff::where('staff_role', 'sales_person')->get();
        // dd($lead);

        return view('/crm/leads/edit', compact('lead', 'salesPersons'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'shipping_address_id' => 'required|exists:customer_address_details,id',
            'requirement_type' => 'required',
            'budget_range' => 'nullable',
            'urgency' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:new,contacted,qualified,proposal,won,lost,nurtured',
            'staff_id' => 'required|exists:staff,id',
            'estimated_value' => 'nullable|numeric',
            'notes' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $lead = Lead::findOrFail($id);
        $lead->customer_id = $request->customer_id;
        $lead->customer_address_id = $request->shipping_address_id;
        $lead->requirement_type = $request->requirement_type;
        $lead->budget_range = $request->budget_range;
        $lead->urgency = $request->urgency;
        $lead->status = $request->status;
        $lead->staff_id = $request->staff_id;
        $lead->estimated_value = $request->estimated_value;
        $lead->notes = $request->notes;

        $lead->save();

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    public function delete($id)
    {
        $lead = Lead::findOrFail($id);
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
            // ->where('is_lead', true)
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
