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
                    <h4 class="fs-18 fw-semibold m-0">E-Commerce Order Management</h4>
                </div>
                <div>
                    <a href="{{ route('order.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Create Order
                    </a>
                </div>
            </div>

        

            <!-- Search and Filter Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('order.index') }}" class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label">Date From</label>
                                    <input type="date" class="form-control" name="date_from"
                                        value="{{ request('date_from') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Date To</label>
                                    <input type="date" class="form-control" name="date_to"
                                        value="{{ request('date_to') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('order.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-refresh"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @php
                                $statuses = [
                                    'all' => [
                                        'label' => 'All',
                                        'icon' => 'mdi-format-list-bulleted',
                                        'color' => '',
                                    ],
                                    'pending' => [
                                        'label' => 'Pending',
                                        'icon' => 'mdi-timer-sand', // better for "waiting"
                                        'color' => 'text-warning',
                                    ],
                                    'confirmed' => [
                                        'label' => 'Confirmed',
                                        'icon' => 'mdi-check-circle-outline',
                                        'color' => 'text-success',
                                    ],
                                    'processing' => [
                                        'label' => 'Processing',
                                        'icon' => 'mdi-progress-clock', // indicates ongoing process
                                        'color' => 'text-primary',
                                    ],
                                    'shipped' => [
                                        'label' => 'Shipped',
                                        'icon' => 'mdi-truck-delivery', // shows shipment
                                        'color' => 'text-info',
                                    ],
                                    'delivered' => [
                                        'label' => 'Delivered',
                                        'icon' => 'mdi-package-variant-closed', // delivered package
                                        'color' => 'text-success',
                                    ],
                                    'cancelled' => [
                                        'label' => 'Cancelled',
                                        'icon' => 'mdi-close-circle-outline',
                                        'color' => 'text-danger',
                                    ],
                                ];

                                $currentStatus = request()->get('status') ?? 'all';
                            @endphp

                            <ul class="nav nav-underline border-bottom mb-3" id="pills-tab" role="tablist">
                                @foreach ($statuses as $key => $status)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $currentStatus === $key ? 'active' : '' }} p-2"
                                            href="{{ $key === 'all' ? route('order.index') : route('order.index', ['status' => $key]) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i
                                                    class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>{{ $status['label'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            @if ($orders->count() > 0)
                                <div>
                                    <table id="responsive-datatable"
                                        class="table table-striped table-borderless dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;">
                                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                                </th>
                                                <th>Order Number</th>
                                                <th>Customer Info</th>
                                                <th>Products Quantity</th>
                                                <th>Order Prices</th>
                                                <th>Payment Method</th>
                                                <th>Status</th>
                                                <th>Invoice</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input order-checkbox"
                                                            value="{{ $order->id }}">
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('order.view', $order->id) }}"
                                                            class="fw-semibold link-primary">
                                                            #{{ $order->order_number }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <div class="fw-medium">
                                                                {{ $order->customer ? $order->customer->first_name . ' ' . $order->customer->last_name : $order->shipping_first_name . ' ' . $order->shipping_last_name }}
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ $order->customer ? $order->customer->email : $order->email }}</small>
                                                            @if ($order->shipping_phone)
                                                                <br><small class="text-muted"><i class="fas fa-phone"></i>
                                                                    {{ $order->shipping_phone }}</small>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="small">
                                                            @php
                                                                $totalProducts = $order->orderItems->sum('quantity');
                                                            @endphp
                                                            <div class="fw-medium">Total Products: {{ $totalProducts }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="small">
                                                            <div>Subtotal: <span
                                                                    class="fw-medium">₹{{ number_format($order->subtotal, 2) }}</span>
                                                            </div>
                                                            @if ($order->shipping_charges > 0)
                                                                <div>Shipping: <span
                                                                        class="fw-medium">₹{{ number_format($order->shipping_charges, 2) }}</span>
                                                                </div>
                                                            @endif
                                                            @if ($order->discount_amount > 0)
                                                                <div class="text-success">Discount:
                                                                    -₹{{ number_format($order->discount_amount, 2) }}</div>
                                                            @endif
                                                            <div class="fw-bold text-success border-top pt-1">
                                                                Grand Total: ₹{{ number_format($order->total_amount, 2) }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $paymentMethods = [
                                                                'online' => 'Online',
                                                                'cod' => 'Cash on Delivery',
                                                                'cheque' => 'Cheque',
                                                                'bank_transfer' => 'Bank Transfer',
                                                            ];
                                                            // Attempt to read property "payment_method" on null
                                                            $paymentMethod =
                                                                $paymentMethods[
                                                                    $order->orderPayments->first()->payment_method ??
                                                                        'cod'
                                                                ] ??
                                                                ucfirst(
                                                                    $order->orderPayments->first()->payment_method ??
                                                                        'cod',
                                                                );
                                                        @endphp
                                                        {{ $paymentMethod }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusColors = [
                                                                'pending' => 'warning',
                                                                'confirmed' => 'info',
                                                                'processing' => 'primary',
                                                                'shipped' => 'primary',
                                                                'delivered' => 'success',
                                                                'cancelled' => 'danger',
                                                            ];
                                                            $statusColor =
                                                                $statusColors[$order->status] ?? 'secondary';
                                                        @endphp
                                                        <select class="form-select form-select-sm status-select"
                                                            data-order-id="{{ $order->id }}" style="width: auto;">
                                                            <option value="pending"
                                                                {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                                Pending
                                                            </option>
                                                            <option value="confirmed"
                                                                {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                                                Confirmed</option>
                                                            <option value="processing"
                                                                {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                                Processing</option>
                                                            <option value="shipped"
                                                                {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                                                Shipped
                                                            </option>
                                                            <option value="delivered"
                                                                {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                                                Delivered</option>
                                                            <option value="cancelled"
                                                                {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                                Cancelled</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('order.invoice', $order->id) }}"
                                                            class="btn btn-sm btn-outline-success" title="Download Invoice"
                                                            target="_blank">
                                                            <i class="fas fa-file-pdf me-1"></i> PDF
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div>{{ $order->created_at->format('d M Y') }}</div>
                                                        <small
                                                            class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                                    </td>
                                                    <td>
                                                        <a aria-label="anchor"
                                                            href="{{ route('order.view', $order->id) }}"
                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                            data-bs-toggle="tooltip" data-bs-original-title="View">
                                                            <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                        </a>
                                                        <a aria-label="anchor"
                                                            href="{{ route('order.edit', $order->id) }}"
                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                            data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                            <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                        </a>
                                                        <form style="display: inline-block"
                                                            action="{{ route('order.delete', $order->id) }}"
                                                            method="POST" onsubmit="return confirm('Are you sure?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-original-title="Delete"><i
                                                                    class="mdi mdi-delete fs-14 text-danger"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-shopping-cart fa-3x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">No Orders Found</h5>
                                    <p class="text-muted">There are no orders to display at the moment.</p>
                                    <a href="{{ route('order.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Create First Order
                                    </a>
                                </div>
                            @endif
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
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Delete Confirmation Modal -->
    <div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkDeleteModalLabel">Confirm Bulk Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <span id="selectedCount">0</span> selected order(s)? This action cannot
                    be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmBulkDelete">Delete Selected</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let orderToDelete = null;

            // Select All functionality
            $('#selectAll').on('change', function() {
                $('.order-checkbox').prop('checked', this.checked);
                toggleDeleteButton();
            });

            // Individual checkbox functionality
            $('.order-checkbox').on('change', function() {
                const totalCheckboxes = $('.order-checkbox').length;
                const checkedCheckboxes = $('.order-checkbox:checked').length;

                $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
                toggleDeleteButton();
            });

            // Toggle delete selected button visibility
            function toggleDeleteButton() {
                const checkedCount = $('.order-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#deleteSelectedBtn').show();
                } else {
                    $('#deleteSelectedBtn').hide();
                }
            }

            // Handle status change
            $('.status-select').on('change', function() {
                const orderId = $(this).data('order-id');
                const newStatus = $(this).val();
                const selectElement = $(this);
                const originalValue = selectElement.data('original-value') || selectElement.val();

                $.ajax({
                    url: `/demo/e-commerce/order/${orderId}/update-status`,
                    method: 'POST',
                    data: {
                        status: newStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message);
                            } else {
                                alert(response.message);
                            }
                            // Update the original value
                            selectElement.data('original-value', newStatus);
                        } else {
                            // Show error and revert
                            if (typeof toastr !== 'undefined') {
                                toastr.error(response.message);
                            } else {
                                alert(response.message);
                            }
                            selectElement.val(originalValue);
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
                        // Revert the select to previous value
                        selectElement.val(originalValue);
                    }
                });
            });

            // Store original values for status selects
            $('.status-select').each(function() {
                $(this).data('original-value', $(this).val());
            });

            // Delete selected orders functionality
            $('#deleteSelectedBtn').on('click', function() {
                const selectedOrders = $('.order-checkbox:checked');
                if (selectedOrders.length > 0) {
                    $('#selectedCount').text(selectedOrders.length);
                    $('#bulkDeleteModal').modal('show');
                }
            });

            // Confirm bulk delete
            $('#confirmBulkDelete').on('click', function() {
                const selectedOrderIds = [];
                $('.order-checkbox:checked').each(function() {
                    selectedOrderIds.push($(this).val());
                });

                if (selectedOrderIds.length > 0) {
                    $.ajax({
                        url: '/demo/e-commerce/orders/bulk-delete',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            order_ids: selectedOrderIds
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#bulkDeleteModal').modal('hide');
                                if (typeof toastr !== 'undefined') {
                                    toastr.success(response.message);
                                } else {
                                    alert(response.message);
                                }
                                location.reload();
                            } else {
                                if (typeof toastr !== 'undefined') {
                                    toastr.error(response.message);
                                } else {
                                    alert(response.message ||
                                        'An error occurred while deleting orders.');
                                }
                            }
                        },
                        error: function(xhr) {
                            const message = xhr.responseJSON?.message ||
                                'An error occurred while deleting orders.';
                            if (typeof toastr !== 'undefined') {
                                toastr.error(message);
                            } else {
                                alert(message);
                            }
                        }
                    });
                }
            });

            // Delete single order functionality
            $('.delete-order').on('click', function() {
                orderToDelete = $(this).data('id');
                $('#deleteModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                if (orderToDelete) {
                    $.ajax({
                        url: `demo/e-commerce/order/${orderToDelete}`,
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
                                location.reload();
                            }
                        },
                        error: function(xhr) {
                            const message = xhr.responseJSON?.message ||
                                'An error occurred while deleting the order.';
                            if (typeof toastr !== 'undefined') {
                                toastr.error(message);
                            } else {
                                alert(message);
                            }
                        }
                    });
                }
            });
        });
    </script>

@endsection
