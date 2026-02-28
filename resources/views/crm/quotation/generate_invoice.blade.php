@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row pt-3">
                <div class="col-xl-10 mx-auto">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Generate Invoice from Quotation #{{ $quotation->quote_number }}</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('quotation.storeInvoice', $quotation->id) }}"
                                id="invoiceForm">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Invoice Number</label>
                                        <input type="text" name="invoice_number" class="form-control"
                                            value="{{ $invoice->invoice_number ?? 'INV-' . time() }}">
                                        @if (isset($invoice))
                                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Invoice Date</label>
                                        <input type="date" name="invoice_date" class="form-control"
                                            value="{{ now()->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Due Date</label>
                                        <input type="date" name="due_date" class="form-control"
                                            value="{{ now()->addDays(30)->format('Y-m-d') }}" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Billing Address</label>
                                        <textarea name="billing_address" class="form-control" rows="3">{{ optional($quotation->leadDetails->customerAddress)->address1 }} {{ optional($quotation->leadDetails->customerAddress)->address2 }} {{ optional($quotation->leadDetails->customerAddress)->city }} {{ optional($quotation->leadDetails->customerAddress)->state }} {{ optional($quotation->leadDetails->customerAddress)->pincode }}</textarea>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Shipping Address</label>
                                        <textarea name="shipping_address" class="form-control" rows="3">{{ optional($quotation->leadDetails->customerAddress)->address1 }} {{ optional($quotation->leadDetails->customerAddress)->address2 }} {{ optional($quotation->leadDetails->customerAddress)->city }} {{ optional($quotation->leadDetails->customerAddress)->state }} {{ optional($quotation->leadDetails->customerAddress)->pincode }}</textarea>
                                    </div>

                                    <div class="col-12">
                                        <h6>Products</h6>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <th>SKU</th>
                                                    <th>HSN</th>
                                                    <th>Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($quotation->products as $product)
                                                    <tr>
                                                        <td>{{ $product->name ?? ($product->product_name ?? 'Item') }}</td>
                                                        <td>{{ $product->type ?? '-' }}</td>
                                                        <td>{{ $product->brand ?? '-' }}</td>
                                                        <td>{{ $product->model_no ?? '-' }}</td>
                                                        <td>{{ $product->sku ?? '-' }}</td>
                                                        <td>{{ $product->hsn ?? ($product->hsn_code ?? '-') }}</td>
                                                        <td>{{ $product->quantity ?? 1 }}</td>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Subtotal</label>
                                        <input type="text" readonly class="form-control" id="subtotal"
                                            value="₹{{ number_format($invoice->subtotal ?? ($quotation->amcData->total_amount ?? 0), 2) }}">
                                        <input type="hidden" id="subtotal_value"
                                            value="{{ $invoice->subtotal ?? ($quotation->amcData->total_amount ?? 0) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Tax</label>
                                        <input type="number" step="0.01" name="tax_amount" class="form-control"
                                            id="tax_amount"
                                            value="{{ old('tax_amount', $invoice->total_tax ?? ($quotation->tax_amount ?? 0)) }}"
                                            placeholder="0.00" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Total Discount</label>
                                        <input type="number" step="0.01" name="total_discount" class="form-control"
                                            id="total_discount"
                                            value="{{ old('total_discount', $invoice->total_discount ?? 0) }}"
                                            placeholder="0.00">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Round Off</label>
                                        <input type="number" step="0.01" name="round_off" class="form-control"
                                            id="round_off" value="{{ old('round_off', $invoice->round_off ?? 0) }}"
                                            placeholder="0.00">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Grand Total</label>
                                        <input type="text" readonly class="form-control" id="grand_total"
                                            value="₹{{ number_format(old('grand_total', $invoice->grand_total ?? ($quotation->amcData->total_amount ?? 0)), 2) }}">
                                        <input type="hidden" name="grand_total" id="grand_total_value"
                                            value="{{ old('grand_total', $invoice->grand_total ?? ($quotation->amcData->total_amount ?? 0)) }}">
                                    </div>

                                    <input type="hidden" name="status" id="invoice_status"
                                        value="{{ $invoice->status ?? 'draft' }}">

                                    <div class="col-12 mt-3">
                                        <button type="button" class="btn btn-secondary" id="saveDraftBtn">Save as
                                            Draft</button>
                                        <button type="button" class="btn btn-primary" id="sendBtn">Save & Send</button>
                                        @if (isset($invoice) && $invoice->status === 'sent')
                                            <a href="{{ route('quotation.viewInvoice', $quotation->id) }}"
                                                class="btn btn-outline-primary">View Invoice</a>
                                        @endif
                                        <a href="{{ route('quotation.view', $quotation->id) }}"
                                            class="btn btn-light">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Calculate Grand Total = Subtotal + Tax - Discount + RoundOff
        function calculateGrandTotal() {
            const subtotal = parseFloat(document.getElementById('subtotal_value').value) || 0;
            const tax = parseFloat(document.getElementById('tax_amount').value) || 0;
            const discount = parseFloat(document.getElementById('total_discount').value) || 0;
            const roundOff = parseFloat(document.getElementById('round_off').value) || 0;

            const grandTotal = subtotal + tax - discount + roundOff;

            document.getElementById('grand_total').value = '₹' + grandTotal.toFixed(2);
            document.getElementById('grand_total_value').value = grandTotal.toFixed(2);
        }

        // Attach event listeners for auto-calculation
        document.getElementById('tax_amount').addEventListener('input', calculateGrandTotal);
        document.getElementById('total_discount').addEventListener('input', calculateGrandTotal);
        document.getElementById('round_off').addEventListener('input', calculateGrandTotal);

        // Calculate on page load
        document.addEventListener('DOMContentLoaded', calculateGrandTotal);

        document.getElementById('saveDraftBtn').addEventListener('click', function() {
            document.getElementById('invoice_status').value = 'draft';
            document.getElementById('invoiceForm').submit();
        });

        document.getElementById('sendBtn').addEventListener('click', function() {
            document.getElementById('invoice_status').value = 'sent';
            document.getElementById('invoiceForm').submit();
        });
    </script>
@endsection
