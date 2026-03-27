@extends('e-commerce/layouts/master')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Order Feedback</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('order-feedback.update', $feedback->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-header">
                            <h5 class="card-title mb-0">Feedback Details</h5>
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
                                <!-- Order Information -->
                                <div class="col-lg-3">
                                    <label class="form-label">Order Number</label>
                                    <p class="form-control-plaintext">
                                        <a href="{{ route('order.view', $feedback->order_id) }}" target="_blank">
                                            {{ $feedback->order->order_number ?? 'N/A' }}
                                        </a>
                                    </p>
                                </div>

                                <div class="col-lg-3">
                                    <label class="form-label">Order Date</label>
                                    <p class="form-control-plaintext">
                                        {{ $feedback->order->created_at->format('F j, Y') ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="col-lg-3">
                                    <label class="form-label">Product Name</label>
                                    <p class="form-control-plaintext">
                                        {{ $feedback->product->warehouseProduct->product_name ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="col-lg-3">
                                    <label class="form-label">Product SKU</label>
                                    <p class="form-control-plaintext">
                                        {{ $feedback->product->warehouseProduct->sku ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="col-lg-3">
                                    <label class="form-label">Customer Name</label>
                                    <p class="form-control-plaintext">
                                        {{ $feedback->customer->first_name ?? '' }} {{ $feedback->customer->last_name ?? '' }}
                                    </p>
                                </div>

                                <div class="col-lg-3">
                                    <label class="form-label">Customer Email</label>
                                    <p class="form-control-plaintext">
                                        {{ $feedback->customer->email ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="col-lg-3">
                                    <label class="form-label">Star Rating</label>
                                    <div class="text-warning fs-4">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $feedback->star)
                                                <i class="bx bxs-star"></i>
                                            @else
                                                <i class="bx bx-star"></i>
                                            @endif
                                        @endfor
                                        <span class="text-muted ms-2">({{ $feedback->star }}/5)</span>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label class="form-label">Feedback ID</label>
                                    <p class="form-control-plaintext">{{ $feedback->id }}</p>
                                </div>

                                <!-- Feedback Text -->
                                <div class="col-12">
                                    <label for="feedback" class="form-label">Feedback Text</label>
                                    <textarea class="form-control @error('feedback') is-invalid @enderror" 
                                              id="feedback" 
                                              name="feedback" 
                                              rows="5" 
                                              maxlength="5000">{{ old('feedback', $feedback->feedback) }}</textarea>
                                    @error('feedback')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Maximum 5000 characters</small>
                                </div>

                                <!-- Status -->
                                <div class="col-lg-3">
                                    <label for="status" class="form-label">Feedback Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status">
                                        <option value="inactive" {{ old('status', $feedback->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="active" {{ old('status', $feedback->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        <strong>Active:</strong> Visible on product page.<br>
                                        <strong>Inactive:</strong> Hidden from product page.
                                    </small>
                                </div>

                                <!-- Media Files -->
                                <div class="col-12">
                                    <label class="form-label">Media Files</label>
                                    @php
                                        $mediaItems = is_array($feedback->media ?? null) ? $feedback->media : [];
                                    @endphp
                                    @if(count($mediaItems) > 0)
                                        <div class="row g-3">
                                            @foreach($mediaItems as $index => $media)
                                                <div class="col-6 col-md-4 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body p-2">
                                                            @if(($media['file_type'] ?? '') === 'image' && !empty($media['file_path']))
                                                                <a href="{{ asset($media['file_path']) }}" target="_blank">
                                                                    <img src="{{ asset($media['file_path']) }}" 
                                                                         alt="Feedback media" 
                                                                         class="img-fluid rounded mb-2"
                                                                         style="width: 100%; height: 120px; object-fit: cover;">
                                                                </a>
                                                            @elseif(($media['file_type'] ?? '') === 'video' && !empty($media['file_path']))
                                                                <div class="ratio ratio-16x9 mb-2">
                                                                    <video controls class="rounded">
                                                                        <source src="{{ asset($media['file_path']) }}" type="video/mp4">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                </div>
                                                            @endif
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <small class="text-muted text-truncate" style="max-width: 80px;">
                                                                    {{ $media['original_name'] ?? 'media-file' }}
                                                                </small>
                                                                <button type="button" 
                                                                        class="btn btn-sm btn-danger delete-media-btn"
                                                                        data-feedback-id="{{ $feedback->id }}"
                                                                        data-media-index="{{ $index }}"
                                                                        title="Delete media">
                                                                    <i class="bx bx-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center text-muted py-4">
                                            <i class="bx bx-image font-size-48 mb-3 d-block"></i>
                                            <p>No media files attached to this feedback.</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Metadata -->
                                <div class="col-lg-3">
                                    <label class="form-label">Submitted</label>
                                    <p class="form-control-plaintext">{{ $feedback->created_at->format('F j, Y g:i A') }}</p>
                                </div>

                                <div class="col-lg-3">
                                    <label class="form-label">Last Updated</label>
                                    <p class="form-control-plaintext">{{ $feedback->updated_at->format('F j, Y g:i A') }}</p>
                                </div>

                                @if($feedback->deleted_at)
                                    <div class="col-lg-3">
                                        <label class="form-label">Deleted</label>
                                        <p class="form-control-plaintext">{{ $feedback->deleted_at->format('F j, Y g:i A') }}</p>
                                    </div>
                                @endif

                                <!-- Submit -->
                                <div class="col-12 text-start mt-4">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">
                                        <i class="ri-save-line me-1"></i>
                                        Update Feedback
                                    </button>
                                    <a href="{{ route('order-feedback.index') }}" class="btn btn-secondary waves-effect ms-2">
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

<!-- CSRF Token for AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Delete Media
            document.querySelectorAll('.delete-media-btn').forEach(function(btn) {
                btn.addEventListener('click', async function() {
                    if (!confirm('Are you sure you want to delete this media file?')) {
                        return;
                    }

                    const feedbackId = this.dataset.feedbackId;
                    const mediaIndex = this.dataset.mediaIndex;
                    const originalHtml = this.innerHTML;
                    
                    this.disabled = true;
                    this.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>';

                    try {
                        const response = await fetch(`/demo/e-commerce/order-feedback/${feedbackId}/media/${mediaIndex}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Remove the media card from DOM
                            const mediaCard = this.closest('.col-lg-3');
                            if (mediaCard) {
                                mediaCard.remove();
                            }
                            
                            // Check if no media left
                            const mediaContainer = document.querySelector('.row.g-3');
                            if (mediaContainer && mediaContainer.children.length === 0) {
                                mediaContainer.innerHTML = `
                                    <div class="col-12 text-center text-muted py-4">
                                        <i class="bx bx-image font-size-48 mb-3 d-block"></i>
                                        <p>No media files attached to this feedback.</p>
                                    </div>
                                `;
                            }
                        } else {
                            alert(data.message || 'Failed to delete media.');
                            this.innerHTML = originalHtml;
                            this.disabled = false;
                        }
                    } catch (error) {
                        alert('An error occurred while deleting media.');
                        this.innerHTML = originalHtml;
                        this.disabled = false;
                    }
                });
            });
        });
    </script>
@endsection
