@extends('crm/layouts/master') 

@section('content')

<div class="content"> 


    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Re-Imbursement List</h4>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pt-0">

                        @php
                                $statuses = [
                                    'all' => ['label' => 'All', 'icon' => 'mdi-format-list-bulleted', 'color' => ''],
                                    
                                    'pending' => [
                                        'label' => 'Pending',
                                        'icon' => 'mdi-clock-time-four-outline',
                                        'color' => 'text-warning',
                                    ],
                                    'completed' => [
                                        'label' => 'Completed',
                                        'icon' => 'mdi-check-circle-outline',
                                        'color' => 'text-success',
                                    ],
                                    'failed' => [
                                        'label' => 'Failed',
                                        'icon' => 'mdi-alert-circle-outline',
                                        'color' => 'text-danger',
                                    ],
                                ];

                                $currentStatus = request()->get('status') ?? 'all';
                            @endphp

                            <ul class="nav nav-underline border-bottom" id="pills-tab" role="tablist">
                                @foreach ($statuses as $key => $status)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $currentStatus === $key ? 'active' : '' }} p-2"
                                            href="{{ $key === 'all' ? route('reimbursement') : route('reimbursement', ['status' => $key]) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i
                                                    class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>{{ $status['label'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                        {{-- <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $status === 'all' ? 'active' : '' }} p-2" id="all_tab" 
                                    href="{{ route('reimbursement', ['status' => 'all']) }}" role="tab">
                                    <span class="d-none d-sm-block">All</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $status === 'pending' ? 'active' : '' }} p-2" id="pending_tab" 
                                    href="{{ route('reimbursement', ['status' => 'pending']) }}" role="tab">
                                    <span class="d-none d-sm-block">Pending</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $status === 'completed' ? 'active' : '' }} p-2" id="completed_tab" 
                                    href="{{ route('reimbursement', ['status' => 'completed']) }}" role="tab">
                                    <span class="d-none d-sm-block">Completed</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $status === 'failed' ? 'active' : '' }} p-2" id="failed_tab" 
                                    href="{{ route('reimbursement', ['status' => 'failed']) }}" role="tab">
                                    <span class="d-none d-sm-block">Failed</span>
                                </a>
                            </li>
                        </ul> --}}

                        <div class="tab-content text-muted">
                            <div class="tab-pane active show" id="all_customer" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>

                                                        <tr>
                                                            <td>Return Number</td>
                                                            <td>Date</td>
                                                            <td>User Type</td>
                                                            <td>Name</td>
                                                            <td>Amount</td>
                                                            <td>Method</td>
                                                            <td>Status</td>
                                                            <td>Note</td>
                                                        </tr>

                                                    </thead>
                                                    <tbody>
                                                        @forelse($returnOrders as $order)
                                                            <tr>
                                                                <td>{{ $order->return_order_number }}</td>
                                                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                                                <td>Customer</td>
                                                                <td>{{ $order->customer->first_name ?? '' }} {{ $order->customer->last_name ?? '' }}</td>
                                                                <td>₹{{ number_format($order->refund_amount, 2) }}</td>
                                                                <td>PhonePe</td>
                                                                <td>
                                                                    @if($order->refund_status === 'pending')
                                                                        <span class="badge bg-warning">Pending</span>
                                                                    @elseif($order->refund_status === 'completed')
                                                                        <span class="badge bg-success">Completed</span>
                                                                    @elseif($order->refund_status === 'failed')
                                                                        <span class="badge bg-danger">Failed</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">{{ $order->refund_status }}</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $order->return_reason ?? $order->customer_notes ?? '-' }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8" class="text-center">No records found</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div> 

@endsection
