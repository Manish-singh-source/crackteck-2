@extends('e-commerce/layouts/master')

@section('content')

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Product Deals List</h4>
                <p class="text-muted">Manage product deals and offers</p>
            </div>
            <div>
                <a href="{{ route('product-deals.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add New Deal
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body border border-dashed border-end-0 border-start-0">
                        <form action="#" method="get">
                            <div class="d-flex justify-content-between">
                                <div class="row">
                                    <div class="col-xl-10 col-md-10 col-sm-10">
                                        <div class="search-box">
                                            <input type="text" name="search" value="" class="form-control search" placeholder="Search Deal Offer">
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
                                            <li><a class="dropdown-item" href="#">Sort By Discount</a></li>
                                            <li><a class="dropdown-item" href="#">Sort By Offer Price</a></li>
                                            <li><a class="dropdown-item" href="#">Sort By Time Left</a></li>
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
                                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    Active
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mt-3">
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
                        <div class="tab-content text-muted">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow-none">
                                        <div class="card-body">
                                            <table id="responsive-datatable"
                                                class="table table-striped table-borderless dt-responsive nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Sr. No.</th>
                                                        <th>Deal Title</th>
                                                        <th>Products Count</th>
                                                        <th>Price Range</th>
                                                        <th>Avg. Discount</th>
                                                        <th>Offer Period</th>
                                                        <th>Time Left</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($deals as $index => $deal)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>
                                                                <div class="fw-semibold">{{ $deal->deal_title }}</div>
                                                                <small class="text-muted">Created {{ $deal->created_at->diffForHumans() }}</small>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-primary-subtle text-primary">
                                                                    {{ $deal->total_products }} Product{{ $deal->total_products > 1 ? 's' : '' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <span class="fw-semibold text-success">₹{{ number_format($deal->min_offer_price, 0) }}</span>
                                                                    @if($deal->min_offer_price != $deal->max_offer_price)
                                                                        <span class="text-muted"> - </span>
                                                                        <span class="fw-semibold text-success">₹{{ number_format($deal->max_offer_price, 0) }}</span>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-primary-subtle text-primary">
                                                                    {{ number_format($deal->average_discount, 1) }}% Avg
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <small>
                                                                    {{ $deal->offer_start_date->format('M d, Y H:i') }}<br>
                                                                    <span class="text-muted">to</span><br>
                                                                    {{ $deal->offer_end_date->format('M d, Y H:i') }}
                                                                </small>
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $timeLeft = $deal->time_left_seconds;
                                                                    $badgeClass = 'bg-info';
                                                                    $timeText = '';

                                                                    if ($timeLeft <= 0) {
                                                                        $badgeClass = 'bg-danger';
                                                                        $timeText = 'Expired';
                                                                    } elseif ($timeLeft < 3600) { // Less than 1 hour
                                                                        $badgeClass = 'bg-warning';
                                                                        $timeText = floor($timeLeft / 60) . 'm left';
                                                                    } elseif ($timeLeft < 86400) { // Less than 1 day
                                                                        $badgeClass = 'bg-warning';
                                                                        $timeText = floor($timeLeft / 3600) . 'h left';
                                                                    } else {
                                                                        $badgeClass = 'bg-success';
                                                                        $timeText = floor($timeLeft / 86400) . 'd left';
                                                                    }
                                                                @endphp
                                                                <span class="badge {{ $badgeClass }} text-dark fw-semibold">{{ $timeText }}</span>
                                                            </td>
                                                            <td>
                                                                @if($deal->status === 'active')
                                                                    <span class="badge bg-success-subtle text-success fw-semibold">Active</span>
                                                                @else
                                                                    <span class="badge bg-danger-subtle text-danger fw-semibold">Inactive</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a aria-label="Edit" href="{{ route('product-deals.edit', $deal) }}"
                                                                    class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                    <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                </a>
                                                                <form action="{{ route('product-deals.delete', $deal) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this deal?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" aria-label="Delete"
                                                                        class="btn btn-icon btn-sm bg-danger-subtle"
                                                                        data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center py-4">
                                                                <div class="text-muted">
                                                                    <i class="fa fa-inbox fa-3x mb-3"></i>
                                                                    <h5>No Product Deals Found</h5>
                                                                    <p>Start by creating your first product deal.</p>
                                                                    <a href="{{ route('product-deals.create') }}" class="btn btn-primary">
                                                                        <i class="fa fa-plus"></i> Create Deal
                                                                    </a>
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

                    <!-- Pagination -->
                    @if($deals->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-0">
                                        Showing {{ $deals->firstItem() }} to {{ $deals->lastItem() }} of {{ $deals->total() }} results
                                    </p>
                                </div>
                                <div>
                                    {{ $deals->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Auto-hide success alerts
    setTimeout(function() {
        $('.alert-success').fadeOut();
    }, 5000);
});
</script>
@endsection