@extends('e-commerce/layouts/master')

@section('content')

    <div class="content">
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">E-commerce Product Details & Serial Numbers</h4>
                    <p class="text-muted">Showing {{ $product->warehouseProduct->stock_quantity ?? 0 }} items based on stock
                        quantity</p>
                </div>
                <div>
                    <a href="{{ route('ec.product.edit', $product->id) }}" class="btn btn-primary">Edit Product</a>
                    <a href="{{ route('ec.product.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Vendor Information -->
                    {{-- <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Vendor Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">PO Number:</label>
                                        <p class="text-muted">{{ $product->warehouseProduct->po_number ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Vendor Name:</label>
                                        <p class="text-muted">{{ $product->warehouseProduct->vendor_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Invoice Number:</label>
                                        <p class="text-muted">{{ $product->warehouseProduct->invoice_number ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Purchase Date:</label>
                                        <p class="text-muted">
                                            {{ $product->warehouseProduct->purchase_date ? $product->warehouseProduct->purchase_date->format('d M Y') : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Bill Due Date:</label>
                                        <p class="text-muted">
                                            {{ $product->warehouseProduct->bill_due_date ? $product->warehouseProduct->bill_due_date->format('d M Y') : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Bill Amount:</label>
                                        <p class="text-muted">
                                            {{ $product->warehouseProduct->bill_amount ? '₹' . number_format($product->warehouseProduct->bill_amount, 2) : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Basic Product Information -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Basic Product Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Product Name:</label>
                                        <p class="text-muted">{{ $product->warehouseProduct->product_name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">SKU:</label>
                                        <p class="text-muted">{{ $product->warehouseProduct->sku }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">HSN Code:</label>
                                        <p class="text-muted">{{ $product->warehouseProduct->hsn_code ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Brand:</label>
                                        <p class="text-muted">{{ $product->warehouseProduct->brand->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Model No:</label>
                                        <p class="text-muted">{{ $product->warehouseProduct->model_no ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Parent Category:</label>
                                        <p class="text-muted">
                                            {{ $product->warehouseProduct->parentCategorie->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Sub Category:</label>
                                        <p class="text-muted">{{ $product->warehouseProduct->subCategorie->name ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Brand Warranty:</label>
                                        <p class="text-muted">{{ $product->warehouseProduct->brand_warranty ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Company Warranty:</label>
                                        <p class="text-muted">{{ $product->company_warranty ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Warehouse:</label>
                                        <p class="text-muted">{{ $product->warehouseProduct->warehouse->name ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Product Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="fw-semibold">Short Description:</label>
                                <div class="text-muted">
                                    {!! $product->short_description ?? 'N/A' !!}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="fw-semibold">Full Description:</label>
                                <div class="text-muted">
                                    {!! $product->full_description ?? 'N/A' !!}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="fw-semibold">Technical Specification:</label>
                                <div class="text-muted">
                                    {!! $product->technical_specification ?? 'N/A' !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Information -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Pricing Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Cost Price:</label>
                                        <p class="text-muted">
                                            {{ $product->warehouseProduct->cost_price ? '₹' . number_format($product->warehouseProduct->cost_price, 2) : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Selling Price:</label>
                                        <p class="text-muted">
                                            {{ $product->warehouseProduct->selling_price ? '₹' . number_format($product->warehouseProduct->selling_price, 2) : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Discount Price:</label>
                                        <p class="text-muted">
                                            {{ $product->warehouseProduct->discount_price ? '₹' . number_format($product->warehouseProduct->discount_price, 2) : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Tax Rate:</label>
                                        <p class="text-muted">
                                            {{ $product->warehouseProduct->tax ? $product->warehouseProduct->tax . '%' : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Final Price:</label>
                                        <p class="text-muted">
                                            {{ $product->warehouseProduct->final_price ? '₹' . number_format($product->warehouseProduct->final_price, 2) : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Information -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Inventory Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Stock Quantity:</label>
                                        <p class="text-muted">{{ $product->warehouseProduct->stock_quantity ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Stock Status:</label>
                                        @php
                                            $stockStatus = $product->warehouseProduct->stock_status;
                                            $badgeClass = '';
                                            if ($stockStatus == '0') {
                                                $stockStatus = 'In Stock';
                                                $badgeClass = 'bg-success';
                                            } elseif ($stockStatus == '1') {
                                                $stockStatus = 'Out of Stock';
                                                $badgeClass = 'bg-secondary';
                                            } elseif ($stockStatus == '2') {
                                                $stockStatus = 'Low Stock';
                                                $badgeClass = 'bg-warning';
                                            } else {
                                                $stockStatus = 'Scrap';
                                                $badgeClass = 'bg-danger';
                                            }
                                        @endphp
                                        <p class="text-muted">
                                            <span
                                                class="badge {{ $badgeClass }}">{{ $stockStatus ?? 'Out of Stock' }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Min Order Quantity:</label>
                                        <p class="text-muted">{{ $product->min_order_qty ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Max Order Quantity:</label>
                                        <p class="text-muted">{{ $product->max_order_qty ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Serial Numbers -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Product Serial Numbers</h5>
                            <p class="text-muted mb-0">Each product item with unique serial number</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Auto Generated Serial</th>
                                            <th>Manual Serial Number</th>
                                            <th>Barcode</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($product->warehouseProduct->productSerials as $index => $serial)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-primary">{{ $index + 1 }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($product->warehouseProduct->main_product_image)
                                                            <img src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                                alt="{{ $product->warehouseProduct->product_name }}"
                                                                width="40" height="40" class="img-fluid rounded me-2">
                                                        @else
                                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                                <i class="mdi mdi-package-variant text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-semibold">{{ $product->warehouseProduct->product_name }}</div>
                                                            <div class="text-muted small">SKU: {{ $product->warehouseProduct->sku }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $serial->auto_generated_serial }}</td>
                                                <td>{{ $serial->manual_serial ?? 'N/A' }}</td>
                                                <td>    
                                                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($serial->auto_generated_serial, 'C128') }}" alt="Barcode" width="100">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-warning edit-serial-btn"
                                                        data-serial-id="{{ $serial->id }}">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="mdi mdi-information-outline fs-48 mb-2"></i>
                                                        <p>No serial numbers found. This might be because the stock quantity
                                                            is 0.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Rack Details -->
                    {{-- <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <h5 class="card-title mb-0">Rack Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Warehouse:</label>
                                    <p class="text-muted">{{ $product->warehouseProduct->warehouse->warehouse_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Warehouse Rack:</label>
                                    <p class="text-muted">{{ $product->warehouseProduct->warehouseRack->rack_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Rack Zone Area:</label>
                                    <p class="text-muted">{{ $product->warehouseProduct->rack_zone_area ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Rack No:</label>
                                    <p class="text-muted">{{ $product->warehouseProduct->rack_no ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Level No:</label>
                                    <p class="text-muted">{{ $product->warehouseProduct->level_no ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Position No:</label>
                                    <p class="text-muted">{{ $product->warehouseProduct->position_no ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Expiry Date:</label>
                                    <p class="text-muted">{{ $product->warehouseProduct->expiry_date ? $product->warehouseProduct->expiry_date->format('d M Y') : 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Rack Status:</label>
                                    <p class="text-muted">
                                        <span class="badge bg-info">{{ $product->warehouseProduct->rack_status ?? 'N/A' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                </div>

                <div class="col-lg-4">
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
                                        $decoded = json_decode($product->warehouseProduct->additional_product_images, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            $images = $decoded;
                                        } else {
                                            // Fallback: comma-separated string
                                            $images = explode(',', $product->warehouseProduct->additional_product_images);
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

                    <!-- SEO Information -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">SEO Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="fw-semibold">Meta Title:</label>
                                <p class="text-muted">{{ $product->meta_title ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-semibold">Meta Description:</label>
                                <p class="text-muted">{{ $product->meta_description ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-semibold">Meta Keywords:</label>
                                <p class="text-muted">{{ $product->meta_keywords ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-semibold">URL Slug:</label>
                                <p class="text-muted">{{ $product->meta_product_url_slug ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Details -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Shipping Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="fw-semibold">Shipping Charges:</label>
                                <p class="text-muted">
                                    {{ $product->shipping_charges ? '₹' . number_format($product->shipping_charges, 2) : 'N/A' }}
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-semibold">Shipping Class:</label>
                                <p class="text-muted">
                                    @php
                                        $shippingClass = [
                                            0 => 'Light',
                                            1 => 'Medium',
                                            2 => 'Heavy',
                                            3 => 'Fragile',
                                        ];
                                    @endphp
                                    <span
                                        class="badge bg-info">{{ $shippingClass[$product->shipping_class] ?? 'N/A' }}</span>
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- Product Variations -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Product Variations</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- @php $variations = json_decode($product->warehouseProduct->variation_options, true); 
                                    // print_r($variations);
                                @endphp --}}
                                @foreach ($product->warehouseProduct->variation_options as $key=> $attribute)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="fw-semibold">{{ $key }}:</label>
                                            <p class="text-muted">
                                                @foreach ($attribute as $value)
                                                    {{ $value }},
                                                @endforeach
                                            </p>
                                        </div>  
                                    </div>
                                @endforeach
                            </div>
                        </div>  

                    </div>

                    <!-- E-commerce Flags & Settings -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">E-commerce Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="fw-semibold">Installation Options:</label>
                                <p class="text-muted">
                                    @if ($product->with_installation && is_array($product->with_installation))

                                        @foreach ($product->with_installation as $option)
                                            <span class="badge bg-secondary me-1">{{ $option }}</span>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-semibold">Product Tags:</label>
                                <p class="text-muted">
                                    @if ($product->product_tags && is_array($product->product_tags))
                                        @foreach ($product->product_tags as $tag)
                                            <span class="badge bg-secondary me-1">{{ $tag }}</span>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Featured:</label>
                                        <p class="text-muted">
                                            <span
                                                class="badge {{ $product->is_featured ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $product->is_featured ? 'Yes' : 'No' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Best Seller:</label>
                                        <p class="text-muted">
                                            <span
                                                class="badge {{ $product->is_best_seller ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $product->is_best_seller ? 'Yes' : 'No' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Suggested:</label>
                                        <p class="text-muted">
                                            <span
                                                class="badge {{ $product->is_suggested ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $product->is_suggested ? 'Yes' : 'No' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Today's Deal:</label>
                                        <p class="text-muted">
                                            <span
                                                class="badge {{ $product->is_todays_deal ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $product->is_todays_deal ? 'Yes' : 'No' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Status -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Product Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">E-commerce Status:</label>
                                        <p class="text-muted">
                                            @php
                                            $ecommerceStatus = [
                                                0 => 'Inactive',
                                                1 => 'Active',
                                                2 => 'Draft',
                                            ];
                                            @endphp
                                            <span
                                                class="badge {{ $product->status == '1' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $ecommerceStatus[$product->status] ?? 'N/A' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Total Sold:</label>
                                        <p class="text-muted">{{ $product->total_sold ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Created Date:</label>
                                        <p class="text-muted">{{ $product->created_at->format('d M Y, h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Last Updated:</label>
                                        <p class="text-muted">{{ $product->updated_at->format('d M Y, h:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div> <!-- content -->

    <!-- Scrap Serial Modal -->
    <div class="modal fade" id="scrapSerialModal" tabindex="-1" aria-labelledby="scrapSerialModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrapSerialModalLabel">Scrap Serial Number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="scrapSerialForm">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="mdi mdi-alert-circle-outline me-2"></i>
                            <strong>Warning:</strong> This action will permanently scrap the selected serial number.
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="scrapSerialNumber" readonly>
                            <input type="hidden" id="scrapSerialId" name="serial_ids">
                        </div>
                        <div class="mb-3">
                            <label for="scrapReason" class="form-label">Reason <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="scrapReason" name="reason" rows="3"
                                placeholder="Enter the reason for scrapping this serial number" required></textarea>
                            <div class="invalid-feedback" id="reason_error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" id="scrapSerialSubmitBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                            <i class="mdi mdi-delete me-1"></i>
                            Scrap Serial
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function saveSerial(serialId) {
            const manualSerialInput = document.getElementById(`manual-serial-${serialId}`);
            const saveBtn = document.querySelector(`[data-serial-id="${serialId}"]`);
            const currentSerialSpan = document.getElementById(`current-serial-${serialId}`);

            // Show loading state
            const originalBtnText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Saving...';
            saveBtn.disabled = true;

            // Prepare data
            const formData = new FormData();
            formData.append('serial_id', serialId);
            formData.append('manual_serial', manualSerialInput.value.trim());
            formData.append('_token', '{{ csrf_token() }}');

            // Make AJAX request
            fetch('{{ route('product-list.save-serial') }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update current serial display
                        currentSerialSpan.textContent = data.data.final_serial;

                        // Update the status indicator
                        const row = document.getElementById(`serial-row-${serialId}`);
                        const statusElement = row.querySelector('small');

                        if (data.data.is_manual) {
                            statusElement.innerHTML = '<i class="mdi mdi-check-circle"></i> Using manual serial';
                            statusElement.className = 'text-success';
                        } else {
                            statusElement.innerHTML = '<i class="mdi mdi-auto-fix"></i> Using auto-generated serial';
                            statusElement.className = 'text-muted';
                        }

                        // Show success message
                        showAlert('success', data.message);
                    } else {
                        // Show error message
                        showAlert('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'An error occurred while saving the serial number');
                })
                .finally(() => {
                    // Reset button state
                    saveBtn.innerHTML = originalBtnText;
                    saveBtn.disabled = false;
                });
        }

        function showAlert(type, message) {
            // Create alert element
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
            alertDiv.innerHTML = `
        <i class="mdi mdi-${type === 'success' ? 'check-circle' : 'alert-circle'}-outline me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

            // Insert at the top of the content
            const content = document.querySelector('.content .container-fluid');
            content.insertBefore(alertDiv, content.firstChild);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        // Scrap serial function
        function scrapSerial(serialNumber, serialId) {
            // Set modal data
            document.getElementById('scrapSerialNumber').value = serialNumber;
            document.getElementById('scrapSerialId').value = serialNumber;
            document.getElementById('scrapReason').value = '';

            // Clear previous errors
            document.getElementById('reason_error').textContent = '';
            document.getElementById('scrapReason').classList.remove('is-invalid');

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('scrapSerialModal'));
            modal.show();
        }

        // Add Enter key support for serial inputs
        document.addEventListener('DOMContentLoaded', function() {
            const serialInputs = document.querySelectorAll('.serial-input');

            serialInputs.forEach(input => {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const serialId = this.id.replace('manual-serial-', '');
                        saveSerial(serialId);
                    }
                });
            });

            // Handle scrap serial form submission
            document.getElementById('scrapSerialForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const submitBtn = document.getElementById('scrapSerialSubmitBtn');
                const spinner = submitBtn.querySelector('.spinner-border');
                const serialNumber = document.getElementById('scrapSerialNumber').value;

                // Clear previous errors
                document.getElementById('reason_error').textContent = '';
                document.getElementById('scrapReason').classList.remove('is-invalid');

                // Show loading state
                submitBtn.disabled = true;
                spinner.classList.remove('d-none');

                // Prepare form data
                const formData = new FormData(form);

                fetch('{{ route('product-list.scrap-product') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Hide loading state
                        submitBtn.disabled = false;
                        spinner.classList.add('d-none');

                        if (data.success) {
                            // Show success message
                            showAlert('success', data.message);

                            // Close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'scrapSerialModal'));
                            modal.hide();

                            // Remove the scrapped serial row from the table
                            const serialRow = document.querySelector(`tr[id*="${serialNumber}"]`);
                            if (serialRow) {
                                serialRow.style.transition = 'opacity 0.3s';
                                serialRow.style.opacity = '0';
                                setTimeout(() => {
                                    serialRow.remove();

                                    // Check if no more serial numbers are left
                                    const remainingRows = document.querySelectorAll(
                                        '#serial-row-');
                                    if (remainingRows.length === 0) {
                                        // Reload page if no serial numbers left
                                        setTimeout(() => {
                                            location.reload();
                                        }, 1000);
                                    }
                                }, 300);
                            }
                        } else {
                            showAlert('error', data.message);
                        }
                    })
                    .catch(error => {
                        // Hide loading state
                        submitBtn.disabled = false;
                        spinner.classList.add('d-none');

                        console.error('Error:', error);
                        showAlert('error', 'An error occurred while scrapping the serial number');
                    });
            });
        });
    </script>
@endsection
