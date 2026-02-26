@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Invoice #{{ $order->order_number }}</h4>
                </div>
                <div>
                    <a href="{{ route('order.invoice-download', $order->id) }}" class="btn btn-primary">
                        <i class="fas fa-download me-1"></i> Download PDF
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Invoice Header -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5 class="text-primary fw-bold">CrackTeck Solutions Pvt. Ltd.</h5>
                                    <p class="mb-1">Tech Park, Mumbai - 400001</p>
                                    <p class="mb-1">GSTIN: 27AABCC1234M1Z2</p>
                                    <p class="mb-0">Phone: +91 98765 43210</p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <h5 class="fw-bold">INVOICE</h5>
                                    <p class="mb-1"><strong>Invoice No:</strong> {{ $invoice_number }}</p>
                                    <p class="mb-1"><strong>Date:</strong> {{ $invoice_date }}</p>
                                    <p class="mb-0"><strong>Status:</strong> <span class="badge bg-success">{{ ucfirst($order->status) }}</span></p>
                                </div>
                            </div>

                            <hr>

                            <!-- Customer & Payment Info -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Bill To:</h6>
                                    @if($order->customer)
                                        <p class="mb-1"><strong>{{ $order->customer->first_name ?? '' }} {{ $order->customer->last_name ?? '' }}</strong></p>
                                        <p class="mb-1">{{ $order->customer->email ?? '' }}</p>
                                        @if($order->customer->phone)
                                            <p class="mb-0">Phone: {{ $order->customer->phone }}</p>
                                        @endif
                                    @elseif($order->billingAddress)
                                        <p class="mb-1"><strong>{{ $order->billingAddress->first_name ?? '' }} {{ $order->billingAddress->last_name ?? '' }}</strong></p>
                                        <p class="mb-1">{{ $order->billingAddress->address_line_1 ?? '' }}</p>
                                        <p class="mb-0">{{ $order->billingAddress->city ?? '' }}, {{ $order->billingAddress->state ?? '' }} - {{ $order->billingAddress->pincode ?? '' }}</p>
                                    @else
                                        <p class="mb-0">N/A</p>
                                    @endif
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <h6 class="fw-bold">Payment Details:</h6>
                                    <p class="mb-1"><strong>Payment Method:</strong> {{ ucfirst($order->orderPayments->first()->payment_method ?? 'N/A') }}</p>
                                    <p class="mb-0"><strong>Payment Status:</strong> <span class="badge bg-info">{{ ucfirst($order->orderPayments->first()->status ?? 'pending') }}</span></p>
                                </div>
                            </div>

                            <!-- Order Items Table -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">#</th>
                                            <th>Product</th>
                                            <th class="text-center" style="width: 80px;">HSN</th>
                                            <th class="text-center" style="width: 80px;">Qty</th>
                                            <th class="text-end">Rate</th>
                                            <th class="text-end">Tax</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $index => $item)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    <strong>{{ $item->product_name }}</strong><br>
                                                    <small class="text-muted">SKU: {{ $item->product_sku }}</small>
                                                </td>
                                                <td class="text-center">{{ $item->hsn_code ?? '-' }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-end">₹{{ number_format($item->unit_price, 2) }}</td>
                                                <td class="text-end">₹{{ number_format($item->tax_per_unit, 2) }}</td>
                                                <td class="text-end">₹{{ number_format($item->line_total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Subtotal:</strong></td>
                                            <td colspan="2" class="text-end"><strong>₹{{ number_format($totals['subtotal'], 2) }}</strong></td>
                                        </tr>
                                        @if($totals['discount_amount'] > 0)
                                            <tr class="text-success">
                                                <td colspan="5" class="text-end"><strong>Discount:</strong></td>
                                                <td colspan="2" class="text-end">-₹{{ number_format($totals['discount_amount'], 2) }}</td>
                                            </tr>
                                        @endif
                                        @if($totals['shipping_charges'] > 0)
                                            <tr>
                                                <td colspan="5" class="text-end"><strong>Shipping:</strong></td>
                                                <td colspan="2" class="text-end">₹{{ number_format($totals['shipping_charges'], 2) }}</td>
                                            </tr>
                                        @endif
                                        <tr class="table-success">
                                            <td colspan="5" class="text-end"><strong>Grand Total:</strong></td>
                                            <td colspan="2" class="text-end"><strong>₹{{ number_format($totals['rounded_total'], 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Amount in Words -->
                            <div class="alert alert-info mb-4">
                                <strong>Amount in Words:</strong> {{ $amount_in_words }} Only
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="fw-bold">Terms & Conditions:</h6>
                                    <ul class="text-muted small">
                                        <li>Goods once sold will not be taken back.</li>
                                        <li>Payment should be made within the stipulated time.</li>
                                        <li>Subject to Mumbai jurisdiction only.</li>
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
