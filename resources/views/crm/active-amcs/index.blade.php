    @extends('crm/layouts/master')

    @section('content')
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">AMC Services</h4>
                    </div>
                </div>

                <!-- End Main Widgets -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body pt-2">
                                <div class="d-flex justify-content-between align-items-center border-bottom">
                                    <ul class="nav nav-underline pt-2" id="pills-tab" role="tablist">
                                        {{-- AMC Services --}}
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active p-2" id="amc_service_tab" data-bs-toggle="tab"
                                                href="#amc_services" role="tab">
                                                <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                                <span class="d-none d-sm-block">All AMCs</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content text-muted">

                                    <div class="tab-pane active show" id="amc_services" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card shadow-none">
                                                    <div class="card-body">
                                                        <div id="amc_filters"
                                                            class="d-flex justify-content-between align-items-center mb-3"
                                                            style="display: none;">
                                                            <a href="{{ route('amc-service-requests.create') }}"
                                                                class="btn btn-primary">Create AMC</a>
                                                        </div>
                                                        <table
                                                            class="table table-striped table-borderless dt-responsive nowrap service-datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Request ID</th>
                                                                    <th>Customer Name</th>
                                                                    <th>Request Date</th>
                                                                    <th>Product Name / Model No</th>
                                                                    <th>Request Source</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($amcRequests as $request)
                                                                    <tr>
                                                                        <td>{{ $request->request_id }}</td>
                                                                        <td>
                                                                            <div class="fw-semibold">
                                                                                {{ $request->customer->first_name ?? '' }}
                                                                                {{ $request->customer->last_name ?? '' }}
                                                                            </div>
                                                                            <div class="text-muted small">
                                                                                {{ $request->customer->email ?? '' }}
                                                                            </div>
                                                                            <div class="text-muted small">
                                                                                {{ $request->customer->phone ?? 'N/A' }}
                                                                            </div>
                                                                        </td>
                                                                        <td>{{ $request->request_date }}</td>
                                                                        <td>
                                                                            <div class="fw-semibold">
                                                                                {{ $request->amcProducts->count() }}
                                                                                Product(s)
                                                                            </div>
                                                                        </td>
                                                                        @php
                                                                            $statusClasses = [
                                                                                'pending' => 'badge bg-warning',
                                                                                'approved' => 'badge bg-success',
                                                                                'rejected' => 'badge bg-danger',
                                                                                'processing' => 'badge bg-info',
                                                                                'processed' => 'badge bg-primary',
                                                                                'picking' => 'badge bg-secondary',
                                                                                'picked' => 'badge bg-dark',
                                                                                'completed' => 'badge bg-success',
                                                                            ];
                                                                        @endphp
                                                                        <td>
                                                                            @if ($request->request_source == 'customer')
                                                                                <span
                                                                                    class="badge bg-primary-subtle text-primary fw-semibold">Customer</span>
                                                                            @elseif($request->request_source == 'system')
                                                                                <span
                                                                                    class="badge bg-secondary-subtle text-secondary fw-semibold">System</span>
                                                                            @elseif($request->request_source == 'lead_won')
                                                                                <span
                                                                                    class="badge bg-info-subtle text-info fw-semibold">Lead
                                                                                    Won</span>
                                                                            @endif
                                                                            <div class="text-muted small">
                                                                                {{ $request->created_at->diffForHumans() }}
                                                                            </div>
                                                                        </td>

                                                                        @php
                                                                            $statuses = [
                                                                                'active' => ['Active', 'success'],
                                                                                'inactive' => ['Inactive', 'danger'],
                                                                                'expired' => ['Expired', 'secondary'],
                                                                                'cancelled' => ['Cancelled', 'dark'],
                                                                            ];

                                                                            [$label, $color] = $statuses[$request->status] ?? [
                                                                                ucfirst(
                                                                                    str_replace(
                                                                                        '_',
                                                                                        ' ',
                                                                                        $request->status,
                                                                                    ),
                                                                                ),
                                                                                'secondary',
                                                                            ];
                                                                        @endphp
                                                                        <td>
                                                                            <span
                                                                                class="badge bg-{{ $color }}-subtle text-{{ $color }} fw-semibold">
                                                                                {{ $label }}
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <a aria-label="anchor"
                                                                                href="{{ route('amcs-request.view', $request->id) }}"
                                                                                class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="View">
                                                                                <i
                                                                                    class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                            </a>
                                                                            
                                                                            <a aria-label="anchor"
                                                                                href="{{ route('service-request.edit-amc-service-request', [$request->id, 'amc']) }}"
                                                                                class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Edit">
                                                                                <i
                                                                                    class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                            </a> 
                                                                            
                                                                            <form
                                                                                action="{{ route('amcs-request.delete', $request->id) }}"
                                                                                method="POST" class="d-inline"
                                                                                onsubmit="return confirm('Are you sure you want to delete this quick service request?');">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" aria-label="anchor"
                                                                                    class="btn btn-icon btn-sm bg-danger-subtle"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-original-title="Delete">
                                                                                    <i
                                                                                        class="mdi mdi-delete fs-14 text-danger"></i>
                                                                                </button>
                                                                            </form> 
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="9"
                                                                            class="text-center text-muted py-4">
                                                                            <div class="text-muted">
                                                                                <i
                                                                                    class="mdi mdi-information-outline fs-1"></i>
                                                                                <p class="mt-2">
                                                                                    No Quick Service requests found.
                                                                                    <a
                                                                                        href="{{ route('quick-service-requests.create') }}">Create
                                                                                        one now</a>
                                                                                </p>
                                                                            </div>
                                                                        </td>
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
                </div> <!-- row -->
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    @endsection
