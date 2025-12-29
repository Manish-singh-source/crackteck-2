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


            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <form action="{{ route('staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                                                    $roleOptions = ['' => '--Select--'];
                                                    foreach ($roles as $role) {
                                                        $roleOptions[$role->id] = $role->name;
                                                    }

                                                    $selectedRole = old('staff_role', $staff->staff_role ?? '');
                                                @endphp

                                                @include('components.form.select', [
                                                    'label' => 'Role',
                                                    'name' => 'staff_role', // match update validation
                                                    'options' => $roleOptions,
                                                    'value' => $selectedRole,
                                                    'model' => $staff,
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
                                                    'model' => $staff,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Last Name',
                                                    'name' => 'last_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Last Name',
                                                    'model' => $staff,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Phone number',
                                                    'name' => 'phone',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Phone number',
                                                    'model' => $staff,
                                                ])
                                            </div>


                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'E-mail address',
                                                    'name' => 'email',
                                                    'type' => 'email',
                                                    'placeholder' => 'Enter Email id',
                                                    'model' => $staff,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Date of Birth',
                                                    'name' => 'dob',
                                                    'type' => 'date',
                                                    'placeholder' => 'Enter Date of Birth',
                                                    'model' => $staff,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Gender',
                                                    'name' => 'gender',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        '0' => 'Male',
                                                        '1' => 'Female',
                                                        '2' => 'Other',
                                                    ],
                                                    'model' => $staff,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Marital Status',
                                                    'name' => 'marital_status',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        '0' => 'Married',
                                                        '1' => 'Unmarried',
                                                        '2' => 'Divorced',
                                                    ],
                                                    'model' => $staff,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Employment Type',
                                                    'name' => 'employment_type',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        '0' => 'Full-time',
                                                        '1' => 'Part-time',
                                                    ],
                                                    'model' => $staff,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Joining Date',
                                                    'name' => 'joining_date',
                                                    'type' => 'date',
                                                    'placeholder' => 'Enter Joining Date',
                                                    'model' => $staff,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Assigned Area',
                                                    'name' => 'assigned_area',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Assigned Area',
                                                    'model' => $staff,
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
                                                    'model' => $staff->address ?? null,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Address Line 2',
                                                    'name' => 'address2',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Address Line 2',
                                                    'model' => $staff->address ?? null,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'City',
                                                    'name' => 'city',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter City',
                                                    'model' => $staff->address ?? null,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'State',
                                                    'name' => 'state',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter State',
                                                    'model' => $staff->address ?? null,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Country',
                                                    'name' => 'country',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Country',
                                                    'model' => $staff->address ?? null,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Pincode',
                                                    'name' => 'pincode',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Pincode',
                                                    'model' => $staff->address ?? null,
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
                                                    'model' => $staff->bankDetails ?? null,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Bank Account Number',
                                                    'name' => 'bank_acc_number',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Bank Account Number',
                                                    'model' => $staff->bankDetails ?? null,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Bank Name',
                                                    'name' => 'bank_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Bank Name',
                                                    'model' => $staff->bankDetails ?? null,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'IFSC Code',
                                                    'name' => 'ifsc_code',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter IFSC Code',
                                                    'model' => $staff->bankDetails ?? null,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Passbook Photo',
                                                    'name' => 'passbook_pic',
                                                    'type' => 'file',
                                                    'placeholder' => 'Enter Passbook Photo',
                                                    'model' => $staff->bankDetails ?? null,
                                                ])
                                                @if (!empty($staff->bankDetails?->passbook_pic))
                                                    <a href="{{ asset($staff->bankDetails->passbook_pic) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary mt-1">
                                                        View Passbook
                                                    </a>
                                                @endif
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
                                                    'model' => $staff->workSkills ?? null,
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
                                                    'model' => $staff->workSkills ?? null,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Certifications',
                                                    'name' => 'certifications',
                                                    'type' => 'file',
                                                    'model' => $staff->workSkills ?? null,
                                                ])
                                                @if (!empty($staff->workSkills?->certifications))
                                                    <a href="{{ asset($staff->workSkills->certifications) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                        View Certifications
                                                    </a>
                                                @endif
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Experience',
                                                    'name' => 'experience',
                                                    'type' => 'number',
                                                    'placeholder' => 'Enter Experience',
                                                    'model' => $staff->workSkills ?? null,
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
                                                    'model' => $staff->aadharDetails ?? null,
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Aadhar Front Image',
                                                    'name' => 'aadhar_front_path',
                                                    'type' => 'file',
                                                    'model' => $staff->aadharDetails ?? null,
                                                ])
                                                @if (!empty($staff->aadharDetails?->aadhar_front_path))
                                                    <a href="{{ asset($staff->aadharDetails->aadhar_front_path) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                        View Aadhar Front
                                                    </a>
                                                @endif
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Aadhar Back Image',
                                                    'name' => 'aadhar_back_path',
                                                    'type' => 'file',
                                                    'model' => $staff->aadharDetails ?? null,
                                                ])
                                                @if (!empty($staff->aadharDetails?->aadhar_back_path))
                                                    <a href="{{ asset($staff->aadharDetails->aadhar_back_path) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                        View Aadhar Back
                                                    </a>
                                                @endif
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
                                                    'model' => $staff->panDetails ?? null,
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Pan Front Image',
                                                    'name' => 'pan_card_front_path',
                                                    'type' => 'file',
                                                    'placeholder' => 'Enter Pan Front Image',
                                                    'model' => $staff->panDetails ?? null,
                                                ])
                                                @if (!empty($staff->panDetails?->pan_card_front_path))
                                                    <a href="{{ asset($staff->panDetails->pan_card_front_path) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                        View PAN Front
                                                    </a>
                                                @endif
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Pan Back Image',
                                                    'name' => 'pan_card_back_path',
                                                    'type' => 'file',
                                                    'placeholder' => 'Enter Pan Back Image',
                                                    'model' => $staff->panDetails ?? null,
                                                ])
                                                @if (!empty($staff->panDetails?->pan_card_back_path))
                                                    <a href="{{ asset($staff->panDetails->pan_card_back_path) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                        View PAN Back
                                                    </a>
                                                @endif
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
                                                        '0' => 'Two Wheeler',
                                                        '1' => 'Three Wheeler',
                                                        '2' => 'Four Wheeler',
                                                        '3' => 'Other',
                                                    ],
                                                    'model' => $staff->vehicleDetails ?? null,
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Vehicle Number',
                                                    'name' => 'vehicle_number',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Vehicle Number',
                                                    'model' => $staff->vehicleDetails ?? null,
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Driving License Number',
                                                    'name' => 'driving_license_no',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Driving License Number',
                                                    'model' => $staff->vehicleDetails ?? null,
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Driving License Front Image',
                                                    'name' => 'driving_license_front_path',
                                                    'type' => 'file',
                                                    'placeholder' => 'Enter Driving License Front Image',
                                                    'model' => $staff->vehicleDetails ?? null,
                                                ])
                                                @if (!empty($staff->vehicleDetails?->driving_license_front_path))
                                                    <a href="{{ asset($staff->vehicleDetails->driving_license_front_path) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                        View DL Front
                                                    </a>
                                                @endif
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Driving License Back Image',
                                                    'name' => 'driving_license_back_path',
                                                    'type' => 'file',
                                                    'placeholder' => 'Enter Driving License Back Image',
                                                    'model' => $staff->vehicleDetails ?? null,
                                                ])
                                                @if (!empty($staff->vehicleDetails?->driving_license_back_path))
                                                    <a href="{{ asset($staff->vehicleDetails->driving_license_back_path) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                        View DL Back
                                                    </a>
                                                @endif
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
                                                        '0' => 'No',
                                                        '1' => 'Yes',
                                                    ],
                                                    'model' => $staff->policeVerification ?? null,
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.select', [
                                                    'label' => 'Police Verification Status',
                                                    'name' => 'police_verification_status',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        '0' => 'Pending',
                                                        '1' => 'Completed',
                                                    ],
                                                    'model' => $staff->policeVerification ?? null,
                                                ])
                                            </div>

                                            <div class="">
                                                @include('components.form.input', [
                                                    'label' => 'Upload Police Verification Document',
                                                    'name' => 'police_certificate',
                                                    'type' => 'file',
                                                    'model' => $staff->policeVerification ?? null,
                                                ])
                                                @if (!empty($staff->policeVerification?->police_certificate))
                                                    <a href="{{ asset($staff->policeVerification->police_certificate) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                        View Police Document
                                                    </a>
                                                @endif
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
                                                        '0' => 'Inactive',
                                                        '1' => 'Active',
                                                        '2' => 'Resigned',
                                                        '3' => 'Terminated',
                                                        '4' => 'Blocked',
                                                        '5' => 'Suspended',
                                                        '6' => 'Pending',
                                                    ],
                                                    'model' => $staff,
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
