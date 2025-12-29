@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Promotional Banner List</h4>
                </div>
                <div>
                    <a href="{{ route('promotional.banner.create') }}" class="btn btn-primary">Add New Banner</a>
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
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Image</th>
                                                            <th>Title</th>
                                                            <th>Description</th>
                                                            <th>Start Date/Time</th>
                                                            <th>End Date/Time</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($promotionalBanner as $promotionalBanner)
                                                            <tr>
                                                                <td>{{ $promotionalBanner->id }}</td>
                                                                <td>
                                                                    <div class="profile-section-image">
                                                                        <img src={{ $promotionalBanner->promotional_banner ? asset($promotionalBanner->promotional_banner) : asset('images/default-profile.png') }}
                                                                            alt="Banner Image" style="width: 80px"
                                                                            class="img-thumbnail">
                                                                    </div>
                                                                </td>
                                                                <td>{{ $promotionalBanner->banner_title }}</td>
                                                                <td>
                                                                    <div
                                                                        style="max-width:500px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                                        {{ $promotionalBanner->banner_description }}
                                                                    </div>
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($promotionalBanner->start_datetime)->format('Y-m-d h:i A') }}
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($promotionalBanner->end_datetime)->format('Y-m-d h:i A') }}
                                                                </td>

                                                                <td>
                                                                    <span
                                                                        class="badge bg-{{ $promotionalBanner->status == 'Active' ? 'success' : 'danger' }}-subtle text-{{ $promotionalBanner->status == 'Active' ? 'success' : 'danger' }} fw-semibold">
                                                                        {{ ucfirst($promotionalBanner->status) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a aria-label="Edit"
                                                                        href="{{ route('promotional.banner.edit', $promotionalBanner->id) }}"
                                                                        class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-original-title="Edit">
                                                                        <i
                                                                            class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                    </a>
                                                                    <form style="display: inline-block"
                                                                        action="{{ route('promotional.banner.delete', $promotionalBanner->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Are you sure?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Delete"><i
                                                                                class="mdi mdi-delete fs-14 text-danger"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <!-- Repeat for more banners -->
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
