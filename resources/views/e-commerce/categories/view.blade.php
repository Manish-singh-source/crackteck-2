@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">


        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">{{ $parentCategorie->name }} Categorie</h4>
                </div>
                <div>
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target=".attribute-value">Add
                        Sub Categories</button>

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
                                <form action="{{ route('sub.category.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="modal-body">
                                        <div class="row mx-2 py-3">
                                            <div class="mb-3 col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Parent Name',
                                                    'name' => 'parent_category_id',
                                                    'type' => 'text',
                                                    // 'value' => $parentCategorie->name,
                                                    'readonly' => true,
                                                    'model' => $parentCategorie,
                                                    'options' => [
                                                        $parentCategorie->id => $parentCategorie->name,
                                                    ],
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
                                        <button type="button" class="btn btn-md btn-danger"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-md btn-success">Add Sub Categorie</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade attribute-value-edit" tabindex="-1" role="dialog"
                        aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title">Edit Sub Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <form id="editChildCategoryForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- hidden parent id for submit --}}
                                    <input type="hidden" name="parent_category_id" id="edit_parent_category_id"
                                        value="{{ $parentCategorie->id }}">

                                    <div class="modal-body">
                                        <div class="row mx-2 py-3">

                                            {{-- Parent Name (disabled select) --}}
                                            <div class="mb-3 col-6">
                                                <label for="edit_parent_category_select" class="form-label">Parent
                                                    Name</label>
                                                <select class="form-select" id="edit_parent_category_select" disabled>
                                                    <option value="{{ $parentCategorie->id }}" selected>
                                                        {{ $parentCategorie->name }}
                                                    </option>
                                                </select>
                                            </div>

                                            {{-- Sub Category Name --}}
                                            <div class="mb-3 col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Sub Categorie',
                                                    'name' => 'name',
                                                    'type' => 'text',
                                                    // 'model' => $subCategories->name,
                                                    'required' => true,
                                                ])
                                            </div>

                                            {{-- Feature Image --}}
                                            <div class="mb-3 col-6">
                                                <label for="edit_image" class="form-label">Feature Image</label>
                                                <input type="file" name="image" id="edit_image" class="form-control">
                                                <div id="current_feature_image" class="mt-2"></div>
                                            </div>

                                            {{-- Icon Image --}}
                                            <div class="mb-3 col-6">
                                                <label for="edit_icon_image" class="form-label">Icon Image</label>
                                                <input type="file" name="icon_image" id="edit_icon_image"
                                                    class="form-control">
                                                <div id="current_icon_image" class="mt-2"></div>
                                            </div>

                                            {{-- General Status --}}
                                            <div class="mb-3 col-6">
                                                <label for="edit_status" class="form-label">General Status</label>
                                                <select name="status" id="edit_status" class="form-select">
                                                    <option value="inactive">Inactive</option>
                                                    <option value="active">Active</option>
                                                </select>
                                            </div>

                                            {{-- E‑commerce Status --}}
                                            <div class="mb-3 col-6">
                                                <label for="edit_status_ecommerce" class="form-label">Show on E-commerce
                                                    Website</label>
                                                <select name="status_ecommerce" id="edit_status_ecommerce"
                                                    class="form-select">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-md btn-danger"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-md btn-success">Update Sub
                                            Categorie</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
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
                                                            <th>Icon Image</th>
                                                            <th>Sub Categorie Value</th>
                                                            <th>General Status</th>
                                                            <th>E-commerce Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($subCategories as $subCategory)
                                                            <tr>
                                                                <td>{{ $subCategory->id }}</td>
                                                                <td>
                                                                    @if ($subCategory->image)
                                                                        <img src="{{ asset($subCategory->image) }}"
                                                                            alt="{{ $subCategory->name }}"
                                                                            style="width: 50px; height: 50px; object-fit: cover;"
                                                                            class="rounded">
                                                                    @else
                                                                        <span class="text-muted">No Image</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($subCategory->icon_image)
                                                                        <img src="{{ asset($subCategory->icon_image) }}"
                                                                            alt="{{ $subCategory->name }}"
                                                                            style="width: 50px; height: 50px; object-fit: cover;"
                                                                            class="rounded">
                                                                    @else
                                                                        <span class="text-muted">No Image</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $subCategory->name }}</td>
                                                                <td>
                                                                    <span
                                                                        class="badge fw-semibold {{ $subCategory->status === 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                                        {{ $subCategory->status == 'active' ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge fw-semibold {{ $subCategory->status_ecommerce === 'yes' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                                        {{ $subCategory->status_ecommerce == 'yes' ? 'Yes' : 'No' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-warning btn-sm me-1"
                                                                        onclick="editChildCategory({{ $subCategory->id }})"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target=".attribute-value-edit">
                                                                        <i class="mdi mdi-pencil-outline"></i>
                                                                    </button>
                                                                    <form style="display: inline-block"
                                                                        action="{{ route('child.category.delete', $subCategory->id) }}"
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            function editChildCategory(childId) {
                // Fetch child category data via AJAX
                $.ajax({    
                    url: `/e-commerce/get-child-category-data/${childId}`,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            console.log(data);
                            // Set the form action URL
                            document.getElementById('editChildCategoryForm').action =
                                `/e-commerce/update-child-categorie/${childId}`;

                            // Populate form fields
                            document.getElementById('name').value = data.name;    
                            document.getElementById('edit_status').value = data.status;
                            document.getElementById('edit_status_ecommerce').value = data.status_ecommerce;

                            // Clear and set image previews
                            const featurePreview = document.getElementById('current_feature_image');
                            const iconPreview = document.getElementById('current_icon_image');

                            featurePreview.innerHTML = '';
                            iconPreview.innerHTML = '';

                            if (data.image) {
                                featurePreview.innerHTML = `
                                <img src="${data.image}" alt="Current Feature Image"
                                     style="width: 80px; height: 80px; object-fit: cover;" class="rounded">
                                <small class="d-block text-muted">Current Feature Image</small>
                            `;
                            }

                            if (data.icon_image) {
                                iconPreview.innerHTML = `
                                <img src="${data.icon_image}" alt="Current Icon Image"
                                     style="width: 80px; height: 80px; object-fit: cover;" class="rounded">
                                <small class="d-block text-muted">Current Icon Image</small>
                            `;
                            }

                            // Show the modal
                            new bootstrap.Modal(document.querySelector('.attribute-value-edit')).show();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching child category data:', xhr.responseText);
                    }
                });
            }
        </script>
    @endsection
@endsection
