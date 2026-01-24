<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FollowUpController extends Controller
{
    //
    public function index()
    {
        $status = request()->get('status') ?? 'all';
        $query = FollowUp::query();
        if ($status != 'all') {
            $query->where('status', $status);
        }
        $followup = $query->with('leadDetails.customer', 'staffDetails')->get();
        return view('/crm/follow-up/index', compact('followup'));
    }

    public function create()
    {
        $leads = Lead::all();

        return view('/crm/follow-up/create', compact('leads'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lead_id' => 'required',
            'followup_date' => 'required',
            'followup_time' => 'required',
            'staff_id' => 'required',
            'status' => 'required',
            'remarks' => 'nullable'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $followup = new FollowUp;
        $followup->lead_id = $request->lead_id;
        $followup->staff_id = $request->staff_id;
        $followup->followup_date = $request->followup_date;
        $followup->followup_time = $request->followup_time;
        $followup->status = $request->status;
        $followup->remarks = $request->remarks;

        $followup->save();

        if (! $followup) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('follow-up.index')->with('success', 'Follow Up added successfully.');
    }

    public function view($id)
    {
        $followup = FollowUp::find($id);

        return view('/crm/follow-up/view', compact('followup'));
    }

    public function edit($id)
    {
        $followup = FollowUp::with('leadDetails.customer', 'staffDetails')->find($id);
        $leads = Lead::all();
        // dd($followup);

        return view('/crm/follow-up/edit', compact('followup', 'leads'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'lead_id' => 'required',
            'followup_date' => 'required',
            'followup_time' => 'required',
            'status' => 'required',
            'remarks' => 'nullable'
        ]);

        // dd($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // dd($request->all());

        $followup = FollowUp::findOrFail($id);
        $followup->followup_date = $request->followup_date;
        $followup->followup_time = $request->followup_time;
        $followup->status = $request->status;
        $followup->remarks = $request->remarks;

        $followup->save();

        return redirect()->route('follow-up.index')->with('success', 'Follow Up updated successfully.');
    }

    public function delete($id)
    {
        $followup = FollowUp::findOrFail($id);
        $followup->delete();

        return redirect()->route('follow-up.index')->with('success', 'Follow Up deleted successfully.');
    }

    public function fetchLeads($id)
    {
        $lead = Lead::with('customer', 'staff')->find($id);

        if (!$lead) {
            return response()->json(['error' => 'Lead not found'], 404);
        }

        $customer = $lead->customer;
        if (!$customer) {
            return response()->json([
                'client_name' => '',
                'email' => '',
                'phone' => '',
            ]);
        }

        $staff = $lead->staff;
        if (!$staff) {
            return response()->json([
                'staff_name' => '',
                'staff_id' => '',
            ]);
        }

        return response()->json([
            'staff_name' => ($staff->first_name ?? '') . ' ' . ($staff->last_name ?? ''),
            'staff_id' => ($staff->id ?? ''),
            'client_name' => ($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''),
            'email' => $customer->email ?? '',
            'phone' => $customer->phone ?? '',
        ]);
    }
}
