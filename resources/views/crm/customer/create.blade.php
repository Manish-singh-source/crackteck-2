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
                                                        '' => '--Select--',
                                                        '0' => 'Male',
                                                        '1' => 'Female',
                                                        '2' => 'Other',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Customer Type',
                                                    'name' => 'customer_type',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        '0' => 'E-commerce',
                                                        '1' => 'AMC',
                                                        '2' => 'Both',
                                                        '3' => 'Offline',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Source Type',
                                                    'name' => 'source_type',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        '0' => 'E-commerce',
                                                        '1' => 'App',
                                                        '2' => 'Call',
                                                        '3' => 'Walk-in',
                                                        '4' => 'Other',
                                                    ],
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
                                                    Aadhar Card Details:
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Aadhar Number',
                                                    'name' => 'aadhar_number',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Aadhar Number',
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Aadhar Front Image',
                                                    'name' => 'aadhar_front_path',
                                                    'type' => 'file',
                                                ])
                                            </div>

                                            <div class="col-4">
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
                                                    'label' => 'Pan Number',
                                                    'name' => 'pan_number',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Pan Number',
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Pan Front Image',
                                                    'name' => 'pan_card_front_path',
                                                    'type' => 'file',
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Pan Back Image',
                                                    'name' => 'pan_card_back_path',
                                                    'type' => 'file',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                                            <!-- First branch (default) -->
                                            <div class="branch-item border rounded p-3 mb-3" data-branch-index="0">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0 text-primary">Branch #1</h6>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="is_primary"
                                                            value="0" id="primary_0" checked>
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
                                                            'name' => 'branches[0][address1]',
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
                                                    <div class="col-4">
                                                        @include('components.form.input', [
                                                            'label' => 'State',
                                                            'name' => 'branches[0][state]',
                                                            'type' => 'text',
                                                            'placeholder' => 'Enter State',
                                                        ])
                                                    </div>
                                                    <div class="col-4">
                                                        @include('components.form.input', [
                                                            'label' => 'Country',
                                                            'name' => 'branches[0][country]',
                                                            'type' => 'text',
                                                            'placeholder' => 'Enter Country',
                                                        ])
                                                    </div>
                                                    <div class="col-4">
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

                            </div>

                            <div class="col-lg-4">
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
                                                    'label' => 'Company Name',
                                                    'name' => 'company_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Company Name',
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'Company Address Line 1',
                                                    'name' => 'comp_address1',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Company Address Line 1',
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'Company Address Line 2',
                                                    'name' => 'comp_address2',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Company Address Line 2',
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'City',
                                                    'name' => 'comp_city',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter City',
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'State',
                                                    'name' => 'comp_state',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter State',
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'Country',
                                                    'name' => 'comp_country',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Country',
                                                ])
                                            </div>

                                            <div class="mb-3">
                                                @include('components.form.input', [
                                                    'label' => 'Pincode',
                                                    'name' => 'comp_pincode',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Pincode',
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
                                        <div class="row">
                                            <div class=" mb-3">
                                                @include('components.form.select', [
                                                    'label' => 'Status',
                                                    'name' => 'status',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        '1' => 'Inactive',
                                                        '2' => 'Active',
                                                        '3' => 'Blocked',
                                                        '4' => 'Suspended',
                                                    ],
                                                ])
                                            </div>
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
            let branchIndex = 1; // Start from 1 since we already have branch 0

            // Add new branch
            $('#add-branch-btn').click(function() {
                const branchHtml = `
                    <div class="branch-item border rounded p-3 mb-3" data-branch-index="${branchIndex}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 text-primary">Branch #${branchIndex + 1}</h6>
                            <div class="d-flex align-items-center gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="primary_branch" value="${branchIndex}" id="primary_${branchIndex}">
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
                                <label for="branches_${branchIndex}_address" class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                <input type="text" name="branches[${branchIndex}][address]" id="branches_${branchIndex}_address" class="form-control" placeholder="Enter Address Line 1">
                            </div>
                            <div class="col-6">
                                <label for="branches_${branchIndex}_address2" class="form-label">Address Line 2</label>
                                <input type="text" name="branches[${branchIndex}][address2]" id="branches_${branchIndex}_address2" class="form-control" placeholder="Enter Address Line 2">
                            </div>
                            <div class="col-6">
                                <label for="branches_${branchIndex}_city" class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" name="branches[${branchIndex}][city]" id="branches_${branchIndex}_city" class="form-control" placeholder="Enter City">
                            </div>
                            <div class="col-6">
                                <label for="branches_${branchIndex}_state" class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" name="branches[${branchIndex}][state]" id="branches_${branchIndex}_state" class="form-control" placeholder="Enter State">
                            </div>
                            <div class="col-6">
                                <label for="branches_${branchIndex}_country" class="form-label">Country <span class="text-danger">*</span></label>
                                <input type="text" name="branches[${branchIndex}][country]" id="branches_${branchIndex}_country" class="form-control" placeholder="Enter Country">
                            </div>
                            <div class="col-6">
                                <label for="branches_${branchIndex}_pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                <input type="text" name="branches[${branchIndex}][pincode]" id="branches_${branchIndex}_pincode" class="form-control" placeholder="Enter Pincode">
                            </div>
                        </div>
                    </div>
                `;

                $('#branches-container').append(branchHtml);
                branchIndex++;
            });

            // Remove branch
            $(document).on('click', '.remove-branch-btn', function() {
                const branchItem = $(this).closest('.branch-item');
                const branchIndexToRemove = branchItem.data('branch-index');

                // If this was the primary branch, make the first remaining branch primary
                const wasPrimary = branchItem.find('input[name="primary_branch"]:checked').length > 0;

                branchItem.remove();

                if (wasPrimary) {
                    $('.branch-item:first input[name="primary_branch"]').prop('checked', true);
                }

                // Update branch numbers
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
