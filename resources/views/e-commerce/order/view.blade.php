@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">E-Commerce Order Details</h4>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('order.invoice', $order->id) }}" class="btn btn-success" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i> Download Invoice
                    </a>
                    <a href="{{ route('order.edit', $order->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit Order
                    </a>
                    <a href="{{ route('order.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Orders
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8">

                    <!-- Order Summary Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Order Summary</h5>
                                <div class="fw-bold text-dark">Order #{{ $order->order_number }}</div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Order Date:</span>
                                            <span>{{ $order->created_at ? \App\Helpers\DateFormat::formatDateTime($order->created_at) : 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Order Source:</span>
                                            @php
                                                $sourcePlatform = match ($order->source_platform) {
                                                    'website' => 'Website',
                                                    'mobile_app' => 'Mobile App',
                                                    'admin_panel' => 'Admin Panel',
                                                };
                                            @endphp
                                            <span>{{ $sourcePlatform }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Total Items:</span>
                                            <span>{{ $order->orderItems->count() }} items</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Total Quantity:</span>
                                            <span>{{ $order->orderItems->sum('quantity') }}</span>
                                        </li>
                                        <!-- New Delivery Status Display -->
                                        @if ($order->status)
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Status:</span>
                                                @php
                                                    $deliveryStatusBadgeColor = match ($order->status) {
                                                        'pending' => 'warning',
                                                        'admin_approved' => 'info',
                                                        'assigned_delivery_man' => 'primary',
                                                        'order_accepted' => 'primary',
                                                        'product_taken' => 'primary',
                                                        'delivered' => 'success',
                                                        'cancelled' => 'danger',
                                                        'returned' => 'warning',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $deliveryStatusBadgeColor }}">
                                                    @if ($order->status === 'pending')
                                                        Pending
                                                    @elseif ($order->status === 'admin_approved')
                                                        Admin Approved
                                                    @elseif ($order->status === 'assigned_delivery_man')
                                                        Assigned to Delivery Man
                                                    @elseif ($order->status === 'order_accepted')
                                                        Order Accepted
                                                    @elseif ($order->status === 'product_taken')
                                                        Product Taken
                                                    @elseif ($order->status === 'delivered')
                                                        Delivered
                                                    @elseif ($order->status === 'cancelled')
                                                        Cancelled
                                                    @elseif ($order->status === 'returned')
                                                        Returned
                                                    @else
                                                        Unknown
                                                    @endif
                                                </span>
                                            </li>
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Expected Delivery Date:</span>
                                                <span>{{ $order->expected_delivery_date ? \App\Helpers\DateFormat::formatDateTime($order->expected_delivery_date) : 'N/A' }}</span>
                                            </li>
                                        @endif
                                        <!-- Return Delivery Status Display - Show for all return order statuses -->
                                        @if ($returnOrder)
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold text-danger">Return Status:</span>
                                                @php
                                                    $returnStatusBadgeColor = match ($returnOrder->status) {
                                                        'pending' => 'warning',
                                                        'assigned' => 'info',
                                                        'accepted' => 'primary',
                                                        'picked' => 'primary',
                                                        'received' => 'success',
                                                        default => 'secondary',
                                                    };
                                                    $returnStatusText = match ($returnOrder->status) {
                                                        'pending' => 'Return Pending',
                                                        'assigned' => 'Return Assigned',
                                                        'accepted' => 'Return Accepted',
                                                        'picked' => 'Return Picked',
                                                        'received' => 'Received in Warehouse',
                                                        default => 'Unknown',
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $returnStatusBadgeColor }}">{{ $returnStatusText }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            @php
                                                $assignedPersonType = match ($order->assigned_person_type) {
                                                    'engineer' => 'Engineer',
                                                    'delivery_man' => 'Delivery Man',
                                                };
                                            @endphp
                                            <span class="fw-semibold">Assigned Person Type:</span>
                                            <span>{{ $assignedPersonType ?? 'N/A' }}</span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Confirmed At:</span>
                                            <span>{{ \App\Helpers\DateFormat::formatDateTime($order->confirmed_at) ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Assigned Person:</span>
                                            <span>{{ $assignedPerson ? $assignedPerson->first_name . ' ' . $assignedPerson->last_name : 'N/A' }}</span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Assigned At:</span>
                                            <span>{{ $order->assigned_at ? \App\Helpers\DateFormat::formatDateTime($order->assigned_at) : 'N/A' }}</span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Accepted At:</span>
                                            <span>{{ $order->accepted_at ? \App\Helpers\DateFormat::formatDateTime($order->accepted_at) : 'N/A' }}</span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Shipped At:</span>
                                            <span>{{ $order->shipped_at ? \App\Helpers\DateFormat::formatDateTime($order->shipped_at) : 'N/A' }}</span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Delivered At:</span>
                                            <span>{{ $order->delivered_at ? \App\Helpers\DateFormat::formatDateTime($order->delivered_at) : 'N/A' }}</span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Cancelled At:</span>
                                            <span>{{ $order->cancelled_at ? \App\Helpers\DateFormat::formatDateTime($order->cancelled_at) : 'N/A' }}</span>
                                        </li>

                                        @if ($order->expected_delivery_date)
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Expected Delivery:</span>
                                                <span>{{ $order->expected_delivery_date ? \App\Helpers\DateFormat::formatDateTime($order->expected_delivery_date) : 'N/A' }}</span>
                                            </li>
                                        @endif

                                        <!-- Return Person Timeline -->
                                        @if ($returnOrder)
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap mt-3 pt-3 border-top">
                                                <span class="fw-semibold text-primary">Return Person Type:</span>
                                                <span>Delivery Man</span>
                                            </li>
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Return Person:</span>
                                                <span>{{ $returnOrder->deliveryMan ? $returnOrder->deliveryMan->first_name . ' ' . $returnOrder->deliveryMan->last_name : 'N/A' }}</span>
                                            </li>
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Return Assigned At:</span>
                                                <span>{{ $returnOrder->return_assigned_at ? \App\Helpers\DateFormat::formatDateTime($returnOrder->return_assigned_at): 'N/A' }}</span>
                                            </li>
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Return Accepted At:</span>
                                                <span>{{ $returnOrder->return_accepted_at ? \App\Helpers\DateFormat::formatDateTime($returnOrder->return_accepted_at): 'N/A' }}</span>
                                            </li>
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Return Picked At:</span>
                                                <span>{{ $returnOrder->return_picked_at ? \App\Helpers\DateFormat::formatDateTime($returnOrder->return_picked_at): 'N/A' }}</span>
                                            </li>
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Return Received At:</span>
                                                <span>{{ $returnOrder->return_delivered_at ? \App\Helpers\DateFormat::formatDateTime($returnOrder->return_delivered_at): 'N/A' }}</span>
                                            </li>
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Return Completed At:</span>
                                                <span>{{ $returnOrder->return_completed_at ? \App\Helpers\DateFormat::formatDateTime($returnOrder->return_completed_at): 'N/A' }}</span>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Details Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Customer Information</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Customer Name:</span>
                                            <span>{{ $order->customer ? $order->customer->first_name . ' ' . $order->customer->last_name : $order->shipping_first_name . ' ' . $order->shipping_last_name }}</span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Email:</span>
                                            <span>{{ $order->customer ? $order->customer->email : $order->email }}</span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Phone:</span>
                                            <span>{{ $order->customer->phone ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Right Column -->
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0">
                                            <span class="fw-semibold">Shipping Address:</span>
                                            <div class="mt-1">
                                                {{ $order->customer->first_name ?? '' }}
                                                {{ $order->customer->last_name ?? '' }}<br>
                                                {{ $order->shippingAddress->address1 ?? '' }}<br>
                                                @if ($order->shippingAddress->address2)
                                                    {{ $order->shippingAddress->address2 }}<br>
                                                @endif
                                                {{ $order->shippingAddress->city ?? '' }},
                                                {{ $order->shippingAddress->state ?? '' }}
                                                {{ $order->shippingAddress->pincode ?? '' }}<br>
                                                {{ $order->shippingAddress->country ?? '' }}
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Order Items Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Order Items</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>HSN & SKU Code</th>
                                            <th>Quantity</th>
                                            <th>Price Per Unit</th>
                                            <th>Tax Amount</th>
                                            <th>Other Detail</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($item->product->main_product_image)
                                                            <img src="{{ asset($item->product->main_product_image) }}"
                                                                alt="Product" class="rounded me-2" width="50"
                                                                height="50">
                                                        @else
                                                            <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                                                style="width: 50px; height: 50px;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-medium">{{ $item->product->product_name }}
                                                            </div>
                                                            <small class="text-muted">Model:
                                                                {{ $item->product->model_no ?? 'N/A' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <small class="text-muted">HSN Code:
                                                            {{ $item->hsn_code ?? 'N/A' }}</small>
                                                        <br>
                                                        <small class="text-muted">SKU Code:
                                                            {{ $item->product_sku ?? 'N/A' }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-medium">{{ $item->quantity }}</span>
                                                </td>
                                                <td>
                                                    <small class="fw-medium">Unit Price:
                                                        ₹{{ number_format($item->unit_price, 2) }}</small>
                                                    <br>
                                                    <small class="fw-medium">Discount Price:
                                                        ₹{{ number_format($item->discount_per_unit, 2) }}</small>
                                                    <br>
                                                </td>
                                                <td>
                                                    {{-- <span
                                                        class="fw-medium">₹{{ number_format($item->igst_amount, 2) }}</span>
                                                    @if ($item->tax_percentage > 0)
                                                        <br><small
                                                            class="text-muted">({{ $item->tax_percentage }}%)</small>
                                                    @endif --}}
                                                    <small class="fw-medium">
                                                        ₹{{ number_format($item->tax_per_unit, 2) }}</small>
                                                </td>
                                                <td>
                                                    <small class="fw-medium">Weight:
                                                        {{ $item->weight ?? 'N/A' }}</small>
                                                    <br>
                                                    <small class="fw-medium">Dimensions:
                                                        {{ $item->dimensions ?? 'N/A' }}</small>
                                                    <br>
                                                    <small class="fw-medium">COD:
                                                        @php
                                                            $cod  = match ($item->cod ) {
                                                                'no' => 'No',
                                                                'yes' => 'Yes'
                                                            }
                                                        @endphp
                                                        {{ $cod ?? 'N/A' }}</small>
                                                    <br>
                                                    <small class="fw-medium">Installation:
                                                        @php
                                                            $installation  = match ($item->installation ) {
                                                                'no' => 'No',
                                                                'yes' => 'Yes'
                                                            }
                                                        @endphp
                                                        {{ $installation ?? 'N/A' }}</small>
                                                    <br>
                                                </td>
                                                <td>
                                                    <span
                                                        class="fw-bold text-success">₹{{ number_format($item->line_total, 2) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Payment Information</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($order->orderPayments as $key => $payment)
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Payment Method:</span>
                                                @php
                                                    $paymentMethod = [
                                                        'online' => 'Online',
                                                        'cod' => 'Cash on Delivery',
                                                        'cheque' => 'Cheque',
                                                        'bank_transfer' => 'Bank Transfer',
                                                    ];
                                                @endphp
                                                <span class="badge bg-info">
                                                    @if ($payment->payment_method)
                                                        {{ $paymentMethod[$payment->payment_method] }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </span>
                                            </li>
                                            @if ($payment->payment_method !== 'cod' && $payment->card_last_four)
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                    <span class="fw-semibold">Card Number:</span>
                                                    <span>**** **** **** {{ $payment->card_last_four }}</span>
                                                </li>
                                            @endif
                                            @if ($payment->card_name)
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                    <span class="fw-semibold">Card Holder:</span>
                                                    <span>{{ $payment->card_name }}</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        @if (!$order->billing_same_as_shipping)
                                            <div>
                                                <span class="fw-semibold">Billing Address:</span>
                                                <div class="mt-1">
                                                    {{ $order->billing_first_name }} {{ $order->billing_last_name }}<br>
                                                    {{ $order->billing_address_line_1 }}<br>
                                                    @if ($order->billing_address_line_2)
                                                        {{ $order->billing_address_line_2 }}<br>
                                                    @endif
                                                    {{ $order->billing_city }}, {{ $order->billing_state }}
                                                    {{ $order->billing_zipcode }}<br>
                                                    {{ $order->billing_country }}
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Billing address same as shipping address
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>

                <!-- Right Column - Order Summary -->
                <div class="col-xl-4">
                    <!-- Order Totals Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item border-0 d-flex justify-content-between">
                                    <span>Total Items:</span>
                                    <span class="fw-medium">{{ $order->orderItems->count() }}</span>
                                </li>
                                <li class="list-group-item border-0 d-flex justify-content-between">
                                    <span>Total Quantity:</span>
                                    <span class="fw-medium">{{ $order->orderItems->sum('quantity') }}</span>
                                </li>
                                <li class="list-group-item border-0 d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span class="fw-medium">₹{{ number_format($order->subtotal, 2) }}</span>
                                </li>
                                <li class="list-group-item border-0 d-flex justify-content-between">
                                    <span>Tax Amount:</span>
                                    <span class="fw-medium">₹{{ number_format($order->tax_amount, 2) }}</span>
                                </li>
                                <li class="list-group-item border-0 d-flex justify-content-between">
                                    <span>Discount:</span>
                                    <span
                                        class="fw-medium text-success">-₹{{ number_format($order->discount_amount, 2) }}</span>
                                </li>
                                <li class="list-group-item border-0 d-flex justify-content-between">
                                    <span>Shipping Charges:</span>
                                    <span class="fw-medium">₹{{ number_format($order->shipping_charges, 2) }}</span>
                                </li>
                                <li class="list-group-item border-0 d-flex justify-content-between">
                                    <span>Coupon Applied:</span>
                                    <span class="fw-medium">₹{{ number_format($order->coupon_code, 2) }}</span>
                                </li>
                                <li class="list-group-item border-0 d-flex justify-content-between border-top pt-3">
                                    <span class="fw-bold">Grand Total:</span>
                                    <span
                                        class="fw-bold text-success fs-5">₹{{ number_format($order->total_amount, 2) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Product Picked - In Transit to Warehouse Section -->
                    @if ($returnOrder && $returnOrder->status === 'picked')
                        <div class="card mt-3 border-primary">
                            <div class="card-header bg-primary text-white border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-truck me-2"></i>
                                    <h5 class="card-title mb-0">Product Picked - In Transit to Warehouse</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Return Order #{{ $returnOrder->return_order_number }}</strong> has been picked up from the customer.
                                    <br>
                                    <small>Picked at: {{ $returnOrder->return_picked_at ? $returnOrder->return_picked_at->format('d M Y h:i A') : 'N/A' }}</small>
                                </div>
                                
                                <!-- Warehouse Receive Form -->
                                <form action="{{ route('order.return.receive', $returnOrder->id) }}" method="POST" id="receive-return-form">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="d-flex align-items-end gap-2">
                                        <div class="flex-grow-1">
                                            <label for="warehouse_status" class="form-label fw-semibold">Warehouse Action</label>
                                            <select class="form-select" id="warehouse_status" name="warehouse_status" required>
                                                <option value="" selected disabled>-- Select Action --</option>
                                                <option value="received">Mark as Received in Warehouse</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-warehouse me-1"></i> Update Status
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Item Received in Warehouse Section -->
                    @if ($returnOrder && $returnOrder->status === 'received')
                        <div class="card mt-3 border-success">
                            <div class="card-header bg-success text-white border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-warehouse me-2"></i>
                                    <h5 class="card-title mb-0">Item Received in Warehouse</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-success mb-3">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Return Order #{{ $returnOrder->return_order_number }}</strong> has been received in the warehouse.
                                    <br>
                                    <small>Received at: {{ $returnOrder->return_delivered_at ? $returnOrder->return_delivered_at->format('d M Y h:i A') : 'N/A' }}</small>
                                </div>
                                
                                <!-- Returned Product Details -->
                                <h6 class="fw-semibold mb-3">Returned Product Details:</h6>
                                @if ($order->orderItems && $order->orderItems->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->orderItems as $item)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @if ($item->product->main_product_image)
                                                                    <img src="{{ asset($item->product->main_product_image) }}" 
                                                                        alt="Product" class="rounded me-2" width="40" height="40">
                                                                @else
                                                                    <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                                                        style="width: 40px; height: 40px;">
                                                                        <i class="fas fa-image text-muted"></i>
                                                                    </div>
                                                                @endif
                                                                <div>
                                                                    <div class="fw-medium">{{ $item->product->product_name }}</div>
                                                                    <small class="text-muted">{{ $item->product->model_no ?? 'N/A' }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>₹{{ number_format($item->unit_price, 2) }}</td>
                                                        <td>₹{{ number_format($item->line_total, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">No product details available.</p>
                                @endif

                                <div class="mt-3 pt-3 border-top">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{-- <p class="mb-1"><strong>Return Reason:</strong> {{ $returnOrder->return_reason ?? 'N/A' }}</p> --}}
                                            @if ($returnOrder->refund_status !== 'completed')
                                                <!-- Refund Button with Confirmation -->
                                                <form action="{{ route('order.return.complete-refund', $returnOrder->id) }}" method="POST" id="complete-refund-form-{{ $returnOrder->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" class="btn btn-success btn-sm" onclick="confirmRefund({{ $returnOrder->id }}, {{ $returnOrder->refund_amount ?? 0 }})">
                                                        <i class="fas fa-rupee-sign me-1"></i> Refund ₹{{ number_format($returnOrder->refund_amount ?? 0, 2) }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <p class="mb-0"><strong>Refund Status:</strong> 
                                                @php
                                                    $refundStatusBadgeColor = match ($returnOrder->refund_status) {
                                                        'pending' => 'warning',
                                                        'processing' => 'info',
                                                        'completed' => 'success',
                                                        'failed' => 'danger',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $refundStatusBadgeColor }}">{{ ucfirst($returnOrder->refund_status ?? 'Pending') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Assign Return Delivery Man Card - Show only when order is delivered and return status is pending/assigned -->
                    @if ($order->status === 'delivered' && $returnOrder && in_array($returnOrder->status, ['pending', 'assigned']))
                        <div class="card mt-3">
                            <div class="card-header border-bottom-dashed">
                                <div class="d-flex">
                                    <h5 class="card-title flex-grow-1 mb-0">
                                        <i class="fas fa-truck-loading me-2"></i>Assign Return Delivery Man
                                    </h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('order.assign-person', $order->id) }}" method="POST"
                                    id="assign-return-delivery-man-form">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="assigned_person_type" value="delivery_man">

                                    <div class="mb-3">
                                        <label for="return_delivery_man_id" class="form-label">Select Delivery Man for Return</label>
                                        <select class="form-select @error('delivery_man_id') is-invalid @enderror"
                                            id="return_delivery_man_id" name="delivery_man_id">
                                            <option value="" selected disabled>-- Select Delivery Man --</option>
                                            @foreach ($deliveryMen as $deliveryMan)
                                                <option value="{{ $deliveryMan->id }}"
                                                    @if ($returnOrder && $returnOrder->delivery_man_id == $deliveryMan->id) selected @endif>
                                                    {{ $deliveryMan->first_name }} {{ $deliveryMan->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('delivery_man_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-warning w-100 mt-3">
                                        <i class="mdi mdi-check-circle me-2"></i>Assign Return Delivery Man
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Assign Delivery Man Card - Show only when status is admin_approved -->
                    @if ($order->status === 'admin_approved')
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="d-flex">
                                    <h5 class="card-title flex-grow-1 mb-0">
                                        Assign Person
                                    </h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('order.assign-person', $order->id) }}" method="POST"
                                    id="assign-delivery-man-form">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="assigned_person_type" class="form-label">Select Assignment Type</label>
                                        <select class="form-select @error('assigned_person_type') is-invalid @enderror"
                                            id="assigned_person_type" name="assigned_person_type" required disabled>
                                            <option value="delivery_man" selected>Delivery Man</option>
                                        </select>
                                        <input type="hidden" name="assigned_person_type" value="delivery_man">
                                        @error('assigned_person_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3" id="deliveryManSection" style="display: {{ $order->assigned_person_type == 'delivery_man' ? 'block' : 'none' }};">
                                        <label for="delivery_man_id" class="form-label">Select Delivery Man</label>
                                        <select class="form-select @error('delivery_man_id') is-invalid @enderror"
                                            id="delivery_man_id" name="delivery_man_id">
                                            <option value="" selected disabled>-- Select Delivery Man --</option>
                                            @foreach ($deliveryMen as $deliveryMan)
                                                <option value="{{ $deliveryMan->id }}"
                                                    @if ($order->assigned_person_id == $deliveryMan->id) selected @endif>
                                                    {{ $deliveryMan->first_name }} {{ $deliveryMan->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('delivery_man_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3" id="engineerSection" style="display: {{ $order->assigned_person_type == 'engineer' ? 'block' : 'none' }};">
                                        <label for="engineer_id" class="form-label">Select Engineer</label>
                                        <select class="form-select @error('engineer_id') is-invalid @enderror"
                                            id="engineer_id" name="engineer_id">
                                            <option value="" selected disabled>-- Select Engineer --</option>
                                            @foreach ($engineers as $engineer)
                                                <option value="{{ $engineer->id }}"
                                                    @if ($order->assigned_person_id == $engineer->id) selected @endif>
                                                    {{ $engineer->first_name }} {{ $engineer->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('engineer_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 mt-3">
                                        <i class="mdi mdi-check-circle me-2"></i>Assign Person
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endif

                    <!-- Product Pickup Card - Show only when status is order_accepted -->
                    @if ($order->status === 'order_accepted')
                        <div class="card mt-3">
                            <div class="card-header border-bottom-dashed bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-box-open me-2"></i>Product Pickup Confirmation
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('order.product-pickup', $order->id) }}" method="POST"
                                    id="product-pickup-form">
                                    @csrf
                                    @method('POST')

                                    <div class="alert alert-info mb-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Please confirm that the product has been picked up from the warehouse.
                                    </div>

                                    <div class="mb-3">
                                        <label for="pickup_confirmation" class="form-label">Confirmation</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                id="pickup_confirmation" name="pickup_confirmation" value="1" required>
                                            <label class="form-check-label" for="pickup_confirmation">
                                                I confirm that the product has been picked up from the warehouse
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success" id="submit-btn">
                                            <i class="fas fa-check me-1"></i>Confirm Product Pickup
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3">
                    Are you sure you want to delete this order? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete Order</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const orderId = {{ $order->id }};

            // Handle assigned person type change
            $('#assigned_person_type').on('change', function() {
                var selectedValue = $(this).val();

                if (selectedValue === 'engineer') {
                    $('#deliveryManSection').hide();
                    $('#engineerSection').show();
                    $('#delivery_man_id').prop('required', false);
                    $('#engineer_id').prop('required', true);
                } else if (selectedValue === 'delivery_man') {
                    $('#engineerSection').hide();
                    $('#deliveryManSection').show();
                    $('#engineer_id').prop('required', false);
                    $('#delivery_man_id').prop('required', true);
                } else {
                    $('#engineerSection').hide();
                    $('#deliveryManSection').hide();
                    $('#delivery_man_id').prop('required', false);
                    $('#engineer_id').prop('required', false);
                }
            });

            // Initialize required fields based on current selection
            var currentAssignedPersonType = '{{ $order->assigned_person_type }}';
            if (currentAssignedPersonType === 'engineer') {
                $('#engineer_id').prop('required', true);
                $('#delivery_man_id').prop('required', false);
            } else if (currentAssignedPersonType === 'delivery_man') {
                $('#delivery_man_id').prop('required', true);
                $('#engineer_id').prop('required', false);
            }

            // Update order status
            $('#update-status-btn').on('click', function() {
                const newStatus = $('#order-status').val();
                const button = $(this);
                const originalText = button.html();

                // Show loading state
                button.prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-1"></i> Updating...');

                $.ajax({
                    url: `/demo/e-commerce/order/${orderId}/update-status`,
                    method: 'POST',
                    data: {
                        order_status: newStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Response:', response);
                        if (response.success) {

                            // Reload page to show updated timestamps
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(response.message);
                            } else {
                                alert(response.message);
                            }
                        }
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON?.message ||
                            'Failed to update order status';
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }
                    },
                    complete: function() {
                        // Restore button state
                        button.prop('disabled', false).html(originalText);
                    }
                });
            });

            // Delete order
            $('#delete-order-btn').on('click', function() {
                $('#deleteModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                const button = $(this);
                const originalText = button.html();

                // Show loading state
                button.prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-1"></i> Deleting...');

                $.ajax({
                    url: `/e-commerce/order/${orderId}`,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#deleteModal').modal('hide');
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message);
                            } else {
                                alert(response.message);
                            }
                            // Redirect to orders list
                            setTimeout(() => {
                                window.location.href = '{{ route('order.index') }}';
                            }, 1000);
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(response.message);
                            } else {
                                alert(response.message);
                            }
                        }
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON?.message || 'Failed to delete order';
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }
                    },
                    complete: function() {
                        // Restore button state
                        button.prop('disabled', false).html(originalText);
                    }
                });
            });

            // Handle assign delivery man form submission
            $('#assign-delivery-man-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const button = form.find('button[type="submit"]');
                const originalText = button.html();

                button.prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-1"></i> Assigning...');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(response.message);
                            } else {
                                alert(response.message);
                            }
                        }
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON?.message ||
                            'Failed to assign delivery man';
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }
                    },
                    complete: function() {
                        button.prop('disabled', false).html(originalText);
                    }
                });
            });

            // Handle assign return delivery man form submission
            $('#assign-return-delivery-man-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const button = form.find('button[type="submit"]');
                const originalText = button.html();

                button.prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-1"></i> Assigning...');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message);
                            } else {
                                alert(response.message);
                            }
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(response.message);
                            } else {
                                alert(response.message);
                            }
                        }
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON?.message ||
                            'Failed to assign return delivery man';
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }
                    },
                    complete: function() {
                        button.prop('disabled', false).html(originalText);
                    }
                });
            });
        });
    </script>

    <script>
        // Function to confirm refund
        function confirmRefund(returnOrderId, refundAmount) {
            const formattedAmount = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(refundAmount);
            
            if (confirm('Are you sure you want to refund ' + formattedAmount + ' to the customer?')) {
                document.getElementById('complete-refund-form-' + returnOrderId).submit();
            }
        }
    </script>
@endsection
