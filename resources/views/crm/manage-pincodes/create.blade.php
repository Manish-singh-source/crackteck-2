@extends('crm/layouts/master')

@section('content')
    <div class="content">


        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pincodes</li>
                            <li class="breadcrumb-item active" aria-current="page">Create Pincode</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0"></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('pincodes.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Pincode
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">

                                            <div class="col-2">
                                                @include('components.form.input', [
                                                    'label' => 'Pincode',
                                                    'name' => 'pincode',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Pincode',
                                                ])
                                            </div>

                                            <div class="col-2">
                                                @include('components.form.select', [
                                                    'label' => 'Delivery',
                                                    'name' => 'delivery',
                                                    'value' => '1',
                                                    'options' => [
                                                        '0' => 'Inactive',
                                                        '1' => 'Active',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-2">
                                                @include('components.form.select', [
                                                    'label' => 'Installation',
                                                    'name' => 'installation',
                                                    'value' => '1',
                                                    'options' => [
                                                        '0' => 'Inactive',
                                                        '1' => 'Active',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-2">
                                                @include('components.form.select', [
                                                    'label' => 'Repair',
                                                    'name' => 'repair',
                                                    'value' => '1',
                                                    'options' => [
                                                        '0' => 'Inactive',
                                                        '1' => 'Active',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-2">
                                                @include('components.form.select', [
                                                    'label' => 'Quick Service',
                                                    'name' => 'quick_service',
                                                    'value' => '1',
                                                    'options' => [
                                                        '0' => 'Inactive',
                                                        '1' => 'Active',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-2">
                                                @include('components.form.select', [
                                                    'label' => 'AMC',
                                                    'name' => 'amc',
                                                    'value' => '1',
                                                    'options' => [
                                                        '0' => 'Inactive',
                                                        '1' => 'Active',
                                                    ],
                                                ])
                                            </div>  
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-12">
                                <div class="text-start mb-3">
                                    <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                        Submit
                                    </button> 
                                    {{-- <a href="{{ route('pincodes.index') }}"
                                        class="btn btn-success w-sm waves ripple-light">Submit</a> --}}
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
