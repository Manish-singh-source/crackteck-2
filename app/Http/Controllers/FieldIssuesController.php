<?php

namespace App\Http\Controllers;

use App\Models\FieldIssue;
use Illuminate\Http\Request;

class FieldIssuesController extends Controller
{
    //
    public function index()
    {
        $fieldIssues = FieldIssue::with(['staff', 'serviceRequest.customer'])->get();
        return view('/crm/field-issues/index', compact('fieldIssues'));
    }

    public function view($id)
    {
        $issue = FieldIssue::with(['staff', 'serviceRequest.customer', 'serviceRequestProduct'])->findOrFail($id);
        $engineer = $issue->staff;
        $customer = $issue->serviceRequest?->customer ?? null; 
        $customerAddress = $issue->serviceRequest?->customer?->primaryAddress ?? null;
        $productData = $issue->serviceRequestProduct ?? null;

        return view('/crm/field-issues/view', compact('issue', 'engineer', 'customer', 'customerAddress', 'productData'));
    }

    public function edit($id)
    {
        $issue = \App\Models\FieldIssue::findOrFail($id);

        return view('/crm/field-issues/edit', compact('issue'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'job_id' => 'required',
            'engineer_id' => 'required',
            'customer_name' => 'required',
            'location' => 'required',
            'issue_type' => 'required',
            'priority' => 'required',
            'status' => 'required',
        ]);
        \App\Models\FieldIssue::create($data);

        return redirect()->route('field-issues.index')->with('success', 'Field issue created successfully.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'job_id' => 'required',
            'engineer_id' => 'required',
            'customer_name' => 'required',
            'location' => 'required',
            'issue_type' => 'required',
            'priority' => 'required',
            'status' => 'required',
        ]);
        $issue = \App\Models\FieldIssue::findOrFail($id);
        $issue->update($data);

        return redirect()->route('field-issues.index')->with('success', 'Field issue updated successfully.');
    }

    public function destroy($id)
    {
        $issue = \App\Models\FieldIssue::findOrFail($id);
        $issue->delete();

        return redirect()->route('field-issues.index')->with('success', 'Field issue deleted successfully.');
    }
}
