@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="pt-2">
                <!-- Breadcrumb -->
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Visit Details</h4>
                    </div>
                    
                </div>

                <div class="row">
                    <!-- Customer Details Card -->
                    <div class="col-lg-6 mb-3">
                        <div class="card h-100">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Customer Details</h5>
                            </div>
                            <div class="card-body">
                                @php
                                    $branch = $visit->amcService->branches->first();
                                @endphp
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold">Customer Name:</span>
                                        <span>{{ $visit->amcService->full_name ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold">Contact Number:</span>
                                        <span>{{ $visit->amcService->phone ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold">Email:</span>
                                        <span>{{ $visit->amcService->email ?? 'N/A' }}</span>
                                    </li>
                                    @if($visit->amcService->customer_type == 'Company')
                                        <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Company Name:</span>
                                            <span>{{ $visit->amcService->company_name ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">GST No:</span>
                                            <span>{{ $visit->amcService->gst_no ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">PAN No:</span>
                                            <span>{{ $visit->amcService->pan_no ?? 'N/A' }}</span>
                                        </li>
                                    @endif
                                    @if($branch)
                                        <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold d-block mb-2">Address:</span>
                                            <div class="ms-3">
                                                <div class="mb-1"> {{ $branch->full_address }}</div>
                                            </div>
                                        </li>
                                    @else
                                        <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Company Address:</span>
                                            <span class="text-end">{{ $visit->amcService->company_address ?? 'N/A' }}</span>
                                        </li>
                                    @endif
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold">AMC Plan:</span>
                                        <span>{{ $visit->amcService->amcPlan->plan_name ?? 'N/A' }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Engineer Details Card -->
                    <div class="col-lg-6 mb-3">
                        <div class="card h-100">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Engineer Details</h5>
                            </div>
                            <div class="card-body">
                                @php
                                    $activeAssignment = $visit->activeAssignment;
                                    $allAssignments = $visit->engineerAssignments()->orderBy('created_at', 'desc')->get();
                                    $transferredAssignments = $allAssignments->where('status', 'Transferred');
                                @endphp

                                @if($transferredAssignments->count() > 0)
                                    <div class="alert alert-warning mb-3">
                                        <h6 class="alert-heading mb-2"><i class="bx bx-info-circle me-1"></i> Transfer History</h6>
                                        @foreach($transferredAssignments as $transferred)
                                            <div class="mb-2">
                                                <strong>Previous Assignment:</strong>
                                                @if($transferred->assignment_type == 'Individual')
                                                    {{ $transferred->engineer->first_name ?? '' }} {{ $transferred->engineer->last_name ?? '' }}
                                                @else
                                                    Group: {{ $transferred->group_name }}
                                                @endif
                                                <br>
                                                <small class="text-muted">
                                                    Transferred on {{ $transferred->transferred_at ? $transferred->transferred_at->format('d M Y h:i A') : 'N/A' }}
                                                </small>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if($activeAssignment)
                                    @if($activeAssignment->assignment_type == 'Individual')
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Assignment Type:</span>
                                                <span><span class="badge bg-info-subtle text-info">Individual</span></span>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Engineer Name:</span>
                                                <span>{{ $activeAssignment->engineer->first_name ?? '' }} {{ $activeAssignment->engineer->last_name ?? '' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Designation:</span>
                                                <span>{{ $activeAssignment->engineer->designation ?? 'N/A' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Contact:</span>
                                                <span>{{ $activeAssignment->engineer->phone ?? 'N/A' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Email:</span>
                                                <span>{{ $activeAssignment->engineer->email ?? 'N/A' }}</span>
                                            </li>
                                        </ul>
                                    @else
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Assignment Type:</span>
                                                <span><span class="badge bg-primary-subtle text-primary">Group</span></span>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Group Name:</span>
                                                <span class="fw-bold">{{ $activeAssignment->group_name }}</span>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Supervisor:</span>
                                                <span>{{ $activeAssignment->supervisor->first_name ?? '' }} {{ $activeAssignment->supervisor->last_name ?? '' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Total Members:</span>
                                                <span>{{ $activeAssignment->groupMembers->count() }}</span>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="fw-semibold d-block mb-2">Group Members:</span>
                                                <div class="ms-3">
                                                    @foreach($activeAssignment->groupMembers as $member)
                                                        <div class="mb-1">
                                                            <i class="bx bx-user-circle me-1"></i>
                                                            {{ $member->engineer->first_name ?? '' }} {{ $member->engineer->last_name ?? '' }}
                                                            @if($member->is_supervisor)
                                                                <span class="badge bg-warning-subtle text-warning ms-1">Supervisor</span>
                                                            @endif
                                                        </div>
                                                    @endforeach


                                                </div>
                                            </li>
                                        </ul>
                                    @endif
                                @else
                                    <div class="text-center text-muted py-4">
                                        <i class="bx bx-user-x fs-1"></i>
                                        <p class="mb-0">No engineer assigned yet</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visit Details Card -->
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Visit Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Service ID:</span>
                                                <span>
                                                    <a href="{{ route('amc-services.view', $visit->amc_service_id) }}">
                                                        #{{ $visit->amcService->id ?? 'N/A' }}
                                                    </a>
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Visit Number:</span>
                                                <span>{{ $visit->visit_number }}</span>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Assigned Date:</span>
                                                <span>
                                                    @if($visit->activeAssignment)
                                                        {{ $visit->activeAssignment->assigned_at ? $visit->activeAssignment->assigned_at->format('d M Y h:i A') : 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Visit Date:</span>
                                                <span>{{ $visit->scheduled_date ? $visit->scheduled_date->format('d M Y h:i A') : 'N/A' }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Issue Type:</span>
                                                <span>{{ $visit->issue_type ?? 'N/A' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Status:</span>
                                                <span>
                                                    @if($visit->status == 'Completed')
                                                        <span class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                    @elseif($visit->status == 'Upcoming')
                                                        <span class="badge bg-warning-subtle text-warning fw-semibold">Upcoming</span>
                                                    @else
                                                        <span class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $visit->status }}</span>
                                                    @endif
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Report:</span>
                                                <span>{{ $visit->report ?? 'Not submitted yet' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Notes:</span>
                                                <span>{{ $visit->notes ?? 'N/A' }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Card -->
                @if($visit->amcService->products->count() > 0)
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Products Covered</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th>Type</th>
                                                <th>Brand</th>
                                                <th>Serial Number</th>
                                                <th>Model Number</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($visit->amcService->products as $index => $product)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $product->product_name }}</td>
                                                    <td>{{ $product->type->parent_categories ?? 'N/A' }}</td>
                                                    <td>{{ $product->brand->brand_title ?? 'N/A' }}</td>
                                                    <td>{{ $product->serial_no ?? 'N/A' }}</td>
                                                    <td>{{ $product->model_no ?? 'N/A' }}</td>
                                                    <td>{{ $product->quantity ?? 1 }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Back Button -->
                <div class="row">
                    <div class="col-12">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="bx bx-arrow-back me-1"></i> Back
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
