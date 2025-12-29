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
                            <h5 class="card-title mb-0">Create Brand</h5>
                        </div>
                        <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="card-body">
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
                                                    ])
                                                    <div class="text-danger mt-2">Supported File : jpg,png,jpeg and size
                                                        220x220 Pixels</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                @include('components.form.select', [
                                                    'label' => 'Status For E-commerce',
                                                    'name' => 'status_ecommerce',
                                                    'value' => '1',
                                                    'options' => [
                                                        '0' => 'Inactive',
                                                        '1' => 'Active',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-lg-4">
                                                @include('components.form.select', [
                                                    'label' => 'Status',
                                                    'name' => 'status',
                                                    'value' => '1',
                                                    'options' => [
                                                        '0' => 'Inactive',
                                                        '1' => 'Active',
                                                    ],
                                                ])
                                            </div>
                                        </div>

                                        <div class="text-start mt-4">
                                            {{-- <a href="{{ route('brand.index') }}" class="btn btn-success">
                                                Add
                                            </a> --}}
                                            <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection
