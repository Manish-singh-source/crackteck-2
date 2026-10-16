@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3">
                <h4 class="fs-18 fw-semibold m-0">Payment Log List</h4>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('payments') }}" method="GET" class="row g-3 mb-3">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <div class="col-md-4">
                            <label for="payment-search" class="form-label">Search payments</label>
                            <input id="payment-search" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}"
                                placeholder="Payment ID, customer, order, plan or invoice" maxlength="255">
                        </div>
                        <div class="col-md-2">
                            <label for="payment-source" class="form-label">Payment for</label>
                            <select id="payment-source" name="source" class="form-select">
                                <option value="">All sources</option>
                                @foreach (['order' => 'Orders', 'amc' => 'Remote AMC', 'service' => 'Service Requests'] as $value => $label)
                                    <option value="{{ $value }}" @selected(($filters['source'] ?? '') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="payment-from" class="form-label">From</label>
                            <input id="payment-from" type="date" name="from" class="form-control" value="{{ $filters['from'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <label for="payment-to" class="form-label">To</label>
                            <input id="payment-to" type="date" name="to" class="form-control" value="{{ $filters['to'] ?? '' }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end gap-2">
                            <button class="btn btn-primary" type="submit">Filter</button>
                            <a href="{{ route('payments') }}" class="btn btn-light">Reset</a>
                        </div>
                    </form>
                    <ul class="nav nav-underline border-bottom mb-3" aria-label="Payment status filters">
                        @foreach (['all' => 'All Payments', 'pending' => 'Pending Payments', 'completed' => 'Completed Payments', 'failed' => 'Failed Payments', 'refunded' => 'Refunded Payments'] as $value => $label)
                            <li class="nav-item">
                                <a href="{{ route('payments', array_merge($filters, ['status' => $value])) }}"
                                    class="nav-link p-2 {{ $status === $value ? 'active' : '' }}"
                                    @if ($status === $value) aria-current="page" @endif>
                                    {{ $label }} <span class="badge bg-secondary ms-1">{{ $counts[$value] ?? 0 }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Payment ID</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Service/Plan</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Payment Mode</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Invoice ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                    @php
                                        $customerName = trim(($payment->first_name ?? '').' '.($payment->last_name ?? ''));
                                        $badge = ['completed' => 'success', 'pending' => 'warning', 'failed' => 'danger', 'refunded' => 'info'][$payment->status] ?? 'secondary';
                                        $rawStatus = ucwords(str_replace('_', ' ', $payment->raw_status));
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $payment->reference ?: strtoupper($payment->source).'-'.$payment->id }}
                                            @if ($payment->transaction_id && $payment->transaction_id !== $payment->reference)
                                                <small class="d-block text-muted">{{ $payment->transaction_id }}</small>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">{{ $payment->payment_date ? \Illuminate\Support\Carbon::parse($payment->payment_date)->format('d M Y, h:i A') : '—' }}</td>
                                        <td>{{ $customerName ?: 'Customer unavailable' }}</td>
                                        <td>
                                            {{ $payment->description ?: '—' }}
                                            <small class="d-block text-muted">{{ ['order' => 'Order', 'amc' => 'Remote AMC', 'service' => 'Service Request'][$payment->source] }}</small>
                                        </td>
                                        <td class="text-nowrap">{{ number_format((float) $payment->amount, 2) }} {{ $payment->currency }}</td>
                                        <td>
                                            {{ $payment->method ? strtoupper(str_replace('_', ' ', $payment->method)) : 'Not recorded' }}
                                            @if ($payment->gateway)
                                                <small class="d-block text-muted">{{ ucfirst($payment->gateway) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $badge }}-subtle text-{{ $badge }} fw-semibold">{{ ucfirst($payment->status) }}</span>
                                            @if (strtolower($rawStatus) !== $payment->status)
                                                <small class="d-block text-muted">{{ $rawStatus }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $payment->invoice_number ?: '—' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center text-muted py-4">No payments found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <span class="text-muted">Showing {{ $payments->firstItem() ?? 0 }}–{{ $payments->lastItem() ?? 0 }} of {{ $payments->total() }} payments</span>
                        {{ $payments->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
