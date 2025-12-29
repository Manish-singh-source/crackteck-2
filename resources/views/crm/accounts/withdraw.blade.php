@extends('crm/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Withdraw Log List</h4>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pt-0">

                        <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active p-2" id="all_logs_tab" data-bs-toggle="tab"
                                    href="#all_logs" role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-information"></i></span>
                                    <span class="d-none d-sm-block">All Logs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="pending_logs_tab" data-bs-toggle="tab" href="#pending_logs"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Pending Logs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="approved_logs_tab" data-bs-toggle="tab" href="#approved_logs"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Approved Logs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="rejected_logs_tab" data-bs-toggle="tab" href="#rejected_logs"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Rejected Logs</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content text-muted">
                            <div class="tab-pane active show pt-4" id="all_logs" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Withdrawal ID
                                                            </th>
                                                            <th>Date
                                                            </th>
                                                            <th>Requester Name
                                                            </th>
                                                            <th>User Type
                                                            </th>
                                                            <th>Amount
                                                            </th>
                                                            <th>Method
                                                            </th>
                                                            <th>Status
                                                            </th>
                                                            <th>Approved By
                                                            </th>
                                                            <th>Notes
                                                            </th>
                                                        </tr>

                                                    </thead>
                                                    <tbody>

                                                        <tr>

                                                            <td>WDR001</td>
                                                            <td>2025-05-27</td>
                                                            <td>Engineer Arun</td>
                                                            <td>Staff</td>
                                                            <td>200 INR</td>
                                                            <td>Bank Transfer</td>
                                                            <td>Approved</td>
                                                            <td>Admin A1</td>
                                                            <td>Tool expense refund</td>
                                                        </tr>

                                                        <tr>

                                                            <td>WDR002</td>
                                                            <td>2025-05-26</td>
                                                            <td>John ABC</td>
                                                            <td>Staff</td>
                                                            <td>150 INR</td>
                                                            <td>Wallet Refund</td>
                                                            <td>Rejected</td>
                                                            <td>Admin A2</td>
                                                            <td>Invalid claim</td>
                                                        </tr>

                                                        <tr>

                                                            <td>WDR003</td>
                                                            <td>2025-05-25</td>
                                                            <td>Vendor XYZ</td>
                                                            <td>Vendor</td>
                                                            <td>700 INR</td>
                                                            <td>Cheque</td>
                                                            <td>Pending</td>
                                                            <td>-</td>
                                                            <td>Monthly payout</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane show pt-4" id="pending_logs" role="tabpanel">
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
                            <div class="tab-pane show pt-4" id="approved_logs" role="tabpanel">
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
                            <div class="tab-pane show pt-4" id="rejected_logs" role="tabpanel">
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