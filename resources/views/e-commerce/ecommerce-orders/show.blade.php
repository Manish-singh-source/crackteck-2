@extends('layout.master')

@section('main-content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Order Details - #{{ $order->order_number }}</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('ecommerce-order.index') }}">E-Commerce Orders</a></li>
                                    <li class="breadcrumb-item active">Order Details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-9">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title flex-grow-1 mb-0">Order #{{ $order->order_number }}</h5>
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('ecommerce-order.invoice', $order->id) }}" 
                                           class="btn btn-success btn-sm">
                                            <i class="ri-download-2-line align-middle me-1"></i> Download Invoice
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-nowrap align-middle table-borderless mb-0">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th scope="col">Product Details</th>
                                                <th scope="col">HSN/SAC</th>
                                                <th scope="col">Rate</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Tax %</th>
                                                <th scope="col">Tax Amount</th>
                                                <th scope="col" class="text-end">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->orderItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                            <img src="{{ $item->product_image ? asset('storage/' . $item->product_image) : asset('assets/images/products/img-8.png') }}" 
                                                                 alt="" class="img-fluid d-block">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-14 mb-1">{{ $item->product_name }}</h6>
                                                            <p class="text-muted mb-0">SKU: {{ $item->product_sku }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $item->hsn_sac_code }}</td>
                                                <td>₹{{ number_format($item->unit_price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->tax_percentage }}%</td>
                                                <td>₹{{ number_format($item->igst_amount, 2) }}</td>
                                                <td class="text-end">₹{{ number_format($item->final_amount, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td colspan="6"><strong>Sub Total</strong></td>
                                                <td class="text-end"><strong>₹{{ number_format($totals['subtotal'], 2) }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"><strong>Total Tax</strong></td>
                                                <td class="text-end"><strong>₹{{ number_format($totals['total_tax'], 2) }}</strong></td>
                                            </tr>
                                            @if($totals['shipping_charges'] > 0)
                                            <tr>
                                                <td colspan="6"><strong>Shipping Charges</strong></td>
                                                <td class="text-end"><strong>₹{{ number_format($totals['shipping_charges'], 2) }}</strong></td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td colspan="6"><strong>Rounding Off</strong></td>
                                                <td class="text-end"><strong>{{ $totals['rounding_off'] >= 0 ? '+' : '' }}₹{{ number_format($totals['rounding_off'], 2) }}</strong></td>
                                            </tr>
                                            <tr class="table-active">
                                                <td colspan="6"><strong>Total Amount</strong></td>
                                                <td class="text-end"><strong>₹{{ number_format($totals['rounded_total'], 2) }}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex">
                                    <h5 class="card-title flex-grow-1 mb-0">Order Status</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Current Status</label>
                                    <select class="form-select" id="order-status" data-order-id="{{ $order->id }}">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Order Date</label>
                                    <p class="text-muted mb-0">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Payment Method</label>
                                    <p class="text-muted mb-0">
                                        <span class="badge bg-{{ $order->payment_method == 'mastercard' ? 'info' : 'warning' }}">
                                            {{ $order->payment_method == 'mastercard' ? 'Credit Card' : 'Cash on Delivery' }}
                                        </span>
                                    </p>
                                </div>

                                @if($order->payment_method == 'mastercard')
                                <div class="mb-3">
                                    <label class="form-label">Card Details</label>
                                    <p class="text-muted mb-1">{{ $order->card_name }}</p>
                                    <p class="text-muted mb-0">**** **** **** {{ $order->card_last_four }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Customer Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="mb-1">{{ $order->user->name }}</h6>
                                    <p class="text-muted mb-0">{{ $order->user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Shipping Address</h5>
                            </div>
                            <div class="card-body">
                                <address class="mb-0">
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

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Billing Address</h5>
                            </div>
                            <div class="card-body">
                                <address class="mb-0">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    // Handle status change
    $('#order-status').on('change', function() {
        const orderId = $(this).data('order-id');
        const newStatus = $(this).val();
        const selectElement = $(this);
        const originalValue = selectElement.data('original-value');

        $.ajax({
            url: `/e-commerce/ecommerce-order/${orderId}/update-status`,
            method: 'POST',
            data: {
                status: newStatus,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    selectElement.data('original-value', newStatus);
                } else {
                    toastr.error(response.message);
                    selectElement.val(originalValue);
                }
            },
            error: function() {
                toastr.error('Failed to update order status');
                selectElement.val(originalValue);
            }
        });
    });

    // Store original value
    $('#order-status').data('original-value', $('#order-status').val());
});
</script>
@endsection
