@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">AMC Services</h4>
                </div>

            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header border-bottom-dashed d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Active AMC Services</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width:40px;"><input type="checkbox" id="selectAll"></th>
                                <th>Service ID</th>
                                <th>Customer Name</th>
                                <th>Source</th>
                                <th>AMC Plan</th>
                                <th>Duration</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th style="width:120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($amcServices as $service)
                                <tr>
                                    <td><input type="checkbox" class="item-checkbox" name="ids[]"
                                            value="{{ $service->id }}"></td>
                                    <td>
                                        <a href="{{ route('amc-services.view', $service->id) }}">
                                            #AMC-{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $service->full_name }}</div>
                                        <div class="text-muted small">{{ $service->email }}</div>
                                        <div class="text-muted small">{{ $service->phone }}</div>
                                    </td>
                                    <td>
                                        @if ($service->source_type == 'ecommerce_amc_page')
                                            <span class="badge bg-primary">E-commerce AMC Page</span>
                                        @elseif($service->source_type == 'Customer App Amc')
                                            <span class="badge bg-success">Customer App AMC</span>
                                        @elseif($service->source_type == 'admin_panel')
                                            <span class="badge bg-secondary">Admin Panel</span>
                                        @endif
                                    </td>
                                    <td>{{ $service->amcPlan->plan_name ?? 'N/A' }}</td>
                                    <td>{{ $service->plan_duration ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $startDate = \Carbon\Carbon::parse($service->plan_start_date);
                                        @endphp
                                        {{ $startDate->format('d M Y') }}
                                    </td>
                                    <td>
                                        @php
                                            $endDate = null;
                                            if ($service->plan_start_date && $service->plan_duration) {
                                                $startDate = \Carbon\Carbon::parse($service->plan_start_date);
                                                $duration = $service->plan_duration;

                                                // Extract number from duration string
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
                                        {{ $endDate ? $endDate->format('d M Y') : 'N/A' }}
                                    </td>
                                    <td>₹{{ number_format($service->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('amc-services.view', $service->id) }}"
                                            class="btn btn-icon btn-sm bg-primary-subtle me-1" title="View">
                                            <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                        </a>
                                        <a href="{{ route('amc-services.edit', $service->id) }}"
                                            class="btn btn-icon btn-sm bg-warning-subtle me-1" title="Edit">
                                            <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">No active AMC services found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($amcServices->hasPages())
                        <div class="mt-3">
                            {{ $amcServices->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Select all checkbox functionality
            $('#selectAll').change(function() {
                $('.item-checkbox').prop('checked', $(this).prop('checked'));
            });

            // Individual checkbox change
            $('.item-checkbox').change(function() {
                if (!$(this).prop('checked')) {
                    $('#selectAll').prop('checked', false);
                }

                if ($('.item-checkbox:checked').length === $('.item-checkbox').length) {
                    $('#selectAll').prop('checked', true);
                }
            });
        });
    </script>
@endsection
