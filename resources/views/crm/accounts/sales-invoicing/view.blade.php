@extends('crm/layouts/master')

@section('content')

<style>
    #popupOverlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    #popupOverlay img {
        max-width: 90%;
        max-height: 90%;
        box-shadow: 0 0 10px #fff;
    }

    #popupOverlay .closeBtn {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 30px;
        color: white;
        cursor: pointer;
    }

    button {
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }
</style>
<div class="content">
    <div class="container-fluid">

        <div class="row pb-3">
            <div class="col-xl-8 mx-auto">

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Customer Details</h5>
                            <div class="fw-bold text-dark">Order ID: #1001</div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <!-- Left Column -->
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold">Customer Name:</span>
                                        <span>Shyam Jaiswal</span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold">Contact No:</span>
                                        <span>9004086582</span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold">Email:</span>
                                        <span>shyam@gmail.com</span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold">Customer Type:</span>
                                        <span>Retailer</span>
                                    </li>
                                    <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold">Order Date:</span>
                                        <span>2025-04-04 06:09 PM</span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold">Payment Method:</span>
                                        <span>Online - UPI</span>
                                    </li>



                                </ul>
                            </div>

                            <!-- Right Column -->
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold">Company Name:</span>
                                        <span>Technofra</span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold">Shipping Address:</span>
                                        <span>Lalji Pada, Maharashtra 400067</span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold">Billing Address:</span>
                                        <span>Lalji Pada, Kandivali West, Mumbai, Maharashtra 400067</span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold">GST No:</span>
                                        <span>988498</span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold">PAN No:</span>
                                        <span>789MTUO</span>
                                    </li>


                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Order Details
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-borderless dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="align-middle">
                                    <td>#ORD12345</td>
                                    <td>John Doe</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="https://placehold.co/100x100" alt="Headphone" width="100px" class="img-fluid d-block">
                                            </div>
                                        </div>
                                    </td>
                                    <td>Headphone</td>
                                    <td>2</td>
                                    <td>₹99.99</td>
                                    <td>2025-04-04 06:09 PM</td>
                                    <td><span class="badge bg-success">Delivered</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body p-4">
                        <ul class="simple-timeline mb-0">
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-dot timeline-dot-purple"></span>
                                <div class="timeline-time mt-3">
                                    <div class="timeline-header-section mb-2">
                                        <h5 class="mb-0">Status Changed</h5>
                                        <small class="text-muted">25 min ago</small>
                                    </div>
                                    <p class="mb-2">
                                        Status has been changed pending to active.
                                    </p>
                                </div>
                            </li>

                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-dot timeline-dot-info"></span>
                                <div class="timeline-time mt-3">
                                    <div class="timeline-header-section mb-2">
                                        <h5 class="mb-0">Service Generated</h5>
                                        <small class="text-muted">6 days ago</small>
                                    </div>
                                    <p class="mb-2">
                                        A new service request has been generated by John Doe (engineer)
                                    </p>
                                </div>
                            </li>

                            <li>
                                <div class="timeline-time mt-3">
                                    <div class="timeline-header-section mb-2">
                                        <a href="#" class="mb-0 btn btn-sm btn-primary">View All History</a>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> <!-- content -->

@endsection