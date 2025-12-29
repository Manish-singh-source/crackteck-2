@extends('crm/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Ticket List</h4>
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
                                            <input type="text" name="search" value="" class="form-control search" placeholder="Search Ticket No">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-sm-2 col-2">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <button type="submit" class="btn btn-primary waves ripple-light">
                                                <i class="fa-solid fa-magnifying-glass "></i>

                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-arrow-up-z-a "></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Sort By Ticket No.</a></li>
                                            <li><a class="dropdown-item" href="#">Sort By Time</a></li>
                                        </ul>
                                    </div>

                                    <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-group" role="group">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
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
                                            <div class="modal-body px-3 py-md-2">
                                                <h5>Priority</h5>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mt-3">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    High
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="mt-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                                <label class="form-check-label" for="flexCheckDefault1">
                                                                    Medium
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mt-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                                <label class="form-check-label" for="flexCheckDefault3">
                                                                    Low
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
                                <a class="nav-link active p-2" id="all_tickets_tab" data-bs-toggle="tab"
                                    href="#all_tickets" role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-information"></i></span>
                                    <span class="d-none d-sm-block">All Tickets</span>
                                </a>
                            </li>
                            <!-- 
                            <li class="nav-item">
                                <a class="nav-link p-2" id="running_tickets_tab" data-bs-toggle="tab" href="#running_tickets"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Running Tickets</span>
                                </a>
                            </li> 
                            <li class="nav-item">
                                <a class="nav-link p-2" id="answered_tickets_tab" data-bs-toggle="tab"
                                    href="#answered_tickets" role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Answered Tickets</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="replied_tickets_tab" data-bs-toggle="tab"
                                    href="#replied_tickets" role="tab">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-school"></i></span>
                                    <span class="d-none d-sm-block">Replied Tickets</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="closed_tickets_tab" data-bs-toggle="tab"
                                    href="#closed_tickets" role="tab">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-school"></i></span>
                                    <span class="d-none d-sm-block">Closed Tickets</span>
                                </a>
                            </li> -->
                        </ul>

                        <div class="tab-content text-muted">

                            <div class="tab-pane active show pt-4" id="all_tickets" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>Subject</th>
                                                            <th>Ticket Number</th>
                                                            <th>Submitted By</th>
                                                            <th>Priority</th>
                                                            <th>Status</th>
                                                            <th>Last Reply</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div>2 weeks ago</div>
                                                                <div>2025-04-04 06:09 PM</div>
                                                            </td>
                                                            <td>Problem in Creating AMC Request</td>
                                                            <td>
                                                                <a href="amc-detail.php">
                                                                    #1002
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    John Doe
                                                                </div>
                                                                <div class="badge bg-primary-subtle text-primary fw-semibold">
                                                                    Engineer
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="badge bg-danger-subtle text-danger fw-semibold">
                                                                    High
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="badge bg-danger-subtle text-danger fw-semibold">
                                                                    Pending
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div>1 weeks ago</div>
                                                                <div>2025-04-11 06:09 PM</div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex gap-2">
                                                                    <a aria-label="anchor" href="{{ route('support-ticket.view') }}"
                                                                        class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                        data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                        <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                    </a>
                                                                    <!-- <a aria-label="anchor"
                                                                        class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                        data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                        <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                    </a> -->
                                                                    <a aria-label="anchor"
                                                                        class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                        data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                        <i class="mdi mdi-delete fs-14 text-danger"></i>
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

                            </div><!-- end Experience -->
                        </div> <!-- Tab panes -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

@endsection