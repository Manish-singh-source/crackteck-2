@extends('crm/layouts/master')

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
                    <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
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
                                                    'label' => 'Phone number',
                                                    'name' => 'phone',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Phone number',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'E-mail address',
                                                    'name' => 'email',
                                                    'type' => 'email',
                                                    'placeholder' => 'Enter Email id',
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
                                        <h5 class="card-title mb-0">
                                            Address/Branch Information
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <form method="post" id="branch-form">
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    @include('components.form.input', [
                                                        'label' => 'Branch Name',
                                                        'name' => 'branch_name',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Name of Branch',
                                                    ])
                                                </div>
                                                <div class="col-6">
                                                    @include('components.form.input', [
                                                        'label' => 'Address Line 1',
                                                        'name' => 'address',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Address Line 1',
                                                    ])
                                                </div>

                                                <div class="col-6">
                                                    @include('components.form.input', [
                                                        'label' => 'Address Line 2',
                                                        'name' => 'address2',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Address Line 2',
                                                    ])
                                                </div>

                                                <div class="col-6">
                                                    @include('components.form.input', [
                                                        'label' => 'City',
                                                        'name' => 'city',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter City',
                                                    ])
                                                </div>

                                                <div class="col-6">
                                                    @include('components.form.input', [
                                                        'label' => 'State',
                                                        'name' => 'state',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter State',
                                                    ])
                                                </div>

                                                <div class="col-6">
                                                    @include('components.form.input', [
                                                        'label' => 'Country',
                                                        'name' => 'country',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Country',
                                                    ])
                                                </div>

                                                <div class="col-6">
                                                    @include('components.form.input', [
                                                        'label' => 'Pincode',
                                                        'name' => 'pincode',
                                                        'type' => 'text',
                                                        'placeholder' => 'Enter Pincode',
                                                    ])
                                                </div>

                                                <div class="col-12">
                                                    <div class="text-end">
                                                        <input type="submit" value="Add" class="btn btn-success">
                                                        <!-- <button type="submit" class="btn btn-success">
                                                        Add
                                                    </button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card branch-section">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Branch Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-borderless dt-responsive nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Branch Name</th>
                                                    <th>Address Line 1</th>
                                                    <th>Address Line 2</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Country</th>
                                                    <th>Pincode</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr class="align-middle">
                                                    <td>BO</td>
                                                    <td>
                                                        <div>
                                                            Sanjay Nagar Jalji Pada Kandivali West
                                                        </div>
                                                    </td>
                                                    <td>
                                                        Ganesh Nagar
                                                    </td>
                                                    <td>
                                                        Mumbai
                                                    </td>
                                                    <td>
                                                        Maharashtra
                                                    </td>
                                                    <td>
                                                        India
                                                    </td>
                                                    <td>400067</td>
                                                    <td>
                                                        <a aria-label="anchor"
                                                            class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                            data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr class="align-middle">
                                                    <td>KD</td>
                                                    <td>
                                                        <div>
                                                            Sanjay Nagar Jalji Pada Kandivali West
                                                        </div>
                                                    </td>
                                                    <td>
                                                        Ganesh Nagar
                                                    </td>
                                                    <td>
                                                        Mumbai
                                                    </td>
                                                    <td>
                                                        Maharashtra
                                                    </td>
                                                    <td>
                                                        India
                                                    </td>
                                                    <td>400067</td>
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
                                                @include('components.form.select', [
                                                    'label' => 'Customer Type',
                                                    'name' => 'customer_type',
                                                    'options' => [
                                                        '0' => '--Select--',
                                                        '1' => 'Retail',
                                                        '2' => 'Wholesale',
                                                        '3' => 'Corporate',
                                                    ],
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'Company Name',
                                                    'name' => 'company_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Company Name',
                                                ])
                                            </div>

                                            {{-- <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'Company Address',
                                                    'name' => 'company_addr',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Company Address',
                                                ])
                                            </div> --}}

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
                                    {{-- <a href="{{ route('customer.index') }}" class="btn btn-success w-sm waves ripple-light">
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

    <script>
        $(document).ready(function() {
            // $(".branch-section").hide();


        });
    </script>
@endsection
