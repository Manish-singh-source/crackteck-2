@extends('warehouse/layouts/master')

@section('content')
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit Product</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">

                    <form action="{{ route('product-list.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            {{-- LEFT SIDE --}}
                            <div class="col-lg-8">

                                {{-- Vendor Information --}}
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">Vendor Information</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">

                                            {{-- SAME AS CREATE: Vendor --}}
                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    @include('components.form.select', [
                                                        'label' => 'Vendor',
                                                        'name' => 'vendor_id',
                                                        'options' => $vendors->prepend('-- Select Vendor --', 0),
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    @include('components.form.select', [
                                                        'label' => 'Vendor PO Number',
                                                        'name' => 'vendor_purchase_order_id',
                                                        'id' => 'vendor_purchase_order_id',
                                                        'options' =>
                                                            ['' => '--Select Vendor PO Number--'] +
                                                            $vendorPurchaseOrders->toArray(),
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    @include('components.form.select', [
                                                        'label' => 'Brand',
                                                        'name' => 'brand_id',
                                                        'options' =>
                                                            ['' => '--Select Brand--'] + $brands->toArray(),
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                {{-- Parent Category --}}
                                                @include('components.form.select', [
                                                    'label' => 'Parent Category',
                                                    'name' => 'parent_category_id', // keep as requested
                                                    'id' => 'parent_category',
                                                    'options' =>
                                                        ['' => '--Select Parent Category--'] +
                                                        $parentCategories->toArray(),
                                                    'model' => $product,
                                                ])
                                            </div>

                                            <div class="col-lg-6">
                                                {{-- Sub Category --}}
                                                @include('components.form.select', [
                                                    'label' => 'Sub Category',
                                                    'name' => 'sub_category_id', // keep as requested
                                                    'id' => 'sub_category_id',
                                                    'options' =>
                                                        ['' => '--Select Sub Category--'] +
                                                        $subCategories->toArray(),
                                                    'model' => $product,
                                                ])
                                            </div>

                                            <div class="col-lg-6">
                                                @include('components.form.select', [
                                                    'label' => 'Warehouse',
                                                    'name' => 'warehouse_id',
                                                    'options' =>
                                                        ['' => 'Select Warehouse'] + $warehouses->toArray(),
                                                    'model' => isset($product) ? $product : null,
                                                    'model' => $product,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Basic Product Information --}}
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">Basic Product Information</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Product Name',
                                                        'name' => 'product_name',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Product Name',
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'HSN Code',
                                                        'name' => 'hsn_code',
                                                        'type' => 'text',
                                                        'placeholder' => 'Product HSN Code',
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'SKU',
                                                        'name' => 'sku',
                                                        'type' => 'text',
                                                        'placeholder' => 'Product SKU Code',
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Model No',
                                                        'name' => 'model_no',
                                                        'type' => 'text',
                                                        'placeholder' => 'Product Model No.',
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Product Details (Quill) --}}
                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">Product Details</h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div>
                                                    <label for="short_description" class="form-label">
                                                        Short Description
                                                    </label>
                                                    <div id="short-description-editor" style="height: 200px;">
                                                        {!! $product->short_description !!}
                                                    </div>
                                                    <input type="hidden" name="short_description" id="short_description"
                                                        value="{{ old('short_description', $product->short_description) }}">
                                                </div>
                                            </div>

                                            <div class="col-12 mb-3">
                                                <div>
                                                    <label for="full_description" class="form-label">
                                                        Full Description
                                                    </label>
                                                    <div id="full-description-editor" style="height: 300px;">
                                                        {!! $product->full_description !!}
                                                    </div>
                                                    <input type="hidden" name="full_description" id="full_description"
                                                        value="{{ old('full_description', $product->full_description) }}">
                                                </div>
                                            </div>

                                            <div class="col-12 mb-3">
                                                <div>
                                                    <label for="technical_specification" class="form-label">
                                                        Technical Specifications
                                                    </label>
                                                    <div id="technical-specification-editor" style="height: 300px;">
                                                        {!! $product->technical_specification !!}
                                                    </div>
                                                    <input type="hidden" name="technical_specification"
                                                        id="technical_specification"
                                                        value="{{ old('technical_specification', $product->technical_specification) }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div class="mb-3">
                                                    @include('components.form.input', [
                                                        'label' => 'Brand Warranty',
                                                        'name' => 'brand_warranty',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Brand Warranty',
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div class="mb-3">
                                                    @include('components.form.input', [
                                                        'label' => 'Company Warranty',
                                                        'name' => 'company_warranty',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Company Warranty',
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- RIGHT SIDE --}}
                            <div class="col-lg-4">

                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">Pricing</h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Cost Price',
                                                        'name' => 'cost_price',
                                                        'id' => 'cost_price',
                                                        'type' => 'number',
                                                        'placeholder' => 'Enter Cost Price',
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Selling Price',
                                                        'name' => 'selling_price',
                                                        'id' => 'selling_price',
                                                        'type' => 'number',
                                                        'placeholder' => 'Enter Selling Price',
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Discount Price',
                                                        'name' => 'discount_price',
                                                        'id' => 'discount_price',
                                                        'type' => 'number',
                                                        'placeholder' => 'Enter Discount Price',
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Tax (%)',
                                                        'name' => 'tax',
                                                        'id' => 'tax',
                                                        'type' => 'number',
                                                        'placeholder' => 'Enter Tax',
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Final Price',
                                                        'name' => 'final_price',
                                                        'id' => 'final_price',
                                                        'type' => 'number',
                                                        'placeholder' => 'Enter Final Price',
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Stock Quantity',
                                                        'name' => 'stock_quantity',
                                                        'type' => 'number',
                                                        'placeholder' => 'Enter Stock Quantity',
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="">
                                                <div>
                                                    @include('components.form.select', [
                                                        'label' => 'Stock Status',
                                                        'name' => 'stock_status',
                                                        'options' => [
                                                            '' => '--Select--',
                                                            'in_stock' => 'In Stock',
                                                            'out_of_stock' => 'Out of Stock',
                                                            'low_stock' => 'Low Stock',
                                                            'scrap' => 'Scrap',
                                                        ],
                                                        'model' => $product,
                                                    ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Images and Media --}}
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">Images and Media:</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            @include('components.form.input', [
                                                'label' => 'Main Product Image',
                                                'name' => 'main_product_image',
                                                'type' => 'file',
                                                'placeholder' => 'Upload Main Product Image',
                                            ])
                                            @if ($product->main_product_image)
                                                <small class="text-muted">
                                                    Current: {{ basename($product->main_product_image) }}
                                                </small>
                                            @endif
                                            <div class="text-danger">Image Size Should Be 800x650</div>
                                        </div>

                                        @php
                                            $images = [];

                                            if (!empty($product->additional_product_images)) {
                                                if (is_array($product->additional_product_images)) {
                                                    $images = $product->additional_product_images;
                                                } else {
                                                    $decoded = json_decode($product->additional_product_images, true);
                                                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                                        $images = $decoded;
                                                    } else {
                                                        $images = explode(',', $product->additional_product_images);
                                                    }
                                                }
                                            }
                                        @endphp

                                        <div class="mb-3">
                                            <label for="additional_product_images" class="form-label">
                                                Additional Product Images
                                            </label>

                                            <input type="file" class="form-control" name="additional_product_images[]"
                                                multiple accept="image/*">

                                            @if (count($images) > 0)
                                                <small class="text-muted">
                                                    Current: {{ count($images) }} images
                                                </small>
                                            @endif

                                            <div class="text-danger">
                                                Image Size Should Be 800x650
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            @include('components.form.input', [
                                                'label' => 'Product Datasheet or Manual',
                                                'name' => 'datasheet_manual',
                                                'type' => 'file',
                                                'placeholder' => 'Upload Product Datasheet or Manual',
                                            ])
                                            @if ($product->datasheet_manual)
                                                <small class="text-muted">
                                                    Current: {{ basename($product->datasheet_manual) }}
                                                </small>
                                            @endif
                                            <div class="text-danger">PDF files only</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Product Variations --}}
                                <div class="card">
                                    <div class="card-header border-bottom-dashed d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Product Variations</h5>
                                        <span class="badge bg-primary">Multiple Select Enabled</span>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            @foreach ($variationAttributes as $attribute)
                                                <div class="col-md-12">
                                                    <div class="variation-group">
                                                        <label for="variation_{{ $attribute->id }}" class="form-label fw-semibold">
                                                            {{ $attribute->name }}
                                                            <span class="text-muted fw-normal">(Select Multiple)</span>
                                                        </label>
                                                        <select id="variation_{{ $attribute->id }}"
                                                                name="variations[{{ $attribute->name }}][]"
                                                                class="form-select variation-select"
                                                                multiple
                                                                old-values="{{ json_encode($product->variation_options ?? []) }}"
                                                                data-attribute="{{ $attribute->name }}">
                                                            @foreach ($attribute->values as $value)
                                                                @php
                                                                    $selectedValues = $selectedVariations[$attribute->name] ?? [];
                                                                    $isSelected = in_array($value->value, $selectedValues);
                                                                @endphp
                                                                <option value="{{ $value->value }}"
                                                                        @if($isSelected) selected @endif>
                                                                    {{ $value->value }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @if($variationAttributes->isEmpty())
                                            <div class="alert alert-info mb-0">
                                                <i class="bx bx-info-circle me-2"></i>
                                                No product variations available. Please add variations from the E-commerce section.
                                            </div>
                                        @endif
                                    </div>
                                </div>


                                {{-- Status --}}
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">Status</h5>
                                    </div>

                                    <div class="card-body">
                                        <div>
                                            @include('components.form.select', [
                                                'label' => 'Product Status',
                                                'name' => 'status',
                                                'options' => [
                                                    '' => '--Select--',
                                                    'inactive' => 'Inactive',
                                                    'active' => 'Active',
                                                ],
                                                'model' => $product,
                                            ])
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Submit --}}
                            <div class="col-lg-12">
                                <div class="text-start mb-3">
                                    <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                        Update
                                    </button>
                                    <a href="{{ route('products.index') }}"
                                        class="btn btn-danger w-sm waves ripple-light">
                                        Cancel
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
    <!-- Include Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Include Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Quill editors
            var shortDescriptionQuill = new Quill('#short-description-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['link', 'image']
                    ]
                }
            });

            var fullDescriptionQuill = new Quill('#full-description-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['link', 'image']
                    ]
                }
            });

            var technicalSpecificationQuill = new Quill('#technical-specification-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['link', 'image']
                    ]
                }
            });

            // Update hidden inputs when form is submitted
            $('form').on('submit', function() {
                $('#short_description').val(shortDescriptionQuill.root.innerHTML);
                $('#full_description').val(fullDescriptionQuill.root.innerHTML);
                $('#technical_specification').val(technicalSpecificationQuill.root.innerHTML);
            });

            // Warehouse -> Racks
            $('select[name="warehouse_id"]').on('change', function() {
                var id = $(this).val();
                $.get('/warehouse-dependent?type=rack&id=' + id, function(data) {
                    console.log(data);
                    var select = $('select[name="warehouse_rack_name"]');
                    select.empty().append('<option value="">--Select Rack--</option>');
                    $.each(data, function(key, value) {
                        select.append('<option value="' + key + '">' + value + '</option>');
                    });
                });
            });

            // Rack -> Zone
            $('select[name="warehouse_rack_name"]').on('change', function() {
                var id = $(this).val();
                $.get('/warehouse-dependent?type=zone&id=' + id, function(data) {
                    var select = $('select[name="zone_area_id"]');
                    select.empty().append('<option value="">--Select Zone--</option>');
                    $.each(data, function(key, value) {
                        select.append('<option value="' + key + '">' + value + '</option>');
                    });
                });
            });

            // Zone -> Rack No
            $('select[name="zone_area_id"]').on('change', function() {
                var id = $(this).val();
                $.get('/warehouse-dependent?type=rack_no&id=' + id, function(data) {
                    var select = $('select[name="rack_no_id"]');
                    select.empty().append('<option value="">--Select Rack No--</option>');
                    $.each(data, function(key, value) {
                        select.append('<option value="' + key + '">' + value + '</option>');
                    });
                });
            });

            // Rack No -> Level
            $('select[name="rack_no_id"]').on('change', function() {
                var id = $(this).val();
                $.get('/warehouse-dependent?type=level&id=' + id, function(data) {
                    var select = $('select[name="level_no_id"]');
                    select.empty().append('<option value="">--Select Level--</option>');
                    $.each(data, function(key, value) {
                        select.append('<option value="' + key + '">' + value + '</option>');
                    });
                });
            });

            // Level -> Position
            $('select[name="level_no_id"]').on('change', function() {
                var id = $(this).val();
                $.get('/warehouse-dependent?type=position&id=' + id, function(data) {
                    var select = $('select[name="position_no_id"]');
                    select.empty().append('<option value="">--Select Position--</option>');
                    $.each(data, function(key, value) {
                        select.append('<option value="' + key + '">' + value + '</option>');
                    });
                });
            });

            // AJAX SKU Validation
            let skuTimeout = null;
            $('#sku').on('input', function() {
                const sku = $(this).val().trim();
                const $input = $(this);
                const $feedback = $('#sku-ajax-feedback');

                // Clear previous timeout
                if (skuTimeout) {
                    clearTimeout(skuTimeout);
                }

                // Remove existing feedback
                $feedback.remove();
                $input.removeClass('is-invalid is-valid');

                if (sku.length >= 2) {
                    skuTimeout = setTimeout(() => {
                        $.ajax({
                            url: '{{ route('product-list.check-sku') }}',
                            method: 'GET',
                            data: {
                                sku: sku
                            },
                            success: function(response) {
                                if (response.valid) {
                                    $input.removeClass('is-invalid').addClass(
                                        'is-valid');
                                    $input.after(
                                        '<div id="sku-ajax-feedback" class="valid-feedback">' +
                                        response.message + '</div>');
                                } else {
                                    $input.removeClass('is-valid').addClass(
                                        'is-invalid');
                                    $input.after(
                                        '<div id="sku-ajax-feedback" class="invalid-feedback">' +
                                        response.message + '</div>');
                                }
                            },
                            error: function() {
                                $input.removeClass('is-valid').addClass('is-invalid');
                                $input.after(
                                    '<div id="sku-ajax-feedback" class="invalid-feedback">Error checking SKU availability</div>'
                                );
                            }
                        });
                    }, 500);
                }
            });

            // ========================================
            // Task 2: Category-Dependent Subcategory Filtering
            // ========================================
            $('#parent_category').on('change', function() {
                var parentId = $(this).val();
                var subcategorySelect = $('#sub_category');

                // keep selected parent; only touch subcategory
                subcategorySelect.empty();

                if (!parentId) {
                    subcategorySelect.append('<option value="">--Select Category First--</option>');
                    return;
                }

                subcategorySelect.append('<option value="">Loading...</option>');

                $.ajax({
                    url: '/category-dependent',
                    method: 'GET',
                    data: {
                        parent_id: parentId
                    },
                    success: function(data) {
                        subcategorySelect.empty()
                            .append('<option value="">--Select Subcategory--</option>');
                        $.each(data, function(key, value) {
                            subcategorySelect.append('<option value="' + key + '">' +
                                value + '</option>');
                        });
                    },
                    error: function() {
                        subcategorySelect.empty()
                            .append('<option value="">Error loading subcategories</option>');
                        console.error('Error fetching subcategories');
                    }
                });
            });


            // ========================================
            // Task 3: Real-time Pricing Calculation
            // ========================================
            function calculateFinalPrice() {
                var sellingPrice = parseFloat($('input[name="selling_price"]').val()) || 0;
                var discountPrice = parseFloat($('input[name="discount_price"]').val()) || 0;
                var taxPercentage = parseFloat($('input[name="tax"]').val()) || 0;

                // Validation: discount price cannot be greater than selling price
                if (discountPrice > sellingPrice && sellingPrice > 0) {
                    alert('Discount price cannot be greater than selling price');
                    $('input[name="discount_price"]').val('');
                    discountPrice = 0;
                }

                // Validation: tax percentage cannot exceed 100%
                if (taxPercentage > 100) {
                    alert('Tax percentage cannot exceed 100%');
                    $('input[name="tax"]').val('');
                    taxPercentage = 0;
                }

                // Calculate base price
                // If discount price is entered: base_price = selling_price - discount_price
                // Otherwise: base_price = selling_price
                var basePrice = discountPrice > 0 ? (sellingPrice - discountPrice) : sellingPrice;

                // Apply tax: final_price = base_price + (base_price * tax_percentage / 100)
                var finalPrice = basePrice + (basePrice * taxPercentage / 100);

                // Update final price field (rounded to 2 decimal places)
                $('input[name="final_price"]').val(finalPrice.toFixed(2));
            }

            // Attach event listeners to pricing fields
            $('input[name="selling_price"], input[name="discount_price"], input[name="tax"]').on('keyup change',
                function() {
                    calculateFinalPrice();
                });

            // Calculate on page load if values exist
            calculateFinalPrice();

        });
    </script>
