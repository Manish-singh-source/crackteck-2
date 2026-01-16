@extends('warehouse/layouts/master')

@section('content')

    <div class="content">
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Product Details & Serial Numbers</h4>
                    <p class="text-muted">Showing {{ $product->stock_quantity ?? 0 }} items based on stock quantity</p>
                </div>
                <div>
                    <a href="{{ route('product-list.edit', $product->id) }}" class="btn btn-primary">Edit Product</a>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Vendor Information -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Vendor Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Vendor Name:</label>
                                        <p class="text-muted">
                                            {{ $product->vendor->first_name . ' ' . $product->vendor->last_name ?? 'N/A' }}
                                            <span>{{ '{ ' . $product->vendor->vendor_code . ' }' ?? 'N/A' }}</span>
                                        </p>
                                        {{-- Vendor_code  --}}
                                        <p class="text-muted"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">PO Number:</label>
                                        <p class="text-muted">{{ $product->vendorPurchaseOrder->po_number ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Invoice Number:</label>
                                        <p class="text-muted">{{ $product->vendorPurchaseOrder->invoice_number ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Purchase Date:</label>
                                        <p class="text-muted">
                                            {{ $product->vendorPurchaseOrder->purchase_date ? $product->vendorPurchaseOrder->purchase_date : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Bill Due Date:</label>
                                        <p class="text-muted">
                                            {{ $product->vendorPurchaseOrder->po_amount_due_date ? $product->vendorPurchaseOrder->po_amount_due_date : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Bill Amount:</label>
                                        <p class="text-muted">
                                            {{ $product->vendorPurchaseOrder->po_amount ? '₹' . number_format($product->vendorPurchaseOrder->po_amount, 2) : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                        <p class="text-muted">{{ $product->product_name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">SKU:</label>
                                        <p class="text-muted">{{ $product->sku }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">HSN Code:</label>
                                        <p class="text-muted">{{ $product->hsn_code ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Brand:</label>
                                        <p class="text-muted">{{ $product->brand->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Model No:</label>
                                        <p class="text-muted">{{ $product->model_no ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Parent Category:</label>
                                        <p class="text-muted">{{ $product->parentCategorie->name ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Sub Category:</label>
                                        <p class="text-muted">{{ $product->subCategorie->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Brand Warranty:</label>
                                        <p class="text-muted">{{ $product->brand_warranty ?? 'N/A' }}</p>
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
                                        <p class="text-muted">{{ $product->warehouse->name ?? 'N/A' }}</p>
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
                                            <th>SR No</th>
                                            <th>Product Name</th>
                                            <th>Auto Generated Serial</th>
                                            <th>Manual Serial Number</th>
                                            <th>Barcode</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($product->productSerials as $index => $serial)
                                            <tr id="serial-row-{{ $serial->id }}">
                                                <td>
                                                    <span>{{ $index + 1 }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($product->main_product_image)
                                                            <img src="{{ asset($product->main_product_image) }}"
                                                                alt="{{ $product->product_name }}" width="100"
                                                                height="40" class="img-fluid rounded me-2">
                                                        @else
                                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-2"
                                                                style="width: 40px; height: 40px;">
                                                                <i class="mdi mdi-package-variant text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-semibold">{{ $product->product_name }}</div>
                                                            <div class="text-muted small">SKU: {{ $product->sku }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $serial->auto_generated_serial }}</td>
                                                <td>{{ $serial->manual_serial ?? 'N/A' }}</td>
                                                <td>
                                                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($serial->auto_generated_serial, 'C128') }}"
                                                        alt="Barcode" width="200">
                                                </td>
                                                <td>
                                                    {{-- Edit button --}}
                                                    <button type="button" class="btn btn-sm btn-warning edit-serial-btn"
                                                        data-serial-id="{{ $serial->id }}">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </button>
                                                    {{-- Scrap button --}}
                                                    <button type="button" class="btn btn-sm btn-danger scrap-serial-btn"
                                                        data-serial-id="{{ $serial->id }}"
                                                        data-serial-number="{{ $serial->auto_generated_serial }}">
                                                        <i class="mdi mdi-recycle"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No serial numbers found.</td>
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
                                        <p class="text-muted">{{ $product->warehouse->warehouse_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Warehouse Rack:</label>
                                        <p class="text-muted">{{ $product->warehouseRack->rack_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Rack Zone Area:</label>
                                        <p class="text-muted">{{ $product->rack_zone_area ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Rack No:</label>
                                        <p class="text-muted">{{ $product->rack_no ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Level No:</label>
                                        <p class="text-muted">{{ $product->level_no ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Position No:</label>
                                        <p class="text-muted">{{ $product->position_no ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>

                <div class="col-lg-4">

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
                                            {{ $product->cost_price ? '₹' . number_format($product->cost_price, 2) : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Selling Price:</label>
                                        <p class="text-muted">
                                            {{ $product->selling_price ? '₹' . number_format($product->selling_price, 2) : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Discount Price:</label>
                                        <p class="text-muted">
                                            {{ $product->discount_price ? '₹' . number_format($product->discount_price, 2) : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Tax Rate:</label>
                                        <p class="text-muted">{{ $product->tax ? $product->tax . '%' : 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Final Price:</label>
                                        <p class="text-muted">{{ $product->final_price ? $product->final_price : 'N/A' }}
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
                                        <p class="text-muted">{{ $product->stock_quantity ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Stock Status:</label>
                                        @php
                                            $stockStatus = $product->stock_status;
                                            $badgeClass = '';
                                            if ($stockStatus == 'in_stock') {
                                                $stockStatus = 'In Stock';
                                                $badgeClass = 'bg-success';
                                            } elseif ($stockStatus == 'out_of_stock') {
                                                $stockStatus = 'Out of Stock';
                                                $badgeClass = 'bg-secondary';
                                            } elseif ($stockStatus == 'low_stock') {
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
                                {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Minimum Stock Level:</label>
                                    <p class="text-muted">{{ $product->minimum_stock_level ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Maximum Stock Level:</label>
                                    <p class="text-muted">{{ $product->maximum_stock_level ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Reorder Level:</label>
                                    <p class="text-muted">{{ $product->reorder_level ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Reorder Quantity:</label>
                                    <p class="text-muted">{{ $product->reorder_quantity ?? 'N/A' }}</p>
                                </div>
                            </div> --}}
                            </div>
                        </div>
                    </div>

                    <!-- Product Images -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Product Images</h5>
                        </div>
                        <div class="card-body">
                            @if ($product->main_product_image)
                                <div class="mb-3">
                                    <label class="fw-semibold">Main Product Image:</label>
                                    <div class="mt-2">
                                        <img src="{{ asset($product->main_product_image) }}" alt="Main Product Image"
                                            class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            @endif

                            @php
                                // Handle both JSON and comma-separated string
                                $images = [];
                                if ($product->additional_product_images) {
                                    if (is_array($product->additional_product_images)) {
                                        $images = $product->additional_product_images;
                                    } else {
                                        // Try JSON decode
                                        $decoded = json_decode($product->additional_product_images, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            $images = $decoded;
                                        } else {
                                            // Fallback: comma-separated string
                                            $images = explode(',', $product->additional_product_images);
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


                            @if ($product->datasheet_manual)
                                <div class="mb-3">
                                    <label class="fw-semibold">Datasheet/Manual:</label>
                                    <div class="mt-2">
                                        <a href="{{ asset($product->datasheet_manual) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="mdi mdi-file-pdf-outline"></i> Download PDF
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Product Variations -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Product Variations</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- @php 
                                    $variations = json_decode($product->variation_options, true); 
                                @endphp --}}
                                @foreach ($product->variation_options as $key => $attribute)
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

                    <!-- Product Status -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Product Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-semibold">Status:</label>
                                        <p class="text-muted">
                                            <span
                                                class="badge {{ $product->status == 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fw-semibold">
                                                {{ $product->status == 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </p>
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

    <!-- Edit Serial Modal -->
    <div class="modal fade" id="editSerialModal" tabindex="-1" aria-labelledby="editSerialModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSerialModalLabel">Edit Serial Number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editSerialForm">
                    @csrf
                    <input type="hidden" id="editSerialId" name="serial_id">
                    <div class="modal-body" style="background-color: #fff; padding: 20px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Auto Generated Serial</label>
                                    <input type="text" class="form-control" id="editAutoSerial" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Manual Serial</label>
                                    <input type="text" class="form-control" id="editManualSerial"
                                        name="manual_serial">
                                    <div class="invalid-feedback" id="manual_serial_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Cost Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="editCostPrice"
                                        name="cost_price" required>
                                    <div class="invalid-feedback" id="cost_price_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Selling Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="editSellingPrice"
                                        name="selling_price" required>
                                    <div class="invalid-feedback" id="selling_price_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Discount Price</label>
                                    <input type="number" step="0.01" class="form-control" id="editDiscountPrice"
                                        name="discount_price">
                                    <div class="invalid-feedback" id="discount_price_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tax (%)</label>
                                    <input type="number" step="0.01" class="form-control" id="editTax"
                                        name="tax">
                                    <div class="invalid-feedback" id="tax_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Final Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="editFinalPrice"
                                        name="final_price" required>
                                    <div class="invalid-feedback" id="final_price_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="editStatus" name="status" required>
                                        <option value="inactive">Inactive</option>
                                        <option value="active">Active</option>
                                        <option value="sold">Sold</option>
                                        <option value="scrap">Scrap</option>
                                    </select>
                                    <div class="invalid-feedback" id="status_error"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Main Product Image</label>
                                    <input type="file" class="form-control" id="editMainImage"
                                        name="main_product_image" accept="image/*">
                                    <div class="mt-2" id="currentMainImage"></div>
                                    <div class="invalid-feedback" id="main_product_image_error"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Additional Product Images</label>
                                    <input type="file" class="form-control" id="editAdditionalImages"
                                        name="additional_product_images[]" accept="image/*" multiple>
                                    <div class="mt-2" id="currentAdditionalImages"></div>
                                    <div class="invalid-feedback" id="additional_product_images_error"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Variations</label>
                                    <textarea class="form-control" id="editVariations" name="variations" rows="3"
                                        placeholder='{"color": "Red", "size": "Large"}'></textarea>
                                    <small class="text-muted">Enter variations in JSON format</small>
                                    <div class="invalid-feedback" id="variations_error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="editSerialSubmitBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                            <i class="mdi mdi-content-save me-1"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scrap Serial Modal -->
    <div class="modal fade" id="scrapSerialModal" tabindex="-1" aria-labelledby="scrapSerialModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrapSerialModalLabel">Scrap Serial Number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="Scrap Serial Number">
                    @csrf
                    <div class="modal-body" style="background-color: #fff; padding: 20px;">
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

        // Edit serial function
        function editSerial(serialId) {
            // Clear previous errors
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            // Fetch serial data
            const url = "{{ route('product-list.get-serial-data', ':id') }}".replace(':id', serialId);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const serial = data.data;

                        // Populate form fields
                        document.getElementById('editSerialId').value = serial.id;
                        document.getElementById('editAutoSerial').value = serial.auto_generated_serial || '';
                        document.getElementById('editManualSerial').value = serial.manual_serial || '';
                        document.getElementById('editCostPrice').value = serial.cost_price || '';
                        document.getElementById('editSellingPrice').value = serial.selling_price || '';
                        document.getElementById('editDiscountPrice').value = serial.discount_price || '';
                        document.getElementById('editTax').value = serial.tax || '';
                        document.getElementById('editFinalPrice').value = serial.final_price || '';
                        document.getElementById('editStatus').value = serial.status || 'active';

                        // Handle variations (JSON)
                        if (serial.variations) {
                            document.getElementById('editVariations').value = typeof serial.variations === 'string' ?
                                serial.variations :
                                JSON.stringify(serial.variations, null, 2);
                        } else {
                            document.getElementById('editVariations').value = '';
                        }

                        // Display current main image
                        const mainImageDiv = document.getElementById('currentMainImage');
                        if (serial.main_product_image) {
                            mainImageDiv.innerHTML =
                                `<img src="{{ asset('') }}${serial.main_product_image}" alt="Main Image" class="img-thumbnail" style="max-height: 100px;">`;
                        } else {
                            mainImageDiv.innerHTML = '<small class="text-muted">No image uploaded</small>';
                        }

                        // Display current additional images
                        const additionalImagesDiv = document.getElementById('currentAdditionalImages');
                        if (serial.additional_product_images && serial.additional_product_images.length > 0) {
                            let imagesHtml = '<div class="d-flex flex-wrap gap-2">';
                            serial.additional_product_images.forEach(img => {
                                imagesHtml +=
                                    `<img src="{{ asset('') }}${img}" alt="Additional Image" class="img-thumbnail" style="max-height: 80px;">`;
                            });
                            imagesHtml += '</div>';
                            additionalImagesDiv.innerHTML = imagesHtml;
                        } else {
                            additionalImagesDiv.innerHTML = '<small class="text-muted">No additional images</small>';
                        }

                        // Show modal
                        const modal = new bootstrap.Modal(document.getElementById('editSerialModal'));
                        modal.show();
                    } else {
                        showAlert('error', data.message || 'Failed to load serial data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'An error occurred while loading serial data');
                });
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

            // Handle edit button clicks
            document.querySelectorAll('.edit-serial-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const serialId = this.getAttribute('data-serial-id');
                    editSerial(serialId);
                });
            });

            // Handle scrap button clicks
            document.querySelectorAll('.scrap-serial-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const serialId = this.getAttribute('data-serial-id');
                    const serialNumber = this.getAttribute('data-serial-number');
                    scrapSerial(serialNumber, serialId);
                });
            });

            // Handle edit serial form submission
            document.getElementById('editSerialForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const submitBtn = document.getElementById('editSerialSubmitBtn');
                const spinner = submitBtn.querySelector('.spinner-border');

                // Clear previous errors
                document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                // Show loading state
                submitBtn.disabled = true;
                spinner.classList.remove('d-none');

                // Prepare form data
                const formData = new FormData(form);

                fetch('{{ route('product-list.update-serial') }}', {
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
                                'editSerialModal'));
                            modal.hide();

                            // Reload page to show updated data
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            // Show validation errors
                            if (data.errors) {
                                Object.keys(data.errors).forEach(key => {
                                    const errorElement = document.getElementById(
                                        `${key}_error`);
                                    const inputElement = document.querySelector(
                                        `[name="${key}"]`);
                                    if (errorElement && inputElement) {
                                        errorElement.textContent = data.errors[key][0];
                                        inputElement.classList.add('is-invalid');
                                    }
                                });
                            }
                            showAlert('error', data.message || 'Validation failed');
                        }
                    })
                    .catch(error => {
                        // Hide loading state
                        submitBtn.disabled = false;
                        spinner.classList.add('d-none');

                        console.error('Error:', error);
                        showAlert('error', 'An error occurred while updating the serial number');
                    });
            });

            // Handle scrap serial form submission
            (document).ready(function() {
                // Handle scrap product form submission
                $('#scrapProductForm').on('submit', function(e) {
                    e.preventDefault();
                    const form = $(this);
                    const submitBtn = $('#scrapSubmitBtn');
                    const spinner = submitBtn.find('.spinner-border');
                    console.log(form.serialize());
                    // Clear previous errors
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').text('');

                    // Show loading state
                    submitBtn.prop('disabled', true);
                    spinner.removeClass('d-none');

                    $.ajax({
                        url: '{{ route('scrap-items.add-to-scrap') }}',
                        method: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            // Hide loading state first
                            submitBtn.prop('disabled', false);
                            spinner.addClass('d-none');

                            if (response.success) {
                                // Show success message
                                toastr.success(response.message);

                                // Reset form and close modal
                                form[0].reset();
                                $('#addScrapModal').modal('hide');

                                // Reload page to show updated data
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.responseJSON);
                            // Hide loading state first
                            submitBtn.prop('disabled', false);
                            spinner.addClass('d-none');

                            if (xhr.status === 422) {
                                // Validation errors
                                const errors = xhr.responseJSON.errors;
                                Object.keys(errors).forEach(function(key) {
                                    $('#' + key).addClass('is-invalid');
                                    $('#' + key + '_error').text(errors[key][0]);
                                });
                            } else {
                                toastr.error('An error occurred while processing your request.');
                            }
                        }
                    });
                });

                // Handle restore product
                $('.restore-btn').on('click', function() {
                    const scrapId = $(this).data('scrap-id');
                    const button = $(this);

                    if (confirm('Are you sure you want to restore this product?')) {
                        button.prop('disabled', true);

                        $.ajax({
                            url: '{{ route('product-list.restore-product', ':id') }}'.replace(':id',
                                scrapId),
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    // toastr.success(response.message);
                                    location.reload();
                                    // Remove the row from table
                                    button.closest('tr').fadeOut(function() {
                                        $(this).remove();

                                        // Check if table is empty and reload if needed
                                        if ($('tbody tr:visible').length === 0) {
                                            setTimeout(function() {
                                                location.reload();
                                            }, 1000);
                                        }
                                    });
                                } else {
                                    toastr.error(response.message);
                                    button.prop('disabled', false);
                                }
                            },
                            error: function() {
                                toastr.error('An error occurred while restoring the product.');
                                button.prop('disabled', false);
                            }
                        });
                    }
                });
            });
            
        });
    </script>
@endsection

    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
    @endsection
