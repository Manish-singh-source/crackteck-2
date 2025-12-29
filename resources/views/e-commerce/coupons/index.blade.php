@extends('e-commerce/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Coupons List</h4>
            </div>
            <div>
                <a href="{{ route('coupon.create') }}" class="btn btn-primary">Add New Coupon</a>
                <!-- <button class="btn btn-primary">Create Coupon</button> -->
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body border border-dashed border-end-0 border-start-0">
                        <form action="{{ route('coupon.index') }}" method="get">
                            <div class="d-flex justify-content-between">
                                <div class="row">
                                    <div class="col-xl-10 col-md-10 col-sm-10">
                                        <div class="search-box">
                                            <input type="text" name="search" value="{{ request('search') }}" class="form-control search" placeholder="Search Coupon Code or Title">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-sm-2 col-2">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <button type="submit" class="btn btn-primary waves ripple-light">
                                                <i class="fa-solid fa-magnifying-glass "></i>

                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-arrow-up-z-a "></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Sort By Name</a></li>
                                            <li><a class="dropdown-item" href="#">Sort By Discount Value</a></li>
                                        </ul>
                                    </div>

                                    <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-group" role="group">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
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
                                                                <input class="form-check-input" type="radio" name="status" value="active" id="statusActive" {{ request('status') == 'active' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="statusActive">
                                                                    Active
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mt-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="status" value="inactive" id="statusInactive" {{ request('status') == 'inactive' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="statusInactive">
                                                                    Inactive
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mt-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="status" value="" id="statusAll" {{ !request('status') ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="statusAll">
                                                                    All
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                    <div class="card-body pt-0">
                        <div class="tab-content text-muted">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow-none">
                                        <div class="card-body">
                                            <table id="responsive-datatable"
                                                class="table table-striped table-borderless dt-responsive nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Duration</th>
                                                        <th>Name</th>
                                                        <th>Code</th>
                                                        <th>Type</th>
                                                        <th>Discount Value</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($coupons as $coupon)
                                                    <tr>
                                                        <td>
                                                            {{ $coupon->start_date->format('M d, Y') }} -
                                                            {{ $coupon->end_date->format('M d, Y') }}
                                                        </td>
                                                        <td>{{ $coupon->coupon_title }}</td>
                                                        <td>
                                                            <code>{{ $coupon->coupon_code }}</code>
                                                        </td>
                                                        <td>
                                                            <span class="badge {{ $coupon->discount_type === 'percentage' ? 'bg-info-subtle text-info' : 'bg-success-subtle text-success' }} fw-semibold">
                                                                {{ $coupon->discount_type === 'percentage' ? 'Percentage' : 'Fixed Amount' }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $coupon->formatted_discount }}</td>
                                                        <td>
                                                            <span class="badge {{ $coupon->status_badge_class }} fw-semibold">
                                                                {{ $coupon->status_text }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a aria-label="anchor" href="{{ route('coupon.edit', $coupon->id) }}"
                                                                class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                            </a>
                                                            <button type="button" aria-label="anchor"
                                                                class="btn btn-icon btn-sm bg-danger-subtle delete-coupon"
                                                                data-coupon-id="{{ $coupon->id }}"
                                                                data-coupon-name="{{ $coupon->coupon_title }}"
                                                                data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center py-4">
                                                            <div class="text-muted">
                                                                <i class="mdi mdi-ticket-percent fs-24 mb-2"></i>
                                                                <p class="mb-0">No coupons found</p>
                                                                <a href="{{ route('coupon.create') }}" class="btn btn-primary btn-sm mt-2">
                                                                    Create First Coupon
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination -->
                                        @if($coupons->hasPages())
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="text-muted">
                                                Showing {{ $coupons->firstItem() }} to {{ $coupons->lastItem() }} of {{ $coupons->total() }} results
                                            </div>
                                            <div>
                                                {{ $coupons->links() }}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div> <!-- Tab panes -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Delete coupon functionality
    $('.delete-coupon').on('click', function() {
        const couponId = $(this).data('coupon-id');
        const couponName = $(this).data('coupon-name');

        if (confirm(`Are you sure you want to delete the coupon "${couponName}"?`)) {
            $.ajax({
                url: `/e-commerce/delete-coupon/${couponId}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    alert(response.message || 'Error deleting coupon');
                }
            });
        }
    });

    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
@endsection