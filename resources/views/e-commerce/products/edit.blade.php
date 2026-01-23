@extends('e-commerce/layouts/master')

@section('content')

    <div class="content">
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit E-commerce Product</h4>
                    <p class="text-muted">Update product information for both warehouse and e-commerce</p>
                </div>
                <div>
                    <a href="{{ route('ec.product.view', $product->id) }}" class="btn btn-secondary">View Product</a>
                    <a href="{{ route('ec.product.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>

            <form id="editProductForm" action="{{ route('ec.product.update', $product->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Hidden: linked warehouse product id (required by validation) --}}
                <input type="hidden" name="warehouse_product_id" id="warehouse_product_id" value="{{ old('warehouse_product_id', $product->product_id) }}">

                <div class="row">
                    <div class="col-lg-8">
                        <!-- Warehouse Product Information (Read-only) -->
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Warehouse Product Information</h5>
                                <p class="text-muted mb-0">This information comes from the linked warehouse product</p>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ $product->warehouseProduct->product_name }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">HSN</label>
                                        <input type="text" class="form-control"
                                            value="{{ $product->warehouseProduct->hsn_code }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">SKU <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                            id="sku" name="sku" placeholder="Enter unique SKU for e-commerce"
                                            value="{{ old('sku', $product->sku) }}">
                                        @error('sku')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Brand</label>
                                        <input type="text" class="form-control"
                                            value="{{ $product->warehouseProduct->brand->name ?? 'N/A' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Model No</label>
                                        <input type="text" class="form-control"
                                            value="{{ $product->warehouseProduct->model_no ?? 'N/A' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Category</label>
                                        <input type="text" class="form-control"
                                            value="{{ $product->warehouseProduct->parentCategorie->name ?? 'N/A' }}"
                                            readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Category</label>
                                        <input type="text" class="form-control"
                                            value="{{ $product->warehouseProduct->subCategorie->name ?? 'N/A' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Available Stock</label>
                                        <input type="text" class="form-control"
                                            value="{{ $product->warehouseProduct->stock_quantity ?? 0 }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- E-commerce Descriptions -->
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">E-commerce Descriptions</h5>
                                <p class="text-muted mb-0">These descriptions are specific to e-commerce and can be
                                    different from warehouse descriptions</p>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label" for="short_description">E-commerce Short
                                            Description</label>
                                        <textarea class="form-control" id="short_description" name="short_description" rows="3"
                                            placeholder="Enter short description for e-commerce">{{ old('short_description', $product->short_description) }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="full_description">E-commerce Full Description</label>
                                        <textarea class="form-control" id="full_description" name="full_description" rows="5"
                                            placeholder="Enter full description for e-commerce">{{ old('full_description', $product->full_description) }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="technical_specification">E-commerce Technical
                                            Specification</label>
                                        <textarea class="form-control" id="technical_specification" name="technical_specification" rows="5"
                                            placeholder="Enter technical specifications for e-commerce">{{ old('technical_specification', $product->technical_specification) }}</textarea>
                                    </div>
                                    <div class="row justify-content-end align-items-end mt-3">
                                        <div class="col-11">
                                            <div class="mb-3">
                                                <label for="installation_option" class="form-label">
                                                    With Installation Options
                                                </label>
                                                <input type="text" class="form-control" id="installation_option"
                                                    placeholder="Enter installation option (e.g., Basic Installation, Premium Setup)">
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-primary w-100 add-installation">
                                                    Add
                                                </button>
                                            </div>
                                        </div>

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

                                        {{-- Hidden field to hold existing options as JSON/array --}}
                                        <input type="hidden" id="installation_options_initial"
                                            value='@json(old('installation_options', $product->with_installation ?? []))'>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="brand_warranty">Brand Warranty</label>
                                        <input type="text" class="form-control" id="brand_warranty"
                                            name="brand_warranty"
                                            value="{{ old('brand_warranty', $product->brand_warranty) }}"
                                            placeholder="Enter Brand Warranty details">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="company_warranty">Company Warranty</label>
                                        <input type="text" class="form-control" id="company_warranty"
                                            name="company_warranty"
                                            value="{{ old('company_warranty', $product->company_warranty) }}"
                                            placeholder="Enter Company Warranty details">
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
                                            <input name="cost_price" id="cost_price" type="text" class="form-control"
                                                value="{{ old('cost_price', $product->warehouseProduct->cost_price) }}"
                                                placeholder="Select warehouse product first" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div>
                                            <label for="selling_price" class="form-label">Selling Price</label>
                                            <input name="selling_price" id="selling_price" type="text"
                                                class="form-control"
                                                value="{{ old('selling_price', $product->warehouseProduct->selling_price) }}"
                                                placeholder="Select warehouse product first" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div>
                                            <label for="discount_price" class="form-label">Discount Price</label>
                                            <input name="discount_price" id="discount_price" type="text"
                                                class="form-control"
                                                value="{{ old('discount_price', $product->warehouseProduct->discount_price) }}"
                                                placeholder="Select warehouse product first" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div>
                                            <label for="tax" class="form-label">Tax (%)</label>
                                            <input name="tax" id="tax" type="text" class="form-control"
                                                value="{{ old('tax', $product->warehouseProduct->tax) }}"
                                                placeholder="Select warehouse product first" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div>
                                            <label for="final_price" class="form-label">Final Price</label>
                                            <input name="final_price" id="final_price" type="text"
                                                class="form-control"
                                                value="{{ old('final_price', $product->warehouseProduct->final_price) }}"
                                                placeholder="Select warehouse product first" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Inventory & Order Management -->
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Inventory & Order Management</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="warehouse_stock">Warehouse Stock</label>
                                        <input type="number" class="form-control" id="warehouse_stock"
                                            name="warehouse_stock"
                                            value="{{ old('warehouse_stock', $product->warehouseProduct->stock_quantity) }}"
                                            placeholder="Enter warehouse stock" readonly>
                                    </div>
                                    {{-- Stock Status --}}
                                    <div class="col-md-6">
                                        @php
                                            $stockStatus = $product->warehouseProduct->stock_status;
                                            if ($stockStatus == '0') {
                                                $stockStatus = 'In Stock';
                                            } elseif ($stockStatus == '1') {
                                                $stockStatus = 'Out of Stock';
                                            } elseif ($stockStatus == '2') {
                                                $stockStatus = 'Low Stock';
                                            } elseif ($stockStatus == '3') {
                                                $stockStatus = 'Scrap';
                                            }
                                        @endphp
                                        <label class="form-label" for="warehouse_stock_status">Warehouse Stock
                                            Status</label>
                                        <input type="text" class="form-control" id="warehouse_stock_status"
                                            name="warehouse_stock_status"
                                            value="{{ old('warehouse_stock_status', $stockStatus) }}"
                                            placeholder="Enter warehouse stock status" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="min_order_qty">Minimum Order Quantity</label>
                                        <input type="number" class="form-control" id="min_order_qty"
                                            name="min_order_qty"
                                            value="{{ old('min_order_qty', $product->min_order_qty) }}"
                                            placeholder="Enter minimum order quantity" min="1">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="max_order_qty">Maximum Order Quantity</label>
                                        <input type="number" class="form-control" id="max_order_qty"
                                            name="max_order_qty"
                                            value="{{ old('max_order_qty', $product->max_order_qty) }}"
                                            placeholder="Enter maximum order quantity" min="1">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Information -->
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">SEO Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label" for="meta_title">Meta Title</label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                                            value="{{ old('meta_title', $product->meta_title) }}"
                                            placeholder="Enter meta title for SEO">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="meta_description">Meta Description</label>
                                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3"
                                            placeholder="Enter meta description for SEO">{{ old('meta_description', $product->meta_description) }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="meta_keywords">Meta Keywords</label>
                                        <input type="text" class="form-control" id="meta_keywords"
                                            name="meta_keywords"
                                            value="{{ old('meta_keywords', $product->meta_keywords) }}"
                                            placeholder="Enter meta keywords separated by commas">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="meta_product_url_slug">URL Slug</label>
                                        <input type="text" class="form-control" id="meta_product_url_slug"
                                            name="meta_product_url_slug"
                                            value="{{ old('meta_product_url_slug', $product->meta_product_url_slug) }}"
                                            placeholder="Enter URL slug (auto-generated if empty)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <!-- Product Images -->
                        {{-- <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Product Images</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="product_images">Product Images</label>
                                    <input type="file" class="form-control" id="product_images"
                                        name="product_images[]" multiple accept="image/*">
                                    <small class="text-muted">Upload multiple images. Supported formats: JPG, PNG,
                                        GIF</small>
                                </div>
                                @if ($product->product_images && is_array($product->product_images))
                                    <div class="current-images">
                                        <label class="form-label">Current Images:</label>
                                        <div class="row">
                                            @foreach ($product->product_images as $index => $image)
                                                <div class="col-6 mb-2">
                                                    <div class="position-relative">
                                                        <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail"
                                                            style="width: 100%; height: 80px; object-fit: cover;">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                                            onclick="removeImage({{ $index }})"
                                                            style="padding: 2px 6px; font-size: 10px;">
                                                            <i class="mdi mdi-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div> --}}


                        <!-- Product Images -->
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Product Images</h5>
                            </div>
                            <div class="card-body">
                                @if ($product->warehouseProduct->main_product_image)
                                    <div class="mb-3">
                                        <label class="fw-semibold">Main Product Image:</label>
                                        <div class="mt-2">
                                            <img src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                alt="Main Product Image" class="img-fluid rounded"
                                                style="max-height: 200px;">
                                        </div>
                                    </div>
                                @endif

                                @php
                                    // Handle both JSON and comma-separated string
                                    $images = [];
                                    if ($product->warehouseProduct->additional_product_images) {
                                        if (is_array($product->warehouseProduct->additional_product_images)) {
                                            $images = $product->warehouseProduct->additional_product_images;
                                        } else {
                                            // Try JSON decode
                                            $decoded = json_decode(
                                                $product->warehouseProduct->additional_product_images,
                                                true,
                                            );
                                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                                $images = $decoded;
                                            } else {
                                                // Fallback: comma-separated string
                                                $images = explode(
                                                    ',',
                                                    $product->warehouseProduct->additional_product_images,
                                                );
                                            }
                                        }
                                    }
                                @endphp

                                @if (!empty($images))
                                    <div class="mb-3">
                                        <label class="fw-semibold">Additional Images:</label>
                                        <div class="row mt-2">
                                            @foreach ($images as $image)
                                                <div class="col-6 mb-2">
                                                    <img src="{{ asset(trim($image)) }}" alt="Additional Image"
                                                        class="img-fluid rounded" style="max-height: 100px;">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif


                                @if ($product->warehouseProduct->datasheet_manual)
                                    <div class="mb-3">
                                        <label class="fw-semibold">Datasheet/Manual:</label>
                                        <div class="mt-2">
                                            <a href="{{ asset($product->warehouseProduct->datasheet_manual) }}"
                                                target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="mdi mdi-file-pdf-outline"></i> Download PDF
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Shipping Details -->
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Shipping Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label" for="shipping_charges">Shipping Charges</label>
                                        <input type="number" step="0.01" class="form-control" id="shipping_charges"
                                            name="shipping_charges"
                                            value="{{ old('shipping_charges', $product->shipping_charges) }}"
                                            placeholder="Enter shipping charges">
                                    </div>
                                    <div class="col-md-12">
                                        @include('components.form.select', [
                                            'label' => 'Shipping Class',
                                            'name' => 'shipping_class',
                                            'value' => old('shipping_class', $product->shipping_class),
                                            'options' => [
                                                '' => '--Select--',
                                                '0' => 'Light',
                                                '1' => 'Medium',
                                                '2' => 'Heavy',
                                                '3' => 'Fragile',
                                            ],
                                        ])
                                    </div>
                                    {{-- Featured Product --}}
                                    <div class="col-md-12">
                                        @include('components.form.select', [
                                            'label' => 'Featured Product',
                                            'name' => 'is_featured',
                                            'value' => old('is_featured', $product->is_featured),
                                            'options' => [
                                                '0' => 'No',
                                                '1' => 'Yes',
                                            ],
                                        ])
                                    </div>
                                    <div class="col-md-12">
                                        @include('components.form.select', [
                                            'label' => 'Best Seller',
                                            'name' => 'is_best_seller',
                                            'value' => old('is_best_seller', $product->is_best_seller),
                                            'options' => [
                                                '0' => 'No',
                                                '1' => 'Yes',
                                            ],
                                        ])
                                    </div>
                                    <div class="col-md-12">
                                        @include('components.form.select', [
                                            'label' => 'Suggested Product',
                                            'name' => 'is_suggested',
                                            'value' => old('is_suggested', $product->is_suggested),
                                            'options' => [
                                                '0' => 'No',
                                                '1' => 'Yes',
                                            ],
                                        ])
                                    </div>
                                    <div class="col-md-12">
                                        @include('components.form.select', [
                                            'label' => 'Today\'s Deal',
                                            'name' => 'is_todays_deal',
                                            'value' => old('is_todays_deal', $product->is_todays_deal),
                                            'options' => [
                                                '0' => 'No',
                                                '1' => 'Yes',
                                            ],
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- E-commerce Status & Flags -->
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">E-commerce Status & Flags</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    @include('components.form.select', [
                                        'label' => 'E-commerce Status',
                                        'name' => 'status',
                                        'value' => old('ecommerce_status', $product->status),
                                        'options' => [
                                            '' => '--Select--',
                                            'inactive' => 'Inactive',
                                            'active' => 'Active',
                                            'draft' => 'Draft',
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
                                    <div id="product_tags_list" class="border rounded p-2" style="min-height: 40px;">
                                        {{-- JS will append checkboxes here --}}
                                    </div>

                                    {{-- Hidden input to store tags as JSON (same format as create) --}}
                                    <input type="hidden" name="product_tags" id="product_tags_json"
                                        value='@json(old('product_tags', $product->product_tags ?? []))'>
                                </div>


                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="card">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="mdi mdi-content-save me-1"></i>
                                        Update Product
                                    </button>
                                    <a href="{{ route('ec.product.view', $product->id) }}" class="btn btn-secondary">
                                        <i class="mdi mdi-eye me-1"></i>
                                        View Product
                                    </a>
                                    <a href="{{ route('ec.product.index') }}" class="btn btn-outline-secondary">
                                        <i class="mdi mdi-arrow-left me-1"></i>
                                        Back to List
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div> <!-- content -->

@endsection

@section('scripts')
    <script>
        // Handle product tags input
        // document.getElementById('product_tags').addEventListener('input', function(e) {
        //     // Auto-format tags as user types
        //     let value = e.target.value;
        //     // Remove extra spaces and ensure proper comma separation
        //     value = value.replace(/\s*,\s*/g, ', ').replace(/,+/g, ',');
        //     if (value !== e.target.value) {
        //         e.target.value = value;
        //     }
        // });

        // Handle installation options
        document.querySelectorAll('input[name="installation_options[]"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // You can add any additional logic here if needed
                console.log('Installation option changed:', this.value, this.checked);
            });
        });

        // Handle image removal
        function removeImage(index) {
            if (confirm('Are you sure you want to remove this image?')) {
                // Create a hidden input to mark this image for removal
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'remove_images[]';
                hiddenInput.value = index;
                document.getElementById('editProductForm').appendChild(hiddenInput);

                // Hide the image container
                event.target.closest('.col-6').style.display = 'none';
            }
        }

        // Form validation (basic UI checks only)
        // document.getElementById('editProductForm').addEventListener('submit', function(e) {
        //     // Only ensure the status select has a value; server-side validation handles the rest
        //     const statusField = document.getElementById('status');
        //     if (statusField && !statusField.value) {
        //         e.preventDefault();
        //         statusField.classList.add('is-invalid');
        //         alert('Please select a status.');
        //         return false;
        //     }

        //     // Show loading state
        //     const submitBtn = this.querySelector('button[type="submit"]');
        //     const originalText = submitBtn.innerHTML;
        //     submitBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i> Updating...';
        //     submitBtn.disabled = true;

        //     // Re-enable button after 10 seconds as fallback
        //     setTimeout(function() {
        //         submitBtn.innerHTML = originalText;
        //         submitBtn.disabled = false;
        //     }, 10000);
        // });

        // Auto-generate URL slug from meta title
        document.getElementById('meta_title').addEventListener('input', function(e) {
            const slugField = document.getElementById('meta_product_url_slug');
            if (!slugField.value || slugField.dataset.autoGenerated === 'true') {
                const slug = e.target.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim('-');
                slugField.value = slug;
                slugField.dataset.autoGenerated = 'true';
            }
        });

        // AJAX SKU Validation for E-commerce Product Edit
        let skuTimeout = null;
        $('#sku').on('input', function() {
            const sku = $(this).val().trim();
            const $input = $(this);
            const $feedback = $('#sku-ajax-feedback');
            const productId = '{{ $product->id }}'; // Current product ID

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
                            sku: sku,
                            product_id: productId // Exclude current product from check
                        },
                        success: function(response) {
                            if (response.valid) {
                                $input.removeClass('is-invalid').addClass('is-valid');
                                $input.after(
                                    '<div id="sku-ajax-feedback" class="valid-feedback">' +
                                    response.message + '</div>');
                            } else {
                                $input.removeClass('is-valid').addClass('is-invalid');
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

        // Mark slug as manually edited if user types in it
        document.getElementById('meta_product_url_slug').addEventListener('input', function(e) {
            if (e.target.value) {
                e.target.dataset.autoGenerated = 'false';
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('product_tags_input');
            const addBtn = document.getElementById('add_tag_btn');
            const listDiv = document.getElementById('product_tags_list');
            const jsonField = document.getElementById('product_tags_json');

            // Agar elements nahi mile (kisi aur page pe), to kuch mat karo
            if (!input || !addBtn || !listDiv || !jsonField) {
                return;
            }

            let tags = [];

            // 1) Existing tags load karo (old() ya product->product_tags se)
            try {
                const existing = jsonField.value ? JSON.parse(jsonField.value) : [];
                if (Array.isArray(existing)) {
                    tags = existing;
                }
            } catch (e) {
                tags = [];
            }

            // 2) Tags render function
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

                // Sync to hidden JSON for backend
                jsonField.value = JSON.stringify(tags);
            }

            // 3) Input se naya tag add karna
            function addTagFromInput() {
                const value = input.value.trim();
                if (!value) return;

                // Duplicate avoid karo (case-insensitive)
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

            // 4) Checkbox uncheck → tag remove
            listDiv.addEventListener('change', function(e) {
                if (!e.target.classList.contains('product-tag-checkbox')) return;

                const index = parseInt(e.target.getAttribute('data-index'), 10);
                if (!isNaN(index) && tags[index] !== undefined) {
                    if (!e.target.checked) {
                        tags.splice(index, 1);
                        renderTags();
                    }
                }
            });

            // Initial render
            renderTags();
        });
    </script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const input        = document.getElementById('installation_option');
    const addBtn       = document.querySelector('.add-installation');
    const table        = document.getElementById('installationTable');
    const tbody        = document.getElementById('installation_tbody');
    const initialField = document.getElementById('installation_options_initial');

    if (!input || !addBtn || !table || !tbody || !initialField) {
        return;
    }

    let installationOptions = [];

    // 1) Load existing options (old() / product->with_installation)
    try {
        const existing = initialField.value ? JSON.parse(initialField.value) : [];
        if (Array.isArray(existing)) {
            installationOptions = existing;
        }
    } catch (e) {
        installationOptions = [];
    }

    function renderInstallationTable() {
        tbody.innerHTML = '';

        // Purane hidden inputs remove karo
        document
            .querySelectorAll('input[name="installation_options[]"]')
            .forEach(el => el.remove());

        if (!installationOptions.length) {
            table.style.display = 'none';
            return;
        }

        table.style.display = '';

        installationOptions.forEach(function (option, index) {
            const tr = document.createElement('tr');
            tr.className = 'align-middle';

            tr.innerHTML = `
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
            `;

            tbody.appendChild(tr);

            // Hidden input as array for backend
            const hidden = document.createElement('input');
            hidden.type  = 'hidden';
            hidden.name  = 'installation_options[]';
            hidden.value = option;
            tbody.appendChild(hidden);
        });
    }

    function addInstallationFromInput() {
        const value = input.value.trim();
        if (!value) return;

        // Optional: avoid duplicate options (case-insensitive)
        const exists = installationOptions
            .some(opt => opt.toLowerCase() === value.toLowerCase());
        if (!exists) {
            installationOptions.push(value);
            renderInstallationTable();
        }

        input.value = '';
        input.focus();
    }

    // Add button
    addBtn.addEventListener('click', addInstallationFromInput);

    // Enter key support
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addInstallationFromInput();
        }
    });

    // Delete clicked row
    tbody.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-installation');
        if (!btn) return;

        const index = parseInt(btn.getAttribute('data-index'), 10);
        if (!isNaN(index) && installationOptions[index] !== undefined) {
            installationOptions.splice(index, 1);
            renderInstallationTable();
        }
    });

    // Initial render from existing data
    renderInstallationTable();
});
</script>

@endsection
