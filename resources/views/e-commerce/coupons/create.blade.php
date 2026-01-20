@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <!-- Breadcrumb -->
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Create New Coupon</h4>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('coupon.store') }}" method="POST" id="couponForm">
                @csrf
                <div class="row">
                    <!-- Main Form (8 columns) -->
                    <div class="col-lg-8">
                        <!-- Basic Details Card -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Basic Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                                        <input type="text" name="code"
                                            class="form-control @error('code') is-invalid @enderror"
                                            value="{{ old('code') }}" placeholder="SAVE20" required>
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" placeholder="Summer Sale 20% OFF" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"
                                            placeholder="Enter coupon description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Discount Details Card -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Discount Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        {{-- type: 0 - Percentage, 1 - Fixed, 2 - Buy X Get Y --}}
                                        <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                                        <select name="type" class="form-select @error('type') is-invalid @enderror"
                                            required>
                                            <option value="">Select Type</option>
                                            <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage (%)
                                            </option>
                                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount
                                            </option>
                                            <option value="buy_x_get_y" {{ old('type') == 'buy_x_get_y' ? 'selected' : '' }}>Buy X Get Y
                                            </option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                                        <input type="number" name="discount_value"
                                            class="form-control @error('discount_value') is-invalid @enderror"
                                            value="{{ old('discount_value') }}" step="0.01" min="0.01"
                                            placeholder="10.00" required>
                                        @error('discount_value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">Max Discount</label>
                                        <input type="number" name="max_discount"
                                            class="form-control @error('max_discount') is-invalid @enderror"
                                            value="{{ old('max_discount') }}" step="0.01" min="0"
                                            placeholder="100.00">
                                        @error('max_discount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">Min Purchase Amount</label>
                                        <input type="number" name="min_purchase_amount"
                                            class="form-control @error('min_purchase_amount') is-invalid @enderror"
                                            value="{{ old('min_purchase_amount') }}" step="0.01" min="0"
                                            placeholder="500.00">
                                        @error('min_purchase_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Applicable Categories Card -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Applicable Categories</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 mb-3">
                                    <div class="col-lg-9">
                                        <input type="text" id="category_search" class="form-control"
                                            placeholder="Search categories...">
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="button" id="add_category_btn" class="btn btn-success w-100"
                                            disabled>
                                            <i class="mdi mdi-plus me-1"></i> Add
                                        </button>
                                    </div>
                                </div>
                                <div id="category_search_results" class="mb-3" style="display: none;">
                                    <div class="list-group" id="category_list"></div>
                                </div>
                                <div id="selected_categories_container">
                                    <div id="selected_categories" class="d-flex flex-wrap gap-2"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Applicable Brands Card -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Applicable Brands</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 mb-3">
                                    <div class="col-lg-9">
                                        <input type="text" id="brand_search" class="form-control"
                                            placeholder="Search brands...">
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="button" id="add_brand_btn" class="btn btn-success w-100" disabled>
                                            <i class="mdi mdi-plus me-1"></i> Add
                                        </button>
                                    </div>
                                </div>
                                <div id="brand_search_results" class="mb-3" style="display: none;">
                                    <div class="list-group" id="brand_list"></div>
                                </div>
                                <div id="selected_brands_container">
                                    <div id="selected_brands" class="d-flex flex-wrap gap-2"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Excluded Products Card -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Excluded Products</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 mb-3">
                                    <div class="col-lg-9">
                                        <input type="text" id="product_search" class="form-control"
                                            placeholder="Search products...">
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="button" id="add_product_btn" class="btn btn-success w-100"
                                            disabled>
                                            <i class="mdi mdi-plus me-1"></i> Add
                                        </button>
                                    </div>
                                </div>
                                <div id="product_search_results" class="mb-3" style="display: none;">
                                    <div class="list-group" id="product_list"></div>
                                </div>
                                <div id="selected_products_container">
                                    <div id="selected_products" class="d-flex flex-wrap gap-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar (4 columns) -->
                    <div class="col-lg-4">
                        <!-- Validity Period -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Validity Period</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" name="start_date"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        value="{{ old('start_date') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="date" name="end_date"
                                        class="form-control @error('end_date') is-invalid @enderror"
                                        value="{{ old('end_date') }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Usage Limits -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Usage Limits</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Total Usage Limit</label>
                                    <input type="number" name="usage_limit"
                                        class="form-control @error('usage_limit') is-invalid @enderror"
                                        value="{{ old('usage_limit', 0) }}" min="0" placeholder="0 = Unlimited">
                                    <small class="text-muted">0 = Unlimited</small>
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Usage Per Customer</label>
                                    <input type="number" name="usage_per_customer"
                                        class="form-control @error('usage_per_customer') is-invalid @enderror"
                                        value="{{ old('usage_per_customer', 1) }}" min="1" placeholder="1">
                                    @error('usage_per_customer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Settings -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror"
                                        required>
                                        <option value="active" {{ old('status', 1) == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                        <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Stackable</label>
                                    <select name="stackable"
                                        class="form-select @error('stackable') is-invalid @enderror">
                                        <option value="0" {{ old('stackable', 0) == 0 ? 'selected' : '' }}>No
                                        </option>
                                        <option value="1" {{ old('stackable') == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @error('stackable')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success w-100 mb-2">
                                    <i class="mdi mdi-content-save me-1"></i> Create Coupon
                                </button>
                                <a href="{{ route('coupon.index') }}" class="btn btn-secondary w-100">
                                    <i class="mdi mdi-arrow-left me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let selectedCategories = [];
            let selectedCategoryData = null;
            let selectedBrands = [];
            let selectedBrandData = null;
            let selectedProducts = [];
            let selectedProductData = null;

            // Category search
            $('#category_search').on('input', function() {
                const query = $(this).val();
                if (query.length >= 2) {
                    searchCategories(query);
                } else {
                    $('#category_search_results').hide();
                    $('#add_category_btn').prop('disabled', true);
                }
            });

            $('#add_category_btn').click(function() {
                if (selectedCategoryData && !selectedCategories.includes(selectedCategoryData.id)) {
                    addCategoryChip(selectedCategoryData);
                    selectedCategories.push(selectedCategoryData.id);
                    $('#category_search').val('');
                    $('#category_search_results').hide();
                    $(this).prop('disabled', true);
                }
            });

            function searchCategories(query) {
                $.ajax({
                    url: '{{ route('coupon.search-categories') }}',
                    method: 'GET',
                    data: {
                        q: query
                    },
                    success: function(response) {
                        displayCategoryResults(response);
                    },
                    error: function() {
                        console.error('Error searching categories');
                    }
                });
            }

            function displayCategoryResults(categories) {
                const categoryList = $('#category_list');
                categoryList.empty();

                if (categories.length === 0) {
                    categoryList.append('<div class="list-group-item">No categories found</div>');
                } else {
                    categories.forEach(function(category) {
                        const item = $('<a href="#" class="list-group-item list-group-item-action"></a>')
                            .text(category.name)
                            .data('category', category)
                            .click(function(e) {
                                e.preventDefault();
                                selectedCategoryData = $(this).data('category');
                                $('#add_category_btn').prop('disabled', false);
                                $('.list-group-item').removeClass('active');
                                $(this).addClass('active');
                            });
                        categoryList.append(item);
                    });
                }
                $('#category_search_results').show();
            }

            function addCategoryChip(category) {
                const chip = $(`
            <div class="badge bg-primary" data-id="${category.id}">
                ${category.name}
                <i class="mdi mdi-close ms-1 cursor-pointer remove-category" data-id="${category.id}"></i>
                <input type="hidden" name="applicable_categories[]" value="${category.id}">
            </div>
        `);
                $('#selected_categories').append(chip);
            }

            $(document).on('click', '.remove-category', function() {
                const id = $(this).data('id');
                selectedCategories = selectedCategories.filter(catId => catId !== id);
                $(this).closest('.badge').remove();
            });

            // Brand search
            $('#brand_search').on('input', function() {
                const query = $(this).val();
                if (query.length >= 2) {
                    searchBrands(query);
                } else {
                    $('#brand_search_results').hide();
                    $('#add_brand_btn').prop('disabled', true);
                }
            });

            $('#add_brand_btn').click(function() {
                if (selectedBrandData && !selectedBrands.includes(selectedBrandData.id)) {
                    addBrandChip(selectedBrandData);
                    selectedBrands.push(selectedBrandData.id);
                    $('#brand_search').val('');
                    $('#brand_search_results').hide();
                    $(this).prop('disabled', true);
                }
            });

            function searchBrands(query) {
                $.ajax({
                    url: '{{ route('coupon.search-brands') }}',
                    method: 'GET',
                    data: {
                        q: query
                    },
                    success: function(response) {
                        displayBrandResults(response);
                    },
                    error: function() {
                        console.error('Error searching brands');
                    }
                });
            }

            function displayBrandResults(brands) {
                const brandList = $('#brand_list');
                brandList.empty();

                if (brands.length === 0) {
                    brandList.append('<div class="list-group-item">No brands found</div>');
                } else {
                    brands.forEach(function(brand) {
                        const item = $('<a href="#" class="list-group-item list-group-item-action"></a>')
                            .text(brand.name)
                            .data('brand', brand)
                            .click(function(e) {
                                e.preventDefault();
                                selectedBrandData = $(this).data('brand');
                                $('#add_brand_btn').prop('disabled', false);
                                $('.list-group-item').removeClass('active');
                                $(this).addClass('active');
                            });
                        brandList.append(item);
                    });
                }
                $('#brand_search_results').show();
            }

            function addBrandChip(brand) {
                const chip = $(`
            <div class="badge bg-success" data-id="${brand.id}">
                ${brand.name}
                <i class="mdi mdi-close ms-1 cursor-pointer remove-brand" data-id="${brand.id}"></i>
                <input type="hidden" name="applicable_brands[]" value="${brand.id}">
            </div>
        `);
                $('#selected_brands').append(chip);
            }

            $(document).on('click', '.remove-brand', function() {
                const id = $(this).data('id');
                selectedBrands = selectedBrands.filter(brandId => brandId !== id);
                $(this).closest('.badge').remove();
            });

            // Product search
            $('#product_search').on('input', function() {
                const query = $(this).val();
                if (query.length >= 2) {
                    searchProducts(query);
                } else {
                    $('#product_search_results').hide();
                    $('#add_product_btn').prop('disabled', true);
                }
            });

            $('#add_product_btn').click(function() {
                if (selectedProductData && !selectedProducts.includes(selectedProductData.id)) {
                    addProductChip(selectedProductData);
                    selectedProducts.push(selectedProductData.id);
                    $('#product_search').val('');
                    $('#product_search_results').hide();
                    $(this).prop('disabled', true);
                }
            });

            function searchProducts(query) {
                $.ajax({
                    url: '{{ route('coupon.search-products') }}',
                    method: 'GET',
                    data: {
                        q: query
                    },
                    success: function(response) {
                        displayProductResults(response);
                    },
                    error: function() {
                        console.error('Error searching products');
                    }
                });
            }

            function displayProductResults(products) {
                const productList = $('#product_list');
                productList.empty();

                if (products.length === 0) {
                    productList.append('<div class="list-group-item">No products found</div>');
                } else {
                    products.forEach(function(product) {
                        const item = $('<a href="#" class="list-group-item list-group-item-action"></a>')
                            .html(`${product.name} <small class="text-muted">(${product.sku})</small>`)
                            .data('product', product)
                            .click(function(e) {
                                e.preventDefault();
                                selectedProductData = $(this).data('product');
                                $('#add_product_btn').prop('disabled', false);
                                $('.list-group-item').removeClass('active');
                                $(this).addClass('active');
                            });
                        productList.append(item);
                    });
                }
                $('#product_search_results').show();
            }

            function addProductChip(product) {
                const chip = $(`
            <div class="badge bg-danger" data-id="${product.id}">
                ${product.name} (${product.sku})
                <i class="mdi mdi-close ms-1 cursor-pointer remove-product" data-id="${product.id}"></i>
                <input type="hidden" name="excluded_products[]" value="${product.id}">
            </div>
        `);
                $('#selected_products').append(chip);
            }

            $(document).on('click', '.remove-product', function() {
                const id = $(this).data('id');
                selectedProducts = selectedProducts.filter(prodId => prodId !== id);
                $(this).closest('.badge').remove();
            });

            // Form validation
            $('#couponForm').on('submit', function(e) {
                const type = $('select[name="type"]').val();
                const discountValue = parseFloat($('input[name="discount_value"]').val());
                const startDate = new Date($('input[name="start_date"]').val());
                const endDate = new Date($('input[name="end_date"]').val());

                if (type === 'percentage' && discountValue > 100) {
                    e.preventDefault();
                    alert('Percentage discount cannot exceed 100%');
                    return false;
                }

                if (discountValue <= 0) {
                    e.preventDefault();
                    alert('Discount value must be greater than 0');
                    return false;
                }

                if (startDate >= endDate) {
                    e.preventDefault();
                    alert('End date must be after start date');
                    return false;
                }
            });

            // Auto-generate code from title
            $('input[name="title"]').on('input', function() {
                if (!$('input[name="code"]').val()) {
                    const code = $(this).val()
                        .toUpperCase()
                        .replace(/[^A-Z0-9]/g, '')
                        .substring(0, 12);
                    $('input[name="code"]').val(code);
                }
            });
        });
    </script>

    <style>
        .cursor-pointer {
            cursor: pointer;
        }

        .badge {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }
    </style>
@endsection
