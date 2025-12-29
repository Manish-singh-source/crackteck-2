<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
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
        <div class="company-name">Crackteck</div>
        <div>Your Technology Partner</div>
        <div class="invoice-title">INVOICE</div>
    </div>

    <div class="invoice-info">
        <div class="invoice-details">
            <h3>Invoice Details</h3>
            <p><strong>Invoice Number:</strong> #{{ $order->order_number }}</p>
            <p><strong>Invoice Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
            <p><strong>Order Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Payment Method:</strong> {{ $order->payment_method == 'mastercard' ? 'Credit Card' : 'Cash on Delivery' }}</p>
        </div>
        <div class="customer-details">
            <h3>Customer Details</h3>
            <p><strong>Name:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            @if($order->billing_phone)
            <p><strong>Phone:</strong> {{ $order->billing_phone }}</p>
            @endif
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Item Description</th>
                <th>HSN/SAC</th>
                <th class="text-center">QTY</th>
                <th class="text-right">Rate</th>
                <th class="text-right">Taxable Value</th>
                <th class="text-center">Tax %</th>
                <th class="text-right">IGST</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->hsn_sac_code }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">₹{{ number_format($item->unit_price, 2) }}</td>
                <td class="text-right">₹{{ number_format($item->taxable_value, 2) }}</td>
                <td class="text-center">{{ $item->tax_percentage }}%</td>
                <td class="text-right">₹{{ number_format($item->igst_amount, 2) }}</td>
                <td class="text-right">₹{{ number_format($item->final_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #f5f5f5; font-weight: bold;">
                <td colspan="3"><strong>Total</strong></td>
                <td class="text-center"><strong>{{ $order->orderItems->sum('quantity') }}</strong></td>
                <td class="text-right"><strong>₹{{ number_format($order->orderItems->sum('total_price'), 2) }}</strong></td>
                <td class="text-right"><strong>₹{{ number_format($totals['subtotal'], 2) }}</strong></td>
                <td class="text-center">-</td>
                <td class="text-right"><strong>₹{{ number_format($totals['total_tax'], 2) }}</strong></td>
                <td class="text-right"><strong>₹{{ number_format($totals['total_amount'], 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Total Taxable Value:</td>
                <td class="text-right">₹{{ number_format($totals['subtotal'], 2) }}</td>
            </tr>
            <tr>
                <td>Total Tax Amount:</td>
                <td class="text-right">₹{{ number_format($totals['total_tax'], 2) }}</td>
            </tr>
            @if($totals['shipping_charges'] > 0)
            <tr>
                <td>Shipping Charges:</td>
                <td class="text-right">₹{{ number_format($totals['shipping_charges'], 2) }}</td>
            </tr>
            @endif
            <tr>
                <td>Rounded Off:</td>
                <td class="text-right">{{ $totals['rounding_off'] >= 0 ? '+' : '' }}₹{{ number_format($totals['rounding_off'], 2) }}</td>
            </tr>
            <tr class="total-row">
                <td><strong>Total Amount:</strong></td>
                <td class="text-right"><strong>₹{{ number_format($totals['rounded_total'], 2) }}</strong></td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 10px;">
                    <strong>Amount in Words:</strong><br>
                    {{ $totals['total_in_words'] }}
                </td>
            </tr>
        </table>
    </div>

    <div class="addresses">
        <div class="address-block">
            <h4>Billing Address</h4>
            <address>
                {{ $order->billing_first_name }} {{ $order->billing_last_name }}<br>
                @if($order->billing_company)
                    {{ $order->billing_company }}<br>
                @endif
                {{ $order->billing_address_line_1 }}<br>
                @if($order->billing_address_line_2)
                    {{ $order->billing_address_line_2 }}<br>
                @endif
                {{ $order->billing_city }}, {{ $order->billing_state }}<br>
                {{ $order->billing_country }} - {{ $order->billing_postal_code }}<br>
                @if($order->billing_phone)
                    Phone: {{ $order->billing_phone }}
                @endif
            </address>
        </div>
        <div class="address-block">
            <h4>Shipping Address</h4>
            <address>
                {{ $order->shipping_first_name }} {{ $order->shipping_last_name }}<br>
                @if($order->shipping_company)
                    {{ $order->shipping_company }}<br>
                @endif
                {{ $order->shipping_address_line_1 }}<br>
                @if($order->shipping_address_line_2)
                    {{ $order->shipping_address_line_2 }}<br>
                @endif
                {{ $order->shipping_city }}, {{ $order->shipping_state }}<br>
                {{ $order->shipping_country }} - {{ $order->shipping_postal_code }}<br>
                @if($order->shipping_phone)
                    Phone: {{ $order->shipping_phone }}
                @endif
            </address>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This is a computer generated invoice and does not require signature.</p>
    </div>
</body>
</html>
