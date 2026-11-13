@extends('crm.layouts.master')

@section('content')
<div class="content"><div class="container-fluid">
    <div class="py-3 d-flex justify-content-between align-items-center"><h4 class="fs-18 fw-semibold m-0">Staff Wallet Expenses</h4><a href="{{ route('expenses.create') }}" class="btn btn-primary">Add Expense</a></div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="card"><div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3"><select name="staff_id" class="form-select"><option value="">All staff</option>@foreach($staff as $member)<option value="{{ $member->id }}" @selected(request('staff_id') == $member->id)>{{ $member->first_name }} {{ $member->last_name }}</option>@endforeach</select></div>
            <div class="col-md-2"><select name="status" class="form-select"><option value="">All statuses</option>@foreach(['pending'=>'Pending','admin_approved'=>'Approved','admin_rejected'=>'Rejected','paid'=>'Paid'] as $value => $label)<option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>@endforeach</select></div>
            <div class="col-md-2"><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div><div class="col-md-2"><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div><div class="col-md-3"><button class="btn btn-outline-primary">Filter</button> <a href="{{ route('expenses.index') }}" class="btn btn-light">Reset</a></div>
        </form>
        <div class="table-responsive"><table class="table table-striped align-middle"><thead><tr><th>ID</th><th>Staff</th><th>Role</th><th>Amount</th><th>Reason</th><th>Receipt</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead><tbody>
        @forelse($expenses as $expense)
            <tr><td>#{{ $expense->id }}</td><td>{{ $expense->staff?->first_name }} {{ $expense->staff?->last_name }}<small class="d-block text-muted">{{ $expense->staff?->staff_code }}</small></td><td>{{ ucfirst(str_replace('_', ' ', $expense->staff_type)) }}</td><td>₹{{ number_format($expense->amount, 2) }}</td><td>{{ $expense->reason }}</td><td>@if($expense->receipt)<a href="{{ asset('storage/'.$expense->receipt) }}" target="_blank">View</a>@else — @endif</td><td><span class="badge bg-{{ $expense->status === 'paid' ? 'success' : ($expense->status === 'admin_rejected' ? 'danger' : ($expense->status === 'admin_approved' ? 'info' : 'warning')) }}">{{ str_replace('_', ' ', ucfirst($expense->status)) }}</span></td><td>{{ $expense->created_at?->format('d M Y') }}</td><td class="text-nowrap"><a href="{{ route('expenses.view', $expense->id) }}" class="btn btn-sm btn-outline-primary">View</a><a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>@if(in_array($expense->status, ['pending','admin_approved']))<form method="POST" action="{{ route('expenses.status', $expense->id) }}" class="d-inline">@csrf @method('PATCH')<input type="hidden" name="status" value="{{ $expense->status === 'pending' ? 'admin_approved' : 'paid' }}"><button class="btn btn-sm btn-success">{{ $expense->status === 'pending' ? 'Approve' : 'Mark paid' }}</button></form>@endif<form method="POST" action="{{ route('expenses.delete', $expense->id) }}" class="d-inline" onsubmit="return confirm('Delete this expense?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>
        @empty<tr><td colspan="9" class="text-center py-4">No expenses found.</td></tr>@endforelse
        </tbody></table></div>
        {{ $expenses->links() }}
    </div></div>
</div></div>
@endsection
