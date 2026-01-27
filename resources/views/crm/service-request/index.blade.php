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
                        <div class="card-body pt-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                    {{-- AMC Services --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active p-2"
                                           onclick="hideSection()"
                                           id="amc_service_tab"
                                           data-bs-toggle="tab"
                                           href="#all_services"
                                           role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                            <span class="d-none d-sm-block">AMC Services</span>
                                        </a>
                                    </li>

                                    {{-- Installation Services --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2"
                                           onclick="showSection()"
                                           id="installation_services_tab"
                                           data-bs-toggle="tab"
                                           href="#pending_services"
                                           role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-sitemap-outline"></i></span>
                                            <span class="d-none d-sm-block">Installation Services</span>
                                        </a>
                                    </li>

                                    {{-- Repairing Services --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2"
                                           onclick="showSection()"
                                           id="repairing_services_tab"
                                           data-bs-toggle="tab"
                                           href="#pending_services"
                                           role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-sitemap-outline"></i></span>
                                            <span class="d-none d-sm-block">Repairing Services</span>
                                        </a>
                                    </li>

                                    {{-- Quick Services --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2"
                                           onclick="quickService()"
                                           id="quick_services_tab"
                                           data-bs-toggle="tab"
                                           href="#quick_services"
                                           role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-sitemap-outline"></i></span>
                                            <span class="d-none d-sm-block">Quick Services</span>
                                        </a>
                                    </li>
                                </ul>

                                <div>
                                    <a href="{{ route('service-request.create-amc') }}" id="mySection1"
                                       class="btn btn-primary">Create AMC</a>
                                    <a href="{{ route('service-request.create-non-amc') }}" id="mySection"
                                       class="btn btn-primary">Create Non-AMC Service</a>
                                    <a href="{{ route('quick-service-requests.create') }}" id="mySection2"
                                       class="btn btn-primary">Create Quick Service</a>
                                </div>
                            </div>

                            <div class="tab-content text-muted">

                                {{-- Non‑AMC / Installation / Repairing services --}}
                                <div class="tab-pane" id="pending_services" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="non-amc-datatable"
                                                           class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Service Id</th>
                                                                <th>Customer Name</th>
                                                                <th>Source</th>
                                                                <th>Service Type</th>
                                                                <th>Priority</th>
                                                                <th>Products</th>
                                                                <th>Total Amount</th>
                                                                <th>Status</th>
                                                                <th>Assigned Engineer</th>
                                                                <th>Created By</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($nonAmcServices ?? [] as $service)
                                                                <tr>
                                                                    <td>
                                                                        <a href="{{ route('service-request.view-non-amc', $service->id) }}">
                                                                            #SRV-{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="fw-semibold">{{ $service->full_name }}</div>
                                                                        <div class="text-muted small">{{ $service->email }}</div>
                                                                        <div class="text-muted small">{{ $service->phone }}</div>
                                                                    </td>

                                                                    <td>
                                                                        @if ($service->source_type == 'ecommerce_non_amc_page')
                                                                            <span class="badge bg-primary">E-commerce NON AMC</span>
                                                                        @elseif($service->source_type == 'customer_installation_page')
                                                                            <span class="badge bg-success">Customer Installation</span>
                                                                        @elseif($service->source_type == 'customer_repairing_page')
                                                                            <span class="badge bg-warning">Customer Repairing</span>
                                                                        @elseif($service->source_type == 'admin_panel')
                                                                            <span class="badge bg-secondary">Admin Panel</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        <span class="badge bg-info-subtle text-info">{{ $service->service_type }}</span>
                                                                    </td>

                                                                    <td>
                                                                        @if ($service->priority_level == 'High')
                                                                            <span class="badge bg-danger-subtle text-danger">High</span>
                                                                        @elseif($service->priority_level == 'Medium')
                                                                            <span class="badge bg-warning-subtle text-warning">Medium</span>
                                                                        @else
                                                                            <span class="badge bg-success-subtle text-success">Low</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>{{ $service->products->count() }} Product(s)</td>
                                                                    <td>₹{{ number_format($service->total_amount, 2) }}</td>

                                                                    <td>
                                                                        @if ($service->status == 'Completed')
                                                                            <span class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                                        @elseif($service->status == 'In Progress')
                                                                            <span class="badge bg-primary-subtle text-primary fw-semibold">In Progress</span>
                                                                        @elseif($service->status == 'Pending')
                                                                            <span class="badge bg-warning-subtle text-warning fw-semibold">Pending</span>
                                                                        @else
                                                                            <span class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $service->status }}</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        @if ($service->assignedEngineer)
                                                                            <div class="fw-semibold">
                                                                                {{ $service->assignedEngineer->first_name }}
                                                                                {{ $service->assignedEngineer->last_name }}
                                                                            </div>
                                                                            <div class="text-muted small">
                                                                                {{ $service->assignedEngineer->phone }}
                                                                            </div>
                                                                        @else
                                                                            <span class="text-muted">Not assigned</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        <div>{{ $service->creator->name ?? 'System' }}</div>
                                                                        <div class="text-muted small">
                                                                            {{ $service->created_at->diffForHumans() }}
                                                                        </div>
                                                                    </td>

                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                           href="{{ route('service-request.view-non-amc', $service->id) }}"
                                                                           class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-original-title="View">
                                                                            <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                           href="{{ route('service-request.edit-non-amc', $service->id) }}"
                                                                           class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-original-title="Edit">
                                                                            <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('service-request.delete-non-amc', $service->id) }}"
                                                                            method="POST" class="d-inline"
                                                                            onsubmit="return confirm('Are you sure you want to delete this service request?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" aria-label="anchor"
                                                                                    class="btn btn-icon btn-sm bg-danger-subtle"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-original-title="Delete">
                                                                                <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="11" class="text-center py-4">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-information-outline fs-1"></i>
                                                                            <p class="mt-2">
                                                                                No Non-AMC service requests found.
                                                                                <a href="{{ route('service-request.create-non-amc') }}">Create one now</a>
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

                                {{-- AMC services (default active) --}}
                                <div class="tab-pane active show" id="all_services" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                           class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Service Id</th>
                                                                <th>Customer Name</th>
                                                                <th>Source</th>
                                                                <th>AMC Plan</th>
                                                                <th>Plan Duration</th>
                                                                <th>Start Date</th>
                                                                <th>End Date</th>
                                                                <th>Total Amount</th>
                                                                <th>Status</th>
                                                                <th>Created By</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($amcServices ?? [] as $service)
                                                                <tr>
                                                                    <td>
                                                                        <a href="{{ route('service-request.view-amc', $service->id) }}">
                                                                            #AMC-{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="fw-semibold">{{ $service->full_name }}</div>
                                                                        <div class="text-muted small">{{ $service->email }}</div>
                                                                        <div class="text-muted small">{{ $service->phone }}</div>
                                                                    </td>
                                                                    <td>
                                                                        @if ($service->source_type == 'ecommerce_amc_page')
                                                                            <span class="badge bg-primary">E-commerce AMC Page</span>
                                                                        @elseif($service->source_type == 'Customer App Amc')
                                                                            <span class="badge bg-success">Customer App AMC</span>
                                                                        @elseif($service->source_type == 'admin_panel')
                                                                            <span class="badge bg-secondary">Admin Panel</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $service->amcPlan->plan_name ?? 'N/A' }}</td>
                                                                    <td>{{ $service->plan_duration ?? 'N/A' }}</td>
                                                                    <td>
                                                                        @php
                                                                            $startDate = $service->plan_start_date
                                                                                ? \Carbon\Carbon::parse($service->plan_start_date)
                                                                                : null;
                                                                        @endphp
                                                                        {{ $startDate ? $startDate->format('d M Y') : 'N/A' }}
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $endDate = null;
                                                                            if ($service->plan_start_date && $service->plan_duration) {
                                                                                $startDate = \Carbon\Carbon::parse($service->plan_start_date);
                                                                                $duration = $service->plan_duration;

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
                                                                        {{ $endDate ? $endDate->format('d M Y') : 'N/A' }}
                                                                    </td>
                                                                    <td>₹{{ number_format($service->total_amount, 2) }}</td>
                                                                    <td>
                                                                        @if ($service->status == 'Active')
                                                                            <span class="badge bg-success-subtle text-success fw-semibold">Active</span>
                                                                        @elseif($service->status == 'Pending')
                                                                            <span class="badge bg-warning-subtle text-warning fw-semibold">Pending</span>
                                                                        @elseif($service->status == 'Expired')
                                                                            <span class="badge bg-danger-subtle text-danger fw-semibold">Expired</span>
                                                                        @else
                                                                            <span class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $service->status }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <div>{{ $service->creator->name ?? 'System' }}</div>
                                                                        <div class="text-muted small">
                                                                            {{ $service->created_at->diffForHumans() }}
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                           href="{{ route('service-request.view-amc', $service->id) }}"
                                                                           class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-original-title="View">
                                                                            <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                           href="{{ route('service-request.edit-amc', $service->id) }}"
                                                                           class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-original-title="Edit">
                                                                            <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('service-request.delete-amc', $service->id) }}"
                                                                            method="POST" class="d-inline"
                                                                            onsubmit="return confirm('Are you sure you want to delete this AMC request?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" aria-label="anchor"
                                                                                    class="btn btn-icon btn-sm bg-danger-subtle"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-original-title="Delete">
                                                                                <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="11" class="text-center py-4">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-information-outline fs-1"></i>
                                                                            <p class="mt-2">
                                                                                No AMC requests found.
                                                                                <a href="{{ route('service-request.create-amc') }}">Create one now</a>
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
                                                    <table id="quick-service-datatable"
                                                           class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Request ID</th>
                                                                <th>Customer Name</th>
                                                                <th>Request Date</th>
                                                                <th>Product Name / Model No</th>
                                                                <th>Status</th>
                                                                <th>Request Source</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($serviceRequests ?? [] as $request)
                                                                <tr>
                                                                    <td>{{ $request->request_id }}</td>
                                                                    <td>
                                                                        <div class="fw-semibold">
                                                                            {{ $request->customer->first_name ?? '' }}
                                                                            {{ $request->customer->last_name ?? '' }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $request->customer->phone ?? 'N/A' }}
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $request->request_date }}</td>
                                                                    <td>
                                                                        <div class="fw-semibold">
                                                                            {{ $request->products->count() }} Product(s)
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        @if ($request->status == 0)
                                                                            <span class="badge bg-warning-subtle text-warning fw-semibold">Pending</span>
                                                                        @elseif($request->status == 1)
                                                                            <span class="badge bg-info-subtle text-info fw-semibold">Approved</span>
                                                                        @elseif($request->status == 2)
                                                                            <span class="badge bg-danger-subtle text-danger fw-semibold">Rejected</span>
                                                                        @elseif($request->status == 3)
                                                                            <span class="badge bg-warning-subtle text-warning fw-semibold">Processing</span>
                                                                        @elseif($request->status == 4)
                                                                            <span class="badge bg-primary-subtle text-primary fw-semibold">Processed</span>
                                                                        @elseif($request->status == 5)
                                                                            <span class="badge bg-info-subtle text-info fw-semibold">Picking</span>
                                                                        @elseif($request->status == 6)
                                                                            <span class="badge bg-success-subtle text-success fw-semibold">Picked</span>
                                                                        @elseif($request->status == 7)
                                                                            <span class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($request->request_source == 0)
                                                                            <span class="badge bg-primary-subtle text-primary fw-semibold">Customer</span>
                                                                        @elseif($request->request_source == 1)
                                                                            <span class="badge bg-secondary-subtle text-secondary fw-semibold">System</span>
                                                                        @endif
                                                                        <div class="text-muted small">
                                                                            {{ $request->created_at->diffForHumans() }}
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                           href="{{ route('service-request.view-quick-service-request', $request->id) }}"
                                                                           class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-original-title="View">
                                                                            <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                           href="{{ route('service-request.edit-quick-service-request', $request->id) }}"
                                                                           class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-original-title="Edit">
                                                                            <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
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
                                                                                <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="8" class="text-center text-muted py-4">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-information-outline fs-1"></i>
                                                                            <p class="mt-2">
                                                                                No Quick Service requests found.
                                                                                <a href="{{ route('quick-service-requests.create') }}">Create one now</a>
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
        function hideSection() {
            document.getElementById("mySection1").style.display = "block";
            document.getElementById("mySection").style.display = "none";
            document.getElementById("mySection2").style.display = "none";
        }

        function showSection() {
            document.getElementById("mySection").style.display = "block";
            document.getElementById("mySection1").style.display = "none";
            document.getElementById("mySection2").style.display = "none";
        }

        function quickService() {
            document.getElementById("mySection").style.display = "none";
            document.getElementById("mySection1").style.display = "none";
            document.getElementById("mySection2").style.display = "block";
        }

        // default state (AMC)
        document.getElementById("mySection").style.display = "none";
        document.getElementById("mySection2").style.display = "none";
    </script>
@endsection
