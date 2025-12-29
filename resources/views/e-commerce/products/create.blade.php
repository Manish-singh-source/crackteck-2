@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product</li>
                            <li class="breadcrumb-item active" aria-current="page">Add Product</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Add New E-commerce Product</h4>
                </div>
            </div>

            <form id="ecommerceProductForm" action="{{ route('ec.product.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="warehouse_product_id" id="warehouse_product_id">

                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Warehouse Product Search Section -->
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Search Warehouse Product
                                                </h5>
                                                <p class="text-muted mb-0">Search and select a product from warehouse to
                                                    auto-fill details</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label" for="warehouse_search">
                                                    Search Product by Name, SKU, or Serial Number <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" id="warehouse_search"
                                                        placeholder="Type to search warehouse products..."
                                                        autocomplete="off">
                                                    <div id="search_results"
                                                        class="position-absolute w-100 bg-white border rounded shadow-sm"
                                                        style="z-index: 1000; max-height: 300px; overflow-y: auto; display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12" id="selected_product_info" style="display: none;">
                                                <div class="alert alert-success">
                                                    <div>
                                                        <img src="" id="selected_product_image" alt="">
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <strong>Selected Product:</strong> <span
                                                            id="selected_product_name"></span>
                                                        <button type="button" class="btn-close float-end"
                                                            id="clear_selection"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Basic Product Information (Auto-filled) -->
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Basic Product Information
                                                </h5>
                                                <p class="text-muted mb-0">Auto-filled from warehouse product</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    <label class="form-label" for="product_name">
                                                        Product Name <span class="text-danger">*</span>
                                                    </label>
                                                    <input name="product_name" id="product_name" type="text"
                                                        class="form-control" placeholder="Select warehouse product first"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    <label class="form-label" for="hsn_code">
                                                        HSN <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text"
                                                        class="form-control @error('hsn_code') is-invalid @enderror"
                                                        id="hsn_code" name="hsn_code"
                                                        placeholder="Enter unique HSN for e-commerce"
                                                        value="{{ old('hsn_code') }}">
                                                    @error('hsn_code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    <label class="form-label" for="sku">
                                                        SKU <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text"
                                                        class="form-control @error('sku') is-invalid @enderror"
                                                        id="sku" name="sku"
                                                        placeholder="Enter unique SKU for e-commerce"
                                                        value="{{ old('sku') }}">
                                                    @error('sku')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    <label class="form-label" for="brand_name">
                                                        Brand
                                                    </label>
                                                    <input type="text" class="form-control" id="brand_name"
                                                        name="brand_name" placeholder="Select warehouse product first"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    <label class="form-label" for="model_no">
                                                        Model No
                                                    </label>
                                                    <input type="text" class="form-control" id="model_no"
                                                        name="model_no" placeholder="Select warehouse product first"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    <label class="form-label" for="category_name">
                                                        Category
                                                    </label>
                                                    <input type="text" class="form-control" id="category_name"
                                                        name="category_name" placeholder="Select warehouse product first"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    <label class="form-label" for="subcategory_name">
                                                        Sub Category
                                                    </label>
                                                    <input type="text" class="form-control" id="subcategory_name"
                                                        name="subcategory_name"
                                                        placeholder="Select warehouse product first" readonly>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div>
                                                    <label class="form-label" for="stock_quantity">
                                                        Available Stock
                                                    </label>
                                                    <input type="text" class="form-control" id="stock_quantity"
                                                        name="stock_quantity" placeholder="Select warehouse product first"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- E-commerce Product Details -->
                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            E-commerce Product Details
                                        </h5>
                                        <p class="text-muted mb-0">Customize descriptions for e-commerce display</p>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div>
                                                    <label for="ecommerce_short_description" class="form-label">E-commerce
                                                        Short Description</label>
                                                    <div id="quill-editor-short" style="height: 200px;">
                                                        <p>Enter a compelling short description for e-commerce display...
                                                        </p>
                                                    </div>
                                                    <input type="hidden" name="ecommerce_short_description"
                                                        id="ecommerce_short_description">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div>
                                                    <label for="ecommerce_full_description" class="form-label">E-commerce
                                                        Full Description</label>
                                                    <div id="quill-editor-full" style="height: 300px;">
                                                        <p>Enter detailed product description for e-commerce display...</p>
                                                    </div>
                                                    <input type="hidden" name="ecommerce_full_description"
                                                        id="ecommerce_full_description">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div>
                                                    <label for="ecommerce_technical_specification"
                                                        class="form-label">E-commerce Technical Specifications</label>
                                                    <div id="quill-editor-tech" style="height: 300px;">
                                                        <p>Enter technical specifications formatted for e-commerce
                                                            display...</p>
                                                    </div>
                                                    <input type="hidden" name="ecommerce_technical_specification"
                                                        id="ecommerce_technical_specification">
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-6">
                                                <div class="row justify-content-end align-items-end">
                                                    <div class="col-11">
                                                        <div class="mb-3">
                                                            <label for="installation_option" class="form-label">With
                                                                Installation Options</label>
                                                            <input type="text" class="form-control"
                                                                id="installation_option"
                                                                placeholder="Enter installation option (e.g., Basic Installation, Premium Setup)">
                                                        </div>
                                                    </div>
                                                    <div class="col-1">
                                                        <div class="mb-3">
                                                            <button type="button"
                                                                class="btn btn-primary w-100 add-installation">Add</button>
                                                        </div>
                                                    </div>

                                                    {{-- <table class="table mt-4" id="installationTable"
                                                        style="display: none;">
                                                        <thead>
                                                            <tr>
                                                                <th>Installation Options</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Selected values will appear here -->
                                                        </tbody>
                                                    </table> --}}

                                                    <table class="table table-bordered table-hover table-sm align-middle"
                                                        id="installationTable" style="display: none;">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th class="text-start">Installation Option</th>
                                                                <th class="text-end" style="width: 60px;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="installation_tbody">
                                                            <!-- JS will inject rows here -->
                                                        </tbody>
                                                    </table>


                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div class="mb-3">
                                                    <label for="brand_warranty" class="form-label">Brand Warranty</label>
                                                    <input type="text" class="form-control" id="brand_warranty"
                                                        name="brand_warranty" placeholder="Auto-filled from warehouse"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6">
                                                <div class="mb-3">
                                                    <label for="company_warranty" class="form-label">Company
                                                        Warranty</label>
                                                    <input type="text" class="form-control" id="company_warranty"
                                                        name="company_warranty" placeholder="Enter company warranty" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing Information (Auto-filled from Warehouse) -->
                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Pricing Information
                                        </h5>
                                        <p class="text-muted mb-0">Auto-filled from warehouse product</p>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6 mb-2">
                                                <div>
                                                    <label for="cost_price" class="form-label">Cost Price</label>
                                                    <input name="cost_price" id="cost_price" type="text"
                                                        class="form-control" placeholder="Select warehouse product first"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <div>
                                                    <label for="selling_price" class="form-label">Selling Price</label>
                                                    <input name="selling_price" id="selling_price" type="text"
                                                        class="form-control" placeholder="Select warehouse product first"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <div>
                                                    <label for="discount_price" class="form-label">Discount Price</label>
                                                    <input name="discount_price" id="discount_price" type="text"
                                                        class="form-control" placeholder="Select warehouse product first"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <div>
                                                    <label for="tax" class="form-label">Tax (%)</label>
                                                    <input name="tax" id="tax" type="text"
                                                        class="form-control" placeholder="Select warehouse product first"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <div>
                                                    <label for="final_price" class="form-label">Final Price</label>
                                                    <input name="final_price" id="final_price" type="text"
                                                        class="form-control" placeholder="Select warehouse product first"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- E-commerce Inventory Settings -->
                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            E-commerce Inventory Settings
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6 mb-2">
                                                <div>
                                                    <label for="warehouse_stock" class="form-label">Warehouse
                                                        Stock</label>
                                                    <input name="warehouse_stock" id="warehouse_stock" type="text"
                                                        class="form-control" placeholder="Select warehouse product first"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <div>
                                                    <label for="warehouse_stock_status" class="form-label">Stock
                                                        Status</label>
                                                    <input name="warehouse_stock_status" id="warehouse_stock_status"
                                                        type="text" class="form-control"
                                                        placeholder="Select warehouse product first" readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <div>
                                                    <label for="min_order_qty" class="form-label">Minimum Order Qty <span
                                                            class="text-danger">*</span></label>
                                                    <input name="min_order_qty" id="min_order_qty" type="number"
                                                        class="form-control" placeholder="Enter Minimum Order Quantity"
                                                        value="1" required>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <div>
                                                    <label for="max_order_qty" class="form-label">Maximum Order
                                                        Qty</label>
                                                    <input name="max_order_qty" id="max_order_qty" type="number"
                                                        class="form-control" placeholder="Enter Maximum Order Quantity">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- SEO Section -->
                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            SEO Settings
                                        </h5>
                                        <p class="text-muted mb-0">Optimize your product for search engines</p>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div>
                                                    <label for="meta_title" class="form-label">Meta Title</label>
                                                    <input name="meta_title" id="meta_title" type="text"
                                                        class="form-control" placeholder="Enter SEO meta title"
                                                        maxlength="60">
                                                    <small class="text-muted">Recommended: 50-60 characters</small>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div>
                                                    <label for="meta_description" class="form-label">Meta
                                                        Description</label>
                                                    <textarea name="meta_description" id="meta_description" rows="3" class="form-control"
                                                        placeholder="Enter SEO meta description" maxlength="160"></textarea>
                                                    <small class="text-muted">Recommended: 150-160 characters</small>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div>
                                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                                    <input name="meta_keywords" id="meta_keywords" type="text"
                                                        class="form-control"
                                                        placeholder="Enter keywords separated by commas">
                                                    <small class="text-muted">Separate keywords with commas</small>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div>
                                                    <label for="meta_product_url_slug" class="form-label">Product URL
                                                        Slug</label>
                                                    <input name="meta_product_url_slug" id="meta_product_url_slug"
                                                        type="text" class="form-control"
                                                        placeholder="Auto-generated from product name">
                                                    <small class="text-muted">Leave empty to auto-generate</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-4">
                                <!-- Product Images (Auto-filled from Warehouse) -->
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Product Images & Media
                                        </h5>
                                        <p class="text-muted mb-0">Auto-filled from warehouse product</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="main_product_image_display" class="form-label">Main Product
                                                Image</label>
                                            <div id="main_image_preview" class="border rounded p-3 text-center"
                                                style="min-height: 200px;">
                                                <p class="text-muted">Select warehouse product to view image</p>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Additional Images</label>
                                            <div id="additional_images_preview" class="border rounded p-3">
                                                <p class="text-muted">Select warehouse product to view additional images
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Product Manual/Datasheet</label>
                                            <div id="datasheet_preview" class="border rounded p-3">
                                                <p class="text-muted">Select warehouse product to view datasheet</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- E-commerce Settings -->
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            E-commerce Settings
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="mb-3">
                                            @include('components.form.select', [
                                                'label' => 'Status',
                                                'name' => 'status',
                                                'value' => '1',
                                                'options' => [
                                                    '0' => 'Inactive',
                                                    '1' => 'Active',
                                                    '2' => 'Draft',
                                                ],
                                            ])
                                        </div>

                                        <div class="mb-3">
                                            <label for="product_tags_input" class="form-label">Product Tags</label>

                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" id="product_tags_input"
                                                    placeholder="Enter a tag and click Add">
                                                <button type="button" class="btn btn-outline-primary" id="add_tag_btn">
                                                    Add
                                                </button>
                                            </div>

                                            <small class="text-muted d-block mb-2">
                                                Example: Best Seller, High-Speed, Premium
                                            </small>

                                            {{-- Checklist of tags --}}
                                            <div id="product_tags_list" class="border rounded p-2"
                                                style="min-height: 40px;">
                                                {{-- JS will append checkboxes here --}}
                                            </div>

                                            {{-- Hidden input to store tags as JSON --}}
                                            <input type="hidden" name="product_tags" id="product_tags_json"
                                                value='@json(old('product_tags', $product->product_tags ?? []))'>
                                        </div>

                                    </div>
                                </div>

                                <!-- Shipping Details -->
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Shipping Details
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="shipping_charges" class="form-label">Shipping Charges</label>
                                            <input name="shipping_charges" id="shipping_charges" type="number"
                                                step="0.01" class="form-control" placeholder="0.00">
                                        </div>
                                        <div class="mb-3">
                                            @include('components.form.select', [
                                                'label' => 'Shipping Class',
                                                'name' => 'shipping_class',
                                                'value' => '0',
                                                'options' => [
                                                    '' => '--Select--',
                                                    '0' => 'Light',
                                                    '1' => 'Medium',
                                                    '2' => 'Heavy',
                                                    '3' => 'Fragile',
                                                ],
                                            ])
                                        </div>
                                        <div class="mb-3">
                                            @include('components.form.select', [
                                                'label' => 'Featured Product',
                                                'name' => 'is_featured',
                                                'value' => '0',
                                                'options' => [
                                                    '' => '--Select--',
                                                    '0' => 'No',
                                                    '1' => 'Yes',
                                                ],
                                            ])
                                        </div>
                                        <div class="mb-3">
                                            @include('components.form.select', [
                                                'label' => 'Best Seller',
                                                'name' => 'is_best_seller',
                                                'value' => '0',
                                                'options' => [
                                                    '' => '--Select--',
                                                    '0' => 'No',
                                                    '1' => 'Yes',
                                                ],
                                            ])
                                        </div>
                                        <div class="mb-3">
                                            @include('components.form.select', [
                                                'label' => 'Suggested Product',
                                                'name' => 'is_suggested',
                                                'value' => '0',
                                                'options' => [
                                                    '' => '--Select--',
                                                    '0' => 'No',
                                                    '1' => 'Yes',
                                                ],
                                            ])
                                        </div>
                                        <div class="mb-3">
                                            @include('components.form.select', [
                                                'label' => 'Today\'s Deal',
                                                'name' => 'is_todays_deal',
                                                'value' => '0',
                                                'options' => [
                                                    '' => '--Select--',
                                                    '0' => 'No',
                                                    '1' => 'Yes',
                                                ],
                                            ])
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="text-start mb-3">
                                        <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                            <i class="fas fa-save me-1"></i> Create E-commerce Product
                                        </button>
                                        <a href="{{ route('ec.product.index') }}" class="btn btn-secondary w-sm ms-2">
                                            <i class="fas fa-times me-1"></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div> <!-- container-fluid -->
    </div> <!-- content -->

    <!-- Include Quill Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        $(document).ready(function() {
            let searchTimeout;
            let selectedProductId = null;
            let installationOptions = [];

            // Initialize Quill editors
            const quillShort = new Quill('#quill-editor-short', {
                theme: 'snow',
                placeholder: 'Enter short description for e-commerce...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        ['link'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['clean']
                    ]
                }
            });

            const quillFull = new Quill('#quill-editor-full', {
                theme: 'snow',
                placeholder: 'Enter full description for e-commerce...',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['link', 'image'],
                        ['clean']
                    ]
                }
            });

            const quillTech = new Quill('#quill-editor-tech', {
                theme: 'snow',
                placeholder: 'Enter technical specifications for e-commerce...',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        ['blockquote'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['link'],
                        ['clean']
                    ]
                }
            });

            // Warehouse Product Search
            $('#warehouse_search').on('input', function() {
                const query = $(this).val();

                clearTimeout(searchTimeout);

                if (query.length < 2) {
                    $('#search_results').hide();
                    return;
                }

                searchTimeout = setTimeout(function() {
                    $.ajax({
                        url: '{{ route('ec.product.search-warehouse') }}',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(data) {
                            displaySearchResults(data);
                        },
                        error: function() {
                            $('#search_results').html(
                                '<div class="p-2 text-danger">Error searching products</div>'
                            ).show();
                        }
                    });
                }, 300);
            });

            // Display search results
            function displaySearchResults(products) {
                if (products.length === 0) {
                    $('#search_results').html('<div class="p-2 text-muted">No products found</div>').show();
                    return;
                }

                let html = '';
                products.forEach(function(product) {
                    console.log(product.main_product_image);
                    html += `
                        <div class="search-result-item p-2 border-bottom cursor-pointer" data-product-id="${product.id}">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2">
                                        <div>
                                            <img src="/${product.main_product_image}" alt="${product.product_name}" style=" height: 40px; object-fit: cover;">
                                        </div>
                                        <div>
                                            <div class="fw-semibold">${product.product_name} - ${product.sku}</div>
                                            <small class="text-muted">Stock: ${product.stock_quantity} | Status: ${product.status == 1 ? 'Active' : 'Inactive'}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                $('#search_results').html(html).show();
            }

            // Handle search result selection
            $(document).on('click', '.search-result-item', function() {
                const productId = $(this).data('product-id');
                selectedProductId = productId;

                // Hide search results
                $('#search_results').hide();
                $('#warehouse_search').val('');

                // Fetch and fill product details
                fetchAndFillProductDetails(productId);
            });

            // Fetch and auto-fill product details
            function fetchAndFillProductDetails(productId) {
                $.ajax({
                    url: `{{ route('ec.product.get-warehouse', ':id') }}`.replace(':id', productId),
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            fillProductDetails(response.product);
                        }
                    },
                    error: function() {
                        alert('Error fetching product details');
                    }
                });
            }

            // Fill product details in form
            function fillProductDetails(product) {
                // Set warehouse product ID
                console.log(product);
                $('#warehouse_product_id').val(product.id);

                // Fill basic information
                $('#product_name').val(product.product_name);
                $('#sku').val(product.sku);
                $('#sku').attr('readonly', true);
                // Note: SKU is now manually entered for e-commerce products
                $('#hsn_code').val(product.hsn_code);
                $('#brand_name').val(product.brand_name);
                $('#model_no').val(product.model_no);
                $('#serial_no').val(product.serial_no);
                $('#category_name').val(product.category_name);
                $('#subcategory_name').val(product.subcategory_name);
                $('#stock_quantity').val(product.stock_quantity);

                // Fill pricing information
                $('#cost_price').val(product.cost_price);
                $('#selling_price').val(product.selling_price);
                $('#discount_price').val(product.discount_price);
                $('#tax').val(product.tax);
                $('#final_price').val(product.final_price);

                // Fill inventory
                $('#warehouse_stock').val(product.stock_quantity);

                if (product.stock_status == '0') {
                    $('#warehouse_stock_status').val('In Stock');
                } else if (product.stock_status == '1') {
                    $('#warehouse_stock_status').val('Out of Stock');
                } else if (product.stock_status == '2') {
                    $('#warehouse_stock_status').val('Low Stock');
                } else if (product.stock_status == '3') {
                    $('#warehouse_stock_status').val('Scrap');
                }

                // Maximum Order Qty
                $('#max_order_qty').val(product.stock_quantity);

                // Fill warranty
                $('#brand_warranty').val(product.brand_warranty);
                $('#company_warranty').val(product.company_warranty);

                // Fill Quill editors with warehouse data
                quillShort.root.innerHTML = product.short_description ||
                    '<p>Enter short description for e-commerce...</p>';
                quillFull.root.innerHTML = product.full_description ||
                    '<p>Enter full description for e-commerce...</p>';
                quillTech.root.innerHTML = product.technical_specification ||
                    '<p>Enter technical specifications for e-commerce...</p>';

                // Show images
                if (product.main_product_image) {
                    $('#main_image_preview').html(
                        `<img src="{{ asset('') }}${product.main_product_image}" class="img-fluid rounded" style="max-height: 200px;">`
                    );
                }

                // console.log(product.additional_product_images);
                if (product.additional_product_images) {
                    let additionalHtml = '';
                    // console.log(product.additional_product_images);
                    additionalImages = JSON.parse(product.additional_product_images);
                    additionalImages.forEach(function(image) {
                        additionalHtml +=
                            `<img src="{{ asset('') }}${image}" class="img-fluid rounded" style="max-height: 100px;">`;
                    });
                    $('#additional_images_preview').html(additionalHtml);
                }

                // if (product.additional_product_images && product.additional_product_images.length > 0) {
                //     let additionalHtml = '';
                //     product.additional_product_images.forEach(function(image) {
                //         additionalHtml +=
                //             `<img src="{{ asset('') }}${image}" class="img-thumbnail me-2 mb-2" style="width: 60px; height: 60px;">`;
                //     });
                //     $('#additional_images_preview').html(additionalHtml);
                // }

                if (product.datasheet_manual) {
                    $('#datasheet_preview').html(
                        `<a href="{{ asset('') }}${product.datasheet_manual}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="mdi mdi-file-pdf-outline"></i> Download PDF
                        </a>`
                    );
                }

                // Auto-generate SEO fields
                $('#meta_title').val(product.product_name);
                $('#meta_description').val(product.short_description ? product.short_description.substring(0, 160) :
                    '');
                $('#meta_keywords').val(product.brand_name + ', ' + product.category_name);

                // Show selected product info
                $('#selected_product_name').text(product.product_name + ' (Warehouse SKU: ' + product.sku + ')');
                $('#selected_product_image').attr('src', product.main_product_image);
                $('#selected_product_info').show();
            }

            // Clear selection
            $('#clear_selection').on('click', function() {
                selectedProductId = null;
                $('#selected_product_info').hide();
                $('#ecommerceProductForm')[0].reset();

                // Clear Quill editors
                quillShort.root.innerHTML = '<p>Enter short description for e-commerce...</p>';
                quillFull.root.innerHTML = '<p>Enter full description for e-commerce...</p>';
                quillTech.root.innerHTML = '<p>Enter technical specifications for e-commerce...</p>';

                // Clear image previews
                $('#main_image_preview').html(
                    '<p class="text-muted">Select warehouse product to view image</p>');
                $('#additional_images_preview').html(
                    '<p class="text-muted">Select warehouse product to view additional images</p>');
                $('#datasheet_preview').html(
                    '<p class="text-muted">Select warehouse product to view datasheet</p>');
            });

            // Installation options management
            $('.add-installation').on('click', function(e) {
                e.preventDefault();
                const installationValue = $('#installation_option').val().trim();

                if (installationValue && !installationOptions.includes(installationValue)) {
                    installationOptions.push(installationValue);
                    updateInstallationTable();
                    $('#installation_option').val('');
                }
            });

            function updateInstallationTable() {
                if (installationOptions.length === 0) {
                    $('#installationTable').hide();
                    return;
                }

                let html = '';
                installationOptions.forEach(function(option, index) {
                    html += `
                        <tr>
                            <td class="py-2">
                                <span class="fw-medium text-dark">${option}</span>
                            </td>
                            <td class="text-end py-2">
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger remove-installation"
                                        data-index="${index}"
                                        title="Remove">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });

                $('#installation_tbody').html(html);
                $('#installationTable').show();
            }

            // Remove installation option
            $(document).on('click', '.remove-installation', function() {
                const index = $(this).data('index');
                installationOptions.splice(index, 1);
                updateInstallationTable();
            });

            // Handle product tags
            $('#product_tags_input').on('blur', function() {
                const tags = $(this).val().split(',').map(tag => tag.trim()).filter(tag => tag);
                // Store tags for form submission
                $(this).data('tags', tags);
            });

            // Form submission
            $(document).on('submit', '#ecommerceProductForm', function(e) {
                e.preventDefault();

                if (!selectedProductId) {
                    alert('Please select a warehouse product first.');
                    return;
                }

                // Update hidden fields with Quill content
                $('#ecommerce_short_description').val(quillShort.root.innerHTML);
                $('#ecommerce_full_description').val(quillFull.root.innerHTML);
                $('#ecommerce_technical_specification').val(quillTech.root.innerHTML);

                const formElement = this;
                const fd = new FormData(formElement);

                // Ensure CSRF token is present (in case @csrf not in form)
                fd.set('_token', '{{ csrf_token() }}');

                // Append installation options as an array
                installationOptions.forEach(function(option, index) {
                    fd.append(`installation_options[${index}]`, option);
                });

                // Add product tags (send as JSON string so controller can accept string or array)
                const tags = $('#product_tags_input').val() ? $('#product_tags_input').val().split(',').map(tag => tag.trim()).filter(tag => tag) : [];
                if (tags.length) {
                    fd.set('product_tags', JSON.stringify(tags));
                }

                $.ajax({
                    url: $(formElement).attr('action'),
                    method: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            } else {
                                // fallback: reload
                                window.location.reload();
                            }
                        } else {
                            alert(response.message || 'An error occurred while creating the product');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        let message = 'An error occurred';

                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            } else if (xhr.responseJSON.errors) {
                                // Show validation errors
                                const errs = xhr.responseJSON.errors;
                                message = Object.values(errs).flat().join('\n');
                            }
                        }

                        alert(message);
                    }
                });
            });

            // Hide search results when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#warehouse_search, #search_results').length) {
                    $('#search_results').hide();
                }
            });

            // AJAX SKU Validation for E-commerce Products
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
                            url: '{{ route('ec.product.check-sku') }}',
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
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('product_tags_input');
            const addBtn = document.getElementById('add_tag_btn');
            const listDiv = document.getElementById('product_tags_list');
            const jsonField = document.getElementById('product_tags_json');

            let tags = [];

            // Load existing tags from hidden JSON (for edit page)
            try {
                const existing = jsonField.value ? JSON.parse(jsonField.value) : [];
                if (Array.isArray(existing)) {
                    tags = existing;
                }
            } catch (e) {
                tags = [];
            }

            function renderTags() {
                listDiv.innerHTML = '';

                if (!tags.length) {
                    listDiv.innerHTML =
                        '<span class="text-muted small">No tags added yet.</span>';
                }

                tags.forEach((tag, index) => {
                    const id = 'tag_chk_' + index;
                    const wrapper = document.createElement('div');
                    wrapper.className = 'form-check form-check-inline me-3 mb-1';

                    wrapper.innerHTML = `
                <input class="form-check-input product-tag-checkbox"
                       type="checkbox"
                       id="${id}"
                       data-index="${index}"
                       checked>
                <label class="form-check-label" for="${id}">
                    ${tag}
                </label>
            `;

                    listDiv.appendChild(wrapper);
                });

                // Sync to hidden JSON
                jsonField.value = JSON.stringify(tags);
            }

            function addTagFromInput() {
                const value = input.value.trim();
                if (!value) return;

                // avoid duplicates (case-insensitive)
                const exists = tags.some(t => t.toLowerCase() === value.toLowerCase());
                if (!exists) {
                    tags.push(value);
                    renderTags();
                }
                input.value = '';
                input.focus();
            }

            addBtn.addEventListener('click', addTagFromInput);

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addTagFromInput();
                }
            });

            listDiv.addEventListener('change', function(e) {
                if (!e.target.classList.contains('product-tag-checkbox')) return;

                const index = parseInt(e.target.getAttribute('data-index'), 10);
                if (!isNaN(index) && tags[index] !== undefined) {
                    // unchecked → remove tag
                    if (!e.target.checked) {
                        tags.splice(index, 1);
                        renderTags();
                    }
                }
            });

            // Initial render with existing tags
            renderTags();
        });
    </script>
@endsection
