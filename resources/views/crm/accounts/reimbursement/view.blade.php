@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">View Staff Expense</h4>
                </div>
                <div>
                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">
                                            <i class="fa-solid fa-edit"></i> Edit
                                        </a>
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Expense Details
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush ">

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Staff Type :
                                            </span>
                                            <span>
                                                @if ($expense->staff_type == 'engineer')
                                                    <span class="">Engineer</span>
                                                @elseif($expense->staff_type == 'delivery_man')
                                                    <span class="">Delivery Man</span>
                                                @else
                                                    {{ ucfirst($expense->staff_type) }}
                                                @endif
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Staff Name :
                                            </span>
                                            <span>
                                                @if ($expense->staff)
                                                    {{ $expense->staff->first_name }} {{ $expense->staff->last_name }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Reason :
                                            </span>
                                            <span>
                                                {{ $expense->reason }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Date :
                                            </span>
                                            <span>
                                                {{ date('d-m-Y H:i:s', strtotime($expense->created_at)) }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush ">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Staff Code :
                                            </span>
                                            <span>
                                                @if ($expense->staff)
                                                    {{ $expense->staff->staff_code }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Amount :
                                            </span>
                                            <span>
                                                ₹{{ number_format($expense->amount, 2) }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Status :
                                            </span>
                                            <span>
                                                @if ($expense->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($expense->status == 'admin_approved')
                                                    <span class="badge bg-success">Admin Approved</span>
                                                @elseif($expense->status == 'admin_rejected')
                                                    <span class="badge bg-danger">Admin Rejected</span>
                                                @elseif($expense->status == 'paid')
                                                    <span class="badge bg-info">Paid</span>
                                                @endif
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Receipt :
                                            </span>
                                            <span>
                                                @if ($expense->receipt)
                                                    <a href="{{ asset('storage/' . $expense->receipt) }}" target="_blank"
                                                        class="btn btn-outline-primary">
                                                        <i class="fa-solid fa-file"></i> View Receipt
                                                    </a>
                                                @else
                                                    <span class="text-muted">No Receipt Uploaded</span>
                                                @endif
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
