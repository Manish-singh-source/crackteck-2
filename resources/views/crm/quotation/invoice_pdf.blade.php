<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
        }

        .invoice-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 20px;
        }

        .info-block {
            font-size: 13px;
        }

        .info-block strong {
            display: block;
            margin-bottom: 5px;
        }

        .customer-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .customer-block {
            font-size: 13px;
        }

        .customer-block h6 {
            margin: 0 0 10px 0;
            font-weight: bold;
        }

        .customer-block p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 13px;
        }

        table th {
            background-color: #f5f5f5;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #333;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .text-right {
            text-align: right;
        }

        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .totals-table {
            width: 300px;
            font-size: 13px;
        }

        .totals-table tr td {
            padding: 8px 12px;
            border-bottom: none;
        }

        .totals-table .label {
            text-align: left;
            font-weight: bold;
        }

        .totals-table .total-row {
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
        }

        .totals-table .total-row td {
            padding: 12px;
            font-weight: bold;
            font-size: 14px;
        }

        .footer {
            margin-top: 40px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-name">CRACKTECK</div>
            <div class="invoice-title">INVOICE</div>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <div class="info-block">
                <strong>Invoice Number:</strong>
                {{ $invoice->invoice_number }}<br>
                <strong>Invoice Date:</strong>
                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}<br>
                <strong>Due Date:</strong>
                {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}
            </div>
            <div class="info-block">
                <strong>Status:</strong>
                {{ ucfirst($invoice->status) }}<br>
                <strong>Currency:</strong>
                {{ $invoice->currency }}<br>
                <strong>Payment Status:</strong>
                {{ ucfirst($invoice->payment_status) }}
            </div>
        </div>

        <!-- Customer Info -->
        <div class="customer-info">
            <div class="customer-block">
                <h6>Bill To:</h6>
                @if ($invoice->quoteDetails && $invoice->quoteDetails->leadDetails && $invoice->quoteDetails->leadDetails->customer)
                    <p><strong>{{ $invoice->quoteDetails->leadDetails->customer->first_name }}
                            {{ $invoice->quoteDetails->leadDetails->customer->last_name }}</strong></p>
                    <p>{{ $invoice->quoteDetails->leadDetails->customer->email }}</p>
                    <p>{{ $invoice->quoteDetails->leadDetails->customer->phone }}</p>
                @endif
            </div>
            <div class="customer-block">
                <h6>Billing Address:</h6>
                @if ($invoice->billing_address)
                    <p>{!! nl2br(e($invoice->billing_address)) !!}</p>
                @elseif(
                    $invoice->quoteDetails &&
                        $invoice->quoteDetails->leadDetails &&
                        $invoice->quoteDetails->leadDetails->customerAddress)
                    @php $addr = $invoice->quoteDetails->leadDetails->customerAddress; @endphp
                    <p>{{ $addr->address1 }} {{ $addr->address2 }}<br>
                        {{ $addr->city }}, {{ $addr->state }} - {{ $addr->pincode }}<br>
                        {{ $addr->country }}</p>
                @else
                    <p>N/A</p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Tax Amount</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoice->items as $item)
                    <tr>
                        <td>{{ $item->product_name ?? 'Item' }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">₹{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">₹{{ number_format($item->tax_amount, 2) }}</td>
                        <td class="text-right">₹{{ number_format($item->line_total, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">No items</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td class="label">Subtotal:</td>
                    <td class="text-right">₹{{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Total Discount:</td>
                    <td class="text-right">-₹{{ number_format($invoice->total_discount, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Total Tax:</td>
                    <td class="text-right">₹{{ number_format($invoice->total_tax, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td class="label">Grand Total:</td>
                    <td class="text-right">₹{{ number_format($invoice->grand_total, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is a computer generated invoice and does not require signature.</p>
            <p>Payment terms: {{ $invoice->payment_method ?? 'To be defined' }}</p>
        </div>
    </div>
</body>

</html>
