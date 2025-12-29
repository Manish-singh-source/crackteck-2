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
                                            	{{-- 0 - Pending, 1 - Approved, 2 - Assigned, 3 - Rejected, 4 - In Transfer, 5 - Transferred, 6 - In Progress, 7 - Completed --}}
                                            @if ($request->status == 0)
                                                <span class="badge bg-warning-subtle text-warning fw-semibold">Pending</span>
                                            @elseif($request->status == 1)
                                                <span class="badge bg-success-subtle text-success fw-semibold">Approved</span>
                                            @elseif($request->status == 2)
                                                <span class="badge bg-primary-subtle text-primary fw-semibold">Assigned</span>
                                            @elseif($request->status == 3)
                                                <span class="badge bg-danger-subtle text-danger fw-semibold">Rejected</span>
                                            @elseif($request->status == 4)
                                                <span class="badge bg-info-subtle text-info fw-semibold">In Transfer</span>
                                            @elseif($request->status == 5)
                                                <span class="badge bg-success-subtle text-success fw-semibold">Transferred</span>
                                            @elseif($request->status == 6)
                                                <span class="badge bg-info-subtle text-info fw-semibold">In Progress</span>
                                            @elseif($request->status == 7)
                                                <span class="badge bg-success-subtle text-success fw-semibold">Completed</span>
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

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <!-- Assigned Engineers Display -->
                            @if ($request->activeAssignment)
                                <div class="card mt-3" id="assignedEngineersCard">
                                    <div class="card-header border-bottom-dashed bg-light">
                                        <h5 class="card-title mb-0">Assigned Engineers</h5>
                                    </div>
                                    <div class="card-body">
                                        @if ($request->activeAssignment->assignment_type === 'Individual')
                                            <!-- Individual Engineer Card -->
                                            <div class="border rounded p-3 bg-success-subtle">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 fw-bold">
                                                            {{ $request->activeAssignment->engineer->first_name }}
                                                            {{ $request->activeAssignment->engineer->last_name }}
                                                        </h6>
                                                        <p class="mb-1 text-muted small">
                                                            <i class="mdi mdi-briefcase"></i>
                                                            {{ $request->activeAssignment->engineer->designation }}
                                                        </p>
                                                        <p class="mb-1 text-muted small">
                                                            <i class="mdi mdi-office-building"></i>
                                                            {{ $request->activeAssignment->engineer->department }}
                                                        </p>
                                                        <p class="mb-0 text-muted small">
                                                            <i class="mdi mdi-phone"></i>
                                                            {{ $request->activeAssignment->engineer->phone }}
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
                                                    {{ $request->activeAssignment->group_name }}
                                                    <span
                                                        class="badge bg-info ms-2">{{ $request->activeAssignment->groupEngineers->count() }}
                                                        Engineers</span>
                                                </h6>

                                                <div class="row">
                                                    @foreach ($request->activeAssignment->groupEngineers as $groupEngineer)
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
                                            {{ $request->activeAssignment->assigned_at->format('d M Y, h:i A') }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="card mt-3">
                                <div class="card-body text-center">
                                    <a href="{{ route('service-request.edit-quick-service-request', $request->id) }}"
                                        class="btn btn-warning">
                                        <i class="mdi mdi-pencil"></i> Edit Request
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
        </div>
    </div>

@endsection
