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
                                            <span>{{ $order->created_at->format('d M Y h:i A') }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Order Source:</span>
                                            <span>{{ ucfirst($order->order_source ?? 'Website') }}</span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Total Items:</span>
                                            <span>{{ $order->orderItems->count() }} items</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Status:</span>
                                            <span
                                                class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'confirmed' ? 'info' : ($order->status === 'processing' ? 'primary' : ($order->status === 'shipped' ? 'primary' : ($order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : ($order->status === 'returned' ? 'warning' : 'secondary')))))) }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </li>
                                        @if ($order->confirmed_at)
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Confirmed At:</span>
                                                <span>{{ $order->confirmed_at->format('d M Y h:i A') }}</span>
                                            </li>
                                        @endif
                                        @if ($order->shipped_at)
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Shipped At:</span>
                                                <span>{{ $order->shipped_at->format('d M Y h:i A') }}</span>
                                            </li>
                                        @endif
                                        @if ($order->delivered_at)
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Delivered At:</span>
                                                <span>{{ $order->delivered_at->format('d M Y h:i A') }}</span>
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
                                            <span>{{ $order->user ? $order->user->name : $order->shipping_first_name . ' ' . $order->shipping_last_name }}</span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Email:</span>
                                            <span>{{ $order->user ? $order->user->email : $order->email }}</span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Phone:</span>
                                            <span>{{ $order->shipping_phone ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Right Column -->
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0">
                                            <span class="fw-semibold">Shipping Address:</span>
                                            <div class="mt-1">
                                                {{ $order->shipping_first_name }} {{ $order->shipping_last_name }}<br>
                                                {{ $order->shipping_address_line_1 }}<br>
                                                @if ($order->shipping_address_line_2)
                                                    {{ $order->shipping_address_line_2 }}<br>
                                                @endif
                                                {{ $order->shipping_city }}, {{ $order->shipping_state }}
                                                {{ $order->shipping_zipcode }}<br>
                                                {{ $order->shipping_country }}
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
                                            <th>HSN/SAC Code</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Tax Amount</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($item->product_image)
                                                            <img src="{{ asset($item->product_image) }}" alt="Product"
                                                                class="rounded me-2" width="50" height="50">
                                                        @else
                                                            <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                                                style="width: 50px; height: 50px;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-medium">{{ $item->product_name }}</div>
                                                            <small class="text-muted">SKU:
                                                                {{ $item->product_sku ?? 'N/A' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-medium">{{ $item->hsn_sac_code ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-medium">{{ $item->quantity }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="fw-medium">₹{{ number_format($item->unit_price, 2) }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="fw-medium">₹{{ number_format($item->igst_amount, 2) }}</span>
                                                    @if ($item->tax_percentage > 0)
                                                        <br><small
                                                            class="text-muted">({{ $item->tax_percentage }}%)</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span
                                                        class="fw-bold text-success">₹{{ number_format($item->total_price, 2) }}</span>
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
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">Payment Method:</span>
                                            <span
                                                class="badge bg-{{ $order->payment_method === 'cod' ? 'warning' : 'info' }}">
                                                @if ($order->payment_method === 'mastercard' || $order->payment_method === 'visa')
                                                    {{ ucfirst($order->payment_method) }} Card
                                                @elseif($order->payment_method === 'cod')
                                                    Cash on Delivery
                                                @else
                                                    {{ ucfirst($order->payment_method) }}
                                                @endif
                                            </span>
                                        </li>
                                        @if ($order->payment_method !== 'cod' && $order->card_last_four)
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Card Number:</span>
                                                <span>**** **** **** {{ $order->card_last_four }}</span>
                                            </li>
                                        @endif
                                        @if ($order->card_name)
                                            <li class="list-group-item border-0 d-flex align-items-center gap-2 flex-wrap">
                                                <span class="fw-semibold">Card Holder:</span>
                                                <span>{{ $order->card_name }}</span>
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
                                    <span>Subtotal:</span>
                                    <span class="fw-medium">₹{{ number_format($totals['subtotal'], 2) }}</span>
                                </li>
                                @if ($totals['shipping_charges'] > 0)
                                    <li class="list-group-item border-0 d-flex justify-content-between">
                                        <span>Shipping Charges:</span>
                                        <span
                                            class="fw-medium">₹{{ number_format($totals['shipping_charges'], 2) }}</span>
                                    </li>
                                @endif
                                @if ($totals['tax_amount'] > 0)
                                    <li class="list-group-item border-0 d-flex justify-content-between">
                                        <span>Tax Amount:</span>
                                        <span class="fw-medium">₹{{ number_format($totals['tax_amount'], 2) }}</span>
                                    </li>
                                @endif
                                @if ($totals['discount_amount'] > 0)
                                    <li class="list-group-item border-0 d-flex justify-content-between">
                                        <span>Discount:</span>
                                        <span
                                            class="fw-medium text-success">-₹{{ number_format($totals['discount_amount'], 2) }}</span>
                                    </li>
                                @endif
                                <li class="list-group-item border-0 d-flex justify-content-between border-top pt-3">
                                    <span class="fw-bold">Grand Total:</span>
                                    <span
                                        class="fw-bold text-success fs-5">₹{{ number_format($totals['grand_total'], 2) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Status Management Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Assign Delivery Man</h5>
                        </div>
                        <div class="card-body">
                            <form id="assign-delivery-man-form">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Delivery Man</label>
                                    <select class="form-select" name="status" id="delivery-man">
                                        <option value="">-- Select Delivery Man --</option>
                                        @forelse ($deliveryMen as $deliveryMan)
                                            <option value="{{ $deliveryMan->id }}" {{ $order->delivery_man_id == $deliveryMan->id ? 'selected' : '' }}>{{ $deliveryMan->first_name }}
                                                {{ $deliveryMan->last_name }}</option>
                                        @empty
                                            <option value="">No Delivery Men Found</option>
                                        @endforelse
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary w-100" id="assign-delivery-man-btn">
                                    <i class="fas fa-save me-1"></i> Assign
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Status Management Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Status Management</h5>
                        </div>
                        <div class="card-body">
                            <form id="status-update-form">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Order Status</label>
                                    <select class="form-select" name="status" id="order-status">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                            Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                            Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                            Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary w-100" id="update-status-btn">
                                    <i class="fas fa-save me-1"></i> Update Status
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('order.invoice', $order->id) }}" class="btn btn-success"
                                    target="_blank">
                                    <i class="fas fa-file-pdf me-1"></i> Download Invoice
                                </a>
                                <a href="{{ route('order.edit', $order->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-1"></i> Edit Order
                                </a>
                                @if (!in_array($order->status, ['shipped', 'delivered']))
                                    <button type="button" class="btn btn-danger" id="delete-order-btn"
                                        data-order-id="{{ $order->id }}">
                                        <i class="fas fa-trash me-1"></i> Delete Order
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
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
                <div class="modal-body">
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

            // Update order status
            $('#assign-delivery-man-btn').on('click', function() {
                const deliveryManId = $('#delivery-man').val();
                const button = $(this);
                const originalText = button.html();

                // Show loading state
                button.prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-1"></i> Assigning...');

                $.ajax({
                    url: `/e-commerce/order/${orderId}/assign-delivery-man`,
                    method: 'POST',
                    data: {
                        delivery_man_id: deliveryManId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message);
                            } else {
                                alert(response.message);
                            }
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
                            'Failed to assign delivery man';
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

            // Update order status
            $('#update-status-btn').on('click', function() {
                const newStatus = $('#order-status').val();
                const button = $(this);
                const originalText = button.html();

                // Show loading state
                button.prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-1"></i> Updating...');

                $.ajax({
                    url: `/e-commerce/order/${orderId}/update-status`,
                    method: 'POST',
                    data: {
                        status: newStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message);
                            } else {
                                alert(response.message);
                            }
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
        });
    </script>

@endsection
