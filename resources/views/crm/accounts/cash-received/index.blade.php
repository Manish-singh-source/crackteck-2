@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Cash Received from Customer</h4>
                </div>
            </div>

            <div class="row">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body pt-0">

                                <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active p-2" id="all_customer_tab" data-bs-toggle="tab"
                                            href="#all_customer" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                            <span class="d-none d-sm-block">Transactions</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content text-muted">
                                    <div class="tab-pane active show" id="all_customer" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card shadow-none">
                                                    <div class="card-body">
                                                        <table id="responsive-datatable"
                                                            class="table table-striped table-borderless dt-responsive nowrap">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Date</th>
                                                                    <th>Staff Name</th>
                                                                    <th>Customer Name</th>
                                                                    <th>Type</th>
                                                                    <th>Related ID</th>
                                                                    <th>Amount</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($cashReceivedList as $cash)
                                                                    <tr>
                                                                        <td>{{ $cash->id }}</td>
                                                                        <td>{{ $cash->created_at->format('d M Y') }}</td>
                                                                        <td>{{ $cash->staff->first_name ?? '' }}
                                                                            {{ $cash->staff->last_name ?? '' }}</td>
                                                                        <td>{{ $cash->customer->first_name ?? '' }}
                                                                            {{ $cash->customer->last_name ?? '' }}</td>
                                                                        <td>
                                                                            @if ($cash->order_id)
                                                                                <span class="badge bg-primary">Order</span>
                                                                            @else
                                                                                <span class="badge bg-info">Service
                                                                                    Request</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($cash->order_id)
                                                                                {{ $cash->order_id }}
                                                                            @else
                                                                                {{ $cash->service_request_id }}
                                                                            @endif
                                                                        </td>
                                                                        <td>₹{{ number_format($cash->amount, 2) }}</td>
                                                                        <td>
                                                                            @if ($cash->status == 'customer_paid')
                                                                                <span class="badge bg-warning">Customer
                                                                                    Paid</span>
                                                                            @else
                                                                                <span
                                                                                    class="badge bg-success">Received</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ route('cash-received.view', $cash->id) }}"
                                                                                class="btn btn-sm btn-info">
                                                                                <i class="mdi mdi-eye"></i> View
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="9" class="text-center">No cash
                                                                            received entries found.</td>
                                                                    </tr>
                                                                @endforelse
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

    </div>
@endsection
