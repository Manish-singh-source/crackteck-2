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

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#approve-request').on('click', function() {
                var url = $(this).data('url');
                var adminReason = $('#admin_reason').val();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        admin_reason: adminReason,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#standard-modal').modal('hide');
                            location.reload(); // Reload the page to reflect changes
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while approving the request.');
                    }
                });
            });
        });
    </script>

    <div class="content">
        <div class="container-fluid">

            <div class="row mt-3">
                <div class="col-xl-8 mx-auto">

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Transfer Request
                                </h5>
                                @if ($caseTransfer->status === 'pending')
                                    <div class="action-buttons">
                                        <button type="button" class="mb-0 btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#standard-modal">
                                            Change Status
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="modal fade" id="standard-modal" tabindex="-1" aria-labelledby="standard-modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="standard-modalLabel">Request</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body px-3 py-md-2">
                                        <div class="row">
                                            <div class="col-12">
                                                @include('components.form.input', [
                                                    'label' => 'Admin Reason',
                                                    'name' => 'admin_reason',
                                                    'type' => 'text',
                                                    'id' => 'admin_reason',
                                                    'placeholder' => 'Enter Admin Reason',
                                                    'required' => true,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="approve-request" data-url="{{ route('case-transfer.approve', $caseTransfer->id) }}">Approve</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <ul class="list-group list-group-flush ">

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Current Engineer :
                                    </span>
                                    <span>
                                        {{ $caseTransfer->requestingEngineer ? $caseTransfer->requestingEngineer->first_name : 'N/A' }}
                                        {{ $caseTransfer->requestingEngineer ? $caseTransfer->requestingEngineer->last_name : ' ' }}
                                    </span>
                                </li>
                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Request Transfer Status:</span>

                                    @php
                                        $status = $caseTransfer->status ?? 'pending';

                                        $statusLabels = [
                                            'approved' => 'Approved',
                                            'pending' => 'Pending',
                                            'rejected' => 'Rejected',
                                        ];

                                        $statusClasses = [
                                            'approved' => 'bg-success-subtle text-success',
                                            'pending' => 'bg-warning-subtle text-warning',
                                            'rejected' => 'bg-danger-subtle text-danger',
                                        ];
                                    @endphp

                                    <span
                                        class="badge fw-semibold {{ $statusClasses[$status] ?? 'bg-secondary-subtle text-secondary' }}">
                                        {{ $statusLabels[$status] ?? ucfirst($status) }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Transfer Reason:
                                    </span>
                                    <span>
                                        {{ $caseTransfer->engineer_reason ?: 'N/A' }}
                                    </span>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Customer Details
                                </h5>
                                <div class="fw-bold text-dark">
                                    #{{ $serviceRequest->request_id ?? 'N/A' }}
                                </div>
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
                                                {{ $customer->first_name ?? 'N/A' }} {{ $customer->last_name ?? 'N/A' }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Contact no :
                                            </span>
                                            <span>
                                                {{ $customer->phone ?? 'N/A' }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Company Name :
                                            </span>
                                            <span>
                                                {{ $customerCompany->company_name ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">GST No :
                                            </span>
                                            <span>
                                                {{ $customerCompany->gst_no ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">PAN No :
                                            </span>
                                            <span>
                                                {{ $customerPan->pan_number ?? 'N/A' }}
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
                                                {{ $customer->email ?? 'N/A' }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Address :
                                            </span>
                                            <span>
                                                {{ $customerAddress->address1 }},
                                                {{ $customerAddress->address2 }},
                                                {{ $customerAddress->city }},
                                                {{ $customerAddress->state }},
                                                {{ $customerAddress->pincode }},
                                                {{ $customerAddress->country }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Customer Type :
                                            </span>
                                            <span>
                                                {{ $customer->customer_type ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Company Address :
                                            </span>
                                            <span>
                                                {{ $customerCompany->comp_address1 }},
                                                {{ $customerCompany->comp_address2 }},
                                                {{ $customerCompany->comp_state }},
                                                {{ $customerCompany->comp_city }},
                                                {{ $customerCompany->comp_pincode }},
                                                {{ $customerCompany->comp_country }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Service Details
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">

                                        <li
                                            class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">
                                                Service Id :
                                            </span>
                                            <span>
                                                <span
                                                    class="fw-bold text-dark">#{{ $serviceRequest->request_id ?? 'N/A' }}</span><br>
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Date :
                                            </span>
                                            <span>
                                                <div>
                                                    {{ $serviceRequest->created_at ? $serviceRequest->created_at->format('Y-m-d H:i A') : 'N/A' }}
                                                </div>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">

                                        <li
                                            class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">
                                                Service Type :
                                            </span>
                                            @php
                                                $serviceTypes = [
                                                    'quick_service' => 'Quick Service',
                                                    'amc' => 'AMC Service',
                                                    'repairing' => 'Repair Service',
                                                    'installation' => 'Installation Service',
                                                ];
                                            @endphp
                                            <span>
                                                <span
                                                    class="fw-bold text-dark">{{ $serviceTypes[$serviceRequest->service_type] ?? 'N/A' }}</span><br>
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Status :

                                            </span>
                                            <span
                                                class="badge bg-danger-subtle text-danger fw-semibold">{{ ucfirst($serviceRequest->request_status ?? 'pending') }}</span>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    AMC Details
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">

                                        <li
                                            class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Plan Name:
                                            </span>
                                            <span>
                                                Software Updates
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Duration (Months) :
                                            </span>
                                            <span>
                                                12
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Start From :
                                            </span>
                                            <span>
                                                2025-04-04 06:09 PM
                                            </span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Total Vistor :
                                            </span>
                                            <span>
                                                50
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">

                                        <li
                                            class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Plan Type :
                                            </span>
                                            <span>
                                                Standard
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Description :
                                            </span>
                                            <span>
                                                AMC Service for 1 year
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">End From :
                                            </span>
                                            <span>
                                                2025-04-04 06:09 PM
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>


                    </div> --}}
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Product Details
                                </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-borderless dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Modal Number</th>
                                        <th>SKU</th>
                                        <th>HSN</th>
                                        <th>Brand</th>
                                        <th>Description</th>
                                        <th>Purchase Date</th>
                                        <th>Diagnosis List</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                        <tr class="align-middle">
                                            <td>
                                                <div>
                                                    {{ $product->name ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td>
                                                {{ $product->name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $product->model_no ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $product->sku ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $product->hsn ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $product->brand ?? 'N/A' }}
                                            </td>
                                            <td>{{ $product->description ?? 'N/A' }}</td>
                                            <td>{{ $product->purchase_date ? $product->purchase_date : 'N/A' }}</td>
                                            <td>
                                                {{ is_array($product->itemCode->diagnosis_list)
                                                    ? implode(', ', $product->itemCode->diagnosis_list)
                                                    : $product->itemCode->diagnosis_list ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No products found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="col-xl-4">

                    <!-- Assign Engineer Card -->
                    @if ($serviceRequest->status === 'admin_approved')
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Assign Engineer</h5>
                            </div>
                            <div class="card-body">
                                <form id="assignEngineerForm">
                                    @csrf
                                    <input type="hidden" name="service_request_id" value="{{ $serviceRequest->id }}">

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Assignment Type</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="assignment_type"
                                                    id="typeIndividual" value="individual" checked>
                                                <label class="form-check-label" for="typeIndividual">Individual</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="assignment_type"
                                                    id="typeGroup" value="group">
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
                    @if ($serviceRequest->activeAssignment)
                        <div class="card mt-3" id="assignedEngineersCard">
                            <div class="card-header border-bottom-dashed bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="mdi mdi-account-check"></i> Current Assignment
                                </h5>
                            </div>
                            <div class="card-body">
                                @if ($serviceRequest->activeAssignment->assignment_type === 'individual')
                                    <!-- Individual Engineer Card -->
                                    <div class="border rounded p-3 bg-success-subtle">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">
                                                    {{ $serviceRequest->activeAssignment->engineer->first_name }}
                                                    {{ $serviceRequest->activeAssignment->engineer->last_name }}
                                                </h6>
                                                <p class="mb-1 text-muted small">
                                                    <i class="mdi mdi-phone"></i>
                                                    {{ $serviceRequest->activeAssignment->engineer->phone }}
                                                </p>
                                                <p class="mb-0 text-muted small">
                                                    <i class="mdi mdi-clock-outline"></i>
                                                    Assigned: {{ $serviceRequest->activeAssignment->assigned_at }}
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
                                            {{ $serviceRequest->activeAssignment->group_name }}
                                            <span
                                                class="badge bg-info ms-2">{{ $serviceRequest->activeAssignment->groupEngineers->count() }}
                                                Engineers</span>
                                        </h6>
                                        <p class="mb-3 text-muted small">
                                            <i class="mdi mdi-clock-outline"></i>
                                            Assigned: {{ $serviceRequest->activeAssignment->assigned_at }}
                                        </p>

                                        <div class="row">
                                            @foreach ($serviceRequest->activeAssignment->groupEngineers as $groupEngineer)
                                                <div class="col-md-12 mb-2">
                                                    <div
                                                        class="border rounded p-2 {{ $groupEngineer->pivot->is_supervisor ? 'bg-warning-subtle' : 'bg-white' }}">
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
                    @if ($serviceRequest->inactiveAssignments && $serviceRequest->inactiveAssignments->count() > 0)
                        <div class="card mt-3">
                            <div class="card-header border-bottom-dashed bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="mdi mdi-history"></i> Assignment History
                                </h5>
                            </div>
                            <div class="card-body">
                                @foreach ($serviceRequest->inactiveAssignments as $assignment)
                                    <div class="border rounded p-3 mb-3 bg-light">
                                        @if ($assignment->assignment_type === 'individual')
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
                                                    @if ($assignment->transferred_at)
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
                                            @if ($assignment->transferred_at)
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
        });
    </script>


    <script>
        $(document).ready(function() {

            $("#approve-request").on('click', function() {
                $(".action-buttons").hide();
                $("#standard-modal").modal('hide');
                $(".request-status").html("Approved");
                $(".request-status").removeClass("bg-danger-subtle text-danger");
                $(".request-status").addClass("bg-success-subtle text-success");
                $(".engineer-details").show();
            });

            $("#reject-request").on('click', function() {
                $(".action-buttons").hide();
                $("#standard-modal").modal('hide');
                $(".request-status").html("Rejected");
                $(".request-status").removeClass("bg-success-subtle text-success");
                $(".request-status").addClass("bg-danger-subtle text-danger");
            });

            $(".engineer-details").hide();
            $(".hide-section").hide();
            $(".hide-report-section").hide();
            $(".hide-assign-eng-section").hide();
            $(".hide-selected-engineers-section").hide();

            $("#eng-location").on("change", function() {
                $(".hide-assign-eng-section").show();
                $(".hide-section").show();
            });

            $(".eng-assign").on("change", function() {
                $(".hide-assign-eng-section").show();
                $(".hide-section").show();
                $("#groupDropdown").fadeToggle();
                $("#individualDropdown").fadeToggle();
            });

            $(".assign-eng-btn").on("click", function() {
                $(".hide-section").hide();
                $(".hide-assign-eng-section").hide();
                $(".hide-selected-engineers-section").show();
                $(".hide-report-section").show();

            });

            $(".show-report").on("click", function() {
                $("#popupOverlay").css("display", "flex");
            });

            $(".hide-report").on("click", function() {
                $("#popupOverlay").hide();
            });

            $(".add-engineer").on("click", function() {
                const $selectedOptions = $('#groupDropdown1 option:selected');
                const $tableBody = $('#selectedTable tbody');

                $selectedOptions.each(function() {
                    const optionText = $(this).text();

                    // Append row to table
                    const newRow = `
                    <tr>
                        <td>${optionText}</td>
                        <td><input type="checkbox" class="form-check-input" /></td>
                    </tr>
                `;
                    $tableBody.append(newRow);

                    // Remove option from the select dropdown
                    $(this).remove();
                });
            });

        });
    </script>
@endsection
