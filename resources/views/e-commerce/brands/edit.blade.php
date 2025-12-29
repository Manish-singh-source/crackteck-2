@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0"></h4>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">Edit Brand</h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">
                                <form action="{{ route('brand.update', $brand->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="lang-tab-content-en"
                                                        role="tabpanel" aria-labelledby="lang-tab-en">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="">
                                                                        @include('components.form.input', [
                                                                            'label' => 'Name',
                                                                            'name' => 'name',
                                                                            'type' => 'text',
                                                                            'placeholder' => 'Enter Name',
                                                                            'model' => $brand,
                                                                        ])
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="row g-3">
                                                <div class="col-lg-4">
                                                    <div>
                                                        @include('components.form.input', [
                                                            'label' => 'Image',
                                                            'name' => 'image',
                                                            'type' => 'file',
                                                            'placeholder' => 'Enter Image',
                                                            'model' => $brand,
                                                        ])
                                                        <div class="text-danger mt-2">Supported File : jpg,png,jpeg and size
                                                            220x220 Pixels</div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    @include('components.form.select', [
                                                        'label' => 'Status For E-commerce',
                                                        'name' => 'status_ecommerce',
                                                        'options' => [
                                                            '0' => 'Inactive',
                                                            '1' => 'Active',
                                                        ],
                                                        'model' => $brand,
                                                    ])
                                                </div>
                                                <div class="col-lg-4">
                                                    @include('components.form.select', [
                                                        'label' => 'Status',
                                                        'name' => 'status',
                                                        'options' => [
                                                            '0' => 'Inactive',
                                                            '1' => 'Active',
                                                        ],
                                                        'model' => $brand,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="text-start mt-4">
                                                {{-- <a href="{{ route('brand.index') }}" class="btn btn-success">
                                        Add
                                    </a> --}}
                                                <button type="submit" class="btn btn-success">
                                                    Edit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    @endsection
