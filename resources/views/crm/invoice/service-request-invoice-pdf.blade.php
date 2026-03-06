<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $quotation->invoice_number ?? $quotation->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .invoice-title {
            font-size: 20px;
            color: #666;
            margin-top: 10px;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-details, .customer-details {
            width: 48%;
        }
        .invoice-details h3, .customer-details h3 {
            margin-top: 0;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .table .text-right {
            text-align: right;
        }
        .table .text-center {
            text-align: center;
        }
        .totals {
            width: 300px;
            margin-left: auto;
            margin-bottom: 30px;
        }
        .totals table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals td {
            padding: 5px 10px;
            border-bottom: 1px solid #ddd;
        }
        .totals .total-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .addresses {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .address-block {
            width: 48%;
        }
        .address-block h4 {
            margin-top: 0;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">CrackTeck Solutions Pvt. Ltd.</div>
        <div>Tech Park, Mumbai - 400001</div>
        <div>GSTIN: 27AABCC1234M1Z2</div>
        <div class="invoice-title">INVOICE</div>
    </div>

    <div class="invoice-info">
        <div class="invoice-details">
            <h3>Invoice Details</h3>
            <p><strong>Invoice Number:</strong> #{{ $quotation->invoice_number ?? 'N/A' }}</p>
            <p><strong>Invoice Date:</strong> {{ $quotation->invoice_date ? $quotation->invoice_date->format('d-m-Y') : 'N/A' }}</p>
            <p><strong>Due Date:</strong> {{ $quotation->due_date ? $quotation->due_date->format('d-m-Y') : 'N/A' }}</p>
            <p><strong>Payment Status:</strong> {{ ucfirst($quotation->payment_status ?? 'Pending') }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($quotation->payment_method ?? 'N/A') }}</p>
        </div>
        <div class="customer-details">
            <h3>Customer Details</h3>
            @if($quotation->serviceRequest && $quotation->serviceRequest->customer)
                <p><strong>Name:</strong> {{ $quotation->serviceRequest->customer->first_name ?? '' }} {{ $quotation->serviceRequest->customer->last_name ?? '' }}</p>
                <p><strong>Email:</strong> {{ $quotation->serviceRequest->customer->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $quotation->serviceRequest->customer->phone ?? 'N/A' }}</p>
            @else
                <p><strong>Name:</strong> N/A</p>
                <p><strong>Email:</strong> N/A</p>
                <p><strong>Phone:</strong> N/A</p>
            @endif
        </div>
    </div>

    <!-- Service Request Items Table -->
    <table class="table">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th>Product / Part Name</th>
                <th class="text-center" style="width: 80px;">Type</th>
                <th class="text-center" style="width: 80px;">Qty</th>
                <th class="text-right">Rate</th>
                <th class="text-right">Tax</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
                $hasItems = false;
            @endphp
            
            {{-- Show products from service request --}}
            @if($quotation->serviceRequest && $quotation->serviceRequest->products && $quotation->serviceRequest->products->count() > 0)
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
                        <td class="text-right">₹{{ number_format($product->service_charge ?? 0, 2) }}</td>
                        <td class="text-right">₹0.00</td>
                        <td class="text-right">₹{{ number_format($product->service_charge ?? 0, 2) }}</td>
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
                                        {{ ($quotation->serviceRequest->products->count() ?? 0) + $partIndex + 1 }}
                                    </td>
                                    <td>
                                        <strong>{{ $part->product->product_name ?? $part->requestedPart->serial_number ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">SKU: {{ $part->product->product_sku ?? '-' }}</small>
                                    </td>
                                    <td class="text-center">Part</td>
                                    <td class="text-center">{{ $part->requested_quantity ?? 1 }}</td>
                                    <td class="text-right">₹{{ number_format($part->product->selling_price ?? 0, 2) }}</td>
                                    <td class="text-right">₹0.00</td>
                                    <td class="text-right">₹{{ number_format(($part->product->selling_price ?? 0) * ($part->requested_quantity ?? 1), 2) }}</td>
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
    </table>

    <div class="totals">
        <table>
            @if($quotation->service_charge_total > 0)
            <tr>
                <td>Service Charge:</td>
                <td class="text-right">₹{{ number_format($quotation->service_charge_total, 2) }}</td>
            </tr>
            @endif
            @if($quotation->product_price_total > 0)
            <tr>
                <td>Product Price:</td>
                <td class="text-right">₹{{ number_format($quotation->product_price_total, 2) }}</td>
            </tr>
            @endif
            <tr>
                <td>Subtotal:</td>
                <td class="text-right">₹{{ number_format($quotation->subtotal ?? 0, 2) }}</td>
            </tr>
            @if($quotation->delivery_charge > 0)
            <tr>
                <td>Delivery Charge:</td>
                <td class="text-right">₹{{ number_format($quotation->delivery_charge, 2) }}</td>
            </tr>
            @endif
            @if($quotation->total_discount > 0)
            <tr>
                <td>Discount:</td>
                <td class="text-right">-₹{{ number_format($quotation->total_discount, 2) }}</td>
            </tr>
            @endif
            @if($quotation->total_tax > 0)
            <tr>
                <td>Tax:</td>
                <td class="text-right">₹{{ number_format($quotation->total_tax, 2) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td><strong>Total Amount:</strong></td>
                <td class="text-right"><strong>₹{{ number_format($quotation->grand_total ?? 0, 2) }}</strong></td>
            </tr>
            @if($quotation->paid_amount > 0)
            <tr>
                <td>Paid Amount:</td>
                <td class="text-right">₹{{ number_format($quotation->paid_amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Balance Due:</strong></td>
                <td class="text-right"><strong>₹{{ number_format(($quotation->grand_total ?? 0) - $quotation->paid_amount, 2) }}</strong></td>
            </tr>
            @endif
        </table>
    </div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This is a computer generated invoice and does not require signature.</p>
    </div>
</body>
</html>
