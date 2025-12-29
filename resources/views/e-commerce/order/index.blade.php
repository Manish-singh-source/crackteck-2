@extends('e-commerce/layouts/master')

@section('content')

<div class="content">
    <div class="container-fluid">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
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

        <!-- Status Filter Tabs -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body border-bottom">
                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == '' ? 'active' : '' }}"
                                   href="{{ route('order.index') }}">
                                    All Orders <span class="badge bg-secondary ms-1">{{ $statusCounts['all'] }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
                                   href="{{ route('order.index', ['status' => 'pending']) }}">
                                    Pending <span class="badge bg-warning ms-1">{{ $statusCounts['pending'] }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == 'confirmed' ? 'active' : '' }}"
                                   href="{{ route('order.index', ['status' => 'confirmed']) }}">
                                    Confirmed <span class="badge bg-info ms-1">{{ $statusCounts['confirmed'] }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == 'processing' ? 'active' : '' }}"
                                   href="{{ route('order.index', ['status' => 'processing']) }}">
                                    Processing <span class="badge bg-info ms-1">{{ $statusCounts['processing'] }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == 'shipped' ? 'active' : '' }}"
                                   href="{{ route('order.index', ['status' => 'shipped']) }}">
                                    Shipped <span class="badge bg-primary ms-1">{{ $statusCounts['shipped'] }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == 'delivered' ? 'active' : '' }}"
                                   href="{{ route('order.index', ['status' => 'delivered']) }}">
                                    Delivered <span class="badge bg-success ms-1">{{ $statusCounts['delivered'] }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}"
                                   href="{{ route('order.index', ['status' => 'cancelled']) }}">
                                    Cancelled <span class="badge bg-danger ms-1">{{ $statusCounts['cancelled'] }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Form -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('order.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Search</label>
                                <input type="text" class="form-control" name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Order number, customer name, email...">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
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
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Orders List</h5>
                            <button type="button" class="btn btn-danger btn-sm" id="deleteSelectedBtn" style="display: none;">
                                <i class="fas fa-trash me-1"></i> Delete Selected
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 40px;">
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                            </th>
                                            <th>Order Number</th>
                                            <th>Customer Info</th>
                                            <th>Products & HSN</th>
                                            <th>Order Totals</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Invoice</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input order-checkbox" value="{{ $order->id }}">
                                                </td>
                                                <td>
                                                    <a href="{{ route('order.view', $order->id) }}" class="fw-semibold link-primary">
                                                        #{{ $order->order_number }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <div>
                                                        <div class="fw-medium">
                                                            {{ $order->user ? $order->user->name : ($order->shipping_first_name . ' ' . $order->shipping_last_name) }}
                                                        </div>
                                                        <small class="text-muted">{{ $order->user ? $order->user->email : $order->email }}</small>
                                                        @if($order->shipping_phone)
                                                            <br><small class="text-muted"><i class="fas fa-phone"></i> {{ $order->shipping_phone }}</small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="small">
                                                        @foreach($order->orderItems as $item)
                                                            <div class="mb-2 p-2 border rounded">
                                                                <div class="fw-medium">{{ $item->product_name }}</div>
                                                                <div class="text-muted">
                                                                    HSN/SAC: <span class="fw-medium">{{ $item->hsn_sac_code ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between">
                                                                    <span>Qty: {{ $item->quantity }}</span>
                                                                    <span>₹{{ number_format($item->unit_price, 2) }}</span>
                                                                </div>
                                                                @if($item->igst_amount > 0)
                                                                    <div class="text-muted">Tax: ₹{{ number_format($item->igst_amount, 2) }}</div>
                                                                @endif
                                                                <div class="fw-medium">Total: ₹{{ number_format($item->total_price, 2) }}</div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="small">
                                                        <div>Subtotal: <span class="fw-medium">₹{{ number_format($order->subtotal, 2) }}</span></div>
                                                        @if($order->shipping_charges > 0)
                                                            <div>Shipping: <span class="fw-medium">₹{{ number_format($order->shipping_charges, 2) }}</span></div>
                                                        @endif
                                                        @if($order->discount_amount > 0)
                                                            <div class="text-success">Discount: -₹{{ number_format($order->discount_amount, 2) }}</div>
                                                        @endif
                                                        <div class="fw-bold text-success border-top pt-1">
                                                            Grand Total: ₹{{ number_format($order->total_amount, 2) }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($order->payment_method === 'mastercard' || $order->payment_method === 'visa')
                                                        <div>
                                                            <span class="badge bg-info">{{ ucfirst($order->payment_method) }}</span>
                                                            @if($order->card_last_four)
                                                                <br><small class="text-muted">**** **** **** {{ $order->card_last_four }}</small>
                                                            @endif
                                                        </div>
                                                    @elseif($order->payment_method === 'cod')
                                                        <span class="badge bg-warning">Cash on Delivery</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ ucfirst($order->payment_method) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $statusColors = [
                                                            'pending' => 'warning',
                                                            'confirmed' => 'info',
                                                            'processing' => 'primary',
                                                            'shipped' => 'primary',
                                                            'delivered' => 'success',
                                                            'cancelled' => 'danger'
                                                        ];
                                                        $statusColor = $statusColors[$order->status] ?? 'secondary';
                                                    @endphp
                                                    <select class="form-select form-select-sm status-select"
                                                            data-order-id="{{ $order->id }}"
                                                            style="width: auto;">
                                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <a href="{{ route('order.invoice', $order->id) }}"
                                                       class="btn btn-sm btn-outline-success" title="Download Invoice" target="_blank">
                                                        <i class="fas fa-file-pdf me-1"></i> PDF
                                                    </a>
                                                </td>
                                                <td>
                                                    <div>{{ $order->created_at->format('d M Y') }}</div>
                                                    <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('order.view', $order->id) }}"
                                                           class="btn btn-sm btn-outline-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('order.edit', $order->id) }}"
                                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger delete-order"
                                                                data-id="{{ $order->id }}" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <p class="text-muted mb-0">
                                        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                                    </p>
                                </div>
                                <div>
                                    {{ $orders->links() }}
                                </div>
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
<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkDeleteModalLabel">Confirm Bulk Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <span id="selectedCount">0</span> selected order(s)? This action cannot be undone.
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
            url: `/e-commerce/order/${orderId}/update-status`,
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
                const message = xhr.responseJSON?.message || 'Failed to update order status';
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
                url: '/e-commerce/orders/bulk-delete',
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
                            alert(response.message || 'An error occurred while deleting orders.');
                        }
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'An error occurred while deleting orders.';
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
                url: `/e-commerce/order/${orderToDelete}`,
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
                    const message = xhr.responseJSON?.message || 'An error occurred while deleting the order.';
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