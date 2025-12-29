@extends('crm/layouts/master')

@section('content')

<style>
    .table-top-head {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        justify-content: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
    }

    .table-top-head span {
        list-style: none;
        margin-right: 8px;
        flex-shrink: 0;
    }

    .table-top-head span a {
        height: 35px;
        width: 35px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        justify-content: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        border: 1px solid #E6EAED;
        background: #ffffff;
        border-radius: 5px;
        padding: 4px;
        cursor: pointer;
    }
</style>
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Expenses</h4>
            </div>
            <div>
                <a href="{{ route('expenses.create') }}" class="btn btn-primary">Add Expense</a>
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
                        <div class="d-flex justify-content-between align-items-center">
                            <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active p-2" id="all_customer_tab" data-bs-toggle="tab"
                                        href="#all_customer" role="tab">
                                        <span class="d-block d-sm-none"><i
                                                class="mdi mdi-information"></i></span>
                                        <span class="d-none d-sm-block">All Expenses</span>
                                    </a>
                                </li>
                            </ul>
                            
                        </div>

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
                                                            <td>Expense Type</td>
                                                            <td>Date</td>
                                                            <td>Amount</td>
                                                            <td>Paid To</td>
                                                            <td>Payment Mode</td>
                                                            <td>Remarks</td>
                                                            <td>Upload Bill Copy</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="align-middle">
                                                            <td>Fuel</td>
                                                            <td>2025-06-03</td>
                                                            <td>₹1,200</td>
                                                            <td>Shell Petrol Pump</td>
                                                            <td>Cash</td>
                                                            <td>Office van refueling</td>
                                                            <td>
                                                                <a href="#" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                                            </td>
                                                            </td>
                                                        </tr>
                                                        <tr class="align-middle">
                                                            <td>Travel</td>
                                                            <td>2025-06-01</td>
                                                            <td>₹3,500</td>
                                                            <td>Rajesh Kumar</td>
                                                            <td> UPI</td>
                                                            <td> Client meeting in Pune</td>
                                                            <td>
                                                                <a href="#" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr class="align-middle">
                                                            <td> Rent</td>
                                                            <td> 2025-06-01</td>
                                                            <td> ₹25,000</td>
                                                            <td> Building Owner</td>
                                                            <td> Bank Transfer</td>
                                                            <td> Monthly office rent</td>
                                                            <td>
                                                                <a href="#" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr class="align-middle">
                                                            <td> Salary</td>
                                                            <td> 2025-06-05</td>
                                                            <td> ₹40,000</td>
                                                            <td> Priya Mehta</td>
                                                            <td> Bank Transfer</td>
                                                            <td> June salary</td>
                                                            <td>
                                                                <a href="#" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
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