@extends('crm.layouts.master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Transaction log List</h4>
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
                                    <span class="d-none d-sm-block">Transactions</span>
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
                                                            <th>Date</th>
                                                            <th>Engineer Name</th>
                                                            <th>Customer Name</th>
                                                            <th>Transaction ID</th>
                                                            <th>Order ID</th>
                                                            <th>Amount</th>
                                                            <th>Mode</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    2 weeks ago
                                                                </div>
                                                                <div>
                                                                    2025-04-04 06:09 PM
                                                                </div>
                                                            </td>
                                                            <td>E1</td>
                                                            <td>John Doe</td>

                                                            <td>TXN8901</td>
                                                            <td>#ORD123 </td>

                                                            <td>
                                                                <div class="text-success">
                                                                    +2890 INR
                                                                </div>
                                                                Order balance added for order number cartuser7658831
                                                            </td>
                                                            <td>UPI</td>
                                                            <td>
                                                                <span class="badge bg-danger-subtle text-danger fw-semibold">Pending</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    2 weeks ago
                                                                </div>
                                                                <div>
                                                                    2025-04-04 06:09 PM
                                                                </div>
                                                            </td>
                                                            <td>E2</td>
                                                            <td>John Doe</td>

                                                            <td>TXN8901</td>
                                                            <td>#ORD123 </td>

                                                            <td>
                                                                <div class="text-success">
                                                                    +2890 INR
                                                                </div>
                                                                Order balance added for order number cartuser7658831
                                                            </td>
                                                            <td>Cash</td>
                                                            <td>
                                                                <span class="badge bg-danger-subtle text-danger fw-semibold">Pending</span>
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