@extends('crm/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0"> Stock Reports</h4>
            </div>
            <div>
                <a href="{{ route('stock-report.create') }}" class="btn btn-primary">Add Reports</a>
                <!-- <button class="btn btn-primary">Add New Customer</button> -->
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
                                            <input type="text" name="search" value="" class="form-control search" placeholder="Search Customer">
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
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <!-- <span class="d-none d-md-inline-flex"> Sort </span> -->
                                            <i class="fa-solid fa-arrow-up-z-a "></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Sort By Name</a></li>
                                            <li><a class="dropdown-item" href="#">Sort By E-mail</a></li>
                                        </ul>
                                    </div>

                                    <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-group" role="group">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                                            <!-- <span class="d-none d-md-inline-flex"> Filters </span> -->
                                            <i class="fa-solid fa-filter "></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="standard-modal" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="standard-modalLabel">Filters</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body px-3 py-md-2">
                                                <h5>Status</h5>
                                                <div class="row">
                                                    <div class="col-6">

                                                        <div class="mt-3">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    Active
                                                                </label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                                                <label class="form-check-label" for="flexRadioDefault2">
                                                                    Inactive
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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
                                <a class="nav-link active p-2" id="all_customer_tab" data-bs-toggle="tab"
                                    href="#all_customer" role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-information"></i></span>
                                    <span class="d-none d-sm-block">All Stock</span>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link p-2" id="active_customer_tab" data-bs-toggle="tab" href="#active_customer"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Active Customer</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="banned_customers_tab" data-bs-toggle="tab"
                                    href="#banned_customers" role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Banned Customer</span>
                                </a>
                            </li> -->
                        </ul>

                        <div class="tab-content text-muted">

                            <div class="tab-pane active show pt-4" id="all_customer" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Requested By</th>
                                                            <th>Date of Request</th>
                                                            <th>Item Name</th>
                                                            <th>Quantity</th>
                                                            <th>Reason / Justification</th>
                                                            <th>Urgency Level</th>
                                                            <th>Approval Status</th>
                                                            <th>Final Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Ravi Sharma (Engineering)</td>
                                                            <td>2025-06-06</td>
                                                            <td>Router Adapter</td>
                                                            <td>5</td>
                                                            <td>Required for client setup</td>
                                                            <td><span class="badge bg-danger">High</span></td>
                                                            <td><span class="badge bg-success">Approved</span></td>
                                                            <td><span class="badge bg-info">Issued from Stock</span></td>
                                                            <td>
                                                                <a href="#" class="btn btn-sm btn-primary"><i class="mdi mdi-eye-outline"></i></a>
                                                                <a href="{{ route('stock-request.edit') }}" class="btn btn-sm btn-warning"><i class="mdi mdi-pencil-outline"></i></a>
                                                                <a href="#" class="btn btn-sm btn-danger delete-row"><i class="mdi mdi-delete"></i></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Anita Desai (Sales)</td>
                                                            <td>2025-06-05</td>
                                                            <td>HDMI Cable</td>
                                                            <td>10</td>
                                                            <td>Client demo kit preparation</td>
                                                            <td><span class="badge bg-warning text-dark">Medium</span></td>
                                                            <td><span class="badge bg-secondary">Pending</span></td>
                                                            <td><span class="badge bg-light text-dark">--</span></td>
                                                            <td>
                                                                <a href="#" class="btn btn-sm btn-primary"><i class="mdi mdi-eye-outline"></i></a>
                                                                <a href="{{ route('stock-request.edit') }}" class="btn btn-sm btn-warning"><i class="mdi mdi-pencil-outline"></i></a>
                                                                <a href="#" class="btn btn-sm btn-danger delete-row"><i class="mdi mdi-delete"></i></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Manoj Gupta (Admin)</td>
                                                            <td>2025-06-04</td>
                                                            <td>Printer Toner</td>
                                                            <td>2</td>
                                                            <td>Office printer refill</td>
                                                            <td><span class="badge bg-success">Low</span></td>
                                                            <td><span class="badge bg-danger">Rejected</span></td>
                                                            <td><span class="badge bg-light text-dark">--</span></td>
                                                            <td>
                                                                <a href="#" class="btn btn-sm btn-primary"><i class="mdi mdi-eye-outline"></i></a>
                                                                <a href="{{ route('stock-request.edit') }}" class="btn btn-sm btn-warning"><i class="mdi mdi-pencil-outline"></i></a>
                                                                <a href="#" class="btn btn-sm btn-danger delete-row"><i class="mdi mdi-delete"></i></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- end Experience -->



                        </div> <!-- Tab panes -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

@endsection