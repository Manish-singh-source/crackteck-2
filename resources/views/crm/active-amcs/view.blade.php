@extends('crm/layouts/master')

@section('content')

    <style>
        .engineer-checkbox {
            margin-right: 10px;
        }

        .supervisor-badge {
            background-color: #ffc107;
            color: #000;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            margin-left: 5px;
        }
    </style>


    @php
        $status = [
            'pending' => 'Pending',
            'active' => 'Active',
            'inactive' => 'Inactive',
            'expired' => 'Expired',
            'cancelled' => 'Cancelled',
            'admin_approved' => 'Admin Approved',
            'assigned_engineer' => 'Assigned Engineer',
            'engineer_approved' => 'Engineer Approved',
            'engineer_not_approved' => 'Engineer Not Approved',
            'in_transfer' => 'In Transfer',
            'transferred' => 'Transferred',
            'in_progress' => 'In Progress',
            'picking' => 'Picking',
            'picked' => 'Picked',
            'completed' => 'Completed',
            'on_hold' => 'On Hold',
        ];

        $statusColor = [
            'pending' => 'bg-warning-subtle text-warning',
            'active' => 'bg-success-subtle text-success',
            'inactive' => 'bg-secondary-subtle text-secondary',
            'expired' => 'bg-danger-subtle text-danger',
            'cancelled' => 'bg-danger-subtle text-danger',
            'admin_approved' => 'bg-success-subtle text-success',
            'assigned_engineer' => 'bg-primary-subtle text-primary',
            'engineer_approved' => 'bg-success-subtle text-success',
            'engineer_not_approved' => 'bg-danger-subtle text-danger',
            'in_transfer' => 'bg-info-subtle text-info',
            'transferred' => 'bg-success-subtle text-success',
            'in_progress' => 'bg-info-subtle text-info',
            'picking' => 'bg-success-subtle text-success',
            'picked' => 'bg-success-subtle text-success',
            'completed' => 'bg-success-subtle text-success',
            'on_hold' => 'bg-warning-subtle text-warning',
        ];
    @endphp

    <div class="content">
        <div class="container-fluid">
            <div class="row py-3">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">View AMC Service Request</h4>
                    </div>
                </div>
                <div class="col-xl-8 mx-auto">

                    <!-- Customer Details Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Customer Personal Details</h5>
                                <div>
                                    <span class="fw-bold text-dark">{{ $amcRequest->request_id }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Customer Name:</span>
                                            <span>{{ $amcRequest->customer->first_name ?? '' }}
                                                {{ $amcRequest->customer->last_name ?? '' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Contact No:</span>
                                            <span>{{ $amcRequest->customer->phone ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Email:</span>
                                            <span>{{ $amcRequest->customer->email ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">DOB:</span>
                                            <span>{{ $amcRequest->customer->dob }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Customer Type:</span>
                                            @if ($amcRequest->customer->customer_type == 'ecommerce')
                                                <span>E-commerce</span>
                                            @elseif ($amcRequest->customer->customer_type == 'amc')
                                                <span>AMC</span>
                                            @elseif ($amcRequest->customer->customer_type == 'both')
                                                <span>Both</span>
                                            @elseif ($amcRequest->customer->customer_type == 'offline')
                                                <span>Offline</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Company Name:</span>
                                            <span>{{ $amcRequest->customerCompany->company_name ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">GST No:</span>
                                            <span>{{ $amcRequest->customerCompany->gst_no ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">PAN No:</span>
                                            <span>{{ $amcRequest->customerPan->pan_number ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Status:</span>
                                            @php $index = $amcRequest->status; @endphp
                                            <span class="badge {{ $statusColor[$index] }} fw-semibold">
                                                {{ $status[$index] }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Visit Date:</span>
                                            <span>{{ $amcRequest->reschedule_date ?? $amcRequest->visit_date }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Customer Details Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Customer Address Details</h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Branch Name:</span>
                                            <span>{{ $amcRequest->customerAddress->branch_name ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Address Line 1:</span>
                                            <span>{{ $amcRequest->customerAddress->address1 ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Address Line 2:</span>
                                            <span>{{ $amcRequest->customerAddress->address2 ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">State:</span>
                                            <span>{{ $amcRequest->customerAddress->state ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Country:</span>
                                            <span>{{ $amcRequest->customerAddress->country ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">City:</span>
                                            <span>{{ $amcRequest->customerAddress->city ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Pin Code:</span>
                                            <span>{{ $amcRequest->customerAddress->pincode ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Service Visits History Details --}}
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex flex-row justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title flex-grow-1 mb-0">
                                        Service History Details
                                    </h5>
                                </div>
                                <div class="d-flex flex-row justify-content-between align-items-center gap-2">
                                    {{-- 
                                    <div>
                                        <span>
                                            Next Visit Date:
                                        </span>
                                        <span
                                            class="p-1 rounded bg-warning-subtle text-warning fw-semibold">{{ $amcRequest->amcScheduleMeetings->first()?->scheduled_at ? \Carbon\Carbon::parse($amcRequest->amcScheduleMeetings->first()->scheduled_at)->format('d M Y') : 'N/A' }}</span>
                                    </div> 
                                    --}}
                                    <div>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addVisitModal2">Assign Engineer</button>
                                        <!-- Modal -->

                                        <div class="modal fade" id="addVisitModal2" tabindex="-1"
                                            aria-labelledby="addVisitModalLabel2" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="assignEngineerModalForm">
                                                        @csrf

                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addVisitModalLabel2">Assign
                                                                Engineer</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body p-2">
                                                            <input type="hidden" name="service_request_id"
                                                                value="{{ $amcRequest->id }}">

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Assignment Type</label>
                                                                <div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="assignment_type"
                                                                            id="typeIndividualModal" value="individual"
                                                                            checked>
                                                                        <label class="form-check-label"
                                                                            for="typeIndividualModal">Individual</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="assignment_type"
                                                                            id="typeGroupModal" value="group">
                                                                        <label class="form-check-label"
                                                                            for="typeGroupModal">Group</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Individual Assignment -->
                                                            <div id="individualSectionModal">
                                                                <div class="mb-3">
                                                                    <label for="engineer_id_modal"
                                                                        class="form-label">Select Engineer</label>
                                                                    <select name="engineer_id" id="engineer_id_modal"
                                                                        class="form-select">
                                                                        <option value="">--Select Engineer--</option>
                                                                        @foreach ($engineers as $engineer)
                                                                            <option value="{{ $engineer->id }}">
                                                                                {{ $engineer->first_name }}
                                                                                {{ $engineer->last_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Group Assignment -->
                                                            <div id="groupSectionModal" style="display: none;">
                                                                <div class="mb-3">
                                                                    <label for="group_name_modal" class="form-label">Group
                                                                        Name</label>
                                                                    <input type="text" name="group_name"
                                                                        id="group_name_modal" class="form-control"
                                                                        placeholder="Enter Group Name">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Select Engineers</label>
                                                                    <div class="border rounded p-3"
                                                                        style="max-height: 300px; overflow-y: auto;">
                                                                        @foreach ($engineers as $engineer)
                                                                            <div class="form-check mb-2">
                                                                                <input
                                                                                    class="form-check-input engineer-checkbox-modal"
                                                                                    type="checkbox" name="engineer_ids[]"
                                                                                    value="{{ $engineer->id }}"
                                                                                    id="eng_modal_{{ $engineer->id }}">
                                                                                <label class="form-check-label"
                                                                                    for="eng_modal_{{ $engineer->id }}">
                                                                                    {{ $engineer->first_name }}
                                                                                    {{ $engineer->last_name }}
                                                                                </label>
                                                                                <input class="form-check-input ms-3"
                                                                                    type="radio" name="supervisor_id"
                                                                                    value="{{ $engineer->id }}"
                                                                                    id="sup_modal_{{ $engineer->id }}">
                                                                                <label
                                                                                    class="form-check-label small text-muted"
                                                                                    for="sup_modal_{{ $engineer->id }}">
                                                                                    (Supervisor)
                                                                                </label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                    <small class="text-muted">Check engineers to add to
                                                                        group, select one as
                                                                        supervisor</small>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Assign</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-striped table-borderless dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Engineer Name</th>
                                        <th>Visit Date</th>
                                        <th>Issue Type</th>
                                        <th>Report</th>
                                        <th>Status</th>
                                        <th>Action </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($amcRequest->amcScheduleMeetings as $index => $meeting)
                                        <tr class="align-middle">
                                            <td>
                                                {{ $index + 1 }}    
                                            </td>
                                            <td>
                                                {{ $meeting->activeAssignment->engineer->first_name ?? 'N/A' }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($meeting->scheduled_at)->format('d M Y') }}</td>
                                            <td>
                                                Maintanance
                                            </td>
                                            <td>
                                                NA
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-warning-subtle text-warning fw-semibold">{{ $meeting->status ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <!-- Re-Scheduled Button -->
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#rescheduleModal">
                                                    Re-Scheduled
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Re-Schedule Visit Modal -->
                    <div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="#">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rescheduleModalLabel">
                                            Reschedule Appointment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body p-2">
                                        <p>Please enter new schedule date:</p>
                                        <input type="date" id="newSchedule" class="form-control"
                                            placeholder="Enter new date/time">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Product Details Card --}}
                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Product Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Product Name</th>
                                            <th>Type</th>
                                            <th>Model No</th>
                                            <th>HSN</th>
                                            <th>Brand</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($amcRequest->amcProducts as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->type ?? '-' }}</td>
                                                <td>{{ $product->model_no ?? '-' }}</td>
                                                <td>{{ $product->hsn ?? '-' }}</td>
                                                <td>{{ $product->brand ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Toggle between Individual and Group sections
            $('input[name="assignment_type"]').change(function() {
                if ($(this).val() === 'individual') {
                    $('#individualSection').show();
                    $('#groupSection').hide();
                    // Clear group fields
                    $('#group_name').val('');
                    $('.engineer-checkbox').prop('checked', false);
                    $('input[name="supervisor_id"]').prop('checked', false);
                } else {
                    $('#individualSection').hide();
                    $('#groupSection').show();
                    // Clear individual field
                    $('#engineer_id').val('');
                }
            });

            // Sync checkbox with supervisor radio
            $('.engineer-checkbox').change(function() {
                const engineerId = $(this).val();
                const supervisorRadio = $('input[name="supervisor_id"][value="' + engineerId + '"]');

                if (!$(this).is(':checked')) {
                    // If unchecked, also uncheck supervisor radio
                    supervisorRadio.prop('checked', false);
                }
            });

            // Ensure supervisor is also checked as engineer
            $('input[name="supervisor_id"]').change(function() {
                const engineerId = $(this).val();
                const engineerCheckbox = $('.engineer-checkbox[value="' + engineerId + '"]');

                if (!engineerCheckbox.is(':checked')) {
                    engineerCheckbox.prop('checked', true);
                }
            });

            // Form submission
            $('#assignEngineerForm').submit(function(e) {
                e.preventDefault();

                const assignmentType = $('input[name="assignment_type"]:checked').val();

                // Validation
                if (assignmentType === 'individual') {
                    if (!$('#engineer_id').val()) {
                        alert('Please select an engineer');
                        return;
                    }
                } else if (assignmentType === 'group') {
                    if (!$('#group_name').val()) {
                        alert('Please enter group name');
                        return;
                    }

                    const checkedEngineers = $('.engineer-checkbox:checked').length;
                    if (checkedEngineers === 0) {
                        alert('Please select at least one engineer');
                        return;
                    }

                    if (!$('input[name="supervisor_id"]:checked').val()) {
                        alert('Please select a supervisor');
                        return;
                    }
                }

                // Submit via AJAX
                const formData = $(this).serialize();

                console.log(formData)
                $.ajax({
                    url: '{{ route('service-request.assign-quick-service-engineer') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // console.log('Assignment Response:', response);
                        if (response.success) {
                            let message = response.message;
                            if (response.status_updated) {
                                message += '\n\nStatus Updated:';
                                message += '\nOld Status: ' + response.old_status;
                                message += '\nNew Status: ' + response.new_status +
                                    ' (Assigned Engineer)';
                            }
                            alert(message);
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error('Assignment Error:', xhr);
                        const error = xhr.responseJSON?.message ||
                            'Error assigning engineer. Please try again.';
                        alert(error);
                    }
                });
            });

            // Modal Assign Engineer Form Handling (AMC modal)
            // Toggle between Individual and Group sections inside modal
            $('input[name="assignment_type_modal"]').change(function() {
                if ($(this).val() === 'individual') {
                    $('#individualSectionModal').show();
                    $('#groupSectionModal').hide();
                    // Clear group fields
                    $('#group_name_modal').val('');
                    $('.engineer-checkbox-modal').prop('checked', false);
                    $('input[name="supervisor_id"]').prop('checked', false);
                } else {
                    $('#individualSectionModal').hide();
                    $('#groupSectionModal').show();
                    // Clear individual field
                    $('#engineer_id_modal').val('');
                }
            });

            // Sync checkbox with supervisor radio (modal)
            $(document).on('change', '.engineer-checkbox-modal', function() {
                const engineerId = $(this).val();
                const supervisorRadio = $('input[name="supervisor_id"][value="' + engineerId + '"]');

                if (!$(this).is(':checked')) {
                    supervisorRadio.prop('checked', false);
                }
            });

            // Ensure supervisor is also checked as engineer (modal)
            $(document).on('change', 'input[name="supervisor_id"]', function() {
                const engineerId = $(this).val();
                const engineerCheckbox = $('.engineer-checkbox-modal[value="' + engineerId + '"]');

                if (!engineerCheckbox.is(':checked')) {
                    engineerCheckbox.prop('checked', true);
                }
            });

            // Modal form submission
            $('#assignEngineerModalForm').submit(function(e) {
                e.preventDefault();

                const assignmentType = $('input[name="assignment_type_modal"]:checked').val();

                // Validation
                if (assignmentType === 'individual') {
                    if (!$('#engineer_id_modal').val()) {
                        alert('Please select an engineer');
                        return;
                    }
                } else if (assignmentType === 'group') {
                    if (!$('#group_name_modal').val()) {
                        alert('Please enter group name');
                        return;
                    }

                    const checkedEngineers = $('.engineer-checkbox-modal:checked').length;
                    if (checkedEngineers === 0) {
                        alert('Please select at least one engineer');
                        return;
                    }

                    if (!$('input[name="supervisor_id"]:checked').val()) {
                        alert('Please select a supervisor');
                        return;
                    }
                }

                // Submit via AJAX
                const formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('service-request.assign-quick-service-engineer') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }   
                    },
                    error: function(xhr) {
                        console.error('Assignment Error:', xhr);
                        const error = xhr.responseJSON?.message ||
                            'Error assigning engineer. Please try again.';
                        alert(error);
                    }
                });
            });
        });

        // Pickup Assignment Form Handling
        $(document).ready(function() {
            // Show/hide delivery man or engineer section based on person type selection
            function updatePersonTypeSections() {
                var selectedType = $('input[name="assigned_person_type"]:checked').val();
                if (selectedType === 'delivery_man') {
                    $('#deliveryManSection').show();
                    $('#engineerSection').hide();
                    $('#assigned_person_id').prop('required', true);
                    $('#engineer_assigned_person_id').prop('required', false);
                } else {
                    $('#deliveryManSection').hide();
                    $('#engineerSection').show();
                    $('#assigned_person_id').prop('required', false);
                    $('#engineer_assigned_person_id').prop('required', true);
                }
            }

            // Initialize on page load
            updatePersonTypeSections();

            // Handle person type change
            $('input[name="assigned_person_type"]').change(function() {
                updatePersonTypeSections();
            });

            // Handle admin pickup action form submission
            $('#adminPickupActionForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                var submitBtn = $(this).find('button[type="submit"]');
                var originalBtnText = submitBtn.html();

                // Validate action is selected
                var action = $('#admin_action').val();
                if (!action) {
                    alert('Please select an action (Approve or Cancel)');
                    return;
                }

                submitBtn.prop('disabled', true).html(
                    '<i class="mdi mdi-loading mdi-spin"></i> Processing...');

                $.ajax({
                    url: "{{ route('service-request.pickup-admin-action') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        submitBtn.prop('disabled', false).html(originalBtnText);

                        if (response.success) {
                            alert('Action completed successfully!');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                        console.error('Admin Action Error:', xhr);
                        const error = xhr.responseJSON?.message ||
                            'Error processing admin action. Please try again.';
                        alert(error);
                    }
                });
            });

            // Handle pickup assignment form submission
            $('#assignPickupForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                var submitBtn = $(this).find('button[type="submit"]');
                var originalBtnText = submitBtn.html();

                // Validate assigned_person_type is selected
                var assignedPersonType = $('input[name="assigned_person_type"]:checked').val();
                if (!assignedPersonType) {
                    alert('Please select an Assigned Person Type (Delivery Man or Engineer)');
                    return;
                }

                submitBtn.prop('disabled', true).html(
                    '<i class="mdi mdi-loading mdi-spin"></i> Processing...');

                $.ajax({
                    url: "{{ route('service-request.assign-pickup') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        submitBtn.prop('disabled', false).html(originalBtnText);

                        if (response.success) {
                            alert('Pickup assigned successfully!');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                        console.error('Pickup Assignment Error:', xhr);
                        const error = xhr.responseJSON?.message ||
                            'Error assigning pickup. Please try again.';
                        alert(error);
                    }
                });
            });

            // Handle pickup received form submission
            $('[id^="pickupReceivedForm_"]').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                var submitBtn = $(this).find('button[type="submit"]');
                var originalBtnText = submitBtn.html();

                if (!confirm(
                        'Are you sure you want to mark this pickup as received? This will update the product and service request status to picked.'
                    )) {
                    return;
                }

                submitBtn.prop('disabled', true).html(
                    '<i class="mdi mdi-loading mdi-spin"></i> Processing...');

                $.ajax({
                    url: "{{ route('service-request.pickup-received') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        submitBtn.prop('disabled', false).html(originalBtnText);

                        if (response.success) {
                            alert('Pickup marked as received successfully!');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                        console.error('Pickup Received Error:', xhr);
                        const error = xhr.responseJSON?.message ||
                            'Error processing received action. Please try again.';
                        alert(error);
                    }
                });
            });

            // Handle return picked form submission
            $('[id^="returnPickedForm_"]').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                var submitBtn = $(this).find('button[type="submit"]');
                var originalBtnText = submitBtn.html();

                if (!confirm('Are you sure you want to mark this return as picked?')) {
                    return;
                }

                submitBtn.prop('disabled', true).html(
                    '<i class="mdi mdi-loading mdi-spin"></i> Processing...');

                $.ajax({
                    url: "{{ route('service-request.return-picked') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        submitBtn.prop('disabled', false).html(originalBtnText);

                        if (response.success) {
                            alert('Return marked as picked successfully!');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                        console.error('Return Picked Error:', xhr);
                        const error = xhr.responseJSON?.message ||
                            'Error processing return picked action. Please try again.';
                        alert(error);
                    }
                });
            });
        });

        // Function to add new diagnosis item
        function addDiagnosisItem(pickupId) {
            const container = document.getElementById('diagnosisListContainer_' + pickupId);
            const itemCount = container.querySelectorAll('.diagnosis-item').length;

            const newItem = document.createElement('div');
            newItem.className = 'diagnosis-item mb-2 p-2 border rounded bg-white';
            newItem.innerHTML = `
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="diagnosis_list[${itemCount}][component]" class="form-control" placeholder="Component Name" required>
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="diagnosis_list[${itemCount}][report]" class="form-control" placeholder="Report" required>
                    </div>
                    <div class="col-md-3">
                        <select name="diagnosis_list[${itemCount}][status]" class="form-select" required>
                            <option value="working">Working</option>
                            <option value="not_working">Not Working</option>
                            <option value="picking">Picking</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeDiagnosisItem(this)">
                    <i class="mdi mdi-delete"></i> Remove
                </button>
            `;

            container.appendChild(newItem);
        }

        // Function to remove diagnosis item
        function removeDiagnosisItem(button) {
            const item = button.closest('.diagnosis-item');
            if (item.parentElement.querySelectorAll('.diagnosis-item').length > 1) {
                item.remove();
            } else {
                alert('You must have at least one diagnosis item.');
            }
        }

        // Handle diagnosis form submission
        $(document).ready(function() {
            // Handle submit diagnosis form
            $('[id^="submitDiagnosisForm_"]').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                var submitBtn = $(this).find('button[type="submit"]');
                var originalBtnText = submitBtn.html();

                if (!confirm(
                        'Are you sure you want to submit this diagnosis? This will update the product status to Diagnosis Completed.'
                    )) {
                    return;
                }

                submitBtn.prop('disabled', true).html(
                    '<i class="mdi mdi-loading mdi-spin"></i> Processing...');

                $.ajax({
                    url: "{{ route('service-request.submit-diagnosis') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        submitBtn.prop('disabled', false).html(originalBtnText);

                        if (response.success) {
                            alert('Diagnosis submitted successfully!');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                        console.error('Diagnosis Submit Error:', xhr);
                        const error = xhr.responseJSON?.message ||
                            'Error submitting diagnosis. Please try again.';
                        alert(error);
                    }
                });
            });
        });

        // Return Assignment Form Handling
        $(document).ready(function() {
            // Show/hide delivery man or engineer section based on person type selection for returns
            function updateReturnPersonTypeSections(pickupId) {
                var selectedType = $('input[name="assigned_person_type"]:checked').val();
                if (selectedType === 'delivery_man') {
                    $('#returnDeliveryManSection_' + pickupId).show();
                    $('#returnEngineerSection_' + pickupId).hide();
                    $('#return_assigned_person_id_' + pickupId).prop('required', true);
                    $('#return_engineer_assigned_person_id_' + pickupId).prop('required', false);
                } else {
                    $('#returnDeliveryManSection_' + pickupId).hide();
                    $('#returnEngineerSection_' + pickupId).show();
                    $('#return_assigned_person_id_' + pickupId).prop('required', false);
                    $('#return_engineer_assigned_person_id_' + pickupId).prop('required', true);
                }
            }

            // Handle person type change for return forms
            $('.return-person-type').change(function() {
                var pickupId = $(this).attr('id').split('_').pop();
                updateReturnPersonTypeSections(pickupId);
            });

            // Initialize return person type sections on page load
            @if (isset($pickups) && $pickups->where('status', 'received')->count() > 0)
                @foreach ($pickups->where('status', 'received') as $receivedPickup)
                    updateReturnPersonTypeSections('{{ $receivedPickup->id }}');
                @endforeach
            @endif

            // Handle return assignment form submission
            $('[id^="assignReturnForm_"]').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                var submitBtn = $(this).find('button[type="submit"]');
                var originalBtnText = submitBtn.html();
                var pickupId = $(this).attr('id').split('_').pop();

                // Validate assigned_person_type is selected
                var assignedPersonType = $('input[name="assigned_person_type"]:checked').val();
                if (!assignedPersonType) {
                    alert('Please select an Assigned Person Type (Delivery Man or Engineer)');
                    return;
                }

                // Validate assigned_person_id is selected
                var assignedPersonId;
                if (assignedPersonType === 'delivery_man') {
                    assignedPersonId = $('#return_assigned_person_id_' + pickupId).val();
                    if (!assignedPersonId) {
                        alert('Please select a Delivery Man');
                        return;
                    }
                } else {
                    assignedPersonId = $('#return_engineer_assigned_person_id_' + pickupId).val();
                    if (!assignedPersonId) {
                        alert('Please select an Engineer');
                        return;
                    }
                }

                submitBtn.prop('disabled', true).html(
                    '<i class="mdi mdi-loading mdi-spin"></i> Processing...');

                $.ajax({
                    url: "{{ route('service-request.assign-return') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        submitBtn.prop('disabled', false).html(originalBtnText);

                        if (response.success) {
                            alert(
                                'Return assigned successfully! Delivery will be done shortly.'
                            );
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                        console.error('Return Assignment Error:', xhr);
                        const error = xhr.responseJSON?.message ||
                            'Error assigning return. Please try again.';
                        alert(error);
                    }
                });
            });
        });
    </script>
@endsection