@endsection

@section('scripts')
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     document.querySelectorAll('.js-variation-select').forEach(function(el) {
        //         new Choices(el, {
        //             removeItemButton: true, // chip ke andar × button
        //             shouldSort: false,
        //             placeholder: true,
        //             placeholderValue: 'Select values',
        //             searchPlaceholderValue: 'Filter...',
        //             allowHTML: true
        //         });
        //     });
        // });


        // Vendor -> Vendor PO Number
        $(document).ready(function() {
            $('#vendor_id').on('change', function() {
                var vendorId = $(this).val();
                $.ajax({
                    url: '{{ route('product-list.get-vendor-purchase-orders-by-vendor') }}',
                    method: 'GET',
                    data: {
                        vendor_id: vendorId
                    },
                    success: function(data) {
                        $('#vendor_purchase_order_id').empty();
                        $('#vendor_purchase_order_id').append(
                            '<option value="">--Select--</option>');
                        $.each(data, function(key, value) {
                            $('#vendor_purchase_order_id').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                    }
                });
            });

            // Parent Category -> Sub Category
            $('#parent_category_id').on('change', function() {
                var parentId = $(this).val();
                $.ajax({
                    url: '{{ route('product-list.get-sub-categories') }}',
                    method: 'GET',
                    data: {
                        parent_id: parentId
                    },
                    success: function(data) {
                        $('#sub_category_id').empty();
                        $('#sub_category_id').append(
                            '<option value="">--Select Sub category--</option>');

                        $.each(data, function(key, value) {
                            $('#sub_category_id').append('<option value="' + key +
                                '">' + value + '</option>');
                        });

                    }
                });
            });
        });
    </script>
    <style>
        /* Beautiful styling for variation dropdowns */
        .variation-group {
            position: relative;
        }

        .variation-group .form-label {
            margin-bottom: 0.5rem;
            color: #495057;
            font-size: 0.9375rem;
        }

        /* Choices.js Custom Styling */
        .variation-select + .choices {
            margin-bottom: 0;
        }

        .variation-select + .choices .choices__inner {
            min-height: 50px;
            padding: 6px 10px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        .variation-select + .choices .choices__inner:hover {
            border-color: #0d6efd;
        }

        .variation-select + .choices.is-focused .choices__inner,
        .variation-select + .choices.is-open .choices__inner {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        /* Selected Items (Chips/Tags) */
        .variation-select + .choices .choices__list--multiple .choices__item {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: #fff;
            padding: 6px 12px;
            margin: 3px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            font-size: 0.875rem;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
            transition: all 0.2s ease;
        }

        .variation-select + .choices .choices__list--multiple .choices__item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.4);
        }

        /* Remove Button (×) */
        .variation-select + .choices .choices__list--multiple .choices__item .choices__button {
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            color: #fff;
            padding: 2px 6px;
            margin-left: 8px;
            border-radius: 50%;
            font-size: 1.1rem;
            line-height: 1;
            opacity: 0.9;
            transition: all 0.2s ease;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .variation-select + .choices .choices__list--multiple .choices__item .choices__button:hover {
            background-color: rgba(255, 255, 255, 0.3);
            opacity: 1;
            transform: rotate(90deg);
        }

        /* Dropdown List */
        .variation-select + .choices .choices__list--dropdown {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            margin-top: 4px;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .variation-select + .choices .choices__list--dropdown .choices__item--selectable {
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .variation-select + .choices .choices__list--dropdown .choices__item--selectable:hover,
        .variation-select + .choices .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
        }

        /* Placeholder */
        .variation-select + .choices .choices__placeholder {
            opacity: 0.6;
            color: #6c757d;
        }

        /* Input field inside dropdown */
        .variation-select + .choices .choices__input {
            background-color: transparent;
            margin-bottom: 0;
            padding: 4px 0;
        }

        /* Empty state */
        .variation-select + .choices .choices__list--dropdown .choices__item--choice.has-no-results {
            color: #6c757d;
            font-style: italic;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Choices.js for all variation select dropdowns
            const variationSelects = document.querySelectorAll('.variation-select');

            variationSelects.forEach(function(selectElement) {
                const attributeName = selectElement.getAttribute('data-attribute');

                const choices = new Choices(selectElement, {
                    removeItemButton: true,
                    shouldSort: false,
                    placeholder: true,
                    placeholderValue: `Select ${attributeName}...`,
                    searchPlaceholderValue: `Search ${attributeName}...`,
                    allowHTML: true,
                    noResultsText: 'No options found',
                    itemSelectText: 'Click to select',
                    maxItemCount: -1,
                    searchEnabled: true,
                    searchChoices: true,
                    searchFields: ['label', 'value'],
                    removeItemButtonAlignLeft: false,
                    classNames: {
                        containerOuter: 'choices',
                        containerInner: 'choices__inner',
                        input: 'choices__input',
                        inputCloned: 'choices__input--cloned',
                        list: 'choices__list',
                        listItems: 'choices__list--multiple',
                        listSingle: 'choices__list--single',
                        listDropdown: 'choices__list--dropdown',
                        item: 'choices__item',
                        itemSelectable: 'choices__item--selectable',
                        itemDisabled: 'choices__item--disabled',
                        itemChoice: 'choices__item--choice',
                        placeholder: 'choices__placeholder',
                        group: 'choices__group',
                        groupHeading: 'choices__heading',
                        button: 'choices__button',
                    },
                });
            });
        });
    </script>
@endsection
