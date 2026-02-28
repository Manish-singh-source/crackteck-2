@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row pt-3">
                <div class="col-xl-10 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Invoice #{{ $invoice->invoice_number }}</h5>
                            <div class="btn-group" role="group">
                                @if ($invoice->invoice_pdf)
                                    <a href="{{ asset('storage/' . $invoice->invoice_pdf) }}" class="btn btn-success btn-sm"
                                        target="_blank">
                                        <i class="fas fa-file-pdf me-1"></i>Download PDF
                                    </a>
                                @endif
                                <a href="{{ route('quotation.view', $invoice->quote_id) }}"
                                    class="btn btn-light btn-sm">Back
                                    to Quotation</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Invoice Date:</strong> {{ $invoice->invoice_date }}<br>
                                <strong>Due Date:</strong> {{ $invoice->due_date }}<br>
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
                                            <th>Images</th>
                                            <th>Product Name</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th>Model No</th>
                                            <th>SKU</th>
                                            <th>HSN</th>
                                            <th>Purchase Date</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice->items as $item)
                                            <tr>
                                                <td>{{ $item->images ?? '-' }}</td>
                                                <td>{{ $item->name ?? ($item->name ?? 'Item') }}
                                                    @if ($item->type || $item->brand)
                                                        <div class="text-muted small">{{ $item->type ?? '' }}
                                                            {{ $item->brand ? '- ' . $item->brand : '' }}</div>
                                                    @endif
                                                </td>
                                                <td>{{ $item->description ?? '-' }}</td>
                                                <td>{{ $item->type ?? '-' }}</td>
                                                <td>{{ $item->model_no ?? '-' }}</td>
                                                <td>{{ $item->sku ?? '-' }}</td>
                                                <td>{{ $item->hsn ?? '-' }}</td>
                                                <td>{{ $item->purchase_date ?? '-' }}</td>
                                                <td>{{ $item->quantity }}</td>
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
                                        <tr>
                                            <th>Total Discount</th>
                                            <td class="text-end">₹{{ number_format($invoice->total_discount ?? 0, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Round Off</th>
                                            <td class="text-end">₹{{ number_format($invoice->round_off ?? 0, 2) }}</td>
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
