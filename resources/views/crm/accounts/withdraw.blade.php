@extends('crm.layouts.master')

@section('content')
<div class="content"><div class="container-fluid">
    <div class="py-3"><h4 class="fs-18 fw-semibold m-0">Staff Payout Requests</h4></div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <div class="card mb-3"><div class="card-body"><h5 class="card-title">Create Payout Request</h5>
        <form method="POST" action="{{ route('withdraw.store') }}" class="row g-3">@csrf
            <div class="col-md-4"><label class="form-label">Staff</label><select name="staff_id" class="form-select" required><option value="">Select staff</option>@foreach($staff as $member)<option value="{{ $member->id }}" @selected(old('staff_id') == $member->id)>{{ $member->first_name }} {{ $member->last_name }} — {{ $member->staff_role }}</option>@endforeach</select></div>
            <div class="col-md-2"><label class="form-label">Amount</label><input name="amount" type="number" min="1" step="0.01" value="{{ old('amount') }}" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Payout method</label><select name="payout_method" class="form-select" required><option value="cash">Cash</option><option value="upi" @selected(old('payout_method') === 'upi')>UPI</option><option value="bank_transfer" @selected(old('payout_method') === 'bank_transfer')>Bank transfer</option></select></div>
            <div class="col-md-3"><label class="form-label">UPI / bank details</label><input name="payout_details" value="{{ old('payout_details') }}" class="form-control" placeholder="Required except cash"></div>
            <div class="col-md-9"><label class="form-label">Reason</label><input name="reason" value="{{ old('reason') }}" maxlength="500" class="form-control" required></div>
            <div class="col-md-3 d-flex align-items-end"><button class="btn btn-primary w-100">Submit request</button></div>
        </form>
    </div></div>

    <div class="card"><div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3"><select name="staff_id" class="form-select"><option value="">All staff</option>@foreach($staff as $member)<option value="{{ $member->id }}" @selected(request('staff_id') == $member->id)>{{ $member->first_name }} {{ $member->last_name }}</option>@endforeach</select></div>
            <div class="col-md-2"><select name="status" class="form-select"><option value="">All statuses</option>@foreach(['pending','approved','rejected','paid'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>@endforeach</select></div>
            <div class="col-md-2"><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div><div class="col-md-2"><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div><div class="col-md-3"><button class="btn btn-outline-primary">Filter</button> <a href="{{ route('withdraw') }}" class="btn btn-light">Reset</a></div>
        </form>
        <div class="table-responsive"><table class="table table-striped align-middle"><thead><tr><th>Request</th><th>Staff</th><th>Amount</th><th>Method</th><th>Reason</th><th>Status</th><th>Requested</th><th>Action</th></tr></thead><tbody>
        @forelse($withdrawals as $withdrawal)
            <tr><td>{{ $withdrawal->withdrawal_no }}</td><td>{{ $withdrawal->staff?->first_name }} {{ $withdrawal->staff?->last_name }}<small class="d-block text-muted">{{ $withdrawal->requester_role }}</small></td><td>₹{{ number_format($withdrawal->amount, 2) }}</td><td>{{ strtoupper(str_replace('_', ' ', $withdrawal->payout_method)) }}<small class="d-block text-muted">{{ $withdrawal->payout_details }}</small></td><td>{{ $withdrawal->reason }}</td><td><span class="badge bg-{{ $withdrawal->status === 'paid' ? 'success' : ($withdrawal->status === 'rejected' ? 'danger' : ($withdrawal->status === 'approved' ? 'info' : 'warning')) }}">{{ ucfirst($withdrawal->status) }}</span>@if($withdrawal->rejection_reason)<small class="d-block text-danger">{{ $withdrawal->rejection_reason }}</small>@endif</td><td>{{ $withdrawal->requested_at?->format('d M Y, h:i A') }}</td><td>@if($withdrawal->status === 'pending')<form method="POST" action="{{ route('withdraw.status', $withdrawal) }}" class="d-inline">@csrf @method('PATCH')<input type="hidden" name="status" value="approved"><button class="btn btn-sm btn-success">Approve</button></form><button class="btn btn-sm btn-outline-danger" data-bs-toggle="collapse" data-bs-target="#reject-{{ $withdrawal->id }}">Reject</button><form id="reject-{{ $withdrawal->id }}" class="collapse mt-1" method="POST" action="{{ route('withdraw.status', $withdrawal) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="rejected"><input required name="rejection_reason" class="form-control form-control-sm mb-1" placeholder="Rejection reason"><button class="btn btn-sm btn-danger">Confirm</button></form>@elseif($withdrawal->status === 'approved')<form method="POST" action="{{ route('withdraw.status', $withdrawal) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="paid"><input required name="payment_reference" class="form-control form-control-sm mb-1" placeholder="UTR / payment reference"><button class="btn btn-sm btn-primary">Mark paid</button></form>@else<span class="text-muted">{{ $withdrawal->payment_reference ?: 'Finalized' }}</span>@endif</td></tr>
        @empty<tr><td colspan="8" class="text-center py-4">No payout requests found.</td></tr>@endforelse
        </tbody></table></div>
        {{ $withdrawals->links() }}
    </div></div>
</div></div>
@endsection
