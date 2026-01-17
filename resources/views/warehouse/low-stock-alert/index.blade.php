@extends('warehouse/layouts/master')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Low Stock Alert</h4>
                <p class="text-muted mb-0">Products with stock quantity below 40 units</p>
            </div>
            <div>
                <a href="{{ route('low-stock.export') }}" class="btn btn-primary">Export Low Stock Products</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pt-0">
                        <div class="tab-content text-muted">
                            <div class="tab-pane active show" id="low_stock" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                @if($lowStockProducts->isEmpty())
                                                    <div class="alert alert-success" role="alert">
                                                        <i class="fas fa-check-circle me-2"></i>
                                                        All products are adequately stocked. No low stock alerts at this time.
                                                    </div>
                                                @else
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Product Name</th>
                                                                <th>SKU / Product Code</th>
                                                                <th>Current Quantity</th>
                                                                <th>Category</th>
                                                                <th>Brand</th>
                                                                <th>Last Restocked Date</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($lowStockProducts as $product)
                                                                <tr class="align-middle">
                                                                    <td>
                                                                        <a href="{{ route('product-list.view', $product->id) }}" class="text-dark fw-medium">
                                                                            {{ $product->product_name }}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ $product->sku ?? 'N/A' }}</td>
                                                                    <td>
                                                                        @if($product->stock_quantity < 20)
                                                                            <span class="badge bg-danger-subtle text-danger fs-12">
                                                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                                                {{ $product->stock_quantity }}
                                                                            </span>
                                                                        @elseif($product->stock_quantity >= 20 && $product->stock_quantity < 40)
                                                                            <span class="badge bg-warning-subtle text-warning fs-12">
                                                                                <i class="fas fa-exclamation-circle me-1"></i>
                                                                                {{ $product->stock_quantity }}
                                                                            </span>
                                                                        @else
                                                                            <span class="badge bg-success-subtle text-success fs-12">
                                                                                {{ $product->stock_quantity }}
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $product->parentCategorie->name ?? 'N/A' }}</td>
                                                                    <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                                                    <td>{{ $product->created_at ? $product->created_at->format('Y-m-d') : 'N/A' }}</td>
                                                                    <td>
                                                                        <a href="{{ route('product-list.view', $product->id) }}"
                                                                           class="btn btn-sm bg-primary-subtle me-1"
                                                                           title="View Product">
                                                                            <i class="fas fa-eye"></i> View
                                                                        </a>
                                                                        {{-- <a href="{{ route('product-list.edit', $product->id) }}"
                                                                           class="btn btn-sm bg-info-subtle me-1"
                                                                           title="Edit Product">
                                                                            <i class="fas fa-edit"></i> Edit
                                                                        </a> --}}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
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