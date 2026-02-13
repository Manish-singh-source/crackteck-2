@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row pt-3">
                <div class="col-xl-10 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Invoice #{{ $invoice->invoice_number }}</h5>
                            <div>
                                <a href="{{ route('quotation.view', $invoice->quote_id) }}" class="btn btn-light btn-sm">Back
                                    to Quotation</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Invoice Date:</strong> {{ $invoice->invoice_date }}<br>
                                <strong>Due Date:</strong> {{ $invoice->due_date }}<br>
                                <strong>Status:</strong> {{ ucfirst($invoice->status) }}
                            </div>

                            <div class="mb-3">
                                <h6>Invoice To</h6>
                                @if ($invoice->quoteDetails && $invoice->quoteDetails->leadDetails && $invoice->quoteDetails->leadDetails->customer)
                                    <p>
                                        <strong>{{ $invoice->quoteDetails->leadDetails->customer->first_name }}
                                            {{ $invoice->quoteDetails->leadDetails->customer->last_name }}</strong><br>
                                        {{ $invoice->quoteDetails->leadDetails->customer->email ?? '' }}<br>
                                        {{ $invoice->quoteDetails->leadDetails->customer->phone ?? '' }}
                                    </p>
                                @endif

                                <h6>Billing Address</h6>
                                @if ($invoice->billing_address)
                                    <p>{!! is_string($invoice->billing_address) ? e($invoice->billing_address) : json_encode($invoice->billing_address) !!}</p>
                                @elseif(
                                    $invoice->quoteDetails &&
                                        $invoice->quoteDetails->leadDetails &&
                                        $invoice->quoteDetails->leadDetails->customerAddress)
                                    @php $addr = $invoice->quoteDetails->leadDetails->customerAddress; @endphp
                                    <p>
                                        {{ $addr->address1 ?? '' }} {{ $addr->address2 ?? '' }}<br>
                                        {{ $addr->city ?? '' }}, {{ $addr->state ?? '' }} -
                                        {{ $addr->pincode ?? '' }}<br>
                                        {{ $addr->country ?? '' }}
                                    </p>
                                @else
                                    <p>N/A</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <h6>Items</h6>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                            <th>Tax</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice->items as $item)
                                            <tr>
                                                <td>{{ $item->product_name ?? 'Item' }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>₹{{ number_format($item->unit_price, 2) }}</td>
                                                <td>₹{{ number_format($item->tax_amount, 2) }} ({{ $item->tax_rate }}%)
                                                </td>
                                                <td>₹{{ number_format($item->line_total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>Subtotal</th>
                                            <td class="text-end">₹{{ number_format($invoice->subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Tax</th>
                                            <td class="text-end">₹{{ number_format($invoice->total_tax, 2) }}</td>
                                        </tr>
                                        <tr class="border-top">
                                            <th>Grand Total</th>
                                            <td class="text-end">₹{{ number_format($invoice->grand_total, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
