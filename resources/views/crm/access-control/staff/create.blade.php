@extends('crm/layouts/master')

@section('content')
    <div class="content">


        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Staff</li>
                            <li class="breadcrumb-item active" aria-current="page">Add Staff</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0"></h4>
                </div>
            </div>


            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Role Access
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                @php
                                                $roleOptions = [];
                                                $roleOptions[''] = '--Select--';
                                                    foreach ($roles as $role){
                                                        $roleOptions[str_replace(' ', '_', strtolower($role->name))] = $role->name;
                                                    }
                                                @endphp
                                                @include('components.form.select', [
                                                    'label' => 'Role',
                                                    'name' => 'role',
                                                    'options' => $roleOptions,
                                                    'value' => $role->name ?? '',
                                                    'model' => $role,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                                        '' => '--Select--',
                                                        'male' => 'Male',
                                                        'female' => 'Female',
                                                        'other' => 'Other',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Marital Status',
                                                    'name' => 'marital_status',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        'married' => 'Married',
                                                        'unmarried' => 'Unmarried',
                                                        'divorced' => 'Divorced',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Employment Type',
                                                    'name' => 'employment_type',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        'full_time' => 'Full-time',
                                                        'part_time' => 'Part-time',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Joining Date',
                                                    'name' => 'joining_date',
                                                    'type' => 'date',
                                                    'placeholder' => 'Enter Joining Date',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Assigned Area',
                                                    'name' => 'assigned_area',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Assigned Area',
                                                ])
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Address Details
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Address Line 1',
                                                    'name' => 'address1',
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

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Bank Name',
                                                    'name' => 'bank_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Bank Name',
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'IFSC Code',
                                                    'name' => 'ifsc_code',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter IFSC Code',
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Passbook Photo',
                                                    'name' => 'passbook_pic',
                                                    'type' => 'file',
                                                    'placeholder' => 'Enter Passbook Photo',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Work Skills
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-9">
                                                @include('components.form.checkbox', [
                                                    'label' => 'Primary Skills',
                                                    'name' => 'primary_skills',
                                                    'options' => [
                                                        // Engineer skills
                                                        'tech_troubleshooting' => 'Technical Troubleshooting',
                                                        'sys_installation' => 'System Installation & Setup',
                                                        'h_s_maintenance' => 'H & S Maintenance',
                                                        'network_configuration' => 'Network Configuration',
                                                        'doc_reporting' => 'Documentation & Reporting',
                                                
                                                        // Sales Person skills
                                                        'cust_communication' => 'Customer Communication',
                                                        'lead_generation' => 'Lead Generation',
                                                        'negotiation_closing' => 'Negotiation & Closing',
                                                        'product_knowledge' => 'Product Knowledge',
                                                        'crm_handling' => 'CRM Handling',
                                                
                                                        // Delivery Man skills
                                                        'route_planning' => 'Route Planning',
                                                        'time_management' => 'Time Management',
                                                        'safe_driving' => 'Safe Driving',
                                                        'package_handling' => 'Package Handling',
                                                        'cust_verification' => 'Customer Verification',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-3">
                                                @include('components.form.checkbox', [
                                                    'label' => 'Languages Known',
                                                    'name' => 'languages_known',
                                                    'options' => [
                                                        'english' => 'English',
                                                        'hindi' => 'Hindi',
                                                        'marathi' => 'Marathi',
                                                        'gujarati' => 'Gujarati',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Certifications',
                                                    'name' => 'certifications',
                                                    'type' => 'file',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Experience',
                                                    'name' => 'experience',
                                                    'type' => 'number',
                                                    'placeholder' => 'Enter Experience',
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
                                            Aadhar Card Details:
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Aadhar Number',
                                                    'name' => 'aadhar_number',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Aadhar Number',
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Aadhar Front Image',
                                                    'name' => 'aadhar_front_path',
                                                    'type' => 'file',
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Aadhar Back Image',
                                                    'name' => 'aadhar_back_path',
                                                    'type' => 'file',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Pan Card Details:
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Pan Number',
                                                    'name' => 'pan_number',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Pan Number',
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Pan Front Image',
                                                    'name' => 'pan_card_front_path',
                                                    'type' => 'file',
                                                    'placeholder' => 'Enter Pan Front Image',
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Pan Back Image',
                                                    'name' => 'pan_card_back_path',
                                                    'type' => 'file',
                                                    'placeholder' => 'Enter Pan Back Image',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Vehicle Details:
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="">
                                                @include('components.form.select', [
                                                    'label' => 'Vehicle Type',
                                                    'name' => 'vehicle_type',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        'two_wheeler' => 'Two Wheeler',
                                                        'three_wheeler' => 'Three Wheeler',
                                                        'four_wheeler' => 'Four Wheeler',
                                                        'other' => 'Other',
                                                    ],
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Vehicle Number',
                                                    'name' => 'vehicle_number',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Vehicle Number',
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Driving License Number',
                                                    'name' => 'driving_license_no',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Driving License Number',
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Driving License Front Image',
                                                    'name' => 'driving_license_front_path',
                                                    'type' => 'file',
                                                    'placeholder' => 'Enter Driving License Front Image',
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Driving License Back Image',
                                                    'name' => 'driving_license_back_path',
                                                    'type' => 'file',
                                                    'placeholder' => 'Enter Driving License Back Image',
                                                ])
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Police Verification:
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="">
                                                @include('components.form.select', [
                                                    'label' => 'Police Verification',
                                                    'name' => 'police_verification',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        'no' => 'No',
                                                        'yes' => 'Yes',
                                                    ],
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.select', [
                                                    'label' => 'Police Verification Status',
                                                    'name' => 'police_verification_status',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        'pending' => 'Pending',
                                                        'completed' => 'Completed',
                                                    ],
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Upload Police Verification Document',
                                                    'name' => 'police_certificate',
                                                    'type' => 'file',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Status:
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="">
                                                @include('components.form.select', [
                                                    'label' => 'Status',
                                                    'name' => 'status',
                                                    'value' => '1', // Active selected by default
                                                    'options' => [
                                                        '' => '--Select--',
                                                        'inactive' => 'Inactive',
                                                        'active' => 'Active',
                                                        'resigned' => 'Resigned',
                                                        'terminated' => 'Terminated',
                                                        'blocked' => 'Blocked',
                                                        'suspended' => 'Suspended',
                                                        'pending' => 'Pending',
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
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
