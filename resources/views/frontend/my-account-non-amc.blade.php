@extends('frontend/layout/master')

@section('main-content')
    <!-- Breakcrumbs -->
    <div class="tf-sp-1 pb-0">
        <div class="container">
            <ul class="breakcrumbs">
                <li>
                    <a href="{{ route('website') }}" class="body-small link">
                        Home
                    </a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="icon icon-arrow-right"></i>
                </li>
                <li>
                    <span class="body-small">Account</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->
    <!-- My Account -->
    <section class="tf-sp-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="wrap-sidebar-account ">
                        <ul class="my-account-nav content-append">
                            <li><a href="{{ route('my-account') }}" class="my-account-nav-item">Dashboard</a></li>
                            <li><a href="{{ route('my-account-orders') }}" class="my-account-nav-item">Order</a></li>
                            <li><a href="{{ route('my-account-address') }}" class="my-account-nav-item">Address</a></li>
                            <li><a href="{{ route('my-account-edit') }}" class="my-account-nav-item">Account Details</a>
                            </li>
                            <li><a href="{{ route('my-account-password') }}" class="my-account-nav-item">Change Password</a></li>
                            <li><a href="{{ route('my-account-amc') }}" class="my-account-nav-item">AMC</a></li>
                            <li><span class="my-account-nav-item active">Non-AMC</span></li>
                            <li><a href="{{ route('wishlist') }}" class="my-account-nav-item">Wishlist</a></li>
                            @if (Auth::check())
                                <form method="POST" action="{{ route('frontend.logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Logout</button>
                            </form>
                            @else
                                <form method="POST" action="{{ route('frontend.login') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </form>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="my-account-content account-dashboard">
                        <div class="d-flex justify-content-between align-items-center mb-20">
                            <h4 class="fw-semibold mb-0">Non-AMC Service Requests</h4>
                            <a href="{{ route('non-amc') }}" class="tf-btn btn-small">
                                <i class="fas fa-plus me-2"></i>New Request
                            </a>
                        </div>

                        @if($nonAmcServices->isEmpty())
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                You haven't submitted any Non-AMC service requests yet.
                                <a href="{{ route('non-amc') }}" class="alert-link">Submit your first request</a>
                            </div>
                        @else
                        <div class="tf-order_history-table">
                            <table class="table_def">
                                <thead>
                                        <tr>
                                            <th class="title-sidebar fw-medium">Service ID</th>
                                            <th class="title-sidebar fw-medium">Products</th>
                                            <th class="title-sidebar fw-medium">Service Type</th>
                                            <th class="title-sidebar fw-medium">Date</th>
                                            <th class="title-sidebar fw-medium">Status</th>
                                            <th class="title-sidebar fw-medium">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($nonAmcServices as $index => $service)
                                            <tr class="td-order-item">
                                                <td class="body-text-3">#SRV-{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                <td class="body-text-3">
                                                    <span class="badge bg-primary">{{ $service->products->count() }} Product(s)</span>
                                                </td>
                                                <td class="body-text-3">{{ $service->service_type ?? 'N/A' }}</td>
                                                
                                                <td class="body-text-3">{{ $service->created_at ? $service->created_at->format('d M Y') : 'N/A' }}</td>
                                                <td class="body-text-3">
                                                    @php
                                                        $statusClass = match($service->status) {
                                                            'Pending' => 'text-warning',
                                                            'In Progress' => 'text-info',
                                                            'Completed' => 'text-success',
                                                            'Cancelled' => 'text-danger',
                                                            default => 'text-secondary'
                                                        };
                                                    @endphp
                                                    <span class="{{ $statusClass }} fw-semibold">{{ $service->status }}</span>
                                                </td>
                                                <td>
                                                    <button type="button" class="tf-btn btn-small d-inline-flex"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#serviceDetailModal{{ $service->id }}">
                                                        <span class="text-white">View Details</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /My Account -->

    <!-- Service Detail Modals -->
    @if(!$nonAmcServices->isEmpty())
        @foreach($nonAmcServices as $service)
            <div class="modal fade" id="serviceDetailModal{{ $service->id }}" tabindex="-1" aria-labelledby="serviceDetailModalLabel{{ $service->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="serviceDetailModalLabel{{ $service->id }}">
                                Service Request Details - #SRV-{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Customer Information -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Customer Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Name:</strong> {{ $service->first_name }} {{ $service->last_name }}</p>
                                            <p class="mb-2"><strong>Email:</strong> {{ $service->email }}</p>
                                            <p class="mb-2"><strong>Phone:</strong> {{ $service->phone }}</p>
                                            @if($service->dob)
                                                <p class="mb-2"><strong>DOB:</strong> {{ $service->dob->format('d M Y') }}</p>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Customer Type:</strong> {{ $service->customer_type ?? 'N/A' }}</p>
                                            @if($service->gender)
                                                <p class="mb-2"><strong>Gender:</strong> {{ $service->gender }}</p>
                                            @endif
                                            @if($service->company_name)
                                                <p class="mb-2"><strong>Company:</strong> {{ $service->company_name }}</p>
                                                <p class="mb-2"><strong>GST No:</strong> {{ $service->gst_no ?? 'N/A' }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            @if($service->address_line1 || $service->city)
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Address Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">
                                            {{ $service->address_line1 }}
                                            @if($service->address_line2), {{ $service->address_line2 }}@endif<br>
                                            {{ $service->city }}@if($service->state), {{ $service->state }}@endif @if($service->pincode)- {{ $service->pincode }}@endif<br>
                                            @if($service->country){{ $service->country }}@endif
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Service Details -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-tools me-2"></i>Service Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Service Type:</strong> {{ $service->service_type ?? 'N/A' }}</p>
                                            <p class="mb-2"><strong>Priority Level:</strong>
                                                @php
                                                    $priorityClass = match($service->priority_level) {
                                                        'High' => 'badge bg-danger',
                                                        'Medium' => 'badge bg-warning',
                                                        'Low' => 'badge bg-success',
                                                        default => 'badge bg-secondary'
                                                    };
                                                @endphp
                                                <span class="{{ $priorityClass }}">{{ $service->priority_level ?? 'N/A' }}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Total Amount:</strong> ₹{{ number_format($service->total_amount ?? 0, 2) }}</p>
                                            <p class="mb-2">
                                                <strong>Status:</strong>
                                                @php
                                                    $statusClass = match($service->status) {
                                                        'Pending' => 'badge bg-warning',
                                                        'In Progress' => 'badge bg-info',
                                                        'Completed' => 'badge bg-success',
                                                        'Cancelled' => 'badge bg-danger',
                                                        default => 'badge bg-secondary'
                                                    };
                                                @endphp
                                                <span class="{{ $statusClass }}">{{ $service->status }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Products Information -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-box me-2"></i>Products ({{ $service->products->count() }})</h6>
                                </div>
                                <div class="card-body">
                                    @if($service->products->isEmpty())
                                        <p class="text-muted mb-0">No products added</p>
                                    @else
                                        <div class="accordion" id="productsAccordion{{ $service->id }}">
                                            @foreach($service->products as $index => $product)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading{{ $service->id }}_{{ $index }}">
                                                        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapse{{ $service->id }}_{{ $index }}"
                                                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                                                aria-controls="collapse{{ $service->id }}_{{ $index }}">
                                                            <strong>Product #{{ $index + 1 }}:</strong>&nbsp;{{ $product->product_name }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{ $service->id }}_{{ $index }}"
                                                         class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                                         aria-labelledby="heading{{ $service->id }}_{{ $index }}"
                                                         data-bs-parent="#productsAccordion{{ $service->id }}">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p class="mb-2"><strong>Product Name:</strong> {{ $product->product_name }}</p>
                                                                    <p class="mb-2"><strong>Product Type:</strong> {{ $product->product_type ?? 'N/A' }}</p>
                                                                    <p class="mb-2"><strong>Brand:</strong> {{ $product->product_brand ?? 'N/A' }}</p>
                                                                    <p class="mb-2"><strong>Model No:</strong> {{ $product->model_no ?? 'N/A' }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p class="mb-2"><strong>Serial No:</strong> {{ $product->serial_no ?? 'N/A' }}</p>
                                                                    <p class="mb-2"><strong>Purchase Date:</strong> {{ $product->purchase_date ? \Carbon\Carbon::parse($product->purchase_date)->format('d M Y') : 'N/A' }}</p>
                                                                    <p class="mb-2"><strong>Warranty Status:</strong> {{ $product->warranty_status ?? 'N/A' }}</p>
                                                                    @if($product->issue_type)
                                                                        <p class="mb-2"><strong>Issue Type:</strong> {{ $product->issue_type }}</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @if($product->issue_description)
                                                                <div class="mt-2">
                                                                    <p class="mb-0"><strong>Issue Description:</strong></p>
                                                                    <p class="mb-0">{{ $product->issue_description }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Additional Notes -->
                            @if($service->additional_notes)
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Additional Notes</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $service->additional_notes }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection

