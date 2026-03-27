@extends('e-commerce/layouts/master')

@section('title', 'Order Feedback Management')

@section('content')
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row my-3">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Order Feedback Management</h4>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-2    ">
            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Feedback</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="{{ $feedbacks->total() }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-primary-subtle">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="font-size-20 bx bx-comment-detail"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Active Feedback</span>
                                <h4 class="mb-3">
                                    <span class="counter-value"
                                        data-target="{{ \App\Models\OrderFeedback::where('status', 'active')->count() }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-success-subtle">
                                    <span class="avatar-title rounded-circle bg-success">
                                        <i class="font-size-20 bx bx-check-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Inactive Feedback</span>
                                <h4 class="mb-3">
                                    <span class="counter-value"
                                        data-target="{{ \App\Models\OrderFeedback::where('status', 'inactive')->count() }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-warning-subtle">
                                    <span class="avatar-title rounded-circle bg-warning">
                                        <i class="font-size-20 bx bx-time-five"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Average Rating</span>
                                <h4 class="mb-3">
                                    <span class="counter-value"
                                        data-target="{{ round(\App\Models\OrderFeedback::avg('star'), 1) }}">0</span>
                                    <small class="text-muted">/ 5</small>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-info-subtle">
                                    <span class="avatar-title rounded-circle bg-info">
                                        <i class="font-size-20 bx bx-star"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feedback List -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Order #</th>
                                        <th>Product</th>
                                        <th>Customer</th>
                                        <th>Rating</th>
                                        <th>Feedback</th>
                                        <th>Media</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($feedbacks as $feedback)
                                        <tr>
                                            <td>{{ $feedback->id }}</td>
                                            <td>
                                                <a href="{{ route('order.view', $feedback->order_id) }}" target="_blank">
                                                    {{ $feedback->order->order_number ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if (
                                                        $feedback->product &&
                                                            $feedback->product->warehouseProduct &&
                                                            $feedback->product->warehouseProduct->main_product_image)
                                                        <img src="{{ asset($feedback->product->warehouseProduct->main_product_image) }}"
                                                            alt="{{ $feedback->product->warehouseProduct->product_name ?? 'Product' }}"
                                                            class="rounded me-2" width="40" height="40"
                                                            style="object-fit: cover;">
                                                    @endif
                                                    <span>{{ $feedback->product->warehouseProduct->product_name ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $feedback->customer->first_name ?? '' }}
                                                        {{ $feedback->customer->last_name ?? '' }}</strong>
                                                    <br>
                                                    <small
                                                        class="text-muted">{{ $feedback->customer->email ?? '' }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-warning">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $feedback->star)
                                                            <i class="bx bxs-star"></i>
                                                        @else
                                                            <i class="bx bx-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <small class="text-muted">({{ $feedback->star }}/5)</small>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;"
                                                    title="{{ $feedback->feedback }}">
                                                    {{ $feedback->feedback ?: 'No text feedback' }}
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $mediaItems = is_array($feedback->media ?? null) ? $feedback->media : [];
                                                    $previewMedia = array_slice($mediaItems, 0, 3);
                                                @endphp
                                                @if (count($mediaItems) > 0)
                                                    <div class="d-flex gap-1">
                                                        @foreach ($previewMedia as $media)
                                                            @if (($media['file_type'] ?? '') === 'image' && !empty($media['file_path']))
                                                                <a href="{{ asset($media['file_path']) }}" target="_blank">
                                                                    <img src="{{ asset($media['file_path']) }}"
                                                                        alt="Feedback media" class="rounded" width="40"
                                                                        height="40" style="object-fit: cover;">
                                                                </a>
                                                            @elseif(($media['file_type'] ?? '') === 'video' && !empty($media['file_path']))
                                                                <a href="{{ asset($media['file_path']) }}" target="_blank"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                    <i class="bx bx-video"></i>
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                        @if (count($mediaItems) > 3)
                                                            <span class="badge bg-secondary">+{{ count($mediaItems) - 3 }}</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">No media</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $feedback->status_badge_color }}">
                                                    {{ $feedback->status_display_name }}
                                                </span>
                                            </td>
                                            <td>{{ $feedback->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a aria-label="anchor"
                                                        href="{{ route('order-feedback.edit', $feedback->id) }}"
                                                        class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                        data-bs-toggle="tooltip" data-bs-original-title="View">
                                                        <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                    </a>
                                                    <button aria-label="anchor" type="button"
                                                        class="btn btn-icon btn-sm bg-danger-subtle delete-product"
                                                        data-product-id="{{ $feedback->id }}" data-bs-toggle="tooltip"
                                                        data-bs-original-title="Delete">
                                                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="bx bx-comment-detail font-size-48 mb-3 d-block"></i>
                                                    No feedback found.
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($feedbacks->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $feedbacks->withQueryString()->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this feedback? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
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

            // Toggle Status
            document.querySelectorAll('.toggle-status-btn').forEach(function(btn) {
                btn.addEventListener('click', async function() {
                    const id = this.dataset.id;
                    const originalHtml = this.innerHTML;

                    this.disabled = true;
                    this.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>';

                    try {
                        const response = await fetch(
                            `/demo/e-commerce/order-feedback/${id}/toggle-status`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                },
                            });

                        const data = await response.json();

                        if (data.success) {
                            // Reload page to show updated status
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to update status.');
                            this.innerHTML = originalHtml;
                            this.disabled = false;
                        }
                    } catch (error) {
                        alert('An error occurred while updating status.');
                        this.innerHTML = originalHtml;
                        this.disabled = false;
                    }
                });
            });

            // Delete Feedback
            document.querySelectorAll('.delete-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const deleteForm = document.getElementById('deleteForm');
                    deleteForm.action = `/demo/e-commerce/order-feedback/${id}`;

                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();
                });
            });
        });
    </script>
@endsection
