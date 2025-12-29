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
        $followup = FollowUp::with('lead')->get();

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
            'client_name' => 'required|min:3',
            'contact' => 'required|digits:10',
            'email' => 'required|email|unique:follow_ups,email',
            'followup_date' => 'required',
            'followup_time' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // dd($request->all());

        $followup = new FollowUp;
        $followup->lead_id = $request->lead_id;
        $followup->client_name = $request->client_name;
        $followup->contact = $request->contact;
        $followup->email = $request->email;
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
        $followup = FollowUp::find($id);
        $leads = Lead::all();

        return view('/crm/follow-up/edit', compact('followup', 'leads'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'lead_id' => 'required',
            'client_name' => 'required|min:3',
            'contact' => 'required|digits:10',
            'email' => 'required|email',
            'followup_date' => 'required',
            'followup_time' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // dd($request->all());

        $followup = FollowUp::findOrFail($id);
        $followup->lead_id = $request->lead_id;
        $followup->client_name = $request->client_name;
        $followup->contact = $request->contact;
        $followup->email = $request->email;
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
        $lead = Lead::find($id);

        return response()->json([
            'client_name' => $lead->first_name,
            'email' => $lead->email,
            'phone' => $lead->phone,
        ]);
    }
}
