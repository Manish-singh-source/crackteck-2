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
                        <li class="breadcrumb-item active" aria-current="page">Create Stock Request</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0"></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="{{ route('stock-request.store') }}" method="POST" id="stock-request-form">
                            @csrf
                            <div class="card">
                                <div class="card-header border-bottom-dashed">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-sm">
                                            <h5 class="card-title mb-0">
                                                Stock Request Information
                                            </h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label for="requested_by" class="form-label">Requested By <span class="text-danger">*</span></label>
                                            <input type="hidden" name="requested_by" value="{{ auth()->id() }}">
                                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                            @error('requested_by')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-6">
                                            <label for="request_date" class="form-label">Date of Request <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('request_date') is-invalid @enderror"
                                                   name="request_date" id="request_date"
                                                   value="{{ old('request_date', date('Y-m-d')) }}" required>
                                            @error('request_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="reason" class="form-label">Reason / Justification <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('reason') is-invalid @enderror"
                                                      name="reason" id="reason" rows="3"
                                                      placeholder="Enter reason or justification for this stock request" required>{{ old('reason') }}</textarea>
                                            @error('reason')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-6">
                                            <label for="urgency_level" class="form-label">Urgency Level <span class="text-danger">*</span></label>
                                            <select class="form-select @error('urgency_level') is-invalid @enderror"
                                                    name="urgency_level" id="urgency_level" required>
                                                <option value="">--Select Urgency Level--</option>
                                                <option value="Low" {{ old('urgency_level') == 'Low' ? 'selected' : '' }}>Low</option>
                                                <option value="Medium" {{ old('urgency_level') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                                <option value="High" {{ old('urgency_level') == 'High' ? 'selected' : '' }}>High</option>
                                                <option value="Critical" {{ old('urgency_level') == 'Critical' ? 'selected' : '' }}>Critical</option>
                                            </select>
                                            @error('urgency_level')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Selection Section -->
                            <div class="card mt-3">
                                <div class="card-header border-bottom-dashed">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-sm">
                                            <h5 class="card-title mb-0">
                                                Product Selection
                                            </h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row g-3 mb-3">
                                        <div class="col-8">
                                            <label for="product_search" class="form-label">Search Product <span class="text-danger">*</span></label>
                                            <select class="form-select" id="product_search" style="width: 100%;">
                                                <option value="">Search for products...</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label for="product_quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="product_quantity"
                                                   min="1" max="10000" placeholder="Enter quantity">
                                        </div>
                                        <div class="col-1">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="button" class="btn btn-primary d-block" id="add-product">
                                                <i class="mdi mdi-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Selected Products Table -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="selected-products-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>SKU</th>
                                                    <th>Brand</th>
                                                    <th>Quantity</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="selected-products-body">
                                                <tr id="no-products-row">
                                                    <td colspan="5" class="text-center text-muted py-3">
                                                        No products added yet. Search and add products above.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    @error('products')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="col-lg-12">
                        <div class="text-start mb-3">
                            <button type="submit" form="stock-request-form" class="btn btn-success w-sm waves ripple-light">
                                Submit Request
                            </button>
                            <a href="{{ route('stock-request.index') }}" class="btn btn-secondary w-sm waves ripple-light ms-2">
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
    let selectedProducts = [];
    let productCounter = 0;

    // Initialize Select2 for product search
    $('#product_search').select2({
        placeholder: 'Search for products...',
        allowClear: true,
        ajax: {
            url: '{{ route("stock-request.search-products") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });

    // Add product to the list
    $('#add-product').on('click', function() {
        const productId = $('#product_search').val();
        const quantity = $('#product_quantity').val();

        if (!productId) {
            alert('Please select a product.');
            return;
        }

        if (!quantity || quantity < 1) {
            alert('Please enter a valid quantity.');
            return;
        }

        // Check if product already exists
        if (selectedProducts.find(p => p.id == productId)) {
            alert('This product is already added. You can edit the quantity in the table below.');
            return;
        }

        // Get product details
        $.ajax({
            url: `/warehouse/get-product/${productId}`,
            type: 'GET',
            success: function(product) {
                addProductToTable(product, quantity);

                // Clear form
                $('#product_search').val(null).trigger('change');
                $('#product_quantity').val('');
            },
            error: function() {
                alert('Error fetching product details.');
            }
        });
    });

    function addProductToTable(product, quantity) {
        productCounter++;

        selectedProducts.push({
            id: product.id,
            counter: productCounter,
            product_name: product.product_name,
            sku: product.sku,
            brand: product.brand,
            quantity: quantity
        });

        updateProductsTable();
    }

    function updateProductsTable() {
        const tbody = $('#selected-products-body');
        tbody.empty();

        if (selectedProducts.length === 0) {
            tbody.append(`
                <tr id="no-products-row">
                    <td colspan="5" class="text-center text-muted py-3">
                        No products added yet. Search and add products above.
                    </td>
                </tr>
            `);
        } else {
            selectedProducts.forEach(function(product) {
                tbody.append(`
                    <tr data-counter="${product.counter}">
                        <td>${product.product_name}</td>
                        <td>${product.sku}</td>
                        <td>${product.brand}</td>
                        <td>
                            <input type="number" class="form-control quantity-input"
                                   value="${product.quantity}" min="1" max="10000"
                                   data-counter="${product.counter}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger remove-product"
                                    data-counter="${product.counter}">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }
    }

    // Handle quantity change
    $(document).on('change', '.quantity-input', function() {
        const counter = $(this).data('counter');
        const newQuantity = $(this).val();

        const productIndex = selectedProducts.findIndex(p => p.counter == counter);
        if (productIndex !== -1) {
            selectedProducts[productIndex].quantity = newQuantity;
        }
    });

    // Handle product removal
    $(document).on('click', '.remove-product', function() {
        const counter = $(this).data('counter');
        selectedProducts = selectedProducts.filter(p => p.counter != counter);
        updateProductsTable();
    });

    // Handle form submission
    $('#stock-request-form').on('submit', function(e) {
        if (selectedProducts.length === 0) {
            e.preventDefault();
            alert('Please add at least one product to the request.');
            return false;
        }

        // Add hidden inputs for products
        selectedProducts.forEach(function(product, index) {
            $(this).append(`
                <input type="hidden" name="products[${index}][product_id]" value="${product.id}">
                <input type="hidden" name="products[${index}][quantity]" value="${product.quantity}">
            `);
        }.bind(this));
    });
});
</script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection