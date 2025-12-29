@extends('warehouse/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Stock Requests</h4>
            </div>
            <div>
                <a href="{{ route('stock-request.create') }}" class="btn btn-primary">Create New Stock Request</a>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body border border-dashed border-end-0 border-start-0">
                        <form action="#" method="get">
                            <div class="d-flex justify-content-between">
                                <div class="row">
                                    <div class="col-xl-10 col-md-10 col-sm-10">
                                        <div class="search-box">
                                            <input type="text" name="search" value="{{ request('search') }}" class="form-control search" placeholder="Search by user name, email, or reason">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-sm-2 col-2">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <button type="submit" class="btn btn-primary waves ripple-light">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <!-- <span class="d-none d-md-inline-flex"> Sort </span> -->
                                            <i class="fa-solid fa-arrow-up-z-a "></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Sort By Name</a></li>
                                            <li><a class="dropdown-item" href="#">Sort By E-mail</a></li>
                                        </ul>
                                    </div>

                                    <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-group" role="group">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                                            <!-- <span class="d-none d-md-inline-flex"> Filters </span> -->
                                            <i class="fa-solid fa-filter "></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="standard-modal" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="standard-modalLabel">Filters</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body px-3 py-md-2">
                                                <h5>Status</h5>
                                                <div class="row">
                                                    <div class="col-6">

                                                        <div class="mt-3">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    Active
                                                                </label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                                                <label class="form-check-label" for="flexRadioDefault2">
                                                                    Inactive
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                    <div class="card-body pt-0">
                        <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active p-2" id="all_customer_tab" data-bs-toggle="tab"
                                    href="#all_customer" role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-information"></i></span>
                                    <span class="d-none d-sm-block">All Stock Requests</span>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link p-2" id="active_customer_tab" data-bs-toggle="tab" href="#active_customer"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Active Customer</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="banned_customers_tab" data-bs-toggle="tab"
                                    href="#banned_customers" role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Banned Customer</span>
                                </a>
                            </li> -->
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
                                                            <th>Requested By</th>
                                                            <th>Date of Request</th>
                                                            <th>Item No</th>
                                                            <th>Quantity</th>
                                                            <th>Reason / Justification</th>
                                                            <th>Urgency Level</th>
                                                            <th>Approval Status</th>
                                                            <th>Final Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($stockRequests as $stockRequest)
                                                            <tr>
                                                                <td>{{ $stockRequest->requestedBy->name ?? 'N/A' }}</td>
                                                                <td>{{ $stockRequest->request_date->format('Y-m-d') }}</td>
                                                                <td>{{ $stockRequest->item_count }}</td>
                                                                <td>{{ $stockRequest->total_quantity }}</td>
                                                                <td>{{ Str::limit($stockRequest->reason, 50) }}</td>
                                                                <td>
                                                                    <span class="badge {{ $stockRequest->urgency_badge_class }}">
                                                                        {{ $stockRequest->urgency_level }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge {{ $stockRequest->approval_badge_class }}">
                                                                        {{ $stockRequest->approval_status }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge {{ $stockRequest->final_badge_class }}">
                                                                        {{ $stockRequest->final_status }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('stock-request.show', $stockRequest) }}"
                                                                       class="btn btn-sm btn-primary"
                                                                       data-bs-toggle="tooltip"
                                                                       data-bs-original-title="View/Edit">
                                                                        <i class="mdi mdi-eye-outline"></i>
                                                                    </a>
                                                                    {{-- <button type="button"
                                                                            class="btn btn-sm btn-danger delete-stock-request"
                                                                            data-id="{{ $stockRequest->id }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Delete">
                                                                        <i class="mdi mdi-delete"></i>
                                                                    </button> --}}
                                                                    <form style="display: inline-block"
                                                                            action="{{ route('stock-request.destroy', $stockRequest->id) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Are you sure?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Delete"><i
                                                                                    class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center py-4">
                                                                    <div class="text-muted">
                                                                        <i class="mdi mdi-inbox-outline fs-24 mb-2 d-block"></i>
                                                                        No stock requests found.
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

                                <!-- Pagination -->
                                @if($stockRequests->hasPages())
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-center">
                                                {{ $stockRequests->links() }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div><!-- end Experience -->

                        </div> <!-- Tab panes -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this stock request? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let deleteId = null;

    // Handle delete button click
    $('.delete-stock-request').on('click', function() {
        deleteId = $(this).data('id');
        $('#deleteModal').modal('show');
    });

    // Handle confirm delete
    $('#confirmDelete').on('click', function() {
        if (deleteId) {
            $.ajax({
                url: `/warehouse/stock-requests/${deleteId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while deleting the stock request.');
                }
            });
        }
        $('#deleteModal').modal('hide');
    });
});
</script>
@endsection