@extends('crm/layouts/master')

@section('content')

<div class="content">


    <div class="container-fluid">

        <div class="bradcrumb pt-3 ps-2 bg-light">
            <div class="row ">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Assigned Jobs</li>
                        <li class="breadcrumb-item active" aria-current="page">Start Job</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0"></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="d-flex">
                                    <h5 class="card-title flex-grow-1 mb-0">
                                        Client Details
                                    </h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul class="list-group list-group-flush ">

                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">Customer Name :
                                                </span>
                                                <span>
                                                    {{ $assignment->job->first_name }} {{ $assignment->job->last_name }}
                                                </span>
                                            </li>

                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">Contact no :
                                                </span>
                                                <span>
                                                    {{ $assignment->job->phone ?? 'N/A' }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="list-group list-group-flush ">

                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">Email :
                                                </span>
                                                <span>
                                                    {{ $assignment->job->email ?? 'N/A' }}
                                                </span>
                                            </li>

                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">Address :
                                                </span>
                                                <span>
                                                    {{ $assignment->job->address }}, {{ $assignment->job->city }}, {{ $assignment->job->state }} {{ $assignment->job->pincode }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons Section -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Workflow Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-primary start-job-btn workflow-btn" data-step="1">
                                            <i class="ri-play-line"></i> Start Job
                                            <span class="workflow-status ms-2" style="display: none;">✓</span>
                                        </button>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-info perform-diagnosis-btn workflow-btn" data-step="2">
                                            <i class="ri-stethoscope-line"></i> Perform Diagnosis
                                            <span class="workflow-status ms-2" style="display: none;">✓</span>
                                        </button>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-warning take-action-btn workflow-btn" data-step="3">
                                            <i class="ri-tools-line"></i> Take Action
                                            <span class="workflow-status ms-2" style="display: none;">✓</span>
                                        </button>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-danger escalate-btn workflow-btn" data-step="4">
                                            <i class="ri-arrow-up-line"></i> Escalate to On-Site
                                            <span class="workflow-status ms-2" style="display: none;">✓</span>
                                        </button>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-success complete-job-btn workflow-btn" data-step="5">
                                            <i class="ri-check-double-line"></i> Complete Job
                                            <span class="workflow-status ms-2" style="display: none;">✓</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start Job Section -->
                    <div class="col-lg-12 start-job-section">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">
                                            Start Job
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <form id="startJobForm">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="form-label">Client Connected Via <span class="text-danger">*</span></label>
                                            <select name="client_connected" id="client_connected" class="form-select" required>
                                                <option value="">--Select--</option>
                                                <option value="Call">Call</option>
                                                <option value="E-mail">E-mail</option>
                                                <option value="WhatsApp">WhatsApp</option>
                                            </select>
                                        </div>

                                        <div class="col-6">
                                            <label class="form-label">Client Confirmation <span class="text-danger">*</span></label>
                                            <input type="text" name="client_confirmation" id="client_confirmation" class="form-control" placeholder="Enter Confirmation Details" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Remote Tool Used <span class="text-danger">*</span></label>
                                            <select name="remote_tool" id="remote_tool" class="form-select" required>
                                                <option value="">--Select Remote Tool--</option>
                                                <option value="Anydesk">Anydesk</option>
                                                <option value="Team Viewer">Team Viewer</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 start-job-section">
                        <div class="text-start mb-3">
                            <button type="button" class="btn btn-success w-sm waves ripple-light start-job-btn">Submit</button>
                        </div>
                    </div>

                    <!-- Start Details Section -->
                    <div class="col-lg-12 start-job-details-section">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="d-flex">
                                    <h5 class="card-title flex-grow-1 mb-0">
                                        Job Details
                                    </h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul class="list-group list-group-flush ">

                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">Connected Via :
                                                </span>
                                                <span id="display_client_connected">
                                                    N/A
                                                </span>
                                            </li>

                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">Client Confirmation :
                                                </span>
                                                <span id="display_client_confirmation">
                                                    N/A
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="list-group list-group-flush ">
                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">Remote Tool Used :
                                                </span>
                                                <span id="display_remote_tool">
                                                    N/A
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 start-job-details-section">
                        <div class="text-start mb-3">
                            <a href="#" class="btn btn-success w-sm waves ripple-light perform-diagnosis-btn">Perform Diagnosis</a>
                        </div>
                    </div>

                    <!-- Diagnosis Section -->
                    <div class="col-lg-12 diagnosis-section">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">
                                            Diagnosis Details
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <form id="diagnosisForm">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="fw-bold">
                                                Diagnosis Type <span class="text-danger">*</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input diagnosis-type-checkbox" type="checkbox" value="Windows/macOS" id="category3">
                                                <label class="form-check-label" for="category3">
                                                    Windows/macOS
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input diagnosis-type-checkbox" type="checkbox" value="Network" id="category2">
                                                <label class="form-check-label" for="category2">
                                                    Network
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input diagnosis-type-checkbox" type="checkbox" value="Printer/Software" id="category1">
                                                <label class="form-check-label" for="category1">
                                                    Printer/Software
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 pt-3">
                                        <div class="col-12">
                                            <label for="diagnosis_notes" class="form-label">Diagnosis Notes: <span class="text-danger">*</span></label>
                                            <textarea name="diagnosis_notes" id="diagnosis_notes" class="form-control" rows="4" required></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 diagnosis-section">
                        <div class="text-start mb-3">
                            <button type="button" class="btn btn-success w-sm waves ripple-light diagnosis-complete-btn">Submit</button>
                        </div>
                    </div>

                    <!-- Diagnosis Details Section -->
                    <div class="col-lg-12 diagnosis-details-section">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="d-flex">
                                    <h5 class="card-title flex-grow-1 mb-0">
                                        Diagnosis Details
                                    </h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row gap-3">
                                    <div class="col-12">
                                        <div class="fw-semibold text-break">
                                            Diagnosis Type
                                        </div>
                                        <ul class="list-group list-group-flush" id="display_diagnosis_types">
                                            <li class="list-group-item border-0">N/A</li>
                                        </ul>
                                    </div>
                                    <div class="col-12">
                                        <div class="fw-semibold text-break">Diagnosis Notes :
                                        </div>
                                        <div id="display_diagnosis_notes">
                                            N/A
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 diagnosis-details-section">
                        <div class="text-start mb-3">
                            <a href="#" class="btn btn-success w-sm waves ripple-light take-action-btn">Take Action</a>
                        </div>
                    </div>

                    <!-- Action Taken Section -->
                    <div class="col-lg-12 action-taken-section">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">
                                            Action Taken
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <form id="actionTakenForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="fix_description" class="form-label">Fix Description: <span class="text-danger">*</span></label>
                                            <textarea name="fix_description" id="fix_description" class="form-control" rows="4" required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label for="before_screenshot" class="form-label">Before Screenshot</label>
                                            <input type="file" name="before_screenshot" id="before_screenshot" class="form-control" accept="image/*">
                                        </div>
                                        <div class="col-12">
                                            <label for="after_screenshot" class="form-label">After Screenshot</label>
                                            <input type="file" name="after_screenshot" id="after_screenshot" class="form-control" accept="image/*">
                                        </div>
                                        <div class="col-12">
                                            <label for="logs" class="form-label">Logs (if any)</label>
                                            <input type="file" name="logs" id="logs" class="form-control" accept=".txt,.pdf,.log">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 action-taken-section">
                        <div class="text-start mb-3">
                            <button type="button" class="btn btn-success w-sm waves ripple-light take-action-complete-btn">Submit</button>
                        </div>
                    </div>

                    <!-- Action Taken Details Section -->
                    <div class="col-lg-12 action-taken-details-section">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="d-flex">
                                    <h5 class="card-title flex-grow-1 mb-0">
                                        Action Taken Details
                                    </h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row gap-3">
                                    <div class="col-12">
                                        <div class="fw-semibold text-break">Fix Description :
                                        </div>
                                        <div id="display_fix_description">
                                            N/A
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span class="fw-semibold text-break">
                                            Before Screenshot:
                                        </span>
                                        <span id="display_before_screenshot_container" style="display: none;">
                                            <a href="#" id="display_before_screenshot" class="btn btn-sm btn-primary" target="_blank">View</a>
                                        </span>
                                        <span id="display_before_screenshot_na">N/A</span>
                                    </div>
                                    <div class="col-12">
                                        <span class="fw-semibold text-break">
                                            After Screenshot:
                                        </span>
                                        <span id="display_after_screenshot_container" style="display: none;">
                                            <a href="#" id="display_after_screenshot" class="btn btn-sm btn-primary" target="_blank">View</a>
                                        </span>
                                        <span id="display_after_screenshot_na">N/A</span>
                                    </div>
                                    <div class="col-12">
                                        <span class="fw-semibold text-break">
                                            Logs (if any):
                                        </span>
                                        <span id="display_logs_container" style="display: none;">
                                            <a href="#" id="display_logs" class="btn btn-sm btn-primary" target="_blank">View</a>
                                        </span>
                                        <span id="display_logs_na">N/A</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 action-taken-details-section">
                        <div class="text-start mb-3">
                            <a href="#" class="btn btn-success w-sm waves ripple-light escalate-btn">Escalate</a>
                        </div>
                        <div class="text-start mb-3">
                            <a href="#" class="btn btn-success w-sm waves ripple-light complete-job-btn">Complete Job</a>
                        </div>
                    </div>

                    <!-- Escalate Section -->
                    <div class="col-lg-12 escalate-section">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">
                                            Escalate to On-Site
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <form id="escalateForm">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Reason For Escalation <span class="text-danger">*</span></label>
                                            <select name="reason_for_escalation" id="reason_for_escalation" class="form-select" required>
                                                <option value="">--Select Reason--</option>
                                                <option value="Hardware Failure">Hardware Failure</option>
                                                <option value="No Internet Access">No Internet Access</option>
                                                <option value="Physical Inspection Required">Physical Inspection Required</option>
                                                <option value="Component Replacement">Component Replacement</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="escalation_notes" class="form-label">Additional Notes: <span class="text-danger">*</span></label>
                                            <textarea name="escalation_notes" id="escalation_notes" class="form-control" rows="4" placeholder="Enter escalation reason and notes..."></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 escalate-section">
                        <div class="text-start mb-3">
                            <button type="button" class="btn btn-success w-sm waves ripple-light escalate-submit-btn">Submit</button>
                            <button type="button" class="btn btn-secondary w-sm waves ripple-light escalate-auto-submit-btn ms-2">Auto Submit</button>
                        </div>
                    </div>

                    <!-- Complete Job Section -->
                    <div class="col-lg-12 complete-job-section">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">
                                            Complete Job
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <form id="completeJobForm">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="time_spent" class="form-label">Time Spent(HH:MM) <span class="text-danger">*</span></label>
                                            <input type="time" name="time_spent" id="time_spent" class="form-control" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="result" class="form-label">Result <span class="text-danger">*</span></label>
                                            <select name="result" id="result" class="form-control" required>
                                                <option value="">-- Select --</option>
                                                <option value="Resolved - Remote">Resolved - Remote</option>
                                                <option value="Unresolved - Remote">Unresolved - Remote</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="client_feedback" class="form-label">Client Feedback: <span class="text-danger">*</span></label>
                                            <textarea name="client_feedback" id="client_feedback" class="form-control" rows="4" required></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 complete-job-section">
                        <div class="text-start mb-3">
                            <button type="button" class="btn btn-success w-sm waves ripple-light complete-job-submit-btn">Mark as Complete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const assignmentId = {{ $assignment->id }};
    let workflowStatus = {
        startJob: false,
        diagnosis: false,
        actionTaken: false,
        escalated: false,
        completed: false
    };

    $(document).ready(function() {
        // Hide sections initially
        $(".start-job-details-section").hide();
        $(".diagnosis-section").hide();
        $(".diagnosis-details-section").hide();
        $(".action-taken-section").hide();
        $(".action-taken-details-section").hide();
        $(".escalate-section").hide();
        $(".complete-job-section").hide();

        // Load existing workflow data if available
        loadWorkflowData();
        updateButtonStatus();

        // Start Job Submit
        $(".start-job-btn").on("click", function(e) {
            e.preventDefault();
            const formData = {
                client_connected: $('#client_connected').val(),
                client_confirmation: $('#client_confirmation').val(),
                remote_tool: $('#remote_tool').val(),
            };

            if (!formData.client_connected || !formData.client_confirmation || !formData.remote_tool) {
                alert('Please fill all required fields');
                return;
            }

            $.ajax({
                url: `/crm/assigned-jobs/${assignmentId}/start-job`,
                method: 'POST',
                data: {
                    ...formData,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Display the submitted data
                        $('#display_client_connected').text(formData.client_connected);
                        $('#display_client_confirmation').text(formData.client_confirmation);
                        $('#display_remote_tool').text(formData.remote_tool);

                        // Update workflow status
                        workflowStatus.startJob = true;
                        updateButtonStatus();

                        // Hide form, show details
                        $(".start-job-section").hide();
                        $(".start-job-details-section").show();
                        alert('Job started successfully!');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Failed to start job'));
                }
            });
        });

        // Perform Diagnosis Submit
        $(".diagnosis-complete-btn").on("click", function(e) {
            e.preventDefault();

            const diagnosisTypes = [];
            $('.diagnosis-type-checkbox:checked').each(function() {
                diagnosisTypes.push($(this).val());
            });

            const diagnosisNotes = $('#diagnosis_notes').val();

            if (diagnosisTypes.length === 0 || !diagnosisNotes) {
                alert('Please select at least one diagnosis type and enter notes');
                return;
            }

            $.ajax({
                url: `/crm/assigned-jobs/${assignmentId}/perform-diagnosis`,
                method: 'POST',
                data: {
                    diagnosis_types: diagnosisTypes,
                    diagnosis_notes: diagnosisNotes,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Display diagnosis details
                        let diagnosisHtml = '';
                        diagnosisTypes.forEach(type => {
                            diagnosisHtml += `<li class="list-group-item border-0">${type}</li>`;
                        });
                        $('#display_diagnosis_types').html(diagnosisHtml);
                        $('#display_diagnosis_notes').text(diagnosisNotes);

                        // Update workflow status
                        workflowStatus.diagnosis = true;
                        updateButtonStatus();

                        // Hide form, show details
                        $(".diagnosis-section").hide();
                        $(".diagnosis-details-section").show();
                        alert('Diagnosis saved successfully!');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Failed to save diagnosis'));
                }
            });
        });

        // Take Action Submit
        $(".take-action-complete-btn").on("click", function(e) {
            e.preventDefault();

            const formData = new FormData($('#actionTakenForm')[0]);
            formData.append('_token', '{{ csrf_token() }}');

            if (!$('#fix_description').val()) {
                alert('Please enter fix description');
                return;
            }

            $.ajax({
                url: `/crm/assigned-jobs/${assignmentId}/take-action`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Display action taken details
                        $('#display_fix_description').text($('#fix_description').val());

                        // Handle file displays
                        if (response.data.before_screenshot) {
                            $('#display_before_screenshot').attr('href', `/storage/${response.data.before_screenshot}`);
                            $('#display_before_screenshot_container').show();
                            $('#display_before_screenshot_na').hide();
                        }

                        if (response.data.after_screenshot) {
                            $('#display_after_screenshot').attr('href', `/storage/${response.data.after_screenshot}`);
                            $('#display_after_screenshot_container').show();
                            $('#display_after_screenshot_na').hide();
                        }

                        if (response.data.logs_file) {
                            $('#display_logs').attr('href', `/storage/${response.data.logs_file}`);
                            $('#display_logs_container').show();
                            $('#display_logs_na').hide();
                        }

                        // Update workflow status
                        workflowStatus.actionTaken = true;
                        updateButtonStatus();

                        // Hide form, show details
                        $(".action-taken-section").hide();
                        $(".action-taken-details-section").show();
                        alert('Action taken saved successfully!');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Failed to save action'));
                }
            });
        });

        // Escalate to On-Site
        $(".escalate-btn").on("click", function(e) {
            e.preventDefault();
            $(".escalate-section").show();
        });

        // Auto Submit Escalation
        $(".escalate-auto-submit-btn").on("click", function(e) {
            e.preventDefault();

            // Auto-fill with default values
            $('#reason_for_escalation').val('Hardware Failure');
            $('#escalation_notes').val('Escalated for on-site inspection and resolution');

            // Trigger submit
            submitEscalation();
        });

        $(".escalate-submit-btn").on("click", function(e) {
            e.preventDefault();
            submitEscalation();
        });

        function submitEscalation() {
            const formData = {
                reason_for_escalation: $('#reason_for_escalation').val(),
                escalation_notes: $('#escalation_notes').val(),
            };

            if (!formData.reason_for_escalation || !formData.escalation_notes) {
                alert('Please fill all required fields');
                return;
            }

            $.ajax({
                url: `/crm/assigned-jobs/${assignmentId}/escalate`,
                method: 'POST',
                data: {
                    ...formData,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Update workflow status
                        workflowStatus.escalated = true;
                        updateButtonStatus();

                        alert('Job escalated to on-site successfully! Redirecting to assigned jobs list...');
                        setTimeout(() => {
                            window.location.href = '{{ route("assigned-jobs.index") }}';
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Failed to escalate job'));
                }
            });
        }

        // Complete Job
        $(".complete-job-btn").on("click", function(e) {
            e.preventDefault();
            $(".complete-job-section").show();
        });

        $(".complete-job-submit-btn").on("click", function(e) {
            e.preventDefault();

            const formData = {
                time_spent: $('#time_spent').val(),
                result: $('#result').val(),
                client_feedback: $('#client_feedback').val(),
            };

            if (!formData.time_spent || !formData.result || !formData.client_feedback) {
                alert('Please fill all required fields');
                return;
            }

            $.ajax({
                url: `/crm/assigned-jobs/${assignmentId}/complete-job`,
                method: 'POST',
                data: {
                    ...formData,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Update workflow status
                        workflowStatus.completed = true;
                        updateButtonStatus();

                        alert('Job completed successfully! Redirecting...');
                        setTimeout(() => {
                            window.location.href = '{{ route("assigned-jobs.index") }}';
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Failed to complete job'));
                }
            });
        });

        // Perform Diagnosis Button
        $(".perform-diagnosis-btn").on("click", function(e) {
            e.preventDefault();
            $(".diagnosis-section").show();
        });

        // Take Action Button
        $(".take-action-btn").on("click", function(e) {
            e.preventDefault();
            $(".action-taken-section").show();
        });
    });

    // Update button status based on workflow completion
    function updateButtonStatus() {
        // Start Job Button
        if (workflowStatus.startJob) {
            $('[data-step="1"]').removeClass('btn-primary').addClass('btn-success');
            $('[data-step="1"] .workflow-status').show();
        }

        // Diagnosis Button
        if (workflowStatus.diagnosis) {
            $('[data-step="2"]').removeClass('btn-info').addClass('btn-success');
            $('[data-step="2"] .workflow-status').show();
        }

        // Action Taken Button
        if (workflowStatus.actionTaken) {
            $('[data-step="3"]').removeClass('btn-warning').addClass('btn-success');
            $('[data-step="3"] .workflow-status').show();
        }

        // Escalate Button
        if (workflowStatus.escalated) {
            $('[data-step="4"]').removeClass('btn-danger').addClass('btn-success');
            $('[data-step="4"] .workflow-status').show();
        }

        // Complete Job Button
        if (workflowStatus.completed) {
            $('[data-step="5"]').removeClass('btn-success').addClass('btn-success');
            $('[data-step="5"] .workflow-status').show();
        }
    }

    // Load existing workflow data
    function loadWorkflowData() {
        @if($assignment->workflow)
            const workflow = {!! json_encode($assignment->workflow) !!};

            // Load Start Job data
            if (workflow.start_job_completed_at) {
                workflowStatus.startJob = true;
                $('#display_client_connected').text(workflow.client_connected_via || 'N/A');
                $('#display_client_confirmation').text(workflow.client_confirmation || 'N/A');
                $('#display_remote_tool').text(workflow.remote_tool_used || 'N/A');
                $(".start-job-section").hide();
                $(".start-job-details-section").show();
            }

            // Load Diagnosis data
            if (workflow.diagnosis_completed_at) {
                workflowStatus.diagnosis = true;
                let diagnosisHtml = '';
                if (workflow.diagnosis_types && workflow.diagnosis_types.length > 0) {
                    workflow.diagnosis_types.forEach(type => {
                        diagnosisHtml += `<li class="list-group-item border-0">${type}</li>`;
                    });
                }
                $('#display_diagnosis_types').html(diagnosisHtml || '<li class="list-group-item border-0">N/A</li>');
                $('#display_diagnosis_notes').text(workflow.diagnosis_notes || 'N/A');
                $(".diagnosis-section").hide();
                $(".diagnosis-details-section").show();
            }

            // Load Action Taken data
            if (workflow.action_taken_completed_at) {
                workflowStatus.actionTaken = true;
                $('#display_fix_description').text(workflow.fix_description || 'N/A');

                if (workflow.before_screenshot) {
                    $('#display_before_screenshot').attr('href', `/storage/${workflow.before_screenshot}`);
                    $('#display_before_screenshot_container').show();
                    $('#display_before_screenshot_na').hide();
                }

                if (workflow.after_screenshot) {
                    $('#display_after_screenshot').attr('href', `/storage/${workflow.after_screenshot}`);
                    $('#display_after_screenshot_container').show();
                    $('#display_after_screenshot_na').hide();
                }

                if (workflow.logs_file) {
                    $('#display_logs').attr('href', `/storage/${workflow.logs_file}`);
                    $('#display_logs_container').show();
                    $('#display_logs_na').hide();
                }

                $(".action-taken-section").hide();
                $(".action-taken-details-section").show();
            }
        @endif
    }
</script>

@endsection