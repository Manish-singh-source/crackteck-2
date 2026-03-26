@extends('frontend/layout/master')

@section('main-content')
<section class="tf-sp-2">
    <div class="container" style="max-width: 760px;">
        <div class="order-detail-wrap">
            <h4 class="fw-bold mb-3">Refund Bank Details</h4>
            <p class="text-muted mb-4">Order {{ $order->order_number }} @if($returnOrder) | Return {{ $returnOrder->return_order_number }} @endif</p>

            <form method="POST" action="{{ request()->fullUrl() }}">
                @csrf
                @if ($returnOrder)
                    <input type="hidden" name="return_order_id" value="{{ $returnOrder->id }}">
                @endif
                <div class="mb-3">
                    <label class="form-label">Account Holder Name</label>
                    <input type="text" name="account_holder_name" class="form-control" value="{{ old('account_holder_name', $bankDetail?->account_holder_name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Bank Name</label>
                    <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $bankDetail?->bank_name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Account Number</label>
                    <input type="text" name="account_number" class="form-control" value="{{ old('account_number', $bankDetail?->account_number) }}" required>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">IFSC Code</label>
                        <input type="text" name="ifsc_code" class="form-control" value="{{ old('ifsc_code', $bankDetail?->ifsc_code) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Branch Name</label>
                        <input type="text" name="branch_name" class="form-control" value="{{ old('branch_name', $bankDetail?->branch_name) }}">
                    </div>
                </div>
                <div class="mt-3 mb-4">
                    <label class="form-label">UPI ID</label>
                    <input type="text" name="upi_id" class="form-control" value="{{ old('upi_id', $bankDetail?->upi_id) }}">
                </div>
                <button type="submit" class="btn btn-dark">Submit Refund Details</button>
            </form>
        </div>
    </div>
</section>
@endsection
