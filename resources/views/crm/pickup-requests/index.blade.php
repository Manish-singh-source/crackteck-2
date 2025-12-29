@extends('crm/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Pickup Requests</h4>
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
                                            <input type="text" name="search" value="" class="form-control search" placeholder="Search By Name, ">
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
                                            <li><a class="dropdown-item" href="#">Module Number</a></li>
                                            <li><a class="dropdown-item" href="#">Serial Number</a></li>
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
                                                    <div class="col">
                                                        <div class="mt-3">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    Approved
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mt-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                                                <label class="form-check-label" for="flexRadioDefault2">
                                                                    Pending
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mt-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                                                                <label class="form-check-label" for="flexRadioDefault3">
                                                                    Rejected
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

                    <!-- <div class="col-xl-2 col-sm-3 col-6">
                                    <div>
                                        <select class="form-select" name="type" id="">

                                            <option selected="" value="0">
                                                All
                                            </option>
                                            <option value="1">
                                                Laptops
                                            </option>
                                            <option value="2">
                                                Computers
                                            </option>
                                            <option value="3">
                                                Accessories
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-2 col-sm-3 col-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-100 waves ripple-light">
                                            <span class="d-none d-md-inline-flex"> Search </span>
                                            <i class="fa-solid fa-magnifying-glass "></i>

                                        </button>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-sm-3 col-6">
                                    <div>
                                        <a href="#" class="btn btn-primary w-50 waves ripple-light">
                                            <i class="ri-refresh-line me-1 align-bottom"></i>
                                            Sort
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-2 col-sm-3 col-3 btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="d-none d-md-inline-flex"> Brand </span>
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Dell</a></li>
                                        <li><a class="dropdown-item" href="#">Hp</a></li>
                                    </ul>
                                </div>
                                <div class="col-xl-2 col-md-2 col-sm-3 col-3 btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="d-none d-md-inline-flex"> Status </span>
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Approved</a></li>
                                        <li><a class="dropdown-item" href="#">Pending</a></li>
                                        <li><a class="dropdown-item" href="#">Rejected</a></li>
                                    </ul>
                                </div> -->
                    <div class="card-body pt-0">
                        <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active p-2" id="all_customer_tab" data-bs-toggle="tab"
                                    href="#all_customer" role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-information"></i></span>
                                    <span class="d-none d-sm-block">All</span>
                                </a>
                            </li>

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
                                                            <th>Name</th>
                                                            <th>Type</th>
                                                            <th>Brand</th>
                                                            <th>Module Number</th>
                                                            <th>Serial Number</th>
                                                            <th>Requested By</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    Dell Inspiron 3370
                                                                </div>
                                                            </td>
                                                            <td>Laptop</td>
                                                            <td>Dell</td>
                                                            <td>9879877</td>
                                                            <td>CDB-0987</td>
                                                            <td>Engineer 1</td>
                                                            <td>
                                                                <span class="badge bg-danger-subtle text-danger fw-semibold">Pending</span>
                                                            </td>
                                                            <td>
                                                                <a aria-label="anchor" href="{{ route('pickup-request.view') }}"
                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                    <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    Kingston SSD 256 GB
                                                                </div>
                                                            </td>
                                                            <td>Accessories</td>
                                                            <td>Kingston</td>
                                                            <td>9879877</td>
                                                            <td>KING-1987</td>
                                                            <td>Engineer 2</td>
                                                            <td>
                                                                <span class="badge bg-success-subtle text-success fw-semibold">Approved</span>
                                                            </td>
                                                            <td>
                                                                <a aria-label="anchor" href="{{ route('pickup-request.view') }}"
                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                    <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    Kingston SSD 256 GB
                                                                </div>
                                                            </td>
                                                            <td>Accessories</td>
                                                            <td>Kingston</td>
                                                            <td>9879877</td>
                                                            <td>KING-1987</td>
                                                            <td>Engineer 3</td>
                                                            <td>
                                                                <span class="badge bg-warning-subtle text-warning fw-semibold">Rejected</span>
                                                            </td>
                                                            <td>
                                                                <a aria-label="anchor" href="{{ route('pickup-request.view') }}"
                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                    <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
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
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->

@endsection