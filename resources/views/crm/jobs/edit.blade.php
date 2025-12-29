@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit Job</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('jobs.update', $job->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Customer Details</h5>
                            </div>
                            <div class="card-body">
                                    <div class="row g-3 pb-3">
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Customer Type',
                                                    'name' => 'customer_type',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Customer Type',
                                                    'model' => $job])
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'First Name',
                                                    'name' => 'first_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Your First Name',
                                                    'model' => $job])
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Last Name',
                                                    'name' => 'last_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Your Last Name',
                                                    'model' => $job])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Phone Number',
                                                    'name' => 'phone',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Your Phone Number',
                                                    'model' => $job])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Email',
                                                    'name' => 'email',
                                                    'type' => 'email',
                                                    'placeholder' => 'Enter Your Email',
                                                    'model' => $job])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Date Of Birth',
                                                    'name' => 'dob',
                                                    'type' => 'date',
                                                    'placeholder' => 'Enter Your Date Of Birth',
                                                    'model' => $job])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Address Line 1',
                                                    'name' => 'address',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Your Address Line 1',
                                                    'model' => $job])
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Address Line 2',
                                                    'name' => 'address2',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Your Address Line 2',
                                                    'model' => $job])
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Country',
                                                    'name' => 'country',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Your Country',
                                                    'model' => $job])
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'State',
                                                    'name' => 'state',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Your State',
                                                    'model' => $job])
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'City',
                                                    'name' => 'city',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Your City',
                                                    'model' => $job])
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Pin Code',
                                                    'name' => 'pin_code',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Your Pin Code',
                                                    'model' => $job])
                                            </div>
                                        </div>

                                        <!-- <div class="col-xl-4 col-lg-6">
                                                                        <div>
                                                                            <label for="address" class="form-label">
                                                                                Priority Level
                                                                            </label>
                                                                            <input type="text" name="address" value="" class="form-control" placeholder="Enter your Priority Level" id="address">
                                                                        </div>
                                                                    </div> -->
                                    </div>
                            </div>

                            <div class="card-body">
                                <div class="row g-3 pb-3">
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Company Name',
                                                'name' => 'company_name',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Company Name',
                                                'model' => $job])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Company Address',
                                                'name' => 'company_address',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Company Address',
                                                'model' => $job])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'GST Number',
                                                'name' => 'gst_no',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your GST Number',
                                                'model' => $job])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'PAN Number',
                                                'name' => 'pan_no',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your PAN Number',
                                                'model' => $job])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Profile Image',
                                                'name' => 'profile_img',
                                                'type' => 'file',
                                                'model' => $job])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Image',
                                                'name' => 'image',
                                                'type' => 'file',
                                                'model' => $job])
                                        </div>
                                        <div id="image-preview-section">

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.select', [
                                                'label' => 'Priority Level',
                                                'name' => 'priority_level',
                                                'options' => [
                                                    '0' => '--Select --',
                                                    'High' => 'High',
                                                    'Medium' => 'Medium',
                                                    'Low' => 'Low',
                                                ],
                                                'model' => $job])
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Product Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3 pb-3">
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Product Name',
                                                    'name' => 'product_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Dell Inspiron 15 Laptop Windows 11',
                                                    'model' => $job])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.select', [
                                                    'label' => 'Product Type',
                                                    'name' => 'product_type',
                                                    'options' => [
                                                        '0' => '--Select --',
                                                        'PC' => 'PC',
                                                        'Laptop' => 'Laptop',
                                                        'Accessories' => 'Accessories',
                                                    ],
                                                    'model' => $job])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Product Brand',
                                                    'name' => 'product_brand',
                                                    'type' => 'text',
                                                    'placeholder' => 'Dell, HP, Asus',
                                                    'model' => $job])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Model Number',
                                                    'name' => 'model_no',
                                                    'type' => 'text',
                                                    'placeholder' => 'Inspiron 3511',
                                                    'model' => $job])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Serial Number',
                                                    'name' => 'serial_no',
                                                    'type' => 'text',
                                                    'placeholder' => 'B0BB7FQBBS',
                                                    'model' => $job])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Purchase Date',
                                                    'name' => 'purchase_date',
                                                    'type' => 'date',
                                                    'model' => $job])
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Image',
                                                    'name' => 'image',
                                                    'type' => 'file',
                                                    'model' => $job])
                                            </div>
                                            <div id="image-preview-section">

                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Issue type',
                                                    'name' => 'issue_type',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Issue',
                                                    'model' => $job])
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                <label for="serial_no" class="form-label">
                                                    Issue Description
                                                </label>
                                                <textarea name="description" class="form-control" id=""></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="text-start mb-3 ms-3">
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
