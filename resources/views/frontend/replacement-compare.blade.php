@extends('frontend/layout/master')

@section('main-content')
<section class="tf-sp-2">
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('shop') }}" class="body-small link">Back to shop</a>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="order-detail-wrap h-100">
                    <h5 class="fw-bold mb-3">Current Product</h5>
                    <div class="d-flex gap-3 align-items-start">
                        <img src="{{ $originalProduct && $originalProduct->main_product_image ? asset($originalProduct->main_product_image) : asset('frontend-assets/images/placeholder-product.png') }}" alt="Current product" style="width: 120px; height: 120px; object-fit: cover; border-radius: 12px;">
                        <div>
                            <h6 class="mb-2">{{ $orderItem->product_name }}</h6>
                            <p class="mb-1">Price: Rs {{ number_format($orderItem->unit_price, 2) }}</p>
                            <p class="mb-1">SKU: {{ $orderItem->product_sku ?: 'N/A' }}</p>
                            <p class="mb-0">Specifications: {!! $originalProduct->technical_specification ?? 'N/A' !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="order-detail-wrap h-100">
                    <h5 class="fw-bold mb-3">Replacement Product</h5>
                    <div class="d-flex gap-3 align-items-start">
                        <img src="{{ $replacementProduct->warehouseProduct && $replacementProduct->warehouseProduct->main_product_image ? asset($replacementProduct->warehouseProduct->main_product_image) : asset('frontend-assets/images/placeholder-product.png') }}" alt="Replacement product" style="width: 120px; height: 120px; object-fit: cover; border-radius: 12px;">
                        <div>
                            <h6 class="mb-2">{{ $replacementProduct->warehouseProduct->product_name ?? 'N/A' }}</h6>
                            <p class="mb-1">Price: Rs {{ number_format($replacementProduct->warehouseProduct->final_price ?? 0, 2) }}</p>
                            <p class="mb-1">SKU: {{ $replacementProduct->warehouseProduct->sku ?? 'N/A' }}</p>
                            <p class="mb-0">Specifications: {!! $replacementProduct->warehouseProduct->technical_specification ?? 'N/A' !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-detail-wrap mt-4">
            <h5 class="fw-bold mb-3">Review Replacement</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-6"><strong>Reason:</strong> {{ $replacementContext['reason'] }}</div>
                <div class="col-md-6"><strong>Order:</strong> {{ $order->order_number }}</div>
                <div class="col-12"><strong>Description:</strong> {{ $replacementContext['description'] ?: 'N/A' }}</div>
            </div>
            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Current Product</th>
                            <th>Replacement Product</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ $orderItem->product_name }}</td>
                            <td>{{ $replacementProduct->warehouseProduct->product_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>Rs {{ number_format($orderItem->unit_price, 2) }}</td>
                            <td>Rs {{ number_format($replacementProduct->warehouseProduct->final_price ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Brand</td>
                            <td>{{ $originalProduct->brand->name ?? 'N/A' }}</td>
                            <td>{{ $replacementProduct->warehouseProduct->brand->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Model</td>
                            <td>{{ $originalProduct->model_no ?? 'N/A' }}</td>
                            <td>{{ $replacementProduct->warehouseProduct->model_no ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Variants / Attributes</td>
                            <td>{{ is_array($originalProduct->variation_options ?? null) ? implode(', ', $originalProduct->variation_options) : ($originalProduct->variation_options ?? 'N/A') }}</td>
                            <td>{{ is_array($replacementProduct->warehouseProduct->variation_options ?? null) ? implode(', ', $replacementProduct->warehouseProduct->variation_options) : ($replacementProduct->warehouseProduct->variation_options ?? 'N/A') }}</td>
                        </tr>
                        <tr>
                            <td>Specifications</td>
                            <td>{!! $originalProduct->technical_specification ?? 'N/A' !!}</td>
                            <td>{!! $replacementProduct->warehouseProduct->technical_specification ?? 'N/A' !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <form action="{{ route('order.replacement.submit') }}" method="POST" class="d-flex gap-3 flex-wrap">
                @csrf
                <input type="hidden" name="replacement_product_id" value="{{ $replacementProduct->id }}">
                <button type="submit" class="btn btn-dark">Confirm Replacement Request</button>
                <a href="{{ route('shop') }}" class="btn btn-outline-secondary">Choose Another Product</a>
            </form>
        </div>
    </div>
</section>
@endsection
