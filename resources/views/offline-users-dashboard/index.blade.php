@extends('offline-users-dashboard/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            @php
                $customer = Auth::guard('customer_web')->user();
            @endphp

            <!-- Welcome Banner -->
            <div class="row my-4">
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
                                        {{-- <a href="{{ route('offline-amc') }}"
                                            class="btn btn-light btn-sm fw-semibold px-4 py-2 rounded-pill shadow-sm">
                                            <i class="fas fa-clipboard-check me-1"></i> View AMC Plans
                                        </a> --}}
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
