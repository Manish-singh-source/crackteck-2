@extends('warehouse/layouts/master')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Stock Reports</h4>
                <p class="text-muted mb-0">View and manage stock reports</p>
            </div>
            <div>
                <a href="{{ route('low-stock.export') }}" class="btn btn-primary">Export Stock Reports</a>
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
                                                @if($stockReports->isEmpty())
                                                    <div class="alert alert-success" role="alert">
                                                        <i class="fas fa-check-circle me-2"></i>
                                                        No stock reports found.
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
                                                            @foreach($stockReports as $product)
                                                                <tr class="align-middle">
                                                                    <td>
                                                                        <a href="{{ route('product-list.view', $product->id) }}" class="text-dark fw-medium">
                                                                            {{ $product->product_name }}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ $product->sku ?? 'N/A' }}</td>
                                                                    <td>
                                                                        {{ $product->stock_quantity }}
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