@extends('e-commerce/layouts/master')

@section('content')

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Collections</h4>
            </div>
            <div class="text-end">
                <a href="{{ route('collection.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Add Collection
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Collections List</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <table id="responsive-datatable" class="table table-striped table-borderless dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Collection Name</th>
                                    <th>Categories Count</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($collections as $index => $collection)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($collection->image)
                                                <img src="{{ asset($collection->image) }}" alt="{{ $collection->title }}"
                                                     class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('images/default-collection.png') }}" alt="Default"
                                                     class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                            @endif
                                        </td>
                                        <td>{{ $collection->title }}</td>
                                        <td>
                                            <span class="badge bg-info-subtle text-info">
                                                {{ $collection->categories->count() }} categories
                                            </span>
                                        </td>
                                        <td>
                                            @if($collection->status)
                                                <span class="badge bg-success-subtle text-success">Active</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a aria-label="anchor" href="{{ route('collection.edit', $collection->id) }}"
                                               class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                               data-bs-toggle="tooltip" data-bs-original-title="Edit Collection">
                                                <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                            </a>
                                            <form style="display: inline-block"
                                                  action="{{ route('collection.delete', $collection->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this collection?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" aria-label="Delete"
                                                        class="btn btn-icon btn-sm bg-danger-subtle"
                                                        data-bs-toggle="tooltip" data-bs-original-title="Delete Collection">
                                                    <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No collections found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

@endsection