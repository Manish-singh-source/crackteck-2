@props([
    'title' => '',
    'subtitle' => '',
    'icon' => '',
    'noPadding' => false,
    'headerClass' => '',
    'bodyClass' => '',
    'id' => '',
])

<div class="card border-0 shadow-sm h-100" {{ $id ? "id=$id" : '' }}>
    <div class="card-header bg-white border-0 pt-3 pb-0 {{ $headerClass }}">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                @if($icon)
                <div class="avatar-sm rounded-2 bg-primary-subtle me-2 d-flex align-items-center justify-content-center">
                    <i class="{{ $icon }} text-primary fs-16"></i>
                </div>
                @endif
                <div>
                    <h5 class="card-title mb-0 fs-16 fw-semibold">{{ $title }}</h5>
                    @if($subtitle)
                    <p class="text-muted fs-12 mb-0 mt-1">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
            <div>
                {{ $actions ?? '' }}
            </div>
        </div>
    </div>
    <div class="card-body {{ $noPadding ? 'p-0' : 'pt-3' }} {{ $bodyClass }}">
        {{ $slot }}
    </div>
</div>
