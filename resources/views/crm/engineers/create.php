@extends('crm/layouts/master')

@section('content')
    <div class="content">


        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Enginner</li>
                            <li class="breadcrumb-item active" aria-current="page">Add Enginner</li>
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
                    <form action="{{ route('engineer.store') }}" method="POST" enctype="multipart/form-data">
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
                                                    'placeholder' => 'Enter E-mail Id',
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
                                            Address Information
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
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

                                        </div>
                                    </div>
                                </div>

                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Bank Account Details
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Bank Account Holder Name',
                                                    'name' => 'bank_acc_holder_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Bank Account Holder Name',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Bank Account Number',
                                                    'name' => 'bank_acc_number',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Bank Account Number',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Bank Name',
                                                    'name' => 'bank_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Bank Name',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'IFSC Code',
                                                    'name' => 'ifsc_code',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter IFSC Code',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Police Verification Details
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Police Verification:',
                                                    'name' => 'police_verification',
                                                    'options' => [
                                                        '0' => '--Select--',
                                                        '1' => 'Yes',
                                                        '2' => 'No',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Police Verification Status:',
                                                    'name' => 'police_verification_status',
                                                    'options' => [
                                                        '0' => '--Select--',
                                                        '1' => 'Pending',
                                                        '2' => 'Completed',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Upload Police Verification Document',
                                                    'name' => 'police_certificate',
                                                    'type' => 'file',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Employment Details:
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3">
                                                @include('components.form.select', [
                                                    'label' => 'Designation',
                                                    'name' => 'designation',
                                                    'options' => [
                                                        '0' => '--Select--',
                                                        '1' => 'Network Engineer',
                                                        '2' => 'Hardware Technician',
                                                    ],
                                                ])
                                            </div>
                                            <div class="mb-3">
                                                @include('components.form.select', [
                                                    'label' => 'Department',
                                                    'name' => 'department',
                                                    'options' => [
                                                        '0' => '--Select--',
                                                        '1' => 'Installation',
                                                        '2' => 'Maintenance',
                                                        '3' => 'Support',
                                                    ],
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'Joining Date',
                                                    'name' => 'join_date',
                                                    'type' => 'date',
                                                ])
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Skill Details:
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3">
                                                @include('components.form.select', [
                                                    'label' => 'Primary Skills',
                                                    'name' => 'primary_skills',
                                                    'options' => [
                                                        '0' => '--Select--',
                                                        '1' => 'Network Engineer',
                                                        '2' => 'Hardware Technician',
                                                    ],
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
                                            <div class=" mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'Aadhar Card Upload',
                                                    'name' => 'aadhar_pic',
                                                    'type' => 'file',
                                                ])
                                            </div>
                                            <div class=" mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'Pan Card Upload',
                                                    'name' => 'pan_card',
                                                    'type' => 'file',
                                                ])
                                            </div>
                                            <div class="mb-3">
                                                @include('components.form.select', [
                                                    'label' => 'Status',
                                                    'name' => 'status',
                                                    'options' => [
                                                        '0' => '--Select--',
                                                        '1' => 'Active',
                                                        '2' => 'Inactive',
                                                    ],
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
                                    {{-- <a href="{{ route('engineers.index') }}"
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

    <script>
        $(document).ready(function() {
            $(".branch-section").hide();

            $("#branch-form").on("submit", function(e) {
                e.preventdefault();
                let formData = e.serialize();
                console.log(formData);
            });
        });
    </script>
@endsection
