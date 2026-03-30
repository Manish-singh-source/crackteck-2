<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\AmcScheduleMeeting;
use App\Models\AssignmentWorkflow;
use App\Models\FieldIssue;
use App\Models\JobAssignment;
use App\Models\RemoteSupportDiagnosis;
use App\Models\RemoteSupportJob;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssignedJobController extends Controller
{
    //
    public function index()
    {
        $jobs = RemoteSupportJob::with('serviceRequest.customer', 'engineer')->get();
        return view('/crm/assigned-jobs/index', compact('jobs'));
    }

    public function view($id)
    {
        $remoteSupportJob = RemoteSupportJob::with('serviceRequest.customer', 'serviceRequest.products', 'engineer')->find($id);
        return view('/crm/assigned-jobs/view', compact('remoteSupportJob', 'id'));
    }

    public function diagnose($id, $remote_support_id)
    {
        $serviceRequestProduct = ServiceRequestProduct::with('productDiagnose', 'remoteSupportDiagnose')->findOrFail($id);
        $remoteSupportJob = RemoteSupportJob::with('diagnosis')->findOrFail($remote_support_id);
        
        return view('/crm/assigned-jobs/diagnose', compact('serviceRequestProduct', 'remote_support_id', 'remoteSupportJob'));
    }

    public function startDiagnose(Request $request, $id, $step, $remote_support_id)
    {
        if ($step == '1') {
            $remoteSupportDiagnose = RemoteSupportDiagnosis::create([
                'remote_support_job_id' => $remote_support_id,
                'service_request_product_id' => $id,
                'client_connected_via' => $request->client_connected,
                'client_confirmation' => $request->client_confirmation,
                'remote_tool' => $request->remote_tool,
                'status' => 'in_progress'
            ]);

            if ($remoteSupportDiagnose) {
                $remoteSupportJob = RemoteSupportJob::findOrFail($remote_support_id);
                $remoteSupportJob->status = 'in_progress';
                $remoteSupportJob->save();

                $serviceRequestProduct = ServiceRequestProduct::with('serviceRequest')->findOrFail($id);
                $serviceRequestProduct->status = 'in_progress';
                $serviceRequestProduct->save();

                $serviceRequest = ServiceRequest::findOrFail($serviceRequestProduct->service_requests_id);
                $serviceRequest->status = 'in_progress';
                $serviceRequest->save();


                if ($serviceRequest->service_type == 'amc') {
                    $amcScheduleMeeting = AmcScheduleMeeting::where('id', $remoteSupportJob->amc_schedule_meeting_id)->first();
                    $amcScheduleMeeting->status = 'in_progress';
                    $amcScheduleMeeting->save();
                }

                return redirect()->back()->with('success', 'Diagnosis started successfully.');
            }
            return redirect()->back()->with('error', 'Failed to start diagnosis.');
        } else if ($step == '2') {
            $remoteSupportDiagnose = RemoteSupportDiagnosis::where('remote_support_job_id', $remote_support_id)->first();
            $remoteSupportDiagnose->diagnosis_list = $request->diagnosis_list;
            $remoteSupportDiagnose->diagnosis_notes = $request->diagnosis_notes;
            $remoteSupportDiagnose->save();

            if ($remoteSupportDiagnose) {
                return redirect()->back()->with('success', 'Diagnosis started successfully.');
            }
            return redirect()->back()->with('error', 'Failed to start diagnosis.');
        } else if ($step == '3') {
            $remoteSupportDiagnose = RemoteSupportDiagnosis::where('remote_support_job_id', $remote_support_id)->first();
            $remoteSupportDiagnose->fix_description = $request->fix_description;
            $remoteSupportDiagnose->before_screenshots = FileUpload::fileUpload($request->before_screenshot, 'assignment-workflows/screenshots');
            $remoteSupportDiagnose->after_screenshots = FileUpload::fileUpload($request->after_screenshot, 'assignment-workflows/screenshots');
            $remoteSupportDiagnose->logs = FileUpload::fileUpload($request->logs, 'assignment-workflows/logs');
            $remoteSupportDiagnose->save();

            if ($remoteSupportDiagnose) {
                return redirect()->back()->with('success', 'Diagnosis started successfully.');
            }
            return redirect()->back()->with('error', 'Failed to start diagnosis.');
        } else if ($step == '4') {
            $result = 'in_progress';
            if ($request->result == 'resolved') {
                $result = 'resolved';
            } else if ($request->result == 'unresolved') {
                $result = 'unresolved';
            }
            $remoteSupportDiagnose = RemoteSupportDiagnosis::where('remote_support_job_id', $remote_support_id)->first();
            $remoteSupportDiagnose->time_spent = $request->time_spent;
            $remoteSupportDiagnose->client_feedback = $request->client_feedback;
            $remoteSupportDiagnose->status = $result;
            $remoteSupportDiagnose->save();

            $remoteSupportJob = RemoteSupportJob::findOrFail($remote_support_id);
            $remoteSupportJob->status = $result;
            $remoteSupportJob->save();

            $serviceRequestProduct = ServiceRequestProduct::with('serviceRequest')->findOrFail($id);
            $serviceRequestProduct->status = 'diagnosis_completed';
            $serviceRequestProduct->save();

            $serviceRequest = ServiceRequest::findOrFail($serviceRequestProduct->service_requests_id);
            $serviceRequest->status = 'completed';
            $serviceRequest->save();

            if ($serviceRequest->service_type == 'amc') {
                $amcScheduleMeeting = AmcScheduleMeeting::where('id', $remoteSupportJob->amc_schedule_meeting_id)->first();
                $amcScheduleMeeting->status = 'completed';
                $amcScheduleMeeting->save();
            }

            if ($remoteSupportDiagnose) {
                return redirect()->back()->with('success', 'Diagnosis completed successfully.');
            }
            return redirect()->back()->with('error', 'Failed to start diagnosis.');
        } else if ($step == '5') {
            $remoteSupportDiagnose = RemoteSupportDiagnosis::where('remote_support_job_id', $remote_support_id)->first();
            $remoteSupportDiagnose->reason_for_escalation = $request->reason_for_escalation;
            $remoteSupportDiagnose->escalation_notes = $request->escalation_notes;
            $remoteSupportDiagnose->status = 'escalated';
            $remoteSupportDiagnose->save();

            $remoteSupportJob = RemoteSupportJob::findOrFail($remote_support_id);
            $remoteSupportJob->status = 'escalated';
            $remoteSupportJob->save();

            if ($remoteSupportDiagnose) {

                $serviceRequestProduct = ServiceRequestProduct::with('serviceRequest')->findOrFail($id);
                // $serviceRequestProduct->status = 'escalated';
                $serviceRequestProduct->status = 'pending';
                $serviceRequestProduct->save();

                $serviceRequest = ServiceRequest::findOrFail($serviceRequestProduct->service_requests_id);
                $serviceRequest->status = 'escalated';
                $serviceRequest->save();

                return redirect()->back()->with('success', 'Diagnosis completed successfully.');
            }

            return redirect()->back()->with('error', 'Failed to start diagnosis.');
        }
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
            'customer_name' => $assignment->job->first_name . ' ' . $assignment->job->last_name,
            'customer_phone' => $assignment->job->phone,
            'customer_email' => $assignment->job->email,
            'location' => $assignment->job->address . ', ' . $assignment->job->city,
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
