<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Invoice - {{ $invoice_number }}</title>
  <style>
    body{margin:18px;background:#fff;font-family:Arial, sans-serif;color:#000;font-size:12px}
    .container{max-width:900px;margin:0 auto;border:2px solid #000;padding:18px}
    header{width:100%;border-bottom:2px solid #000;padding-bottom:12px;margin-bottom:12px}
    .header-table{width:100%;border-collapse:collapse}
    .header-table td{border:none;padding:4px;vertical-align:top}
    .company h1{margin:0;font-size:20px;font-weight:bold}
    .company .address{font-size:12px;margin-top:4px;line-height:1.4}
    .invoice-meta{text-align:right;font-size:12px;line-height:1.4}
    .section{margin-top:12px;border:1px solid #000;padding:8px;font-size:12px;line-height:1.4}
    .items-table{width:100%;border-collapse:collapse;margin-top:12px;font-size:12px}
    .items-table th,.items-table td{border:1px solid #000;padding:6px;text-align:left;vertical-align:top}
    .items-table th{background:#f2f2f2;font-weight:bold}
    .right{text-align:right}
    .totals-table{width:300px;float:right;border-collapse:collapse;margin-top:12px;font-size:12px}
    .totals-table td{border:1px solid #000;padding:6px}
    .footer{margin-top:60px;width:100%;font-size:12px;clear:both}
    .footer-table{width:100%;border-collapse:collapse}
    .footer-table td{border:none;padding:4px;vertical-align:top}
    .bold{font-weight:bold}
    .center{text-align:center}
  </style>
</head>
<body>
  <div class="container">
    <header>
      <table class="header-table">
        <tr>
          <td style="width:60%">
            <div class="company">
              <h1>{{ $company['name'] }}</h1>
              <div class="address">
                {{ $company['address'] }}<br>
                GSTIN: {{ $company['gstin'] }}<br>
                Phone: {{ $company['phone'] }}<br>
                Email: {{ $company['email'] }}
              </div>
            </div>
          </td>
          <td style="width:40%">
            <div class="invoice-meta">
              <div class="bold">INVOICE</div>
              <div>Invoice No: {{ $invoice_number }}</div>
              <div>Date: {{ $invoice_date }}</div>
              <div>Order ID: #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
              <div>Status: {{ $order->status }}</div>
            </div>
          </td>
        </tr>
      </table>
    </header>

    <div class="section">
      <strong>Bill To:</strong><br>
      {{ $order->customer->first_name }} {{ $order->customer->last_name }}<br>
      {{ $order->customer->company_name }}<br>
      {{ $order->customer->company_addr }}<br>
      @if($order->customer->gst_no)
        GSTIN: {{ $order->customer->gst_no }}<br>
      @endif
      @if($order->customer->pan_no)
        PAN: {{ $order->customer->pan_no }}<br>
      @endif
      Phone: {{ $order->customer->phone }}<br>
      Email: {{ $order->customer->email }}
    </div>

    <div class="section">
      <strong>Ship To:</strong><br>
      @if($order->customer->address)
        {{ $order->customer->address->address ?? 'Same as Billing Address' }}<br>
        @if($order->customer->address->address2)
          {{ $order->customer->address->address2 }}<br>
        @endif
        {{ $order->customer->address->city ?? '' }} {{ $order->customer->address->state ?? '' }} {{ $order->customer->address->pincode ?? '' }}
      @else
        Same as Billing Address
      @endif
    </div>

    <table class="items-table">
      <thead>
        <tr>
          <th style="width:8%">Sr.</th>
          <th style="width:40%">Item & Description</th>
          <th style="width:10%">Qty</th>
          <th style="width:10%">Unit</th>
          <th style="width:12%">Rate</th>
          <th style="width:8%">Tax %</th>
          <th style="width:12%">Amount</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="center">1</td>
          <td>
            <strong>{{ $order->product->warehouseProduct->product_name ?? 'N/A' }}</strong><br>
            @if($order->product->warehouseProduct->sku)
              SKU: {{ $order->product->warehouseProduct->sku }}<br>
            @endif
            @if($order->product->warehouseProduct->model_no)
              Model: {{ $order->product->warehouseProduct->model_no }}<br>
            @endif
           
          </td>
          <td class="center">{{ $order->quantity ?? 1 }}</td>
          <td class="center">Pcs</td>
          <td class="right">₹{{ number_format($subtotal, 2) }}</td>
          <td class="center">{{ $tax_rate }}%</td>
          <td class="right">₹{{ number_format($subtotal, 2) }}</td>
        </tr>
      </tbody>
    </table>

    <table class="totals-table">
      <tr>
        <td>Subtotal</td>
        <td class="right">₹{{ number_format($subtotal, 2) }}</td>
      </tr>
      <tr>
        <td>GST ({{ $tax_rate }}%)</td>
        <td class="right">₹{{ number_format($tax_amount, 2) }}</td>
      </tr>
      <tr>
        <td class="bold">Total</td>
        <td class="right bold">₹{{ number_format($total, 2) }}</td>
      </tr>
    </table>

    <div style="clear:both;margin-top:20px"></div>
    <div><strong>Amount in Words:</strong> {{ $amount_in_words }}</div>

    @if($order->deliveryMan)
    <div class="section">
      <strong>Delivery Information</strong><br>
      Delivery Man: {{ $order->deliveryMan->first_name }} {{ $order->deliveryMan->last_name }}<br>
      Contact: {{ $order->deliveryMan->phone }}<br>
      Address: {{ $order->deliveryMan->current_address }}
    </div>
    @endif

    <div class="section">
      <strong>Payment & Bank Details</strong><br>
      Bank: HDFC Bank<br>
      A/C No: 1234567890<br>
      IFSC: HDFC0000123<br>
      Branch: Mumbai Main Branch
    </div>

    <div class="footer">
      <table class="footer-table">
        <tr>
          <td style="width:60%">
            <em>This is a computer generated invoice and does not require signature.</em><br>
            <strong>Terms & Conditions:</strong><br>
            1. Payment due within 30 days of invoice date<br>
            2. All disputes subject to Mumbai jurisdiction<br>
            3. Goods once sold will not be taken back
          </td>
          <td style="width:40%;text-align:right">
            <strong>For {{ $company['name'] }}</strong><br><br><br>
            <strong>Authorised Signatory</strong>
          </td>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>
