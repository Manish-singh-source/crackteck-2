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
                            <!-- <li><a href="my-account-amc') }}" class="my-account-nav-item">AMC</a></li> -->
                            <li><a href="{{ route('my-account-password') }}" class="my-account-nav-item">Change Password</a>
                            </li>
                            <li><span class="my-account-nav-item active">AMC</span></li>
                            {{-- <li><a href="{{ route('my-account-non-amc') }}" class="my-account-nav-item">NON AMC</a> --}}
                            </li>
                            <li><a href="{{ route('wishlist') }}" class="my-account-nav-item">Wishlist</a></li>
                            @if (Auth::guard('customer_web')->check())
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
                            <h4 class="fw-semibold mb-0">AMC Service Requests</h4>
                            <a href="{{ route('amc') }}"
                                class="tf-btn btn-small d-inline-flex">
                                <span class="text-white">New Request</span>
                            </a>
                        </div>

                        @if ($servicesRequest->isEmpty())
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                You haven't submitted any AMC service requests yet.
                                <a href="{{ route('amc') }}" class="alert-link">Submit your first request</a>
                            </div>
                        @else
                            <div class="tf-order_history-table">
                                <table class="table_def">
                                    <thead>
                                        <tr>
                                            <th class="title-sidebar fw-medium">Service ID</th>
                                            <th class="title-sidebar fw-medium">Products</th>
                                            <th class="title-sidebar fw-medium">Plan Name</th>
                                            <th class="title-sidebar fw-medium">Start Date</th>
                                            <th class="title-sidebar fw-medium">End Date</th>
                                            <th class="title-sidebar fw-medium">Status</th>
                                            <th class="title-sidebar fw-medium">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($servicesRequest as $index => $service)
                                            <tr class="td-order-item">
                                                <td class="body-text-3">{{ $service->request_id }}</td>
                                                <td class="body-text-3">
                                                    <span class="">{{ $service->products->count() }}
                                                        Product(s)</span>
                                                </td>
                                                <td class="body-text-3">{{ $service->amcPlan->plan_name ?? 'N/A' }}</td>
                                                <td class="body-text-3">
                                                    {{ $service->created_at ? $service->created_at->format('d M Y') : 'N/A' }}
                                                </td>
                                                {{-- take amc_plan_id from amc_plans table and then in that duration column get duration from amc_plans table 
                                                use created_at from servicesRequest table and then add duration from amc_plans table to created_at date and show that date in end date column --}}
                                                <td class="body-text-3">
                                                    @php
                                                        $startDate = $service->created_at;
                                                        $durationMonths = $service->amcPlan->duration ?? 0;
                                                        $endDate = $startDate
                                                            ? $startDate->copy()->addMonths($durationMonths)
                                                            : null;
                                                    @endphp
                                                    {{ $endDate ? $endDate->format('d M Y') : 'N/A' }}
                                                </td>
                                                <td class="body-text-3">
                                                    @php
                                                        $statusClass = match ($service->amc_status) {
                                                            'Inactive' => 'text-warning',
                                                            'Expired' => 'text-danger',
                                                            'Active' => 'text-success',
                                                            'Cancelled' => 'text-danger',
                                                            default => 'text-secondary',
                                                        };
                                                    @endphp
                                                    <span
                                                        class="{{ $statusClass }} fw-semibold">{{ ucwords(str_replace('_', ' ', $service->amc_status)) }}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('my-account-amc.view', $service->id) }}"
                                                        class="tf-btn btn-small d-inline-flex">
                                                        <span class="text-white">View Details</span>
                                                    </a>
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
@endsection
