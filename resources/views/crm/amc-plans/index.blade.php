@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">AMC Plans List</h4>
                </div>
                <div>
                    <a href="{{ route('amc-plan.create') }}" class="btn btn-primary">Add Plan</a>
                    <!-- <button class="btn btn-primary">Add New Staff</button> -->
                </div>
            </div>


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
                                                    class="form-control search" placeholder="Search Plan Name">
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
                                                <li><a class="dropdown-item" href="#">Sort By Name</a></li>
                                                <li><a class="dropdown-item" href="#">Sort By Price</a></li>
                                                <!-- <li><a class="dropdown-item" href="#">Sort By Ratings</a></li>  -->
                                            </ul>
                                        </div>

                                        <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-group" role="group">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#standard-modal">
                                                <!-- <span class="d-none d-md-inline-flex"> Filters </span> -->
                                                <i class="fa-solid fa-filter "></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="standard-modal" tabindex="-1"
                                        aria-labelledby="standard-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="standard-modalLabel">Filters</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body px-3 py-md-2">
                                                    <h5>Status</h5>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="mt-3">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="flexRadioDefault" id="flexRadioDefault1">
                                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                                        Active
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mt-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="flexRadioDefault" id="flexRadioDefault2">
                                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                                        Inactive
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                        <div class="card-body pt-0">
                            <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active p-2" id="all_active_tab" data-bs-toggle="tab"
                                        href="#all_active" role="tab">
                                        <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                        <span class="d-none d-sm-block">All Plans</span>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                                    <a class="nav-link p-2" id="trashed_tab" data-bs-toggle="tab" href="#trashed"
                                                        role="tab">
                                                        <span class="d-block d-sm-none"><i
                                                                class="mdi mdi-sitemap-outline"></i></span>
                                                        <span class="d-none d-sm-block">Trashed Plans</span>
                                                    </a>
                                                </li> -->
                            </ul>

                            <div class="tab-content text-muted">

                                <div class="tab-pane active show pt-4" id="all_active" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr. No.</th>
                                                                <th>Plan Name</th>
                                                                <th>Plan Code</th>
                                                                <th>Duration</th>
                                                                <th>Plan Services</th>
                                                                <th>Plan Price</th>
                                                                <th>Status</th>
                                                                <th>Created By</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($amcPlans as $amc)
                                                                <tr>
                                                                    <td>{{ $amc->id }} </td>
                                                                    <td>{{ $amc->plan_name }}</td>
                                                                    <td>{{ $amc->plan_code }}</td>
                                                                    <td>{{ $amc->duration }} months</td>
                                                                    <td>
                                                                        <ul>
                                                                            @php
                                                                                $items = json_decode(
                                                                                    $amc->covered_items,
                                                                                    true,
                                                                                );
                                                                                if (!is_array($items)) {
                                                                                    $items = json_decode(
                                                                                        $items,
                                                                                        true,
                                                                                    );
                                                                                }

                                                                            @endphp

                                                                            @if (is_array($items))
                                                                                @foreach ($items as $item)
                                                                                    @php
                                                                                        $item = DB::table('covered_items')->find($item);
                                                                                    @endphp 
                                                                                    <li>{{ ucwords($item->service_name) }}
                                                                                    </li>
                                                                                @endforeach
                                                                            @else
                                                                                <li>No services listed</li>
                                                                            @endif
                                                                        </ul>
                                                                    </td>
                                                                    <td>₹{{ $amc->total_cost }}/year</td>
                                                                    <td>
                                                                        @php
                                                                            $status = $amc->status == 1 ? 'Active' : 'Inactive';
                                                                        @endphp
                                                                        <span
                                                                            class="badge {{ $amc->status == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fw-semibold">
                                                                            {{ $status }}
                                                                        </span>
                                                                    </td>
                                                                    <td>Super Admin</td>
                                                                    <td>
                                                                        <div class="d-flex gap-2">
                                                                            <!-- <a aria-label="anchor"
                                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                                            data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                                            <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                                        </a> -->
                                                                            <a aria-label="anchor"
                                                                                href="{{ route('amc-plan.edit', $amc->id) }}"
                                                                                class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Edit">
                                                                                <i
                                                                                    class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                            </a>
                                                                            <form style="display: inline-block"
                                                                                action="{{ route('amc-plan.delete', $amc->id) }}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Are you sure?')">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-original-title="Delete"><i
                                                                                        class="mdi mdi-delete fs-14 text-danger"></i>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane pt-4" id="trashed" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr. No.</th>
                                                                <th>Plan Name</th>
                                                                <th>Plan Services</th>
                                                                <th>Plan Price</th>
                                                                <th>Status</th>
                                                                <th>Created By</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Basic</td>
                                                                <td>
                                                                    <ul>
                                                                        <li>Preventive Maintenance (Quarterly)</li>
                                                                        <li>Remote Support (Mon–Fri, 10am–6pm)</li>
                                                                        <li>Hardware Inspection</li>
                                                                        <li>Router/Switch Health Check</li>
                                                                    </ul>
                                                                </td>
                                                                <td>₹4,999/year</td>
                                                                <td>
                                                                    <div class="form-check form-switch mb-2">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            role="switch" id="flexSwitchCheckChecked"
                                                                            checked>
                                                                        <label class="form-check-label"
                                                                            for="flexSwitchCheckChecked"></label>
                                                                    </div>
                                                                </td>
                                                                <td>Super Admin</td>
                                                                <td>
                                                                    <div class="d-flex gap-2">
                                                                        <!-- <a aria-label="anchor"
                                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                                            data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                                            <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                                        </a> -->
                                                                        <a aria-label="anchor"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Delete">
                                                                            <i
                                                                                class="mdi mdi-delete fs-14 text-danger"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>Standard</td>
                                                                <td>
                                                                    <ul>
                                                                        <li>Preventive Maintenance (Bi-monthly)</li>
                                                                        <li>On-Site Support (4 visits/year)</li>
                                                                        <li>Network Performance Monitoring</li>
                                                                        <li>Software & Driver Updates</li>
                                                                    </ul>
                                                                </td>
                                                                <td>₹9,999/year</td>
                                                                <td>
                                                                    <div class="form-check form-switch mb-2">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            role="switch" id="flexSwitchCheckChecked">
                                                                        <label class="form-check-label"
                                                                            for="flexSwitchCheckChecked"></label>
                                                                    </div>
                                                                </td>
                                                                <td>Super Admin</td>
                                                                <td>
                                                                    <div class="d-flex gap-2">
                                                                        <!-- <a aria-label="anchor"
                                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                                            data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                                            <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                                        </a> -->
                                                                        <a aria-label="anchor"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Delete">
                                                                            <i
                                                                                class="mdi mdi-delete fs-14 text-danger"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>Premium</td>
                                                                <td>
                                                                    <ul>
                                                                        <li>Preventive Maintenance (Monthly)</li>
                                                                        <li>Unlimited Remote Support</li>
                                                                        <li>8 On-Site Visits/year</li>
                                                                        <li>Priority Response Time</li>
                                                                        <li>Firewall/Network Security Check</li>
                                                                    </ul>
                                                                </td>
                                                                <td>₹14,999/year</td>
                                                                <td>
                                                                    <div class="form-check form-switch mb-2">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            role="switch" id="flexSwitchCheckChecked">
                                                                        <label class="form-check-label"
                                                                            for="flexSwitchCheckChecked"></label>
                                                                    </div>
                                                                </td>
                                                                <td>Super Admin</td>
                                                                <td>
                                                                    <div class="d-flex gap-2">
                                                                        <!-- <a aria-label="anchor"
                                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                                            data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                                            <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                                        </a> -->
                                                                        <a aria-label="anchor"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Delete">
                                                                            <i
                                                                                class="mdi mdi-delete fs-14 text-danger"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>4</td>
                                                                <td>Custom Plan</td>
                                                                <td>
                                                                    <ul>
                                                                        <li>Tailored solutions</li>
                                                                        <li>24/7 Support Options</li>
                                                                        <li>Inventory Management</li>
                                                                        <li>Dedicated Engineer</li>
                                                                    </ul>
                                                                </td>
                                                                <td>Contact Us</td>
                                                                <td>
                                                                    <div class="form-check form-switch mb-2">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            role="switch" id="flexSwitchCheckChecked">
                                                                        <label class="form-check-label"
                                                                            for="flexSwitchCheckChecked"></label>
                                                                    </div>
                                                                </td>
                                                                <td>Super Admin</td>
                                                                <td>
                                                                    <div class="d-flex gap-2">
                                                                        <!-- <a aria-label="anchor"
                                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                                            data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                                            <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                                        </a> -->
                                                                        <a aria-label="anchor"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Delete">
                                                                            <i
                                                                                class="mdi mdi-delete fs-14 text-danger"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
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
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection
