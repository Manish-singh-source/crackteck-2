@extends('crm/layouts/master')

@section('content')

    <style>
        #popupOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        #popupOverlay img {
            max-width: 90%;
            max-height: 90%;
            box-shadow: 0 0 10px #fff;
        }

        #popupOverlay .closeBtn {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 30px;
            color: white;
            cursor: pointer;
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
                                <h5 class="card-title mb-0">Non-AMC Service Request Details</h5>
                                <div>
                                    <span
                                        class="fw-bold text-dark">#SRV-{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    @if ($service->status == 'Completed')
                                        <span class="badge bg-success ms-2">Completed</span>
                                    @elseif($service->status == 'In Progress')
                                        <span class="badge bg-primary ms-2">In Progress</span>
                                    @elseif($service->status == 'Pending')
                                        <span class="badge bg-warning ms-2">Pending</span>
                                    @elseif($service->status == 'Cancelled')
                                        <span class="badge bg-danger ms-2">Cancelled</span>
                                    @else
                                        <span class="badge bg-secondary ms-2">{{ $service->status }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Customer Name:</span>
                                            <span>{{ $service->full_name }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Contact No:</span>
                                            <span>{{ $service->phone }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Email:</span>
                                            <span>{{ $service->email }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">DOB:</span>
                                            <span>{{ $service->dob ? $service->dob->format('d M Y') : 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Gender:</span>
                                            <span>{{ $service->gender ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Customer Type:</span>
                                            <span>{{ $service->customer_type ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Company Name:</span>
                                            <span>{{ $service->company_name ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">GST No:</span>
                                            <span>{{ $service->gst_no ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">PAN No:</span>
                                            <span>{{ $service->pan_no ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Created By:</span>
                                            <span>{{ $service->creator->name ?? 'System' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Created At:</span>
                                            <span>{{ $service->created_at->format('d M Y, h:i A') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Address Section -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6 class="fw-semibold mb-2">Address:</h6>
                                    <p class="text-muted">{{ $service->full_address }}</p>
                                </div>
                            </div>

                            <!-- Images Section -->
                            <div class="row mt-3">
                                @if ($service->profile_image)
                                    <div class="col-md-6">
                                        <h6 class="fw-semibold mb-2">Profile Image:</h6>
                                        <img src="{{ asset('uploads/crm/non-amc/profiles/' . $service->profile_image) }}"
                                            alt="Profile" class="img-thumbnail" style="max-width: 200px; cursor: pointer;"
                                            onclick="openPopup(this.src)">
                                    </div>
                                @endif
                                @if ($service->customer_image)
                                    <div class="col-md-6">
                                        <h6 class="fw-semibold mb-2">Customer Image:</h6>
                                        <img src="{{ asset('uploads/crm/non-amc/customers/' . $service->customer_image) }}"
                                            alt="Customer" class="img-thumbnail" style="max-width: 200px; cursor: pointer;"
                                            onclick="openPopup(this.src)">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Service Details Card -->
                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Service Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Service Type:</span>
                                            <span class="badge bg-info">{{ $service->service_type }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Priority Level:</span>
                                            @if ($service->priority_level == 'High')
                                                <span class="badge bg-danger">High</span>
                                            @elseif($service->priority_level == 'Medium')
                                                <span class="badge bg-warning">Medium</span>
                                            @else
                                                <span class="badge bg-success">Low</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Total Amount:</span>
                                            <span
                                                class="fw-bold text-success">₹{{ number_format($service->total_amount, 2) }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Total Products:</span>
                                            <span>{{ $service->products->count() }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            @if ($service->additional_notes)
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6 class="fw-semibold mb-2">Additional Notes:</h6>
                                        <p class="text-muted">{{ $service->additional_notes }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Products Card -->
                    {{-- <div class="card mt-3">
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
                    </div> --}}

                    <!-- Products Card -->
                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Products Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
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
                                        @forelse($service->products as $index => $product)
                                            <tr>    
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->product_type }}</td>
                                                <td>{{ $product->product_brand }}</td>
                                                <td>{{ $product->model_no }}</td>
                                                <td>{{ $product->serial_no }}</td>
                                                <td>{{ $product->purchase_date ? $product->purchase_date->format('d M Y') : '-' }}
                                                </td>
                                                <td>{{ $product->warranty_status }}</td>
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

                    <!-- Action Buttons -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                <a href="{{ route('service-request.edit-non-amc', $service->id) }}"
                                    class="btn btn-warning">
                                    <i class="mdi mdi-pencil"></i> Edit Service Request
                                </a>
                                <a href="{{ route('service-request.index') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left"></i> Back to List
                                </a>
                                <form action="{{ route('service-request.delete-non-amc', $service->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this service request?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="mdi mdi-delete"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <!-- Assign Engineer Card -->
                            <div class="card mt-3">
                                <div class="card-header border-bottom-dashed">
                                    <h5 class="card-title mb-0">Assign Engineer</h5>
                                </div>
                                <div class="card-body">
                                    <form id="assignEngineerForm">
                                        @csrf
                                        <input type="hidden" name="non_amc_service_id" value="{{ $service->id }}">

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Assignment Type</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="assignment_type"
                                                        id="typeIndividual" value="Individual" checked>
                                                    <label class="form-check-label"
                                                        for="typeIndividual">Individual</label>
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
                            </div>

                            <!-- Assigned Engineers Display -->
                            @if($service->activeAssignment)
                            <div class="card mt-3" id="assignedEngineersCard">
                                <div class="card-header border-bottom-dashed bg-light">
                                    <h5 class="card-title mb-0">Assigned Engineers</h5>
                                </div>
                                <div class="card-body">
                                    @if($service->activeAssignment->assignment_type === 'Individual')
                                        <!-- Individual Engineer Card -->
                                        <div class="border rounded p-3 bg-success-subtle">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-bold">
                                                        {{ $service->activeAssignment->engineer->first_name }} {{ $service->activeAssignment->engineer->last_name }}
                                                    </h6>
                                                    <p class="mb-1 text-muted small">
                                                        <i class="mdi mdi-briefcase"></i> {{ $service->activeAssignment->engineer->designation }}
                                                    </p>
                                                    <p class="mb-1 text-muted small">
                                                        <i class="mdi mdi-office-building"></i> {{ $service->activeAssignment->engineer->department }}
                                                    </p>
                                                    <p class="mb-0 text-muted small">
                                                        <i class="mdi mdi-phone"></i> {{ $service->activeAssignment->engineer->phone }}
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
                                                <i class="mdi mdi-account-group"></i> Group: {{ $service->activeAssignment->group_name }}
                                                <span class="badge bg-info ms-2">{{ $service->activeAssignment->groupEngineers->count() }} Engineers</span>
                                            </h6>

                                            <div class="row">
                                                @foreach($service->activeAssignment->groupEngineers as $groupEngineer)
                                                    <div class="col-md-6 mb-3">
                                                        <div class="border rounded p-2 {{ $groupEngineer->pivot->is_supervisor ? 'bg-warning-subtle' : 'bg-white' }}">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-grow-1">
                                                                    <h6 class="mb-1 fw-semibold">
                                                                        {{ $groupEngineer->first_name }} {{ $groupEngineer->last_name }}
                                                                        @if($groupEngineer->pivot->is_supervisor)
                                                                            <span class="supervisor-badge">SUPERVISOR</span>
                                                                        @endif
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

                            

                            <!-- Action Buttons -->
                            {{-- <div class="card mt-3">
                                <div class="card-body text-center">
                                    <a href="{{ route('service-request.edit-non-amc', $service->id) }}"
                                        class="btn btn-warning">
                                        <i class="mdi mdi-pencil"></i> Edit Non AMC Request
                                    </a>
                                    <a href="{{ route('service-request.index') }}" class="btn btn-secondary">
                                        <i class="mdi mdi-arrow-left"></i> Back to List
                                    </a>
                                </div>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Popup Overlay -->
            <div id="popupOverlay" onclick="closePopup()">
                <span class="closeBtn" onclick="closePopup()">&times;</span>
                <img id="popupImage" src="" alt="Popup Image">
            </div>

            <script>
                function openPopup(imageSrc) {
                    document.getElementById('popupImage').src = imageSrc;
                    document.getElementById('popupOverlay').style.display = 'flex';
                }

                function closePopup() {
                    document.getElementById('popupOverlay').style.display = 'none';
                }
            </script>

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
                url: '{{ route("service-request.assign-non-amc-engineer") }}',
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
                    const error = xhr.responseJSON?.message || 'Error assigning engineer. Please try again.';
                    alert(error);
                }
            });
        });
    });
</script>
@endsection
