@extends('e-commerce/layouts/master')

@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row pt-3">

            <div class="col-xxl-3 col-xl-4 col-lg-5">
                <div class="card sticky-side-div">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0 flex-grow-1">
                                Customer Details
                            </h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="px-3">
                            <div class="profile-section-image">
                                <img src={{ $customer->pic ? asset($customer->pic) : asset('images/default-profile.png') }} alt="Customer Profile Image" style="width: 150px; height:150px" class="img-thumbnail">
                            </div>
                            <div class="mt-3">
                                <h6 class="mb-0"> <Strong>Customer Name :-  </Strong> {{ $customer->first_name }} {{ $customer->last_name }}</h6>
                                <p><strong> Joining Date :- </strong> {{ $customer->created_at->format('d M Y') }} </p>
                            </div>
                        </div>

                        <div class="p-3 bg-body rounded">
                            <h6 class="mb-3 fw-bold">Customer Information</h6>

                            <ul class="list-group">
                                <li class="d-flex justify-content-between align-items-center flex-wrap gap-2 list-group-item">
                                    <span class="fw-semibold">
                                        Full Name
                                    </span>
                                    <span class="font-weight-bold">{{ $customer->first_name }} {{ $customer->last_name }}</span>
                                </li>
                                
                                <li class="d-flex justify-content-between align-items-center flex-wrap gap-2 list-group-item">
                                    <span class="fw-semibold">
                                        Username
                                    </span>
                                    <span class="font-weight-bold">{{ $customer->first_name ?? 'No UserName' }}</span>
                                </li>

                                <li class="d-flex justify-content-between align-items-center flex-wrap gap-2 list-group-item">
                                    <span class="fw-semibold">
                                        Email
                                    </span>
                                    <span class="font-weight-bold text-break">{{ $customer->email }}</span>
                                </li>

                                <li class="d-flex justify-content-between align-items-center flex-wrap gap-2 list-group-item">
                                    <span class="fw-semibold">
                                        Phone
                                    </span>
                                    <span class="font-weight-bold">{{ $customer->phone }}</span>
                                </li>

                                <li class="d-flex justify-content-between align-items-center flex-wrap gap-2 list-group-item">
                                    <span class="fw-semibold">
                                        Status
                                    </span>

                                    <span class="badge badge-pill bg-success">Active</span>
                                </li>
                            </ul>

                            <ul class="mt-4 list-group">
                                <li class="d-flex justify-content-between align-items-center flex-wrap gap-2 list-group-item">
                                    <span class="fw-semibold">
                                        Address
                                    </span>
                                    <span>{{ $customer->address->address ?? 'No Address Found' }}</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center flex-wrap gap-2 list-group-item">
                                    <span class="fw-semibold">
                                        City
                                    </span>
                                    <span>{{ $customer->address->city ?? 'No City Found' }}</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center flex-wrap gap-2 list-group-item">
                                    <span class="fw-semibold">
                                        State
                                    </span>
                                    <span>{{ $customer->address->state ?? 'No City Found' }}</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center flex-wrap gap-2 list-group-item">
                                    <span class="fw-semibold">
                                        Country
                                    </span>
                                    <span>{{ $customer->address->country ?? 'No Country Found' }}</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center flex-wrap gap-2 list-group-item">
                                    <span class="fw-semibold">
                                        Pincode
                                    </span>
                                    <span>{{ $customer->address->pincode ?? 'No Pincode Found' }}</span>
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-9 col-xl-8 col-lg-7">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0 flex-grow-1">
                                Orders
                            </h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive mb-2">
                            <table class="table table-hover table-nowrap align-middle">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>Order Id</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Order Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody class="list form-check-all">
                                    <tr>
                                        <td data-label="Order Number - Time">
                                            
                                        </td>
                                        <td data-label="Status">
                                            <span></span>
                                        </td>
                                        <td data-label="Status">
                                            <span></span>
                                        </td>
                                        <td data-label="Status">
                                            <span class="badge badge-soft-warning"></span>
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
</div> <!-- content -->

@endsection