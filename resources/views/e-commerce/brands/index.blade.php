@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Brand List</h4>
                </div>
                <div>
                    <a href="{{ route('brand.create') }}" class="btn btn-primary">Add New Brand</a>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="tab-content text-muted">
                                <ul class="nav nav-underline border-bottom" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" href="{{ route('brand.index') }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi mdi-format-list-bulleted fs-16 me-1 text-primary"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i class="mdi mdi-format-list-bulleted fs-16 me-1 text-primary"></i>All
                                                Brands
                                            </span>
                                        </a>
                                    </li>
                                    {{-- Active Status Brands --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" href="{{ route('brand.index', ['status' => 'active']) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi mdi-check-circle-outline fs-16 me-1 text-success"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i class="mdi mdi-check-circle-outline fs-16 me-1 text-success"></i>Active
                                                Brands
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" href="{{ route('brand.index', ['status' => 'inactive']) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi mdi-close-circle-outline fs-16 me-1 text-danger"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i class="mdi mdi-close-circle-outline fs-16 me-1 text-danger"></i>Inactive
                                                Brands
                                            </span>
                                        </a>
                                    </li>
                                    
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" href="{{ route('brand.index', ['status_ecommerce' => 'active']) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi mdi-check-circle-outline fs-16 me-1 text-success"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i class="mdi mdi-check-circle-outline fs-16 me-1 text-success"></i>Active on E-commerce
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" href="{{ route('brand.index', ['status_ecommerce' => 'inactive']) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi mdi-close-circle-outline fs-16 me-1 text-danger"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i class="mdi mdi-close-circle-outline fs-16 me-1 text-danger"></i>Inactive on E-commerce
                                            </span>
                                        </a>
                                    </li>

                                </ul>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Name</th>
                                                            <th>Slug</th>
                                                            <th>Image</th>
                                                            <th>E-commerce Status</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($brand as $brand)
                                                            <tr>
                                                                <td>{{ $brand->id }}</td>
                                                                <td>{{ $brand->name }}</td>
                                                                <td>{{ $brand->slug }}</td>
                                                                <td>
                                                                    @if ($brand->image)
                                                                        <img src="{{ asset($brand->image) }}"
                                                                            alt="{{ $brand->name }}"
                                                                            style="width: 50px; height: 50px; object-fit: cover;"
                                                                            class="rounded">
                                                                    @else
                                                                        <span class="text-muted">No Image</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge fw-semibold {{ $brand->status_ecommerce === 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                                        {{ $brand->status_ecommerce == 'active' ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge fw-semibold {{ $brand->status === 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                                        {{ $brand->status == 'active' ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a aria-label="anchor"
                                                                        href="{{ route('brand.edit', $brand->id) }}"
                                                                        class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-original-title="Edit">
                                                                        <i
                                                                            class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                    </a>
                                                                    <form style="display: inline-block"
                                                                        action="{{ route('brand.delete', $brand->id) }}"
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
