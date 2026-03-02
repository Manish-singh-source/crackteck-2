@extends('crm/layouts/master')

@section('content')

<div class="content">

    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Staff Expense</h4>
            </div>
            <div>
                <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data" id="expenseForm">
                            @csrf
                            @method('PUT')
                            <div class="row g-3 pb-3">

                                <div class="col-xl-3 col-lg-6">
                                    <div>
                                        <label class="form-label">Staff Type <span class="text-danger">*</span></label>
                                        <select name="staff_type" id="staff_type" class="form-select" required disabled>
                                            <option value="">-- Select Staff Type --</option>
                                            <option value="engineer" {{ $expense->staff_type == 'engineer' ? 'selected' : '' }}>Engineer</option>
                                            <option value="delivery_man" {{ $expense->staff_type == 'delivery_man' ? 'selected' : '' }}>Delivery Man</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-6">
                                    <div>
                                        <label class="form-label">Staff <span class="text-danger">*</span></label>
                                        <select name="staff_id" id="staff_id" class="form-select" required disabled>
                                            <option value="">-- Select Staff --</option>
                                            @foreach($staff as $staffMember)
                                                <option value="{{ $staffMember->id }}" {{ $expense->staff_id == $staffMember->id ? 'selected' : '' }} data-staff-type="{{ $staffMember->staff_role }}">
                                                    {{ $staffMember->first_name }} {{ $staffMember->last_name }} ({{ $staffMember->staff_code }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-6">
                                    <div>
                                        <label class="form-label">Amount <span class="text-danger">*</span></label>
                                        <input type="number" name="amount" id="amount" class="form-control" value="{{ $expense->amount }}" step="0.01" min="0" required>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-6">
                                    <div>
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-select" required>
                                            <option value="pending" disabled {{ $expense->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="admin_approved" {{ $expense->status == 'admin_approved' ? 'selected' : '' }}>Admin Approved</option>
                                            <option value="admin_rejected" {{ $expense->status == 'admin_rejected' ? 'selected' : '' }}>Admin Rejected</option>
                                            <option value="paid" disabled {{ $expense->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12">
                                    <div>
                                        <label class="form-label">Reason <span class="text-danger">*</span></label>
                                        <textarea name="reason" class="form-control" rows="3" required disabled>{{ $expense->reason }}</textarea>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6">
                                    <div>
                                        <label class="form-label">Receipt</label>
                                        <div class="mt-2 d-flex align-items-center gap-2">
                                            @if($expense->receipt)
                                                <a href="{{ asset('storage/' . $expense->receipt) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fa-solid fa-file"></i> View Receipt
                                                </a>
                                            @else
                                                <span class="text-muted">No Receipt Uploaded</span>
                                            @endif
                                            
                                            @if($expense->status == 'admin_approved')
                                                <button type="button" class="btn btn-success btn-sm" id="payNowBtn">
                                                    <i class="fa-solid fa-money-bill"></i> Pay Now
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" id="actionButtons">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">Update Expense</button>
                                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentStatus = '{{ $expense->status }}';
    const statusSelect = document.getElementById('status');
    const amountInput = document.getElementById('amount');
    const actionButtons = document.getElementById('actionButtons');
    const payNowBtn = document.getElementById('payNowBtn');
    
    // If already paid, disable everything and hide buttons
    if (currentStatus === 'paid') {
        amountInput.disabled = true;
        statusSelect.disabled = true;
        actionButtons.style.display = 'none';
    }
    
    // Pay Now button click handler
    if (payNowBtn) {
        payNowBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to mark this expense as paid?')) {
                const expenseId = '{{ $expense->id }}';
                
                // Call API to update status
                fetch('/api/v1/staff-expenses/' + expenseId + '/status', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: 'paid' })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Disable fields
                        amountInput.disabled = true;
                        statusSelect.disabled = true;
                        actionButtons.style.display = 'none';
                        
                        // Reload page to show updated status
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating status');
                });
            }
        });
    }
});
</script>

@endsection
