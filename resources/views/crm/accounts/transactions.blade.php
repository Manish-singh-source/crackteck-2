@extends('crm.layouts.master')

@section('title', 'Transactions - CRM')

@section('styles')
<style>
    .transaction-type-badge {
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }
    .type-order { background-color: #e3f2fd; color: #1976d2; }
    .type-amc { background-color: #f3e5f5; color: #7b1fa2; }
    .type-service { background-color: #e8f5e9; color: #388e3c; }
    .type-cash { background-color: #fff3e0; color: #f57c00; }
    .type-vendor_po { background-color: #fce4ec; color: #c2185b; }
    
    .status-badge {
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }
    .status-completed, .status-captured, .status-received { background-color: #d4edda; color: #155724; }
    .status-pending, .status-processing { background-color: #fff3cd; color: #856404; }
    .status-failed, .status-rejected, .status-cancelled { background-color: #f8d7da; color: #721c24; }
    .status-refunded { background-color: #d1ecf1; color: #0c5460; }
    .status-approved { background-color: #d4edda; color: #155724; }
    .status-customer_paid { background-color: #cce5ff; color: #004085; }
    .status-created { background-color: #e2e3e5; color: #383d41; }
    .status-partial_paid { background-color: #fff3cd; color: #856404; }
    
    .filter-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .stats-card {
        border-radius: 8px;
        padding: 15px;
        color: white;
    }

    .stats-card.order { background: linear-gradient(135deg, #1976d2, #42a5f5); }
    .stats-card.amc { background: linear-gradient(135deg, #7b1fa2, #ba68c8); }
    .stats-card.service { background: linear-gradient(135deg, #388e3c, #66bb6a); }
    .stats-card.cash { background: linear-gradient(135deg, #f57c00, #ffb74d); }
    .stats-card.vendor { background: linear-gradient(135deg, #c2185b, #f06292); }
    .stats-card.total { background: linear-gradient(135deg, #455a64, #78909c); }
</style>
@endsection

@section('content')

<div class="content py-3">
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Transactions</h4>
                <p class="text-muted mb-0">View all financial transactions across the system</p>
            </div>
            <div class="text-end">
                <a href="{{ route('transactions.export', request()->query()) }}" class="btn btn-success btn-sm">
                    <i class="ri-download-line me-1"></i> Export CSV
                </a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="stats-card order">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs text-white-75">Order Payments</div>
                            <div class="fs-20 fw-bold">{{ number_format($counts['order'] ?? 0) }}</div>
                        </div>
                        <div class="fs-24 opacity-50">📦</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card amc">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs text-white-75">AMC Payments</div>
                            <div class="fs-20 fw-bold">{{ number_format($counts['amc'] ?? 0) }}</div>
                        </div>
                        <div class="fs-24 opacity-50">🛡️</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card service">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs text-white-75">Service Payments</div>
                            <div class="fs-20 fw-bold">{{ number_format($counts['service'] ?? 0) }}</div>
                        </div>
                        <div class="fs-24 opacity-50">🔧</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card cash">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs text-white-75">Cash Received</div>
                            <div class="fs-20 fw-bold">{{ number_format($counts['cash'] ?? 0) }}</div>
                        </div>
                        <div class="fs-24 opacity-50">💵</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card vendor">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs text-white-75">Vendor PO</div>
                            <div class="fs-20 fw-bold">{{ number_format($counts['vendor_po'] ?? 0) }}</div>
                        </div>
                        <div class="fs-24 opacity-50">🏪</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card total">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs text-white-75">Total</div>
                            <div class="fs-20 fw-bold">{{ number_format($counts['total'] ?? 0) }}</div>
                        </div>
                        <div class="fs-24 opacity-50">📊</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        {{-- <div class="filter-card">
            <form method="GET" action="{{ route('transactions') }}" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label text-muted small">Search</label>
                    <input type="text" name="search" class="form-control form-control-sm" 
                           placeholder="Customer name, Order ID, Service ID" value="{{ $search ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label text-muted small">Transaction Type</label>
                    <select name="type" class="form-control form-control-sm">
                        <option value="">All Types</option>
                        @foreach($transactionTypes as $key => $label)
                            <option value="{{ $key }}" {{ ($filters['transaction_type'] ?? '') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label text-muted small">Status</label>
                    <select name="status" class="form-control form-control-sm">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ ($filters['status'] ?? '') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label text-muted small">Date From</label>
                    <input type="date" name="date_from" class="form-control form-control-sm" 
                           value="{{ $filters['date_from'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label text-muted small">Date To</label>
                    <input type="date" name="date_to" class="form-control form-control-sm" 
                           value="{{ $filters['date_to'] ?? '' }}">
                </div>
                <div class="col-md-1">
                    <label class="form-label text-muted small">Per Page</label>
                    <select name="per_page" class="form-control form-control-sm">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="ri-filter-3-line"></i> Filter
                    </button>
                </div>
            </form>
        </div> --}}

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body py-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap table-striped table-borderless dt-responsive nowrap"
                                   id="responsive-datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="all">ID</th>
                                        <th class="all">Type</th>
                                        {{-- <th class="all">Reference</th> --}}
                                        <th>Customer / Vendor</th>
                                        {{-- <th>Staff</th> --}}
                                        <th class="text-end">Amount</th>
                                        <th>Status</th>
                                        <th>Mode</th>
                                        <th class="all">Date</th>
                                        <th class="all">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $index => $transaction)
                                        <tr>
                                            <td>
                                                <span class="text-muted">#{{ $index + 1 }}</span>
                                            </td>
                                            <td>
                                                <span class="transaction-type-badge type-{{ $transaction->transaction_type }}">
                                                    @switch($transaction->transaction_type)
                                                        @case('order') Order @break
                                                        @case('amc') AMC @break
                                                        @case('service') Service @break
                                                        @case('cash') Cash @break
                                                        @case('vendor_po') Vendor PO @break
                                                        @default {{ ucfirst($transaction->transaction_type) }}
                                                    @endswitch
                                                </span>
                                            </td>
                                            {{-- <td>
                                                @if($transaction->transaction_type == 'order')
                                                    <a href="{{ route('order.view', $transaction->reference_id) }}" class="text-decoration-none">
                                                        #{{ $transaction->reference_id }}
                                                    </a>
                                                @elseif($transaction->transaction_type == 'amc')
                                                    <a href="{{ route('amcs-request.view', $transaction->reference_id) }}" class="text-decoration-none">
                                                        #{{ $transaction->reference_id }}
                                                    </a>
                                                @elseif($transaction->transaction_type == 'service')
                                                    <a href="{{ route('service-request.view-quick-service-request', $transaction->reference_id) }}" class="text-decoration-none">
                                                        #{{ $transaction->reference_id }}
                                                    </a>
                                                @elseif($transaction->transaction_type == 'cash')
                                                    #{{ $transaction->reference_id ?? 'N/A' }}
                                                @elseif($transaction->transaction_type == 'vendor_po')
                                                    <a href="{{ route('pay-to-vendors.view', $transaction->id) }}" class="text-decoration-none">
                                                        #PO{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                @else
                                                    #{{ $transaction->reference_id ?? 'N/A' }}
                                                @endif
                                            </td> --}}
                                            <td>
                                                @if($transaction->transaction_type == 'vendor_po')
                                                    @if(isset($transaction->vendor_name))
                                                        <span class="text-danger">{{ $transaction->vendor_name }}</span>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                @else
                                                    @if(isset($transaction->customer_name))
                                                        <span class="text-primary">{{ $transaction->customer_name }}</span>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                @endif
                                            </td>
                                            {{-- <td>
                                                @if(isset($transaction->staff_id) && $transaction->staff_id)
                                                    <span class="text-info">{{ $transaction->staff_name ?? 'Staff #' . $transaction->staff_id }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td> --}}
                                            <td class="text-end">
                                                <span class="fw-semibold text-success">
                                                    ₹{{ number_format($transaction->amount, 2) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge status-{{ $transaction->status }}">
                                                    @switch($transaction->status)
                                                        @case('completed') Completed @break
                                                        @case('captured') Captured @break
                                                        @case('received') Received @break
                                                        @case('pending') Pending @break
                                                        @case('processing') Processing @break
                                                        @case('failed') Failed @break
                                                        @case('refunded') Refunded @break
                                                        @case('approved') Approved @break
                                                        @case('rejected') Rejected @break
                                                        @case('cancelled') Cancelled @break
                                                        @case('created') Created @break
                                                        @case('partial_paid') Partial Paid @break
                                                        @case('customer_paid') Customer Paid @break
                                                        @default {{ ucfirst($transaction->status) }}
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td>
                                                @if($transaction->payment_mode)
                                                    <span class="text-muted small">
                                                        @switch($transaction->payment_mode)
                                                            @case('online') Online @break
                                                            @case('cash') Cash @break
                                                            @case('cod') COD @break
                                                            @case('cheque') Cheque @break
                                                            @case('bank_transfer') Bank Transfer @break
                                                            @case('upi') UPI @break
                                                            @default {{ ucfirst($transaction->payment_mode) }}
                                                        @endswitch
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y') }}</div>
                                                <div class="text-muted small">{{ \Carbon\Carbon::parse($transaction->created_at)->format('h:i A') }}</div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-light" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#transactionModal{{ $transaction->id }}">
                                                    <i class="ri-eye-line"></i> View
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Transaction Detail Modal -->
                                        <div class="modal fade" id="transactionModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="transactionModalLabel{{ $transaction->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="transactionModalLabel{{ $transaction->id }}">
                                                            Transaction Details #{{ $index + 1 }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body m-3">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label text-muted small">Transaction Type</label>
                                                                    <p class="fw-semibold">
                                                                        <span class="transaction-type-badge type-{{ $transaction->transaction_type }}">
                                                                            @switch($transaction->transaction_type)
                                                                                @case('order') Order Payment @break
                                                                                @case('amc') AMC Payment @break
                                                                                @case('service') Service Payment @break
                                                                                @case('cash') Cash Received @break
                                                                                @case('vendor_po') Vendor PO @break
                                                                                @default {{ ucfirst($transaction->transaction_type) }}
                                                                            @endswitch
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label text-muted small">Source Table</label>
                                                                    <p class="fw-semibold">{{ $transaction->source_table }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label text-muted small">Amount</label>
                                                                    <p class="fw-semibold text-success fs-5">₹{{ number_format($transaction->amount, 2) }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label text-muted small">Status</label>
                                                                    <p>
                                                                        <span class="status-badge status-{{ $transaction->status }}">
                                                                            {{ ucfirst($transaction->status) }}
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label text-muted small">Reference ID</label>
                                                                    <p class="fw-semibold">#{{ $transaction->reference_id ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label text-muted small">Payment Mode</label>
                                                                    <p class="fw-semibold">{{ $transaction->payment_mode ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label text-muted small">Created At</label>
                                                                    <p class="fw-semibold">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y, h:i A') }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="ri-inbox-line fs-48 mb-2 d-block"></i>
                                                    No transactions found
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        {{-- @if($transactions->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted">
                                    Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} 
                                    of {{ $transactions->total() }} entries
                                </div>
                                <nav>
                                    <ul class="pagination pagination-split mb-0">
                                        {{ $transactions->appends(request()->query())->links() }}
                                    </ul>
                                </nav>
                            </div>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->
</div>

@push('scripts')
<script>
    // Initialize DataTable if needed
    $(document).ready(function() {
        // Custom handling if using DataTables
    });
</script>
@endpush

@endsection
