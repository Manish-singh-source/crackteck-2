@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Service Request</h4>
                </div>

            </div>

            <!-- Start Main Widgets -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">

                        <div class="card-body">
                            <div class="widget-first">

                                <div class="d-flex align-items-center mb-2">
                                    <div
                                        class="p-2 border border-primary border-opacity-10 bg-primary-subtle rounded-2 me-2">
                                        <div class="bg-primary rounded-circle widget-size text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24">
                                                <path fill="#ffffff"
                                                    d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-dark fs-15">Total Servies</p>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0 fs-22 text-dark me-3">3,456</h3>
                                    <div class="text-center">
                                        <span class="text-primary fs-14"><i class="mdi mdi-trending-up fs-14"></i>
                                            12.5%</span>
                                        <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">

                        <div class="card-body">
                            <div class="widget-first">

                                <div class="d-flex align-items-center mb-2">
                                    <div
                                        class="p-2 border border-secondary border-opacity-10 bg-secondary-subtle rounded-2 me-2">
                                        <div class="bg-secondary rounded-circle widget-size text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24">
                                                <path fill="#ffffff"
                                                    d="m10 17l-5-5l1.41-1.42L10 14.17l7.59-7.59L19 8m-7-6A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-dark fs-15">AMC Services</p>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0 fs-22 text-dark me-3">2,839</h3>
                                    <div class="text-center">
                                        <span class="text-danger fs-14 me-2"><i class="mdi mdi-trending-down fs-14"></i>
                                            1.5%</span>
                                        <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="widget-first">

                                <div class="d-flex align-items-center mb-2">
                                    <div class="p-2 border border-danger border-opacity-10 bg-danger-subtle rounded-2 me-2">
                                        <div class="bg-danger rounded-circle widget-size text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24">
                                                <path fill="#ffffff"
                                                    d="M22 19H2v2h20zM4 15c0 .5.2 1 .6 1.4s.9.6 1.4.6V6c-.5 0-1 .2-1.4.6S4 7.5 4 8zm9.5-9h-3c0-.4.1-.8.4-1.1s.6-.4 1.1-.4c.4 0 .8.1 1.1.4c.2.3.4.7.4 1.1M7 6v11h10V6h-2q0-1.2-.9-2.1C13.2 3 12.8 3 12 3q-1.2 0-2.1.9T9 6zm11 11c.5 0 1-.2 1.4-.6s.6-.9.6-1.4V8c0-.5-.2-1-.6-1.4S18.5 6 18 6z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-dark fs-15">Non AMC Servies</p>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0 fs-22 text-dark me-3">2,254</h3>
                                    <div class="text-center">
                                        <span class="text-primary fs-14 me-2"><i class="mdi mdi-trending-up fs-14"></i>
                                            12.8%</span>
                                        <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="widget-first">

                                <div class="d-flex align-items-center mb-2">
                                    <div
                                        class="p-2 border border-warning border-opacity-10 bg-warning-subtle rounded-2 me-2">
                                        <div class="bg-warning rounded-circle widget-size text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24">
                                                <path fill="#ffffff"
                                                    d="M7 15h2c0 1.08 1.37 2 3 2s3-.92 3-2c0-1.1-1.04-1.5-3.24-2.03C9.64 12.44 7 11.78 7 9c0-1.79 1.47-3.31 3.5-3.82V3h3v2.18C15.53 5.69 17 7.21 17 9h-2c0-1.08-1.37-2-3-2s-3 .92-3 2c0 1.1 1.04 1.5 3.24 2.03C14.36 11.56 17 12.22 17 15c0 1.79-1.47 3.31-3.5 3.82V21h-3v-2.18C8.47 18.31 7 16.79 7 15" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-dark fs-15">Pending AMC</p>
                                </div>


                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0 fs-22 text-dark me-3">4,578</h3>

                                    <div class="text-muted">
                                        <span class="text-danger fs-14 me-2"><i class="mdi mdi-trending-down fs-14"></i>
                                            18%</span>
                                        <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="widget-first">

                                <div class="d-flex align-items-center mb-2">
                                    <div
                                        class="p-2 border border-success border-opacity-10 bg-success-subtle rounded-2 me-2">
                                        <div class="bg-success rounded-circle widget-size text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24">
                                                <g fill="none" stroke="#ffffff" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2">
                                                    <path d="M5 19L19 5" />
                                                    <circle cx="7" cy="7" r="3" />
                                                    <circle cx="17" cy="17" r="3" />
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-dark fs-15">Complete</p>
                                </div>


                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0 fs-22 text-dark me-3">14</h3>

                                    <div class="text-muted">
                                        <span class="text-danger fs-14 me-2"><i class="mdi mdi-trending-down fs-14"></i>
                                            8%</span>
                                        <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="widget-first">

                                <div class="d-flex align-items-center mb-2">
                                    <div
                                        class="p-2 border border-success border-opacity-10 bg-success-subtle rounded-2 me-2">
                                        <div class="bg-success rounded-circle widget-size text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24">
                                                <g fill="none" stroke="#ffffff" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2">
                                                    <path d="M5 19L19 5" />
                                                    <circle cx="7" cy="7" r="3" />
                                                    <circle cx="17" cy="17" r="3" />
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-dark fs-15">In Progress</p>
                                </div>


                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0 fs-22 text-dark me-3">14</h3>

                                    <div class="text-muted">
                                        <span class="text-danger fs-14 me-2"><i class="mdi mdi-trending-down fs-14"></i>
                                            8%</span>
                                        <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Main Widgets -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body border border-dashed border-end-0 border-start-0">
                            <form action="#" method="get">
                                <div class="d-flex justify-content-between">
                                    <div class="row">
                                        <div class="col-xl-10 col-md-10 col-sm-10">
                                            <div class="search-box">
                                                <input type="text" name="search" value=""
                                                    class="form-control search" placeholder="Search Service Id">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-2 col-sm-2 col-2">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <button type="submit" class="btn btn-primary waves ripple-light">
                                                    <!-- <span class="d-none d-md-inline-flex"> Search </span> -->
                                                    <i class="fa-solid fa-magnifying-glass "></i>

                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <!-- <span class="d-none d-md-inline-flex"> Sort </span> -->
                                                <i class="fa-solid fa-arrow-up-z-a "></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Sort By Service Id</a></li>
                                                <li><a class="dropdown-item" href="#">Sort By Duration</a></li>
                                                <li><a class="dropdown-item" href="#">Sort By Start Date</a></li>
                                                <!-- <li><a class="dropdown-item" href="#">Sort By Ratings</a></li>  -->
                                            </ul>
                                        </div>

                                    </div>

                                </div>

                            </form>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active p-2" onclick="hideSection()" id="all_services_tab"
                                            data-bs-toggle="tab" href="#all_services" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                            <span class="d-none d-sm-block">AMC Services</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link p-2" onclick="showSection()" id="pending_services_tab"
                                            data-bs-toggle="tab" href="#pending_services" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-sitemap-outline"></i></span>
                                            <span class="d-none d-sm-block">NON AMC Services</span>
                                        </a>
                                    </li>
                                    {{-- Quick Services --}}
                                    <li class="nav-item">
                                        <a class="nav-link p-2" onclick="quickService()" id="quick_services_tab"
                                            data-bs-toggle="tab" href="#quick_services" role="tab">
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

                                <div class="tab-pane show pt-4" id="pending_services" role="tabpanel">
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
                                                            {{-- @forelse($nonAmcServices as $service)
                                                                <tr>
                                                                    <td>
                                                                        <a
                                                                            href="{{ route('service-request.view-non-amc', $service->id) }}">
                                                                            #SRV-{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="fw-semibold">{{ $service->full_name }}
                                                                        </div>
                                                                        <div class="text-muted small">{{ $service->email }}
                                                                        </div>
                                                                        <div class="text-muted small">{{ $service->phone }}
                                                                        </div>
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        @if ($service->source_type == 'ecommerce_non_amc_page')
                                                                            <span class="badge bg-primary">E-commerce NON
                                                                                AMC</span>
                                                                        @elseif($service->source_type == 'customer_installation_page')
                                                                            <span class="badge bg-success">Customer
                                                                                Installation</span>
                                                                        @elseif($service->source_type == 'customer_repairing_page')
                                                                            <span class="badge bg-warning">Customer
                                                                                Repairing</span>
                                                                        @elseif($service->source_type == 'admin_panel')
                                                                            <span class="badge bg-secondary">Admin Panel</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge bg-info-subtle text-info">{{ $service->service_type }}</span>
                                                                    </td>
                                                                    <td>
                                                                        @if ($service->priority_level == 'High')
                                                                            <span
                                                                                class="badge bg-danger-subtle text-danger">High</span>
                                                                        @elseif($service->priority_level == 'Medium')
                                                                            <span
                                                                                class="badge bg-warning-subtle text-warning">Medium</span>
                                                                        @else
                                                                            <span
                                                                                class="badge bg-success-subtle text-success">Low</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $service->products->count() }} Product(s)</td>
                                                                    <td>₹{{ number_format($service->total_amount, 2) }}
                                                                    </td>
                                                                    <td>
                                                                        @if ($service->status == 'Completed')
                                                                            <span
                                                                                class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                                        @elseif($service->status == 'In Progress')
                                                                            <span
                                                                                class="badge bg-primary-subtle text-primary fw-semibold">In
                                                                                Progress</span>
                                                                        @elseif($service->status == 'Pending')
                                                                            <span
                                                                                class="badge bg-warning-subtle text-warning fw-semibold">Pending</span>
                                                                        @else
                                                                            <span
                                                                                class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $service->status }}</span>
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
                                                                        <div>{{ $service->creator->name ?? 'System' }}
                                                                        </div>
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
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('service-request.edit-non-amc', $service->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
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
                                                                                <i
                                                                                    class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="11" class="text-center py-4">
                                                                        <div class="text-muted">
                                                                            <i
                                                                                class="mdi mdi-information-outline fs-1"></i>
                                                                            <p class="mt-2">No Non-AMC service requests
                                                                                found. <a
                                                                                    href="{{ route('service-request.create-non-amc') }}">Create
                                                                                    one now</a></p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse --}}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane active show pt-4" id="all_services" role="tabpanel">
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
                                                            {{-- @forelse($amcServices as $service)
                                                                <tr>
                                                                    <td>
                                                                        <a
                                                                            href="{{ route('service-request.view-amc', $service->id) }}">
                                                                            #AMC-{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="fw-semibold">{{ $service->full_name }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $service->email }}</div>
                                                                        <div class="text-muted small">
                                                                            {{ $service->phone }}</div>
                                                                    </td>
                                                                    <td>
                                                                        @if ($service->source_type == 'ecommerce_amc_page')
                                                                            <span class="badge bg-primary">E-commerce AMC
                                                                                Page</span>
                                                                        @elseif($service->source_type == 'Customer App Amc')
                                                                            <span class="badge bg-success">Customer App
                                                                                AMC</span>
                                                                        @elseif($service->source_type == 'admin_panel')
                                                                                <span class="badge bg-secondary">Admin Panel</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>{{ $service->amcPlan->plan_name ?? 'N/A' }}</td>
                                                                    <td>{{ $service->plan_duration ?? 'N/A' }}</td>
                                                                    <td>
                                                                        @php
                                                                            $startDate = \Carbon\Carbon::parse(
                                                                                $service->plan_start_date,
                                                                            );
                                                                        @endphp
                                                                        {{ $startDate->format('d M Y') }}
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $endDate = null;
                                                                            if (
                                                                                $service->plan_start_date &&
                                                                                $service->plan_duration
                                                                            ) {
                                                                                $startDate = \Carbon\Carbon::parse(
                                                                                    $service->plan_start_date,
                                                                                );
                                                                                $duration = $service->plan_duration;

                                                                                // Extract number from duration string
                                                                                preg_match(
                                                                                    '/\d+/',
                                                                                    $duration,
                                                                                    $matches,
                                                                                );
                                                                                $number = isset($matches[0])
                                                                                    ? (int) $matches[0]
                                                                                    : 0;

                                                                                if (
                                                                                    stripos($duration, 'month') !==
                                                                                    false
                                                                                ) {
                                                                                    $endDate = $startDate
                                                                                        ->copy()
                                                                                        ->addMonths($number);
                                                                                } elseif (
                                                                                    stripos($duration, 'year') !== false
                                                                                ) {
                                                                                    $endDate = $startDate
                                                                                        ->copy()
                                                                                        ->addYears($number);
                                                                                } elseif (
                                                                                    stripos($duration, 'day') !== false
                                                                                ) {
                                                                                    $endDate = $startDate
                                                                                        ->copy()
                                                                                        ->addDays($number);
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        {{ $endDate ? $endDate->format('d M Y') : 'N/A' }}
                                                                    </td>
                                                                    <td>₹{{ number_format($service->total_amount, 2) }}
                                                                    </td>
                                                                    <td>
                                                                        @if ($service->status == 'Active')
                                                                            <span
                                                                                class="badge bg-success-subtle text-success fw-semibold">Active</span>
                                                                        @elseif($service->status == 'Pending')
                                                                            <span
                                                                                class="badge bg-warning-subtle text-warning fw-semibold">Pending</span>
                                                                        @elseif($service->status == 'Expired')
                                                                            <span
                                                                                class="badge bg-danger-subtle text-danger fw-semibold">Expired</span>
                                                                        @else
                                                                            <span
                                                                                class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $service->status }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <div>{{ $service->creator->name ?? 'System' }}
                                                                        </div>
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
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('service-request.edit-amc', $service->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
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
                                                                                <i
                                                                                    class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="10" class="text-center py-4">
                                                                        <div class="text-muted">
                                                                            <i
                                                                                class="mdi mdi-information-outline fs-1"></i>
                                                                            <p class="mt-2">No AMC requests found. <a
                                                                                    href="{{ route('service-request.create-amc') }}">Create
                                                                                    one now</a></p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse --}}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane show pt-4" id="quick_services" role="tabpanel">
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
                                                            @forelse($serviceRequests as $request)
                                                                <tr>
                                                                    <td>
                                                                        {{ $request->request_id }}
                                                                    </td>
                                                                    <td>
                                                                        <div class="fw-semibold">{{ $request->customer->first_name ?? '' }} {{ $request->customer->last_name ?? '' }}</div>
                                                                        <div class="text-muted small">{{ $request->customer->phone ?? 'N/A' }}</div>
                                                                    </td>
                                                                    <td>{{ $request->request_date}}</td>
                                                                    <td>
                                                                        {{-- i want all total count of products --}}
                                                                        <div class="fw-semibold">{{ $request->products->count() }} Product(s)</div>
                                                                    </td>
                                                                    <td>
                                                                        @if ($request->status == 0)
                                                                            <span class="badge bg-success-subtle text-success fw-semibold">Pending</span>
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
                                                                        <div class="text-muted small">{{ $request->created_at->diffForHumans() }}</div>
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
                                                                            href="{{ route('service-request.edit-quick-service-request', $request->id) }}"
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
                                                                    <td colspan="8" class="text-center text-muted py-4">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-information-outline fs-1"></i>
                                                                            <p class="mt-2">No Quick Service requests found. <a
                                                                                    href="{{ route('quick-service-requests.create') }}">Create
                                                                                    one now</a></p>
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
                            </div>
                        </div>
                    </div>
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
                document.getElementById("mySection").style.display = "none";
                document.getElementById("mySection2").style.display = "none";
                
            </script>
        @endsection
