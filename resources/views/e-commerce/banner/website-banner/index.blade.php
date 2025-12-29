@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Banner List</h4>
                </div>
                <div>
                    <a href="{{ route('website.banner.create') }}" class="btn btn-primary">Add New Banner</a>
                    <!-- <button class="btn btn-primary">Add New Brand</button> -->
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="tab-content text-muted">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <div class="alert alert-info">
                                                    <i class="mdi mdi-information"></i>
                                                    <strong>Drag & Drop:</strong> You can drag and drop rows to reorder banners. The new order will be saved automatically.
                                                </div>

                                                <table id="banner-table" class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">
                                                                <i class="mdi mdi-drag-horizontal text-muted" title="Drag to reorder"></i>
                                                            </th>
                                                            <th width="8%">Sr No</th>
                                                            <th width="10%">Banner Image</th>
                                                            <th width="15%">Banner Heading</th>
                                                            <th width="15%">Banner Sub Heading</th>
                                                            <th width="20%">Description</th>
                                                            <th width="10%">Button Text</th>
                                                            <th width="10%">Button URL</th>
                                                            <th width="8%">Status</th>
                                                            <th width="12%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="sortable-banners">
                                                        @foreach ($website as $index => $banner)
                                                            <tr data-id="{{ $banner->id }}" class="sortable-row">
                                                                <td class="drag-handle" style="cursor: move;">
                                                                    <i class="mdi mdi-drag-horizontal text-muted"></i>
                                                                </td>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>
                                                                    <div class="profile-section-image">
                                                                        <img src="{{ $banner->website_banner ? asset($banner->website_banner) : asset('images/default-profile.png') }}"
                                                                            alt="Banner Image"
                                                                            style="width: 60px; height: 40px; object-fit: cover;"
                                                                            class="img-thumbnail">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <strong>{{ $banner->banner_heading ?: 'N/A' }}</strong>
                                                                </td>
                                                                <td>
                                                                    {{ $banner->banner_sub_heading ?: 'N/A' }}
                                                                </td>
                                                                <td>
                                                                    <div style="max-width:200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                                                         title="{{ $banner->banner_description }}">
                                                                        {{ $banner->banner_description }}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="badge bg-primary-subtle text-primary">
                                                                        {{ $banner->button_text ?: 'N/A' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    @if($banner->banner_url)
                                                                        <a href="{{ $banner->banner_url }}" target="_blank" class="text-decoration-none">
                                                                            <i class="mdi mdi-open-in-new"></i> Link
                                                                        </a>
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span class="badge bg-{{ $banner->status == '1' ? 'success' : 'danger' }}-subtle text-{{ $banner->status == '1' ? 'success' : 'danger' }} fw-semibold">
                                                                        {{ ucfirst($banner->status) == '1' ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a aria-label="anchor"
                                                                        href="{{ route('website.banner.edit', $banner->id) }}"
                                                                        class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-original-title="Edit">
                                                                        <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                    </a>
                                                                    <form style="display: inline-block"
                                                                        action="{{ route('website.banner.delete', $banner->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Delete">
                                                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- Tab panes -->
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortableElement = document.getElementById('sortable-banners');

    if (sortableElement) {
        const sortable = Sortable.create(sortableElement, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                // Get the new order of banner IDs
                const bannerIds = Array.from(sortableElement.children).map(row => {
                    return row.getAttribute('data-id');
                });

                // Update sort order via AJAX
                updateBannerSortOrder(bannerIds);

                // Update the Sr No column
                updateSerialNumbers();
            }
        });
    }

    function updateBannerSortOrder(bannerIds) {
        fetch('{{ route("website.banner.update-sort-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                banner_ids: bannerIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showToast('success', 'Banner order updated successfully!');
            } else {
                // Show error message
                showToast('error', data.message || 'Failed to update banner order');
                // Optionally reload the page to restore original order
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'An error occurred while updating banner order');
            // Optionally reload the page to restore original order
            location.reload();
        });
    }

    function updateSerialNumbers() {
        const rows = document.querySelectorAll('#sortable-banners tr');
        rows.forEach((row, index) => {
            const srNoCell = row.children[1]; // Second column (Sr No)
            srNoCell.textContent = index + 1;
        });
    }

    function showToast(type, message) {
        // Create a simple toast notification
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(toast);

        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 3000);
    }
});
</script>

<style>
.sortable-ghost {
    opacity: 0.4;
}

.sortable-chosen {
    background-color: #f8f9fa;
}

.sortable-drag {
    background-color: #ffffff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.drag-handle:hover {
    background-color: #f8f9fa;
    border-radius: 4px;
}

#banner-table tbody tr {
    transition: all 0.2s ease;
}

#banner-table tbody tr:hover {
    background-color: #f8f9fa;
}
</style>
@endpush
