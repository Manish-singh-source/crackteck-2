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
                            <li class="breadcrumb-item active" aria-current="page">Edit Leads</li>
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
                    <form action="{{ route('leads.update', $lead->id) }}" method="POST">
                        @csrf
                        @method('PUT')
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
                                                    'model' => $lead,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Last Name',
                                                    'name' => 'last_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Last Name',
                                                    'model' => $lead,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Phone number',
                                                    'name' => 'phone',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Phone number',
                                                    'model' => $lead,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'E-mail address',
                                                    'name' => 'email',
                                                    'type' => 'email',
                                                    'placeholder' => 'Enter E-mail Id',
                                                    'model' => $lead,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Date of Birth',
                                                    'name' => 'dob',
                                                    'type' => 'date',
                                                    'model' => $lead,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.select', [
                                                    'label' => 'Gender',
                                                    'name' => 'gender',
                                                    'options' => [
                                                        '0' => '--Select--',
                                                        'male' => 'Male',
                                                        'female' => 'Female',
                                                    ],
                                                    'model' => $lead,
                                                ])
                                            </div>

                                            <!-- Lead Management Fields -->
                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Company Name',
                                                    'name' => 'company_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Company Name',
                                                    'model' => $lead,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Designation',
                                                    'name' => 'designation',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Designation',
                                                    'model' => $lead,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.select', [
                                                    'label' => 'Industry Type',
                                                    'name' => 'industry_type',
                                                    'options' => [
                                                        '0' => '--Select Industry Type--',
                                                        'pharma' => 'Pharma',
                                                        'school' => 'School',
                                                        'manufacturing' => 'Manufacturing',
                                                    ],
                                                    'model' => $lead,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.select', [
                                                    'label' => 'Source',
                                                    'name' => 'source',
                                                    'options' => [
                                                        '0' => '--Select Source--',
                                                        'referral' => 'Referral',
                                                        'website' => 'Website',
                                                        'walk_in' => 'Walk-in',
                                                        'event' => 'Event',
                                                    ],
                                                    'model' => $lead,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.select', [
                                                    'label' => 'Requirement Type',
                                                    'name' => 'requirement_type',
                                                    'options' => [
                                                        '0' => '--Select Requirement--',
                                                        'servers' => 'Servers',
                                                        'cctv' => 'CCTV',
                                                        'biometric' => 'Biometric',
                                                        'networking' => 'Networking',
                                                    ],
                                                    'model' => $lead,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Budget Range',
                                                    'name' => 'budget_range',
                                                    'type' => 'text',
                                                    'placeholder' => 'e.g., 10K-50K',
                                                    'model' => $lead,
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
                                                    'model' => $lead,
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
                                                    'model' => $lead,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.select', [
                                                    'label' => 'Sales Person',
                                                    'name' => 'user_id',
                                                    'options' => $salesPersons->pluck('first_name', 'id')->prepend('--Select Sales Person--', 0),
                                                    'model' => $lead,
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
                                        <input type="hidden" id="edit-branch-id" value="">
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

                                    <div class="card-body branch-table-section">
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
                                                @foreach ($lead->branches as $branch)
                                                    <tr data-branch-id="{{ $branch->id }}">
                                                        <td>{{ $branch->branch_name }}</td>
                                                        <td>
                                                            {{ $branch->address_line1 }}
                                                            @if ($branch->address_line2)
                                                                , {{ $branch->address_line2 }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $branch->city }}</td>
                                                        <td>{{ $branch->state }}</td>
                                                        <td>{{ $branch->country }}</td>
                                                        <td>{{ $branch->pincode }}</td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-icon btn-sm bg-primary-subtle edit-branch"
                                                                data-id="{{ $branch->id }}"
                                                                data-branch-name="{{ $branch->branch_name }}"
                                                                data-address-line1="{{ $branch->address_line1 }}"
                                                                data-address-line2="{{ $branch->address_line2 }}"
                                                                data-city="{{ $branch->city }}"
                                                                data-state="{{ $branch->state }}"
                                                                data-country="{{ $branch->country }}"
                                                                data-pincode="{{ $branch->pincode }}">
                                                                <i class="mdi mdi-pencil fs-14 text-primary"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-icon btn-sm bg-danger-subtle delete-branch"
                                                                data-id="{{ $branch->id }}">
                                                                <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
            const leadId = {{ $lead->id }};
            let editingBranchId = null;

            // Show branch form when Add Branch button is clicked
            $('#add-branch-btn').on('click', function() {
                editingBranchId = null;
                $('#edit-branch-id').val('');
                $('.branch-form-section').slideDown();
                clearBranchForm();
            });

            // Cancel branch form
            $('#cancel-branch-btn').on('click', function() {
                $('.branch-form-section').slideUp();
                clearBranchForm();
                editingBranchId = null;
            });

            // Save or Update branch
            $('#save-branch-btn').on('click', function() {
                const branchData = {
                    lead_id: leadId,
                    branch_name: $('input[name="branch_name"]').val(),
                    address_line1: $('input[name="address_line1"]').val(),
                    address_line2: $('input[name="address_line2"]').val(),
                    city: $('input[name="city"]').val(),
                    state: $('input[name="state"]').val(),
                    country: $('input[name="country"]').val(),
                    pincode: $('input[name="pincode"]').val(),
                    _token: '{{ csrf_token() }}'
                };

                // Validate required fields
                if (!branchData.branch_name || !branchData.address_line1 || !branchData.city ||
                    !branchData.state || !branchData.country || !branchData.pincode) {
                    alert('Please fill all required fields');
                    return;
                }

                const url = editingBranchId ?
                    "{{ url('/crm/leads/branches') }}/" + editingBranchId :
                    "{{ route('leads.branches.store') }}";

                const method = editingBranchId ? 'PUT' : 'POST';

                if (editingBranchId) {
                    branchData._method = 'PUT';
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: branchData,
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload(); // Reload to show updated branches
                        }
                    },
                    error: function(xhr) {
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

            // Edit branch
            $(document).on('click', '.edit-branch', function() {
                editingBranchId = $(this).data('id');
                $('#edit-branch-id').val(editingBranchId);

                $('input[name="branch_name"]').val($(this).data('branch-name'));
                $('input[name="address_line1"]').val($(this).data('address-line1'));
                $('input[name="address_line2"]').val($(this).data('address-line2'));
                $('input[name="city"]').val($(this).data('city'));
                $('input[name="state"]').val($(this).data('state'));
                $('input[name="country"]').val($(this).data('country'));
                $('input[name="pincode"]').val($(this).data('pincode'));

                $('.branch-form-section').slideDown();
            });

            // Delete branch
            $(document).on('click', '.delete-branch', function() {
                if (!confirm('Are you sure you want to delete this branch?')) {
                    return;
                }

                const branchId = $(this).data('id');

                $.ajax({
                    url: "{{ url('/crm/leads/branches') }}/" + branchId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('tr[data-branch-id="' + branchId + '"]').remove();
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            });

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
        });
    </script>
@endsection
