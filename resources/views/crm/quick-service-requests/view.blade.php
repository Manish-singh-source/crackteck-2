@extends('crm.layouts.master')

@section('title', 'Quick Service Request Details')

@section('content')
    <div class="content">
        <div class="container-fluid py-3">
            <!-- Page Breadcrumb -->
            {{-- <div class="page-breadcrumb mb-3">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('crm/index') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('service-request.index') }}">Service Requests</a></li>
                        <li class="breadcrumb-item active">Quick Service Request #QSR-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</li>
                    </ol>
                </nav>
            </div> --}}

            <!-- Error/Success Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <!-- Request Header Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Quick Service Request #QSR-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</h5>
                            <div>
                                @if ($request->status == 'completed')
                                    <span class="badge bg-success-subtle text-success fw-semibold fs-6">Completed</span>
                                @elseif($request->status == 'processing')
                                    <span class="badge bg-info-subtle text-info fw-semibold fs-6">Processing</span>
                                @elseif($request->status == 'active')
                                    <span class="badge bg-primary-subtle text-primary fw-semibold fs-6">Active</span>
                                @elseif($request->status == 'pending')
                                    <span class="badge bg-warning-subtle text-warning fw-semibold fs-6">Pending</span>
                                @elseif($request->status == 'cancel')
                                    <span class="badge bg-danger-subtle text-danger fw-semibold fs-6">Cancelled</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary fw-semibold fs-6">{{ ucfirst($request->status) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Request ID:</span>
                                            <span>#QSR-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Created At:</span>
                                            <span>{{ $request->created_at->format('d M Y, h:i A') }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Status:</span>
                                            <span>
                                                @if ($request->status == 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($request->status == 'processing')
                                                    <span class="badge bg-info">Processing</span>
                                                @elseif($request->status == 'active')
                                                    <span class="badge bg-primary">Active</span>
                                                @elseif($request->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($request->status == 'cancel')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($request->status) }}</span>
                                                @endif
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Quick Service:</span>
                                            <span>{{ $request->quickService->name ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Service Price:</span>
                                            <span class="fw-bold text-success">₹{{ number_format($request->quickService->service_price ?? 0, 2) }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Last Updated:</span>
                                            <span>{{ $request->updated_at->diffForHumans() }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Details Card -->
                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Customer Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Customer Name:</span>
                                            <span>{{ $request->customer->first_name ?? '' }} {{ $request->customer->last_name ?? '' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Contact No:</span>
                                            <span>{{ $request->customer->phone ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Email:</span>
                                            <span>{{ $request->customer->email ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Customer Type:</span>
                                            <span>{{ $request->customer->customer_type ?? 'N/A' }}</span>
                                        </li>


                                        @if($request->customer->company_name)
                                            <li class="list-group-item border-0 d-flex gap-3">
                                                <span class="fw-semibold">Company Name:</span>
                                                <span>{{ $request->customer->company_name }}</span>
                                            </li>
                                        @endif
                                        @if($request->customer->address)
                                            <li class="list-group-item border-0 d-flex gap-3">
                                                <span class="fw-semibold">Address:</span>
                                                <span>{{ $request->customer->address }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Card -->
                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Product Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Product Name:</span>
                                            <span>{{ $request->product_name }}</span>
                                        </li>
                                        @if($request->model_no)
                                            <li class="list-group-item border-0 d-flex gap-3">
                                                <span class="fw-semibold">Model No:</span>
                                                <span>{{ $request->model_no }}</span>
                                            </li>
                                        @endif
                                        @if($request->brand)
                                            <li class="list-group-item border-0 d-flex gap-3">
                                                <span class="fw-semibold">Brand:</span>
                                                <span>{{ $request->brand }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        @if($request->sku)
                                            <li class="list-group-item border-0 d-flex gap-3">
                                                <span class="fw-semibold">SKU:</span>
                                                <span>{{ $request->sku }}</span>
                                            </li>
                                        @endif
                                        @if($request->hsn)
                                            <li class="list-group-item border-0 d-flex gap-3">
                                                <span class="fw-semibold">HSN:</span>
                                                <span>{{ $request->hsn }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            @if($request->issue)
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6 class="fw-semibold mb-2">Issue Description:</h6>
                                        <p class="text-muted">{{ $request->issue }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($request->image)
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6 class="fw-semibold mb-2">Product Image:</h6>
                                        <img src="{{ asset('storage/' . $request->image) }}" alt="Product Image" class="img-thumbnail" style="max-width: 300px;">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Service Details Card -->
                    <div class="card mt-3">
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
                                            <span class="fw-bold text-success">₹{{ number_format($request->quickService->service_price ?? 0, 2) }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        @if($request->quickService && $request->quickService->service_description)
                                            <li class="list-group-item border-0">
                                                <span class="fw-semibold">Service Description:</span>
                                                <p class="text-muted mb-0 mt-2">{{ $request->quickService->service_description }}</p>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Engineer Assignment Section - Only show when status is 'processing' -->
                    @if($request->status === 'processing')
                        <div class="card mt-3">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Assign Engineer</h5>
                            </div>
                            <div class="card-body">
                                <form id="assignEngineerForm">
                                    @csrf
                                    <input type="hidden" name="quick_service_request_id" value="{{ $request->id }}">

                                    <div class="mb-3">
                                        <label class="form-label">Assignment Type <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="assignment_type" id="individual" value="Individual" checked>
                                                <label class="form-check-label" for="individual">Individual</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="assignment_type" id="group" value="Group">
                                                <label class="form-check-label" for="group">Group</label>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Individual Assignment -->
                                    <div id="individualSection">
                                        <div class="mb-3">
                                            <label for="engineer_id" class="form-label">Select Engineer <span class="text-danger">*</span></label>
                                            <select name="engineer_id" id="engineer_id" class="form-select">
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
                                    <div id="groupSection" style="display: none;">
                                        <div class="mb-3">
                                            <label for="group_name" class="form-label">Group Name <span class="text-danger">*</span></label>
                                            <input type="text" name="group_name" id="group_name" class="form-control" placeholder="Enter Group Name">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Select Engineers <span class="text-danger">*</span></label>
                                            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                                @foreach ($engineers as $engineer)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input engineer-checkbox" type="checkbox" name="engineer_ids[]" value="{{ $engineer->id }}" id="eng_{{ $engineer->id }}">
                                                        <label class="form-check-label" for="eng_{{ $engineer->id }}">
                                                            {{ $engineer->first_name }} {{ $engineer->last_name }} - {{ $engineer->designation }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Select Supervisor <span class="text-danger">*</span></label>
                                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                                @foreach ($engineers as $engineer)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="radio" name="supervisor_id" value="{{ $engineer->id }}" id="sup_{{ $engineer->id }}">
                                                        <label class="form-check-label" for="sup_{{ $engineer->id }}">
                                                            {{ $engineer->first_name }} {{ $engineer->last_name }} - {{ $engineer->designation }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" id="assignBtn">
                                        <i class="mdi mdi-account-plus me-1"></i> Assign Engineer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Assigned Engineers Display -->
                    @if($request->activeAssignment)
                        <div class="card mt-3" id="assignedEngineersCard">
                            <div class="card-header border-bottom-dashed bg-light">
                                <h5 class="card-title mb-0">Assigned Engineers</h5>
                            </div>
                            <div class="card-body">
                                @if($request->activeAssignment->assignment_type === 'Individual')
                                    <!-- Individual Engineer Card -->
                                    <div class="border rounded p-3 bg-success-subtle">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">
                                                    {{ $request->activeAssignment->engineer->first_name }} {{ $request->activeAssignment->engineer->last_name }}
                                                </h6>
                                                <p class="mb-1 text-muted small">
                                                    <i class="mdi mdi-briefcase"></i> {{ $request->activeAssignment->engineer->designation }}
                                                </p>
                                                <p class="mb-1 text-muted small">
                                                    <i class="mdi mdi-office-building"></i> {{ $request->activeAssignment->engineer->department }}
                                                </p>
                                                <p class="mb-0 text-muted small">
                                                    <i class="mdi mdi-phone"></i> {{ $request->activeAssignment->engineer->phone }}
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
                                            <i class="mdi mdi-account-group"></i> Group: {{ $request->activeAssignment->group_name }}
                                            <span class="badge bg-info ms-2">{{ $request->activeAssignment->groupEngineers->count() }} Engineers</span>
                                        </h6>

                                        <!-- Supervisor -->
                                        @if($request->activeAssignment->supervisor)
                                            <div class="mb-3">
                                                <h6 class="text-muted small mb-2">Supervisor:</h6>
                                                <div class="border rounded p-2 bg-white">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            <p class="mb-0 fw-semibold">
                                                                {{ $request->activeAssignment->supervisor->first_name }} {{ $request->activeAssignment->supervisor->last_name }}
                                                            </p>
                                                            <p class="mb-0 text-muted small">
                                                                {{ $request->activeAssignment->supervisor->designation }} | {{ $request->activeAssignment->supervisor->phone }}
                                                            </p>
                                                        </div>
                                                        <span class="badge bg-warning">Supervisor</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Group Members -->
                                        <h6 class="text-muted small mb-2">Team Members:</h6>
                                        <div class="row g-2">
                                            @foreach($request->activeAssignment->groupEngineers as $groupEngineer)
                                                <div class="col-md-6">
                                                    <div class="border rounded p-2 bg-white">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1 fw-semibold">
                                                                    {{ $groupEngineer->first_name }} {{ $groupEngineer->last_name }}
                                                                </h6>
                                                                <p class="mb-0 text-muted small">
                                                                    <i class="mdi mdi-briefcase"></i> {{ $groupEngineer->designation }} |
                                                                    <i class="mdi mdi-phone"></i> {{ $groupEngineer->phone }}
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

        // Handle form submission
        $('#assignEngineerForm').submit(function(e) {
            e.preventDefault();

            const assignmentType = $('input[name="assignment_type"]:checked').val();
            let formData = {
                _token: $('input[name="_token"]').val(),
                quick_service_request_id: $('input[name="quick_service_request_id"]').val(),
                assignment_type: assignmentType
            };

            if (assignmentType === 'Individual') {
                const engineerId = $('#engineer_id').val();
                if (!engineerId) {
                    alert('Please select an engineer');
                    return;
                }
                formData.engineer_id = engineerId;
            } else {
                const groupName = $('#group_name').val();
                const engineerIds = [];
                $('.engineer-checkbox:checked').each(function() {
                    engineerIds.push($(this).val());
                });
                const supervisorId = $('input[name="supervisor_id"]:checked').val();

                if (!groupName) {
                    alert('Please enter group name');
                    return;
                }
                if (engineerIds.length === 0) {
                    alert('Please select at least one engineer');
                    return;
                }
                if (!supervisorId) {
                    alert('Please select a supervisor');
                    return;
                }

                formData.group_name = groupName;
                formData.engineer_ids = engineerIds;
                formData.supervisor_id = supervisorId;
            }

            // Disable button
            $('#assignBtn').prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin me-1"></i> Assigning...');

            $.ajax({
                url: '{{ route("quick-service-requests.assign-engineer") }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                        $('#assignBtn').prop('disabled', false).html('<i class="mdi mdi-account-plus me-1"></i> Assign Engineer');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'An error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alert('Error: ' + errorMsg);
                    $('#assignBtn').prop('disabled', false).html('<i class="mdi mdi-account-plus me-1"></i> Assign Engineer');
                }
            });
        });
    });
</script>
@endsection
