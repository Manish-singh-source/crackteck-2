@extends('crm/layouts/master')

@section('content')
    <style>
        .table-top-head {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            justify-content: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
        }

        .table-top-head span {
            list-style: none;
            margin-right: 8px;
            flex-shrink: 0;
        }

        .table-top-head span a {
            height: 35px;
            width: 35px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            justify-content: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            border: 1px solid #E6EAED;
            background: #ffffff;
            border-radius: 5px;
            padding: 4px;
            cursor: pointer;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending {
            background-color: #FFF3CD;
            color: #856404;
        }

        .status-admin_approved {
            background-color: #D4EDDA;
            color: #155724;
        }

        .status-admin_rejected {
            background-color: #F8D7DA;
            color: #721C24;
        }

        .status-paid {
            background-color: #CCE5FF;
            color: #004085;
        }
    </style>
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Staff Wallet Reimbursement</h4>
                </div>
                <div>
                    <a href="{{ route('reimbursement.create') }}" class="btn btn-primary">Add Reimbursement</a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active p-2" id="all_reimbursement_tab" data-bs-toggle="tab"
                                            href="#all_reimbursement" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                            <span class="d-none d-sm-block">All Reimbursement</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>

                            <div class="tab-content text-muted">

                                <div class="tab-pane active show" id="all_reimbursement" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">

                                                        <thead>
                                                            <tr>
                                                                <td>ID</td>
                                                                <td>Staff Type</td>
                                                                <td>Staff Name</td>
                                                                <td>Staff Code</td>
                                                                <td>Amount</td>
                                                                <td>Reason</td>
                                                                <td>Receipt</td>
                                                                <td>Status</td>
                                                                <td>Date</td>
                                                                <td>Actions</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($reimbursements as $reimbursement)
                                                                <tr class="align-middle">
                                                                    <td>{{ $reimbursement->id }}</td>
                                                                    <td>
                                                                        @if ($reimbursement->staff_type == 'engineer')
                                                                            <span class="badge bg-primary">Engineer</span>
                                                                        @elseif($reimbursement->staff_type == 'delivery_man')
                                                                            <span class="badge bg-info">Delivery Man</span>
                                                                        @else
                                                                            <span
                                                                                class="badge bg-secondary">{{ ucfirst($reimbursement->staff_type) }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($reimbursement->staff)
                                                                            {{ $reimbursement->staff->first_name }}
                                                                            {{ $reimbursement->staff->last_name }}
                                                                        @else
                                                                            N/A
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($reimbursement->staff)
                                                                            {{ $reimbursement->staff->staff_code }}
                                                                        @else
                                                                            N/A
                                                                        @endif
                                                                    </td>
                                                                    <td>₹{{ number_format($reimbursement->amount, 2) }}</td>
                                                                    <td>{{ Str::limit($reimbursement->reason, 50) }}</td>
                                                                    <td>
                                                                        @if ($reimbursement->receipt)
                                                                            <a href="{{ asset('storage/' . $reimbursement->receipt) }}"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-outline-primary">View</a>
                                                                        @else
                                                                            <span class="text-muted">No Receipt</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="status-badge status-{{ $reimbursement->status }}">
                                                                            @if ($reimbursement->status == 'pending')
                                                                                Pending
                                                                            @elseif($reimbursement->status == 'admin_approved')
                                                                                Admin Approved
                                                                            @elseif($reimbursement->status == 'admin_rejected')
                                                                                Admin Rejected
                                                                            @elseif($reimbursement->status == 'paid')
                                                                                Paid
                                                                            @endif
                                                                        </span>
                                                                    </td>
                                                                    <td>{{ date('d-m-Y', strtotime($reimbursement->created_at)) }}
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex gap-2">
                                                                            {{-- <a href="{{ route('reimbursements.view', $reimbursement->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                                                        <i class="fa-solid fa-eye"></i>
                                                                    </a> --}}
                                                                            <a href="{{ route('reimbursement.edit', $reimbursement->id) }}"
                                                                                class="btn btn-sm btn-outline-warning"
                                                                                title="Edit">
                                                                                <i class="fa-solid fa-edit"></i>
                                                                            </a>
                                                                            <form
                                                                                action="{{ route('reimbursement.delete', $reimbursement->id) }}"
                                                                                method="POST" style="display:inline;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-outline-danger"
                                                                                    title="Delete"
                                                                                    onclick="return confirm('Are you sure you want to delete this reimbursement?')">
                                                                                    <i class="fa-solid fa-trash"></i>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="10" class="text-center">No reimbursements
                                                                        found</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- end tab-pane -->

                            </div> <!-- Tab panes -->
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection
