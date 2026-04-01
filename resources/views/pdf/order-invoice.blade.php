<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.5;
            margin: 24px;
        }
        .header, .meta, .summary {
            width: 100%;
            margin-bottom: 18px;
        }
        .header td, .meta td, .summary td {
            vertical-align: top;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 6px;
        }
        .muted {
            color: #6b7280;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            background: #dcfce7;
            color: #166534;
            border-radius: 4px;
            font-size: 11px;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        table.items th,
        table.items td {
            border: 1px solid #d1d5db;
            padding: 8px;
        }
        table.items th {
            background: #f3f4f6;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 6px;
        }
        .footer-note {
            margin-top: 18px;
            padding: 10px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
        }
    </style>
</head>
<body>
    <table class="header">
        <tr>
            <td style="width: 60%;">
                <div class="title">CrackTeck Solutions Pvt. Ltd.</div>
                <div>Tech Park, Mumbai - 400001</div>
                <div>GSTIN: 27AABCC1234M1Z2</div>
                <div>Phone: +91 98765 43210</div>
                <div>Email: info@crackteck.com</div>
            </td>
            <td style="width: 40%;" class="text-right">
                <div class="title">INVOICE</div>
                <div><strong>Invoice No:</strong> {{ $invoice->invoice_number }}</div>
                <div><strong>Invoice ID:</strong> {{ $invoice->invoice_id }}</div>
                <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</div>
                <div><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</div>
                <div style="margin-top: 6px;"><span class="badge">{{ strtoupper($invoice->status) }}</span></div>
            </td>
        </tr>
    </table>

    <table class="meta">
        <tr>
            <td style="width: 55%; padding-right: 14px;">
                <div class="section-title">Bill To</div>
                @if($order->customer)
                    <div><strong>{{ trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? '')) ?: 'Customer' }}</strong></div>
                    <div>{{ $order->customer->email ?? 'N/A' }}</div>
                    <div>{{ $order->customer->phone ?? 'N/A' }}</div>
                @elseif($order->billingAddress)
                    <div><strong>{{ trim(($order->billingAddress->first_name ?? '') . ' ' . ($order->billingAddress->last_name ?? '')) ?: 'Customer' }}</strong></div>
                    <div>{{ $order->billingAddress->address_line_1 ?? 'N/A' }}</div>
                    <div>{{ $order->billingAddress->city ?? '' }} {{ $order->billingAddress->state ?? '' }} {{ $order->billingAddress->pincode ?? '' }}</div>
                @else
                    <div>N/A</div>
                @endif
            </td>
            <td style="width: 45%;" class="text-right">
                <div class="section-title">Payment Details</div>
                <div><strong>Order No:</strong> {{ $order->order_number }}</div>
                <div><strong>Payment Method:</strong> {{ ucfirst($order->orderPayments->first()->payment_method ?? 'online') }}</div>
                <div><strong>Payment Status:</strong> {{ ucfirst($order->orderPayments->first()->status ?? 'completed') }}</div>
                <div><strong>Paid At:</strong> {{ optional($invoice->paid_at)->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}</div>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 6%;" class="text-center">#</th>
                <th style="width: 36%;">Item</th>
                <th style="width: 10%;" class="text-center">HSN</th>
                <th style="width: 8%;" class="text-center">Qty</th>
                <th style="width: 14%;" class="text-right">Rate</th>
                <th style="width: 10%;" class="text-right">Tax</th>
                <th style="width: 16%;" class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->product_name }}</strong><br>
                        <span class="muted">SKU: {{ $item->product_sku ?? 'N/A' }}</span>
                    </td>
                    <td class="text-center">{{ $item->hsn_code ?? '-' }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rs {{ number_format((float) $item->unit_price, 2) }}</td>
                    <td class="text-right">Rs {{ number_format((float) $item->tax_per_unit, 2) }}</td>
                    <td class="text-right">Rs {{ number_format((float) $item->line_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary" style="margin-top: 18px;">
        <tr>
            <td style="width: 58%;"></td>
            <td style="width: 42%;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td><strong>Subtotal</strong></td>
                        <td class="text-right">Rs {{ number_format((float) $totals['subtotal'], 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Discount</strong></td>
                        <td class="text-right">Rs {{ number_format((float) $totals['discount_amount'], 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tax</strong></td>
                        <td class="text-right">Rs {{ number_format((float) $totals['tax_amount'], 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Shipping</strong></td>
                        <td class="text-right">Rs {{ number_format((float) $totals['shipping_charges'], 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding-top: 8px;"><strong>Grand Total</strong></td>
                        <td class="text-right" style="padding-top: 8px;"><strong>Rs {{ number_format((float) $totals['grand_total'], 2) }}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        <strong>Amount in Words:</strong> {{ $amount_in_words }}
    </div>

    <div style="margin-top: 18px;" class="muted">
        Goods once sold will not be taken back. Payment has been received successfully against this order.
    </div>
</body>
</html>
