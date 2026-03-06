@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Invoice #{{ $quotation->invoice_number ?? $quotation->id }}</h4>
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
                                    <p class="mb-1"><strong>Invoice No:</strong> {{ $quotation->invoice_number ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Date:</strong> {{ $quotation->invoice_date ? $quotation->invoice_date->format('d-m-Y') : 'N/A' }}</p>
                                    <p class="mb-0"><strong>Status:</strong> <span class="badge bg-success">{{ ucfirst($quotation->payment_status ?? 'Pending') }}</span></p>
                                </div>
                            </div>

                            <hr>

                            <!-- Customer & Payment Info -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Bill To:</h6>
                                    @if($quotation->serviceRequest && $quotation->serviceRequest->customer)
                                        <p class="mb-1"><strong>{{ $quotation->serviceRequest->customer->first_name ?? '' }} {{ $quotation->serviceRequest->customer->last_name ?? '' }}</strong></p>
                                        <p class="mb-1">{{ $quotation->serviceRequest->customer->email ?? 'N/A' }}</p>
                                        @if($quotation->serviceRequest->customer->phone)
                                            <p class="mb-0">Phone: {{ $quotation->serviceRequest->customer->phone }}</p>
                                        @endif
                                    @elseif($quotation->billingAddress)
                                        <p class="mb-1"><strong>{{ $quotation->billingAddress->first_name ?? '' }} {{ $quotation->billingAddress->last_name ?? '' }}</strong></p>
                                        <p class="mb-1">{{ $quotation->billingAddress->address_line_1 ?? '' }}</p>
                                        <p class="mb-0">{{ $quotation->billingAddress->city ?? '' }}, {{ $quotation->billingAddress->state ?? '' }} - {{ $quotation->billingAddress->pincode ?? '' }}</p>
                                    @else
                                        <p class="mb-0">N/A</p>
                                    @endif
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <h6 class="fw-bold">Payment Details:</h6>
                                    <p class="mb-1"><strong>Payment Method:</strong> {{ ucfirst($quotation->payment_method ?? 'N/A') }}</p>
                                    <p class="mb-0"><strong>Payment Status:</strong> <span class="badge bg-info">{{ ucfirst($quotation->payment_status ?? 'pending') }}</span></p>
                                </div>
                            </div>

                            <!-- Service Request Items Table -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">#</th>
                                            <th>Product / Part Name</th>
                                            <th class="text-center" style="width: 80px;">Type</th>
                                            <th class="text-center" style="width: 80px;">Qty</th>
                                            <th class="text-end">Rate</th>
                                            <th class="text-end">Tax</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $hasItems = false;
                                        @endphp
                                        
                                        {{-- Show products from service request --}}
                                        @if($quotation->serviceRequest && $quotation->serviceRequest->products->count() > 0)
                                            @php $hasItems = true; @endphp
                                            @foreach($quotation->serviceRequest->products as $index => $product)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>
                                                        <strong>{{ $product->name ?? 'N/A' }}</strong><br>
                                                        <small class="text-muted">Model: {{ $product->model_no ?? '-' }}</small>
                                                    </td>
                                                    <td class="text-center">Service</td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-end">₹{{ number_format($product->service_charge ?? 0, 2) }}</td>
                                                    <td class="text-end">₹0.00</td>
                                                    <td class="text-end">₹{{ number_format($product->service_charge ?? 0, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        
                                        {{-- Show used parts from service_request_product_request_parts --}}
                                        @if($quotation->serviceRequest && $quotation->serviceRequest->products)
                                            @foreach($quotation->serviceRequest->products as $product)
                                                @if($product->requestParts && $product->requestParts->count() > 0)
                                                    @foreach($product->requestParts as $partIndex => $part)
                                                        @if($part->status == 'used')
                                                            @php $hasItems = true; @endphp
                                                            <tr>
                                                                <td class="text-center">
                                                                    {{ $quotation->serviceRequest->products->count() + $partIndex + 1 }}
                                                                </td>
                                                                <td>
                                                                    <strong>{{ $part->product->product_name ?? $part->requestedPart->serial_number ?? 'N/A' }}</strong><br>
                                                                    <small class="text-muted">SKU: {{ $part->product->sku ?? '-' }}</small>
                                                                </td>
                                                                <td class="text-center">Part</td>
                                                                <td class="text-center">{{ $part->requested_quantity ?? 1 }}</td>
                                                                <td class="text-end">₹{{ number_format($part->product->final_price ?? 0, 2) }}</td>
                                                                <td class="text-end">₹0.00</td>
                                                                <td class="text-end">₹{{ number_format(($part->product->final_price ?? 0) * ($part->requested_quantity ?? 1), 2) }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                        
                                        @if(!$hasItems)
                                            <tr>
                                                <td colspan="7" class="text-center">No items found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        @if($quotation->service_charge_total > 0)
                                            <tr>
                                                <td colspan="5" class="text-end"><strong>Service Charge:</strong></td>
                                                <td colspan="2" class="text-end"><strong>₹{{ number_format($quotation->service_charge_total, 2) }}</strong></td>
                                            </tr>
                                        @endif
                                        @if($quotation->product_price_total > 0)
                                            <tr>
                                                <td colspan="5" class="text-end"><strong>Product Price:</strong></td>
                                                <td colspan="2" class="text-end"><strong>₹{{ number_format($quotation->product_price_total, 2) }}</strong></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Subtotal:</strong></td>
                                            <td colspan="2" class="text-end"><strong>₹{{ number_format($quotation->subtotal ?? 0, 2) }}</strong></td>
                                        </tr>
                                        @if($quotation->delivery_charge > 0)
                                            <tr>
                                                <td colspan="5" class="text-end"><strong>Delivery Charge:</strong></td>
                                                <td colspan="2" class="text-end">₹{{ number_format($quotation->delivery_charge, 2) }}</td>
                                            </tr>
                                        @endif
                                        @if($quotation->total_discount > 0)
                                            <tr class="text-success">
                                                <td colspan="5" class="text-end"><strong>Discount:</strong></td>
                                                <td colspan="2" class="text-end">-₹{{ number_format($quotation->total_discount, 2) }}</td>
                                            </tr>
                                        @endif
                                        @if($quotation->total_tax > 0)
                                            <tr>
                                                <td colspan="5" class="text-end"><strong>Tax:</strong></td>
                                                <td colspan="2" class="text-end">₹{{ number_format($quotation->total_tax, 2) }}</td>
                                            </tr>
                                        @endif
                                        <tr class="table-success">
                                            <td colspan="5" class="text-end"><strong>Grand Total:</strong></td>
                                            <td colspan="2" class="text-end"><strong>₹{{ number_format($quotation->grand_total ?? 0, 2) }}</strong></td>
                                        </tr>
                                        @if($quotation->paid_amount > 0)
                                            <tr>
                                                <td colspan="5" class="text-end"><strong>Paid Amount:</strong></td>
                                                <td colspan="2" class="text-end">₹{{ number_format($quotation->paid_amount, 2) }}</td>
                                            </tr>
                                            <tr class="table-warning">
                                                <td colspan="5" class="text-end"><strong>Balance Due:</strong></td>
                                                <td colspan="2" class="text-end"><strong>₹{{ number_format(($quotation->grand_total ?? 0) - $quotation->paid_amount, 2) }}</strong></td>
                                            </tr>
                                        @endif
                                    </tfoot>
                                </table>
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
