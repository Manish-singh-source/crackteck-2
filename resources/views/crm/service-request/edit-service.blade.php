@extends('crm/layouts/master')

@section('content')

<div class="content">

    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Service</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Service Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <div class="row g-3 pb-3">
                                <div class="col-4">
                                    @include('components.form.select', [
                                    'label' => 'Service Type',
                                    'name' => 'service_type',
                                    'options' => ["0" => "--Select Service Type--", "1" => "Online", "2" => "Offline"]
                                    ])
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Customer Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <div class="row g-3 pb-3">
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Customer Type',
                                        'name' => 'customer_type',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Customer Type',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'First Name',
                                        'name' => 'first_name',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your First Name',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Last Name',
                                        'name' => 'last_name',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your Last Name',
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Phone Number',
                                        'name' => 'phone',
                                        'type' => 'text',
                                        'placeholder' => '+91 000 000 XXXX',
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Email ID',
                                        'name' => 'email',
                                        'type' => 'email',
                                        'placeholder' => 'example@gamil.com',
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Address Line 1',
                                        'name' => 'address',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your Address',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Address Line 2',
                                        'name' => 'address2',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your Address 2',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Country',
                                        'name' => 'country',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your Country',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'State',
                                        'name' => 'state',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your State',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'City',
                                        'name' => 'city',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your City',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Pin Code',
                                        'name' => 'pin_code',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your Pin Code',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'DOB',
                                        'name' => 'dob',
                                        'type' => 'date',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.select', [
                                        'label' => 'Gender',
                                        'name' => 'gender',
                                        'options' => ["0" => "--Select Gender--", "1" => "Male", "2" => "Female"]
                                        ])
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
                        </form>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <div class="row g-3 pb-3">
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Company Name',
                                        'name' => 'company_name',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your Company Name',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Company Address',
                                        'name' => 'company_address',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your Company Address',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'GST Number',
                                        'name' => 'gst_no',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your GST Number',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'PAN Number',
                                        'name' => 'pan_no',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your PAN Number',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Profile Image',
                                        'name' => 'pic',
                                        'type' => 'file',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Image',
                                        'name' => 'image',
                                        'type' => 'file',
                                        ])
                                    </div>
                                    <div id="image-preview-section">

                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.select', [
                                        'label' => 'Priority Level',
                                        'name' => 'priority_level',
                                        'options' => ["0" => "--Select Level --", "1" => "High", "2" => "Medium", "3" => "Low"]
                                        ])
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <div class="row g-3 pb-3">
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Product Name',
                                        'name' => 'product_name',
                                        'type' => 'text',
                                        'placeholder' => 'Dell Inspiron 15 Laptop Windows 11',
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.select', [
                                        'label' => 'Product Type',
                                        'name' => 'product_type',
                                        'options' => ["0" => "--Select Type --", "1" => "Computer", "2" => "Laptop", "3" => "Accessories"]
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Product Brand',
                                        'name' => 'product_brand',
                                        'type' => 'text',
                                        'placeholder' => "Dell, Hp ,Asus"
                                        ])
                                    </div>
                                </div>
                                
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Model Number',
                                        'name' => 'model_no',
                                        'type' => 'text',
                                        'placeholder' => "Inspiron 3511"
                                        ])
                                    </div>
                                </div>
                                
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Serial Number',
                                        'name' => 'Serial Number',
                                        'type' => 'text',
                                        'placeholder' => "B0BB7FQBBS"
                                        ])
                                    </div>
                                </div>
                                
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                            'label' => 'Purchase Date',
                                            'name' => 'purchase_date',
                                            'type' => 'date'
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Image',
                                        'name' => 'image',
                                        'type' => 'file'
                                        ])
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
                                        'placeholder' => "Enter Issue"
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="serial_no" class="form-label">
                                            Issue Description
                                        </label>
                                        <textarea name="" class="form-control" id=""></textarea>
                                    </div>
                                </div>
                                
                                
                                <div class="col-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <table
                            class="table table-striped table-borderless dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Brand</th>
                                    <th>Modal Number</th>
                                    <th>Serial Number</th>
                                    <th>Purchase Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="https://placehold.co/100x100" alt="Headphone" width="100px" class="img-fluid d-block">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            Headphone
                                        </div>
                                    </td>
                                    <td>
                                        Computer
                                    </td>
                                    <td>
                                        Sony
                                    </td>
                                    <td>
                                        Inspiron 3511
                                    </td>
                                    <td>
                                        B0BB7FQBBS
                                    </td>
                                    <td>2025-04-04 06:09 PM</td>
                                    <td>
                                        <a aria-label="anchor"
                                            class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                            data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                        </a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <div class="col-lg-12">
                <div class="text-start mb-3">
                    <a href="{{ route('service-request.index') }}" class="btn btn-success w-sm waves ripple-light">
                        Submit
                    </a>
                    <!-- <button type="submit" class="btn btn-success w-sm waves ripple-light">
                            Submit
                        </button> -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection