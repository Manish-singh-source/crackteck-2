<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FieldIssuesController extends Controller
{
    //
    public function index()
    {
        $fieldIssues = \App\Models\FieldIssue::all();

        return view('/crm/field-issues/index', compact('fieldIssues'));
    }

    public function view($id)
    {
        // Load the issue with related engineer and job (and job devices)
        $issue = \App\Models\FieldIssue::with(['engineer', 'job.devices'])->findOrFail($id);

        // Prepare data for the view
        $engineer = $issue->engineer;
        $job = $issue->job; // Job contains customer fields and hasMany devices
        $customer = $job; // reuse job as customer source when available
        $devices = $job ? $job->devices : collect();

        return view('/crm/field-issues/view', compact('issue', 'engineer', 'customer', 'devices'));
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
