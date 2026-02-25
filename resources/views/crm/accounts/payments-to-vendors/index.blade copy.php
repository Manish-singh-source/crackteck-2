@extends('crm/layouts/master')

@section('content')

<div class="content">


    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Payments To Vendors</h4>
            </div>
            <div>
                <a href="{{ route('pay-to-vendors.create') }}" class="btn btn-primary">Add Payment</a>
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
                                                            <th>Paid To</th>
                                                            <th>Amount</th>
                                                            <th>Date</th>
                                                            <th>Payment Mode</th>
                                                            <th>Linked Bill</th>
                                                            <th>Remarks</th>
                                                            <th>Upload Payment Proof</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="align-middle">
                                                            <td>GreenMart Ltd.</td>
                                                            <td>₹12,000</td>
                                                            <td>2025-06-04</td>
                                                            <td>Bank Transfer</td>
                                                            <td>PB-1023</td>
                                                            <td>Payment for May supplies</td>
                                                            <td>
                                                                <a href="#" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr class="align-middle">
                                                            <td> Nova Traders</td>
                                                            <td> ₹8,500</td>
                                                            <td> 2025-06-02</td>
                                                            <td> UPI</td>
                                                            <td> PB-1021</td>
                                                            <td> Partial payment</td>
                                                            <td>
                                                                <a href="#" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr class="align-middle">
                                                            <td> SafeMove Trans.</td>
                                                            <td> ₹1,200</td>
                                                            <td> 2025-06-05</td>
                                                            <td> Cash</td>
                                                            <td> PB-1025</td>
                                                            <td> Freight charges settlement</td>
                                                            <td>
                                                                <a href="#" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr class="align-middle">
                                                            <td> PrintZone Pvt Ltd</td>
                                                            <td> ₹6,000</td>
                                                            <td> 2025-06-01</td>
                                                            <td> Cheque</td>
                                                            <td> PB-1020</td>
                                                            <td> Final payment for printing</td>
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

                            </div>

                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>

@endsection