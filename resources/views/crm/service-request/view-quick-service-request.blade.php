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
    
    <div class="content">
        <div class="container-fluid">
            <div class="row py-3">
                <div class="col-xl-8 mx-auto">

                    <!-- Customer Details Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Customer Details</h5>
                                <div>
                                    <span class="fw-bold text-dark">{{ $request->request_id }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Customer Name:</span>
                                            <span>{{ $request->customer->first_name ?? '' }}
                                                {{ $request->customer->last_name ?? '' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Contact No:</span>
                                            <span>{{ $request->customer->phone ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Email:</span>
                                            <span>{{ $request->customer->email ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">DOB:</span>
                                            <span>{{ $request->customer->dob }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Customer Type:</span>
                                            @if ($request->customer->customer_type == 0)
                                                <span>E-commerce</span>
                                            @elseif ($request->customer->customer_type == 1)
                                                <span>AMC</span>
                                            @elseif ($request->customer->customer_type == 2)
                                                <span>Both</span>
                                            @elseif ($request->customer->customer_type == 3)
                                                <span>Offline</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Company Name:</span>
                                            <span>{{ $request->customerCompany->company_name ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">GST No:</span>
                                            <span>{{ $request->customerCompany->gst_no ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">PAN No:</span>
                                            <span>{{ $request->customerPan->pan_number ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Created At:</span>
                                            <span>{{ $request->created_at->format('d M Y, h:i A') }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Status:</span>
                                            	{{-- 0 - Pending, 1 - Admin Approved, 2 - Assigned Engineer, 3 - Engineer Approved, 4 - Engineer Not Approved, 5 - In Transfer, 6 - Transferred, 7 - In Progress, 8 - Picking, 9 - Picked, 10 - Completed, 11 - On Hold --}}
                                            @if ($request->status == 0)
                                                <span class="badge bg-warning-subtle text-warning fw-semibold">Pending</span>
                                            @elseif($request->status == 1)
                                                <span class="badge bg-success-subtle text-success fw-semibold">Admin Approved</span>
                                                @elseif($request->status == 2)
                                                <span class="badge bg-primary-subtle text-primary fw-semibold">Assigned Engineer</span>
                                            @elseif($request->status == 3)
                                                <span class="badge bg-success-subtle text-success fw-semibold">Engineer Approved</span>
                                            @elseif($request->status == 4)
                                                <span class="badge bg-danger-subtle text-danger fw-semibold">Engineer Not Approved</span>
                                            @elseif($request->status == 5)
                                                <span class="badge bg-info-subtle text-info fw-semibold">In Transfer</span>
                                            @elseif($request->status == 6)
                                                <span class="badge bg-success-subtle text-success fw-semibold">Transferred</span>
                                            @elseif($request->status == 7)
                                                <span class="badge bg-info-subtle text-info fw-semibold">In Progress</span>
                                            @elseif($request->status == 8)
                                                <span class="badge bg-info-subtle text-info fw-semibold">Picking</span>
                                            @elseif($request->status == 9)
                                                <span class="badge bg-success-subtle text-success fw-semibold">Picked</span>
                                            @elseif($request->status == 10)
                                                <span class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                            @elseif($request->status == 11)
                                                <span class="badge bg-warning-subtle text-warning fw-semibold">On Hold</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Service Details Card -->
                    {{-- <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Quick Service Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Service Name:</span>
                                            <span>{{ $request->quickService->name ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Service Price:</span>
                                            <span
                                                class="fw-bold text-success">₹{{ number_format($request->quickService->service_price ?? 0, 2) }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Description:</span>
                                            <span>{{ $request->quickService->description ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Product Details Card -->
                    {{-- <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Product Information</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Product Name:</span>
                                            <span>{{ $request->product_name ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Model No:</span>
                                            <span>{{ $request->model_no ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Brand:</span>
                                            <span>{{ $request->brand ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">SKU:</span>
                                            <span>{{ $request->sku ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">HSN:</span>
                                            <span>{{ $request->hsn ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                                @if ($request->issue)
                                <div class="col-12 mt-3">
                                    <div class="border-top pt-3">
                                        <span class="fw-semibold">Issue Description:</span>
                                        <p class="mt-2 mb-0">{{ $request->issue }}</p>
                                    </div>
                                </div>
                                @endif
                                @if ($request->image)
                                <div class="col-12 mt-3">
                                    <div class="border-top pt-3">
                                        <span class="fw-semibold">Product Image:</span>
                                        <div class="mt-2">
                                            <img src="{{ asset($request->image) }}" alt="Product Image" class="img-thumbnail" style="max-width: 300px;">
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div> --}}

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
                                            <th>Service Type</th>
                                            <th>Service Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($request->products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->type }}</td>
                                                <td>{{ $product->model_no }}</td>
                                                <td>{{ $product->hsn }}</td>
                                                <td>{{ $product->brand }}</td>
                                                <td>{{ $product->item_code_id }}</td>
                                                <td>{{ $product->service_charge }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7" class="text-end"><strong>Total</strong></td>
                                            <td><strong>{{ $request->products->sum('service_charge') }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-4">

                    <!-- Assign Engineer Card -->
                    @if($request->status == 1)
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Assign Engineer</h5>
                        </div>
                        <div class="card-body">
                                    <form id="assignEngineerForm">
                                        @csrf
                                        <input type="hidden" name="service_request_id" value="{{ $request->id }}">

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Assignment Type</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="assignment_type"
                                                        id="typeIndividual" value="0" checked>
                                                    <label class="form-check-label"
                                                        for="typeIndividual">Individual</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="assignment_type"
                                                        id="typeGroup" value="1">
                                                    <label class="form-check-label" for="typeGroup">Group</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Individual Assignment -->
                                        <div id="individualSection">
                                            <div class="mb-3">
                                                <label for="engineer_id" class="form-label">Select Engineer</label>
                                                <select name="engineer_id" id="engineer_id" class="form-select">
                                                    <option value="">--Select Engineer--</option>
                                                    @foreach ($engineers as $engineer)
                                                        <option value="{{ $engineer->id }}">
                                                            {{ $engineer->first_name }} {{ $engineer->last_name }} 
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Group Assignment -->
                                        <div id="groupSection" style="display: none;">
                                            <div class="mb-3">
                                                <label for="group_name" class="form-label">Group Name</label>
                                                <input type="text" name="group_name" id="group_name"
                                                    class="form-control" placeholder="Enter Group Name">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Select Engineers</label>
                                                <div class="border rounded p-3"
                                                    style="max-height: 300px; overflow-y: auto;">
                                                    @foreach ($engineers as $engineer)
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input engineer-checkbox"
                                                                type="checkbox" name="engineer_ids[]"
                                                                value="{{ $engineer->id }}"
                                                                id="eng_{{ $engineer->id }}">
                                                            <label class="form-check-label"
                                                                for="eng_{{ $engineer->id }}">
                                                                {{ $engineer->first_name }} {{ $engineer->last_name }} 
                                                            </label>
                                                            <input class="form-check-input ms-3" type="radio"
                                                                name="supervisor_id" value="{{ $engineer->id }}"
                                                                id="sup_{{ $engineer->id }}">
                                                            <label class="form-check-label small text-muted"
                                                                for="sup_{{ $engineer->id }}">
                                                                (Supervisor)
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <small class="text-muted">Check engineers to add to group, select one as
                                                    supervisor</small>
                                            </div>
                                        </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-account-plus"></i> Assign Engineer
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                <!-- Assigned Engineers Display -->
                @if ($request->activeAssignment)
                    <div class="card mt-3" id="assignedEngineersCard">
                        <div class="card-header border-bottom-dashed bg-light">
                            <h5 class="card-title mb-0">
                                <i class="mdi mdi-account-check"></i> Current Assignment
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($request->activeAssignment->assignment_type === '0')
                                <!-- Individual Engineer Card -->
                                <div class="border rounded p-3 bg-success-subtle">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">
                                                {{ $request->activeAssignment->engineer->first_name }}
                                                {{ $request->activeAssignment->engineer->last_name }}
                                            </h6>
                                            <p class="mb-1 text-muted small">
                                                <i class="mdi mdi-phone"></i>
                                                {{ $request->activeAssignment->engineer->phone }}
                                            </p>
                                            <p class="mb-0 text-muted small">
                                                <i class="mdi mdi-clock-outline"></i>
                                                Assigned: {{ $request->activeAssignment->assigned_at }}
                                            </p>
                                        </div>
                                        <div>
                                            <span class="badge bg-success">Active</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Group Assignment Card -->
                                <div class="border rounded p-3 bg-info-subtle">
                                    <h6 class="mb-3 fw-bold">
                                        <i class="mdi mdi-account-group"></i> Group:
                                        {{ $request->activeAssignment->group_name }}
                                        <span class="badge bg-info ms-2">{{ $request->activeAssignment->groupEngineers->count() }} Engineers</span>
                                    </h6>
                                    <p class="mb-3 text-muted small">
                                        <i class="mdi mdi-clock-outline"></i>
                                        Assigned: {{ $request->activeAssignment->assigned_at }}
                                    </p>

                                    <div class="row">
                                        @foreach ($request->activeAssignment->groupEngineers as $groupEngineer)
                                            <div class="col-md-12 mb-2">
                                                <div class="border rounded p-2 {{ $groupEngineer->pivot->is_supervisor ? 'bg-warning-subtle' : 'bg-white' }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1 fw-semibold">
                                                                {{ $groupEngineer->first_name }}
                                                                {{ $groupEngineer->last_name }}
                                                                @if ($groupEngineer->pivot->is_supervisor)
                                                                    <span class="supervisor-badge">SUPERVISOR</span>
                                                                @endif
                                                            </h6>
                                                            <p class="mb-0 text-muted small">
                                                                <i class="mdi mdi-phone"></i>
                                                                {{ $groupEngineer->phone }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Previous Assignments History -->
                @if ($request->inactiveAssignments && $request->inactiveAssignments->count() > 0)
                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed bg-light">
                            <h5 class="card-title mb-0">
                                <i class="mdi mdi-history"></i> Assignment History
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach ($request->inactiveAssignments as $assignment)
                                <div class="border rounded p-3 mb-3 bg-light">
                                    @if ($assignment->assignment_type === '0')
                                        <!-- Individual Assignment -->
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold">
                                                    {{ $assignment->engineer->first_name }}
                                                    {{ $assignment->engineer->last_name }}
                                                </h6>
                                                <p class="mb-1 text-muted small">
                                                    <i class="mdi mdi-phone"></i>
                                                    {{ $assignment->engineer->phone }}
                                                </p>
                                                <p class="mb-1 text-muted small">
                                                    <i class="mdi mdi-clock-outline"></i>
                                                    Assigned: {{ $assignment->assigned_at }}
                                                </p>
                                                @if($assignment->transferred_at)
                                                    <p class="mb-0 text-muted small">
                                                        <i class="mdi mdi-transfer"></i>
                                                        Transferred: {{ $assignment->transferred_at }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="badge bg-secondary">Inactive</span>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Group Assignment -->
                                        <h6 class="mb-2 fw-semibold">
                                            <i class="mdi mdi-account-group"></i> Group: {{ $assignment->group_name }}
                                        </h6>
                                        <p class="mb-2 text-muted small">
                                            <i class="mdi mdi-clock-outline"></i>
                                            Assigned: {{ $assignment->assigned_at }}
                                        </p>
                                        @if($assignment->transferred_at)
                                            <p class="mb-2 text-muted small">
                                                <i class="mdi mdi-transfer"></i>
                                                Transferred: {{ $assignment->transferred_at }}
                                            </p>
                                        @endif
                                        <div class="mt-2">
                                            @foreach ($assignment->groupEngineers as $groupEngineer)
                                                <span class="badge bg-secondary me-1 mb-1">
                                                    {{ $groupEngineer->first_name }} {{ $groupEngineer->last_name }}
                                                    @if ($groupEngineer->pivot->is_supervisor)
                                                        (Supervisor)
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

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
                        if ($(this).val() === '0') {
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
                        if (assignmentType === '0') {
                            if (!$('#engineer_id').val()) {
                                alert('Please select an engineer');
                                return;
                            }
                        } else if (assignmentType === '1') {
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

                        $.ajax({
                            url: '{{ route('service-request.assign-quick-service-engineer') }}',
                            method: 'POST',
                            data: formData,
                            success: function(response) {
                                console.log('Assignment Response:', response);
                                if (response.success) {
                                    let message = response.message;
                                    if (response.status_updated) {
                                        message += '\n\nStatus Updated:';
                                        message += '\nOld Status: ' + response.old_status;
                                        message += '\nNew Status: ' + response.new_status + ' (Assigned Engineer)';
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
                });
            </script>
        @endsection