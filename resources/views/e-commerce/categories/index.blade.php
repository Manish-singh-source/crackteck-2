@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Categories List</h4>
                </div>
                <div>
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target=".attribute">Create
                        Parent Categories</button>
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                        data-bs-target=".attribute-value">Add Sub Categories</button>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="tab-content text-muted">
                                <ul class="nav nav-underline border-bottom" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" href="{{ route('category.index') }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi mdi-format-list-bulleted fs-16 me-1 text-primary"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i class="mdi mdi-format-list-bulleted fs-16 me-1 text-primary"></i>All
                                                Categories
                                            </span>
                                        </a>
                                    </li>
                                    {{-- Active Status Brands --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2"
                                            href="{{ route('category.index', ['status' => 'active']) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi mdi-check-circle-outline fs-16 me-1 text-success"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i class="mdi mdi-check-circle-outline fs-16 me-1 text-success"></i>Active
                                                Categories
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2"
                                            href="{{ route('category.index', ['status' => 'inactive']) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi mdi-close-circle-outline fs-16 me-1 text-danger"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i class="mdi mdi-close-circle-outline fs-16 me-1 text-danger"></i>Inactive
                                                Categories
                                            </span>
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2"
                                            href="{{ route('category.index', ['status_ecommerce' => 'active']) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi mdi-check-circle-outline fs-16 me-1 text-success"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i class="mdi mdi-check-circle-outline fs-16 me-1 text-success"></i>Active
                                                on E-commerce
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2"
                                            href="{{ route('category.index', ['status_ecommerce' => 'inactive']) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi mdi-close-circle-outline fs-16 me-1 text-danger"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i class="mdi mdi-close-circle-outline fs-16 me-1 text-danger"></i>Inactive
                                                on E-commerce
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
                                                            <th>Category Image</th>
                                                            <th>Category Name</th>
                                                            <th>E-commerce Status</th>
                                                            <th>General Status</th>
                                                            <th>Sort Order</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($parentCategorie as $category)
                                                            <tr data-category-id="{{ $category->id }}">
                                                                <td>{{ $category->id }}</td>
                                                                <td>
                                                                    @if ($category->image)
                                                                        <img src="{{ asset($category->image) }}"
                                                                            alt="{{ $category->name }}"
                                                                            style="width: 50px; height: 50px; object-fit: cover;"
                                                                            class="rounded">
                                                                    @else
                                                                        <img src="https://placehold.co/50x50"
                                                                            alt="{{ $category->name }}"
                                                                            style="width: 50px; height: 50px; object-fit: cover;"
                                                                            class="rounded">
                                                                    @endif
                                                                </td>
                                                                <td>{{ $category->name }}</td>
                                                                <td>
                                                                    <span
                                                                        class="badge fw-semibold {{ $category->status_ecommerce === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                                                        {{ $category->status_ecommerce == 'active' ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge fw-semibold {{ $category->status === 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                                        {{ $category->status == 'active' ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge bg-info-subtle text-info">{{ $category->sort_order }}</span>
                                                                </td>
                                                                <td>
                                                                    <a aria-label="anchor"
                                                                        href="{{ route('categorie.view', $category->id) }}"
                                                                        class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-original-title="View Child Categories">
                                                                        <i
                                                                            class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                    </a>
                                                                    <a aria-label="anchor"
                                                                        href="{{ route('category.edit', $category->id) }}"
                                                                        class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-original-title="Edit Parent Category">
                                                                        <i
                                                                            class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                    </a>
                                                                    <form style="display: inline-block"
                                                                        action="{{ route('category.delete', $category->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Are you sure you want to delete this category and all its sub-categories?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Delete Category"><i
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade attribute" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Add Parent Categories</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{ route('parent.category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="mx-3 py-3">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    @include('components.form.input', [
                                        'label' => 'Category Name',
                                        'name' => 'name',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Category Name',
                                        'required' => true,
                                    ])
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="image" class="form-label">Category Image <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="image" name="image"
                                        accept="image/*" required>
                                    <small class="text-muted">Upload category image (JPEG, PNG, JPG, GIF -
                                        Max: 2MB)</small>
                                </div>
                                
                                <div class="mb-3 col-6">
                                    @include('components.form.select', [
                                        'label' => 'General Status',
                                        'name' => 'status',
                                        'value' => 'active',
                                        'options' => [
                                            'inactive' => 'Inactive',
                                            'active' => 'Active',
                                        ],
                                        'required' => true,
                                    ])
                                </div>

                                <div class="mb-3 col-6">
                                    @include('components.form.select', [
                                        'label' => 'Show on E-commerce Website',
                                        'name' => 'status_ecommerce',
                                        'value' => 'active',
                                        'options' => [
                                            'inactive' => 'Inactive',
                                            'active' => 'Active',
                                        ],
                                        'required' => true,
                                    ])
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-md btn-success" id="addParentCategory">Add
                            Parent</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade attribute-value" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Add Sub Categories</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{ route('sub.category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row mx-2 py-3">
                            <div class="mb-3 col-6">
                                @include('components.form.select', [
                                    'label' => 'Parent Name',
                                    'name' => 'parent_category_id',
                                    'options' =>
                                        ['' => 'Select Attribute'] +
                                        $parentCategorie->pluck('name', 'id')->toArray(),
                                    'model' => old('parent_category_id', $attribute->parent_category_id ?? null),
                                ])
                            </div>

                            <div class="mb-3 col-6">
                                @include('components.form.input', [
                                    'label' => 'Sub Categorie',
                                    'name' => 'name',
                                    'type' => 'text',
                                    'placeholder' => 'Enter Sub Categorie',
                                ])
                            </div>

                            <div class="mb-3 col-6">
                                <div class="">
                                    @include('components.form.input', [
                                        'label' => 'Feature Image',
                                        'name' => 'image',
                                        'type' => 'file',
                                    ])
                                </div>
                            </div>

                            <div class="mb-3 col-6">
                                <div class="">
                                    @include('components.form.input', [
                                        'label' => 'Icon Image',
                                        'name' => 'icon_image',
                                        'type' => 'file',
                                    ])
                                </div>
                            </div>

                            <div class="mb-3 col-6">
                                @include('components.form.select', [
                                    'label' => 'General Status',
                                    'name' => 'status',
                                    'value' => 'active',
                                    'options' => [
                                        'inactive' => 'Inactive',
                                        'active' => 'Active',
                                    ],
                                    'required' => true,
                                ])
                            </div>

                            <div class="mb-3 col-6">
                                @include('components.form.select', [
                                    'label' => 'Show on E-commerce Website',
                                    'name' => 'status_ecommerce',
                                    'value' => 'yes',
                                    'options' => [
                                        'no' => 'No',
                                        'yes' => 'Yes',
                                    ],
                                    'required' => true,
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-md btn-success">Add Sub Categorie</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Sort order editing is disabled on index page as per requirements
            // Sort order can only be modified from the edit page

            $('#sort_order').on('change', function() {
                let sortId = $('#sort_order').val();
                console.log(sortId);

                $.ajax({
                    url: '{{ route('category.check-sort-order') }}',
                    method: 'GET',
                    data: {
                        sort_order: sortId
                        // _token: '{{ csrf_token() }}' // Uncomment if POST request is needed
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.exists) {

                            $('#sort_order').val('');
                            $('#sort_order').focus();
                            $('#addParentCategory').prop('disabled', true);
                            $('#sort_order').parent().append(
                                '<small class="text-danger">Sort order value already exists. Please provide a unique value.</small>'
                            );

                        } else {
                            $('#addParentCategory').prop('disabled', false);
                            $('#sort_order').parent().find('.text-danger').remove();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching child category data:', xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
