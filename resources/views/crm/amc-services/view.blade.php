@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row pt-3">
                <div class="col-xl-8">
                    <!-- Customer Details Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">AMC Service Details</h5>
                                <div>
                                    <span
                                        class="fw-bold text-dark">#AMC-{{ str_pad($amcService->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    <span class="badge bg-success ms-2">Active</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
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
                                            <span class="fw-semibold">Plan Type:</span>
                                            <span>{{ $amcService->amcPlan->plan_type ?? 'N/A' }}</span>
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
                                            <span class="fw-semibold">Total Visits:</span>
                                            <span>{{ $amcService->amcPlan->total_visits ?? 'N/A' }}</span>
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

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex flex-row justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title flex-grow-1 mb-0">
                                        Service Upcoming/History Details
                                    </h5>
                                </div>
                                <div class="d-flex flex-row justify-content-between align-items-center gap-2">
                                    @php
                                        $totalVisits = $amcService->amcPlan->total_visits ?? 0;
                                        $completedVisits = $amcService->visits()->where('status', 'Completed')->count();
                                        $remainingVisits = $totalVisits - $completedVisits;
                                        $nextVisit = $amcService->visits()->whereIn('status', ['Pending', 'Upcoming'])->orderBy('scheduled_date')->first();
                                    @endphp

                                    @if($amcService->visits->count() == 0)
                                        <button class="btn btn-sm btn-primary" onclick="generateVisits({{ $amcService->id }})">
                                            <i class="bx bx-plus"></i> Generate Visits
                                        </button>
                                    @else
                                        @if($nextVisit)
                                            <div>
                                                <span>Next Visit Date:</span>
                                                <span class="p-1 rounded bg-warning-subtle text-warning fw-semibold">
                                                    {{ $nextVisit->scheduled_date->format('d M Y') }}
                                                </span>
                                            </div>
                                        @endif

                                        @if($remainingVisits > 0)
                                            <div>
                                                <span>Remaining Visits:</span>
                                                <span class="p-1 rounded bg-warning-subtle text-warning fw-semibold">
                                                    {{ $remainingVisits }}
                                                </span>
                                            </div>
                                        @else
                                            <div>
                                                <span>Our Visits:</span>
                                                <span class="p-1 rounded bg-success-subtle text-success fw-semibold">
                                                    Completed
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Upcoming/History Details Table --}}
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($amcService->visits()->orderBy('visit_number')->get() as $index => $visit)
                                        <tr class="align-middle">
                                            <td>{{ $visit->visit_number }}</td>
                                            <td>
                                                @php
                                                    $activeAssignment = $visit->activeAssignment;
                                                @endphp
                                                @if($activeAssignment)
                                                    @if($activeAssignment->assignment_type == 'Individual')
                                                        <div>
                                                            <span class="badge bg-info-subtle text-info mb-1">Individual</span><br>
                                                            <strong>{{ $activeAssignment->engineer->first_name ?? '' }} {{ $activeAssignment->engineer->last_name ?? '' }}</strong>
                                                        </div>
                                                    @else
                                                        <div>
                                                            <span class="badge bg-primary-subtle text-primary mb-1">Group</span><br>
                                                            <strong>{{ $activeAssignment->group_name }}</strong><br>
                                                            <small class="text-muted">Supervisor: {{ $activeAssignment->supervisor->first_name ?? '' }} {{ $activeAssignment->supervisor->last_name ?? '' }}</small><br>
                                                            <small class="text-muted">Members: {{ $activeAssignment->groupMembers->count() }}</small>
                                                        </div>
                                                    @endif
                                                @elseif($visit->engineer)
                                                    {{ $visit->engineer->first_name }} {{ $visit->engineer->last_name }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ $visit->scheduled_date->format('d M Y h:i A') }}</td>
                                            <td>
                                                @if($visit->issue_type)
                                                    {{ $visit->issue_type }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($visit->report)
                                                    <button class="btn btn-sm btn-primary">View Report</button>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($visit->status == 'Completed')
                                                    <span class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                @elseif($visit->status == 'Upcoming')
                                                    <span class="badge bg-warning-subtle text-warning fw-semibold">Upcoming</span>
                                                @elseif($visit->status == 'Cancelled')
                                                    <span class="badge bg-danger-subtle text-danger fw-semibold">Cancelled</span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary fw-semibold">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($visit->status != 'Completed')
                                                    @if($visit->engineer_id)
                                                        <button class="btn btn-sm btn-info"
                                                            onclick="openEditVisitModal({{ $visit->id }}, {{ $visit->engineer_id }}, '{{ $visit->scheduled_date->format('Y-m-d\TH:i') }}')">
                                                            <i class="bx bx-edit"></i> Edit
                                                        </button>
                                                    @else
                                                        <button class="btn btn-sm btn-primary"
                                                            onclick="openAssignVisitModal({{ $visit->id }}, '{{ $visit->scheduled_date->format('Y-m-d\TH:i') }}')">
                                                            <i class="bx bx-user-plus"></i> Assign Engineer
                                                        </button>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                No visits generated yet. Click "Generate Visits" button above.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Branches Card -->
                    @if ($amcService->branches->count() > 0)
                        <div class="card mt-3">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Branch Information</h5>
                            </div>
                            <div class="card-body">
                                @forelse($amcService->branches as $index => $branch)
                                    <div class="border rounded p-3 mb-3">
                                        <h6 class="fw-bold mb-3">Branch #{{ $index + 1 }}: {{ $branch->branch_name }}
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-2"><span class="fw-semibold">Address:</span>
                                                    {{ $branch->address_line1 }}</p>
                                                @if ($branch->address_line2)
                                                    <p class="mb-2"><span class="fw-semibold">Address Line 2:</span>
                                                        {{ $branch->address_line2 }}</p>
                                                @endif
                                                <p class="mb-2"><span class="fw-semibold">City:</span>
                                                    {{ $branch->city }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-2"><span class="fw-semibold">State:</span>
                                                    {{ $branch->state }}</p>
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
                    @endif

                    <!-- Products Card -->
                    @if ($amcService->products->count() > 0)
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
                                                    <td colspan="8" class="text-center text-muted">No products added
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-xl-4">
                    <!-- Assign Engineer Card -->
                    {{-- <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Assign Engineer</h5>
                        </div>
                        <div class="card-body">
                            <form id="assignEngineerForm">
                                @csrf
                                <input type="hidden" name="amc_service_id" value="{{ $amcService->id }}">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Assignment Type</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="assignment_type"
                                                id="typeIndividual" value="Individual" checked>
                                            <label class="form-check-label" for="typeIndividual">Individual</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="assignment_type"
                                                id="typeGroup" value="Group">
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
                                                    {{ $engineer->first_name }} {{ $engineer->last_name }} -
                                                    {{ $engineer->designation }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Group Assignment -->
                                <div id="groupSection" style="display: none;">
                                    <div class="mb-3">
                                        <label for="group_name" class="form-label">Group Name</label>
                                        <input type="text" name="group_name" id="group_name" class="form-control"
                                            placeholder="Enter Group Name">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Select Engineers</label>
                                        <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                            @foreach ($engineers as $engineer)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input engineer-checkbox" type="checkbox"
                                                        name="engineer_ids[]" value="{{ $engineer->id }}"
                                                        id="eng_{{ $engineer->id }}">
                                                    <label class="form-check-label" for="eng_{{ $engineer->id }}">
                                                        {{ $engineer->first_name }} {{ $engineer->last_name }} -
                                                        {{ $engineer->designation }}
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
                    </div> --}}

                    <!-- Assigned Engineers History -->
                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Assigned Engineers History</h5>
                        </div>
                        <div class="card-body">
                            @if ($amcService->engineerAssignments && $amcService->engineerAssignments->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 50px;">#</th>
                                                <th>Assignment Type</th>
                                                <th>Engineer(s)</th>
                                                <th>Assigned Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($amcService->engineerAssignments->sortByDesc('assigned_at') as $index => $assignment)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $assignment->assignment_type == 'Individual' ? 'bg-info' : 'bg-primary' }}">
                                                            {{ $assignment->assignment_type }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if ($assignment->assignment_type == 'Individual')
                                                            <div>
                                                                <strong>{{ $assignment->engineer->first_name ?? '' }}
                                                                    {{ $assignment->engineer->last_name ?? '' }}</strong>
                                                                <br>
                                                                <small
                                                                    class="text-muted">{{ $assignment->engineer->designation ?? '' }}</small>
                                                            </div>
                                                        @else
                                                            <div>
                                                                <strong>Group: {{ $assignment->group_name }}</strong>
                                                                <br>
                                                                <small class="text-muted">
                                                                    Supervisor:
                                                                    {{ $assignment->supervisor->first_name ?? '' }}
                                                                    {{ $assignment->supervisor->last_name ?? '' }}
                                                                </small>
                                                                <br>
                                                                <small class="text-muted">
                                                                    Members: {{ $assignment->groupEngineers->count() }}
                                                                </small>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <i class="mdi mdi-clock-outline"></i>
                                                        {{ $assignment->assigned_at ? $assignment->assigned_at->format('d M Y, h:i A') : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $assignment->status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ $assignment->status }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="mdi mdi-account-off mdi-48px"></i>
                                    <p class="mb-0">No engineers assigned yet</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions Card -->
                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('amc-services.edit', $amcService->id) }}" class="btn btn-warning">
                                    <i class="bx bx-pencil"></i> Edit AMC Service
                                </a>
                                <a href="{{ route('amc-services.index') }}" class="btn btn-secondary">
                                    <i class="bx bx-arrow-back"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Assign/Edit Visit Engineer Modal -->
    <div class="modal fade" id="assignVisitEngineerModal" tabindex="-1" aria-labelledby="assignVisitEngineerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="assignVisitEngineerForm">
                    @csrf
                    <input type="hidden" id="visit_id" name="visit_id">
                    <input type="hidden" id="is_edit" name="is_edit" value="0">

                    <div class="modal-header">
                        <h5 class="modal-title" id="assignVisitEngineerModalLabel">Assign Engineer to Visit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-3">
                        <div class="mb-3">
                            <label for="modal_scheduled_date" class="form-label">Visit Date <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="scheduled_date" id="modal_scheduled_date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Assignment Type <span class="text-danger">*</span></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="assignment_type"
                                        id="modal_typeIndividual" value="Individual" checked>
                                    <label class="form-check-label" for="modal_typeIndividual">Individual</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="assignment_type"
                                        id="modal_typeGroup" value="Group">
                                    <label class="form-check-label" for="modal_typeGroup">Group</label>
                                </div>
                            </div>
                        </div>

                        <!-- Individual Assignment -->
                        <div id="modal_individualSection">
                            <div class="mb-3">
                                <label for="modal_engineer_id" class="form-label">Select Engineer <span class="text-danger">*</span></label>
                                <select name="engineer_id" id="modal_engineer_id" class="form-select">
                                    <option value="">--Select Engineer--</option>
                                    @foreach ($engineers as $engineer)
                                        <option value="{{ $engineer->id }}">
                                            {{ $engineer->first_name }} {{ $engineer->last_name }} - {{ $engineer->designation }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Group Assignment -->
                        <div id="modal_groupSection" style="display: none;">
                            <div class="mb-3">
                                <label for="modal_group_name" class="form-label">Group Name <span class="text-danger">*</span></label>
                                <input type="text" name="group_name" id="modal_group_name" class="form-control"
                                    placeholder="Enter Group Name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Select Engineers <span class="text-danger">*</span></label>
                                <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                    @foreach ($engineers as $engineer)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input modal-engineer-checkbox" type="checkbox"
                                                name="engineer_ids[]" value="{{ $engineer->id }}"
                                                id="modal_eng_{{ $engineer->id }}">
                                            <label class="form-check-label" for="modal_eng_{{ $engineer->id }}">
                                                {{ $engineer->first_name }} {{ $engineer->last_name }} -
                                                {{ $engineer->designation }}
                                            </label>
                                            <input class="form-check-input ms-3" type="radio"
                                                name="supervisor_id" value="{{ $engineer->id }}"
                                                id="modal_sup_{{ $engineer->id }}">
                                            <label class="form-check-label small text-muted"
                                                for="modal_sup_{{ $engineer->id }}">
                                                (Supervisor)
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-muted">Check engineers to add to group, select one as supervisor</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Toggle between Individual and Group assignment (Sidebar form)
        $('input[name="assignment_type"]').change(function() {
            if ($(this).val() === 'Individual') {
                $('#individualSection').show();
                $('#groupSection').hide();
            } else {
                $('#individualSection').hide();
                $('#groupSection').show();
            }
        });

        // Toggle between Individual and Group assignment (Modal)
        $('input[name="assignment_type"]').change(function() {
            if ($(this).val() === 'Individual') {
                $('#modal_individualSection').show();
                $('#modal_groupSection').hide();
            } else {
                $('#modal_individualSection').hide();
                $('#modal_groupSection').show();
            }
        });

        // Handle form submission
        $('#assignEngineerForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            // Validation
            let assignmentType = $('input[name="assignment_type"]:checked').val();

            if (assignmentType === 'Individual') {
                if (!$('#engineer_id').val()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please select an engineer'
                    });
                    return;
                }
            } else {
                if (!$('#group_name').val()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please enter group name'
                    });
                    return;
                }

                let checkedEngineers = $('.engineer-checkbox:checked').length;
                if (checkedEngineers === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please select at least one engineer'
                    });
                    return;
                }

                if (!$('input[name="supervisor_id"]:checked').val()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please select a supervisor'
                    });
                    return;
                }
            }

            // Submit form
            $.ajax({
                url: '{{ route('amc-services.assign-engineer') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'An error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorMessage
                    });
                }
            });
        });

        // Handle visit engineer assignment form
        $('#assignVisitEngineerForm').submit(function(e) {
            e.preventDefault();

            let assignmentType = $('input[name="assignment_type"]:checked').val();

            // Validation
            if (assignmentType === 'Individual') {
                if (!$('#modal_engineer_id').val()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please select an engineer'
                    });
                    return;
                }
            } else {
                if (!$('#modal_group_name').val()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please enter group name'
                    });
                    return;
                }

                let checkedEngineers = $('.modal-engineer-checkbox:checked').length;
                if (checkedEngineers === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please select at least one engineer'
                    });
                    return;
                }

                if (!$('input[name="supervisor_id"]:checked').val()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please select a supervisor'
                    });
                    return;
                }
            }

            let formData = new FormData(this);
            let isEdit = $('#is_edit').val() === '1';
            let url = isEdit ? '{{ route('amc-services.update-visit-engineer') }}' : '{{ route('amc-services.assign-visit-engineer') }}';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'An error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorMessage
                    });
                }
            });
        });
    });

    // Generate visits function
    function generateVisits(amcServiceId) {
        Swal.fire({
            title: 'Generate Visits?',
            text: 'This will create visit schedules based on the AMC plan duration and total visits.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, generate!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url('/crm/amc-service-generate-visits') }}/' + amcServiceId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    }
                });
            }
        });
    }

    // Open assign visit modal
    function openAssignVisitModal(visitId, scheduledDate) {
        $('#visit_id').val(visitId);
        $('#is_edit').val('0');
        $('#modal_engineer_id').val('');
        $('#modal_scheduled_date').val(scheduledDate);
        $('#modal_group_name').val('');
        $('.modal-engineer-checkbox').prop('checked', false);
        $('input[name="supervisor_id"]').prop('checked', false);
        $('#modal_typeIndividual').prop('checked', true);
        $('#modal_individualSection').show();
        $('#modal_groupSection').hide();
        $('#assignVisitEngineerModalLabel').text('Assign Engineer to Visit');
        $('#assignVisitEngineerModal').modal('show');
    }

    // Open edit visit modal
    function openEditVisitModal(visitId, engineerId, scheduledDate) {
        $('#visit_id').val(visitId);
        $('#is_edit').val('1');
        $('#modal_engineer_id').val(engineerId);
        $('#modal_scheduled_date').val(scheduledDate);
        $('#modal_group_name').val('');
        $('.modal-engineer-checkbox').prop('checked', false);
        $('input[name="supervisor_id"]').prop('checked', false);
        $('#modal_typeIndividual').prop('checked', true);
        $('#modal_individualSection').show();
        $('#modal_groupSection').hide();
        $('#assignVisitEngineerModalLabel').text('Edit Visit Engineer');
        $('#assignVisitEngineerModal').modal('show');
    }
</script>
@endsection
