<?php

namespace App\Http\Controllers;

use App\Models\AssignmentWorkflow;
use App\Models\FieldIssue;
use App\Models\JobAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssignedJobController extends Controller
{
    //
    public function index()
    {
        $assignedJobs = JobAssignment::with(['job', 'engineer'])->get();

        return view('/crm/assigned-jobs/index', compact('assignedJobs'));
    }

    public function view($id)
    {
        $assignment = JobAssignment::with(['job', 'engineer', 'workflow'])->findOrFail($id);

        return view('/crm/assigned-jobs/view', compact('assignment'));
    }

    public function edit($id)
    {
        $assignment = JobAssignment::with(['job', 'engineer'])->findOrFail($id);

        return view('/crm/assigned-jobs/edit', compact('assignment'));
    }

    public function update(Request $request, $id)
    {
        $assignment = JobAssignment::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed,Cancelled',
            'notes' => 'nullable|string',
        ]);

        $assignment->status = $request->status;
        $assignment->notes = $request->notes;

        if ($request->status == 'In Progress' && ! $assignment->started_at) {
            $assignment->started_at = now();
        }

        if ($request->status == 'Completed' && ! $assignment->completed_at) {
            $assignment->completed_at = now();
        }

        $assignment->save();

        return redirect()->route('assigned-jobs.index')->with('success', 'Assigned job updated successfully.');
    }

    public function delete($id)
    {
        $assignment = JobAssignment::findOrFail($id);
        $assignment->delete();

        return redirect()->route('assigned-jobs.index')->with('success', 'Assigned job deleted successfully.');
    }

    /**
     * Start Job - Save client connection details
     */
    public function startJob(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'client_connected' => 'required|string',
            'client_confirmation' => 'required|string',
            'remote_tool' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $assignment = JobAssignment::findOrFail($id);

        // Create or update workflow
        $workflow = AssignmentWorkflow::updateOrCreate(
            ['job_assignment_id' => $id],
            [
                'client_connected_via' => $request->client_connected,
                'client_confirmation' => $request->client_confirmation,
                'remote_tool_used' => $request->remote_tool,
                'start_job_completed_at' => now(),
            ]
        );

        // Update assignment status to In Progress
        $assignment->update(['status' => 'In Progress', 'started_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Job started successfully',
            'data' => $workflow,
        ]);
    }

    /**
     * Perform Diagnosis - Save diagnosis details
     */
    public function performDiagnosis(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'diagnosis_types' => 'required|array|min:1',
            'diagnosis_notes' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $workflow = AssignmentWorkflow::where('job_assignment_id', $id)->firstOrFail();

        $workflow->update([
            'diagnosis_types' => $request->diagnosis_types,
            'diagnosis_notes' => $request->diagnosis_notes,
            'diagnosis_completed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Diagnosis saved successfully',
            'data' => $workflow,
        ]);
    }

    /**
     * Take Action - Save action taken details with file uploads
     */
    public function takeAction(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fix_description' => 'required|string',
            'before_screenshot' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'after_screenshot' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'logs' => 'nullable|file|mimes:txt,pdf,log|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $workflow = AssignmentWorkflow::where('job_assignment_id', $id)->firstOrFail();

        $data = [
            'fix_description' => $request->fix_description,
            'action_taken_completed_at' => now(),
        ];

        // Handle file uploads
        if ($request->hasFile('before_screenshot')) {
            $data['before_screenshot'] = $request->file('before_screenshot')->store('assignment-workflows/screenshots', 'public');
        }

        if ($request->hasFile('after_screenshot')) {
            $data['after_screenshot'] = $request->file('after_screenshot')->store('assignment-workflows/screenshots', 'public');
        }

        if ($request->hasFile('logs')) {
            $data['logs_file'] = $request->file('logs')->store('assignment-workflows/logs', 'public');
        }

        $workflow->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Action taken saved successfully',
            'data' => $workflow,
        ]);
    }

    /**
     * Complete Job - Save completion details and mark as completed
     */
    public function completeJob(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'time_spent' => 'required|date_format:H:i',
            'result' => 'required|in:Resolved - Remote,Unresolved - Remote',
            'client_feedback' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $assignment = JobAssignment::findOrFail($id);
        $workflow = AssignmentWorkflow::where('job_assignment_id', $id)->firstOrFail();

        // Update workflow
        $workflow->update([
            'time_spent' => $request->time_spent,
            'result' => $request->result,
            'client_feedback' => $request->client_feedback,
            'job_completed_at' => now(),
        ]);

        // Update assignment status to Completed
        $assignment->update([
            'status' => 'Completed',
            'completed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job completed successfully',
            'data' => $workflow,
        ]);
    }

    /**
     * Escalate to On-Site - Create a field issue
     */
    public function escalateToOnSite(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'reason_for_escalation' => 'required|string',
            'escalation_notes' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $assignment = JobAssignment::with(['job', 'engineer'])->findOrFail($id);

        // Create field issue
        $fieldIssue = FieldIssue::create([
            'job_assignment_id' => $id,
            'job_id' => $assignment->job_id,
            'engineer_id' => $assignment->engineer_id,
            'customer_name' => $assignment->job->first_name.' '.$assignment->job->last_name,
            'customer_phone' => $assignment->job->phone,
            'customer_email' => $assignment->job->email,
            'location' => $assignment->job->address.', '.$assignment->job->city,
            'issue_type' => $assignment->job->issue_type,
            'issue_description' => $assignment->job->description,
            'priority' => $assignment->job->priority_level,
            'reason_for_escalation' => $request->reason_for_escalation,
            'escalation_notes' => $request->escalation_notes,
            'status' => 'Pending',
        ]);

        // Keep assignment status as Pending (do not cancel it)
        // The field issue itself is created with status 'Pending', so we leave the assignment status unchanged
        $assignment->update(['status' => 'Pending']);

        return response()->json([
            'success' => true,
            'message' => 'Job escalated to on-site successfully',
            'data' => $fieldIssue,
        ]);
    }
}
