@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Attribite list</h4>
                </div>
                <div>
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target=".attribute">Create
                        Attribute</button>
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                        data-bs-target=".attribute-value">Add Attribute Value</button>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="tab-content text-muted">
                                @php
                                    $statuses = [
                                        'all' => [
                                            'label' => 'All',
                                            'icon' => 'mdi-format-list-bulleted',
                                            'color' => '',
                                        ],
                                        'active' => [
                                            'label' => 'Active',
                                            'icon' => 'mdi-check-circle-outline',
                                            'color' => 'text-success',
                                        ],
                                        'inactive' => [
                                            'label' => 'Inactive',
                                            'icon' => 'mdi-close-circle-outline',
                                            'color' => 'text-danger',
                                        ],
                                    ];

                                    $currentStatus = request()->get('status') ?? 'all';
                                @endphp

                                <ul class="nav nav-underline border-bottom" id="pills-tab" role="tablist">
                                    @foreach ($statuses as $key => $status)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link {{ $currentStatus === $key ? 'active' : '' }} p-2"
                                                href="{{ $key === 'all' ? route('variant.index') : route('variant.index', ['status' => $key]) }}">
                                                <span class="d-block d-sm-none">
                                                    <i
                                                        class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>
                                                </span>
                                                <span class="d-none d-sm-block">
                                                    <i
                                                        class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>{{ $status['label'] }}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
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
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($attributeName as $attribute)
                                                            <tr>
                                                                <td>{{ $attribute->id }}</td>
                                                                <td>{{ $attribute->name }}</td>
                                                                <td>
                                                                    <span
                                                                        class="badge {{ $attribute->status == 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fw-semibold">
                                                                        {{ $attribute->status == 'active' ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a aria-label="anchor"
                                                                        href="{{ route('variant.view', $attribute->id) }}"
                                                                        class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-original-title="View">
                                                                        <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                    </a>
                                                                    <form style="display: inline-block"
                                                                        action="{{ route('variant.delete', $attribute->id) }}"
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


    <!-- Modals -->
    <div class="modal fade attribute" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Add Attribute</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{ route('variant.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="p-2">
                            <div class="mb-3">
                                @include('components.form.input', [
                                    'label' => 'Attribute Name',
                                    'name' => 'name',
                                    'type' => 'text',
                                    'placeholder' => 'Enter Attribute Name',
                                ])
                            </div>

                            <div class="mb-3">
                                @include('components.form.select', [
                                    'label' => 'Status',
                                    'name' => 'status',
                                    'value' => 'active',
                                    'options' => [
                                        'inactive' => 'Inactive',
                                        'active' => 'Active',
                                    ],
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-md btn-success">Add Attribue</button>
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
                                @include('components.form.select', [
                                    'label' => 'Attribute Value Name',
                                    'name' => 'attribute_id',
                                    'options' =>
                                        ['' => 'Select Attribute'] +
                                        $attributeName->pluck('name', 'id')->toArray(), // id => name for dropdown
                                    'model' => old('attribute_id', $attribute->attribute_id ?? null),
                                ])
                            </div>

                            <div class="mb-3">
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
                        <button type="button" class="btn btn-md btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-md btn-success">Add Attribue Value</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
