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
                        <h4 class="fs-18 fw-semibold m-0">View Quick Service Request</h4>
                    </div>
                </div>
                <div class="col-xl-8 mx-auto">

                    <!-- Customer Details Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Customer Personal Details</h5>
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
                                            @if ($request->customer->customer_type == 'ecommerce')
                                                <span>E-commerce</span>
                                            @elseif ($request->customer->customer_type == 'amc')
                                                <span>AMC</span>
                                            @elseif ($request->customer->customer_type == 'both')
                                                <span>Both</span>
                                            @elseif ($request->customer->customer_type == 'offline')
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
                                            <span class="fw-semibold">Status:</span>
                                            @php $index = $request->status; @endphp
                                            <span class="badge {{ $statusColor[$index] }} fw-semibold">
                                                {{ $status[$index] }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Visit Date:</span>
                                            <span>{{ $request->reschedule_date ?? $request->visit_date }}</span>
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
                                            <span>{{ $request->customerAddress->branch_name ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Address Line 1:</span>
                                            <span>{{ $request->customerAddress->address1 ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Address Line 2:</span>
                                            <span>{{ $request->customerAddress->address2 ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">State:</span>
                                            <span>{{ $request->customerAddress->state ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Country:</span>
                                            <span>{{ $request->customerAddress->country ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">City:</span>
                                            <span>{{ $request->customerAddress->city ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex gap-3">
                                            <span class="fw-semibold">Pin Code:</span>
                                            <span>{{ $request->customerAddress->pincode ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
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
                                            <th>Status</th>
                                            <th>Service Type</th>
                                            <th>Service Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($request->products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->type ?? '-' }}</td>
                                                <td>{{ $product->model_no ?? '-' }}</td>
                                                <td>{{ $product->hsn ?? '-' }}</td>
                                                <td>{{ $product->brand ?? '-' }}</td>
                                                <td>
                                                    @php
                                                        $status = [
                                                            // enum('pending', 'approved', 'rejected', 'processing', 'in_progress', 'on_hold', 'diagnosis_completed', 'processed', 'picking', 'picked', 'completed')
                                                            'pending' => 'Pending',
                                                            'approved' => 'Approved',
                                                            'rejected' => 'Rejected',
                                                            'processing' => 'Processing',
                                                            'in_progress' => 'In Progress',
                                                            'on_hold' => 'On Hold',
                                                            'diagnosis_completed' => 'Diagnosis Completed',
                                                            'processed' => 'Processed',
                                                            'picking' => 'Picking',
                                                            'picked' => 'Picked',
                                                            'stock_in_hand' => 'Stock In Hand',
                                                            'request_part' => 'Request Part',
                                                            'completed' => 'Completed',
                                                        ];

                                                        $statusColor = [
                                                            // i want all unique status colors here 
                                                            'pending' => 'bg-warning-subtle text-warning',
                                                            'approved' => 'bg-success-subtle text-success',
                                                            'rejected' => 'bg-danger-subtle text-danger',
                                                            'processing' => 'bg-info-subtle text-info',
                                                            'in_progress' => 'bg-primary-subtle text-primary',
                                                            'on_hold' => 'bg-warning-subtle text-warning',
                                                            'diagnosis_completed' => 'bg-success-subtle text-success',
                                                            'processed' => 'bg-info-subtle text-info',
                                                            'picking' => 'bg-primary-subtle text-primary',
                                                            'picked' => 'bg-success-subtle text-success',
                                                            'completed' => 'bg-success-subtle text-success',
                                                        ];
                                                    @endphp
                                                    <span class="badge {{ $statusColor[$product->status ?? '-'] ?? 'bg-secondary-subtle text-secondary' }}">{{ $status[$product->status ?? '-'] ?? '-' }}</span>
                                                </td>
                                                <td>
                                                    @php 
                                                        $serviceType = [
                                                            'amc' => 'AMC',
                                                            'quick_service' => 'Quick Service',
                                                            'repairing' => 'Repairing Service',
                                                            'installation' => 'Installation Service',
                                                        ];
                                                    @endphp
                                                    {{ $serviceType[$product->itemCode->service_type ?? '-'] ?? '-' }}
                                                </td>
                                                <td>{{ $product->service_charge ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8" class="text-end"><strong>Total</strong></td>
                                            <td><strong>{{ $request->products->sum('service_charge') }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Engineer Diagnosis Details Card --}}
                    @foreach ($request->products as $index => $product)
                        @if ($product->diagnosisDetails && $product->diagnosisDetails->count() > 0)
                            <div class="card mt-3">
                                <div class="card-header border-bottom-dashed bg-info-subtle">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-clipboard-check"></i>
                                        Diagnosis Details - {{ $product->name }} (Sr No: {{ $index + 1 }})
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @foreach ($product->diagnosisDetails as $diagnosis)
                                        <div class="border rounded p-3 mb-3 bg-light">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <ul class="list-group list-group-flush p-3">
                                                        <li class="list-group-item border-0">
                                                            <span class="fw-semibold">Service Request ID:</span>
                                                            <span class="text-muted">{{ $request->request_id }}</span>
                                                        </li>
                                                        <li class="list-group-item border-0">
                                                            <span class="fw-semibold">Product Name:</span>
                                                            <span class="text-muted">{{ $product->name }}</span>
                                                        </li>
                                                        <li class="list-group-item border-0">
                                                            <span class="fw-semibold">Assigned Engineer:</span>
                                                            <span class="text-muted">
                                                                {{ $diagnosis->assignedEngineer->engineer->first_name ?? 'N/A' }} 
                                                                {{ $diagnosis->assignedEngineer->engineer->last_name ?? '' }}
                                                            </span>
                                                        </li>
                                                        <li class="list-group-item border-0">
                                                            <span class="fw-semibold">Covered Item Service Name:</span>
                                                            <span class="text-muted">{{ $diagnosis->coveredItem->service_name ?? 'N/A' }}</span>
                                                        </li>
                                                        <li class="list-group-item border-0">
                                                            <span class="fw-semibold">Diagnosis Status:</span>
                                                            <span class="badge bg-primary">{{ $product->status ?? 'N/A' }}</span>
                                                        </li>
                                                        <li class="list-group-item border-0">
                                                            <span class="fw-semibold">Estimated Cost:</span>
                                                            <span class="text-muted">₹{{ number_format($product->service_charge ?? 0, 2) }}</span>
                                                        </li>
                                                        <li class="list-group-item border-0">
                                                            <span class="fw-semibold">Completed At:</span>
                                                            <span class="text-muted">{{ $diagnosis->completed_at ? $diagnosis->completed_at : 'N/A' }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-8">
                                                    {{-- Diagnosis List --}}
                                                    @php
                                                        $diagnosisList = json_decode($diagnosis->diagnosis_list, true);
                                                        $hasStockInHand = false;
                                                        $hasRequestPart = false;
                                                        $stockInHandItems = [];
                                                        $requestPartItems = [];
                                                        if ($diagnosisList && is_array($diagnosisList)) {
                                                            foreach ($diagnosisList as $item) {
                                                                if (($item['status'] ?? '') === 'stock_in_hand') {
                                                                    $hasStockInHand = true;
                                                                    $stockInHandItems[] = $item;
                                                                }
                                                                if (($item['status'] ?? '') === 'request_part') {
                                                                    $hasRequestPart = true;
                                                                    $requestPartItems[] = $item;
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    @if ($diagnosisList && is_array($diagnosisList))
                                                        <div class="mb-3">
                                                            <h6 class="fw-semibold mb-2">Diagnosis List</h6>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-sm">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Component</th>
                                                                            <th>Report</th>
                                                                            <th>Status</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($diagnosisList as $item)
                                                                            <tr>
                                                                                <td>{{ $item['name'] ?? 'N/A' }}</td>
                                                                                <td>{{ $item['report'] ?? 'N/A' }}</td>
                                                                                <td>
                                                                                    @php
                                                                                        $diagStatus = $item['status'] ?? '';
                                                                                        $diagStatusClass = $diagStatus === 'working' ? 'bg-success' : ($diagStatus === 'not_working' ? 'bg-danger' : 'bg-warning');
                                                                                        $diagStatusLabel = $diagStatus === 'working' ? 'Working' : ($diagStatus === 'not_working' ? 'Not Working' : ($diagStatus === 'picking' ? 'Picking' : ($diagStatus === 'stock_in_hand' ? 'Stock In Hand' : ($diagStatus === 'request_part' ? 'Request Part' : ucfirst($diagStatus)))));
                                                                                    @endphp
                                                                                    <span class="badge {{ $diagStatusClass }}">{{ $diagStatusLabel }}</span>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Requested Parts Section - Shows all stock_in_hand and part_request --}}
                                                    @php
                                                        // Get all request parts for this product
                                                        $requestParts = $product->requestParts ?? collect();
                                                    @endphp
                                                    @if($requestParts && $requestParts->count() > 0)
                                                        <div class="mb-3">
                                                            <h6 class="fw-semibold mb-2">Requested Parts Details</h6>
                                                            @foreach($requestParts as $requestPart)
                                                                @php
                                                                    $partDetails = $requestPart->product;
                                                                    $partSerial = $requestPart->requestedPart;
                                                                    $status = $requestPart->status;
                                                                    
                                                                    // Status colors and labels
                                                                    $statusLabels = [
                                                                        'pending' => 'Pending',
                                                                        'admin_approved' => 'Admin Approved',
                                                                        'admin_rejected' => 'Admin Rejected',
                                                                        'customer_approved' => 'Customer Approved',
                                                                        'customer_rejected' => 'Customer Rejected',
                                                                        'warehouse_approved' => 'Warehouse Approved',
                                                                        'warehouse_rejected' => 'Warehouse Rejected',
                                                                        'assigned' => 'Assigned',
                                                                        'ap_approved' => 'AP Approved',
                                                                        'ap_rejected' => 'AP Rejected',
                                                                        'picked' => 'Picked',
                                                                        'in_transit' => 'In Transit',
                                                                        'delivered' => 'Delivered',
                                                                        'used' => 'Used',
                                                                    ];
                                                                    
                                                                    $statusColors = [
                                                                        'pending' => 'bg-warning',
                                                                        'admin_approved' => 'bg-success',
                                                                        'admin_rejected' => 'bg-danger',
                                                                        'customer_approved' => 'bg-success',
                                                                        'customer_rejected' => 'bg-danger',
                                                                        'warehouse_approved' => 'bg-info',
                                                                        'warehouse_rejected' => 'bg-danger',
                                                                        'assigned' => 'bg-primary',
                                                                        'ap_approved' => 'bg-info',
                                                                        'ap_rejected' => 'bg-danger',
                                                                        'picked' => 'bg-success',
                                                                        'in_transit' => 'bg-info',
                                                                        'delivered' => 'bg-success',
                                                                        'used' => 'bg-success',
                                                                    ];
                                                                    
                                                                    $requestTypeLabels = [
                                                                        'stock_in_hand' => 'Stock In Hand',
                                                                        'part_request' => 'Part Request',
                                                                    ];
                                                                @endphp
                                                                <div class="border rounded p-3 mb-2 bg-white">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                                                <div>
                                                                                    <span class="fw-semibold">Part Name:</span> {{ $partDetails->name ?? 'N/A' }}<br>
                                                                                    <span class="text-muted small">
                                                                                        Part ID: {{ $requestPart->part_id ?? 'N/A' }} | 
                                                                                        Request Type: {{ $requestTypeLabels[$requestPart->request_type] ?? $requestPart->request_type }} | 
                                                                                        Qty: {{ $requestPart->requested_quantity ?? 1 }}
                                                                                    </span>
                                                                                </div>
                                                                                <span class="badge {{ $statusColors[$status] ?? 'bg-secondary' }}">
                                                                                    {{ $statusLabels[$status] ?? ucfirst($status) }}
                                                                                </span>
                                                                            </div>
                                                                            
                                                                            {{-- Status Timeline --}}
                                                                            <div class="mb-2">
                                                                                <span class="fw-semibold small">Timeline:</span>
                                                                                <ul class="list-unstyled mb-0 small">
                                                                                    <li><span class="text-muted">Requested:</span> {{ $requestPart->created_at ? $requestPart->created_at : 'N/A' }}</li>
                                                                                    @if($requestPart->admin_approved_at)
                                                                                        <li><span class="text-success">Admin Approved:</span> {{ $requestPart->admin_approved_at }}</li>
                                                                                    @endif
                                                                                    @if($requestPart->admin_rejected_at)
                                                                                        <li><span class="text-danger">Admin Rejected:</span> {{ $requestPart->admin_rejected_at }}</li>
                                                                                    @endif
                                                                                    @if($requestPart->customer_approved_at)
                                                                                        <li><span class="text-success">Customer Approved:</span> {{ $requestPart->customer_approved_at }}</li>
                                                                                    @endif
                                                                                    @if($requestPart->customer_rejected_at)
                                                                                        <li><span class="text-danger">Customer Rejected:</span> {{ $requestPart->customer_rejected_at }}</li>
                                                                                    @endif
                                                                                    @if($requestPart->assigned_at)
                                                                                        <li><span class="text-success">Assigned:</span> {{ $requestPart->assigned_at }}</li>
                                                                                    @endif
                                                                                    @if($requestPart->assigned_approved_at)
                                                                                        <li><span class="text-success">Assigned Approved:</span> {{ $requestPart->assigned_approved_at }}</li>
                                                                                    @endif
                                                                                    @if($requestPart->assigned_rejected_at)
                                                                                        <li><span class="text-danger">Assigned Rejected:</span> {{ $requestPart->assigned_rejected_at }}</li>
                                                                                    @endif
                                                                                    @if($requestPart->picked_at)
                                                                                        <li><span class="text-info">Picked:</span> {{ $requestPart->picked_at }}</li>
                                                                                    @endif
                                                                                    @if($requestPart->delivered_at)
                                                                                        <li><span class="text-success">Delivered:</span> {{ $requestPart->delivered_at }}</li>
                                                                                    @endif
                                                                                </ul>
                                                                            </div>
                                                                            
                                                                            {{-- Admin Action for pending items --}}
                                                                            @if(in_array($status, ['pending']))
                                                                                <form action="{{ route('service-request.admin-stock-in-hand-approval') }}" method="POST" class="d-flex gap-2 align-items-center">
                                                                                    @csrf
                                                                                    <input type="hidden" name="request_id" value="{{ $request->id }}">
                                                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                                                    <input type="hidden" name="engineer_id" value="{{ $requestPart->engineer_id }}">
                                                                                    <input type="hidden" name="part_id" value="{{ $requestPart->part_id }}">
                                                                                    <input type="hidden" name="quantity" value="{{ $requestPart->requested_quantity ?? 1 }}">
                                                                                    <input type="hidden" name="request_type" value="{{ $requestPart->request_type ?? 'stock_in_hand' }}">
                                                                                    <select name="admin_action" class="form-select form-select-sm" style="width: auto;" required>
                                                                                        <option value="">-- Select Action --</option>
                                                                                        <option value="admin_approved">Admin Approved</option>
                                                                                        <option value="admin_rejected">Admin Rejected</option>
                                                                                    </select>
                                                                                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                                                                </form>
                                                                            @endif
                                                                            
                                                                            {{-- Feature 4: Assignment option after customer approval for request_part type --}}
                                                                            @if($status === 'customer_approved' && $requestPart->request_type === 'request_part')
                                                                                <div class="mt-2">
                                                                                    <span class="fw-semibold small">Assign To:</span>
                                                                                    <form action="{{ route('service-request.assign-part-to-person') }}" method="POST" class="d-flex gap-2 align-items-center mt-1">
                                                                                        @csrf
                                                                                        <input type="hidden" name="request_id" value="{{ $request->id }}">
                                                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                                                        <input type="hidden" name="request_part_id" value="{{ $requestPart->id }}">
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input assign-type-radio" type="radio" name="assigned_person_type" id="type_engineer_{{ $requestPart->id }}" value="engineer" checked onchange="updatePersonDropdown('{{ $requestPart->id }}', 'engineer')">
                                                                                            <label class="form-check-label" for="type_engineer_{{ $requestPart->id }}">Engineer</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input assign-type-radio" type="radio" name="assigned_person_type" id="type_delivery_{{ $requestPart->id }}" value="delivery_man" onchange="updatePersonDropdown('{{ $requestPart->id }}', 'delivery_man')">
                                                                                            <label class="form-check-label" for="type_delivery_{{ $requestPart->id }}">Delivery Man</label>
                                                                                        </div>
                                                                                        <select name="assigned_person_id" id="person_select_{{ $requestPart->id }}" class="form-select form-select-sm person-select" style="width: auto;" data-engineers='{{ json_encode($engineers->map(fn($e) => ["id" => $e->id, "name" => $e->first_name . " " . $e->last_name])) }}' data-delivery-men='{{ json_encode($deliveryMen->map(fn($d) => ["id" => $d->id, "name" => $d->first_name . " " . $d->last_name])) }}' required>
                                                                                            <option value="">-- Select Person --</option>
                                                                                        </select>
                                                                                        <button type="submit" class="btn btn-sm btn-success">Assign</button>
                                                                                    </form>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @elseif($hasStockInHand)
                                                        {{-- Fallback: Show stock_in_hand items from diagnosis list if no request parts exist --}}
                                                        <div class="mb-3">
                                                            <h6 class="fw-semibold mb-2">Admin Action</h6>
                                                            @php
                                                                // Get the engineer_id from assigned_engineers table (staff ID)
                                                                $engineerId = $diagnosis->assignedEngineer->engineer_id ?? null;
                                                                $productId = $product->id;
                                                                $requestId = $request->id;
                                                            @endphp
                                                            @foreach($stockInHandItems as $stockItem)
                                                                @php
                                                                    $partId = $stockItem['part_id'] ?? null;
                                                                    $partName = $stockItem['name'] ?? 'N/A';
                                                                    $quantity = $stockItem['quantity'] ?? 1;
                                                                     
                                                                    // Check if there's an existing request part record
                                                                    $requestPart = \App\Models\ServiceRequestProductRequestPart::where('engineer_id', $engineerId)
                                                                        ->where('part_id', $partId)
                                                                        ->where('request_type', 'stock_in_hand')
                                                                        ->first();
                                                                    
                                                                    $currentStatus = $requestPart ? $requestPart->status : 'pending';
                                                                    $isProcessed = in_array($currentStatus, ['admin_approved', 'admin_rejected', 'customer_approved', 'customer_rejected']);
                                                                @endphp
                                                                @if($partId)
                                                                    <div class="d-flex gap-2 align-items-center mb-2 p-2 border rounded bg-white">
                                                                        <div class="me-3">
                                                                            <span class="fw-semibold">Part:</span> {{ $partName }}<br>
                                                                            <span class="text-muted small">Part ID: {{ $partId }} | Qty: {{ $quantity }}</span>
                                                                        </div>
                                                                        @if($isProcessed)
                                                                            <div class="ms-auto">
                                                                                @if($currentStatus === 'admin_approved')
                                                                                    <span class="badge bg-success">Admin Approved</span>
                                                                                @elseif($currentStatus === 'admin_rejected')
                                                                                    <span class="badge bg-danger">Admin Rejected</span>
                                                                                @elseif($currentStatus === 'customer_approved')
                                                                                    <span class="badge bg-success">Customer Approved</span>
                                                                                @elseif($currentStatus === 'customer_rejected')
                                                                                    <span class="badge bg-danger">Customer Rejected</span>
                                                                                @endif
                                                                            </div>
                                                                        @else
                                                                            <form action="{{ route('service-request.admin-stock-in-hand-approval') }}" method="POST" class="d-flex gap-2 align-items-center ms-auto">
                                                                                @csrf
                                                                                <input type="hidden" name="request_id" value="{{ $requestId }}">
                                                                                <input type="hidden" name="product_id" value="{{ $productId }}">
                                                                                <input type="hidden" name="engineer_id" value="{{ $engineerId }}">
                                                                                <input type="hidden" name="part_id" value="{{ $partId }}">
                                                                                <input type="hidden" name="quantity" value="{{ $quantity }}">
                                                                                <input type="hidden" name="request_type" value="stock_in_hand">
                                                                                <select name="admin_action" class="form-select form-select-sm" style="width: auto;" required>
                                                                                    <option value="">-- Select Action --</option>
                                                                                    <option value="admin_approved">Admin Approved</option>
                                                                                    <option value="admin_rejected">Admin Rejected</option>
                                                                                </select>
                                                                                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                                                            </form>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    {{-- Return Diagnosis Section --}}
                                                    @php
                                                        // Get return diagnosis for this product
                                                        $productReturns = $request->productReturns->where('product_id', $product->id);
                                                    @endphp
                                                    @if($productReturns && $productReturns->count() > 0)
                                                        <div class="mb-3">
                                                            <h6 class="fw-semibold mb-2">Return Diagnosis Details</h6>
                                                            @foreach($productReturns as $return)
                                                                @php
                                                                    $returnStatusLabels = [
                                                                        'pending' => 'Pending',
                                                                        'accepted' => 'Accepted',
                                                                        'rejected' => 'Rejected',
                                                                        'picked' => 'Picked',
                                                                        'received' => 'Received',
                                                                    ];
                                                                    
                                                                    $returnStatusColors = [
                                                                        'pending' => 'bg-warning',
                                                                        'accepted' => 'bg-success',
                                                                        'rejected' => 'bg-danger',
                                                                        'picked' => 'bg-info',
                                                                        'received' => 'bg-success',
                                                                    ];
                                                                @endphp
                                                                <div class="border rounded p-3 mb-2 bg-light">
                                                                    <div class="d-flex justify-content-between align-items-start">
                                                                        <div>
                                                                            <span class="fw-semibold">Return ID:</span> {{ $return->id }}<br>
                                                                            <span class="text-muted small">
                                                                                Status: <span class="badge {{ $returnStatusColors[$return->status] ?? 'bg-secondary' }}">
                                                                                    {{ $returnStatusLabels[$return->status] ?? ucfirst($return->status) }}
                                                                                </span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="list-unstyled mb-0 small mt-2">
                                                                        @if($return->admin_approved_at)
                                                                            <li><span class="text-success">Admin Approved:</span> {{ $return->admin_approved_at->format('d-m-Y H:i') }}</li>
                                                                        @endif
                                                                        @if($return->assigned_at)
                                                                            <li><span class="text-info">Assigned:</span> {{ $return->assigned_at->format('d-m-Y H:i') }}</li>
                                                                        @endif
                                                                        @if($return->approved_at)
                                                                            <li><span class="text-success">Approved:</span> {{ $return->approved_at->format('d-m-Y H:i') }}</li>
                                                                        @endif
                                                                        @if($return->picked_at)
                                                                            <li><span class="text-info">Picked:</span> {{ $return->picked_at->format('d-m-Y H:i') }}</li>
                                                                        @endif
                                                                        @if($return->received_at)
                                                                            <li><span class="text-success">Received:</span> {{ $return->received_at->format('d-m-Y H:i') }}</li>
                                                                        @endif
                                                                        @if($return->returned_at)
                                                                            <li><span class="text-success">Returned:</span> {{ $return->returned_at->format('d-m-Y H:i') }}</li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    {{-- Before Photos --}}
                                                    @php
                                                        $beforePhotos = json_decode($diagnosis->before_photos, true);
                                                    @endphp
                                                    @if ($beforePhotos && is_array($beforePhotos) && count($beforePhotos) > 0)
                                                        <div class="mb-3">
                                                            <h6 class="fw-semibold mb-2">Before Photos</h6>
                                                            <div class="d-flex flex-wrap gap-2">
                                                                @foreach ($beforePhotos as $photo)
                                                                    <a href="{{ asset('storage/' . $photo) }}" target="_blank" class="glightbox">
                                                                        <img src="{{ asset('storage/' . $photo) }}" alt="Before Photo" 
                                                                             class="rounded" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd;">
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- After Photos --}}
                                                    @php
                                                        $afterPhotos = json_decode($diagnosis->after_photos, true);
                                                    @endphp
                                                    @if ($afterPhotos && is_array($afterPhotos) && count($afterPhotos) > 0)
                                                        <div class="mb-3">
                                                            <h6 class="fw-semibold mb-2">After Photos</h6>
                                                            <div class="d-flex flex-wrap gap-2">
                                                                @foreach ($afterPhotos as $photo)
                                                                    <a href="{{ asset('storage/' . $photo) }}" target="_blank" class="glightbox">
                                                                        <img src="{{ asset('storage/' . $photo) }}" alt="After Photo" 
                                                                             class="rounded" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd;">
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Diagnosis Notes --}}
                                                    @if ($diagnosis->diagnosis_notes)
                                                        <div class="mb-2">
                                                            <h6 class="fw-semibold mb-1">Notes</h6>
                                                            <p class="text-muted mb-0">{{ $diagnosis->diagnosis_notes }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>

                <div class="col-xl-4">

                    <!-- Assign Engineer Card -->
                    @if ($request->status === 'admin_approved' || $request->status === 'in_transfer' || $request->status === 'engineer_not_approved')
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
                    @if ($request->activeAssignment)
                        <div class="card mt-3" id="assignedEngineersCard">
                            <div class="card-header border-bottom-dashed bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="mdi mdi-account-check"></i> Current Assignment
                                </h5>
                            </div>
                            <div class="card-body">
                                @if ($request->activeAssignment->assignment_type === 'individual')
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
                                            <span
                                                class="badge bg-info ms-2">{{ $request->activeAssignment->groupEngineers->count() }}
                                                Engineers</span>
                                        </h6>
                                        <p class="mb-3 text-muted small">
                                            <i class="mdi mdi-clock-outline"></i>
                                            Assigned: {{ $request->activeAssignment->assigned_at }}
                                        </p>

                                        <div class="row">
                                            @foreach ($request->activeAssignment->groupEngineers as $groupEngineer)
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

                    <!-- Picking Assignment Section -->
                    @php
                        $pickup = isset($pickups) && $pickups->count() > 0 ? $pickups->first() : null;
                        $showAssignmentForm = $pickup && ($pickup->status === 'admin_approved' || $pickup->status === 'approved');
                        $pickingProducts = [];
                        foreach ($request->products as $product) {
                            if ($product->diagnosisDetails && $product->diagnosisDetails->count() > 0) {
                                foreach ($product->diagnosisDetails as $diagnosis) {
                                    $diagnosisList = json_decode($diagnosis->diagnosis_list, true);
                                    if (is_array($diagnosisList)) {
                                        foreach ($diagnosisList as $item) {
                                            if (isset($item['status']) && $item['status'] === 'picking') {
                                                $pickingProducts[] = $product;
                                                break 2;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    @endphp
                    
                    @if (count($pickingProducts) > 0 || $pickup)
                        <div class="card mt-3" id="pickingAssignmentCard">
                            <div class="card-header border-bottom-dashed bg-warning-subtle">
                                <h5 class="card-title mb-0">
                                    <i class="mdi mdi-truck-delivery"></i> Assign Pickup
                                </h5>
                            </div>
                            <div class="card-body">
                                
                                {{-- Step 1: Admin Approval Form (shown when pickup is pending) --}}
                                @if ($pickup && $pickup->status === 'pending')
                                    <form id="adminPickupActionForm">
                                        @csrf
                                        <input type="hidden" name="pickup_id" value="{{ $pickup->id }}">
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <h6 class="fw-semibold mb-3">
                                                    <i class="mdi mdi-shield-check"></i> Step 1: Admin Action
                                                </h6>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Select Action</label>
                                                    <select name="action" id="admin_action" class="form-select">
                                                        <option value="">--Select Action--</option>
                                                        <option value="approved">Approve</option>
                                                        <option value="cancelled">Cancel</option>
                                                    </select>
                                                </div>
                                                <small class="text-muted d-block mb-2">
                                                    <i class="mdi mdi-information"></i>
                                                    Requested by: 
                                                    @if ($pickup->assigned_person_type === 'engineer')
                                                        Engineer: {{ $pickup->assignedPerson->first_name ?? 'N/A' }} {{ $pickup->assignedPerson->last_name ?? '' }}
                                                    @else
                                                        Delivery Man: {{ $pickup->assignedPerson->first_name ?? 'N/A' }} {{ $pickup->assignedPerson->last_name ?? '' }}
                                                    @endif
                                                </small>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="mdi mdi-check"></i> Submit
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @endif

                                {{-- Step 2: Pickup Assignment Form (shown after admin approval) --}}
                                @if (!$pickup || $showAssignmentForm)
                                    <form id="assignPickupForm">
                                        @csrf
                                        <input type="hidden" name="service_request_id" value="{{ $request->id }}">
                                        @if ($pickup && $pickup->status === 'approved')
                                            <input type="hidden" name="pickup_id" value="{{ $pickup->id }}">
                                            <div class="alert alert-info mb-3">
                                                <i class="mdi mdi-information"></i>
                                                <strong>Step 2:</strong> Please assign a person for pickup delivery.
                                            </div>
                                        @endif

                                        @if (count($pickingProducts) > 0)
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Products (Picking Status)</label>
                                                <div class="border rounded p-3 bg-light">
                                                    @foreach ($pickingProducts as $product)
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="mdi mdi-package-variant-closed text-primary me-2"></i>
                                                            <span>{{ $product->name }} ({{ $product->model_no ?? 'N/A' }})</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Assigned Person Type -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Assigned Person Type <span class="text-danger">*</span></label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="assigned_person_type"
                                                        id="personTypeDelivery" value="delivery_man">
                                                    <label class="form-check-label" for="personTypeDelivery">Delivery Man</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="assigned_person_type"
                                                        id="personTypeEngineer" value="engineer" checked>
                                                    <label class="form-check-label" for="personTypeEngineer">Engineer</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delivery Man Selection -->
                                        <div id="deliveryManSection" style="display: none;">
                                            <div class="mb-3">
                                                <label for="assigned_person_id" class="form-label">Select Delivery Man <span class="text-danger">*</span></label>
                                                <select name="assigned_person_id" id="assigned_person_id" class="form-select">
                                                    <option value="">--Select Delivery Man--</option>
                                                    @foreach ($deliveryMen as $deliveryMan)
                                                        <option value="{{ $deliveryMan->id }}">
                                                            {{ $deliveryMan->first_name }} {{ $deliveryMan->last_name }} ({{ $deliveryMan->phone }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Engineer Selection -->
                                        <div id="engineerSection">
                                            @php
                                                $assignedEngineerId = null;
                                                if ($request->activeAssignment && $request->activeAssignment->assignment_type === 'individual') {
                                                    $assignedEngineerId = $request->activeAssignment->engineer_id;
                                                }
                                            @endphp
                                            <div class="mb-3">
                                                <label for="engineer_assigned_person_id" class="form-label">Select Engineer <span class="text-danger">*</span></label>
                                                <select name="assigned_person_id" id="engineer_assigned_person_id" class="form-select">
                                                    <option value="">--Select Engineer--</option>
                                                    @foreach ($engineers as $engineer)
                                                        <option value="{{ $engineer->id }}" {{ $assignedEngineerId == $engineer->id ? 'selected' : '' }}>
                                                            {{ $engineer->first_name }} {{ $engineer->last_name }} ({{ $engineer->phone }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="mdi mdi-truck-check"></i> Assign Pickup
                                        </button>
                                    </form>
                                @endif

                                <!-- Existing Pickups -->
                                @if (isset($pickups) && $pickups->count() > 0)
                                    <div class="card mt-3">
                                        <div class="card-header border-bottom-dashed bg-light">
                                            <h5 class="card-title mb-0">
                                                <i class="mdi mdi-clipboard-list"></i> Pickup Records
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Person Type</th>
                                                            <th>Assigned To</th>
                                                            <th>Status</th>
                                                            <th>Assigned At</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pickups as $pickup)
                                                            <tr>
                                                                <td>{{ $pickup->serviceRequestProduct->name ?? 'N/A' }}</td>
                                                                <td>
                                                                    @if ($pickup->assigned_person_type === 'delivery_man')
                                                                        <span class="badge bg-info">Delivery Man</span>
                                                                    @else
                                                                        <span class="badge bg-primary">Engineer</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $pickup->assignedPerson->first_name ?? 'N/A' }} {{ $pickup->assignedPerson->last_name ?? '' }}</td>
                                                                <td>
                                                                    @php
                                                                        $pickupStatus = [
                                                                            'pending' => 'Pending',
                                                                            'assigned' => 'Assigned',
                                                                            'approved' => 'Approved',
                                                                            'picked' => 'Picked',
                                                                            'received' => 'Received',
                                                                            'cancelled' => 'Cancelled',
                                                                            'returned' => 'Returned',
                                                                            'completed' => 'Completed',
                                                                        ];
                                                                        $pickupStatusColor = [
                                                                            'pending' => 'bg-warning',
                                                                            'assigned' => 'bg-info',
                                                                            'approved' => 'bg-primary',
                                                                            'picked' => 'bg-secondary',
                                                                            'received' => 'bg-success',
                                                                            'cancelled' => 'bg-danger',
                                                                            'returned' => 'bg-warning',
                                                                            'completed' => 'bg-success',
                                                                        ];
                                                                    @endphp
                                                                    <span class="badge {{ $pickupStatusColor[$pickup->status] ?? 'bg-secondary' }}">
                                                                        {{ $pickupStatus[$pickup->status] ?? ucfirst($pickup->status) }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $pickup->assigned_at ? $pickup->assigned_at->format('d M Y, h:i A') : 'N/A' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{-- Return History Section - Show when pickup status is returned --}}
                                            @if (isset($pickups) && $pickups->where('status', 'returned')->count() > 0)
                                                @foreach ($pickups->where('status', 'returned') as $returnedPickup)
                                                    @php
                                                        $returnRecord = App\Models\ServiceRequestProductReturn::where('pickups_id', $returnedPickup->id)->first();
                                                    @endphp
                                                    @if ($returnRecord)
                                                        <div class="mt-3 p-3 border rounded">
                                                            <h6 class="fw-semibold mb-3">
                                                                <i class="mdi mdi-truck-delivery text-info"></i>
                                                                Return Delivery History - {{ $returnedPickup->serviceRequestProduct->name ?? 'N/A' }}
                                                            </h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item border-0 px-0 py-1 d-flex justify-content-between">
                                                                            <span class="fw-semibold">Assigned Person Type:</span>
                                                                            <span>
                                                                                @if ($returnRecord->assigned_person_type === 'delivery_man')
                                                                                    <span class="badge bg-info">Delivery Man</span>
                                                                                @else
                                                                                    <span class="badge bg-primary">Engineer</span>
                                                                                @endif
                                                                            </span>
                                                                        </li>
                                                                        <li class="list-group-item border-0 px-0 py-1 d-flex justify-content-between">
                                                                            <span class="fw-semibold">Assigned To:</span>
                                                                            <span>{{ $returnRecord->assignedPerson->first_name ?? 'N/A' }} {{ $returnRecord->assignedPerson->last_name ?? '' }}</span>
                                                                        </li>
                                                                        <li class="list-group-item border-0 px-0 py-1 d-flex justify-content-between">
                                                                            <span class="fw-semibold">Return Status:</span>
                                                                            <span class="badge bg-success">{{ ucfirst($returnRecord->status) }}</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item border-0 px-0 py-1 d-flex justify-content-between">
                                                                            <span class="fw-semibold">Assigned At:</span>
                                                                            <span>{{ $returnRecord->assigned_at ? $returnRecord->assigned_at->format('d M Y, h:i A') : 'N/A' }}</span>
                                                                        </li>
                                                                        <li class="list-group-item border-0 px-0 py-1 d-flex justify-content-between">
                                                                            <span class="fw-semibold">Accepted At:</span>
                                                                            <span>{{ $returnRecord->accepted_at ? \Carbon\Carbon::parse($returnRecord->accepted_at)->format('d M Y, h:i A') : 'N/A' }}</span>
                                                                        </li>
                                                                        <li class="list-group-item border-0 px-0 py-1 d-flex justify-content-between">
                                                                            <span class="fw-semibold">Picked At:</span>
                                                                            <span>{{ $returnRecord->picked_at ? \Carbon\Carbon::parse($returnRecord->picked_at)->format('d M Y, h:i A') : 'N/A' }}</span>
                                                                        </li>
                                                                        <li class="list-group-item border-0 px-0 py-1 d-flex justify-content-between">
                                                                            <span class="fw-semibold">Delivered At:</span>
                                                                            <span>{{ $returnRecord->delivered_at ? \Carbon\Carbon::parse($returnRecord->delivered_at)->format('d M Y, h:i A') : 'N/A' }}</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2">
                                                                <span class="badge bg-success-subtle text-success fw-semibold">
                                                                    <i class="mdi mdi-check-circle"></i> Product assigned for delivery to customer
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                                       
                                            {{-- {{$returns}} --}}
                                            {{-- Return Status Update Form - Show when return status is accepted --}}
                                            @if (isset($returns) && $returns->where('status', 'accepted')->count() > 0)
                                                @foreach ($returns->where('status', 'accepted') as $acceptedReturn)
                                                    <div class="mt-3 p-3 bg-info-subtle border rounded">
                                                        <h6 class="fw-semibold mb-3">
                                                            <i class="mdi mdi-truck-fast text-info"></i>
                                                            Mark as Picked - {{ $acceptedReturn->serviceRequestProduct->name ?? 'N/A' }}
                                                        </h6>
                                                        <form id="returnPickedForm_{{ $acceptedReturn->id }}">
                                                            @csrf
                                                            <input type="hidden" name="return_id" value="{{ $acceptedReturn->id }}">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <select name="return_status" class="form-select" style="width: auto;">
                                                                    <option value="picked">Picked</option>
                                                                </select>
                                                                <button type="submit" class="btn btn-info">
                                                                    <i class="mdi mdi-truck-delivery"></i> Confirm Picked
                                                                </button>
                                                            </div>
                                                            <small class="text-muted d-block mt-2">
                                                                <i class="mdi mdi-information"></i>
                                                                This will update return status to picked for this product.
                                                            </small>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            @endif

                                            {{-- Received Status Form - Show when pickup status is picked --}}
                                            @if (isset($pickups) && $pickups->where('status', 'picked')->count() > 0)
                                                @foreach ($pickups->where('status', 'picked') as $pickedPickup)
                                                    <div class="mt-3 p-3 bg-success-subtle border rounded">
                                                        <h6 class="fw-semibold mb-3">
                                                            <i class="mdi mdi-check-circle text-success"></i>
                                                            Mark as Received - {{ $pickedPickup->serviceRequestProduct->name ?? 'N/A' }}
                                                        </h6>
                                                        <form id="pickupReceivedForm_{{ $pickedPickup->id }}">
                                                            @csrf
                                                            <input type="hidden" name="pickup_id" value="{{ $pickedPickup->id }}">
                                                            <input type="hidden" name="status" value="received">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <select name="received_status" class="form-select" style="width: auto;">
                                                                    <option value="received">Received</option>
                                                                </select>
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="mdi mdi-check"></i> Confirm Received
                                                                </button>
                                                            </div>
                                                            <small class="text-muted d-block mt-2">
                                                                <i class="mdi mdi-information"></i>
                                                                This will update pickup status to received, product status to picked, and service request status to picked.
                                                            </small>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            @endif

                                            {{-- Diagnosis Form - Show when pickup status is received --}}
                                            @if (isset($pickups) && $pickups->where('status', 'received')->count() > 0)
                                                @foreach ($pickups->where('status', 'received') as $receivedPickup)
                                                    @php
                                                        $product = $receivedPickup->serviceRequestProduct;
                                                        $hasDiagnosis = $product->where('status', 'picked')->count() > 0;
                                                    @endphp
                                                    @if ($hasDiagnosis)
                                                        <div class="mt-3 p-3 bg-info-subtle border rounded" id="diagnosisFormSection_{{ $receivedPickup->id }}">
                                                            <h6 class="fw-semibold mb-3">
                                                                <i class="mdi mdi-clipboard-check text-primary"></i>
                                                                Submit Diagnosis - {{ $product->name ?? 'N/A' }}
                                                            </h6>
                                                            <form id="submitDiagnosisForm_{{ $receivedPickup->id }}">
                                                                @csrf
                                                                <input type="hidden" name="service_request_id" value="{{ $request->id }}">
                                                                <input type="hidden" name="service_request_product_id" value="{{ $product->id }}">
                                                                <input type="hidden" name="pickup_id" value="{{ $receivedPickup->id }}">
                                                                
                                                                {{-- Diagnosis List --}}
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold">Diagnosis List</label>
                                                                    <div id="diagnosisListContainer_{{ $receivedPickup->id }}">
                                                                        <div class="diagnosis-item mb-2 p-2 border rounded bg-white">
                                                                            <div class="row g-2">
                                                                                <div class="col-md-4">
                                                                                    <input type="text" name="diagnosis_list[0][component]" class="form-control" placeholder="Component Name" required>
                                                                                </div>
                                                                                <div class="col-md-5">
                                                                                    <input type="text" name="diagnosis_list[0][report]" class="form-control" placeholder="Report" required>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <select name="diagnosis_list[0][status]" class="form-select" required>
                                                                                        <option value="working">Working</option>
                                                                                        <option value="not_working">Not Working</option>
                                                                                        <option value="picking">Picking</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeDiagnosisItem(this)">
                                                                                <i class="mdi mdi-delete"></i> Remove
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addDiagnosisItem({{ $receivedPickup->id }})">
                                                                        <i class="mdi mdi-plus"></i> Add Component
                                                                    </button>
                                                                </div>

                                                                {{-- Diagnosis Notes --}}
                                                                <div class="mb-3">
                                                                    <label for="diagnosis_notes_{{ $receivedPickup->id }}" class="form-label fw-semibold">Diagnosis Notes</label>
                                                                    <textarea name="diagnosis_notes" id="diagnosis_notes_{{ $receivedPickup->id }}" class="form-control" rows="3" placeholder="Enter diagnosis notes..."></textarea>
                                                                </div>

                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="mdi mdi-check-all"></i> Submit Diagnosis
                                                                </button>
                                                                <small class="text-muted d-block mt-2">
                                                                    <i class="mdi mdi-information"></i>
                                                                    Submitting diagnosis will update product status to "Diagnosis Completed".
                                                                </small>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <div class="mt-3 p-3 bg-success-subtle border rounded">
                                                            <h6 class="fw-semibold mb-3">
                                                                <i class="mdi mdi-check-circle text-success"></i>
                                                                Diagnosis Already Submitted - {{ $product->name ?? 'N/A' }}
                                                            </h6>
                                                            <span class="badge bg-success">Diagnosis Completed</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                
                                {{-- Return Assignment Section - Show when pickup status is received and product status is diagnosis_completed --}}
                                @if (isset($pickups) && $pickups->where('status', 'received')->count() > 0)
                                    @foreach ($pickups->where('status', 'received') as $receivedPickup)
                                        @php
                                            $product = $receivedPickup->serviceRequestProduct;
                                            $hasReturn = $product && $product->status === 'completed';
                                            $existingReturn = App\Models\ServiceRequestProductReturn::where('pickups_id', $receivedPickup->id)->first();
                                        @endphp
                                        @if ($hasReturn && !$existingReturn)
                                            <div class="mt-3 p-3 bg-warning-subtle border rounded" id="returnAssignmentSection_{{ $receivedPickup->id }}">
                                                <h6 class="fw-semibold mb-3">
                                                    <i class="mdi mdi-truck-return text-warning"></i>
                                                    Assign Return - {{ $product->name ?? 'N/A' }}
                                                </h6>
                                                <p class="text-muted small mb-3">
                                                    <i class="mdi mdi-information"></i>
                                                    Product diagnosis is completed. Please assign a delivery person to return the product to the customer.
                                                </p>
                                                <form id="assignReturnForm_{{ $receivedPickup->id }}">
                                                    @csrf
                                                    <input type="hidden" name="request_id" value="{{ $request->id }}">
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="pickups_id" value="{{ $receivedPickup->id }}">
                                                    
                                                    <!-- Assigned Person Type -->
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Assigned Person Type <span class="text-danger">*</span></label>
                                                        <div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input return-person-type" type="radio" 
                                                                    name="assigned_person_type"
                                                                    id="returnPersonTypeDelivery_{{ $receivedPickup->id }}" value="delivery_man">
                                                                <label class="form-check-label" for="returnPersonTypeDelivery_{{ $receivedPickup->id }}">Delivery Man</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input return-person-type" type="radio" 
                                                                    name="assigned_person_type"
                                                                    id="returnPersonTypeEngineer_{{ $receivedPickup->id }}" value="engineer" checked>
                                                                <label class="form-check-label" for="returnPersonTypeEngineer_{{ $receivedPickup->id }}">Engineer</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Delivery Man Selection -->
                                                    <div id="returnDeliveryManSection_{{ $receivedPickup->id }}" style="display: none;">
                                                        <div class="mb-3">
                                                            <label for="return_assigned_person_id_{{ $receivedPickup->id }}" class="form-label">Select Delivery Man <span class="text-danger">*</span></label>
                                                            <select name="delivery_man_id" id="return_assigned_person_id_{{ $receivedPickup->id }}" class="form-select">
                                                                <option value="">--Select Delivery Man--</option>
                                                                @foreach ($deliveryMen as $deliveryMan)
                                                                    <option value="{{ $deliveryMan->id }}">
                                                                        {{ $deliveryMan->first_name }} {{ $deliveryMan->last_name }} ({{ $deliveryMan->phone }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Engineer Selection -->
                                                    <div id="returnEngineerSection_{{ $receivedPickup->id }}">
                                                        @php
                                                            $assignedEngineerId = null;
                                                            if ($request->activeAssignment && $request->activeAssignment->assignment_type === 'individual') {
                                                                $assignedEngineerId = $request->activeAssignment->engineer_id;
                                                            }
                                                        @endphp
                                                        <div class="mb-3">
                                                            <label for="return_engineer_assigned_person_id_{{ $receivedPickup->id }}" class="form-label">Select Engineer <span class="text-danger">*</span></label>
                                                            <select name="engineer_id" id="return_engineer_assigned_person_id_{{ $receivedPickup->id }}" class="form-select">
                                                                <option value="">--Select Engineer--</option>
                                                                @foreach ($engineers as $engineer)
                                                                    <option value="{{ $engineer->id }}" {{ $assignedEngineerId == $engineer->id ? 'selected' : '' }}>
                                                                        {{ $engineer->first_name }} {{ $engineer->last_name }} ({{ $engineer->phone }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="mdi mdi-truck-check"></i> Assign for Return
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif ($existingReturn)
                                            <div class="mt-3 p-3 bg-info-subtle border rounded" id="returnAssignedSection_{{ $receivedPickup->id }}">
                                                <h6 class="fw-semibold mb-3">
                                                    <i class="mdi mdi-check-circle text-info"></i>
                                                    Return Assigned - {{ $product->name ?? 'N/A' }}
                                                </h6>
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="fw-semibold me-2">Assigned To:</span>
                                                    @if ($existingReturn->assigned_person_type === 'delivery_man')
                                                        <span class="badge bg-info">Delivery Man</span>
                                                    @else
                                                        <span class="badge bg-primary">Engineer</span>
                                                    @endif
                                                    <span class="ms-2">{{ $existingReturn->assignedPerson->first_name ?? 'N/A' }} {{ $existingReturn->assignedPerson->last_name ?? '' }}</span>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-semibold me-2">Status:</span>
                                                    @php
                                                        $returnStatus = [
                                                            'pending' => 'Pending',
                                                            'assigned' => 'Assigned',
                                                            'in_transit' => 'In Transit',
                                                            'delivered' => 'Delivered',
                                                            'cancelled' => 'Cancelled',
                                                            'completed' => 'Completed',
                                                        ];
                                                        $returnStatusColor = [
                                                            'pending' => 'bg-warning',
                                                            'assigned' => 'bg-info',
                                                            'in_transit' => 'bg-primary',
                                                            'delivered' => 'bg-success',
                                                            'cancelled' => 'bg-danger',
                                                            'completed' => 'bg-success',
                                                        ];
                                                    @endphp
                                                    <span class="badge {{ $returnStatusColor[$existingReturn->status] ?? 'bg-secondary' }}">
                                                        {{ $returnStatus[$existingReturn->status] ?? ucfirst($existingReturn->status) }}
                                                    </span>
                                                </div>
                                                <p class="text-muted small mt-2 mb-0">
                                                    <i class="mdi mdi-clock-outline"></i>
                                                    Delivery will be done shortly.
                                                </p>
                                            </div>
                                        @endif
                                    @endforeach
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

                submitBtn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Processing...');

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

                submitBtn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Processing...');

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

                if (!confirm('Are you sure you want to mark this pickup as received? This will update the product and service request status to picked.')) {
                    return;
                }

                submitBtn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Processing...');

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

                submitBtn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Processing...');

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

                if (!confirm('Are you sure you want to submit this diagnosis? This will update the product status to Diagnosis Completed.')) {
                    return;
                }

                submitBtn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Processing...');

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

                submitBtn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Processing...');

                $.ajax({
                    url: "{{ route('service-request.assign-return') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        submitBtn.prop('disabled', false).html(originalBtnText);

                        if (response.success) {
                            alert('Return assigned successfully! Delivery will be done shortly.');
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

        // Function to update person dropdown based on selected type (engineer or delivery man)
        function updatePersonDropdown(requestPartId, type) {
            const selectElement = document.getElementById('person_select_' + requestPartId);
            if (!selectElement) return;
            
            // Clear existing options
            selectElement.innerHTML = '<option value="">-- Select Person --</option>';
            
            // Get the appropriate data based on type
            let people = [];
            if (type === 'engineer') {
                try {
                    people = JSON.parse(selectElement.getAttribute('data-engineers'));
                } catch (e) {
                    console.error('Error parsing engineers data:', e);
                }
            } else if (type === 'delivery_man') {
                try {
                    people = JSON.parse(selectElement.getAttribute('data-delivery-men'));
                } catch (e) {
                    console.error('Error parsing delivery men data:', e);
                }
            }
            
            // Add options to dropdown
            people.forEach(function(person) {
                const option = document.createElement('option');
                option.value = person.id;
                option.textContent = person.name;
                selectElement.appendChild(option);
            });
        }

        // Initialize dropdown with engineers on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.person-select').forEach(function(select) {
                const requestPartId = select.id.replace('person_select_', '');
                // Default to engineers on page load
                updatePersonDropdown(requestPartId, 'engineer');
            });
        });
    </script>
@endsection
