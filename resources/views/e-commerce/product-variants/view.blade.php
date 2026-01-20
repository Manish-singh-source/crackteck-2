@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">


        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">{{ $attributeName->name }} Attribite Value</h4>
                </div>
                <div>
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target=".attribute-value">Add
                        Attribute Value</button>
                    <a href="{{ route('variant.index') }}" class="btn btn-secondary">Back to List</a>

                    <!-- Modals -->
                    <div class="modal fade attribute-value" tabindex="-1" role="dialog"
                        aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title">Add Attribute Value</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <form action="{{ route('variant.store.attribute.value') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="modal-body">
                                        <div class="p-2">
                                            <div class="mb-3">
                                                <input type="hidden" name="attribute_id" value="{{ $attributeName->id }}">
                                                @include('components.form.input', [
                                                    'label' => 'Attribute Value',
                                                    'name' => 'value',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Attribute Value',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-md btn-danger"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-md btn-success">Add Attribue Value</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade attribute-value-edit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title">Edit Attribute Value</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form id="editAttributeValueForm" action="" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="p-2">
                                            <div class="mb-3">
                                                <label for="edit_attribute_value" class="form-label">Attribute Value</label>
                                                <input type="text" name="value" id="edit_attribute_value"
                                                    class="form-control" placeholder="Enter Attribute Value">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-md btn-danger"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-md btn-success">Update Attribute
                                            Value</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Parent Category Edit Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit Parent Category</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('variant.update', $attributeName->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-lg-4">
                                        @include('components.form.input', [
                                            'label' => 'Attribute Name',
                                            'name' => 'name',
                                            'type' => 'text',
                                            'placeholder' => 'Enter Attribute Name',
                                            'model' => $attributeName,
                                            'required' => true,
                                        ])
                                    </div>
                                    <div class="col-lg-4">
                                        @include('components.form.input', [
                                            'label' => 'Attribute URL',
                                            'name' => 'attribute_code',
                                            'type' => 'text',
                                            'placeholder' => 'Enter Attribute URL',
                                            'model' => $attributeName,
                                            'required' => true,
                                            'disabled' => true,
                                        ])
                                    </div>
                                    <div class="col-lg-4">
                                        @include('components.form.select', [
                                            'label' => 'Status',
                                            'name' => 'status',
                                            'options' => [
                                                'active' => 'Active',
                                                'inactive' => 'Inactive',
                                            ],
                                            'model' => $attributeName,
                                            'required' => true,
                                        ])
                                    </div>

                                </div>
                                <div class="text-start mt-4">
                                    <button type="submit" class="btn btn-success">Update Parent Category</button>
                                    <a href="{{ route('category.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
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
                                                            <th>Attribute Value</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($attributeValue as $key => $value)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $value->value }}</td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-sm bg-warning-subtle me-1 btn-edit-attr-value"
                                                                        data-id="{{ $value->id }}"
                                                                        data-value="{{ $value->value }}"
                                                                        data-action="{{ route('variant.update.attribute.value', $value->id) }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target=".attribute-value-edit"
                                                                        data-bs-original-title="Edit">
                                                                        <i
                                                                            class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                    </button>

                                                                    <form style="display: inline-block"
                                                                        action="{{ route('variant.delete.attribute.value', $value->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Are you sure?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Delete">
                                                                            <i
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
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-edit-attr-value').click(function() {
                var id = $(this).data('id');
                var value = $(this).data('value');
                var action = $(this).data('action');

                $('#edit_attribute_value').val(value);
                $('#editAttributeValueForm').attr('action', action);
            });
        });
    </script>
@endsection
