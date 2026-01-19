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
                            <li class="breadcrumb-item active" aria-current="page">Edit Customer</li>
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
                    <form action="{{ route('customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- LEFT 8 COLS --}}
                            <div class="col-lg-8">
                                {{-- Personal Information --}}
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
                                                    'label'       => 'First Name',
                                                    'name'        => 'first_name',
                                                    'type'        => 'text',
                                                    'placeholder' => 'Enter First Name',
                                                    'model'       => $customer,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label'       => 'Last Name',
                                                    'name'        => 'last_name',
                                                    'type'        => 'text',
                                                    'placeholder' => 'Enter Last Name',
                                                    'model'       => $customer,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label'       => 'Phone number',
                                                    'name'        => 'phone',
                                                    'type'        => 'text',
                                                    'placeholder' => 'Enter Phone number',
                                                    'model'       => $customer,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label'       => 'E-mail address',
                                                    'name'        => 'email',
                                                    'type'        => 'email',
                                                    'placeholder' => 'Enter Email id',
                                                    'model'       => $customer,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label'       => 'Date of Birth',
                                                    'name'        => 'dob',
                                                    'type'        => 'date',
                                                    'placeholder' => 'Enter Date of Birth',
                                                    'model'       => $customer,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label'   => 'Gender',
                                                    'name'    => 'gender',
                                                    'options' => [
                                                        ''  => '--Select--',
                                                        'male' => 'Male',
                                                        'female' => 'Female',
                                                        'other' => 'Other',
                                                    ],
                                                    'model'   => $customer,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label'   => 'Customer Type',
                                                    'name'    => 'customer_type',
                                                    'options' => [
                                                        ''  => '--Select--',
                                                        'ecommerce' => 'E-commerce',
                                                        'amc' => 'AMC',
                                                        'non_amc' => 'Non-AMC',
                                                        'both' => 'Both',
                                                        'offline' => 'Offline',
                                                    ],
                                                    'model'   => $customer,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label'   => 'Source Type',
                                                    'name'    => 'source_type',
                                                    'options' => [
                                                        ''  => '--Select--',
                                                        'ecommerce' => 'E-commerce',
                                                        'admin_panel' => 'Admin Panel',
                                                        'app' => 'App',
                                                        'call' => 'Call',
                                                        'walk_in' => 'Walk-in',
                                                        'other' => 'Other',
                                                    ],
                                                    'model'   => $customer,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Aadhar Card Details --}}
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Aadhar Card Details:
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label'       => 'Aadhar Number',
                                                    'name'        => 'aadhar_number',
                                                    'type'        => 'text',
                                                    'placeholder' => 'Enter Aadhar Number',
                                                    'model'       => $customer->aadharDetails ?? null,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Aadhar Front Image',
                                                    'name'  => 'aadhar_front_path',
                                                    'type'  => 'file',
                                                    'model' => $customer->aadharDetails ?? null,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Aadhar Back Image',
                                                    'name'  => 'aadhar_back_path',
                                                    'type'  => 'file',
                                                    'model' => $customer->aadharDetails ?? null,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Pan Card Details --}}
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Pan Card Details:
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label'       => 'Pan Number',
                                                    'name'        => 'pan_number',
                                                    'type'        => 'text',
                                                    'placeholder' => 'Enter Pan Number',
                                                    'model'       => $customer->panCardDetails ?? null,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Pan Front Image',
                                                    'name'  => 'pan_card_front_path',
                                                    'type'  => 'file',
                                                    'model' => $customer->panCardDetails ?? null,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Pan Back Image',
                                                    'name'  => 'pan_card_back_path',
                                                    'type'  => 'file',
                                                    'model' => $customer->panCardDetails ?? null,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Customer Address / Branch Information (dynamic) --}}
                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title mb-0">
                                                Customer Address/Branch Information
                                            </h5>
                                            <button type="button" class="btn btn-primary btn-sm" id="add-branch-btn">
                                                <i class="mdi mdi-plus"></i> Add Branch
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div id="branches-container">
                                            @if($customer->branches && $customer->branches->count() > 0)
                                                @foreach($customer->branches as $index => $branch)
                                                    <div class="branch-item border rounded p-3 mb-3"
                                                         data-branch-index="{{ $index }}"
                                                         data-branch-id="{{ $branch->id }}">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <h6 class="mb-0 text-primary">Branch #{{ $index + 1 }}</h6>
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                           name="is_primary"
                                                                           value="{{ $index }}"
                                                                           id="primary_{{ $index }}"
                                                                           {{ $branch->is_primary ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="primary_{{ $index }}">
                                                                        Primary Branch
                                                                    </label>
                                                                </div>
                                                                @if($customer->branches->count() > 1)
                                                                    <button type="button"
                                                                            class="btn btn-danger btn-sm remove-branch-btn">
                                                                        <i class="mdi mdi-delete"></i> Remove
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row g-3">
                                                            <input type="hidden"
                                                                   name="branches[{{ $index }}][id]"
                                                                   value="{{ $branch->id }}">
                                                            <div class="col-6">
                                                                <label for="branches_{{ $index }}_branch_name"
                                                                       class="form-label">Branch Name
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text"
                                                                       name="branches[{{ $index }}][branch_name]"
                                                                       id="branches_{{ $index }}_branch_name"
                                                                       class="form-control"
                                                                       placeholder="Enter Name of Branch"
                                                                       value="{{ $branch->branch_name }}">
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="branches_{{ $index }}_address1"
                                                                       class="form-label">Address Line 1
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text"
                                                                       name="branches[{{ $index }}][address1]"
                                                                       id="branches_{{ $index }}_address1"
                                                                       class="form-control"
                                                                       placeholder="Enter Address Line 1"
                                                                       value="{{ $branch->address1 }}">
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="branches_{{ $index }}_address2"
                                                                       class="form-label">Address Line 2</label>
                                                                <input type="text"
                                                                       name="branches[{{ $index }}][address2]"
                                                                       id="branches_{{ $index }}_address2"
                                                                       class="form-control"
                                                                       placeholder="Enter Address Line 2"
                                                                       value="{{ $branch->address2 }}">
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="branches_{{ $index }}_city"
                                                                       class="form-label">City
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text"
                                                                       name="branches[{{ $index }}][city]"
                                                                       id="branches_{{ $index }}_city"
                                                                       class="form-control"
                                                                       placeholder="Enter City"
                                                                       value="{{ $branch->city }}">
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="branches_{{ $index }}_state"
                                                                       class="form-label">State
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text"
                                                                       name="branches[{{ $index }}][state]"
                                                                       id="branches_{{ $index }}_state"
                                                                       class="form-control"
                                                                       placeholder="Enter State"
                                                                       value="{{ $branch->state }}">
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="branches_{{ $index }}_country"
                                                                       class="form-label">Country
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text"
                                                                       name="branches[{{ $index }}][country]"
                                                                       id="branches_{{ $index }}_country"
                                                                       class="form-control"
                                                                       placeholder="Enter Country"
                                                                       value="{{ $branch->country }}">
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="branches_{{ $index }}_pincode"
                                                                       class="form-label">Pincode
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text"
                                                                       name="branches[{{ $index }}][pincode]"
                                                                       id="branches_{{ $index }}_pincode"
                                                                       class="form-control"
                                                                       placeholder="Enter Pincode"
                                                                       value="{{ $branch->pincode }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                {{-- default empty branch --}}
                                                <div class="branch-item border rounded p-3 mb-3" data-branch-index="0">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="mb-0 text-primary">Branch #1</h6>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                   name="is_primary"
                                                                   value="{{ $index }}" id="primary_{{ $index }}" checked>
                                                            <label class="form-check-label" for="primary_{{ $index }}">
                                                                Primary Branch
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-6">
                                                            <label for="branches_0_branch_name" class="form-label">
                                                                Branch Name <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="branches[0][branch_name]"
                                                                   id="branches_0_branch_name"
                                                                   class="form-control"
                                                                   placeholder="Enter Name of Branch">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="branches_0_address1" class="form-label">
                                                                Address Line 1 <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="branches[0][address1]"
                                                                   id="branches_0_address1"
                                                                   class="form-control"
                                                                   placeholder="Enter Address Line 1">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="branches_0_address2" class="form-label">
                                                                Address Line 2
                                                            </label>
                                                            <input type="text" name="branches[0][address2]"
                                                                   id="branches_0_address2"
                                                                   class="form-control"
                                                                   placeholder="Enter Address Line 2">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="branches_0_city" class="form-label">
                                                                City <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="branches[0][city]"
                                                                   id="branches_0_city"
                                                                   class="form-control"
                                                                   placeholder="Enter City">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="branches_0_state" class="form-label">
                                                                State <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="branches[0][state]"
                                                                   id="branches_0_state"
                                                                   class="form-control"
                                                                   placeholder="Enter State">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="branches_0_country" class="form-label">
                                                                Country <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="branches[0][country]"
                                                                   id="branches_0_country"
                                                                   class="form-control"
                                                                   placeholder="Enter Country">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="branches_0_pincode" class="form-label">
                                                                Pincode <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="branches[0][pincode]"
                                                                   id="branches_0_pincode"
                                                                   class="form-control"
                                                                   placeholder="Enter Pincode">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Branch table (kept same) --}}
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customer->branches as $index => $branch)
                                                    <tr>
                                                        <td>{{ $branch->branch_name }}</td>
                                                        <td>{{ $branch->address1 }}</td>
                                                        <td>{{ $branch->address2 }}</td>
                                                        <td>{{ $branch->city }}</td>
                                                        <td>{{ $branch->state }}</td>
                                                        <td>{{ $branch->country }}</td>
                                                        <td>{{ $branch->pincode }}</td>
                                                    </tr>
                                                @endforeach 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                            {{-- RIGHT 4 COLS --}}
                            <div class="col-lg-4">
                                {{-- Company Details: aligned to Add page --}}
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Company Details:
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label'       => 'Company Name',
                                                    'name'        => 'company_name',
                                                    'type'        => 'text',
                                                    'placeholder' => 'Enter Company Name',
                                                    'model'       => $customer->companyDetails,
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label'       => 'Company Address Line 1',
                                                    'name'        => 'comp_address1',
                                                    'type'        => 'text',
                                                    'placeholder' => 'Enter Company Address Line 1',
                                                    'model'       => $customer->companyDetails,
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label'       => 'Company Address Line 2',
                                                    'name'        => 'comp_address2',
                                                    'type'        => 'text',
                                                    'placeholder' => 'Enter Company Address Line 2',
                                                    'model'       => $customer->companyDetails,
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label'       => 'City',
                                                    'name'        => 'comp_city',
                                                    'type'        => 'text',
                                                    'placeholder' => 'Enter City',
                                                    'model'       => $customer->companyDetails,
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label'       => 'State',
                                                    'name'        => 'comp_state',
                                                    'type'        => 'text',
                                                    'placeholder' => 'Enter State',
                                                    'model'       => $customer->companyDetails,
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label'       => 'Country',
                                                    'name'        => 'comp_country',
                                                    'type'        => 'text',
                                                    'placeholder' => 'Enter Country',
                                                    'model'       => $customer->companyDetails,
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label'       => 'Pincode',
                                                    'name'        => 'comp_pincode',
                                                    'type'        => 'text',
                                                    'placeholder' => 'Enter Pincode',
                                                    'model'       => $customer->companyDetails,
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label'       => 'GST Number',
                                                    'name'        => 'gst_no',
                                                    'type'        => 'text',
                                                    'placeholder' => 'Enter GST Number',
                                                    'model'       => $customer->companyDetails,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Status:
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'Profile Image',
                                                    'name' => 'profile',
                                                    'type' => 'file',
                                                    'placeholder' => 'Profile Image',
                                                ])
                                            </div>
                                            <div class="mb-3">
                                                @include('components.form.select', [
                                                    'label'   => 'Status',
                                                    'name'    => 'status',
                                                    'options' => [
                                                        ''  => '--Select--',
                                                        'inactive' => 'Inactive',
                                                        'active' => 'Active',
                                                        'blocked' => 'Blocked',
                                                        'suspended' => 'Suspended',
                                                    ],
                                                    'model'   => $customer,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="col-lg-12">
                                <div class="text-start mb-3">
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
            let branchIndex = {{ $customer->branches ? $customer->branches->count() : 1 }};

            $('#add-branch-btn').click(function() {
                const branchHtml = `
                    <div class="branch-item border rounded p-3 mb-3" data-branch-index="${branchIndex}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 text-primary">Branch #${branchIndex + 1}</h6>
                            <div class="d-flex align-items-center gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_primary" value="${branchIndex}" id="primary_${branchIndex}">
                                    <label class="form-check-label" for="primary_${branchIndex}">
                                        Primary Branch
                                    </label>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm remove-branch-btn">
                                    <i class="mdi mdi-delete"></i> Remove
                                </button>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label for="branches_${branchIndex}_branch_name" class="form-label">Branch Name <span class="text-danger">*</span></label>
                                <input type="text" name="branches[${branchIndex}][branch_name]" id="branches_${branchIndex}_branch_name" class="form-control" placeholder="Enter Name of Branch">
                            </div>
                            <div class="col-6">
                                <label for="branches_${branchIndex}_address1" class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                <input type="text" name="branches[${branchIndex}][address1]" id="branches_${branchIndex}_address1" class="form-control" placeholder="Enter Address Line 1">
                            </div>
                            <div class="col-6">
                                <label for="branches_${branchIndex}_address2" class="form-label">Address Line 2</label>
                                <input type="text" name="branches[${branchIndex}][address2]" id="branches_${branchIndex}_address2" class="form-control" placeholder="Enter Address Line 2">
                            </div>
                            <div class="col-6">
                                <label for="branches_${branchIndex}_city" class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" name="branches[${branchIndex}][city]" id="branches_${branchIndex}_city" class="form-control" placeholder="Enter City">
                            </div>
                            <div class="col-4">
                                <label for="branches_${branchIndex}_state" class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" name="branches[${branchIndex}][state]" id="branches_${branchIndex}_state" class="form-control" placeholder="Enter State">
                            </div>
                            <div class="col-4">
                                <label for="branches_${branchIndex}_country" class="form-label">Country <span class="text-danger">*</span></label>
                                <input type="text" name="branches[${branchIndex}][country]" id="branches_${branchIndex}_country" class="form-control" placeholder="Enter Country">
                            </div>
                            <div class="col-4">
                                <label for="branches_${branchIndex}_pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                <input type="text" name="branches[${branchIndex}][pincode]" id="branches_${branchIndex}_pincode" class="form-control" placeholder="Enter Pincode">
                            </div>
                        </div>
                    </div>
                `;

                $('#branches-container').append(branchHtml);
                branchIndex++;
            });

            $(document).on('click', '.remove-branch-btn', function() {
                const branchItem = $(this).closest('.branch-item');
                const wasPrimary = branchItem.find('input[name="is_primary"]:checked').length > 0;

                branchItem.remove();

                if (wasPrimary) {
                    $('.branch-item:first input[name="is_primary"]').prop('checked', true);
                }

                updateBranchNumbers();
            });

            function updateBranchNumbers() {
                $('.branch-item').each(function(index) {
                    $(this).find('h6').text(`Branch #${index + 1}`);
                });
            }
        });
    </script>
@endsection
