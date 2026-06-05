@extends('warehouse/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Add New Product</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">

                    <form action="{{ route('product-list.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Vendor Information
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    @include('components.form.select', [
                                                        'label' => 'Vendor',
                                                        'name' => 'vendor_id',
                                                        'options' => $vendors->prepend('-- Select Vendor --', 0),
                                                    ])
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    <label class="form-label">Vendor PO Number</label>
                                                    <select name="vendor_purchase_order_id" id="vendor_purchase_order_id"
                                                        class="form-select @error('vendor_purchase_order_id') is-invalid @enderror"
                                                        data-old-value="{{ old('vendor_purchase_order_id') }}">
                                                        <option value="">--Select--</option>
                                                    </select>
                                                    @error('vendor_purchase_order_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div class="">
                                                    @include('components.form.select', [
                                                        'label' => 'Brand',
                                                        'name' => 'brand_id',
                                                        'options' =>
                                                            ['' => '--Select Brand--'] + $brands->toArray(),
                                                    ])
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                {{-- Parent Category --}}
                                                @include('components.form.select', [
                                                    'label' => 'Parent Category',
                                                    'name' => 'parent_category_id', // keep as requested
                                                    'id' => 'parent_category_id',
                                                    'options' =>
                                                        ['' => '--Select Parent Category--'] +
                                                        $parentCategories->toArray(),
                                                ])
                                            </div>

                                            <div class="col-lg-6">
                                                {{-- Sub Category --}}
                                                <label class="form-label">Sub Category</label>
                                                <select name="sub_category_id" id="sub_category_id"
                                                    class="form-select @error('sub_category_id') is-invalid @enderror"
                                                    data-old-value="{{ old('sub_category_id') }}">
                                                    <option value="">--Select Sub Category--</option>
                                                </select>
                                                @error('sub_category_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6">
                                                @include('components.form.select', [
                                                    'label' => 'Warehouse',
                                                    'name' => 'warehouse_id',
                                                    'options' =>
                                                        ['' => 'Select Warehouse'] + $warehouses->toArray(),
                                                    'model' => isset($product) ? $product : null,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Basic Product Information
                                                </h5>
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
                                                    ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Product Details
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div>
                                                    <label for="short_description" class="form-label">Short
                                                        Description</label>
                                                    <div id="short-description-editor" style="height: 200px;"></div>
                                                    <input type="hidden" name="short_description" id="short_description"
                                                        value="{{ old('short_description') }}">
                                                    @error('short_description')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div>
                                                    <label for="full_description" class="form-label">Full
                                                        Description</label>
                                                    <div id="full-description-editor" style="height: 300px;"></div>
                                                    <input type="hidden" name="full_description" id="full_description"
                                                        value="{{ old('full_description') }}">
                                                    @error('full_description')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div>
                                                    <label for="technical_specification" class="form-label">Technical
                                                        Specifications</label>
                                                    <div id="technical-specification-editor" style="height: 300px;"></div>
                                                    <input type="hidden" name="technical_specification"
                                                        id="technical_specification"
                                                        value="{{ old('technical_specification') }}">
                                                    @error('technical_specification')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="mb-3">
                                                    @include('components.form.input', [
                                                        'label' => 'Brand Warranty',
                                                        'name' => 'brand_warranty',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Brand Warranty',
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
                                                    ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-4">
                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Pricing
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Cost Price',
                                                        'name' => 'cost_price',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Cost Price',
                                                    ])
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Selling Price',
                                                        'name' => 'selling_price',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Selling Price',
                                                    ])
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Discount Price',
                                                        'name' => 'discount_price',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Discount Price',
                                                    ])
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Tax (%)',
                                                        'name' => 'tax',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Tax',
                                                    ])
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Final Price (Calculated)',
                                                        'name' => 'final_price',
                                                        'type' => 'text',
                                                        'placeholder' => 'Auto-calculated',
                                                        'readonly' => true,
                                                    ])
                                                    <small class="text-muted">This field is automatically calculated based
                                                        on selling price, discount, and tax</small>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div>
                                                    @include('components.form.input', [
                                                        'label' => 'Stock Quantity',
                                                        'name' => 'stock_quantity',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Stock Quantity',
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
                                                    ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Images and Media:
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            @include('components.form.input', [
                                                'label' => 'Main Product Image',
                                                'name' => 'main_product_image',
                                                'type' => 'file',
                                                'placeholder' => 'Upload Main Product Image',
                                                'accept' => 'image/*',
                                            ])
                                            <div id="emailHelp" class="text-danger">Image Size Should Be
                                                800x650
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="additional_product_images" class="form-label">Additional Product
                                                Images</label>
                                            <input type="file"
                                                class="form-control @error('additional_product_images') is-invalid @enderror @error('additional_product_images.*') is-invalid @enderror"
                                                name="additional_product_images[]" multiple accept="image/*">
                                            <div class="text-danger">Image Size Should Be 800x650</div>
                                            @if ($errors->has('additional_product_images'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('additional_product_images') }}</div>
                                            @endif
                                            @foreach ($errors->get('additional_product_images.*') as $messages)
                                                @foreach ((array) $messages as $message)
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @endforeach
                                            @endforeach
                                        </div>

                                        <div class="mb-3">
                                            @include('components.form.input', [
                                                'label' => 'Product Datasheet or Manual',
                                                'name' => 'datasheet_manual',
                                                'type' => 'file',
                                                'placeholder' => 'Upload Product Datasheet or Manual',
                                                'accept' =>
                                                    'application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                            ])
                                            <div class="text-danger">PDF files only</div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Product Variations --}}
                                <div class="card">
                                    <div
                                        class="card-header border-bottom-dashed d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Product Variations</h5>
                                        <span class="badge bg-primary">Multiple Select Enabled</span>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            @foreach ($variationAttributes as $attribute)
                                                <div class="col-md-12">
                                                    <div class="variation-group">
                                                        <label for="variation_{{ $attribute->id }}"
                                                            class="form-label fw-semibold">
                                                            {{ $attribute->name }}
                                                            <span class="text-muted fw-normal">(Select Multiple)</span>
                                                        </label>
                                                        <select id="variation_{{ $attribute->id }}"
                                                            name="variations[{{ $attribute->name }}][]"
                                                            class="form-select variation-select" multiple
                                                            data-attribute="{{ $attribute->name }}">
                                                            @foreach ($attribute->values as $value)
                                                                @php
                                                                    $selectedValues =
                                                                        $selectedVariations[$attribute->name] ?? [];
                                                                    $isSelected = in_array(
                                                                        $value->value,
                                                                        $selectedValues,
                                                                    );
                                                                @endphp
                                                                <option value="{{ $value->value }}"
                                                                    @if ($isSelected) selected @endif>
                                                                    {{ $value->value }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @php
                                            $variationError = null;
                                            foreach ($errors->keys() as $key) {
                                                if (str_starts_with($key, 'variations')) {
                                                    $variationError = $errors->first($key);
                                                    break;
                                                }
                                            }
                                        @endphp

                                        @if ($variationError)
                                            <div class="text-danger mb-3">{{ $variationError }}</div>
                                        @endif

                                        @if ($variationAttributes->isEmpty())
                                            <div class="alert alert-info mb-0">
                                                <i class="bx bx-info-circle me-2"></i>
                                                No product variations available. Please add variations from the E-commerce
                                                section.
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Shipping Information --}}
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Shipping Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="mb-3">
                                                    @include('components.form.input', [
                                                        'label' => 'Weight',
                                                        'name' => 'weight',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Weight (e.g., 5kg)',
                                                    ])
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="mb-3">
                                                    @include('components.form.input', [
                                                        'label' => 'Dimensions',
                                                        'name' => 'dimensions',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Dimensions (e.g., 10x20x30 cm)',
                                                    ])
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="mb-3">
                                                    @include('components.form.input', [
                                                        'label' => 'Shipping Time',
                                                        'name' => 'shipping_time',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Shipping Time (e.g., 2-3 days)',
                                                    ])
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="mb-3">
                                                    @include('components.form.select', [
                                                        'label' => 'Cash on Delivery (COD)',
                                                        'name' => 'cod',
                                                        'options' => [
                                                            '' => '--Select--',
                                                            'yes' => 'Yes',
                                                            'no' => 'No',
                                                        ],
                                                    ])
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="mb-3">
                                                    @include('components.form.select', [
                                                        'label' => 'Installation',
                                                        'name' => 'installation',
                                                        'options' => [
                                                            '' => '--Select--',
                                                            'yes' => 'Yes',
                                                            'no' => 'No',
                                                        ],
                                                    ])
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="mb-3">
                                                    @include('components.form.select', [
                                                        'label' => 'Product Status',
                                                        'name' => 'status',
                                                        'value' => 'active',
                                                        'options' => [
                                                            '' => '--Select--',
                                                            'inactive' => 'Inactive',
                                                            'active' => 'Active',
                                                        ],
                                                    ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="text-start mb-3">
                                    <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                        Submit
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

            var oldShortDescription = @json(old('short_description', ''));
            var oldFullDescription = @json(old('full_description', ''));
            var oldTechnicalSpecification = @json(old('technical_specification', ''));

            if (oldShortDescription) {
                shortDescriptionQuill.root.innerHTML = oldShortDescription;
            }
            if (oldFullDescription) {
                fullDescriptionQuill.root.innerHTML = oldFullDescription;
            }
            if (oldTechnicalSpecification) {
                technicalSpecificationQuill.root.innerHTML = oldTechnicalSpecification;
            }

            function getQuillHtmlValue(quill) {
                var text = quill.getText().trim();
                return text.length ? quill.root.innerHTML : '';
            }

            // Update hidden inputs when form is submitted
            $('form').on('submit', function() {
                $('#short_description').val(getQuillHtmlValue(shortDescriptionQuill));
                $('#full_description').val(getQuillHtmlValue(fullDescriptionQuill));
                $('#technical_specification').val(getQuillHtmlValue(technicalSpecificationQuill));
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
            function loadVendorPurchaseOrders(vendorId, selectedPurchaseOrderId) {
                if (!vendorId) {
                    $('#vendor_purchase_order_id').empty().append('<option value="">--Select--</option>');
                    return;
                }

                $.ajax({
                    url: '{{ route('product-list.get-vendor-purchase-orders-by-vendor') }}',
                    method: 'GET',
                    data: {
                        vendor_id: vendorId
                    },
                    success: function(data) {
                        var $select = $('#vendor_purchase_order_id');
                        $select.empty().append('<option value="">--Select--</option>');
                        $.each(data, function(key, value) {
                            $select.append('<option value="' + key + '">' + value +
                                '</option>');
                        });
                        if (selectedPurchaseOrderId) {
                            $select.val(selectedPurchaseOrderId);
                        }
                    }
                });
            }

            function loadSubCategories(parentId, selectedSubCategoryId) {
                var $select = $('#sub_category_id');
                if (!parentId) {
                    $select.empty().append('<option value="">--Select Sub Category--</option>');
                    return;
                }

                $.ajax({
                    url: '{{ route('product-list.get-sub-categories') }}',
                    method: 'GET',
                    data: {
                        parent_id: parentId
                    },
                    success: function(data) {
                        $select.empty().append('<option value="">--Select Sub Category--</option>');
                        $.each(data, function(key, value) {
                            $select.append('<option value="' + key + '">' + value +
                                '</option>');
                        });
                        var selected = $select.data('old-value');
                        if (selected) {
                            $select.val(selected);
                        }
                    }
                });
            }

            $('#vendor_id').on('change', function() {
                var vendorId = $(this).val();
                var selected = $('#vendor_purchase_order_id').data('old-value');
                loadVendorPurchaseOrders(vendorId, selected);
            });

            $('#parent_category_id').on('change', function() {
                var parentId = $(this).val();
                loadSubCategories(parentId);
            });

            var oldVendorId = @json(old('vendor_id'));
            var oldParentCategoryId = @json(old('parent_category_id'));

            if (oldVendorId) {
                $('#vendor_id').val(oldVendorId).trigger('change');
            }

            if (oldParentCategoryId) {
                $('#parent_category_id').val(oldParentCategoryId).trigger('change');
            }
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
        .variation-select+.choices {
            margin-bottom: 0;
        }

        .variation-select+.choices .choices__inner {
            min-height: 50px;
            padding: 6px 10px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        .variation-select+.choices .choices__inner:hover {
            border-color: #0d6efd;
        }

        .variation-select+.choices.is-focused .choices__inner,
        .variation-select+.choices.is-open .choices__inner {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        /* Selected Items (Chips/Tags) */
        .variation-select+.choices .choices__list--multiple .choices__item {
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

        .variation-select+.choices .choices__list--multiple .choices__item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.4);
        }

        /* Remove Button (×) */
        .variation-select+.choices .choices__list--multiple .choices__item .choices__button {
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

        .variation-select+.choices .choices__list--multiple .choices__item .choices__button:hover {
            background-color: rgba(255, 255, 255, 0.3);
            opacity: 1;
            transform: rotate(90deg);
        }

        /* Dropdown List */
        .variation-select+.choices .choices__list--dropdown {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            margin-top: 4px;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .variation-select+.choices .choices__list--dropdown .choices__item--selectable {
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .variation-select+.choices .choices__list--dropdown .choices__item--selectable:hover,
        .variation-select+.choices .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
        }

        /* Placeholder */
        .variation-select+.choices .choices__placeholder {
            opacity: 0.6;
            color: #6c757d;
        }

        /* Input field inside dropdown */
        .variation-select+.choices .choices__input {
            background-color: transparent;
            margin-bottom: 0;
            padding: 4px 0;
        }

        /* Empty state */
        .variation-select+.choices .choices__list--dropdown .choices__item--choice.has-no-results {
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
