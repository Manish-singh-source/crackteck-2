@extends('warehouse/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('warehouse/index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('stock-request.index') }}">Stock Requests</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View/Edit Stock Request</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Stock Request #{{ $stockRequest->id }}</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('stock-request.update', $stockRequest) }}" method="POST"
                        id="stock-request-form">
                        @csrf
                        @method('PUT')

                        <!-- Request Information (Non-Editable) -->
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">
                                            Request Information
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="form-label">Requested By</label>
                                        <input type="text" class="form-control"
                                            value="{{ $stockRequest->requestedBy->first_name ?? 'N/A' }} {{ $stockRequest->requestedBy->last_name ?? '' }}" readonly>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label">Date of Request</label>
                                        <input type="text" class="form-control"
                                            value="{{ $stockRequest->request_date->format('Y-m-d') }}" readonly>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Reason / Justification</label>
                                        <textarea class="form-control" rows="3" readonly>{{ $stockRequest->reason }}</textarea>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label">Urgency Level</label>
                                        <input type="text" class="form-control"
                                            value="{{ $stockRequest->urgency_level }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Management (Editable) -->
                        <div class="card mt-3">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">
                                            Status Management
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label for="approval_status" class="form-label">Approval Status</label>
                                        <select class="form-select @error('approval_status') is-invalid @enderror"
                                            name="approval_status" id="approval_status">
                                            <option value="Pending"
                                                {{ $stockRequest->approval_status == 'Pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="Approved"
                                                {{ $stockRequest->approval_status == 'Approved' ? 'selected' : '' }}>
                                                Approved</option>
                                            <option value="Rejected"
                                                {{ $stockRequest->approval_status == 'Rejected' ? 'selected' : '' }}>
                                                Rejected</option>
                                        </select>
                                        @error('approval_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <label for="final_status" class="form-label">Final Status</label>
                                        <select class="form-select @error('final_status') is-invalid @enderror"
                                            name="final_status" id="final_status">
                                            <option value="Pending"
                                                {{ $stockRequest->final_status == 'Pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="Completed"
                                                {{ $stockRequest->final_status == 'Completed' ? 'selected' : '' }}>
                                                Completed</option>
                                            <option value="Cancelled"
                                                {{ $stockRequest->final_status == 'Cancelled' ? 'selected' : '' }}>
                                                Cancelled</option>
                                        </select>
                                        @error('final_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Management -->
                        <div class="card mt-3">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">
                                            Product Management
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <!-- Add New Product Section -->
                                <div class="row g-3 mb-3 p-3 bg-light rounded">
                                    <div class="col-12">
                                        <h6 class="mb-3">Add New Product</h6>
                                    </div>
                                    <div class="col-8">
                                        <label for="new_product_search" class="form-label">Search Product</label>
                                        <select class="form-select" id="new_product_search" style="width: 100%;">
                                            <option value="">Search for products...</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label for="new_product_quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="new_product_quantity" min="1"
                                            max="10000" placeholder="Enter quantity">
                                    </div>
                                    <div class="col-1">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="button" class="btn btn-primary d-block" id="add-new-product">
                                            <i class="mdi mdi-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Existing Products Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="products-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Product Name</th>
                                                <th>SKU</th>
                                                <th>Brand</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="products-body">
                                            @forelse($stockRequest->stockRequestItems as $item)
                                                <tr data-item-id="{{ $item->id }}">
                                                    <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                                                    <td>{{ $item->product->sku ?? 'N/A' }}</td>
                                                    <td>{{ $item->product->brand->brand_title ?? 'N/A' }}</td>
                                                    <td>
                                                        <input type="number" class="form-control quantity-input"
                                                            value="{{ $item->quantity }}" min="1" max="10000"
                                                            data-item-id="{{ $item->id }}"
                                                            name="products[{{ $loop->index }}][quantity]">
                                                        <input type="hidden" name="products[{{ $loop->index }}][id]"
                                                            value="{{ $item->id }}">
                                                        <input type="hidden"
                                                            name="products[{{ $loop->index }}][product_id]"
                                                            value="{{ $item->product_id }}">
                                                    </td>
                                                    <td>
                                                        <button type="submit" data-item-id="{{ $item->id }}" id="remove-product"
                                                            class="btn btn-icon btn-sm bg-danger-subtle"
                                                            data-bs-toggle="tooltip" data-bs-original-title="Delete"><i
                                                                class="mdi mdi-delete fs-14 text-danger"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr id="no-products-row">
                                                    <td colspan="5" class="text-center text-muted py-3">
                                                        No products in this request.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Action Buttons -->
                    <div class="col-lg-12 mt-3">
                        <div class="text-start mb-3">
                            <button type="submit" form="stock-request-form"
                                class="btn btn-success w-sm waves ripple-light">
                                Update Request
                            </button>
                            <a href="{{ route('stock-request.index') }}"
                                class="btn btn-secondary w-sm waves ripple-light ms-2">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let newProductCounter = 0;
            let removedProducts = [];

            // Initialize Select2 for new product search
            $('#new_product_search').select2({
                placeholder: 'Search for products...',
                allowClear: true,
                ajax: {
                    url: '{{ route('stock-request.search-products') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2
            });

            // Add new product to the list
            $('#add-new-product').on('click', function() {
                const productId = $('#new_product_search').val();
                const quantity = $('#new_product_quantity').val();

                if (!productId) {
                    alert('Please select a product.');
                    return;
                }

                if (!quantity || quantity < 1) {
                    alert('Please enter a valid quantity.');
                    return;
                }

                // Check if product already exists
                if ($(`tr[data-product-id="${productId}"]`).length > 0) {
                    alert('This product is already in the list. You can edit the quantity in the table.');
                    return;
                }

                // Get product details
                $.ajax({
                    url: `/warehouse/get-product/${productId}`,
                    type: 'GET',
                    success: function(product) {
                        addNewProductToTable(product, quantity);

                        // Clear form
                        $('#new_product_search').val(null).trigger('change');
                        $('#new_product_quantity').val('');
                    },
                    error: function() {
                        alert('Error fetching product details.');
                    }
                });
            });

            function addNewProductToTable(product, quantity) {
                newProductCounter++;

                // Remove "no products" row if it exists
                $('#no-products-row').remove();

                const newRow = `
            <tr data-product-id="${product.id}" data-new-product="true">
                <td>${product.product_name}</td>
                <td>${product.sku}</td>
                <td>${product.brand}</td>
                <td>
                    <input type="number" class="form-control quantity-input"
                           value="${quantity}" min="1" max="10000"
                           name="new_products[${newProductCounter}][quantity]">
                    <input type="hidden" name="new_products[${newProductCounter}][product_id]" value="${product.id}">
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-new-product">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </td>
            </tr>
        `;

                $('#products-body').append(newRow);
            }

            // Handle existing product removal
            $(document).on('click', '.remove-product', function() {
                const itemId = $(this).data('item-id');
                const row = $(this).closest('tr');

                if (confirm('Are you sure you want to remove this product from the request?')) {
                    // Add to removed products list
                    removedProducts.push(itemId);

                    // Add hidden input for removed product
                    $('#stock-request-form').append(
                        `<input type="hidden" name="removed_products[]" value="${itemId}">`);

                    // Remove row
                    row.remove();

                    // Check if table is empty
                    if ($('#products-body tr').length === 0) {
                        $('#products-body').append(`
                    <tr id="no-products-row">
                        <td colspan="5" class="text-center text-muted py-3">
                            No products in this request.
                        </td>
                    </tr>
                `);
                    }
                }
            });

            // Handle new product removal
            $(document).on('click', '.remove-new-product', function() {
                const row = $(this).closest('tr');

                if (confirm('Are you sure you want to remove this product?')) {
                    row.remove();

                    // Check if table is empty
                    if ($('#products-body tr').length === 0) {
                        $('#products-body').append(`
                    <tr id="no-products-row">
                        <td colspan="5" class="text-center text-muted py-3">
                            No products in this request.
                        </td>
                    </tr>
                `);
                    }
                }
            });

            // Handle form submission
            $('#stock-request-form').on('submit', function(e) {
                const hasProducts = $('#products-body tr:not(#no-products-row)').length > 0;

                if (!hasProducts) {
                    e.preventDefault();
                    alert('Please ensure at least one product is in the request.');
                    return false;
                }
            });

            $("#remove-product").on('click', function() {
                const itemId = $(this).data('item-id');
                confirm('Are you sure you want to remove this product from the request?') &&
                $.ajax({
                    url: `/warehouse/stock-requests/remove-product/${itemId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while removing the product.');
                    }
                });
            });
        });
    </script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
