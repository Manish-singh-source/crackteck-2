@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Spare Parts Requests</h4>
                </div>
                <div class="row g-3">
                    <div class="col-12 text-end">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa-solid fa-sliders me-1"></i>
                                {{ ucfirst(str_replace('_', ' ', request()->get('status', 'all'))) }}
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                {{-- All Status --}}
                                <li class="dropdown-header">Status Filter</li>
                                @php
                                    $statuses = [
                                        'all' => 'All',
                                        'requested' => 'Requested',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                        'customer_approved' => 'Customer Approved',
                                        'customer_rejected' => 'Customer Rejected',
                                        'picked' => 'Picked',
                                        'in_transit' => 'In Transit',
                                        'delivered' => 'Delivered',
                                        'used' => 'Used',
                                        'cancelled' => 'Cancelled',
                                        'pending' => 'Pending',
                                        'engineer_approved' => 'Engineer Approved',
                                        'engineer_rejected' => 'Engineer Rejected',
                                    ];
                                @endphp

                                @foreach ($statuses as $key => $label)
                                    <li>
                                        <a class="dropdown-item {{ request()->get('status') === $key ? 'active' : '' }}"
                                            href="{{ route('spare-parts-requests.index', ['status' => $key]) }}">
                                            <i
                                                class="fa-solid fa-circle me-2 {{ request()->get('status') === $key ? 'text-primary' : 'text-muted' }} fs-14"></i>
                                            {{ $label }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">

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
                                                                <th>Sr. No.</th>
                                                                <th>Request Id</th>
                                                                <th>Requested By</th>
                                                                <th>Requested Date</th>
                                                                <th>Part Id</th>
                                                                <th>Total Quantity</th>
                                                                <th>Request Type</th>
                                                                <th>Approval Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $badgeClasses = [
                                                                    'requested' => 'bg-warning-subtle text-warning',
                                                                    'approved' => 'bg-success-subtle text-success',
                                                                    'rejected' => 'bg-danger-subtle text-danger',
                                                                    'customer_approved' =>
                                                                        'bg-success-subtle text-success',
                                                                    'customer_rejected' =>
                                                                        'bg-danger-subtle text-danger',
                                                                    'picked' => 'bg-success-subtle text-success',
                                                                    'in_transit' => 'bg-warning-subtle text-warning',
                                                                    'delivered' => 'bg-success-subtle text-success',
                                                                    'used' => 'bg-success-subtle text-success',
                                                                    'cancelled' => 'bg-danger-subtle text-danger',
                                                                    'pending' => 'bg-warning-subtle text-warning',
                                                                    'delivered' => 'bg-success-subtle text-success',
                                                                    'engineer_approved' =>
                                                                        'bg-success-subtle text-success',
                                                                    'engineer_rejected' =>
                                                                        'bg-danger-subtle text-danger',
                                                                ];

                                                                $status = [
                                                                    'requested' => 'Requested',
                                                                    'approved' => 'Approved',
                                                                    'rejected' => 'Rejected',
                                                                    'customer_approved' => 'Customer Approved',
                                                                    'customer_rejected' => 'Customer Rejected',
                                                                    'picked' => 'Picked',
                                                                    'in_transit' => 'In Transit',
                                                                    'delivered' => 'Delivered',
                                                                    'used' => 'Used',
                                                                    'cancelled' => 'Cancelled',
                                                                    'pending' => 'Pending',
                                                                    'delivered' => 'Delivered',
                                                                    'engineer_approved' => 'Engineer Approved',
                                                                    'engineer_rejected' => 'Engineer Rejected',
                                                                ];
                                                            @endphp
                                                            @forelse($stockRequests as $index => $request)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $request->serviceRequest->request_id ?? 'N/A' }}
                                                                    <td>{{ $request->fromEngineer->first_name ?? 'N/A' }}
                                                                        {{ $request->fromEngineer->last_name ?? 'N/A' }}
                                                                    </td>
                                                                    <td>{{ $request->created_at }}</td>
                                                                    <td>{{ $request->product->product_name }}</td>
                                                                    <td>{{ $request?->requested_quantity ?? '0' }}</td>
                                                                    <td>
                                                                        {{ ucwords(str_replace('_', ' ', $request->request_type)) }}
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge {{ $badgeClasses[strtolower($request->status)] }}">
                                                                            {{ $status[strtolower($request->status)] }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        {{-- <a href="#" --}}
                                                                        <a href="{{ route('spare-parts-requests.view', $request) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View/Edit">
                                                                            <i class="mdi mdi-eye-outline"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9" class="text-center">No requests
                                                                        found.</td>
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
            </div> <!-- container-fluid -->
        </div> <!-- content -->

        <script>
            document.querySelectorAll('.dropdown-item[data-sort]').forEach(item => {
                item.addEventListener('click', function() {
                    const sortBy = this.dataset.sort;
                    console.log('Sort by:', sortBy);
                    // call your sorting logic here
                });
            });
        </script>
    @endsection
