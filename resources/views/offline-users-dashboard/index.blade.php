@extends('offline-users-dashboard/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
                </div>
                <div class="text-muted">
                    <i class="fas fa-calendar-alt me-1"></i>
                    <span id="current-date"></span>
                </div>
            </div>
            @php
                $customer = Auth::guard('customer_web')->user();
            @endphp

            <!-- Welcome Banner -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 overflow-hidden"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <div class="text-white">
                                        <h3 class="fw-bold mb-2">Welcome back,
                                            <span class="d-none d-sm-inline-block pro-user-name ms-1">
                                                {{ $customer ? $customer->first_name . ' ' . $customer->last_name : 'Guest' }}
                                            </span> 👋
                                        </h3>
                                        <p class="fs-15 mb-3 opacity-75">
                                            Manage your account, track your AMC plans, view service requests, and stay
                                            updated — all from one place.
                                        </p>
                                        <a href="{{ route('offline-amc') }}"
                                            class="btn btn-light btn-sm fw-semibold px-4 py-2 rounded-pill shadow-sm">
                                            <i class="fas fa-clipboard-check me-1"></i> View AMC Plans
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center d-none d-lg-block">
                                    <div style="font-size: 100px; opacity: 0.2;">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 56px; height: 56px; background: rgba(102, 126, 234, 0.15);">
                                        <i class="fas fa-clipboard-list fs-22 text-primary"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fw-bold mb-1 text-dark">0</h5>
                                    <p class="text-muted mb-0 fs-13">Active AMC Plans</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 56px; height: 56px; background: rgba(40, 199, 111, 0.15);">
                                        <i class="fas fa-tools fs-22" style="color: #28c76f;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fw-bold mb-1 text-dark">0</h5>
                                    <p class="text-muted mb-0 fs-13">Service Requests</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 56px; height: 56px; background: rgba(255, 159, 67, 0.15);">
                                        <i class="fas fa-calendar-check fs-22" style="color: #ff9f43;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fw-bold mb-1 text-dark">0</h5>
                                    <p class="text-muted mb-0 fs-13">Upcoming Visits</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 56px; height: 56px; background: rgba(234, 84, 85, 0.15);">
                                        <i class="fas fa-exclamation-triangle fs-22" style="color: #ea5455;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fw-bold mb-1 text-dark">0</h5>
                                    <p class="text-muted mb-0 fs-13">Pending Issues</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Account Info -->
            <div class="row g-3 mb-4">
                <!-- Quick Actions -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-bottom">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i class="fas fa-bolt text-warning me-2"></i>Quick Actions
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-sm-6 col-lg-4">
                                    <a href="{{ route('amc') }}" class="text-decoration-none">
                                        <div class="card border bg-light-subtle h-100 mb-0 transition-card">
                                            <div class="card-body text-center py-4">
                                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                    style="width: 60px; height: 60px; background: rgba(102, 126, 234, 0.15);">
                                                    <i class="fas fa-clipboard-check fs-24 text-primary"></i>
                                                </div>
                                                <h6 class="fw-semibold text-dark mb-1">My AMC Plans</h6>
                                                <small class="text-muted">View & manage AMC</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <a href="{{ route('my-account-orders') }}" class="text-decoration-none">
                                        <div class="card border bg-light-subtle h-100 mb-0 transition-card">
                                            <div class="card-body text-center py-4">
                                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                    style="width: 60px; height: 60px; background: rgba(40, 199, 111, 0.15);">
                                                    <i class="fas fa-shopping-bag fs-24" style="color: #28c76f;"></i>
                                                </div>
                                                <h6 class="fw-semibold text-dark mb-1">Recent Orders</h6>
                                                <small class="text-muted">Track your orders</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <a href="{{ route('my-account-address') }}" class="text-decoration-none">
                                        <div class="card border bg-light-subtle h-100 mb-0 transition-card">
                                            <div class="card-body text-center py-4">
                                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                    style="width: 60px; height: 60px; background: rgba(255, 159, 67, 0.15);">
                                                    <i class="fas fa-map-marker-alt fs-24" style="color: #ff9f43;"></i>
                                                </div>
                                                <h6 class="fw-semibold text-dark mb-1">My Addresses</h6>
                                                <small class="text-muted">Manage addresses</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <a href="{{ route('my-account-edit') }}" class="text-decoration-none">
                                        <div class="card border bg-light-subtle h-100 mb-0 transition-card">
                                            <div class="card-body text-center py-4">
                                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                    style="width: 60px; height: 60px; background: rgba(234, 84, 85, 0.15);">
                                                    <i class="fas fa-user-edit fs-24" style="color: #ea5455;"></i>
                                                </div>
                                                <h6 class="fw-semibold text-dark mb-1">Edit Profile</h6>
                                                <small class="text-muted">Update your details</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <a href="{{ route('my-account-edit') }}" class="text-decoration-none">
                                        <div class="card border bg-light-subtle h-100 mb-0 transition-card">
                                            <div class="card-body text-center py-4">
                                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                    style="width: 60px; height: 60px; background: rgba(0, 207, 232, 0.15);">
                                                    <i class="fas fa-lock fs-24" style="color: #00cfe8;"></i>
                                                </div>
                                                <h6 class="fw-semibold text-dark mb-1">Change Password</h6>
                                                <small class="text-muted">Security settings</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <a href="{{ route('my-account-orders') }}" class="text-decoration-none">
                                        <div class="card border bg-light-subtle h-100 mb-0 transition-card">
                                            <div class="card-body text-center py-4">
                                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                    style="width: 60px; height: 60px; background: rgba(115, 103, 240, 0.15);">
                                                    <i class="fas fa-headset fs-24" style="color: #7367f0;"></i>
                                                </div>
                                                <h6 class="fw-semibold text-dark mb-1">Support</h6>
                                                <small class="text-muted">Get help & support</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Summary -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-bottom">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i class="fas fa-user-circle text-primary me-2"></i>Account Summary
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Profile Section -->
                            <div class="text-center mb-4">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <span class="text-white fw-bold fs-24">T</span>
                                </div>
                                <h5 class="fw-semibold mb-1">Technofra</h5>
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">
                                    <i class="fas fa-check-circle me-1"></i>Active Account
                                </span>
                            </div>

                            <hr>

                            <!-- Account Details -->
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="rounded d-flex align-items-center justify-content-center"
                                            style="width: 36px; height: 36px; background: rgba(102, 126, 234, 0.1);">
                                            <i class="fas fa-envelope text-primary fs-14"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <small class="text-muted d-block">Email</small>
                                        <span class="fw-medium fs-13">info@technofra.com</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="rounded d-flex align-items-center justify-content-center"
                                            style="width: 36px; height: 36px; background: rgba(40, 199, 111, 0.1);">
                                            <i class="fas fa-phone text-success fs-14"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <small class="text-muted d-block">Phone</small>
                                        <span class="fw-medium fs-13">+91 XXXXXXXXXX</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded d-flex align-items-center justify-content-center"
                                            style="width: 36px; height: 36px; background: rgba(255, 159, 67, 0.1);">
                                            <i class="fas fa-shield-alt" style="color: #ff9f43; font-size: 14px;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <small class="text-muted d-block">Account Type</small>
                                        <span class="fw-medium fs-13">Offline Customer</span>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <a href="{{ route('my-account-edit') }}"
                                class="btn btn-outline-primary btn-sm w-100 rounded-pill">
                                <i class="fas fa-pen me-1"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i class="fas fa-history text-info me-2"></i>Recent Activity
                            </h5>
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="text-center py-5">
                                <div class="mb-3" style="font-size: 48px; opacity: 0.3;">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h6 class="text-muted fw-normal">No recent activity found</h6>
                                <p class="text-muted fs-13 mb-0">Your recent activities will appear here once you start
                                    using the services.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .transition-card {
            transition: all 0.3s ease;
            border-radius: 12px !important;
        }

        .transition-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
            border-color: #667eea !important;
        }

        .card {
            border-radius: 12px;
        }

        .shadow-sm {
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06) !important;
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Display current date
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('en-IN', options);
    </script>
@endsection
