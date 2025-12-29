@extends('e-commerce/layouts/master')

@section('main-content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">E-Commerce Orders</h4>
                            {{-- <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">E-Commerce Orders</li>
                                </ol>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h4 class="card-title mb-0">Order Management</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                                            <button type="button" class="btn btn-danger" id="bulk-delete-btn" style="display: none;">
                                                <i class="ri-delete-bin-line"></i> Delete Selected
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Filter Tabs -->
                            <div class="card-body border-bottom">
                                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') == '' ? 'active' : '' }}" 
                                           href="{{ route('ecommerce-order.index') }}">
                                            All Orders <span class="badge bg-secondary ms-1">{{ $statusCounts['all'] }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" 
                                           href="{{ route('ecommerce-order.index', ['status' => 'pending']) }}">
                                            Pending <span class="badge bg-warning ms-1">{{ $statusCounts['pending'] }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') == 'processing' ? 'active' : '' }}" 
                                           href="{{ route('ecommerce-order.index', ['status' => 'processing']) }}">
                                            Processing <span class="badge bg-info ms-1">{{ $statusCounts['processing'] }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') == 'shipped' ? 'active' : '' }}" 
                                           href="{{ route('ecommerce-order.index', ['status' => 'shipped']) }}">
                                            Shipped <span class="badge bg-primary ms-1">{{ $statusCounts['shipped'] }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') == 'delivered' ? 'active' : '' }}" 
                                           href="{{ route('ecommerce-order.index', ['status' => 'delivered']) }}">
                                            Delivered <span class="badge bg-success ms-1">{{ $statusCounts['delivered'] }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}" 
                                           href="{{ route('ecommerce-order.index', ['status' => 'cancelled']) }}">
                                            Cancelled <span class="badge bg-danger ms-1">{{ $statusCounts['cancelled'] }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Search and Filter Form -->
                            <div class="card-body border-bottom">
                                <form method="GET" action="{{ route('ecommerce-order.index') }}" class="row g-3">
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
                                                <i class="ri-search-line"></i> Search
                                            </button>
                                            <a href="{{ route('ecommerce-order.index') }}" class="btn btn-secondary">
                                                <i class="ri-refresh-line"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-nowrap table-striped-columns mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                                        <label class="form-check-label" for="checkAll"></label>
                                                    </div>
                                                </th>
                                                <th scope="col">Order Number</th>
                                                <th scope="col">Customer</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Items</th>
                                                <th scope="col">Total Amount</th>
                                                <th scope="col">Payment Method</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($orders as $order)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input order-checkbox" type="checkbox" 
                                                               value="{{ $order->id }}" id="order{{ $order->id }}">
                                                        <label class="form-check-label" for="order{{ $order->id }}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('ecommerce-order.show', $order->id) }}" 
                                                       class="fw-medium link-primary">#{{ $order->order_number }}</a>
                                                </td>
                                                <td>
                                                    <div>
                                                        <h6 class="mb-1">{{ $order->user->name }}</h6>
                                                        <p class="text-muted mb-0">{{ $order->user->email }}</p>
                                                    </div>
                                                </td>
                                                <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                                <td>
                                                    <select class="form-select form-select-sm status-select" 
                                                            data-order-id="{{ $order->id }}" 
                                                            style="width: auto;">
                                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                </td>
                                                <td>{{ $order->orderItems->count() }} items</td>
                                                <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $order->payment_method == 'mastercard' ? 'info' : 'warning' }}">
                                                        {{ $order->payment_method == 'mastercard' ? 'Credit Card' : 'Cash on Delivery' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle btn btn-sm btn-light" 
                                                           data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('ecommerce-order.show', $order->id) }}">
                                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View Details
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('ecommerce-order.invoice', $order->id) }}">
                                                                    <i class="ri-download-2-line align-bottom me-2 text-muted"></i> Download Invoice
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="ri-shopping-cart-line display-4 text-muted mb-3"></i>
                                                        <h5 class="text-muted">No orders found</h5>
                                                        <p class="text-muted mb-0">No orders match your current filters.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                @if($orders->hasPages())
                                <div class="d-flex justify-content-end mt-3">
                                    {{ $orders->appends(request()->query())->links() }}
                                </div>
                                @endif
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
    // Handle select all checkbox
    $('#checkAll').on('change', function() {
        $('.order-checkbox').prop('checked', this.checked);
        toggleBulkDeleteButton();
    });

    // Handle individual checkboxes
    $('.order-checkbox').on('change', function() {
        toggleBulkDeleteButton();
        
        // Update select all checkbox
        const totalCheckboxes = $('.order-checkbox').length;
        const checkedCheckboxes = $('.order-checkbox:checked').length;
        $('#checkAll').prop('checked', totalCheckboxes === checkedCheckboxes);
    });

    // Toggle bulk delete button visibility
    function toggleBulkDeleteButton() {
        const checkedCount = $('.order-checkbox:checked').length;
        if (checkedCount > 0) {
            $('#bulk-delete-btn').show();
        } else {
            $('#bulk-delete-btn').hide();
        }
    }

    // Handle status change
    $('.status-select').on('change', function() {
        const orderId = $(this).data('order-id');
        const newStatus = $(this).val();
        const selectElement = $(this);

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
                } else {
                    toastr.error(response.message);
                    // Revert the select to previous value
                    selectElement.val(selectElement.data('original-value'));
                }
            },
            error: function() {
                toastr.error('Failed to update order status');
                // Revert the select to previous value
                selectElement.val(selectElement.data('original-value'));
            }
        });
    });

    // Store original values for status selects
    $('.status-select').each(function() {
        $(this).data('original-value', $(this).val());
    });

    // Handle bulk delete
    $('#bulk-delete-btn').on('click', function() {
        const selectedIds = $('.order-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            toastr.warning('Please select orders to delete');
            return;
        }

        if (confirm(`Are you sure you want to delete ${selectedIds.length} selected orders?`)) {
            $.ajax({
                url: '{{ route("ecommerce-order.bulk-delete") }}',
                method: 'POST',
                data: {
                    order_ids: selectedIds,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('Failed to delete orders');
                }
            });
        }
    });
});
</script>
@endsection
