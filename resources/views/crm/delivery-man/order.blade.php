@extends('crm/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Orders List</h4>
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
                                    <span class="d-none d-sm-block">All Orders</span>
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
                                                            <th>Order Id</th>
                                                            <th>Product Image</th>
                                                            <th>Product Name</th>
                                                            <th>Customer Name</th>
                                                            <th>Contact No.</th>
                                                            <th>Address</th>
                                                            <th>Amount</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr class="align-middle">
                                                            <td>#1001</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div>
                                                                        <img src="https://placehold.co/100x100" alt="Headphone" width="100px" class="img-fluid d-block">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                Headphones
                                                            </td>
                                                            <td>John Doe</td>
                                                            <td>8877989456</td>
                                                            <td>
                                                                17, Navyug Industrial Estate,Vazir Glass Factory Lane, Off.
                                                                <br /> Andheri-Kurla Road, Andheri (E), Mumbai – 59
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    ₹3,493.0
                                                                </div>
                                                                <span
                                                                    class="badge bg-danger-subtle text-danger fw-semibold">Unpaid</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-success-subtle text-success fw-semibold">Placed</span>
                                                            </td>
                                                            <td>
                                                                <a aria-label="anchor" href="{{ route('delivery.detail') }}"
                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                    <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
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

                            </div><!-- end Experience -->

                        </div> <!-- Tab panes -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

@endsection