@extends('e-commerce/layouts/master')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">View Banner Details</h4>
            </div>
            <div>
                <a href="{{ route('website.banner.index') }}" class="btn btn-secondary">Back to List</a>
                <a href="{{ route('website.banner.edit', $website->id) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Banner Information</h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Banner Image -->
                            <div class="col-12">
                                <label class="form-label fw-bold">Banner Image</label>
                                <div>
                                    @if($website->image_url)
                                        <img src="{{ asset($website->image_url) }}" alt="{{ $website->title }}"
                                             class="img-fluid" style="max-width: 600px; height: auto;">
                                    @else
                                        <p class="text-muted">No image available</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="col-lg-6">
                                <label class="form-label fw-bold">Title</label>
                                <p class="form-control-plaintext">{{ $website->title }}</p>
                            </div>

                            <!-- Slug -->
                            <div class="col-lg-6">
                                <label class="form-label fw-bold">Slug</label>
                                <p class="form-control-plaintext">{{ $website->slug }}</p>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label class="form-label fw-bold">Description</label>
                                <p class="form-control-plaintext">{{ $website->description ?: 'N/A' }}</p>
                            </div>

                            <!-- Type -->
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">Type</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-{{ $website->type == 0 ? 'info' : 'warning' }}">
                                        {{ $website->type == 0 ? 'Website' : 'Promotional' }}
                                    </span>
                                </p>
                            </div>

                            <!-- Channel -->
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">Channel</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-secondary">
                                        {{ $website->channel == 0 ? 'Website' : 'Mobile' }}
                                    </span>
                                </p>
                            </div>

                            <!-- Position -->
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">Position</label>
                                <p class="form-control-plaintext">
                                    @php
                                        $positions = ['Homepage', 'Category', 'Product', 'Slider', 'Checkout', 'Cart'];
                                    @endphp
                                    <span class="badge bg-primary">
                                        {{ $positions[$website->position] ?? 'N/A' }}
                                    </span>
                                </p>
                            </div>

                            <!-- Display Order -->
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">Display Order</label>
                                <p class="form-control-plaintext">{{ $website->display_order }}</p>
                            </div>

                            <!-- Promotion Type -->
                            @if($website->promotion_type !== null)
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">Promotion Type</label>
                                <p class="form-control-plaintext">
                                    @php
                                        $promoTypes = ['Discount', 'Coupon', 'Flash Sale', 'Event'];
                                    @endphp
                                    {{ $promoTypes[$website->promotion_type] ?? 'N/A' }}
                                </p>
                            </div>
                            @endif

                            <!-- Discount Value -->
                            @if($website->discount_value)
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">Discount Value</label>
                                <p class="form-control-plaintext">{{ $website->discount_value }}</p>
                            </div>
                            @endif

                            <!-- Discount Type -->
                            @if($website->discount_type !== null)
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">Discount Type</label>
                                <p class="form-control-plaintext">
                                    {{ $website->discount_type == 0 ? 'Percentage' : 'Fixed' }}
                                </p>
                            </div>
                            @endif

                            <!-- Promo Code -->
                            @if($website->promo_code)
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">Promo Code</label>
                                <p class="form-control-plaintext">
                                    <code>{{ $website->promo_code }}</code>
                                </p>
                            </div>
                            @endif

                            <!-- Link URL -->
                            @if($website->link_url)
                            <div class="col-lg-6">
                                <label class="form-label fw-bold">Link URL</label>
                                <p class="form-control-plaintext">
                                    <a href="{{ $website->link_url }}" target="_blank">{{ $website->link_url }}</a>
                                </p>
                            </div>
                            @endif




                            <!-- Link Target -->
                            @if($website->link_target !== null)
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">Link Target</label>
                                <p class="form-control-plaintext">
                                    {{ $website->link_target == 0 ? 'Self' : 'Blank' }}
                                </p>
                            </div>
                            @endif

                            <!-- Start Date -->
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">Start Date</label>
                                <p class="form-control-plaintext">
                                    {{ $website->start_at ? $website->start_at->format('d M Y, h:i A') : 'N/A' }}
                                </p>
                            </div>

                            <!-- End Date -->
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">End Date</label>
                                <p class="form-control-plaintext">
                                    {{ $website->end_at ? $website->end_at->format('d M Y, h:i A') : 'N/A' }}
                                </p>
                            </div>

                            <!-- Status -->
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">Status</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-{{ $website->is_active ? 'success' : 'danger' }}">
                                        {{ $website->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </p>
                            </div>

                            <!-- Click Count -->
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">Click Count</label>
                                <p class="form-control-plaintext">{{ $website->click_count }}</p>
                            </div>

                            <!-- View Count -->
                            <div class="col-lg-3">
                                <label class="form-label fw-bold">View Count</label>
                                <p class="form-control-plaintext">{{ $website->view_count }}</p>
                            </div>

                            <!-- Metadata -->
                            @if($website->metadata)
                            <div class="col-12">
                                <label class="form-label fw-bold">Metadata</label>
                                <pre class="bg-light p-3 rounded">{{ json_encode($website->metadata, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                            @endif

                            <!-- Created At -->
                            <div class="col-lg-6">
                                <label class="form-label fw-bold">Created At</label>
                                <p class="form-control-plaintext">
                                    {{ $website->created_at ? $website->created_at->format('d M Y, h:i A') : 'N/A' }}
                                </p>
                            </div>

                            <!-- Updated At -->
                            <div class="col-lg-6">
                                <label class="form-label fw-bold">Updated At</label>
                                <p class="form-control-plaintext">
                                    {{ $website->updated_at ? $website->updated_at->format('d M Y, h:i A') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection