@extends('e-commerce/layouts/master')

@section('content')

    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit Product Deal</h4>
                </div>
                <div>
                    <a href="{{ route('product-deals.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('product-deals.update', $productDeal) }}" method="POST" id="productDealForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Deal Information Section -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Deal Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Deal Title -->
                                    <div class="col-lg-6">
                                        @include('components.form.input', [
                                            'label' => 'Deal Title',
                                            'name' => 'deal_title',
                                            'type' => 'text',
                                            'placeholder' => 'Enter Deal Title (e.g., Diwali Mega Offer)',
                                            'model' => $productDeal,
                                        ])
                                    </div>

                                    <!-- Status -->
                                    <div class="col-lg-6">
                                        @include('components.form.select', [
                                            'label' => 'Status',
                                            'name' => 'status',
                                            'options' => ['active' => 'Active', 'inactive' => 'Inactive'],
                                            'model' => $productDeal,
                                        ])
                                    </div>

                                    <!-- Offer Start Date -->
                                    <div class="col-lg-6">
                                        @include('components.form.input', [
                                            'label' => 'Offer Start Date & Time',
                                            'name' => 'offer_start_date',
                                            'type' => 'datetime-local',
                                            'model' => $productDeal
                                                ? $productDeal
                                                : '',
                                        ])
                                    </div>

                                    <!-- Offer End Date -->
                                    <div class="col-lg-6">
                                        @include('components.form.input', [
                                            'label' => 'Offer End Date & Time',
                                            'name' => 'offer_end_date',
                                            'type' => 'datetime-local',
                                            'model' => $productDeal
                                                ? $productDeal
                                                : '',
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Selection Section -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Product Selection</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-lg-8">
                                        <label class="form-label">Search Products</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="productSearch"
                                                placeholder="Search by Product Name or SKU" autocomplete="off">
                                            <button type="button" class="btn btn-primary" id="searchProducts">
                                                <i class="fa fa-search"></i> Search Products
                                            </button>
                                        </div>
                                        <div id="productSearchResults" class="mt-2" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Selected Products Table Section -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Selected Products</h5>
                            </div>
                            <div class="card-body">
                                <div id="selectedProductsContainer">
                                    <!-- Will be populated by JavaScript -->
                                </div>

                                <!-- Hidden inputs for selected products -->
                                <div id="productInputs"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="col-12">
                        <div class="text-start">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Deal
                            </button>
                            <a href="{{ route('product-deals.index') }}" class="btn btn-secondary ms-2">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @php
        $dealProducts = $productDeal->dealItems->map(function ($item) {
            return [
                'id' => $item->ecommerce_product_id,
                'name' => $item->ecommerceProduct->warehouseProduct->product_name,
                'sku' => $item->ecommerceProduct->sku,
                'brand' => $item->ecommerceProduct->warehouseProduct->brand->brand_title ?? 'N/A',
                'selling_price' => $item->original_price,
                'image' => $item->ecommerceProduct->warehouseProduct->main_product_image,
                'discount_type' => $item->discount_type,
                'discount_value' => $item->discount_value,
                'offer_price' => $item->offer_price,
            ];
        });

    @endphp
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize with existing deal products
            let selectedProducts = @json($dealProducts);

            console.log(selectedProducts);
            // Product search functionality
            $('#searchProducts').on('click', function() {
                const searchTerm = $('#productSearch').val().trim();
                if (searchTerm.length < 2) {
                    alert('Please enter at least 2 characters to search');
                    return;
                }

                $.ajax({
                    url: '{{ route('product-deals.search-products') }}',
                    method: 'GET',
                    data: {
                        search: searchTerm
                    },
                    success: function(products) {
                        if (products.length > 0) {
                            showProductSearchResults(products);
                        } else {
                            $('#productSearchResults').html(
                                '<div class="alert alert-warning">No products found matching your search.</div>'
                            ).show();
                        }
                    },
                    error: function() {
                        $('#productSearchResults').html(
                            '<div class="alert alert-danger">Error searching products. Please try again.</div>'
                        ).show();
                    }
                });
            });

            // Allow search on Enter key
            $('#productSearch').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#searchProducts').click();
                }
            });

            function showProductSearchResults(products) {
                let html = '<div class="search-results border rounded p-3 bg-light">';
                html += '<h6 class="mb-3">Search Results:</h6>';

                products.forEach(function(product) {
                    const isSelected = selectedProducts.find(p => p.id === product.id);
                    if (!isSelected) {
                        html += `
                    <div class="product-result d-flex justify-content-between align-items-center p-2 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                ${product.image ? `<img src="${product.image}" alt="${product.name}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">` : '<div style="width: 50px; height: 50px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 4px;"><i class="fa fa-image"></i></div>'}
                            </div>
                            <div>
                                <strong>${product.name}</strong><br>
                                <small class="text-muted">SKU: ${product.sku} | Brand: ${product.brand}</small><br>
                                <span class="badge bg-success">₹${parseFloat(product.selling_price).toLocaleString()}</span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm add-product" data-product='${JSON.stringify(product)}'>
                            <i class="fa fa-plus"></i> Add Product
                        </button>
                    </div>
                `;
                    }
                });

                html += '</div>';
                $('#productSearchResults').html(html).show();

                // Handle add product button click
                $('.add-product').on('click', function() {
                    const product = JSON.parse($(this).attr('data-product'));
                    addProductToSelection(product);
                    $(this).closest('.product-result').remove();
                });
            }

            function addProductToSelection(product) {
                // Add default discount values
                product.discount_type = 'percentage';
                product.discount_value = 10;
                product.offer_price = calculateOfferPrice(product.selling_price, 'percentage', 10);

                selectedProducts.push(product);
                updateSelectedProductsDisplay();
                updateProductInputs();
                $('#productSearch').val('');
                $('#productSearchResults').hide();
            }

            function removeProductFromSelection(productId) {
                selectedProducts = selectedProducts.filter(p => p.id !== productId);
                updateSelectedProductsDisplay();
                updateProductInputs();
            }

            function updateSelectedProductsDisplay() {
                const container = $('#selectedProductsContainer');

                if (selectedProducts.length === 0) {
                    container.html(
                        '<div class="alert alert-info"><i class="fa fa-info-circle"></i> No products selected yet. Use the search above to add products to this deal.</div>'
                    );
                    return;
                }

                let html = '<div class="table-responsive">';
                html += '<table class="table table-bordered">';
                html += '<thead class="table-light">';
                html += '<tr>';
                html += '<th>Sr. No.</th>';
                html += '<th>Product Name</th>';
                html += '<th>Original Price</th>';
                html += '<th>Discount Type</th>';
                html += '<th>Discount Value</th>';
                html += '<th>Offer Price</th>';
                html += '<th>Actions</th>';
                html += '</tr>';
                html += '</thead>';
                html += '<tbody>';

                selectedProducts.forEach(function(product, index) {
                    html += `
                <tr data-product-id="${product.id}">
                    <td>${index + 1}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                ${product.image ? `<img src="/${product.image}" alt="${product.name}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">` : '<div style="width: 40px; height: 40px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 4px;"><i class="fa fa-image"></i></div>'}
                            </div>
                            <div>
                                <strong>${product.name}</strong><br>
                                <small class="text-muted">SKU: ${product.sku}</small>
                            </div>
                        </div>
                    </td>
                    <td>₹${parseFloat(product.selling_price).toLocaleString()}</td>
                    <td>
                        <select class="form-select form-select-sm discount-type" data-product-id="${product.id}">
                            <option value="percentage" ${product.discount_type === 'percentage' ? 'selected' : ''}>Percentage (%)</option>
                            <option value="flat" ${product.discount_type === 'flat' ? 'selected' : ''}>Flat (₹)</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm discount-value"
                               data-product-id="${product.id}" value="${product.discount_value}"
                               min="0.01" step="0.01" style="width: 100px;">
                    </td>
                    <td class="offer-price">₹${parseFloat(product.offer_price).toLocaleString()}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-product" data-product-id="${product.id}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
                });

                html += '</tbody>';
                html += '</table>';
                html += '</div>';

                container.html(html);

                // Bind events for discount changes
                bindDiscountEvents();
            }

            function bindDiscountEvents() {
                // Handle discount type change
                $('.discount-type').on('change', function() {
                    const productId = $(this).data('product-id');
                    const discountType = $(this).val();

                    // Update the product in selectedProducts array
                    const productIndex = selectedProducts.findIndex(p => p.id === productId);
                    if (productIndex !== -1) {
                        selectedProducts[productIndex].discount_type = discountType;

                        // Reset discount value based on type
                        const discountValueInput = $(`.discount-value[data-product-id="${productId}"]`);
                        if (discountType === 'percentage') {
                            discountValueInput.attr('max', '100').val('10');
                            selectedProducts[productIndex].discount_value = 10;
                        } else {
                            discountValueInput.removeAttr('max').val('100');
                            selectedProducts[productIndex].discount_value = 100;
                        }

                        updateOfferPrice(productId);
                    }
                });

                // Handle discount value change
                $('.discount-value').on('input', function() {
                    const productId = $(this).data('product-id');
                    const discountValue = parseFloat($(this).val()) || 0;

                    // Update the product in selectedProducts array
                    const productIndex = selectedProducts.findIndex(p => p.id === productId);
                    if (productIndex !== -1) {
                        selectedProducts[productIndex].discount_value = discountValue;
                        updateOfferPrice(productId);
                    }
                });

                // Handle remove product
                $('.remove-product').on('click', function() {
                    const productId = $(this).data('product-id');
                    removeProductFromSelection(productId);
                });
            }

            function updateOfferPrice(productId) {
                const product = selectedProducts.find(p => p.id === productId);
                if (!product) return;

                const originalPrice = parseFloat(product.selling_price);
                const discountType = product.discount_type;
                const discountValue = parseFloat(product.discount_value) || 0;

                const offerPrice = calculateOfferPrice(originalPrice, discountType, discountValue);
                product.offer_price = offerPrice;

                // Update the display
                $(`.offer-price[data-product-id="${productId}"]`).text('₹' + parseFloat(offerPrice)
                    .toLocaleString());
                $(`tr[data-product-id="${productId}"] .offer-price`).text('₹' + parseFloat(offerPrice)
                    .toLocaleString());

                updateProductInputs();
            }

            function calculateOfferPrice(originalPrice, discountType, discountValue) {
                if (discountType === 'percentage') {
                    return originalPrice - (originalPrice * discountValue / 100);
                } else {
                    return originalPrice - discountValue;
                }
            }

            function updateProductInputs() {
                const container = $('#productInputs');
                container.empty();

                selectedProducts.forEach(function(product, index) {
                    container.append(`
                <input type="hidden" name="products[${index}][ecommerce_product_id]" value="${product.id}">
                <input type="hidden" name="products[${index}][discount_type]" value="${product.discount_type}">
                <input type="hidden" name="products[${index}][discount_value]" value="${product.discount_value}">
            `);
                });
            }

            // Form validation
            $('#productDealForm').on('submit', function(e) {
                let isValid = true;
                let errorMessages = [];

                // Check if at least one product is selected
                if (selectedProducts.length === 0) {
                    isValid = false;
                    errorMessages.push('Please add at least one product to the deal');
                }

                // Check date validation
                const startDate = new Date($('input[name="offer_start_date"]').val());
                const endDate = new Date($('input[name="offer_end_date"]').val());

                if (startDate && endDate && startDate >= endDate) {
                    isValid = false;
                    errorMessages.push('Offer end date must be after start date');
                }

                // Validate each product's discount values
                selectedProducts.forEach(function(product, index) {
                    const originalPrice = parseFloat(product.selling_price);
                    const discountValue = parseFloat(product.discount_value);

                    if (product.discount_type === 'percentage' && discountValue > 100) {
                        isValid = false;
                        errorMessages.push(
                            `Product "${product.name}": Percentage discount cannot exceed 100%`);
                    }

                    if (product.discount_type === 'flat' && discountValue >= originalPrice) {
                        isValid = false;
                        errorMessages.push(
                            `Product "${product.name}": Flat discount cannot exceed original price`
                        );
                    }

                    if (discountValue <= 0) {
                        isValid = false;
                        errorMessages.push(
                            `Product "${product.name}": Discount value must be greater than 0`);
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Please fix the following errors:\n' + errorMessages.join('\n'));
                }
            });

            // Update end date minimum when start date changes
            $('input[name="offer_start_date"]').on('change', function() {
                const startDateTime = $(this).val();
                if (startDateTime) {
                    $('input[name="offer_end_date"]').attr('min', startDateTime);
                }
            });

            // Initialize the display on page load
            updateSelectedProductsDisplay();
            updateProductInputs();
        });
    </script>
@endsection
