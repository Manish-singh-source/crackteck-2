@extends('warehouse/layouts/master')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Products List</h4>
                </div>
                <div>
                    <a href="{{ route('product-list.create') }}" class="btn btn-primary">Add New Product</a>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active p-2" id="all_customer_tab" data-bs-toggle="tab"
                                        href="#all_customer" role="tab">
                                        <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                        <span class="d-none d-sm-block">All Products</span>
                                    </a>
                                </li>

                            </ul>

                            <div class="tab-content text-muted">

                                <div class="tab-pane active show pt-4" id="all_customer" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>SKU & HSN</th>
                                                                <th>Category - Sub Category</th>
                                                                <th>Pricing</th>
                                                                <th>Stock</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($products as $product)
                                                                <tr class="align-middle">
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="me-3">
                                                                                @if ($product->main_product_image)
                                                                                    <img src="{{ asset($product->main_product_image) }}"
                                                                                        alt="{{ $product->product_name }}"
                                                                                        width="80" height="80"
                                                                                        class="img-fluid rounded">
                                                                                @else
                                                                                    <img src="https://placehold.co/80x80"
                                                                                        alt="No Image" width="80"
                                                                                        height="80"
                                                                                        class="img-fluid rounded">
                                                                                @endif
                                                                            </div>
                                                                            <div>
                                                                                <div class="fw-semibold">
                                                                                    {{ $product->product_name }}
                                                                                </div>
                                                                                <div class="text-muted small">
                                                                                    Brand:
                                                                                    {{ $product->brand->name ?? 'N/A' }}
                                                                                </div>
                                                                                <div class="text-muted small">
                                                                                    Model: {{ $product->model_no ?? 'N/A' }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="small text-muted fw-semibold mb-1">SKU:
                                                                                {{ $product->sku }}</div>
                                                                        @if ($product->hsn_code)
                                                                            <div class="small text-muted">HSN:
                                                                                {{ $product->hsn_code }}</div>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($product->parentCategorie)
                                                                            <span
                                                                                class="badge bg-primary-subtle text-primary fw-semibold">{{ $product->parentCategorie->name }}</span>
                                                                        @endif
                                                                        @if ($product->subCategorie)
                                                                            <div class="small text-muted">
                                                                                {{ $product->subCategorie->name }}</div>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($product->cost_price)
                                                                            <div class="small">Cost:
                                                                                ₹{{ number_format($product->cost_price, 2) }}
                                                                            </div>
                                                                        @endif
                                                                        @if ($product->selling_price)
                                                                            <div class="small">Selling:
                                                                                ₹{{ number_format($product->selling_price, 2) }}
                                                                            </div>
                                                                        @endif
                                                                        @if ($product->discount_price)
                                                                            <div class="small text-success">Discount:
                                                                                ₹{{ number_format($product->discount_price, 2) }}
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <div>{{ $product->stock_quantity ?? 0 }}</div>
                                                                        @if ($product->stock_status)
                                                                            <span
                                                                                class="badge {{ $product->stock_status == 'In Stock' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                                                {{ $product->stock_status }}
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <div class="small text-muted">
                                                                            {{ $product->created_at->format('d M Y') }}
                                                                        </div>
                                                                        <span
                                                                            class="badge {{ $product->status == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fw-semibold">
                                                                            {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('product-list.view', $product->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('product-list.edit', $product->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('product-list.destroy', $product->id) }}"
                                                                            method="POST" style="display: inline;"
                                                                            onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" aria-label="anchor"
                                                                                class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Delete">
                                                                                <i
                                                                                    class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>

                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7" class="text-center py-4">
                                                                        <div class="text-muted">
                                                                            <i
                                                                                class="mdi mdi-package-variant-closed fs-48 mb-2"></i>
                                                                            <p>No products found</p>
                                                                            <a href="{{ route('product-list.create') }}"
                                                                                class="btn btn-primary">Add First
                                                                                Product</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
