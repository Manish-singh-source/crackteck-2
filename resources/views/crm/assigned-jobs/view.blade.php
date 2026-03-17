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
                                            Service Request Details
                                        </h5>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush ">
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Service Request Id :
                                                    </span>
                                                    <span>
                                                        {{ $remoteSupportJob->serviceRequest->request_id }}
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Service Request Type :
                                                    </span>
                                                    <span>
                                                        {{ ucwords(str_replace('_', ' ', $remoteSupportJob->serviceRequest?->service_type)) }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush ">
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Service Request Date :
                                                    </span>
                                                    <span>
                                                        {{-- {{ $remoteSupportJob->serviceRequest?->request_date ? \App\Helpers\DateFormat::formatDateTime($remoteSupportJob->serviceRequest?->request_date) : 'N/A' }} --}}
                                                        {{ $remoteSupportJob->serviceRequest?->request_date }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header border-bottom-dashed">
                                    <div class="d-flex">
                                        <h5 class="card-title flex-grow-1 mb-0">
                                            Customer Details
                                        </h5>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush ">

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Customer Name :
                                                    </span>
                                                    <span>
                                                        {{ $remoteSupportJob->serviceRequest->customer->first_name }}
                                                        {{ $remoteSupportJob->serviceRequest->customer->last_name }}
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Contact no :
                                                    </span>
                                                    <span>
                                                        {{ $remoteSupportJob->serviceRequest->customer->phone }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush ">

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Email :
                                                    </span>
                                                    <span>
                                                        {{ $remoteSupportJob->serviceRequest->customer->email }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card shadow-none">
                                <div class="card-body">
                                    <table id="responsive-datatable"
                                        class="table table-striped table-borderless dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Model No</th>
                                                <th>SKU</th>
                                                <th>HSN</th>
                                                <th>Purchase Date</th>
                                                <th>Brand</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($remoteSupportJob?->serviceRequest?->products as $key => $product)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->productType?->device_type }}</td>
                                                    <td>{{ $product->model_no }}</td>
                                                    <td>{{ $product->sku }}</td>
                                                    <td>{{ $product->hsn }}</td>
                                                    <td>{{ $product->purchase_date ? \App\Helpers\DateFormat::formatDateTime($product->purchase_date) : 'N/A' }}</td>
                                                    <td>{{ $product->brand }}</td>
                                                    <td>{{ $product->description }}</td>
                                                    <td>{{ ucwords(str_replace('_', ' ', $product->status)) }}</td>
                                                    <td>
                                                        <a href="{{ route('assigned-jobs.diagnose', [$product->id, $id]) }}" class="btn btn-sm btn-primary">
                                                            {{ ($product->status == 'diagnosis_completed' || $product->status == 'escalated') ? 'View' : 'Start Diagnose'}}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="text-center">
                                                    No Data Found
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const assignmentId = 1;
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
                            $('#display_client_confirmation').text(formData
                            .client_confirmation);
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
                                diagnosisHtml +=
                                    `<li class="list-group-item border-0">${type}</li>`;
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
                        alert('Error: ' + (xhr.responseJSON?.message ||
                            'Failed to save diagnosis'));
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
                                $('#display_before_screenshot').attr('href',
                                    `/storage/${response.data.before_screenshot}`);
                                $('#display_before_screenshot_container').show();
                                $('#display_before_screenshot_na').hide();
                            }

                            if (response.data.after_screenshot) {
                                $('#display_after_screenshot').attr('href',
                                    `/storage/${response.data.after_screenshot}`);
                                $('#display_after_screenshot_container').show();
                                $('#display_after_screenshot_na').hide();
                            }

                            if (response.data.logs_file) {
                                $('#display_logs').attr('href',
                                    `/storage/${response.data.logs_file}`);
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
                        alert('Error: ' + (xhr.responseJSON?.message ||
                            'Failed to save action'));
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

                            alert(
                                'Job escalated to on-site successfully! Redirecting to assigned jobs list...');
                            setTimeout(() => {
                                window.location.href = '{{ route('assigned-jobs.index') }}';
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
                                window.location.href =
                                    '{{ route('assigned-jobs.index') }}';
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + (xhr.responseJSON?.message ||
                            'Failed to complete job'));
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
            const workflow = {!! json_encode([]) !!};

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
        }
    </script>
@endsection
