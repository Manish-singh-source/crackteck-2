@extends('crm/layouts/master')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Cash Received Details</h4>
            </div>
            <div>
                <a href="{{ route('cash-received.index') }}" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="fw-semibold mb-3">Cash Received Information</h5>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Entry ID</label>
                                    <p class="mb-0">{{ $cashReceived->id }}</p>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Amount</label>
                                    <p class="mb-0 fs-5 text-success">₹{{ number_format($cashReceived->amount, 2) }}</p>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Created Date</label>
                                    <p class="mb-0">{{ $cashReceived->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Status</label>
                                    <p class="mb-0">
                                        @if($cashReceived->status == 'customer_paid')
                                            <span class="badge bg-warning">Customer Paid</span>
                                        @else
                                            <span class="badge bg-success">Received by Account Team</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="fw-semibold mb-3">Customer Details</h5>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Name</label>
                                    <p class="mb-0">{{ $cashReceived->customer->first_name ?? '' }} {{ $cashReceived->customer->last_name ?? '' }}</p>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Email</label>
                                    <p class="mb-0">{{ $cashReceived->customer->email ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Phone</label>
                                    <p class="mb-0">{{ $cashReceived->customer->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="fw-semibold mb-3">Staff Details (Who Collected Cash)</h5>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Name</label>
                                    <p class="mb-0">{{ $cashReceived->staff->first_name ?? 'N/A' }} {{ $cashReceived->staff->last_name ?? '' }}</p>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Role</label>
                                    <p class="mb-0">{{ $cashReceived->staff->staff_role ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Phone</label>
                                    <p class="mb-0">{{ $cashReceived->staff->phone ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="fw-semibold mb-3">{{ $type }} Details</h5>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Type</label>
                                    <p class="mb-0">
                                        @if($cashReceived->order_id)
                                            <span class="badge bg-primary">Order</span>
                                        @else
                                            <span class="badge bg-info">Service Request</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Related ID</label>
                                    <p class="mb-0">{{ $relatedId }}</p>
                                </div>
                                
                                @if($cashReceived->order)
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Order Total</label>
                                    <p class="mb-0">₹{{ number_format($cashReceived->order->total_amount ?? 0, 2) }}</p>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Order Status</label>
                                    <p class="mb-0">{{ $cashReceived->order->status ?? 'N/A' }}</p>
                                </div>
                                @endif

                                @if($cashReceived->serviceRequest)
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Service Type</label>
                                    <p class="mb-0">{{ $cashReceived->serviceRequest->service_type ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Service Status</label>
                                    <p class="mb-0">{{ $cashReceived->serviceRequest->status ?? 'N/A' }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($paymentDetails)
                        <hr class="my-3">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="fw-semibold mb-3">Payment Details</h5>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Payment Amount</label>
                                    <p class="mb-0">₹{{ number_format($paymentDetails->amount ?? $paymentDetails->total_amount ?? 0, 2) }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Payment Status</label>
                                    <p class="mb-0">
                                        <span class="badge bg-{{ ($paymentDetails->status ?? $paymentDetails->payment_status) == 'completed' ? 'success' : 'warning' }}">
                                            {{ $paymentDetails->status ?? $paymentDetails->payment_status ?? 'N/A' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small">Payment Method</label>
                                    <p class="mb-0">{{ $paymentDetails->payment_method ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($cashReceived->status == 'customer_paid')
                        <hr class="my-3">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('cash-received.mark-received', $cashReceived->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to mark this cash as received by the Account Team? This will also update the related payment status.');">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="mdi mdi-cash-check"></i> Cash Received to Account Team
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection