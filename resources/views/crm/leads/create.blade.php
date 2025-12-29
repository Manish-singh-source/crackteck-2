@extends('crm/layouts/master')

@section('content')
    <div class="content">


        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Leads</li>
                            <li class="breadcrumb-item active" aria-current="page">Add Leads</li>
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
                    <form action="{{ route('leads.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-lg-12">
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

                                            <!-- Existing Fields -->
                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'First Name',
                                                    'name' => 'first_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter First Name',
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Last Name',
                                                    'name' => 'last_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Last Name',
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Phone number',
                                                    'name' => 'phone',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Phone number',
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'E-mail address',
                                                    'name' => 'email',
                                                    'type' => 'email',
                                                    'placeholder' => 'Enter E-mail Id',
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Date of Birth',
                                                    'name' => 'dob',
                                                    'type' => 'date',
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.select', [
                                                    'label' => 'Gender',
                                                    'name' => 'gender',
                                                    'options' => [
                                                        '0' => '--Select--',
                                                        'Male' => 'Male',
                                                        'Female' => 'Female',
                                                    ],
                                                ])
                                            </div>

                                            <!-- Lead Management Fields -->
                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Company Name',
                                                    'name' => 'company_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Company Name',
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Designation',
                                                    'name' => 'designation',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Designation',
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.select', [
                                                    'label' => 'Industry Type',
                                                    'name' => 'industry_type',
                                                    'options' => [
                                                        '0' => '--Select Industry Type--',
                                                        'Pharma' => 'Pharma',
                                                        'School' => 'School',
                                                        'Manufacturing' => 'Manufacturing',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.select', [
                                                    'label' => 'Source',
                                                    'name' => 'source',
                                                    'options' => [
                                                        '0' => '--Select Source--',
                                                        'Referral' => 'Referral',
                                                        'Website' => 'Website',
                                                        'Walk-in' => 'Walk-in',
                                                        'Event' => 'Event',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.select', [
                                                    'label' => 'Requirement Type',
                                                    'name' => 'requirement_type',
                                                    'options' => [
                                                        '0' => '--Select Requirement--',
                                                        'Servers' => 'Servers',
                                                        'CCTV' => 'CCTV',
                                                        'Biometric' => 'Biometric',
                                                        'Networking' => 'Networking',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Budget Range',
                                                    'name' => 'budget_range',
                                                    'type' => 'text',
                                                    'placeholder' => 'e.g., 10K-50K',
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.select', [
                                                    'label' => 'Urgency',
                                                    'name' => 'urgency',
                                                    'options' => [
                                                        '0' => '--Select Urgency--',
                                                        'Low' => 'Low',
                                                        'Medium' => 'Medium',
                                                        'High' => 'High',
                                                    ],
                                                ])
                                            </div>
                                            <!--
                                                <div class="col-4">
                                                    <label for="region" class="form-label">Region</label>
                                                <input type="text" name="region" id="region" class="form-control" placeholder="Enter Region">
                                            </div> -->

                                            <!-- <div class="col-4">
                                                <label for="assigned_to" class="form-label">Assigned To</label>
                                                <input type="text" name="assigned_to" id="assigned_to" class="form-control" placeholder="Enter Salesperson Name or ID">
                                            </div> -->

                                            <div class="col-4">
                                                @include('components.form.select', [
                                                    'label' => 'Lead Status',
                                                    'name' => 'status',
                                                    'options' => [
                                                        '0' => '--Select Status--',
                                                        'New' => 'New',
                                                        'Contacted' => 'Contacted',
                                                        'Qualified' => 'Qualified',
                                                        'Quoted' => 'Quoted',
                                                        'Lost' => 'Lost',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.select', [
                                                    'label' => 'Sales Person',
                                                    'name' => 'sales_person_id',
                                                    'options' => $salesPersons->pluck('first_name', 'id')->prepend('--Select Sales Person--', 0),
                                                ])
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <!-- Branch Information Section -->
                                <div class="card mt-3">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Branch Information
                                                </h5>
                                            </div>
                                            <div class="col-sm-auto">
                                                <button type="button" class="btn btn-primary btn-sm" id="add-branch-btn">
                                                    <i class="mdi mdi-plus me-1"></i> Add Branch
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body branch-form-section" style="display: none;">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Branch Name',
                                                    'name' => 'branch_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Branch Name',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Address Line 1',
                                                    'name' => 'address_line1',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Address Line 1',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Address Line 2',
                                                    'name' => 'address_line2',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Address Line 2 (Optional)',
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
                                                    <button type="button" class="btn btn-success" id="save-branch-btn">
                                                        Save Branch
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" id="cancel-branch-btn">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body branch-table-section" style="display: none;">
                                        <table class="table table-striped table-borderless dt-responsive nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Branch Name</th>
                                                    <th>Address</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Country</th>
                                                    <th>Pincode</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="branches-table-body">
                                                <!-- Branches will be added here dynamically -->
                                            </tbody>
                                        </table>
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
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let leadId = null;
            let branches = [];

            // Show branch form when Add Branch button is clicked
            $('#add-branch-btn').on('click', function() {
                $('.branch-form-section').slideDown();
                clearBranchForm();
            });

            // Cancel branch form
            $('#cancel-branch-btn').on('click', function() {
                $('.branch-form-section').slideUp();
                clearBranchForm();
            });

            // Save branch (temporarily store in array until lead is created)
            $('#save-branch-btn').on('click', function() {
                const branchData = {
                    branch_name: $('input[name="branch_name"]').val(),
                    address_line1: $('input[name="address_line1"]').val(),
                    address_line2: $('input[name="address_line2"]').val(),
                    city: $('input[name="city"]').val(),
                    state: $('input[name="state"]').val(),
                    country: $('input[name="country"]').val(),
                    pincode: $('input[name="pincode"]').val()
                };

                // Validate required fields
                if (!branchData.branch_name || !branchData.address_line1 || !branchData.city ||
                    !branchData.state || !branchData.country || !branchData.pincode) {
                    alert('Please fill all required fields');
                    return;
                }

                // Add to temporary array
                branches.push(branchData);

                // Add to table
                addBranchToTable(branchData, branches.length - 1);

                // Hide form and clear
                $('.branch-form-section').slideUp();
                $('.branch-table-section').show();
                clearBranchForm();
            });

            // Delete branch from temporary array
            $(document).on('click', '.delete-branch-temp', function() {
                const index = $(this).data('index');
                branches.splice(index, 1);
                refreshBranchTable();
            });

            // Add branch to table
            function addBranchToTable(branch, index) {
                const address = branch.address_line1 + (branch.address_line2 ? ', ' + branch.address_line2 : '');
                const row = `
                    <tr>
                        <td>${branch.branch_name}</td>
                        <td>${address}</td>
                        <td>${branch.city}</td>
                        <td>${branch.state}</td>
                        <td>${branch.country}</td>
                        <td>${branch.pincode}</td>
                        <td>
                            <button type="button" class="btn btn-icon btn-sm bg-danger-subtle delete-branch-temp" data-index="${index}">
                                <i class="mdi mdi-delete fs-14 text-danger"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#branches-table-body').append(row);
            }

            // Refresh branch table
            function refreshBranchTable() {
                $('#branches-table-body').empty();
                branches.forEach((branch, index) => {
                    addBranchToTable(branch, index);
                });
                if (branches.length === 0) {
                    $('.branch-table-section').hide();
                }
            }

            // Clear branch form
            function clearBranchForm() {
                $('input[name="branch_name"]').val('');
                $('input[name="address_line1"]').val('');
                $('input[name="address_line2"]').val('');
                $('input[name="city"]').val('');
                $('input[name="state"]').val('');
                $('input[name="country"]').val('India');
                $('input[name="pincode"]').val('');
            }

            // Intercept form submission to save branches after lead is created
            $('form').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const formData = new FormData(this);

                // Submit lead first
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // If lead created successfully and there are branches to save
                        if (branches.length > 0) {
                            // Extract lead ID from redirect URL or response
                            // For now, we'll need to modify the controller to return the lead ID
                            saveBranches(response.lead_id);
                        } else {
                            // Redirect to leads index
                            window.location.href = "{{ route('leads.index') }}";
                        }
                    },
                    error: function(xhr) {
                        // Handle validation errors
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = '';
                            for (let field in errors) {
                                errorMessage += errors[field][0] + '\n';
                            }
                            alert(errorMessage);
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    }
                });
            });

            // Save all branches for the created lead
            function saveBranches(leadId) {
                let savedCount = 0;
                branches.forEach((branch, index) => {
                    branch.lead_id = leadId;
                    $.ajax({
                        url: "{{ route('leads.branches.store') }}",
                        method: 'POST',
                        data: {
                            ...branch,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            savedCount++;
                            if (savedCount === branches.length) {
                                window.location.href = "{{ route('leads.index') }}";
                            }
                        }
                    });
                });
            }
        });
    </script>
@endsection
