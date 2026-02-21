@extends('offline-users-dashboard/layouts/master')

@section('content')
<style>
    .amc-detail-page {
        background: #f5f6fa;
        min-height: 100vh;
    }
    
    .page-header {
        background: white;
        padding: 20px 30px;
        border-bottom: 1px solid #e8e8e8;
        margin: -20px -30px 25px -30px;
    }
    
    .page-header h4 {
        color: #1a1a1a;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .page-header p {
        color: #6c757d;
        margin-bottom: 0;
        font-size: 14px;
    }
    
    .content-card {
        background: white;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .content-card .card-header {
        background: white;
        border-bottom: 1px solid #f0f0f0;
        padding: 16px 20px;
        font-weight: 600;
        color: #1a1a1a;
        font-size: 15px;
    }
    
    .content-card .card-body {
        padding: 20px;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
    }
    
    .info-item .label {
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    
    .info-item .value {
        font-size: 14px;
        color: #1a1a1a;
        font-weight: 500;
    }
    
    .info-item .value.text-muted {
        color: #9ca3af !important;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .status-active { background: #d1fae5; color: #065f46; }
    .status-inactive { background: #fef3c7; color: #92400e; }
    .status-expired, .status-cancelled { background: #fee2e2; color: #991b1b; }
    .status-pending { background: #dbeafe; color: #1e40af; }
    .status-completed { background: #d1fae5; color: #065f46; }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table th {
        background: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e8e8e8;
    }
    
    .data-table td {
        padding: 12px 15px;
        font-size: 14px;
        color: #1a1a1a;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .data-table tbody tr:hover {
        background: #fafafa;
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #4b5563;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        padding: 8px 16px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        transition: all 0.2s;
    }
    
    .back-link:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        color: #1a1a1a;
    }
    
    .service-id {
        /* font-family: 'Courier New', monospace; */
        font-weight: 600;
        color: #1a1a1a;
    }
    
    .price-amount {
        font-size: 18px;
        font-weight: 700;
        color: #059669;
    }
    
    .badge-code {
        background: #f3f4f6;
        padding: 2px 8px;
        border-radius: 4px;
        /* font-family: 'Courier New', monospace; */
        font-size: 12px;
    }
    
    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #e5e7eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
    }
    
    .branch-box {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 15px;
    }
    
    .branch-box h6 {
        color: #1a1a1a;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .breadcrumb-nav {
        background: white;
        padding: 12px 20px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 13px;
    }
    
    .breadcrumb-nav a {
        color: #6b7280;
        text-decoration: none;
    }
    
    .breadcrumb-nav a:hover {
        color: #1a1a1a;
    }
    
    .breadcrumb-nav span {
        color: #9ca3af;
    }
    
    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }
    
    .section-title i {
        color: #6b7280;
    }
</style>

<!-- AMC Service Details -->
<section class="amc-detail-page">
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center my-4">
            <div>
                <h4 class="mb-1">AMC Service Details</h4>
                <p class="mb-0 text-muted">View your AMC service information and history</p>
            </div>
            <a href="{{ route('offline-amc') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Back to AMC List
            </a>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Service ID & Status -->
                <div class="content-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
                            <div>
                                <span class="label d-block">Service ID</span>
                                <span class="service-id">{{ $amcService->request_id }}</span>
                                <p class="mb-0 mt-1" style="font-size: 13px; color: #6c757d;">
                                    Created on {{ $amcService->created_at->format('d M Y, h:i A') }}
                                </p>
                            </div>
                            <div>
                                @php
                                    $statusClass = match ($amcService->status) {
                                        'inactive' => 'status-inactive',
                                        'active' => 'status-active',
                                        'expired' => 'status-expired',
                                        'cancelled' => 'status-cancelled',
                                        default => 'status-pending',
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    {{ ucwords(str_replace('_', ' ', $amcService->status ?? 'Pending')) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="content-card">
                    <div class="card-header">
                        <div class="section-title">
                            <i class="fas fa-user"></i>
                            Customer Information
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="label">Full Name</span>
                                <span class="value">
                                    {{ $amcService->customer->first_name ?? '' }}
                                    {{ $amcService->customer->last_name ?? '' }}
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="label">Email</span>
                                <span class="value">{{ $amcService->customer->email ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Phone</span>
                                <span class="value">{{ $amcService->customer->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Date of Birth</span>
                                <span class="value">
                                    {{ $amcService->customer->dob ? \Carbon\Carbon::parse($amcService->customer->dob)->format('d M Y') : 'N/A' }}
                                </span>
                            </div>
                            @if ($amcService->customer && $amcService->customer->companyDetails)
                                <div class="info-item">
                                    <span class="label">Company</span>
                                    <span class="value">{{ $amcService->customer->companyDetails->company_name ?? 'N/A' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Company Address</span>
                                    <span class="value">
                                        {{ $amcService->customer->companyDetails->comp_address1 ?? 'N/A' }}
                                        @if($amcService->customer->companyDetails->comp_address2)
                                            , {{ $amcService->customer->companyDetails->comp_address2 }}
                                        @endif
                                        <br>
                                        {{ $amcService->customer->companyDetails->comp_city ?? '' }}
                                        @if($amcService->customer->companyDetails->comp_state)
                                            , {{ $amcService->customer->companyDetails->comp_state }}
                                        @endif
                                        @if($amcService->customer->companyDetails->comp_pincode)
                                            - {{ $amcService->customer->companyDetails->comp_pincode }}
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="label">GST Number</span>
                                    <span class="value">{{ $amcService->customer->companyDetails->gst_no ?? 'N/A' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- AMC Plan Details -->
                <div class="content-card">
                    <div class="card-header">
                        <div class="section-title">
                            <i class="fas fa-file-contract"></i>
                            AMC Plan Details
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="label">Plan Name</span>
                                <span class="value">{{ $amcService->amcPlan->plan_name ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Start Date</span>
                                <span class="value">{{ $amcService->created_at ? $amcService->created_at->format('d M Y') : 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Plan Type</span>
                                <span class="value">AMC Service</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Priority Level</span>
                                <span class="value">Normal</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Duration</span>
                                <span class="value">{{ $amcService->amcPlan->duration ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">End Date</span>
                                <span class="value">
                                    @php
                                        $endDate = null;
                                        if ($amcService->created_at && $amcService->amcPlan->duration) {
                                            $startDate = \Carbon\Carbon::parse($amcService->created_at);
                                            $duration = $amcService->amcPlan->duration;
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
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="label">Total Visits</span>
                                <span class="value">{{ $amcService->amcPlan->total_visits ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Total Amount</span>
                                <span class="price-amount">₹{{ number_format($amcService->amcPlan->total_cost ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Branches -->
                @if ($amcService->customer && $amcService->customer->branches && $amcService->customer->branches->count() > 0)
                    <div class="content-card">
                        <div class="card-header">
                            <div class="section-title">
                                <i class="fas fa-map-marker-alt"></i>
                                Service Locations ({{ $amcService->customer->branches->count() }})
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($amcService->customer->branches as $index => $branch)
                                    <div class="col-md-6 mb-3">
                                        <div class="branch-box">
                                            <h6>{{ $branch->branch_name ?? 'Branch ' . ($index + 1) }}</h6>
                                            <p class="mb-0 text-muted" style="font-size: 13px;">
                                                {{ $branch->address1 }}
                                                @if($branch->address2), {{ $branch->address2 }}@endif
                                                <br>
                                                {{ $branch->city }}, {{ $branch->state }} - {{ $branch->pincode }}
                                                <br>
                                                {{ $branch->country }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Products Information -->
                <div class="content-card">
                    <div class="card-header">
                        <div class="section-title">
                            <i class="fas fa-box"></i>
                            Products ({{ $amcService->amc_products_count }})
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if ($amcService->amcProducts->isEmpty())
                            <div class="text-center py-4 text-muted">
                                No products added
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Type</th>
                                            <th>Brand</th>
                                            <th>Model No</th>
                                            <th>SKU</th>
                                            <th>HSN</th>
                                            <th>Purchase Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($amcService->amcProducts as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->name ?? ($product->item_name ?? 'N/A') }}</td>
                                                <td>{{ $product->type ?? '-' }}</td>
                                                <td>{{ $product->brand ?? '-' }}</td>
                                                <td>{{ $product->model_no ?? '-' }}</td>
                                                <td><span class="badge-code">{{ $product->sku ?? '-' }}</span></td>
                                                <td>{{ $product->hsn ?? '-' }}</td>
                                                <td>{{ $product->purchase_date ? \Carbon\Carbon::parse($product->purchase_date)->format('d M Y') : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Service History -->
                @if ($amcService->amcScheduleMeetings && $amcService->amcScheduleMeetings->count() > 0)
                    <div class="content-card">
                        <div class="card-header">
                            <div class="section-title">
                                <i class="fas fa-history"></i>
                                Service History ({{ $amcService->amcScheduleMeetings->count() }})
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Engineer Name</th>
                                            <th>Visit Date</th>
                                            <th>Issue Type</th>
                                            <th>Report</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($amcService->amcScheduleMeetings as $index => $meeting)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    {{ $meeting->activeAssignment->engineer->first_name ?? 'N/A' }}
                                                    {{ $meeting->activeAssignment->engineer->last_name ?? '' }}
                                                </td>
                                                <td>{{ $meeting->scheduled_at ? \Carbon\Carbon::parse($meeting->scheduled_at)->format('d M Y') : 'N/A' }}</td>
                                                <td>Maintenance</td>
                                                <td>NA</td>
                                                <td>
                                                    @php
                                                        $meetingStatusClass = match ($meeting->status) {
                                                            'Pending' => 'status-pending',
                                                            'Completed' => 'status-completed',
                                                            'Cancelled' => 'status-cancelled',
                                                            'In Progress' => 'status-active',
                                                            default => 'status-inactive',
                                                        };
                                                    @endphp
                                                    <span class="status-badge {{ $meetingStatusClass }}">
                                                        {{ $meeting->status ?? 'N/A' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Additional Notes -->
                @if ($amcService->additional_notes)
                    <div class="content-card">
                        <div class="card-header">
                            <div class="section-title">
                                <i class="fas fa-sticky-note"></i>
                                Additional Notes
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-0" style="font-size: 14px; color: #4b5563;">
                                {{ $amcService->additional_notes }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
