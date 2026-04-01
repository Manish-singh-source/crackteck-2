@props([
    'title' => '',
    'value' => '',
    'change' => 0,
    'icon' => '',
    'iconBg' => 'primary',
    'suffix' => '',
    'prefix' => '',
    'subtitle' => 'vs last period',
])

@php
    $isPositive = $change >= 0;
    $changeColor = $isPositive ? 'success' : 'danger';
    $changeIcon = $isPositive ? 'mdi-trending-up' : 'mdi-trending-down';
@endphp

<div class="col-sm-6 col-xl-4 col-xxl-2">
    <div class="card card-animate border-0 shadow-sm h-100 overflow-hidden position-relative">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <div class="flex-shrink-0 me-3">
                    <div class="avatar-md rounded-3 bg-{{ $iconBg }}-subtle d-flex align-items-center justify-content-center">
                        <i class="{{ $icon }} fs-20 text-{{ $iconBg }}"></i>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <p class="text-muted mb-1 text-uppercase fw-medium fs-12 letter-spacing-0.5">{{ $title }}</p>
                    <h4 class="fw-bold mb-0 fs-22 text-dark">{{ $prefix }}{{ number_format((float)$value) }}{{ $suffix }}</h4>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-{{ $changeColor }}-subtle text-{{ $changeColor }} fs-12 fw-semibold rounded-pill px-2 py-1 me-2">
                    <i class="mdi {{ $changeIcon }} fs-14 me-1"></i>
                    {{ abs($change) }}%
                </span>
                <span class="text-muted fs-12">{{ $subtitle }}</span>
            </div>
        </div>
        <div class="position-absolute top-0 end-0 opacity-5">
            <i class="{{ $icon }} fs-80 text-{{ $iconBg }}"></i>
        </div>
    </div>
</div>
