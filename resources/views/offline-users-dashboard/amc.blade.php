@extends('offline-users-dashboard/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">AMC Service Requests</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">AMC</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('amc') }}" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                        <i class="fas fa-plus me-1"></i> New Request
                    </a>
                </div>
            </div>

            <!-- AMC Stats Summary -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px; background: rgba(102, 126, 234, 0.15);">
                                        <i class="fas fa-clipboard-list fs-20 text-primary"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    {{-- <h4 class="fw-bold mb-0">{{ $servicesRequest->count() }}</h4> --}}
                                    <h4 class="fw-bold mb-0">Service Request (1)</h4>
                                    <small class="text-muted">Total Requests</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px; background: rgba(40, 199, 111, 0.15);">
                                        <i class="fas fa-check-circle fs-20" style="color: #28c76f;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    {{-- <h4 class="fw-bold mb-0">{{ $servicesRequest->where('amc_status', 'Active')->count() }}</h4> --}}
                                    <small class="text-muted">Active</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px; background: rgba(255, 159, 67, 0.15);">
                                        <i class="fas fa-clock fs-20" style="color: #ff9f43;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    {{-- <h4 class="fw-bold mb-0">{{ $servicesRequest->where('amc_status', 'Inactive')->count() }}</h4> --}}
                                    <small class="text-muted">Inactive</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px; background: rgba(234, 84, 85, 0.15);">
                                        <i class="fas fa-times-circle fs-20" style="color: #ea5455;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    {{-- <h4 class="fw-bold mb-0">{{ $servicesRequest->where('amc_status', 'Expired')->count() }}</h4> --}}
                                    <small class="text-muted">Expired</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AMC Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i class="fas fa-clipboard-check text-primary me-2"></i>All AMC Requests
                            </h5>
                            <div class="d-flex gap-2">
                                <span class="badge bg-light text-dark border px-3 py-2 fs-12">
                                    {{-- <i class="fas fa-list me-1"></i> {{ $servicesRequest->count() }} Records --}}
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            hello
                            {{-- @if ($servicesRequest->isEmpty())
                                <div class="text-center py-5">
                                    <div class="mb-3" style="font-size: 60px; opacity: 0.2;">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mb-2">No AMC Service Requests Yet</h5>
                                    <p class="text-muted fs-13 mb-4">You haven't submitted any AMC service requests yet. Get started by creating your first request.</p>
                                    <a href="{{ route('amc') }}" class="btn btn-primary btn-sm rounded-pill px-4">
                                        <i class="fas fa-plus me-1"></i> Submit Your First Request
                                    </a>
                                </div>
                            @else
                                <!-- Desktop Table View -->
                                <div class="table-responsive d-none d-md-block">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="fw-semibold text-muted fs-13 py-3 ps-4">#</th>
                                                <th class="fw-semibold text-muted fs-13 py-3">Service ID</th>
                                                <th class="fw-semibold text-muted fs-13 py-3">Products</th>
                                                <th class="fw-semibold text-muted fs-13 py-3">Plan Name</th>
                                                <th class="fw-semibold text-muted fs-13 py-3">Start Date</th>
                                                <th class="fw-semibold text-muted fs-13 py-3">End Date</th>
                                                <th class="fw-semibold text-muted fs-13 py-3">Status</th>
                                                <th class="fw-semibold text-muted fs-13 py-3 text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($servicesRequest as $index => $service)
                                                <tr>
                                                    <td class="ps-4">
                                                        <span class="text-muted fs-13">{{ $index + 1 }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-semibold text-primary">{{ $service->request_id }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info-subtle text-info rounded-pill px-3 py-1">
                                                            <i class="fas fa-box me-1"></i>{{ $service->products->count() }} Product(s)
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-medium">{{ $service->amcPlan->plan_name ?? 'N/A' }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-13">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            {{ $service->created_at ? $service->created_at->format('d M Y') : 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $startDate = $service->created_at;
                                                            $durationMonths = $service->amcPlan->duration ?? 0;
                                                            $endDate = $startDate ? $startDate->copy()->addMonths($durationMonths) : null;
                                                        @endphp
                                                        <span class="text-muted fs-13">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            {{ $endDate ? $endDate->format('d M Y') : 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusConfig = match ($service->amc_status) {
                                                                'Active' => ['class' => 'bg-success-subtle text-success', 'icon' => 'fa-check-circle'],
                                                                'Inactive' => ['class' => 'bg-warning-subtle text-warning', 'icon' => 'fa-clock'],
                                                                'Expired' => ['class' => 'bg-danger-subtle text-danger', 'icon' => 'fa-times-circle'],
                                                                'Cancelled' => ['class' => 'bg-danger-subtle text-danger', 'icon' => 'fa-ban'],
                                                                default => ['class' => 'bg-secondary-subtle text-secondary', 'icon' => 'fa-question-circle'],
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $statusConfig['class'] }} rounded-pill px-3 py-1">
                                                            <i class="fas {{ $statusConfig['icon'] }} me-1"></i>
                                                            {{ ucwords(str_replace('_', ' ', $service->amc_status)) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('my-account-amc.view', $service->id) }}"
                                                           class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                            <i class="fas fa-eye me-1"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Mobile Card View -->
                                <div class="d-md-none p-3">
                                    @foreach ($servicesRequest as $index => $service)
                                        <div class="card border mb-3 shadow-sm">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div>
                                                        <span class="fw-bold text-primary fs-14">{{ $service->request_id }}</span>
                                                        <br>
                                                        <small class="text-muted">{{ $service->amcPlan->plan_name ?? 'N/A' }}</small>
                                                    </div>
                                                    @php
                                                        $statusConfig = match ($service->amc_status) {
                                                            'Active' => ['class' => 'bg-success-subtle text-success', 'icon' => 'fa-check-circle'],
                                                            'Inactive' => ['class' => 'bg-warning-subtle text-warning', 'icon' => 'fa-clock'],
                                                            'Expired' => ['class' => 'bg-danger-subtle text-danger', 'icon' => 'fa-times-circle'],
                                                            'Cancelled' => ['class' => 'bg-danger-subtle text-danger', 'icon' => 'fa-ban'],
                                                            default => ['class' => 'bg-secondary-subtle text-secondary', 'icon' => 'fa-question-circle'],
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $statusConfig['class'] }} rounded-pill px-3 py-1">
                                                        <i class="fas {{ $statusConfig['icon'] }} me-1"></i>
                                                        {{ ucwords(str_replace('_', ' ', $service->amc_status)) }}
                                                    </span>
                                                </div>

                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Products</small>
                                                        <span class="badge bg-info-subtle text-info rounded-pill px-2 py-1 fs-12">
                                                            <i class="fas fa-box me-1"></i>{{ $service->products->count() }} Product(s)
                                                        </span>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Start Date</small>
                                                        <span class="fs-13 fw-medium">
                                                            {{ $service->created_at ? $service->created_at->format('d M Y') : 'N/A' }}
                                                        </span>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">End Date</small>
                                                        @php
                                                            $startDate = $service->created_at;
                                                            $durationMonths = $service->amcPlan->duration ?? 0;
                                                            $endDate = $startDate ? $startDate->copy()->addMonths($durationMonths) : null;
                                                        @endphp
                                                        <span class="fs-13 fw-medium">
                                                            {{ $endDate ? $endDate->format('d M Y') : 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <a href="{{ route('my-account-amc.view', $service->id) }}"
                                                   class="btn btn-sm btn-outline-primary rounded-pill w-100">
                                                    <i class="fas fa-eye me-1"></i> View Details
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.04) !important;
        }
        .table th {
            border-top: none;
            white-space: nowrap;
        }
        .table td {
            vertical-align: middle;
            white-space: nowrap;
        }
        .card {
            border-radius: 12px;
        }
        .shadow-sm {
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06) !important;
        }
    </style>
@endsection
