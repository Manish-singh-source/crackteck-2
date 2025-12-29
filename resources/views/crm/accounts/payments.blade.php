@extends('crm/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Payment Log List</h4>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pt-0">

                        <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active p-2" id="all_customer_tab" data-bs-toggle="tab"
                                    href="#all_customer" role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-information"></i></span>
                                    <span class="d-none d-sm-block">All Payments</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="active_customer_tab" data-bs-toggle="tab" href="#active_customer"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Pending Payments</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="active_customer_tab" data-bs-toggle="tab" href="#active_customer"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Approved Payments</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="active_customer_tab" data-bs-toggle="tab" href="#active_customer"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Rejected Payments</span>
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

                                                            <td>Payment ID</td>
                                                            <td>Date</td>
                                                            <td>Customer Name</td>
                                                            <td>Service/Plan</td>
                                                            <td>Amount</td>
                                                            <td>Payment Mode</td>
                                                            <td>Status</td>
                                                            <td>Invoice ID </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>PAY1122</td>
                                                            <td>2025-05-27</td>
                                                            <td>Alice Brown</td>
                                                            <td>AMC Gold</td>
                                                            <td>300 INR</td>
                                                            <td>UPI</td>
                                                            <td>
                                                                <span class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                            </td>
                                                            <td>INV77891</td>
                                                        </tr>
                                                        <tr>
                                                            <td>PAY1123</td>
                                                            <td>2025-05-26</td>
                                                            <td>Bob White</td>
                                                            <td>Repair Visit</td>
                                                            <td>120 INR</td>
                                                            <td>Credit Card</td>
                                                            <td>
                                                                <span class="badge bg-danger-subtle text-danger fw-semibold">Failed</span>
                                                            </td>
                                                            <td>INV77892</td>
                                                        </tr>
                                                        <tr>
                                                            <td>PAY1124</td>
                                                            <td>2025-05-25</td>
                                                            <td>Clara Grey</td>
                                                            <td>Subscription</td>
                                                            <td>99 INR</td>
                                                            <td>Net Banking</td>
                                                            <td>
                                                                <span class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                            </td>
                                                            <td>INV77893</td>
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