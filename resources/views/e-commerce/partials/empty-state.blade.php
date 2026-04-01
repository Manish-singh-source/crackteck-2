@props([
    'icon' => 'fas fa-inbox',
    'title' => 'No Data Available',
    'message' => 'There is no data to display for this section.',
])

<div class="text-center py-5">
    <div class="mb-3">
        <div class="avatar-lg rounded-circle bg-light mx-auto d-flex align-items-center justify-content-center">
            <i class="{{ $icon }} fs-24 text-muted"></i>
        </div>
    </div>
    <h6 class="text-dark fw-semibold mb-1">{{ $title }}</h6>
    <p class="text-muted fs-13 mb-0">{{ $message }}</p>
</div>
