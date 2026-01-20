@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Orders</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Order</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit E-Commerce Order #{{ $order->order_number }}</h4>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('order.view', $order->id) }}" class="btn btn-info">
                        <i class="fas fa-eye me-1"></i> View Order
                    </a>
                    <a href="{{ route('order.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Orders
                    </a>
                </div>
            </div>

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

            @if (in_array($order->status, ['shipped', 'delivered']))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    <strong>Note:</strong> This order has been {{ $order->status }} and cannot be modified.
                </div>
            @endif

            <form action="{{ route('order.update', $order->id) }}" method="POST" id="orderForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-lg-8">
                        <!-- Order Information Card -->
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Order Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Order Number</label>
                                            <input type="text" class="form-control" value="{{ $order->order_number }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Order Date</label>
                                            <input type="text" class="form-control"
                                                value="{{ $order->created_at->format('d M Y h:i A') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Customer</label>
                                            <input type="text" class="form-control"
                                                value="{{ $order->customer ? $order->customer->first_name . ' ' . $order->customer->last_name : $order->shipping_first_name . ' ' . $order->shipping_last_name }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Total Amount</label>
                                            <input type="text" class="form-control"
                                                value="₹{{ number_format($order->total_amount, 2) }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address Card -->
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Shipping Address</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ $order->customer ? $order->customer->first_name : $order->shipping_first_name }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ $order->customer ? $order->customer->last_name : $order->shipping_last_name }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <input type="text" class="form-control"
                                                value="{{ $order->customer ? $order->customer->phone : $order->shipping_phone }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Address Line 1</label>
                                            <input type="text" class="form-control"
                                                value="{{ $order->shippingAddress->address1 }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Address Line 2</label>
                                            <input type="text" class="form-control"
                                                value="{{ $order->shippingAddress->address2 }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control"
                                                value="{{ $order->shippingAddress->city }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">State</label>
                                            <input type="text" class="form-control"
                                                value="{{ $order->shippingAddress->state }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Pincode</label>
                                            <input type="text" class="form-control"
                                                value="{{ $order->shippingAddress->pincode }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes Card -->
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Order Notes</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Internal Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4"
                                        placeholder="Add any internal notes about this order...">{{ old('notes', $order->notes ?? '') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">These notes are for internal use only and will not be visible to
                                        the customer.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-4">
                        <!-- Order Summary Card -->
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item border-0 d-flex justify-content-between">
                                        <span>Items:</span>
                                        <span class="fw-medium">{{ $order->orderItems->count() }}</span>
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
                                        <span>Packaging Charges:</span>
                                        <span class="fw-medium">₹{{ number_format($order->packaging_charges, 2) }}</span>
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

                        <!-- Order Status Card -->
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Order Status</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror" id="status"
                                                name="status"
                                                {{ in_array($order->status, ['shipped', 'delivered']) ? 'disabled' : '' }}>
                                                <option value="pending"
                                                    {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed"
                                                    {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed
                                                </option>
                                                <option value="processing"
                                                    {{ $order->status == 'processing' ? 'selected' : '' }}>Processing
                                                </option>
                                                <option value="shipped"
                                                    {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered"
                                                    {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered
                                                </option>
                                                <option value="cancelled"
                                                    {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Current Status</label>
                                            <div class="pt-2">
                                                <span
                                                    class="badge bg-{{ $order->order_status === 'delivered' ? 'success' : ($order->order_status === 'shipped' ? 'primary' : ($order->order_status === 'cancelled' ? 'danger' : 'warning')) }} fs-6">
                                                    {{ ucfirst($order->order_status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    @if (!in_array($order->status, ['shipped', 'delivered']))
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save me-1"></i> Update Order
                                        </button>
                                    @endif
                                    <a href="{{ route('order.view', $order->id) }}" class="btn btn-info">
                                        <i class="fas fa-eye me-1"></i> View Order
                                    </a>
                                    <a href="{{ route('order.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
