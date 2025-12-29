@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">


        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Customer</li>
                            <li class="breadcrumb-item active" aria-current="page">Add Customer</li>
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
                    <form action="{{ route('ec.customer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Personal Information
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'First Name',
                                                    'name' => 'first_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter First Name',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Last Name',
                                                    'name' => 'last_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Last Name',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Phone Number',
                                                    'name' => 'phone',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Phone Number',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'E-mail ID',
                                                    'name' => 'email',
                                                    'type' => 'email',
                                                    'placeholder' => 'Enter E-mail ID',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Date of Birth',
                                                    'name' => 'dob',
                                                    'type' => 'date',
                                                    'placeholder' => 'Enter Date of Birth',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Gender',
                                                    'name' => 'gender',
                                                    'options' => [
                                                        '0' => '--Select--',
                                                        '1' => 'Male',
                                                        '2' => 'Female',
                                                    ],
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title mb-0">
                                                Address/Branch Information
                                            </h5>
                                            <button type="button" class="btn btn-primary btn-sm" id="add-branch-btn">
                                                <i class="mdi mdi-plus"></i> Add Branch
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div id="branches-container">
                                            <!-- First branch (default) -->
                                            <div class="branch-item border rounded p-3 mb-3" data-branch-index="0">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0 text-primary">Branch #1</h6>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="primary_branch" value="0" id="primary_0" checked>
                                                        <label class="form-check-label" for="primary_0">
                                                            Primary Branch
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-6">
                                                        @include('components.form.input', [
                                                            'label' => 'Branch Name',
                                                            'name' => 'branches[0][branch_name]',
                                                            'type' => 'text',
                                                            'placeholder' => 'Enter Name of Branch',
                                                        ])
                                                    </div>
                                                    <div class="col-6">
                                                        @include('components.form.input', [
                                                            'label' => 'Address Line 1',
                                                            'name' => 'branches[0][address]',
                                                            'type' => 'text',
                                                            'placeholder' => 'Enter Address Line 1',
                                                        ])
                                                    </div>
                                                    <div class="col-6">
                                                        @include('components.form.input', [
                                                            'label' => 'Address Line 2',
                                                            'name' => 'branches[0][address2]',
                                                            'type' => 'text',
                                                            'placeholder' => 'Enter Address Line 2',
                                                        ])
                                                    </div>
                                                    <div class="col-6">
                                                        @include('components.form.input', [
                                                            'label' => 'City',
                                                            'name' => 'branches[0][city]',
                                                            'type' => 'text',
                                                            'placeholder' => 'Enter City',
                                                        ])
                                                    </div>
                                                    <div class="col-6">
                                                        @include('components.form.input', [
                                                            'label' => 'State',
                                                            'name' => 'branches[0][state]',
                                                            'type' => 'text',
                                                            'placeholder' => 'Enter State',
                                                        ])
                                                    </div>
                                                    <div class="col-6">
                                                        @include('components.form.input', [
                                                            'label' => 'Country',
                                                            'name' => 'branches[0][country]',
                                                            'type' => 'text',
                                                            'placeholder' => 'Enter Country',
                                                        ])
                                                    </div>
                                                    <div class="col-6">
                                                        @include('components.form.input', [
                                                            'label' => 'Pincode',
                                                            'name' => 'branches[0][pincode]',
                                                            'type' => 'text',
                                                            'placeholder' => 'Enter Pincode',
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="text-start mb-3">
                                    <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                        Submit
                                    </button>
                                </div> -->
                            </div>

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Other Details:
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3">
                                                <label class="form-label">Customer Type</label>
                                                <input type="text" class="form-control" value="E-commerce Customer" readonly>
                                                <input type="hidden" name="customer_type" value="E-commerce Customer">
                                                <small class="text-muted">Customer type is automatically set for e-commerce customers</small>
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'Company Name',
                                                    'name' => 'company_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Company Name',
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'Company Address',
                                                    'name' => 'company_addr',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Company Address',
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'GST Number',
                                                    'name' => 'gst_no',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter GST Number',
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'PAN Number',
                                                    'name' => 'pan_no',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter PAN Number',
                                                ])
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Other Optional:
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row ">
                                            <div class=" mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'Profile Picture Upload',
                                                    'name' => 'pic',
                                                    'type' => 'file',
                                                    'placeholder' => 'Profile Picture Upload',
                                                ])
                                            </div>
                                            <!-- <div class="mb-3">
                                                <label for="pic" class="form-label">Profile Picture Upload <span class="text-danger">*</span></label>
                                                <input type="file" name="pic" id="pic" class="form-control" value="" required="" placeholder="Profile Picture Upload">
                                            </div> -->
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-start mb-3">
                                    {{-- <a href="{{ route('ec.customer.index') }}"
                                        class="btn btn-success w-sm waves ripple-light">
                                        Submit
                                    </a> --}}
                                    <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                        Submit
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
