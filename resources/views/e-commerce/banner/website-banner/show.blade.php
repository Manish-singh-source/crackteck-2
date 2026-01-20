@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                <div>
                    <h4 class="mb-1 fw-bold text-dark">Banner Details</h4>
                    <p class="mb-0 text-muted small">ID: #{{ $website->id }}</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('website.banner.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back to List
                    </a>
                    <a href="{{ route('website.banner.edit', $website->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit Banner
                    </a>
                </div>
            </div>

            {{-- Main Content Card --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 pb-0">
                            <ul class="nav nav-tabs border-0" id="bannerTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active fw-semibold" id="visual-tab" data-bs-toggle="tab"
                                        data-bs-target="#visual" type="button">
                                        <i class="fas fa-image me-1"></i>Visual
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-semibold" id="details-tab" data-bs-toggle="tab"
                                        data-bs-target="#details" type="button">
                                        <i class="fas fa-info-circle me-1"></i>Details
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-semibold" id="stats-tab" data-bs-toggle="tab"
                                        data-bs-target="#stats" type="button">
                                        <i class="fas fa-chart-bar me-1"></i>Stats
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-semibold" id="timeline-tab" data-bs-toggle="tab"
                                        data-bs-target="#timeline" type="button">
                                        <i class="fas fa-clock me-1"></i>Timeline
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body pt-3">
                            <div class="tab-content" id="bannerTabsContent">
                                {{-- Visual Tab --}}
                                <div class="tab-pane fade show active" id="visual" role="tabpanel">
                                    <div class="row g-4">
                                        <div class="col-lg-8">
                                            @if ($website->image_url)
                                                <div class="bg-light p-4 rounded-3 shadow-sm">
                                                    <img src="{{ asset($website->image_url) }}" alt="{{ $website->title }}"
                                                        class="img-fluid rounded-3 shadow-lg"
                                                        style="max-height: 500px; object-fit: cover;">
                                                </div>
                                            @else
                                                <div
                                                    class="bg-light p-5 text-center rounded-3 border-dashed border-2 border-secondary">
                                                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted mb-0">No banner image available</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label fw-bold text-dark mb-2">Quick Info</label>
                                                    <div
                                                        class="d-flex align-items-center gap-3 p-3 bg-primary-subtle rounded-3">
                                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width: 60px; height: 60px;">
                                                            <i class="fas fa-crown text-primary fs-4"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-semibold">
                                                                {{ Str::limit($website->title, 30) }}</h6>
                                                            <span
                                                                class="badge bg-success">{{ $website->is_active ? 'Active' : 'Inactive' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Details Tab --}}
                                <div class="tab-pane fade" id="details" role="tabpanel">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <label class="form-label fw-bold text-dark mb-2">Title</label>
                                            <div class="p-3 bg-light rounded-3 border">
                                                <h5 class="mb-0 fw-semibold text-truncate" title="{{ $website->title }}">
                                                    {{ $website->title }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label fw-bold text-dark mb-2">Slug</label>
                                            <div class="p-3 bg-light rounded-3 border">
                                                <code class="text-muted small d-block mb-1">/{{ $website->slug }}</code>
                                                <span class="badge bg-info">SEO Friendly</span>
                                            </div>
                                        </div>

                                        @if ($website->description)
                                            <div class="col-12">
                                                <label class="form-label fw-bold text-dark mb-2">Description</label>
                                                <div class="p-4 bg-light rounded-3 border">
                                                    <p class="mb-0 lh-lg">{{ $website->description }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-lg-3 col-md-6">
                                            <label class="form-label fw-bold text-dark mb-2">Type</label>
                                            <span
                                                class="badge fs-6 px-3 py-2 w-100 text-start bg-{{ $website->type == 0 ? 'info' : 'warning' }}">
                                                {{ $website->type == 0 ? 'Website' : 'Promotional' }}
                                            </span>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <label class="form-label fw-bold text-dark mb-2">Channel</label>
                                            <span class="badge fs-6 px-3 py-2 w-100 text-start bg-secondary">
                                                {{ $website->channel == 0 ? 'Website' : 'Mobile' }}
                                            </span>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <label class="form-label fw-bold text-dark mb-2">Position</label>
                                            @php
                                                $positions = [
                                                    'Homepage',
                                                    'Category',
                                                    'Product',
                                                    'Slider',
                                                    'Checkout',
                                                    'Cart',
                                                ];
                                            @endphp
                                            <span class="badge fs-6 px-3 py-2 w-100 text-start bg-primary">
                                                {{ $positions[$website->position] ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <label class="form-label fw-bold text-dark mb-2">Order</label>
                                            <div class="p-3 bg-light rounded-3 border text-center">
                                                <span
                                                    class="fs-4 fw-bold text-primary">{{ $website->display_order }}</span>
                                            </div>
                                        </div>

                                        {{-- Promotion Details --}}
                                        @if ($website->promotion_type !== null || $website->discount_value || $website->promo_code)
                                            <div class="col-12">
                                                <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">Promotion Details
                                                </h6>
                                                <div class="row g-3">
                                                    @if ($website->promotion_type !== null)
                                                        <div class="col-lg-3">
                                                            <label
                                                                class="form-label fw-semibold text-muted small mb-1">Promo
                                                                Type</label>
                                                            @php $promoTypes = ['Discount', 'Coupon', 'Flash Sale', 'Event']; @endphp
                                                            <span
                                                                class="badge bg-success px-3 py-2">{{ $promoTypes[$website->promotion_type] ?? 'N/A' }}</span>
                                                        </div>
                                                    @endif
                                                    @if ($website->discount_value)
                                                        <div class="col-lg-3">
                                                            <label
                                                                class="form-label fw-semibold text-muted small mb-1">Discount</label>
                                                            <div
                                                                class="p-2 bg-warning bg-opacity-10 border rounded-2 text-warning fw-bold">
                                                                {{ $website->discount_value }}%
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($website->promo_code)
                                                        <div class="col-lg-3">
                                                            <label
                                                                class="form-label fw-semibold text-muted small mb-1">Promo
                                                                Code</label>
                                                            <div class="p-3 bg-dark text-white rounded-2 text-center">
                                                                <code
                                                                    class="fs-6 fw-bold">{{ $website->promo_code }}</code>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Link Details --}}
                                        @if ($website->link_url)
                                            <div class="col-lg-6">
                                                <label class="form-label fw-bold text-dark mb-2">Link URL</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0"><i
                                                            class="fas fa-link"></i></span>
                                                    <input type="text" class="form-control border-start-0 bg-light"
                                                        value="{{ $website->link_url }}" readonly>
                                                    <button class="btn btn-outline-primary"
                                                        onclick="window.open('{{ $website->link_url }}', '_blank')">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Stats Tab --}}
                                <div class="tab-pane fade" id="stats" role="tabpanel">
                                    <div class="row g-4 text-center">
                                        <div class="col-lg-3 col-md-6">
                                            <div class="card border-0 h-100 bg-gradient-primary text-white shadow-lg">
                                                <div class="card-body py-4">
                                                    <i class="fas fa-eye fa-2x mb-2 opacity-75"></i>
                                                    <h3 class="fw-bold mb-1">{{ number_format($website->view_count) }}
                                                    </h3>
                                                    <p class="mb-0 small">Total Views</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="card border-0 h-100 bg-gradient-success text-white shadow-lg">
                                                <div class="card-body py-4">
                                                    <i class="fas fa-mouse-pointer fa-2x mb-2 opacity-75"></i>
                                                    <h3 class="fw-bold mb-1">{{ number_format($website->click_count) }}
                                                    </h3>
                                                    <p class="mb-0 small">Total Clicks</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="card border-0 h-100 bg-gradient-info text-white shadow-lg">
                                                <div class="card-body py-4">
                                                    <i class="fas fa-chart-line fa-2x mb-2 opacity-75"></i>
                                                    <h3 class="fw-bold mb-1">
                                                        {{ $website->click_count ? round(($website->click_count / $website->view_count) * 100, 1) : 0 }}%
                                                    </h3>
                                                    <p class="mb-0 small">CTR</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="card border-0 h-100 bg-gradient-warning text-white shadow-lg">
                                                <div class="card-body py-4">
                                                    <i
                                                        class="fas fa-toggle-{{ $website->is_active ? 'on' : 'off' }} fa-2x mb-2 opacity-75"></i>
                                                    <h3 class="fw-bold mb-1">{{ $website->is_active ? 'ON' : 'OFF' }}</h3>
                                                    <p class="mb-0 small">Status</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Timeline Tab --}}
                                <div class="tab-pane fade" id="timeline" role="tabpanel">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <label class="form-label fw-bold text-dark mb-2">Schedule</label>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <div
                                                        class="d-flex align-items-center gap-3 p-3 bg-info bg-opacity-10 border rounded-3">
                                                        <div class="bg-info bg-opacity-25 p-3 rounded-circle d-flex align-items-center justify-content-center text-info fw-bold fs-6"
                                                            style="width: 50px; height: 50px;">
                                                            {{ $website->start_at ? $website->start_at->format('D') : '?' }}
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-semibold">Start Date</h6>
                                                            <p class="mb-0 text-muted small">
                                                                {{ $website->start_at ? $website->start_at->format('d M Y, h:i A') : 'Not Set' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div
                                                        class="d-flex align-items-center gap-3 p-3 bg-danger bg-opacity-10 border rounded-3">
                                                        <div class="bg-danger bg-opacity-25 p-3 rounded-circle d-flex align-items-center justify-content-center text-danger fw-bold fs-6"
                                                            style="width: 50px; height: 50px;">
                                                            {{ $website->end_at ? $website->end_at->format('D') : '?' }}
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-semibold">End Date</h6>
                                                            <p class="mb-0 text-muted small">
                                                                {{ $website->end_at ? $website->end_at->format('d M Y, h:i A') : 'Not Set' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label fw-bold text-dark mb-2">Activity</label>
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <div class="p-3 bg-light border rounded-3 text-center">
                                                        <span
                                                            class="fs-5 fw-bold text-success">{{ $website->created_at ? $website->created_at->diffForHumans() : 'N/A' }}</span>
                                                        <p class="mb-0 text-muted small">Created</p>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="p-3 bg-light border rounded-3 text-center">
                                                        <span
                                                            class="fs-5 fw-bold text-primary">{{ $website->updated_at ? $website->updated_at->diffForHumans() : 'N/A' }}</span>
                                                        <p class="mb-0 text-muted small">Updated</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($website->metadata)
                                            <div class="col-12">
                                                <label class="form-label fw-bold text-dark mb-2">Metadata</label>
                                                <div class="bg-dark text-white p-4 rounded-3"
                                                    style="font-size: 0.875rem; max-height: 300px; overflow-y: auto;">
                                                    <pre class="mb-0">{{ json_encode($website->metadata, JSON_PRETTY_PRINT) }}</pre>
                                                </div>
                                            </div>
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

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .border-dashed {
            border-style: dashed !important;
        }
    </style>
@endsection
