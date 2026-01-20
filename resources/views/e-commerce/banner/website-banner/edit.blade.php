@extends('e-commerce/layouts/master')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Website Banner</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('website.banner.update', $website->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-header">
                            <h5 class="card-title mb-0">Banner Details</h5>
                        </div>

                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row g-4">
                                <!-- Title -->
                                <div class="col-lg-3">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           name="title" value="{{ old('title', $website->title) }}" required>
                                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Image -->
                                <div class="col-lg-3">
                                    <label class="form-label">Banner Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                           name="image" accept="image/*">
                                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    @if($website->image_url)
                                        <img src="{{ asset($website->image_url) }}" class="mt-2" style="max-width: 100px; height: auto;">
                                    @endif
                                </div>

                                <!-- Type -->
                                <div class="col-lg-3">
                                    <label class="form-label">Banner Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                                        <option value="website" {{ old('type', $website->type) == 'website' ? 'selected' : '' }}>Website</option>
                                        <option value="promotional" {{ old('type', $website->type) == 'promotional' ? 'selected' : '' }}>Promotional</option>
                                    </select>
                                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Channel -->
                                <div class="col-lg-3">
                                    <label class="form-label">Channel <span class="text-danger">*</span></label>
                                    <select class="form-select @error('channel') is-invalid @enderror" name="channel" required>
                                        <option value="website" {{ old('channel', $website->channel) == 'website' ? 'selected' : '' }}>Website</option>
                                        <option value="mobile" {{ old('channel', $website->channel) == 'mobile' ? 'selected' : '' }}>Mobile</option>
                                    </select>
                                    @error('channel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              name="description" rows="3">{{ old('description', $website->description) }}</textarea>
                                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Promotion Type -->
                                <div class="col-lg-3">
                                    <label class="form-label">Promotion Type</label>
                                    <select class="form-select @error('promotion_type') is-invalid @enderror" name="promotion_type">
                                        <option value="">Select</option>
                                        <option value="discount" {{ old('promotion_type', $website->promotion_type) == 'discount' ? 'selected' : '' }}>Discount</option>
                                        <option value="coupon" {{ old('promotion_type', $website->promotion_type) == 'coupon' ? 'selected' : '' }}>Coupon</option>
                                        <option value="flash_sale" {{ old('promotion_type', $website->promotion_type) == 'flash_sale' ? 'selected' : '' }}>Flash Sale</option>
                                        <option value="event" {{ old('promotion_type', $website->promotion_type) == 'event' ? 'selected' : '' }}>Event</option>
                                    </select>
                                    @error('promotion_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Discount Value -->
                                <div class="col-lg-3">
                                    <label class="form-label">Discount Value</label>
                                    <input type="number" step="0.01" class="form-control @error('discount_value') is-invalid @enderror"
                                           name="discount_value" value="{{ old('discount_value', $website->discount_value) }}">
                                    @error('discount_value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Discount Type -->
                                <div class="col-lg-3">
                                    <label class="form-label">Discount Type</label>
                                    <select class="form-select @error('discount_type') is-invalid @enderror" name="discount_type">
                                        <option value="">Select</option>
                                        <option value="percentage" {{ old('discount_type', $website->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                        <option value="fixed" {{ old('discount_type', $website->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                    </select>
                                    @error('discount_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Promo Code -->
                                <div class="col-lg-3">
                                    <label class="form-label">Promo Code</label>
                                    <input type="text" class="form-control @error('promo_code') is-invalid @enderror"
                                           name="promo_code" value="{{ old('promo_code', $website->promo_code) }}">
                                    @error('promo_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Link URL -->
                                <div class="col-lg-3">
                                    <label class="form-label">Link URL</label>
                                    <input type="url" class="form-control @error('link_url') is-invalid @enderror"
                                           name="link_url" value="{{ old('link_url', $website->link_url) }}">
                                    @error('link_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Link Target -->
                                <div class="col-lg-3">
                                    <label class="form-label">Link Target</label>
                                    <select class="form-select @error('link_target') is-invalid @enderror" name="link_target">
                                        <option value="self" {{ old('link_target', $website->link_target) == 'self' ? 'selected' : '' }}>Self</option>
                                        <option value="blank" {{ old('link_target', $website->link_target) == 'blank' ? 'selected' : '' }}>Blank</option>
                                    </select>
                                    @error('link_target')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Position -->
                                <div class="col-lg-3">
                                    <label class="form-label">Position <span class="text-danger">*</span></label>
                                    <select class="form-select @error('position') is-invalid @enderror" name="position" required>
                                        <option value="homepage" {{ old('position', $website->position) == 'homepage' ? 'selected' : '' }}>Homepage</option>
                                        <option value="category" {{ old('position', $website->position) == 'category' ? 'selected' : '' }}>Category</option>
                                        <option value="product" {{ old('position', $website->position) == 'product' ? 'selected' : '' }}>Product</option>
                                        <option value="slider" {{ old('position', $website->position) == 'slider' ? 'selected' : '' }}>Slider</option>
                                        <option value="checkout" {{ old('position', $website->position) == 'checkout' ? 'selected' : '' }}>Checkout</option>
                                        <option value="cart" {{ old('position', $website->position) == 'cart' ? 'selected' : '' }}>Cart</option>
                                    </select>
                                    @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Display Order -->
                                <div class="col-lg-3">
                                    <label class="form-label">Display Order <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('display_order') is-invalid @enderror"
                                           name="display_order" value="{{ old('display_order', $website->display_order) }}" min="0" required>
                                    @error('display_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Start Date -->
                                <div class="col-lg-3">
                                    <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('start_at') is-invalid @enderror"
                                           name="start_at" value="{{ old('start_at', $website->start_at ? $website->start_at->format('Y-m-d\TH:i') : '') }}" required>
                                    @error('start_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- End Date -->
                                <div class="col-lg-3">
                                    <label class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('end_at') is-invalid @enderror"
                                           name="end_at" value="{{ old('end_at', $website->end_at ? $website->end_at->format('Y-m-d\TH:i') : '') }}" required>
                                    @error('end_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Status -->
                                <div class="col-lg-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('is_active') is-invalid @enderror" name="is_active" required>
                                        <option value="1" {{ old('is_active', $website->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', $website->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Metadata -->
                                <div class="col-12">
                                    <label class="form-label">Metadata (JSON)</label>
                                    <textarea class="form-control @error('metadata') is-invalid @enderror"
                                              name="metadata" rows="3">{{ old('metadata', $website->metadata ? json_encode($website->metadata) : '') }}</textarea>
                                    @error('metadata')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Submit -->
                                <div class="col-12 text-start mt-4">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">
                                        <i class="ri-save-line me-1"></i>
                                        Update Banner
                                    </button>
                                    <a href="{{ route('website.banner.index') }}" class="btn btn-secondary waves-effect ms-2">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
