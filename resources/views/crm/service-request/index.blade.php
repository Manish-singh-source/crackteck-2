@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Service Request</h4>
                </div>
            </div>

            <!-- End Main Widgets -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-2">
                            <div class="d-flex justify-content-between align-items-center border-bottom">
                                <ul class="nav nav-underline pt-2" id="pills-tab" role="tablist">
                                    {{-- AMC Services --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active p-2" onclick="showService('AMC')" id="amc_service_tab"
                                            data-bs-toggle="tab" href="#amc_services" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                            <span class="d-none d-sm-block">AMC Services</span>
                                        </a>
                                    </li>

                                    {{-- Installation Services --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" onclick="showService('Installation')"
                                            id="installation_services_tab" data-bs-toggle="tab" href="#installation_service"
                                            role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-sitemap-outline"></i></span>
                                            <span class="d-none d-sm-block">Installation Services</span>
                                        </a>
                                    </li>

                                    {{-- Repairing Services --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" onclick="showService('Repairing')"
                                            id="repairing_services_tab" data-bs-toggle="tab" href="#repairing_services"
                                            role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-sitemap-outline"></i></span>
                                            <span class="d-none d-sm-block">Repairing Services</span>
                                        </a>
                                    </li>

                                    {{-- Quick Services --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" onclick="showService('Quick')" id="quick_services_tab"
                                            data-bs-toggle="tab" href="#quick_services" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-sitemap-outline"></i></span>
                                            <span class="d-none d-sm-block">Quick Services</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content text-muted">

                                {{-- AMC services (default active) --}}
                                <div class="tab-pane active show" id="amc_services" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <div id="amc_filters" class="d-flex justify-content-between align-items-center mb-3" style="display: none;">
                                                        <div class="d-flex gap-3">
                                                            <select class="form-select request-status-filter" data-service="amc" style="width: 200px;">
                                                                <option value="">All Request Status</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="approved">Approved</option>
                                                                <option value="rejected">Rejected</option>
                                                                <option value="processing">Processing</option>
                                                                <option value="processed">Processed</option>
                                                                <option value="picking">Picking</option>
                                                                <option value="picked">Picked</option>
                                                                <option value="completed">Completed</option>
                                                            </select>
                                                            <select class="form-select status-filter" data-service="amc" style="width: 200px;">
                                                                <option value="">All Status</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="admin_approved">Admin Approved</option>
                                                                <option value="assigned_engineer">Engineer Assigned</option>
                                                                <option value="engineer_approved">Engineer Approved</option>
                                                                <option value="engineer_not_approved">Engineer Not Approved</option>
                                                                <option value="in_transfer">In Transfer</option>
                                                                <option value="transferred">Transferred</option>
                                                                <option value="in_progress">In Progress</option>
                                                                <option value="picking">Picking</option>
                                                                <option value="picked">Picked</option>
                                                                <option value="completed">Completed</option>
                                                            </select>
                                                        </div>
                                                        <a href="{{ route('amc-service-requests.create') }}" class="btn btn-primary">Create AMC</a>
                                                    </div>
                                                    <table
                                                        class="table table-striped table-borderless dt-responsive nowrap service-datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>Request ID</th>
                                                                <th>Customer Name</th>
                                                                <th>Request Date</th>
                                                                <th>Product Name / Model No</th>
                                                                <th>Request Status</th>
                                                                <th>Request Source</th>
                                                                <th>Assign Engineer</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($amcServices as $request)
                                                                <tr>
                                                                    <td>{{ $request->request_id }}</td>
                                                                    <td>
                                                                        <div class="fw-semibold">
                                                                            {{ $request->customer->first_name ?? '' }}
                                                                            {{ $request->customer->last_name ?? '' }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $request->customer->email ?? '' }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $request->customer->phone ?? 'N/A' }}
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $request->request_date->format('Y-m-d') }}</td>
                                                                    <td>
                                                                        <div class="fw-semibold">
                                                                            {{ $request->products->count() }} Product(s)
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $statusClasses = [
                                                                                'pending' => 'badge bg-warning',
                                                                                'approved' => 'badge bg-success',
                                                                                'rejected' => 'badge bg-danger',
                                                                                'processing' => 'badge bg-info',
                                                                                'processed' => 'badge bg-primary',
                                                                                'picking' => 'badge bg-secondary',
                                                                                'picked' => 'badge bg-dark',
                                                                                'completed' => 'badge bg-success',
                                                                            ];
                                                                        @endphp

                                                                        <span
                                                                            class="{{ $statusClasses[$request->request_status] ?? 'badge bg-light' }}">
                                                                            {{ ucfirst($request->request_status) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        @if ($request->request_source == 'customer')
                                                                            <span
                                                                                class="badge bg-primary-subtle text-primary fw-semibold">Customer</span>
                                                                        @elseif($request->request_source == 'system')
                                                                            <span
                                                                                class="badge bg-secondary-subtle text-secondary fw-semibold">System</span>
                                                                        @endif
                                                                        <div class="text-muted small">
                                                                            {{ $request->created_at->diffForHumans() }}
                                                                        </div>
                                                                    </td>

                                                                    @php
                                                                        $statuses = [
                                                                            'pending' => ['Pending', 'warning'],
                                                                            'admin_approved' => [
                                                                                'Admin Approved',
                                                                                'info',
                                                                            ],
                                                                            'assigned_engineer' => [
                                                                                'Engineer Assigned',
                                                                                'primary',
                                                                            ],
                                                                            'engineer_approved' => [
                                                                                'Engineer Approved',
                                                                                'success',
                                                                            ],
                                                                            'engineer_not_approved' => [
                                                                                'Engineer Not Approved',
                                                                                'danger',
                                                                            ],
                                                                            'in_transfer' => ['In Transfer', 'warning'],
                                                                            'transferred' => [
                                                                                'Transferred',
                                                                                'secondary',
                                                                            ],
                                                                            'in_progress' => ['In Progress', 'primary'],
                                                                            'picking' => ['Picking', 'info'],
                                                                            'picked' => ['Picked', 'dark'],
                                                                            'completed' => ['Completed', 'success'],
                                                                        ];

                                                                        [$label, $color] = $statuses[
                                                                            $request->status
                                                                        ] ?? [
                                                                            ucfirst(
                                                                                str_replace('_', ' ', $request->status),
                                                                            ),
                                                                            'secondary',
                                                                        ];
                                                                    @endphp

                                                                    <td>
                                                                        @if ($request->is_engineer_assigned == 'assigned')
                                                                            <span
                                                                                class="badge bg-primary-subtle text-primary fw-semibold">Assigned</span>
                                                                        @elseif($request->is_engineer_assigned == 'not_assigned')
                                                                            <span
                                                                                class="badge bg-secondary-subtle text-secondary fw-semibold">Not
                                                                                Assigned</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        <span
                                                                            class="badge bg-{{ $color }}-subtle text-{{ $color }} fw-semibold">
                                                                            {{ $label }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('service-request.view-amc-service-request', $request->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('service-request.edit-amc-service-request', $request->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('service-request.destroy-quick-service-request', $request->id) }}"
                                                                            method="POST" class="d-inline"
                                                                            onsubmit="return confirm('Are you sure you want to delete this quick service request?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" aria-label="anchor"
                                                                                class="btn btn-icon btn-sm bg-danger-subtle"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Delete">
                                                                                <i
                                                                                    class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9"
                                                                        class="text-center text-muted py-4">
                                                                        <div class="text-muted">
                                                                            <i
                                                                                class="mdi mdi-information-outline fs-1"></i>
                                                                            <p class="mt-2">
                                                                                No Quick Service requests found.
                                                                                <a
                                                                                    href="{{ route('quick-service-requests.create') }}">Create
                                                                                    one now</a>
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Installation services --}}
                                <div class="tab-pane" id="installation_service" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <div id="installation_filters" class="d-flex justify-content-between align-items-center mb-3" style="display: none;">
                                                        <div class="d-flex gap-3">
                                                            <select class="form-select request-status-filter" data-service="installation" style="width: 200px;">
                                                                <option value="">All Request Status</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="approved">Approved</option>
                                                                <option value="rejected">Rejected</option>
                                                                <option value="processing">Processing</option>
                                                                <option value="processed">Processed</option>
                                                                <option value="picking">Picking</option>
                                                                <option value="picked">Picked</option>
                                                                <option value="completed">Completed</option>
                                                            </select>
                                                            <select class="form-select status-filter" data-service="installation" style="width: 200px;">
                                                                <option value="">All Status</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="admin_approved">Admin Approved</option>
                                                                <option value="assigned_engineer">Engineer Assigned</option>
                                                                <option value="engineer_approved">Engineer Approved</option>
                                                                <option value="engineer_not_approved">Engineer Not Approved</option>
                                                                <option value="in_transfer">In Transfer</option>
                                                                <option value="transferred">Transferred</option>
                                                                <option value="in_progress">In Progress</option>
                                                                <option value="picking">Picking</option>
                                                                <option value="picked">Picked</option>
                                                                <option value="completed">Completed</option>
                                                            </select>
                                                        </div>
                                                        <a href="{{ route('quick-service-requests.create') }}" class="btn btn-primary">Create Installation</a>
                                                    </div>
                                                    <table
                                                        class="table table-striped table-borderless nowrap service-datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>Request ID</th>
                                                                <th>Customer Name</th>
                                                                <th>Request Date</th>
                                                                <th>Product Name / Model No</th>
                                                                <th>Request Status</th>
                                                                <th>Request Source</th>
                                                                <th>Assign Engineer</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($installationServices as $request)
                                                                <tr>
                                                                    <td>{{ $request->request_id }}</td>
                                                                    <td>
                                                                        <div class="fw-semibold">
                                                                            {{ $request->customer->first_name ?? '' }}
                                                                            {{ $request->customer->last_name ?? '' }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $request->customer->email ?? '' }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $request->customer->phone ?? 'N/A' }}
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $request->request_date->format('Y-m-d') }}</td>
                                                                    <td>
                                                                        <div class="fw-semibold">
                                                                            {{ $request->products->count() }} Product(s)
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $statusClasses = [
                                                                                'pending' => 'badge bg-warning',
                                                                                'approved' => 'badge bg-success',
                                                                                'rejected' => 'badge bg-danger',
                                                                                'processing' => 'badge bg-info',
                                                                                'processed' => 'badge bg-primary',
                                                                                'picking' => 'badge bg-secondary',
                                                                                'picked' => 'badge bg-dark',
                                                                                'completed' => 'badge bg-success',
                                                                            ];
                                                                        @endphp

                                                                        <span
                                                                            class="{{ $statusClasses[$request->request_status] ?? 'badge bg-light' }}">
                                                                            {{ ucfirst($request->request_status) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        @if ($request->request_source == 'customer')
                                                                            <span
                                                                                class="badge bg-primary-subtle text-primary fw-semibold">Customer</span>
                                                                        @elseif($request->request_source == 'system')
                                                                            <span
                                                                                class="badge bg-secondary-subtle text-secondary fw-semibold">System</span>
                                                                        @endif
                                                                        <div class="text-muted small">
                                                                            {{ $request->created_at->diffForHumans() }}
                                                                        </div>
                                                                    </td>

                                                                    @php
                                                                        $statuses = [
                                                                            'pending' => ['Pending', 'warning'],
                                                                            'admin_approved' => [
                                                                                'Admin Approved',
                                                                                'info',
                                                                            ],
                                                                            'assigned_engineer' => [
                                                                                'Engineer Assigned',
                                                                                'primary',
                                                                            ],
                                                                            'engineer_approved' => [
                                                                                'Engineer Approved',
                                                                                'success',
                                                                            ],
                                                                            'engineer_not_approved' => [
                                                                                'Engineer Not Approved',
                                                                                'danger',
                                                                            ],
                                                                            'in_transfer' => ['In Transfer', 'warning'],
                                                                            'transferred' => [
                                                                                'Transferred',
                                                                                'secondary',
                                                                            ],
                                                                            'in_progress' => ['In Progress', 'primary'],
                                                                            'picking' => ['Picking', 'info'],
                                                                            'picked' => ['Picked', 'dark'],
                                                                            'completed' => ['Completed', 'success'],
                                                                        ];

                                                                        [$label, $color] = $statuses[
                                                                            $request->status
                                                                        ] ?? [
                                                                            ucfirst(
                                                                                str_replace('_', ' ', $request->status),
                                                                            ),
                                                                            'secondary',
                                                                        ];
                                                                    @endphp

                                                                    <td>
                                                                        @if ($request->is_engineer_assigned == 'assigned')
                                                                            <span
                                                                                class="badge bg-primary-subtle text-primary fw-semibold">Assigned</span>
                                                                        @elseif($request->is_engineer_assigned == 'not_assigned')
                                                                            <span
                                                                                class="badge bg-secondary-subtle text-secondary fw-semibold">Not
                                                                                Assigned</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        <span
                                                                            class="badge bg-{{ $color }}-subtle text-{{ $color }} fw-semibold">
                                                                            {{ $label }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('service-request.view-quick-service-request', $request->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('service-request.edit-quick-service-request', [$request->id, 'installation']) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('service-request.destroy-quick-service-request', $request->id) }}"
                                                                            method="POST" class="d-inline"
                                                                            onsubmit="return confirm('Are you sure you want to delete this quick service request?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" aria-label="anchor"
                                                                                class="btn btn-icon btn-sm bg-danger-subtle"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Delete">
                                                                                <i
                                                                                    class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9"
                                                                        class="text-center text-muted py-4">
                                                                        <div class="text-muted">
                                                                            <i
                                                                                class="mdi mdi-information-outline fs-1"></i>
                                                                            <p class="mt-2">
                                                                                No Quick Service requests found.
                                                                                <a
                                                                                    href="{{ route('quick-service-requests.create') }}">Create
                                                                                    one now</a>
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Repairing services --}}
                                <div class="tab-pane" id="repairing_services" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <div id="repairing_filters" class="d-flex justify-content-between align-items-center mb-3" style="display: none;">
                                                        <div class="d-flex gap-3">
                                                            <select class="form-select request-status-filter" data-service="repairing" style="width: 200px;">
                                                                <option value="">All Request Status</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="approved">Approved</option>
                                                                <option value="rejected">Rejected</option>
                                                                <option value="processing">Processing</option>
                                                                <option value="processed">Processed</option>
                                                                <option value="picking">Picking</option>
                                                                <option value="picked">Picked</option>
                                                                <option value="completed">Completed</option>
                                                            </select>
                                                            <select class="form-select status-filter" data-service="repairing" style="width: 200px;">
                                                                <option value="">All Status</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="admin_approved">Admin Approved</option>
                                                                <option value="assigned_engineer">Engineer Assigned</option>
                                                                <option value="engineer_approved">Engineer Approved</option>
                                                                <option value="engineer_not_approved">Engineer Not Approved</option>
                                                                <option value="in_transfer">In Transfer</option>
                                                                <option value="transferred">Transferred</option>
                                                                <option value="in_progress">In Progress</option>
                                                                <option value="picking">Picking</option>
                                                                <option value="picked">Picked</option>
                                                                <option value="completed">Completed</option>
                                                            </select>
                                                        </div>
                                                        <a href="{{ route('quick-service-requests.create') }}" class="btn btn-primary">Create Repairing</a>
                                                    </div>
                                                    <table
                                                        class="table table-striped table-borderless nowrap service-datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>Request ID</th>
                                                                <th>Customer Name</th>
                                                                <th>Request Date</th>
                                                                <th>Product Name / Model No</th>
                                                                <th>Request Status</th>
                                                                <th>Request Source</th>
                                                                <th>Assign Engineer</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($repairingServices as $request)
                                                                <tr>
                                                                    <td>{{ $request->request_id }}</td>
                                                                    <td>
                                                                        <div class="fw-semibold">
                                                                            {{ $request->customer->first_name ?? '' }}
                                                                            {{ $request->customer->last_name ?? '' }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $request->customer->email ?? '' }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $request->customer->phone ?? 'N/A' }}
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $request->request_date->format('Y-m-d') }}</td>
                                                                    <td>
                                                                        <div class="fw-semibold">
                                                                            {{ $request->products->count() }} Product(s)
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $statusClasses = [
                                                                                'pending' => 'badge bg-warning',
                                                                                'approved' => 'badge bg-success',
                                                                                'rejected' => 'badge bg-danger',
                                                                                'processing' => 'badge bg-info',
                                                                                'processed' => 'badge bg-primary',
                                                                                'picking' => 'badge bg-secondary',
                                                                                'picked' => 'badge bg-dark',
                                                                                'completed' => 'badge bg-success',
                                                                            ];
                                                                        @endphp

                                                                        <span
                                                                            class="{{ $statusClasses[$request->request_status] ?? 'badge bg-light' }}">
                                                                            {{ ucfirst($request->request_status) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        @if ($request->request_source == 'customer')
                                                                            <span
                                                                                class="badge bg-primary-subtle text-primary fw-semibold">Customer</span>
                                                                        @elseif($request->request_source == 'system')
                                                                            <span
                                                                                class="badge bg-secondary-subtle text-secondary fw-semibold">System</span>
                                                                        @endif
                                                                        <div class="text-muted small">
                                                                            {{ $request->created_at->diffForHumans() }}
                                                                        </div>
                                                                    </td>

                                                                    @php
                                                                        $statuses = [
                                                                            'pending' => ['Pending', 'warning'],
                                                                            'admin_approved' => [
                                                                                'Admin Approved',
                                                                                'info',
                                                                            ],
                                                                            'assigned_engineer' => [
                                                                                'Engineer Assigned',
                                                                                'primary',
                                                                            ],
                                                                            'engineer_approved' => [
                                                                                'Engineer Approved',
                                                                                'success',
                                                                            ],
                                                                            'engineer_not_approved' => [
                                                                                'Engineer Not Approved',
                                                                                'danger',
                                                                            ],
                                                                            'in_transfer' => ['In Transfer', 'warning'],
                                                                            'transferred' => [
                                                                                'Transferred',
                                                                                'secondary',
                                                                            ],
                                                                            'in_progress' => ['In Progress', 'primary'],
                                                                            'picking' => ['Picking', 'info'],
                                                                            'picked' => ['Picked', 'dark'],
                                                                            'completed' => ['Completed', 'success'],
                                                                        ];

                                                                        [$label, $color] = $statuses[
                                                                            $request->status
                                                                        ] ?? [
                                                                            ucfirst(
                                                                                str_replace('_', ' ', $request->status),
                                                                            ),
                                                                            'secondary',
                                                                        ];
                                                                    @endphp

                                                                    <td>
                                                                        @if ($request->is_engineer_assigned == 'assigned')
                                                                            <span
                                                                                class="badge bg-primary-subtle text-primary fw-semibold">Assigned</span>
                                                                        @elseif($request->is_engineer_assigned == 'not_assigned')
                                                                            <span
                                                                                class="badge bg-secondary-subtle text-secondary fw-semibold">Not
                                                                                Assigned</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        <span
                                                                            class="badge bg-{{ $color }}-subtle text-{{ $color }} fw-semibold">
                                                                            {{ $label }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('service-request.view-quick-service-request', $request->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('service-request.edit-quick-service-request', $request->id, 'repair') }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('service-request.destroy-quick-service-request', $request->id) }}"
                                                                            method="POST" class="d-inline"
                                                                            onsubmit="return confirm('Are you sure you want to delete this quick service request?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" aria-label="anchor"
                                                                                class="btn btn-icon btn-sm bg-danger-subtle"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Delete">
                                                                                <i
                                                                                    class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9"
                                                                        class="text-center text-muted py-4">
                                                                        <div class="text-muted">
                                                                            <i
                                                                                class="mdi mdi-information-outline fs-1"></i>
                                                                            <p class="mt-2">
                                                                                No Quick Service requests found.
                                                                                <a
                                                                                    href="{{ route('quick-service-requests.create') }}">Create
                                                                                    one now</a>
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Quick services --}}
                                <div class="tab-pane" id="quick_services" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <div id="quick_filters" class="d-flex justify-content-between align-items-center mb-3" style="display: none;">
                                                        <div class="d-flex gap-3">
                                                            <select class="form-select request-status-filter" data-service="quick" style="width: 200px;">
                                                                <option value="">All Request Status</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="approved">Approved</option>
                                                                <option value="rejected">Rejected</option>
                                                                <option value="processing">Processing</option>
                                                                <option value="processed">Processed</option>
                                                                <option value="picking">Picking</option>
                                                                <option value="picked">Picked</option>
                                                                <option value="completed">Completed</option>
                                                            </select>
                                                            <select class="form-select status-filter" data-service="quick" style="width: 200px;">
                                                                <option value="">All Status</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="admin_approved">Admin Approved</option>
                                                                <option value="assigned_engineer">Engineer Assigned</option>
                                                                <option value="engineer_approved">Engineer Approved</option>
                                                                <option value="engineer_not_approved">Engineer Not Approved</option>
                                                                <option value="in_transfer">In Transfer</option>
                                                                <option value="transferred">Transferred</option>
                                                                <option value="in_progress">In Progress</option>
                                                                <option value="picking">Picking</option>
                                                                <option value="picked">Picked</option>
                                                                <option value="completed">Completed</option>
                                                            </select>
                                                        </div>
                                                        <a href="{{ route('quick-service-requests.create') }}" class="btn btn-primary">Create Quick</a>
                                                    </div>
                                                    <table
                                                        class="table table-striped table-borderless nowrap service-datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>Request ID</th>
                                                                <th>Customer Name</th>
                                                                <th>Request Date</th>
                                                                <th>Product Name / Model No</th>
                                                                <th>Visit Date</th>
                                                                <th>Reschedule Date</th>
                                                                <th>Request Source</th>
                                                                <th>Assign Engineer</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($quickServiceRequests as $request)
                                                                <tr>
                                                                    <td>{{ $request->request_id }}</td>
                                                                    <td>
                                                                        <div class="fw-semibold">
                                                                            {{ $request->customer->first_name ?? '' }}
                                                                            {{ $request->customer->last_name ?? '' }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $request->customer->email ?? '' }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $request->customer->phone ?? 'N/A' }}
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $request->request_date->format('Y-m-d') }}</td>
                                                                    <td>
                                                                        <div class="fw-semibold">
                                                                            {{ $request->products->count() }} Product(s)
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $request->visit_date ?? 'N/A' }}</td>
                                                                    <td>{{ $request->reschedule_date ?? 'N/A' }}</td>
                                                                    <td>
                                                                        @if ($request->request_source == 'customer')
                                                                            <span
                                                                                class="badge bg-primary-subtle text-primary fw-semibold">Customer</span>
                                                                        @elseif($request->request_source == 'system')
                                                                            <span
                                                                                class="badge bg-secondary-subtle text-secondary fw-semibold">System</span>
                                                                        @endif
                                                                        <div class="text-muted small">
                                                                            {{ $request->created_at->diffForHumans() }}
                                                                        </div>
                                                                    </td>

                                                                    @php
                                                                        $statuses = [
                                                                            'pending' => ['Pending', 'warning'],
                                                                            'admin_approved' => [
                                                                                'Admin Approved',
                                                                                'info',
                                                                            ],
                                                                            'assigned_engineer' => [
                                                                                'Engineer Assigned',
                                                                                'primary',
                                                                            ],
                                                                            'engineer_approved' => [
                                                                                'Engineer Approved',
                                                                                'success',
                                                                            ],
                                                                            'engineer_not_approved' => [
                                                                                'Engineer Not Approved',
                                                                                'danger',
                                                                            ],
                                                                            'in_transfer' => ['In Transfer', 'warning'],
                                                                            'transferred' => [
                                                                                'Transferred',
                                                                                'secondary',
                                                                            ],
                                                                            'in_progress' => ['In Progress', 'primary'],
                                                                            'picking' => ['Picking', 'info'],
                                                                            'picked' => ['Picked', 'dark'],
                                                                            'completed' => ['Completed', 'success'],
                                                                        ];

                                                                        [$label, $color] = $statuses[
                                                                            $request->status
                                                                        ] ?? [
                                                                            ucfirst(
                                                                                str_replace('_', ' ', $request->status),
                                                                            ),
                                                                            'secondary',
                                                                        ];
                                                                    @endphp

                                                                    <td>
                                                                        @if ($request->is_engineer_assigned == 'assigned')
                                                                            <span
                                                                                class="badge bg-primary-subtle text-primary fw-semibold">Assigned</span>
                                                                        @elseif($request->is_engineer_assigned == 'not_assigned')
                                                                            <span
                                                                                class="badge bg-secondary-subtle text-secondary fw-semibold">Not
                                                                                Assigned</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        <span
                                                                            class="badge bg-{{ $color }}-subtle text-{{ $color }} fw-semibold">
                                                                            {{ $label }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('service-request.view-quick-service-request', $request->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('service-request.edit-quick-service-request', [$request->id, 'quick_service']) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('service-request.destroy-quick-service-request', $request->id) }}"
                                                                            method="POST" class="d-inline"
                                                                            onsubmit="return confirm('Are you sure you want to delete this quick service request?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" aria-label="anchor"
                                                                                class="btn btn-icon btn-sm bg-danger-subtle"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Delete">
                                                                                <i
                                                                                    class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9"
                                                                        class="text-center text-muted py-4">
                                                                        <div class="text-muted">
                                                                            <i
                                                                                class="mdi mdi-information-outline fs-1"></i>
                                                                            <p class="mt-2">
                                                                                No Quick Service requests found.
                                                                                <a
                                                                                    href="{{ route('quick-service-requests.create') }}">Create
                                                                                    one now</a>
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> {{-- tab-content --}}
                        </div>
                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- container-fluid -->
    </div> <!-- content -->

    <script>
        function showService(type) {
            // Hide all filter divs first
            document.getElementById("amc_filters").style.display = "none";
            document.getElementById("installation_filters").style.display = "none";
            document.getElementById("repairing_filters").style.display = "none";
            document.getElementById("quick_filters").style.display = "none";

            // Show the correct filter div based on tab
            switch (type) {
                case 'AMC':
                    document.getElementById("amc_filters").style.display = "flex";
                    break;
                case 'Installation':
                    document.getElementById("installation_filters").style.display = "flex";
                    break;
                case 'Repairing':
                    document.getElementById("repairing_filters").style.display = "flex";
                    break;
                case 'Quick':
                    document.getElementById("quick_filters").style.display = "flex";
                    break;
            }
        }

        // Default: AMC tab visible
        showService('AMC');
    </script>

    <script>
        $(document).ready(function() {
            $('.service-datatable').each(function() {
                if (!$.fn.DataTable.isDataTable(this)) {
                    $(this).DataTable({
                        pageLength: 10
                    });
                }
            });

            // Filtering functionality for both request status and status
            $('.request-status-filter, .status-filter').on('change', function() {
                const serviceType = $(this).data('service');
                applyFilters(serviceType);
            });

            function applyFilters(serviceType) {
                const tableId = getTableId(serviceType);
                const table = $('#' + tableId).find('table');
                const filtersDiv = $('#' + serviceType + '_filters');
                const selectedRequestStatus = filtersDiv.find('.request-status-filter').val();
                const selectedStatus = filtersDiv.find('.status-filter').val();

                table.find('tbody tr').each(function() {
                    const requestStatusCell = $(this).find('td').eq(4); // Request Status column (0-indexed)
                    const statusCell = $(this).find('td').eq(7); // Status column (0-indexed)
                    const requestStatusBadge = requestStatusCell.find('.badge');
                    const statusBadge = statusCell.find('.badge');
                    const requestStatusText = requestStatusBadge.text().trim();
                    const statusText = statusBadge.text().trim();

                    const requestStatusKey = requestStatusText.toLowerCase(); // display is ucfirst(key)
                    const statusKey = getStatusKey(statusText);

                    const showRow = (selectedRequestStatus === '' || requestStatusKey === selectedRequestStatus) &&
                                    (selectedStatus === '' || statusKey === selectedStatus);

                    if (showRow) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                // Reinitialize DataTable if needed
                if ($.fn.DataTable.isDataTable(table)) {
                    table.DataTable().draw();
                }
            }

            function getStatusKey(displayText) {
                const statusMap = {
                    'Pending': 'pending',
                    'Admin Approved': 'admin_approved',
                    'Engineer Assigned': 'assigned_engineer',
                    'Engineer Approved': 'engineer_approved',
                    'Engineer Not Approved': 'engineer_not_approved',
                    'In Transfer': 'in_transfer',
                    'Transferred': 'transferred',
                    'In Progress': 'in_progress',
                    'Picking': 'picking',
                    'Picked': 'picked',
                    'Completed': 'completed'
                };

                return statusMap[displayText] || '';
            }

            function getTableId(serviceType) {
                switch(serviceType) {
                    case 'amc': return 'amc_services';
                    case 'installation': return 'installation_service';
                    case 'repairing': return 'repairing_services';
                    case 'quick': return 'quick_services';
                    default: return 'amc_services';
                }
            }
        });
    </script>
@endsection
