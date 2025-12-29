@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
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
                            <h5 class="card-title ">Create Category</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="row g-3">
                                    <div class="col-xl-12">
                                        <div>
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="lang-tab-content-en"
                                                    role="tabpanel" aria-labelledby="lang-tab-en">
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="">
                                                                    @include('components.form.input', [
                                                                        'label' => 'Parent Category',
                                                                        'name' => 'parent_category',
                                                                        'type' => 'text',
                                                                        'placeholder' => 'Enter Parent Category',
                                                                    ])
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6" id="parent-cat">
                                                                @include('components.form.input', [
                                                                    'label' => 'Sub Category',
                                                                    'name' => 'sub_category',
                                                                    'type' => 'text',
                                                                    'placeholder' => 'Enter Sub Category',
                                                                ])
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <div class="">
                                                    @include('components.form.input', [
                                                        'label' => 'Feature Image',
                                                        'name' => 'feature_image',
                                                        'type' => 'file',
                                                    ])
                                                    <div class="text-danger mt-2">Supported File : jpg,png,jpeg and size
                                                        200x200 Pixels</div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="">
                                                    @include('components.form.input', [
                                                        'label' => 'Icon Image',
                                                        'name' => 'icon_image',
                                                        'type' => 'file',
                                                    ])
                                                    <div class="text-danger mt-2">Supported File : jpg,png,jpeg and size
                                                        200x200 Pixels</div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                @include('components.form.select', [
                                                    'label' => 'Status',
                                                    'name' => 'status',
                                                    'options' => ['1' => 'Active', '0' => 'Inactive'],
                                                ])
                                            </div>
                                        </div>

                                        <div class="text-start mt-4">
                                            {{-- <a href="{{ route('category.index') }}" class="btn btn-success">
                                                Add
                                            </a> --}}
                                            <button type="submit" class="btn btn-success">
                                                Add
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
