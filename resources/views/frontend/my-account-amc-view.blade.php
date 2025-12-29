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
                    <a href="{{ route('my-account') }}" class="body-small link">
                        Account
                    </a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="icon icon-arrow-right"></i>
                </li>
                <li>
                    <a href="{{ route('my-account-amc') }}" class="body-small link">
                        AMC Services
                    </a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="icon icon-arrow-right"></i>
                </li>
                <li>
                    <span class="body-small">Service Details</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->

    <!-- AMC Service Details -->
    <section class="tf-sp-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="wrap-sidebar-account">
                        <ul class="my-account-nav content-append">
                            <li><a href="{{ route('my-account') }}" class="my-account-nav-item">Dashboard</a></li>
                            <li><a href="{{ route('my-account-orders') }}" class="my-account-nav-item">Order</a></li>
                            <li><a href="{{ route('my-account-address') }}" class="my-account-nav-item">Address</a></li>
                            <li><a href="{{ route('my-account-edit') }}" class="my-account-nav-item">Account Details</a>
                            </li>
                            <li><a href="{{ route('my-account-password') }}" class="my-account-nav-item">Change Password</a>
                            </li>
                            <li><span class="my-account-nav-item active">AMC</span></li>
                            <li><a href="{{ route('my-account-non-amc') }}" class="my-account-nav-item">NON AMC</a></li>
                            <li><a href="{{ route('wishlist') }}" class="my-account-nav-item">Wishlist</a></li>
                            @if (Auth::check())
                                <form method="POST" action="{{ route('frontend.logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100">Logout</button>
                                </form>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="my-account-content">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-semibold mb-0">AMC Service Details</h4>
                            <a href="{{ route('my-account-amc') }}" class="tf-btn btn-small">
                                <i class="fas fa-arrow-left me-2"></i>Back to List
                            </a>
                        </div>

                        <!-- Service ID & Status -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">Service ID: <span
                                                class="text-primary">{{ $amcService->service_id }}</span></h5>
                                        <p class="text-muted mb-0 small">Created on
                                            {{ $amcService->created_at->format('d M Y, h:i A') }}</p>
                                    </div>
                                    <div>
                                        @php
                                            $statusClass = match ($amcService->status) {
                                                'Pending' => 'badge bg-warning text-dark',
                                                'Active' => 'badge bg-success',
                                                'In Progress' => 'badge bg-info',
                                                'Completed' => 'badge bg-success',
                                                'Cancelled' => 'badge bg-danger',
                                                default => 'badge bg-secondary',
                                            };
                                        @endphp
                                        <span class="{{ $statusClass }} fs-6">{{ $amcService->status }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-semibold"><i class="fas fa-user me-2"></i>Customer Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <p class="mb-2"><strong>Name:</strong> {{ $amcService->first_name }}
                                            {{ $amcService->last_name }}</p>
                                        <p class="mb-2"><strong>Email:</strong> {{ $amcService->email }}</p>
                                        <p class="mb-2"><strong>Phone:</strong> {{ $amcService->phone }}</p>
                                        <p class="mb-0"><strong>Date of Birth:</strong>
                                            {{ $amcService->dob ? $amcService->dob->format('d M Y') : 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <p class="mb-2"><strong>Customer Type:</strong> {{ $amcService->customer_type }}
                                        </p>
                                        @if ($amcService->company_name)
                                            <p class="mb-2"><strong>Company:</strong> {{ $amcService->company_name }}</p>
                                            <p class="mb-2"><strong>Company Address:</strong>
                                                {{ $amcService->company_address ?? 'N/A' }}</p>
                                            <p class="mb-2"><strong>GST No:</strong> {{ $amcService->gst_no ?? 'N/A' }}
                                            </p>
                                            <p class="mb-0"><strong>PAN No:</strong> {{ $amcService->pan_no ?? 'N/A' }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- AMC Plan Details -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-semibold"><i class="fas fa-file-contract me-2"></i>AMC Plan Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <p class="mb-2"><strong>Plan Name:</strong>
                                            {{ $amcService->amcPlan->plan_name ?? 'N/A' }}</p>
                                        <p class="mb-2"><strong>Start Date:</strong>
                                            {{ $amcService->plan_start_date ? $amcService->plan_start_date->format('d M Y') : 'N/A' }}
                                        </p>
                                        <p class="mb-2"><strong>Plan Type:</strong> {{ $amcService->plan_type ?? 'N/A' }}</p>
                                        <p class="mb-2"><strong>Priority Level:</strong>
                                            {{ $amcService->priority_level ?? 'Normal' }}</p>

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <p class="mb-2"><strong>Plan Duration:</strong> {{ $amcService->plan_duration }}
                                        </p>
                                        <p class="mb-2">
                                            <strong>End Date:</strong>
                                            @php
                                                $endDate = null;
                                                if ($amcService->plan_start_date && $amcService->plan_duration) {
                                                    $startDate = \Carbon\Carbon::parse($amcService->plan_start_date);
                                                    $duration = $amcService->plan_duration;
                                                    preg_match('/\d+/', $duration, $matches);
                                                    $number = isset($matches[0]) ? (int) $matches[0] : 0;
                                                    if (stripos($duration, 'month') !== false) {
                                                        $endDate = $startDate->copy()->addMonths($number);
                                                    } elseif (stripos($duration, 'year') !== false) {
                                                        $endDate = $startDate->copy()->addYears($number);
                                                    } elseif (stripos($duration, 'day') !== false) {
                                                        $endDate = $startDate->copy()->addDays($number);
                                                    }
                                                }
                                            @endphp
                                            {{ $endDate ? $endDate->format('d M Y') : ($amcService->plan_end_date ? $amcService->plan_end_date->format('d M Y') : 'N/A') }}
                                        </p>
                                        <p class="mb-2"><strong>Total Visits:</strong> {{ $amcService->amcPlan->total_visits ?? 'N/A' }}</p>
                                        <p class="mb-0"><strong>Total Amount:</strong> <span
                                                class="text-success fw-bold fs-6">₹{{ number_format($amcService->total_amount, 2) }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Service Branches -->
                        @if ($amcService->branches && $amcService->branches->count() > 0)
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-semibold"><i class="fas fa-map-marker-alt me-2"></i>Service Locations
                                        ({{ $amcService->branches->count() }})</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($amcService->branches as $index => $branch)
                                            <div class="col-md-6 mb-3">
                                                <div class="border rounded p-3 h-100">
                                                    <h6 class="fw-semibold mb-2">Branch {{ $index + 1 }}</h6>
                                                    <p class="mb-1"><strong>Address:</strong>
                                                        {{ $branch->address_line1 }}</p>
                                                    @if ($branch->address_line2)
                                                        <p class="mb-1">{{ $branch->address_line2 }}</p>
                                                    @endif
                                                    <p class="mb-1">{{ $branch->city }}, {{ $branch->state }} -
                                                        {{ $branch->pincode }}</p>
                                                    <p class="mb-0">{{ $branch->country }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Products Information -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-semibold"><i class="fas fa-box me-2"></i>Products
                                    ({{ $amcService->products->count() }})</h6>
                            </div>
                            <div class="card-body">
                                @if ($amcService->products->isEmpty())
                                    <p class="text-muted mb-0">No products added</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product Name</th>
                                                    <th>Type</th>
                                                    <th>Brand</th>
                                                    <th>Model No</th>
                                                    <th>Serial No</th>
                                                    <th>Purchase Date</th>
                                                    <th>Warranty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($amcService->products as $index => $product)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td>{{ $product->product_type ?? '-' }}</td>
                                                        <td>{{ $product->product_brand ?? '-' }}</td>
                                                        <td>{{ $product->model_no ?? '-' }}</td>
                                                        <td>{{ $product->serial_no ?? '-' }}</td>
                                                        <td>{{ $product->purchase_date ? \Carbon\Carbon::parse($product->purchase_date)->format('d M Y') : '-' }}
                                                        </td>
                                                        <td>{{ $product->warranty_status ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        @if ($amcService->additional_notes)
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-semibold"><i class="fas fa-sticky-note me-2"></i>Additional Notes
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $amcService->additional_notes }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('my-account-amc') }}" class="tf-btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Back to AMC Services
                                    </a>
                                    <a href="{{ route('amc') }}" class="tf-btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>New AMC Request
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /AMC Service Details -->
@endsection
