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


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pt-0">

                        <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active p-2" id="all_services_tab" data-bs-toggle="tab"
                                    href="#all_services" role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-information"></i></span>
                                    <span class="d-none d-sm-block">All Services</span>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link p-2" id="pending_services_tab" data-bs-toggle="tab" href="#pending_services"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Pending Services</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="approved_services_tab" data-bs-toggle="tab" href="#approved_services"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Approved Services</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="rejected_services_tab" data-bs-toggle="tab" href="#rejected_services"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Rejected Services</span>
                                </a>
                            </li> -->
                        </ul>

                        <div class="tab-content text-muted">
                            <div class="tab-pane active show pt-4" id="all_services" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>Service Id</th>
                                                            <th>User</th>
                                                            <th>AMC Plan</th>
                                                            <th>Duration (Months)</th>
                                                            <th>Start Date</th>
                                                            <th>Product Info</th>
                                                            <!-- <th>Created By</th> -->
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div>2 weeks ago</div>
                                                                <div>2025-04-04 06:09 PM</div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('delivery.detail') }}">
                                                                    #1001
                                                                </a>
                                                            </td>
                                                            <td>John Doe</td>
                                                            <td>Standard</td>
                                                            <td>6</td>
                                                            <td>2025-04-04 06:09 PM</td>
                                                            <td>
                                                                <div>type:</div>
                                                                <div>brand:</div>
                                                                <div>model:</div>
                                                                <div>serial number:</div>
                                                                <div>purchase date:</div>
                                                            </td>
                                                            <!-- <td>Operation Manager - username</td> -->
                                                            <td>
                                                                <span class="badge bg-success-subtle text-success fw-semibold">Approved</span>
                                                            </td>
                                                            <td>
                                                                <a aria-label="anchor" href="{{ route('delivery.detail') }}"
                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                    <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                </a>
                                                                <a aria-label="anchor"
                                                                    class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                    <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                </a>
                                                                <a aria-label="anchor"
                                                                    class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                    <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div>1 weeks ago</div>
                                                                <div>2025-04-04 06:09 PM</div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('delivery.detail') }}">
                                                                    #1002
                                                                </a>
                                                            </td>
                                                            <td>John Doe</td>
                                                            <td>Standard</td>
                                                            <td>12</td>
                                                            <td>2025-04-04 06:09 PM</td>
                                                            <td>
                                                                <div>type:</div>
                                                                <div>brand:</div>
                                                                <div>model:</div>
                                                                <div>serial number:</div>
                                                                <div>purchase date:</div>
                                                            </td>
                                                            <!-- <td>
                                                                Super Admin - username
                                                            </td> -->
                                                            <td>
                                                                <span class="badge bg-danger-subtle text-danger fw-semibold">Pending</span>
                                                            </td>
                                                            <td>
                                                                <a aria-label="anchor" href="{{ route('delivery.detail') }}"
                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                    <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                </a>
                                                                <a aria-label="anchor"
                                                                    class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                    <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                </a>
                                                                <a aria-label="anchor"
                                                                    class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                    <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div>3 days ago</div>
                                                                <div>2025-04-04 06:09 PM</div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('delivery.detail') }}">
                                                                    #1003
                                                                </a>
                                                            </td>
                                                            <td>John Doe</td>
                                                            <td>Standard</td>
                                                            <td>12</td>
                                                            <td>2025-04-04 06:09 PM</td>
                                                            <td>
                                                                <div>type:</div>
                                                                <div>brand:</div>
                                                                <div>model:</div>
                                                                <div>serial number:</div>
                                                                <div>purchase date:</div>
                                                            </td>
                                                            <!-- <td>
                                                                Customer - John Doe
                                                            </td> -->
                                                            <td>
                                                                <span class="badge bg-warning-subtle text-warning fw-semibold">Rejected</span>
                                                            </td>
                                                            <td>
                                                                <a aria-label="anchor" href="{{ route('delivery.detail') }}"
                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                    <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                </a>
                                                                <a aria-label="anchor"
                                                                    class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                    <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                </a>
                                                                <a aria-label="anchor"
                                                                    class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                    <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div>3 days ago</div>
                                                                <div>2025-04-04 06:09 PM</div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('delivery.detail') }}">
                                                                    #1004
                                                                </a>
                                                            </td>
                                                            <td>John Doe</td>
                                                            <td>Standard</td>
                                                            <td>12</td>
                                                            <td>2025-04-04 06:09 PM</td>
                                                            <td>
                                                                <div>type:</div>
                                                                <div>brand:</div>
                                                                <div>model:</div>
                                                                <div>serial number:</div>
                                                                <div>purchase date:</div>
                                                            </td>
                                                            <!-- <td>
                                                                Customer - John Doe
                                                            </td> -->
                                                            <td>
                                                                <span class="badge bg-primary-subtle text-primary fw-semibold">In Progress</span>
                                                            </td>
                                                            <td>
                                                                <a aria-label="anchor" href="{{ route('delivery.detail') }}"
                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                    <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                </a>
                                                                <a aria-label="anchor"
                                                                    class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                    <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                </a>
                                                                <a aria-label="anchor"
                                                                    class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                    <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane show pt-4" id="pending_services" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>Seller/Deliveryman/User</th>
                                                            <th>Method</th>
                                                            <th>Amount</th>
                                                            <th>Charge</th>
                                                            <th>Receivable</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                        <tr>
                                                            <td class="border-bottom-0" colspan="100">
                                                                <div class="tab-pane" id="productnav-draft" role="tabpanel">
                                                                    <div class="py-4 text-center">
                                                                        <lord-icon src="" trigger="loop" colors="primary:#405189,secondary:#0ab39c" class="loader-icon">
                                                                        </lord-icon>
                                                                        <h5 class="mt-4">
                                                                            Sorry! No Result Found
                                                                        </h5>
                                                                    </div>
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
                            <div class="tab-pane show pt-4" id="approved_services" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>Seller/Deliveryman/User</th>
                                                            <th>Method</th>
                                                            <th>Amount</th>
                                                            <th>Charge</th>
                                                            <th>Receivable</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                        <tr>
                                                            <td class="border-bottom-0" colspan="100">
                                                                <div class="tab-pane" id="productnav-draft" role="tabpanel">
                                                                    <div class="py-4 text-center">
                                                                        <lord-icon src="" trigger="loop" colors="primary:#405189,secondary:#0ab39c" class="loader-icon">
                                                                        </lord-icon>
                                                                        <h5 class="mt-4">
                                                                            Sorry! No Result Found
                                                                        </h5>
                                                                    </div>
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
                            <div class="tab-pane show pt-4" id="rejected_services" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>Seller/Deliveryman/User</th>
                                                            <th>Method</th>
                                                            <th>Amount</th>
                                                            <th>Charge</th>
                                                            <th>Receivable</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                        <tr>
                                                            <td class="border-bottom-0" colspan="100">
                                                                <div class="tab-pane" id="productnav-draft" role="tabpanel">
                                                                    <div class="py-4 text-center">
                                                                        <lord-icon src="" trigger="loop" colors="primary:#405189,secondary:#0ab39c" class="loader-icon">
                                                                        </lord-icon>
                                                                        <h5 class="mt-4">
                                                                            Sorry! No Result Found
                                                                        </h5>
                                                                    </div>
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
        </div> <!-- container-fluid -->
    </div> <!-- content -->

@endsection