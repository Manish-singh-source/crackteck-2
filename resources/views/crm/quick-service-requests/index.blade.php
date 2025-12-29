@extends('crm.layouts.master')

{{-- @section('title', 'Quick Service Requests') --}}

@section('content')
    <div class="content">
        <div class="container-fluid py-3">
            <!-- Page Breadcrumb -->
            <div class="page-breadcrumb mb-3">
                <nav>
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li> --}}
                        <li class="breadcrumb-item active">Quick Service Requests</li>
                    </ol>
                </nav>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Quick Service Requests</h5>
                            <div>
                                <span class="badge bg-info">Total: {{ $quickServiceRequests->count() }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="quick-service-requests-datatable" class="table table-striped table-hover dt-responsive nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>Request ID</th>
                                        <th>Quick Service Name</th>
                                        <th>Customer Name</th>
                                        <th>Product Name / Model No</th>
                                        <th>Status</th>
                                        <th>Assigned Engineer/Group</th>
                                        <th>Created At</th>
                                        <th style="width:120px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($quickServiceRequests as $request)
                                        <tr>
                                            <td>
                                                <a href="{{ route('quick-service-requests.view', $request->id) }}" class="fw-semibold">
                                                    #QSR-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $request->quickService->name ?? 'N/A' }}</div>
                                                <div class="text-muted small">₹{{ number_format($request->quickService->service_price ?? 0, 2) }}</div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $request->customer->first_name ?? '' }} {{ $request->customer->last_name ?? '' }}</div>
                                                <div class="text-muted small">{{ $request->customer->phone ?? 'N/A' }}</div>
                                            </td>
                                            <td>
                                                <div>{{ $request->product_name }}</div>
                                                @if($request->model_no)
                                                    <div class="text-muted small">Model: {{ $request->model_no }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($request->status == 'completed')
                                                    <span class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                @elseif($request->status == 'processing')
                                                    <span class="badge bg-info-subtle text-info fw-semibold">Processing</span>
                                                @elseif($request->status == 'active')
                                                    <span class="badge bg-primary-subtle text-primary fw-semibold">Active</span>
                                                @elseif($request->status == 'pending')
                                                    <span class="badge bg-warning-subtle text-warning fw-semibold">Pending</span>
                                                @elseif($request->status == 'cancel')
                                                    <span class="badge bg-danger-subtle text-danger fw-semibold">Cancelled</span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary fw-semibold">{{ ucfirst($request->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($request->activeAssignment)
                                                    @if($request->activeAssignment->assignment_type === 'Individual')
                                                        <div class="fw-semibold">{{ $request->activeAssignment->engineer->first_name ?? '' }} {{ $request->activeAssignment->engineer->last_name ?? '' }}</div>
                                                        <div class="text-muted small">Individual</div>
                                                    @else
                                                        <div class="fw-semibold">{{ $request->activeAssignment->group_name }}</div>
                                                        <div class="text-muted small">Group ({{ $request->activeAssignment->groupEngineers->count() }} engineers)</div>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Not Assigned</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>{{ $request->created_at->format('d M Y') }}</div>
                                                <div class="text-muted small">{{ $request->created_at->diffForHumans() }}</div>
                                            </td>
                                            <td>
                                                <a aria-label="anchor"
                                                    href="{{ route('quick-service-requests.view', $request->id) }}"
                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="View">
                                                    <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                </a>
                                                <a aria-label="anchor"
                                                    href="{{ route('quick-service-requests.edit', $request->id) }}"
                                                    class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="Edit">
                                                    <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                </a>
                                                <form
                                                    action="{{ route('quick-service-requests.destroy', $request->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this quick service request?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" aria-label="anchor"
                                                        class="btn btn-icon btn-sm bg-danger-subtle"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="Delete">
                                                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                <div class="text-muted">
                                                    <i class="mdi mdi-information-outline fs-1"></i>
                                                    <p class="mt-2">No Quick Service requests found.</p>
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
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#quick-service-requests-datatable').DataTable({
            "order": [[6, "desc"]], // Sort by Created At column descending
            "pageLength": 15,
            "responsive": true
        });
    });
</script>
@endsection

