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
                                                @if(session('success'))
                                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        {{ session('success') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                    </div>
                                                @endif
                                                @if(session('error'))
                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                        {{ session('error') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                    </div>
                                                @endif

                                                <table id="banner-table" class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">Sr No</th>
                                                            <th width="10%">Image</th>
                                                            <th width="10%">Title</th>
                                                            <th width="15%">Description</th>
                                                            <th width="8%">Type</th>
                                                            <th width="8%">Channel</th>
                                                            <th width="8%">Position</th>
                                                            <th width="10%">Start Date</th>
                                                            <th width="10%">End Date</th>
                                                            <th width="8%">Status</th>
                                                            <th width="17%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($website as $index => $banner)
                                                            <tr>
                                                                <td>{{ ($website->currentPage() - 1) * $website->perPage() + $index + 1 }}</td>
                                                                <td>
                                                                    <img src="{{ $banner->image_url ? asset($banner->image_url) : asset('images/default-banner.png') }}"
                                                                        alt="Banner Image"
                                                                        style="width: 80px; height: 50px; object-fit: cover;"
                                                                        class="img-thumbnail">
                                                                </td>
                                                                <td><strong>{{ $banner->title }}</strong></td>
                                                                <td>
                                                                    <div style="max-width:200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                                                         title="{{ $banner->description }}">
                                                                        {{ $banner->description ?: 'N/A' }}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="badge bg-{{ $banner->type == 0 ? 'info' : 'warning' }}-subtle text-{{ $banner->type == 0 ? 'info' : 'warning' }}">
                                                                        {{ $banner->type == 0 ? 'Website' : 'Promotional' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge bg-secondary-subtle text-secondary">
                                                                        {{ $banner->channel == 0 ? 'Website' : 'Mobile' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $positions = ['Homepage', 'Category', 'Product', 'Slider', 'Checkout', 'Cart'];
                                                                    @endphp
                                                                    <span class="badge bg-primary-subtle text-primary">
                                                                        {{ $positions[$banner->position] ?? 'N/A' }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $banner->start_at ? $banner->start_at->format('d M Y') : 'N/A' }}</td>
                                                                <td>{{ $banner->end_at ? $banner->end_at->format('d M Y') : 'N/A' }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $banner->is_active ? 'success' : 'danger' }}-subtle text-{{ $banner->is_active ? 'success' : 'danger' }}">
                                                                        {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('website.banner.show', $banner->id) }}"
                                                                        class="btn btn-icon btn-sm bg-info-subtle me-1"
                                                                        data-bs-toggle="tooltip"
                                                                        title="View">
                                                                        <i class="mdi mdi-eye-outline fs-14 text-info"></i>
                                                                    </a>
                                                                    <a href="{{ route('website.banner.edit', $banner->id) }}"
                                                                        class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                        data-bs-toggle="tooltip"
                                                                        title="Edit">
                                                                        <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                    </a>
                                                                    <form style="display: inline-block"
                                                                        action="{{ route('website.banner.delete', $banner->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle"
                                                                            data-bs-toggle="tooltip"
                                                                            title="Delete">
                                                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="11" class="text-center text-muted py-4">No banners found</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>

                                                <!-- Pagination -->
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <div>
                                                        Showing {{ $website->firstItem() ?? 0 }} to {{ $website->lastItem() ?? 0 }} of {{ $website->total() }} entries
                                                    </div>
                                                    <div>
                                                        {{ $website->links() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


