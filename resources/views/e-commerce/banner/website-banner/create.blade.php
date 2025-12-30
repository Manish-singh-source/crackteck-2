@extends('e-commerce/layouts/master')

@section('content')
<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Create Website Banner</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('website.banner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h5 class="card-title mb-0">Banner Details</h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-4">
                                
                                <!-- Basic Info -->
                                <div class="col-lg-3">
                                    @include('components.form.input', [
                                        'label' => 'Title *',
                                        'name' => 'title',
                                        'type' => 'text',
                                        'required' => true,
                                        'placeholder' => 'Enter banner title'
                                    ])
                                </div>

                                <!-- Image Upload -->
                                <div class="col-lg-3">
                                    @include('components.form.input', [
                                        'label' => 'Banner Image *',
                                        'name' => 'image',
                                        'type' => 'file',
                                        'accept' => 'image/*',
                                        'required' => true
                                    ])
                                    <small class="text-muted">Recommended: 1920x600px, Max 2MB</small>
                                </div>

                                <!-- Type & Channel -->
                                <div class="col-lg-3">
                                    @include('components.form.select', [
                                        'label' => 'Banner Type *',
                                        'name' => 'type',
                                        'required' => true,
                                        'options' => [
                                            '0' => 'Website',
                                            '1' => 'Promotional'
                                        ]
                                    ])
                                </div>

                                <div class="col-lg-3">
                                    @include('components.form.select', [
                                        'label' => 'Channel *',
                                        'name' => 'channel',
                                        'required' => true,
                                        'options' => [
                                            '0' => 'Website',
                                            '1' => 'Mobile App'
                                        ]
                                    ])
                                </div>

                                <div class="col-12">
                                    {{-- Description Field --}}
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter banner description"></textarea>  
                                </div>

                                <!-- Promotion Details -->
                                <div class="col-lg-3">
                                    @include('components.form.select', [
                                        'label' => 'Promotion Type',
                                        'name' => 'promotion_type',
                                        'options' => [
                                            '' => 'None',
                                            '0' => 'Discount',
                                            '1' => 'Coupon',
                                            '2' => 'Flash Sale',
                                            '3' => 'Event'
                                        ]
                                    ])
                                </div>

                                <div class="col-lg-3 promotion-field">
                                    @include('components.form.input', [
                                        'label' => 'Discount Value',
                                        'name' => 'discount_value',
                                        'type' => 'number',
                                        'step' => '0.01',
                                        'min' => '0',
                                        'placeholder' => '0.00'
                                    ])
                                </div>

                                <div class="col-lg-3 promotion-field">
                                    @include('components.form.select', [
                                        'label' => 'Discount Type',
                                        'name' => 'discount_type',
                                        'options' => [
                                            '' => 'Select',
                                            '0' => 'Percentage (%)',
                                            '1' => 'Fixed Amount'
                                        ]
                                    ])
                                </div>

                                <div class="col-lg-3 promotion-field">
                                    @include('components.form.input', [
                                        'label' => 'Promo Code',
                                        'name' => 'promo_code',
                                        'type' => 'text',
                                        'placeholder' => 'SAVE20'
                                    ])
                                </div>

                                <!-- Link Settings -->
                                <div class="col-lg-3">
                                    @include('components.form.input', [
                                        'label' => 'Link URL',
                                        'name' => 'link_url',
                                        'type' => 'url',
                                        'placeholder' => 'https://example.com'
                                    ])
                                </div>

                                <div class="col-lg-3">
                                    @include('components.form.select', [
                                        'label' => 'Link Target',
                                        'name' => 'link_target',
                                        'options' => [
                                            '0' => 'Same Tab',
                                            '1' => 'New Tab'
                                        ]
                                    ])
                                </div>

                                <!-- Position & Order -->
                                <div class="col-lg-3">
                                    @include('components.form.select', [
                                        'label' => 'Position *',
                                        'name' => 'position',
                                        'required' => true,
                                        'options' => [
                                            '0' => 'Homepage',
                                            '1' => 'Category Page',
                                            '2' => 'Product Page',
                                            '3' => 'Slider',
                                            '4' => 'Checkout',
                                            '5' => 'Cart'
                                        ]
                                    ])
                                </div>

                                <div class="col-lg-3">
                                    @include('components.form.input', [
                                        'label' => 'Display Order',
                                        'name' => 'display_order',
                                        'type' => 'number',
                                        'min' => '0',
                                        'placeholder' => '0',
                                        'required' => true
                                    ])
                                </div>

                                <!-- Date Range -->
                                <div class="col-lg-3">
                                    @include('components.form.input', [
                                        'label' => 'Start Date *',
                                        'name' => 'start_at',
                                        'type' => 'datetime-local',
                                        'required' => true
                                    ])
                                </div>

                                <div class="col-lg-3">
                                    @include('components.form.input', [
                                        'label' => 'End Date *',
                                        'name' => 'end_at',
                                        'type' => 'datetime-local',
                                        'required' => true
                                    ])
                                </div>

                                <!-- Status & Metadata -->
                                <div class="col-lg-3">
                                    @include('components.form.select', [
                                        'label' => 'Status *',
                                        'name' => 'is_active',
                                        'required' => true,
                                        'options' => [
                                            '1' => 'Active',
                                            '0' => 'Inactive'
                                        ]
                                    ])
                                </div>

                                <div class="col-12">
                                    {{-- Metadata  --}}
                                    <label for="metadata" class="form-label">Metadata (JSON)</label>
                                    <textarea class="form-control" id="metadata" name="metadata" rows="3" placeholder="Enter metadata as JSON"></textarea>
                                </div>

                                <!-- Submit -->
                                <div class="col-12 text-start mt-4">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">
                                        <i class="ri-add-line me-1"></i>
                                        Create Banner
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

<style>
.promotion-field {
    display: none;
}
.promotion-field.active {
    display: block;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const promotionType = document.querySelector('[name="promotion_type"]');
    const promotionFields = document.querySelectorAll('.promotion-field');
    
    function togglePromotionFields() {
        if (promotionType.value !== '') {
            promotionFields.forEach(field => field.classList.add('active'));
        } else {
            promotionFields.forEach(field => field.classList.remove('active'));
        }
    }
    
    promotionType.addEventListener('change', togglePromotionFields);
    togglePromotionFields();
    
    // Auto-generate slug from title
    const titleField = document.querySelector('[name="title"]');
    const slugField = document.querySelector('[name="slug"]');
    
    titleField.addEventListener('input', function() {
        if (!slugField.value) {
            slugField.value = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
        }
    });
});
</script>
@endsection
