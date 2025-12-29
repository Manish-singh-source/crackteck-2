@extends('e-commerce/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <div class="bradcrumb pt-3 ps-2 bg-light">
            <div class="row ">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Coupon</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Coupon</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0"></h4>
            </div>
        </div>


        <form action="{{ route('coupon.update', $coupon->id) }}" method="POST" id="couponEditForm">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">
                                            Coupon Basic Details:
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12 mb-2">
                                        <div>
                                            @include('components.form.input', [
                                            'label' => 'Coupon Code',
                                            'name' => 'coupon_code',
                                            'type' => 'text',
                                            'placeholder' => 'Enter Coupon Code',
                                            'model' => $coupon
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 mb-2">
                                        <div>
                                            @include('components.form.input', [
                                            'label' => 'Coupon Title',
                                            'name' => 'coupon_title',
                                            'type' => 'text',
                                            'placeholder' => 'Summer Sale 20% OFF',
                                            'model' => $coupon
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 mb-2">
                                        <div>
                                            <label for="coupon_description" class="form-label"> Coupon Description
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea id="coupon_description" class="form-control @error('coupon_description') is-invalid @enderror" name="coupon_description" placeholder="Enter Coupon Description">{{ old('coupon_description', $coupon->coupon_description) }}</textarea>
                                            @error('coupon_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card pb-4">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">
                                    Discount Details:
                                </h5>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 mb-2">
                                        @include('components.form.select', [
                                        'label' => 'Discount Type',
                                        'name' => 'discount_type',
                                        'options' => ["" => "--Select--", "percentage" => "Percentage", "fixed_amount" => "Fixed Amount"],
                                        'model' => $coupon
                                        ])
                                    </div>
                                    <div class="col-xl-6 col-lg-6 mb-2">
                                        <div>
                                            @include('components.form.input', [
                                            'label' => 'Discount Value',
                                            'name' => 'discount_value',
                                            'type' => 'number',
                                            'placeholder' => 'Enter Discount Value',
                                            'model' => $coupon
                                            ])
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">
                                    Usage Conditions:
                                </h5>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 mb-2">
                                        @include('components.form.input', [
                                        'label' => 'Minimum Purchase Amount',
                                        'name' => 'min_purchase_amount',
                                        'type' => 'number',
                                        'placeholder' => 'Enter Minimum Purchase Amount',
                                        'model' => $coupon
                                        ])
                                    </div>

                                    <div class="col-xl-6 col-lg-6 mb-2">
                                        <label for="categories" class="form-label">Applicable Categories (Optional)</label>
                                        <select name="categories[]" id="categories" class="form-select" multiple>
                                            @foreach($categories as $id => $name)
                                                <option value="{{ $id }}" {{ in_array($id, old('categories', $coupon->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Hold Ctrl/Cmd to select multiple categories. Leave empty to apply to all categories.</small>
                                        @error('categories')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-xl-12 col-lg-12 mb-2">
                                        <label for="product_search" class="form-label">
                                            Product Search (Optional)
                                        </label>
                                        <div class="input-group mb-2">
                                            <input type="text" id="product_search" class="form-control" placeholder="Search product name or SKU">
                                            <button type="button" id="search_products" class="btn btn-outline-primary">
                                                Search Products
                                            </button>
                                        </div>

                                        <!-- Selected Products Display -->
                                        <div id="selected_products" class="border rounded p-2 bg-light" style="min-height: 60px;">
                                            <small class="text-muted">Selected products will appear here. Leave empty to apply to all products.</small>
                                        </div>

                                        <!-- Hidden inputs for selected products -->
                                        <div id="product_inputs"></div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">
                                    Validity Period:
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    @include('components.form.input', [
                                    'label' => 'Start Date',
                                    'name' => 'start_date',
                                    'type' => 'date',
                                    'placeholder' => 'Enter Start Date',
                                    'model' => $coupon
                                    ])
                                </div>
                                <div class="mt-3 mb-3">
                                    @include('components.form.input', [
                                    'label' => 'End Date',
                                    'name' => 'end_date',
                                    'type' => 'date',
                                    'placeholder' => 'Enter End Date',
                                    'model' => $coupon
                                    ])
                                </div>
                            </div>

                        </div>

                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">
                                    Usage Limits
                                </h5>
                            </div>

                            <div class="card-body">
                                <div class=" mb-3">
                                    @include('components.form.input', [
                                    'label' => 'Total Usage Limit (Optional)',
                                    'name' => 'total_usage_limit',
                                    'type' => 'number',
                                    'placeholder' => 'e.g., 100',
                                    'model' => $coupon
                                    ])
                                    <small class="text-muted">Leave empty for unlimited usage</small>
                                </div>
                                <div class="mb-3">
                                    @include('components.form.input', [
                                    'label' => 'Usage Limit Per Customer (Optional)',
                                    'name' => 'usage_limit_per_customer',
                                    'type' => 'number',
                                    'placeholder' => 'e.g., 1',
                                    'model' => $coupon
                                    ])
                                    <small class="text-muted">Leave empty for unlimited per customer</small>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">
                                    Status
                                </h5>
                            </div>

                            <div class="card-body">
                                @include('components.form.select', [
                                'label' => 'Coupon Status',
                                'name' => 'status',
                                'options' => ["active" => "Active", "inactive" => "Inactive"],
                                'model' => $coupon
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="text-start mb-3">
                            <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                Update Coupon
                            </button>
                            <a href="{{ route('coupon.index') }}" class="btn btn-secondary w-sm waves ripple-light ms-2">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div> <!-- container-fluid -->
</div> <!-- content -->

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let selectedProducts = @json($coupon->products->toArray());

    // Initialize Select2 for categories
    $('#categories').select2({
        placeholder: 'Select categories (optional)',
        allowClear: true,
        width: '100%',
        theme: 'bootstrap-5'
    });

    // Initialize selected products display
    updateSelectedProductsDisplay();
    updateProductInputs();

    // Product search functionality
    $('#search_products').on('click', function() {
        const searchTerm = $('#product_search').val().trim();
        if (searchTerm.length < 2) {
            alert('Please enter at least 2 characters to search');
            return;
        }

        $.ajax({
            url: '{{ route("coupon.search-products") }}',
            method: 'GET',
            data: { search: searchTerm },
            success: function(response) {
                if (response.success && response.products.length > 0) {
                    showProductSearchResults(response.products);
                } else {
                    alert('No products found matching your search');
                }
            },
            error: function() {
                alert('Error searching products. Please try again.');
            }
        });
    });

    // Allow search on Enter key
    $('#product_search').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#search_products').click();
        }
    });

    function showProductSearchResults(products) {
        let html = '<div class="search-results border rounded p-2 mt-2 bg-white">';
        html += '<h6>Search Results:</h6>';

        products.forEach(function(product) {
            const isSelected = selectedProducts.find(p => p.id === product.id);
            if (!isSelected) {
                html += `
                    <div class="product-result d-flex justify-content-between align-items-center p-2 border-bottom">
                        <div>
                            <strong>${product.warehouse_product.product_name}</strong><br>
                            <small class="text-muted">SKU: ${product.sku} | Category: ${product.warehouse_product.parent_categorie ? product.warehouse_product.parent_categorie.parent_categories : 'N/A'}</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary add-product" data-product='${JSON.stringify(product)}'>
                            Add
                        </button>
                    </div>
                `;
            }
        });

        html += '</div>';

        // Remove existing search results
        $('.search-results').remove();

        // Add new search results
        $('#product_search').parent().after(html);

        // Bind add product events
        $('.add-product').on('click', function() {
            const product = JSON.parse($(this).attr('data-product'));
            addProductToSelection(product);
            $(this).closest('.product-result').remove();
        });
    }

    function addProductToSelection(product) {
        selectedProducts.push(product);
        updateSelectedProductsDisplay();
        updateProductInputs();
    }

    function removeProductFromSelection(productId) {
        selectedProducts = selectedProducts.filter(p => p.id !== productId);
        updateSelectedProductsDisplay();
        updateProductInputs();
    }

    function updateSelectedProductsDisplay() {
        const container = $('#selected_products');

        if (selectedProducts.length === 0) {
            container.html('<small class="text-muted">Selected products will appear here. Leave empty to apply to all products.</small>');
            return;
        }

        let html = '<div class="selected-products-list">';
        html += '<h6>Selected Products:</h6>';
        html += '<div class="table-responsive">';
        html += '<table class="table table-sm">';
        html += '<thead><tr><th>Product Name</th><th>SKU</th><th>Category</th><th>Action</th></tr></thead>';
        html += '<tbody>';

        selectedProducts.forEach(function(product) {
            html += `
                <tr>
                    <td>${product.warehouse_product.product_name}</td>
                    <td>${product.sku}</td>
                    <td>${product.warehouse_product.parent_categorie ? product.warehouse_product.parent_categorie.parent_categories : 'N/A'}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-product" data-product-id="${product.id}">
                            Remove
                        </button>
                    </td>
                </tr>
            `;
        });

        html += '</tbody></table></div></div>';
        container.html(html);

        // Bind remove events
        $('.remove-product').on('click', function() {
            const productId = parseInt($(this).data('product-id'));
            removeProductFromSelection(productId);
        });
    }

    function updateProductInputs() {
        const container = $('#product_inputs');
        container.empty();

        selectedProducts.forEach(function(product) {
            container.append(`<input type="hidden" name="products[]" value="${product.id}">`);
        });
    }

    // Form validation
    $('#couponEditForm').on('submit', function(e) {
        const discountType = $('select[name="discount_type"]').val();
        const discountValue = parseFloat($('input[name="discount_value"]').val());

        if (discountType === 'percentage' && discountValue > 100) {
            e.preventDefault();
            alert('Percentage discount cannot exceed 100%');
            return false;
        }

        if (discountValue <= 0) {
            e.preventDefault();
            alert('Discount value must be greater than 0');
            return false;
        }
    });
});
</script>
@endsection
