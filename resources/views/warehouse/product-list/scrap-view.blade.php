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
                                    <label class="fw-semibold">PO Number:</label>
                                    <p class="text-muted">{{ $product->po_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Vendor Name:</label>
                                    <p class="text-muted">{{ $product->vendor_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Invoice Number:</label>
                                    <p class="text-muted">{{ $product->invoice_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Purchase Date:</label>
                                    <p class="text-muted">{{ $product->purchase_date ? $product->purchase_date->format('d M Y') : 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Bill Due Date:</label>
                                    <p class="text-muted">{{ $product->bill_due_date ? $product->bill_due_date->format('d M Y') : 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Bill Amount:</label>
                                    <p class="text-muted">{{ $product->bill_amount ? '₹' . number_format($product->bill_amount, 2) : 'N/A' }}</p>
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
                                    <p class="text-muted">{{ $product->brand->brand_title ?? 'N/A' }}</p>
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
                                    <label class="fw-semibold">Serial No:</label>
                                    <p class="text-muted">{{ $product->serial_no ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Parent Category:</label>
                                    <p class="text-muted">{{ $product->parentCategorie->parent_categories ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Sub Category:</label>
                                    <p class="text-muted">{{ $product->subCategorie->sub_categorie ?? 'N/A' }}</p>
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
                                    @forelse($product->productSerials as $index => $serial)
                                    <tr id="serial-row-{{ $serial->id }}">
                                        <td>
                                            <span class="badge bg-primary">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($product->main_product_image)
                                                    <img src="{{ asset($product->main_product_image) }}" alt="{{ $product->product_name }}" width="40" height="40" class="img-fluid rounded me-2">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                        <i class="mdi mdi-package-variant text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $product->product_name }}</div>
                                                    <div class="text-muted small">SKU: {{ $product->sku }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badg ">{{ $serial->auto_generated_serial }}</span>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control serial-input"
                                                       id="manual-serial-{{ $serial->id }}"
                                                       value="{{ $serial->manual_serial }}"
                                                       placeholder="Enter manual serial number">
                                            </div>
                                            @if($serial->is_manual)
                                                <small class="text-success">
                                                    <i class="mdi mdi-check-circle"></i> Using manual serial
                                                </small>
                                            @else
                                                <small class="text-muted">
                                                    Using auto-generated serial
                                                </small>
                                            @endif
                                        </td>
                                        <td><img id="barcode1" width="150px" height="50px" src="data:image/png;base64,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nmuRRRaxGTNm2EcffTQm4z/++MMuvvhiW2KJJcI9888/v5144on2yy+/9PgOErdf319//dW222670K97b87uSVnt8lMyX331la288sqZ/gsvvLC98sorcutcGttVV11lK6ywQrhnnnnmsV122cXef//9jo9+6TffQX3lL46nn366Lbvssj05vPjii+HQuny46kUAYavXfORm89tvv9lNN91ku+66q33++ecdv3/++cdOOOEEO+200+ynn34K9aq74oorbK+99rKff/451OX9yIub5T+Ib9b9g9Yp9912282OP/54+/LLL8Pts2bNsgcffNC23HJLe+mll0Jd3o9B8s3z/fTTT22zzTaziy66yL799tvQVcxh3333ta+//jrU8aNeBBC2es1HTzb33XdfWBHo6yT6AO2zzz727rvv2quvvtrxu//+++2GG26wjTbayF5//XXTh+7tt98O5ccff9xuv/32jm/8pZ+4/fpqJfnUU0918lSu8Xr00UdtypQpttNOO5n8YkzZgw8+eMw9EpdNN91UzeG67rrrTGPoHps4HHDAAUHEJeZxJRhuGPkxzLGNhLNLLrnEPvjgAzvmmGOCiGls//77r73xxhsm0dX45MdVLwL1FLZ6MapFNnoMOuigg3py0QfstttuswUXXDCI24YbbhgeldZdd91QXmihhUzC9+eff/bc113Iitvd3v37IL56hLzyyittueWWM61suuP08/s333wTVqhLL7203XrrrRbHphwUd/PNN7cXXnjB3nzzzdxw8k0zy3PO89WqUXz1GkA+ul+PwxtssIFdffXV4fFUdVz1IoCw1Ws+MrPRKuHDDz8M79HWWWcd23jjjYPf999/H1Zveoe13nrrhTr9+Pjjj+28886z33//3d566y378ccfVT3myos7xnGkYhDfEXd79tlnwyPj4YcfbquuuqqqBrq0StKYt912W1t77bV77l1qqaVsjz32sL///jusnHoaRwuD5DsnXwmrRPryyy8f885ytCtMDQkgbDWclJjS7rvvHlZgetxZc801bbHFFrNHHnnEVlxxxeDyww8/mN6r6cM3derU8ME77rjjbLXVVrN77rkn+EjU4ruhUDHyY7y4Iy6d/w3iG2+SEGhVpdXaIYccEqt77C233BLG5p5sMLh72ISIj5bKWytSrczmnXfenntV0IpJVuOXjdcg+fbje9JJJ4V3bFoZr7TSSuFdm/6gxP6w9SSAsNVzXjKzeuCBB+yoo47qbAhoRabHzEUXXTR84CRwejzSo5NedmtTYebMmSaByAw4WpnE/T/uaHWm6cc3rtb0+LbKKqtkxhmv8p133hnPpa/2fvKNgbJ89Ufk6aefNgn1AgssYNodFWc9Xndv4sQY2HoQQNjqMQ+ZWcQX4doQ0OPl/vvvbw8//LBddtllwV/v0LRSu+aaa8IHTruhxx57bHjJfeqpp5pWP3oflF7xjBc3BB/9MYivbomrNb2P0mrN3VU95sraPNAmRNxkkKCMuamrQmPtKnZ+HSTffn31h0IrYR1Vee6552yrrbayO++8M7wSePnllzt980t9CCBs9ZmL3Ezc3bTykaDpHZtWRNpBnDZtWme3cc8997TPPvvMdOZLj6xayemDuMwyy9j06dMzY7tnx81ydu/PV7npOIZWNKuvvnpWqL7qllxyyeCn3Ue9AwuFrh/xvFueALr3l69Cuvfnqz8SW2+9dXh/eP7559t3330Xdk3HWxGrD65yCSBs5fIeam86kLv++uvbtBGBO/fcczvv3tSJXrw///zzJiFcfPHFVVX4FVdrEqUjjjgivEObaKcScsV58sknxxxK1o7p3XffbWrfZJNNJtrFhO+TwB144IG2/PLLm/546I/IBINxW0EEELaCwA47rD7M55xzTjjHts0225hO6U8d2TDQWSq9QJ8xY0Y4b6V+taOosup13EF+qs+6suJm+aluPN+4Wttvv/1MR050z0QvbZbsuOOOQTgOO+ww06O4YskeeeSRgYNWqfJTfdY1Xr7d92T5qi4+/uuxXv5aPeqw8AUXXBAODWvHV3OhNq76EEDY6jMXYzKJu3bubtNHHievvfZa22KLLcIGQnTWB2/77bc3vetZa621wipJVmWtmvbee+/o2rH9xI3O/frG1Zoeg48++uiQR4wxEav3gjqAq9XoM888E3Z63T1YvRuToJ155pkmv+74/eare8bz1btNrXp1wFgbNO4eDhzr612aC60qzzjjjLkeq/Hf0AkgbENHWkxAfb9SO51PPPFEOPQae9Fjph7LtAM633zzhWqJgXz1tapYFxoyfuTFzXC1OfnG1Zoe0brP1GXF6bdO5/X0fcydd945CIru03h0Nk47lcpHdXmX2sUhzSzLP8tXf0weeughO/TQQ8P3cON9egQ9+eSTTaKnPyKxHlsfAnMStvpk2bJMdKRAjzzd1yeffGLa6cx67NEqSQdIdWBV9+gMmHy1m9eNbpC4g/iqjx122MF0tETHTdyzd0Llp7Nt+v7lzTffrOK4l4RDxzDuvffe4HvXXXfZ9ddfH1awoWL0xyD59uvr7uGR+sYbbzSdGRRbXV988UXYNNBYRrvH1IwAwlazCSGdbAJrrLFG2Cw45ZRT7L333gvfM33sscfCl//zjn5kR6K2DQQQtjbMcgPGqHdqOkKijRHt9OrbGNpceO211+yvv/5qwAgZwjAJIGzDpDmEWITIJqBNgksvvdTOPvvscLxFXvp/O9FXs+KhXtVxQUAEEDZR4JoUBPTO8Kyzzgpf6te7rjvuuGPMu7ZJMRCSLJwAwlY4YjqAAATKJoCwlU2c/upHgIwaRwBha9yUMiAIQABh498ABCDQOAIIW+OmlAFBYDIQKDbH/wAAAP//HIRAUwAAAAZJREFUAwD63TTqIR3DXwAAAABJRU5ErkJggg=="></td>
                                        <td>
                                            <button type="button"
                                                    class="btn btn-sm btn-success save-serial-btn"
                                                    data-serial-id="{{ $serial->id }}"
                                                    onclick="saveSerial({{ $serial->id }})">
                                                <i class="mdi mdi-content-save"></i> Save
                                            </button>
                                            <button type="button"
                                                    class="btn btn-sm btn-danger ms-1 scrap-serial-btn"
                                                    data-serial-id="{{ $serial->id }}"
                                                    data-serial-number="{{ $serial->final_serial }}"
                                                    onclick="scrapSerial('{{ $serial->final_serial }}', {{ $serial->id }})">
                                                <i class="mdi mdi-delete"></i> Scrap
                                            </button>
                                            <div class="mt-1">
                                                <small class="text-muted">
                                                    Current: <strong id="current-serial-{{ $serial->id }}">{{ $serial->final_serial }}</strong>
                                                </small>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="mdi mdi-information-outline fs-48 mb-2"></i>
                                                <p>No serial numbers found. This might be because the stock quantity is 0.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
                                    <p class="text-muted">{{ $product->cost_price ? '₹' . number_format($product->cost_price, 2) : 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Selling Price:</label>
                                    <p class="text-muted">{{ $product->selling_price ? '₹' . number_format($product->selling_price, 2) : 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Discount Price:</label>
                                    <p class="text-muted">{{ $product->discount_price ? '₹' . number_format($product->discount_price, 2) : 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Tax Rate:</label>
                                    <p class="text-muted">{{ $product->tax ? $product->tax . '%' : 'N/A' }}</p>
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
                                    <p class="text-muted">
                                        <span class="badge {{ $product->stock_status == 'In Stock' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->stock_status ?? 'Out of Stock' }}
                                        </span>
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

                <!-- Rack Details -->
                <div class="card">
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
                </div>

            </div>

            <div class="col-lg-4">
                <!-- Product Images -->
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <h5 class="card-title mb-0">Product Images</h5>
                    </div>
                    <div class="card-body">
                        @if($product->main_product_image)
                            <div class="mb-3">
                                <label class="fw-semibold">Main Product Image:</label>
                                <div class="mt-2">
                                    <img src="{{ asset($product->main_product_image) }}" alt="Main Product Image" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>
                        @endif

                        @if($product->additional_product_images && count($product->additional_product_images) > 0)
                            <div class="mb-3">
                                <label class="fw-semibold">Additional Images:</label>
                                <div class="row mt-2">
                                    @foreach($product->additional_product_images as $image)
                                        <div class="col-6 mb-2">
                                            <img src="{{ asset($image) }}" alt="Additional Image" class="img-fluid rounded" style="max-height: 100px;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($product->datasheet_manual)
                            <div class="mb-3">
                                <label class="fw-semibold">Datasheet/Manual:</label>
                                <div class="mt-2">
                                    <a href="{{ asset($product->datasheet_manual) }}" target="_blank" class="btn btn-sm btn-outline-primary">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Color Options:</label>
                                    <p class="text-muted">{{ $product->formatted_color_options }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Size Options:</label>
                                    <p class="text-muted">{{ $product->formatted_size_options }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-semibold">Length Options:</label>
                                    <p class="text-muted">{{ $product->formatted_length_options }}</p>
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
                                    <label class="fw-semibold">Status:</label>
                                    <p class="text-muted">
                                        <span class="badge {{ $product->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->status ?? 'Inactive' }}
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

<!-- Scrap Serial Modal -->
<div class="modal fade" id="scrapSerialModal" tabindex="-1" aria-labelledby="scrapSerialModalLabel" aria-hidden="true">
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
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
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
    fetch('{{ route("product-list.save-serial") }}', {
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

        fetch('{{ route("product-list.scrap-product") }}', {
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
                const modal = bootstrap.Modal.getInstance(document.getElementById('scrapSerialModal'));
                modal.hide();

                // Remove the scrapped serial row from the table
                const serialRow = document.querySelector(`tr[id*="${serialNumber}"]`);
                if (serialRow) {
                    serialRow.style.transition = 'opacity 0.3s';
                    serialRow.style.opacity = '0';
                    setTimeout(() => {
                        serialRow.remove();

                        // Check if no more serial numbers are left
                        const remainingRows = document.querySelectorAll('#serial-row-');
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