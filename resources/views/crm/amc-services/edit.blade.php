@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit AMC Service</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('amc-services.update', $amcService->id) }}" method="POST"
                        enctype="multipart/form-data" id="amcEditForm">
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
                                            <label for="first_name" class="form-label">First Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="first_name" id="first_name" class="form-control"
                                                value="{{ old('first_name', $amcService->first_name) }}"
                                                placeholder="Enter First Name" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label for="last_name" class="form-label">Last Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="last_name" id="last_name" class="form-control"
                                                value="{{ old('last_name', $amcService->last_name) }}"
                                                placeholder="Enter Last Name" required>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label for="phone" class="form-label">Phone Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="phone" id="phone" class="form-control"
                                                value="{{ old('phone', $amcService->phone) }}"
                                                placeholder="Enter Phone Number" required>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label for="email" class="form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                value="{{ old('email', $amcService->email) }}" placeholder="Enter Email"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label for="dob" class="form-label">Date Of Birth</label>
                                            <input type="date" name="dob" id="dob" class="form-control"
                                                value="{{ old('dob', $amcService->dob ? $amcService->dob->format('Y-m-d') : '') }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label for="gender" class="form-label">Gender</label>
                                            <select name="gender" id="gender" class="form-select">
                                                <option value="">--Select Gender--</option>
                                                <option value="Male"
                                                    {{ old('gender', $amcService->gender) == 'Male' ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="Female"
                                                    {{ old('gender', $amcService->gender) == 'Female' ? 'selected' : '' }}>
                                                    Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label for="customer_type" class="form-label">Customer Type</label>
                                            <select name="customer_type" id="customer_type" class="form-select">
                                                <option value="">--Select--</option>
                                                <option value="Individual"
                                                    {{ old('customer_type', $amcService->customer_type) == 'Individual' ? 'selected' : '' }}>
                                                    Individual</option>
                                                <option value="Business"
                                                    {{ old('customer_type', $amcService->customer_type) == 'Business' ? 'selected' : '' }}>
                                                    Business</option>
                                            </select>
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
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label for="company_name" class="form-label">Company Name</label>
                                            <input type="text" name="company_name" id="company_name" class="form-control"
                                                value="{{ old('company_name', $amcService->company_name) }}"
                                                placeholder="Enter Company Name">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label for="company_address" class="form-label">Company Address</label>
                                            <input type="text" name="company_address" id="company_address"
                                                class="form-control"
                                                value="{{ old('company_address', $amcService->company_address) }}"
                                                placeholder="Enter Company Address">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label for="gst_no" class="form-label">GST Number</label>
                                            <input type="text" name="gst_no" id="gst_no" class="form-control"
                                                value="{{ old('gst_no', $amcService->gst_no) }}"
                                                placeholder="Enter GST Number">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label for="pan_no" class="form-label">PAN Number</label>
                                            <input type="text" name="pan_no" id="pan_no" class="form-control"
                                                value="{{ old('pan_no', $amcService->pan_no) }}"
                                                placeholder="Enter PAN Number">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label for="pic" class="form-label">Profile Image</label>
                                            <input type="file" name="pic" id="pic" class="form-control">
                                            @if ($amcService->pic)
                                                <small class="text-muted">Current: <a
                                                        href="{{ asset($amcService->pic) }}" target="_blank">View
                                                        Image</a></small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label for="image" class="form-label">Customer Image</label>
                                            <input type="file" name="image" id="image" class="form-control">
                                            @if ($amcService->image)
                                                <small class="text-muted">Current: <a
                                                        href="{{ asset($amcService->image) }}" target="_blank">View
                                                        Image</a></small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div
                                class="card-header border-bottom-dashed d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    Branch Information
                                </h5>
                                <button type="button" class="btn btn-sm btn-primary" id="addBranchBtn">
                                    <i class="mdi mdi-plus"></i> Add Branch
                                </button>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-borderless dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>Branch Name</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Pincode</th>
                                            <th>Contact</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="branchTableBody">
                                        @foreach ($amcService->branches as $index => $branch)
                                            <tr class="align-middle branch-row" data-branch-id="{{ $branch->id }}">
                                                <td>{{ $branch->branch_name }}</td>
                                                <td>{{ $branch->address_line1 }}{{ $branch->address_line2 ? ', ' . $branch->address_line2 : '' }}
                                                </td>
                                                <td>{{ $branch->city }}</td>
                                                <td>{{ $branch->state }}</td>
                                                <td>{{ $branch->pincode }}</td>
                                                <td>{{ $branch->contact_person ?? '-' }}<br>{{ $branch->contact_no ?? '-' }}
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-icon btn-sm bg-warning-subtle editBranchBtn"
                                                        data-branch-id="{{ $branch->id }}"
                                                        data-branch-name="{{ $branch->branch_name }}"
                                                        data-address-line1="{{ $branch->address_line1 }}"
                                                        data-address-line2="{{ $branch->address_line2 }}"
                                                        data-city="{{ $branch->city }}"
                                                        data-state="{{ $branch->state }}"
                                                        data-country="{{ $branch->country }}"
                                                        data-pincode="{{ $branch->pincode }}"
                                                        data-contact-person="{{ $branch->contact_person }}"
                                                        data-contact-no="{{ $branch->contact_no }}">
                                                        <i class="mdi mdi-pencil fs-14 text-warning"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-icon btn-sm bg-danger-subtle removeBranchBtn"
                                                        data-branch-id="{{ $branch->id }}">
                                                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                    </button>
                                                </td>
                                                <!-- Hidden inputs for existing branches -->
                                                <input type="hidden" name="existing_branches[{{ $index }}][id]"
                                                    value="{{ $branch->id }}">
                                                <input type="hidden"
                                                    name="existing_branches[{{ $index }}][branch_name]"
                                                    value="{{ $branch->branch_name }}">
                                                <input type="hidden"
                                                    name="existing_branches[{{ $index }}][address_line1]"
                                                    value="{{ $branch->address_line1 }}">
                                                <input type="hidden"
                                                    name="existing_branches[{{ $index }}][address_line2]"
                                                    value="{{ $branch->address_line2 }}">
                                                <input type="hidden" name="existing_branches[{{ $index }}][city]"
                                                    value="{{ $branch->city }}">
                                                <input type="hidden"
                                                    name="existing_branches[{{ $index }}][state]"
                                                    value="{{ $branch->state }}">
                                                <input type="hidden"
                                                    name="existing_branches[{{ $index }}][pincode]"
                                                    value="{{ $branch->pincode }}">
                                                <input type="hidden"
                                                    name="existing_branches[{{ $index }}][contact_person]"
                                                    value="{{ $branch->contact_person }}">
                                                <input type="hidden"
                                                    name="existing_branches[{{ $index }}][contact_no]"
                                                    value="{{ $branch->contact_no }}">
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body">
                                <div id="branchContainer">
                                    <!-- Branch forms will be added here dynamically -->
                                </div>
                            </div>
                        </div>
                        

                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Product Information</h5>
                                <button type="button" class="btn btn-sm btn-primary" id="addProductBtn">
                                    <i class="mdi mdi-plus"></i> Add Product
                                </button>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-borderless dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Brand</th>
                                            <th>Model Number</th>
                                            <th>Serial Number</th>
                                            <th>Branch</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBody">
                                        @foreach ($amcService->products as $index => $product)
                                            <tr class="align-middle product-row" data-product-id="{{ $product->id }}">
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->type->parent_categories ?? '-' }}</td>
                                                <td>{{ $product->brand->brand_title ?? '-' }}</td>
                                                <td>{{ $product->model_no ?? '-' }}</td>
                                                <td>{{ $product->serial_no ?? '-' }}</td>
                                                <td>{{ $product->branch->branch_name ?? 'N/A' }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-icon btn-sm bg-warning-subtle editProductBtn"
                                                        data-product-id="{{ $product->id }}"
                                                        data-product-name="{{ $product->product_name }}"
                                                        data-product-type="{{ $product->product_type }}"
                                                        data-product-brand="{{ $product->product_brand }}"
                                                        data-model-no="{{ $product->model_no }}"
                                                        data-serial-no="{{ $product->serial_no }}"
                                                        data-purchase-date="{{ $product->purchase_date ? $product->purchase_date->format('Y-m-d') : '' }}"
                                                        data-warranty-status="{{ $product->warranty_status }}"
                                                        data-branch-id="{{ $product->amc_branch_id }}">
                                                        <i class="mdi mdi-pencil fs-14 text-warning"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-icon btn-sm bg-danger-subtle removeProductBtn"
                                                        data-product-id="{{ $product->id }}">
                                                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                    </button>
                                                </td>
                                                <!-- Hidden inputs for existing products -->
                                                <input type="hidden" name="existing_products[{{ $index }}][id]"
                                                    value="{{ $product->id }}">
                                                <input type="hidden"
                                                    name="existing_products[{{ $index }}][product_name]"
                                                    value="{{ $product->product_name }}">
                                                <input type="hidden"
                                                    name="existing_products[{{ $index }}][product_type]"
                                                    value="{{ $product->product_type }}">
                                                <input type="hidden"
                                                    name="existing_products[{{ $index }}][product_brand]"
                                                    value="{{ $product->product_brand }}">
                                                <input type="hidden"
                                                    name="existing_products[{{ $index }}][model_no]"
                                                    value="{{ $product->model_no }}">
                                                <input type="hidden"
                                                    name="existing_products[{{ $index }}][serial_no]"
                                                    value="{{ $product->serial_no }}">
                                                <input type="hidden"
                                                    name="existing_products[{{ $index }}][purchase_date]"
                                                    value="{{ $product->purchase_date ? $product->purchase_date->format('Y-m-d') : '' }}">
                                                <input type="hidden"
                                                    name="existing_products[{{ $index }}][warranty_status]"
                                                    value="{{ $product->warranty_status }}">
                                                <input type="hidden"
                                                    name="existing_products[{{ $index }}][branch_id]"
                                                    value="{{ $product->amc_branch_id }}">
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body">
                                <div id="productContainer">
                                    <!-- Product forms will be added here dynamically -->
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">AMC Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 pb-3">
                                    <div class="col-md-4">
                                        <label for="amc_plan_id" class="form-label">Select Plan <span
                                                class="text-danger">*</span></label>
                                        <select name="amc_plan_id" id="amc_plan_id" class="form-select" required>
                                            <option value="">--Select Plan--</option>
                                            @foreach ($amcPlans as $plan)
                                                <option value="{{ $plan->id }}"
                                                    data-duration="{{ $plan->duration }}"
                                                    data-amount="{{ $plan->amount }}"
                                                    {{ old('amc_plan_id', $amcService->amc_plan_id) == $plan->id ? 'selected' : '' }}>
                                                    {{ $plan->plan_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="plan_duration" class="form-label">Plan Duration</label>
                                        <input type="text" name="plan_duration" id="plan_duration"
                                            class="form-control"
                                            value="{{ old('plan_duration', $amcService->plan_duration) }}" readonly>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="plan_start_date" class="form-label">Preferred Start Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="plan_start_date" id="plan_start_date"
                                            class="form-control"
                                            value="{{ old('plan_start_date', $amcService->plan_start_date ? $amcService->plan_start_date->format('Y-m-d') : '') }}"
                                            required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="plan_end_date" class="form-label">Plan End Date</label>
                                        <input type="date" name="plan_end_date" id="plan_end_date"
                                            class="form-control"
                                            value="{{ old('plan_end_date', $amcService->plan_end_date ? $amcService->plan_end_date->format('Y-m-d') : '') }}"
                                            readonly>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="total_amount" class="form-label">Total Amount</label>
                                        <input type="number" name="total_amount" id="total_amount" class="form-control"
                                            value="{{ old('total_amount', $amcService->total_amount) }}" step="0.01"
                                            readonly>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="priority_level" class="form-label">Priority Level</label>
                                        <select name="priority_level" id="priority_level" class="form-select">
                                            <option value="">--Select--</option>
                                            <option value="High"
                                                {{ old('priority_level', $amcService->priority_level) == 'High' ? 'selected' : '' }}>
                                                High</option>
                                            <option value="Medium"
                                                {{ old('priority_level', $amcService->priority_level) == 'Medium' ? 'selected' : '' }}>
                                                Medium</option>
                                            <option value="Low"
                                                {{ old('priority_level', $amcService->priority_level) == 'Low' ? 'selected' : '' }}>
                                                Low</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="Pending"
                                                {{ old('status', $amcService->status) == 'Pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="Active"
                                                {{ old('status', $amcService->status) == 'Active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="Expired"
                                                {{ old('status', $amcService->status) == 'Expired' ? 'selected' : '' }}>
                                                Expired</option>
                                            <option value="Cancelled"
                                                {{ old('status', $amcService->status) == 'Cancelled' ? 'selected' : '' }}>
                                                Cancelled</option>
                                        </select>
                                    </div>

                                    <div class="col-md-8">
                                        <label for="additional_notes" class="form-label">Additional Notes</label>
                                        <textarea name="additional_notes" id="additional_notes" class="form-control" rows="2"
                                            placeholder="Enter Additional Notes">{{ old('additional_notes', $amcService->additional_notes) }}</textarea>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-start">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="mdi mdi-content-save"></i> Update AMC Service
                                            </button>
                                            <a href="{{ route('amc-services.index') }}" class="btn btn-secondary">
                                                <i class="mdi mdi-arrow-left"></i> Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let branchCounter = {{ $amcService->branches->count() }};
        let productCounter = {{ $amcService->products->count() }};
        let branchIndex = branchCounter;
        let productIndex = productCounter;
        let newBranches = [];
        let newProducts = [];
        let editingBranchId = null;
        let editingProductId = null;

        $(document).ready(function() {
            // AMC Plan selection - auto-fill duration and amount
            $('#amc_plan_id').change(function() {
                const selectedOption = $(this).find('option:selected');
                const duration = selectedOption.data('duration');
                const amount = selectedOption.data('amount');

                $('#plan_duration').val(duration || '');
                $('#total_amount').val(amount || '');

                // Calculate end date if start date is selected
                if ($('#plan_start_date').val()) {
                    calculateEndDate();
                }
            });

            // Calculate end date when start date changes
            $('#plan_start_date').change(function() {
                calculateEndDate();
            });

            function calculateEndDate() {
                const startDate = $('#plan_start_date').val();
                const duration = $('#plan_duration').val();

                if (startDate && duration) {
                    const start = new Date(startDate);
                    const months = parseInt(duration);

                    if (!isNaN(months)) {
                        start.setMonth(start.getMonth() + months);
                        const endDate = start.toISOString().split('T')[0];
                        $('#plan_end_date').val(endDate);
                    }
                }
            }

            // Add Branch functionality
            $('#addBranchBtn').click(function() {
                editingBranchId = null;
                showBranchForm();
            });

            function showBranchForm(branchData = null) {
                const isEdit = branchData !== null;
                const formHtml = `
                <div class="card mb-3 branch-form-card" id="branchFormCard">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">${isEdit ? 'Edit Branch' : 'Add New Branch'}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Branch Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="branch_name_input" value="${branchData?.branch_name || ''}" placeholder="Enter Branch Name">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address_line1_input" value="${branchData?.address_line1 || ''}" placeholder="Enter Address Line 1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Address Line 2</label>
                                <input type="text" class="form-control" id="address_line2_input" value="${branchData?.address_line2 || ''}" placeholder="Enter Address Line 2">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="city_input" value="${branchData?.city || ''}" placeholder="Enter City">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="state_input" value="${branchData?.state || ''}" placeholder="Enter State">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="pincode_input" value="${branchData?.pincode || ''}" placeholder="Enter Pincode">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Contact Person</label>
                                <input type="text" class="form-control" id="contact_person_input" value="${branchData?.contact_person || ''}" placeholder="Contact Person">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Contact No</label>
                                <input type="text" class="form-control" id="contact_no_input" value="${branchData?.contact_no || ''}" placeholder="Contact Number">
                            </div>
                            <div class="col-12">
                                <div class="text-end">
                                    <button type="button" class="btn btn-success" id="saveBranchBtn">
                                        <i class="mdi mdi-content-save"></i> ${isEdit ? 'Update' : 'Save'} Branch
                                    </button>
                                    <button type="button" class="btn btn-secondary" id="cancelBranchBtn">
                                        <i class="mdi mdi-close"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                $('#branchContainer').html(formHtml);
            }

            // Save Branch
            $(document).on('click', '#saveBranchBtn', function() {
                const branchName = $('#branch_name_input').val().trim();
                const addressLine1 = $('#address_line1_input').val().trim();
                const addressLine2 = $('#address_line2_input').val().trim();
                const city = $('#city_input').val().trim();
                const state = $('#state_input').val().trim();
                const pincode = $('#pincode_input').val().trim();
                const contactPerson = $('#contact_person_input').val().trim();
                const contactNo = $('#contact_no_input').val().trim();

                if (!branchName || !addressLine1 || !city || !state || !pincode) {
                    alert('Please fill all required branch fields');
                    return;
                }

                if (editingBranchId) {
                    // Update existing branch
                    updateBranchRow(editingBranchId, {
                        branch_name: branchName,
                        address_line1: addressLine1,
                        address_line2: addressLine2,
                        city: city,
                        state: state,
                        pincode: pincode,
                        contact_person: contactPerson,
                        contact_no: contactNo
                    });
                } else {
                    // Add new branch
                    addBranchRow({
                        branch_name: branchName,
                        address_line1: addressLine1,
                        address_line2: addressLine2,
                        city: city,
                        state: state,
                        pincode: pincode,
                        contact_person: contactPerson,
                        contact_no: contactNo
                    });
                }

                $('#branchContainer').html('');
                editingBranchId = null;
            });

            // Cancel Branch Form
            $(document).on('click', '#cancelBranchBtn', function() {
                $('#branchContainer').html('');
                editingBranchId = null;
            });

            function addBranchRow(branchData) {
                branchIndex++;
                const row = `
                <tr class="align-middle branch-row" data-branch-index="${branchIndex}">
                    <td>${branchData.branch_name}</td>
                    <td>${branchData.address_line1}${branchData.address_line2 ? ', ' + branchData.address_line2 : ''}</td>
                    <td>${branchData.city}</td>
                    <td>${branchData.state}</td>
                    <td>${branchData.pincode}</td>
                    <td>${branchData.contact_person || '-'}<br>${branchData.contact_no || '-'}</td>
                    <td>
                        <button type="button" class="btn btn-icon btn-sm bg-warning-subtle editBranchBtn" data-branch-index="${branchIndex}">
                            <i class="mdi mdi-pencil fs-14 text-warning"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-sm bg-danger-subtle removeBranchBtn" data-branch-index="${branchIndex}">
                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                        </button>
                    </td>
                    <input type="hidden" name="branches[${branchIndex}][branch_name]" value="${branchData.branch_name}">
                    <input type="hidden" name="branches[${branchIndex}][address_line1]" value="${branchData.address_line1}">
                    <input type="hidden" name="branches[${branchIndex}][address_line2]" value="${branchData.address_line2}">
                    <input type="hidden" name="branches[${branchIndex}][city]" value="${branchData.city}">
                    <input type="hidden" name="branches[${branchIndex}][state]" value="${branchData.state}">
                    <input type="hidden" name="branches[${branchIndex}][pincode]" value="${branchData.pincode}">
                    <input type="hidden" name="branches[${branchIndex}][contact_person]" value="${branchData.contact_person}">
                    <input type="hidden" name="branches[${branchIndex}][contact_no]" value="${branchData.contact_no}">
                </tr>
            `;
                $('#branchTableBody').append(row);
            }

            function updateBranchRow(branchId, branchData) {
                const row = $(`.branch-row[data-branch-id="${branchId}"]`);
                if (row.length) {
                    row.find('td:eq(0)').text(branchData.branch_name);
                    row.find('td:eq(1)').text(branchData.address_line1 + (branchData.address_line2 ? ', ' +
                        branchData.address_line2 : ''));
                    row.find('td:eq(2)').text(branchData.city);
                    row.find('td:eq(3)').text(branchData.state);
                    row.find('td:eq(4)').text(branchData.pincode);
                    row.find('td:eq(5)').html((branchData.contact_person || '-') + '<br>' + (branchData
                        .contact_no || '-'));

                    // Update hidden inputs
                    row.find('input[name*="[branch_name]"]').val(branchData.branch_name);
                    row.find('input[name*="[address_line1]"]').val(branchData.address_line1);
                    row.find('input[name*="[address_line2]"]').val(branchData.address_line2);
                    row.find('input[name*="[city]"]').val(branchData.city);
                    row.find('input[name*="[state]"]').val(branchData.state);
                    row.find('input[name*="[pincode]"]').val(branchData.pincode);
                    row.find('input[name*="[contact_person]"]').val(branchData.contact_person);
                    row.find('input[name*="[contact_no]"]').val(branchData.contact_no);
                }
            }

            // Edit Branch
            $(document).on('click', '.editBranchBtn', function() {
                const branchId = $(this).data('branch-id');
                editingBranchId = branchId;

                const branchData = {
                    branch_name: $(this).data('branch-name'),
                    address_line1: $(this).data('address-line1'),
                    address_line2: $(this).data('address-line2'),
                    city: $(this).data('city'),
                    state: $(this).data('state'),
                    pincode: $(this).data('pincode'),
                    contact_person: $(this).data('contact-person'),
                    contact_no: $(this).data('contact-no')
                };

                showBranchForm(branchData);
            });

            // Remove Branch
            $(document).on('click', '.removeBranchBtn', function() {
                if (confirm('Are you sure you want to remove this branch?')) {
                    $(this).closest('tr').remove();
                }
            });

            // Add Product functionality
            $('#addProductBtn').click(function() {
                editingProductId = null;
                showProductForm();
            });

            function showProductForm(productData = null) {
                const isEdit = productData !== null;

                // Get available branches for dropdown
                let branchOptions = '<option value="">--Select Branch--</option>';
                @foreach ($amcService->branches as $branch)
                    branchOptions +=
                        `<option value="{{ $branch->id }}" ${productData?.branch_id == {{ $branch->id }} ? 'selected' : ''}>{{ $branch->branch_name }}</option>`;
                @endforeach

                // Add new branches from table
                $('#branchTableBody tr[data-branch-index]').each(function() {
                    const branchIndex = $(this).data('branch-index');
                    const branchName = $(this).find('input[name*="[branch_name]"]').val();
                    branchOptions +=
                        `<option value="new_${branchIndex}" ${productData?.branch_id == 'new_' + branchIndex ? 'selected' : ''}>${branchName}</option>`;
                });

                const formHtml = `
                <div class="card mb-3 product-form-card" id="productFormCard">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">${isEdit ? 'Edit Product' : 'Add New Product'}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="product_name_input" value="${productData?.product_name || ''}" placeholder="Enter Product Name">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Product Type</label>
                                <select class="form-select" id="product_type_input">
                                    <option value="">--Select--</option>
                                    @foreach ($productTypes as $type)
                                        <option value="{{ $type->id }}" ${productData?.product_type == {{ $type->id }} ? 'selected' : ''}>{{ $type->parent_categories }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Product Brand</label>
                                <select class="form-select" id="product_brand_input">
                                    <option value="">--Select--</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" ${productData?.product_brand == {{ $brand->id }} ? 'selected' : ''}>{{ $brand->brand_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Model Number</label>
                                <input type="text" class="form-control" id="model_no_input" value="${productData?.model_no || ''}" placeholder="Model Number">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Serial Number</label>
                                <input type="text" class="form-control" id="serial_no_input" value="${productData?.serial_no || ''}" placeholder="Serial Number">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Purchase Date</label>
                                <input type="date" class="form-control" id="purchase_date_input" value="${productData?.purchase_date || ''}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Warranty Status</label>
                                <select class="form-select" id="warranty_status_input">
                                    <option value="">--Select--</option>
                                    <option value="In Warranty" ${productData?.warranty_status == 'In Warranty' ? 'selected' : ''}>In Warranty</option>
                                    <option value="Out of Warranty" ${productData?.warranty_status == 'Out of Warranty' ? 'selected' : ''}>Out of Warranty</option>
                                    <option value="Extended" ${productData?.warranty_status == 'Extended' ? 'selected' : ''}>Extended</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Select Branch <span class="text-danger">*</span></label>
                                <select class="form-select" id="branch_id_input">
                                    ${branchOptions}
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="text-end">
                                    <button type="button" class="btn btn-success" id="saveProductBtn">
                                        <i class="mdi mdi-content-save"></i> ${isEdit ? 'Update' : 'Save'} Product
                                    </button>
                                    <button type="button" class="btn btn-secondary" id="cancelProductBtn">
                                        <i class="mdi mdi-close"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                $('#productContainer').html(formHtml);
            }

            // Save Product
            $(document).on('click', '#saveProductBtn', function() {
                const productName = $('#product_name_input').val().trim();
                const productType = $('#product_type_input').val();
                const productBrand = $('#product_brand_input').val();
                const modelNo = $('#model_no_input').val().trim();
                const serialNo = $('#serial_no_input').val().trim();
                const purchaseDate = $('#purchase_date_input').val();
                const warrantyStatus = $('#warranty_status_input').val();
                const branchId = $('#branch_id_input').val();

                if (!productName || !branchId) {
                    alert('Please enter product name and select a branch');
                    return;
                }

                const productTypeText = $('#product_type_input option:selected').text();
                const productBrandText = $('#product_brand_input option:selected').text();
                const branchName = $('#branch_id_input option:selected').text();

                if (editingProductId) {
                    // Update existing product
                    updateProductRow(editingProductId, {
                        product_name: productName,
                        product_type: productType,
                        product_type_text: productTypeText,
                        product_brand: productBrand,
                        product_brand_text: productBrandText,
                        model_no: modelNo,
                        serial_no: serialNo,
                        purchase_date: purchaseDate,
                        warranty_status: warrantyStatus,
                        branch_id: branchId,
                        branch_name: branchName
                    });
                } else {
                    // Add new product
                    addProductRow({
                        product_name: productName,
                        product_type: productType,
                        product_type_text: productTypeText,
                        product_brand: productBrand,
                        product_brand_text: productBrandText,
                        model_no: modelNo,
                        serial_no: serialNo,
                        purchase_date: purchaseDate,
                        warranty_status: warrantyStatus,
                        branch_id: branchId,
                        branch_name: branchName
                    });
                }

                $('#productContainer').html('');
                editingProductId = null;
            });

            // Cancel Product Form
            $(document).on('click', '#cancelProductBtn', function() {
                $('#productContainer').html('');
                editingProductId = null;
            });

            function addProductRow(productData) {
                productIndex++;
                const row = `
                <tr class="align-middle product-row" data-product-index="${productIndex}">
                    <td>${productData.product_name}</td>
                    <td>${productData.product_type_text || '-'}</td>
                    <td>${productData.product_brand_text || '-'}</td>
                    <td>${productData.model_no || '-'}</td>
                    <td>${productData.serial_no || '-'}</td>
                    <td>${productData.branch_name}</td>
                    <td>
                        <button type="button" class="btn btn-icon btn-sm bg-warning-subtle editProductBtn" data-product-index="${productIndex}">
                            <i class="mdi mdi-pencil fs-14 text-warning"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-sm bg-danger-subtle removeProductBtn" data-product-index="${productIndex}">
                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                        </button>
                    </td>
                    <input type="hidden" name="products[${productIndex}][product_name]" value="${productData.product_name}">
                    <input type="hidden" name="products[${productIndex}][product_type]" value="${productData.product_type}">
                    <input type="hidden" name="products[${productIndex}][product_brand]" value="${productData.product_brand}">
                    <input type="hidden" name="products[${productIndex}][model_no]" value="${productData.model_no}">
                    <input type="hidden" name="products[${productIndex}][serial_no]" value="${productData.serial_no}">
                    <input type="hidden" name="products[${productIndex}][purchase_date]" value="${productData.purchase_date}">
                    <input type="hidden" name="products[${productIndex}][warranty_status]" value="${productData.warranty_status}">
                    <input type="hidden" name="products[${productIndex}][branch_id]" value="${productData.branch_id}">
                </tr>
            `;
                $('#productTableBody').append(row);
            }

            function updateProductRow(productId, productData) {
                const row = $(`.product-row[data-product-id="${productId}"]`);
                if (row.length) {
                    row.find('td:eq(0)').text(productData.product_name);
                    row.find('td:eq(1)').text(productData.product_type_text || '-');
                    row.find('td:eq(2)').text(productData.product_brand_text || '-');
                    row.find('td:eq(3)').text(productData.model_no || '-');
                    row.find('td:eq(4)').text(productData.serial_no || '-');
                    row.find('td:eq(5)').text(productData.branch_name);

                    // Update hidden inputs
                    row.find('input[name*="[product_name]"]').val(productData.product_name);
                    row.find('input[name*="[product_type]"]').val(productData.product_type);
                    row.find('input[name*="[product_brand]"]').val(productData.product_brand);
                    row.find('input[name*="[model_no]"]').val(productData.model_no);
                    row.find('input[name*="[serial_no]"]').val(productData.serial_no);
                    row.find('input[name*="[purchase_date]"]').val(productData.purchase_date);
                    row.find('input[name*="[warranty_status]"]').val(productData.warranty_status);
                    row.find('input[name*="[branch_id]"]').val(productData.branch_id);
                }
            }

            // Edit Product
            $(document).on('click', '.editProductBtn', function() {
                const productId = $(this).data('product-id');
                editingProductId = productId;

                const productData = {
                    product_name: $(this).data('product-name'),
                    product_type: $(this).data('product-type'),
                    product_brand: $(this).data('product-brand'),
                    model_no: $(this).data('model-no'),
                    serial_no: $(this).data('serial-no'),
                    purchase_date: $(this).data('purchase-date'),
                    warranty_status: $(this).data('warranty-status'),
                    branch_id: $(this).data('branch-id')
                };

                showProductForm(productData);
            });

            // Remove Product
            $(document).on('click', '.removeProductBtn', function() {
                if (confirm('Are you sure you want to remove this product?')) {
                    $(this).closest('tr').remove();
                }
            });

        });
    </script>
@endsection
