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
                                <h5 class="card-title mb-0">AMC Request Details</h5>
                                <div>
                                    <span
                                        class="fw-bold text-dark">#AMC-{{ str_pad($amcService->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    @if ($amcService->status == 'Active')
                                        <span class="badge bg-success ms-2">Active</span>
                                    @elseif($amcService->status == 'Pending')
                                        <span class="badge bg-warning ms-2">Pending</span>
                                    @else
                                        <span class="badge bg-secondary ms-2">{{ $amcService->status }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            {{-- {{ $amcService }} --}}
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Customer Name:</span>
                                            <span>{{ $amcService->full_name }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Contact No:</span>
                                            <span>{{ $amcService->phone }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Email:</span>
                                            <span>{{ $amcService->email }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">DOB:</span>
                                            <span>{{ $amcService->dob ? $amcService->dob->format('d M Y') : 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Customer Type:</span>
                                            <span>{{ $amcService->customer_type ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Company Name:</span>
                                            <span>{{ $amcService->company_name ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">GST No:</span>
                                            <span>{{ $amcService->gst_no ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">PAN No:</span>
                                            <span>{{ $amcService->pan_no ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Created By:</span>
                                            <span>{{ $amcService->creator->name ?? 'System' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Created At:</span>
                                            <span>{{ $amcService->created_at->format('d M Y, h:i A') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AMC Plan Details Card -->
                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">AMC Plan Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Plan Name:</span>
                                            <span>{{ $amcService->amcPlan->plan_name ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Start Date:</span>
                                            <span>{{ $amcService->plan_start_date ? $amcService->plan_start_date->format('d M Y') : 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Priority Level:</span>
                                            <span>{{ $amcService->priority_level ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Plan Duration:</span>
                                            <span>{{ $amcService->plan_duration ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">End Date:</span>
                                            <span>
                                                @php
                                                    $endDate = null;
                                                    if ($amcService->plan_start_date && $amcService->plan_duration) {
                                                        $startDate = \Carbon\Carbon::parse(
                                                            $amcService->plan_start_date,
                                                        );
                                                        $duration = $amcService->plan_duration;

                                                        // Extract number from duration string
                                                        preg_match('/\d+/', $duration, $matches);
                                                        $number = isset($matches[0]) ? (int) $matches[0] : 0;

                                                        if (stripos($duration, 'month') !== false) {
                                                            $endDate = $startDate->copy()->addMonths($number);
                                                        } elseif (stripos($duration, 'year') !== false) {
                                                            $endDate = $startDate->copy()->addYears($number);
                                                        } elseif (stripos($duration, 'day') !== false) {
                                                            $endDate = $startDate->copy()->addDays($number);
                                                        }
                                                    }
                                                @endphp
                                                {{ $endDate ? $endDate->format('d M Y') : ($amcService->plan_end_date ? $amcService->plan_end_date->format('d M Y') : 'N/A') }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Total Amount:</span>
                                            <span
                                                class="fw-bold text-success">₹{{ number_format($amcService->total_amount, 2) }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Branches Card -->
                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Branch Information</h5>
                        </div>
                        <div class="card-body">
                            @forelse($amcService->branches as $index => $branch)
                                <div class="border rounded p-3 mb-3">
                                    <h6 class="fw-bold mb-3">Branch #{{ $index + 1 }}: {{ $branch->branch_name }}</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2"><span class="fw-semibold">Address:</span>
                                                {{ $branch->address_line1 }}</p>
                                            @if ($branch->address_line2)
                                                <p class="mb-2"><span class="fw-semibold">Address Line 2:</span>
                                                    {{ $branch->address_line2 }}</p>
                                            @endif
                                            <p class="mb-2"><span class="fw-semibold">City:</span> {{ $branch->city }}
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2"><span class="fw-semibold">State:</span> {{ $branch->state }}
                                            </p>
                                            <p class="mb-2"><span class="fw-semibold">Pincode:</span>
                                                {{ $branch->pincode }}</p>
                                            @if ($branch->contact_person)
                                                <p class="mb-2"><span class="fw-semibold">Contact Person:</span>
                                                    {{ $branch->contact_person }} ({{ $branch->contact_no }})</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No branches added</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Products Card -->
                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Product Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Type</th>
                                            <th>Brand</th>
                                            <th>Model No</th>
                                            <th>Serial No</th>
                                            <th>Purchase Date</th>
                                            <th>Warranty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($amcService->products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->type->parent_categories ?? '-' }}</td>
                                                <td>{{ $product->brand->brand_title ?? '-' }}</td>
                                                <td>{{ $product->model_no ?? '-' }}</td>
                                                <td>{{ $product->serial_no ?? '-' }}</td>
                                                <td>{{ $product->purchase_date ? $product->purchase_date->format('d M Y') : '-' }}
                                                </td>
                                                <td>{{ $product->warranty_status ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">No products added</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <!-- Assigned Engineers Display -->
                            @if ($amcService->activeAssignment)
                                <div class="card mt-3" id="assignedEngineersCard">
                                    <div class="card-header border-bottom-dashed bg-light">
                                        <h5 class="card-title mb-0">Assigned Engineers</h5>
                                    </div>
                                    <div class="card-body">
                                        @if ($amcService->activeAssignment->assignment_type === 'Individual')
                                            <!-- Individual Engineer Card -->
                                            <div class="border rounded p-3 bg-success-subtle">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 fw-bold">
                                                            {{ $amcService->activeAssignment->engineer->first_name }}
                                                            {{ $amcService->activeAssignment->engineer->last_name }}
                                                        </h6>
                                                        <p class="mb-1 text-muted small">
                                                            <i class="mdi mdi-briefcase"></i>
                                                            {{ $amcService->activeAssignment->engineer->designation }}
                                                        </p>
                                                        <p class="mb-1 text-muted small">
                                                            <i class="mdi mdi-office-building"></i>
                                                            {{ $amcService->activeAssignment->engineer->department }}
                                                        </p>
                                                        <p class="mb-0 text-muted small">
                                                            <i class="mdi mdi-phone"></i>
                                                            {{ $amcService->activeAssignment->engineer->phone }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <span class="badge bg-success">Individual Assignment</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Group Assignment Card -->
                                            <div class="border rounded p-3 bg-info-subtle">
                                                <h6 class="mb-3 fw-bold">
                                                    <i class="mdi mdi-account-group"></i> Group:
                                                    {{ $amcService->activeAssignment->group_name }}
                                                    <span
                                                        class="badge bg-info ms-2">{{ $amcService->activeAssignment->groupEngineers->count() }}
                                                        Engineers</span>
                                                </h6>

                                                <div class="row">
                                                    @foreach ($amcService->activeAssignment->groupEngineers as $groupEngineer)
                                                        <div class="col-md-6 mb-3">
                                                            <div
                                                                class="border rounded p-2 {{ $groupEngineer->pivot->is_supervisor ? 'bg-warning-subtle' : 'bg-white' }}">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-grow-1">
                                                                        <h6 class="mb-1 fw-semibold">
                                                                            {{ $groupEngineer->first_name }}
                                                                            {{ $groupEngineer->last_name }}
                                                                            @if ($groupEngineer->pivot->is_supervisor)
                                                                                <span
                                                                                    class="supervisor-badge">SUPERVISOR</span>
                                                                            @endif
                                                                        </h6>
                                                                        <p class="mb-0 text-muted small">
                                                                            <i class="mdi mdi-briefcase"></i>
                                                                            {{ $groupEngineer->designation }} |
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

                                        <div class="mt-3 text-muted small">
                                            <i class="mdi mdi-clock-outline"></i> Assigned on:
                                            {{ $amcService->activeAssignment->assigned_at->format('d M Y, h:i A') }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="card mt-3">
                                <div class="card-body text-center">
                                    <a href="{{ route('service-request.edit-amc', $amcService->id) }}"
                                        class="btn btn-warning">
                                        <i class="mdi mdi-pencil"></i> Edit AMC Request
                                    </a>
                                    <a href="{{ route('service-request.index') }}" class="btn btn-secondary">
                                        <i class="mdi mdi-arrow-left"></i> Back to List
                                    </a>
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
                        if ($(this).val() === 'Individual') {
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
                        if (assignmentType === 'Individual') {
                            if (!$('#engineer_id').val()) {
                                alert('Please select an engineer');
                                return;
                            }
                        } else if (assignmentType === 'Group') {
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
                            url: '{{ route('service-request.assign-engineer') }}',
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
                                const error = xhr.responseJSON?.message ||
                                    'Error assigning engineer. Please try again.';
                                alert(error);
                            }
                        });
                    });
                });
            </script>
        @endsection
