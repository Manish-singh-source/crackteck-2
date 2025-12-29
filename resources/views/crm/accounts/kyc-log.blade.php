@extends('crm/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">KYC Log List</h4>
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
                                    <span class="d-none d-sm-block">All Logs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="active_customer_tab" data-bs-toggle="tab" href="#active_customer"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Pending Logs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="active_customer_tab" data-bs-toggle="tab" href="#active_customer"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Approved Logs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="active_customer_tab" data-bs-toggle="tab" href="#active_customer"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Rejected Logs</span>
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
                                                            <th>KYC ID</th>
                                                            <th>User Name</th>
                                                            <th>Submitted On</th>
                                                            <th>Status</th>
                                                            <th>Verified On</th>
                                                            <th>Verified By</th>
                                                            <th>Rejection Reason</th>
                                                            <th>Document Links</th>
                                                        </tr>

                                                    </thead>
                                                    <tbody>

                                                        <tr>
                                                            <td>KYC123</td>
                                                            <td>Priya Mehra</td>
                                                            <td>2025-05-20</td>
                                                            <td>Approved</td>
                                                            <td>2025-05-21</td>
                                                            <td>Admin KYC1</td>
                                                            <td>-</td>
                                                            <td>[Aadhar], [PAN]</td>
                                                        </tr>


                                                        <tr>
                                                            <td>KYC124</td>
                                                            <td>Rajat Sharma</td>
                                                            <td>2025-05-22</td>
                                                            <td>Rejected</td>
                                                            <td>2025-05-23</td>
                                                            <td>Admin KYC2</td>
                                                            <td>Blurry document</td>
                                                            <td>[Aadhar], [License]</td>
                                                        </tr>

                                                        <tr>
                                                            <td>KYC125</td>
                                                            <td>Neha Kapoor</td>
                                                            <td>2025-05-23</td>
                                                            <td>Pending</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>[Passport]</td>
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