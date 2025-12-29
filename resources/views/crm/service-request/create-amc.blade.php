@extends('crm/layouts/master')

@section('content')

<div class="content">

    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Create AMC</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form action="{{ route('service-request.store-amc') }}" method="POST" enctype="multipart/form-data" id="amcForm">
                    @csrf

                    {{-- Global validation error summary so user sees why submit failed --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h5 class="mb-2">Please fix the following errors:</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Customer Details</h5>
                    </div>
                    <div class="card-body">
                            <div class="row g-3 pb-3">
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'First Name',
                                        'name' => 'first_name',
                                        'type' => 'text',
                                        'placeholder' => "Enter Your First Name"
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Last Name',
                                        'name' => 'last_name',
                                        'type' => 'text',
                                        'placeholder' => "Enter Your Last Name"
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Phone Number',
                                        'name' => 'phone',
                                        'type' => 'text',
                                        'placeholder' => "Enter Your Phone Number"
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Email',
                                        'name' => 'email',
                                        'type' => 'email',
                                        'placeholder' => "Enter Email Id"
                                        ])
                                    </div>
                                </div>


                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Date Of Birth',
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
                                        'options' => ["0" => "--Select Gender --", "1" => "Male", "2" => "Female"]
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.select', [
                                        'label' => 'Customer Type',
                                        'name' => 'customer_type',
                                        'options' => ["0" => "--Select --", "1" => "Type 1", "2" => "Type 2"]
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
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Company Name',
                                        'name' => 'company_name',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your Company Name'
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Company Address',
                                        'name' => 'company_address',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your Company Address'
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'GST Number',
                                        'name' => 'gst_no',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your GST Number'
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'PAN Number',
                                        'name' => 'pan_no',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Your PAN Number'
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Profile Image',
                                        'name' => 'profile_image',
                                        'type' => 'file',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Customer Image',
                                        'name' => 'customer_image',
                                        'type' => 'file',
                                        ])

                                    </div>
                                    <div id="image-preview-section">

                                    </div>
                                </div>

                                {{-- Source Type --}}
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <input type="hidden" name="source_type_label" value="admin_panel" readonly>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="card pb-4">
                    <div class="card-header border-bottom-dashed d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            Branch Information
                        </h5>
                        <button type="button" class="btn btn-sm btn-primary" id="addBranchBtn">
                            <i class="mdi mdi-plus"></i> Add Branch
                        </button>
                    </div>

                    <div class="card-body">
                        <div id="branchContainer">
                            <!-- Branch forms will be added here dynamically -->
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <h5 class="card-title mb-0">
                            Added Branches
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-borderless dt-responsive nowrap" id="branchesTable">
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
                            <tbody id="branchesTableBody">
                                <!-- Branches will be added here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Product Details</h5>
                        <button type="button" class="btn btn-sm btn-primary" id="addProductBtn">
                            <i class="mdi mdi-plus"></i> Add Product
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="productContainer">
                            <!-- Product forms will be added here dynamically -->
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Added Products</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-borderless dt-responsive nowrap" id="productsTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Brand</th>
                                    <th>Model Number</th>
                                    <th>Serial Number</th>
                                    <th>Purchase Date</th>
                                    <th>Branch</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="productsTableBody">
                                <!-- Products will be added here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">AMC Details</h5>
                    </div>
                    <div class="card-body">
                            <div class="row g-3 pb-3">
                                <div class="col-4">
                                    <label for="amc_plan_id" class="form-label">Select Plan <span class="text-danger">*</span></label>
                                    <select name="amc_plan_id" id="amc_plan_id" class="form-select">
                                        <option value="">--Select Plan--</option>
                                        @foreach($amcPlans as $plan)
                                            <option value="{{ $plan->id }}" data-cost="{{ $plan->total_cost }}" data-duration="{{ $plan->duration }}">
                                                {{ $plan->plan_name }} - {{ $plan->plan_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="plan_duration" class="form-label">Plan Duration</label>
                                    <input type="text" name="plan_duration" id="plan_duration" class="form-control" readonly placeholder="Auto-filled">
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Preferred Start Date',
                                        'name' => 'plan_start_date',
                                        'type' => 'date',
                                        'placeholder' => 'Enter Start Date',
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <label for="total_amount" class="form-label">Total Amount</label>
                                    <input type="number" name="total_amount" id="total_amount" class="form-control" step="0.01" readonly placeholder="Auto-filled">
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.select', [
                                            'label' => 'Priority Level',
                                        'name' => 'priority_level',
                                        'options' => ["" => "--Select--", "High" => "High", "Medium" => "Medium", "Low" => "Low"]
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Additional Notes',
                                        'name' => 'additional_notes',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Additional Notes',
                                        ])
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="text-start">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="mdi mdi-content-save"></i> Submit AMC Request
                                        </button>
                                        <a href="{{ route('service-request.index') }}" class="btn btn-secondary">
                                            <i class="mdi mdi-cancel"></i> Cancel
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
    let branchIndex = 0;
    let productIndex = 0;
    let branches = [];
    let products = [];

    // Add Branch
    document.getElementById('addBranchBtn').addEventListener('click', function() {
        const branchHtml = `
            <div class="branch-form border p-3 mb-3 rounded" data-index="${branchIndex}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Branch #${branchIndex + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger remove-branch-form">
                        <i class="mdi mdi-close"></i>
                    </button>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Branch Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control branch-name" placeholder="Enter Branch Name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control branch-address1" placeholder="Enter Address Line 1" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" class="form-control branch-address2" placeholder="Enter Address Line 2">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control branch-city" placeholder="Enter City" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">State <span class="text-danger">*</span></label>
                        <input type="text" class="form-control branch-state" placeholder="Enter State" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control branch-country" placeholder="Enter Country" value="India">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pincode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control branch-pincode" placeholder="Enter Pincode" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contact Person</label>
                        <input type="text" class="form-control branch-contact-person" placeholder="Enter Contact Person">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contact Number</label>
                        <input type="text" class="form-control branch-contact-no" placeholder="Enter Contact Number">
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-success save-branch">
                            <i class="mdi mdi-check"></i> Save Branch
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('branchContainer').insertAdjacentHTML('beforeend', branchHtml);
        branchIndex++;

        // Attach event listeners
        attachBranchEventListeners();
    });

    function attachBranchEventListeners() {
        // Remove branch form
        document.querySelectorAll('.remove-branch-form').forEach(btn => {
            btn.onclick = function() {
                this.closest('.branch-form').remove();
            };
        });

        // Save branch
        document.querySelectorAll('.save-branch').forEach(btn => {
            btn.onclick = function() {
                const form = this.closest('.branch-form');
                const index = form.dataset.index;

                const branchData = {
                    index: index,
                    branch_name: form.querySelector('.branch-name').value,
                    address_line1: form.querySelector('.branch-address1').value,
                    address_line2: form.querySelector('.branch-address2').value,
                    city: form.querySelector('.branch-city').value,
                    state: form.querySelector('.branch-state').value,
                    country: form.querySelector('.branch-country').value,
                    pincode: form.querySelector('.branch-pincode').value,
                    contact_person: form.querySelector('.branch-contact-person').value,
                    contact_no: form.querySelector('.branch-contact-no').value,
                };

                // Validate required fields
                if (!branchData.branch_name || !branchData.address_line1 || !branchData.city || !branchData.state || !branchData.pincode) {
                    alert('Please fill all required fields');
                    return;
                }

                // Add to branches array
                branches.push(branchData);

                // Add to table
                addBranchToTable(branchData);

                // Remove form
                form.remove();
            };
        });
    }

    function addBranchToTable(branch) {
        const row = `
            <tr data-branch-index="${branch.index}">
                <td>${branch.branch_name}</td>
                <td>${branch.address_line1}${branch.address_line2 ? ', ' + branch.address_line2 : ''}</td>
                <td>${branch.city}</td>
                <td>${branch.state}</td>
                <td>${branch.pincode}</td>
                <td>${branch.contact_person || '-'}<br>${branch.contact_no || '-'}</td>
                <td>
                    <button type="button" class="btn btn-icon btn-sm bg-danger-subtle remove-branch" data-index="${branch.index}">
                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                    </button>
                </td>
            </tr>
        `;

        document.getElementById('branchesTableBody').insertAdjacentHTML('beforeend', row);

        // Attach remove event
        document.querySelectorAll('.remove-branch').forEach(btn => {
            btn.onclick = function() {
                const index = this.dataset.index;
                branches = branches.filter(b => b.index != index);
                this.closest('tr').remove();
                updateBranchDropdown();
            };
        });

        updateBranchDropdown();
    }

    function updateBranchDropdown() {
        const selects = document.querySelectorAll('.product-branch-select');
        selects.forEach(select => {
            const currentValue = select.value;
            select.innerHTML = '<option value="">--Select Branch--</option>';
            branches.forEach(branch => {
                const option = document.createElement('option');
                option.value = branch.index;
                option.textContent = branch.branch_name;
                if (currentValue == branch.index) {
                    option.selected = true;
                }
                select.appendChild(option);
            });
        });
    }

    // Add Product
    document.getElementById('addProductBtn').addEventListener('click', function() {
        const productHtml = `
            <div class="product-form border p-3 mb-3 rounded" data-index="${productIndex}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Product #${productIndex + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger remove-product-form">
                        <i class="mdi mdi-close"></i>
                    </button>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control product-name" placeholder="Enter Product Name" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Product Type</label>
                        <select class="form-select product-type">
                            <option value="">--Select--</option>
                            @foreach($productTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->parent_categories }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Product Brand</label>
                        <select class="form-select product-brand">
                            <option value="">--Select--</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->brand_title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Model Number</label>
                        <input type="text" class="form-control product-model" placeholder="Enter Model Number">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Serial Number</label>
                        <input type="text" class="form-control product-serial" placeholder="Enter Serial Number">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Purchase Date</label>
                        <input type="date" class="form-control product-purchase-date">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Warranty Status</label>
                        <select class="form-select product-warranty">
                            <option value="Out of Warranty">Out of Warranty</option>
                            <option value="In Warranty">In Warranty</option>
                            <option value="Extended">Extended</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Select Branch</label>
                        <select class="form-select product-branch-select">
                            <option value="">--Select Branch--</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-success save-product">
                            <i class="mdi mdi-check"></i> Save Product
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('productContainer').insertAdjacentHTML('beforeend', productHtml);
        productIndex++;

        // Update branch dropdown
        updateBranchDropdown();

        // Attach event listeners
        attachProductEventListeners();
    });

    function attachProductEventListeners() {
        // Remove product form
        document.querySelectorAll('.remove-product-form').forEach(btn => {
            btn.onclick = function() {
                this.closest('.product-form').remove();
            };
        });

        // Save product
        document.querySelectorAll('.save-product').forEach(btn => {
            btn.onclick = function() {
                const form = this.closest('.product-form');
                const index = form.dataset.index;

                const productData = {
                    index: index,
                    product_name: form.querySelector('.product-name').value,
                    product_type: form.querySelector('.product-type').value,
                    product_brand: form.querySelector('.product-brand').value,
                    model_no: form.querySelector('.product-model').value,
                    serial_no: form.querySelector('.product-serial').value,
                    purchase_date: form.querySelector('.product-purchase-date').value,
                    warranty_status: form.querySelector('.product-warranty').value,
                    amc_branch_id: form.querySelector('.product-branch-select').value,
                    branch_name: form.querySelector('.product-branch-select').selectedOptions[0]?.text || '-'
                };

                // Validate required fields
                if (!productData.product_name) {
                    alert('Please enter product name');
                    return;
                }

                // Add to products array
                products.push(productData);

                // Add to table
                addProductToTable(productData);

                // Remove form
                form.remove();
            };
        });
    }

    function addProductToTable(product) {
        const row = `
            <tr data-product-index="${product.index}">
                <td>${product.product_name}</td>
                <td>${product.product_type || '-'}</td>
                <td>${product.product_brand || '-'}</td>
                <td>${product.model_no || '-'}</td>
                <td>${product.serial_no || '-'}</td>
                <td>${product.purchase_date || '-'}</td>
                <td>${product.branch_name}</td>
                <td>
                    <button type="button" class="btn btn-icon btn-sm bg-danger-subtle remove-product" data-index="${product.index}">
                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                    </button>
                </td>
            </tr>
        `;

        document.getElementById('productsTableBody').insertAdjacentHTML('beforeend', row);

        // Attach remove event
        document.querySelectorAll('.remove-product').forEach(btn => {
            btn.onclick = function() {
                const index = this.dataset.index;
                products = products.filter(p => p.index != index);
                this.closest('tr').remove();
            };
        });
    }

    // AMC Plan selection
    document.getElementById('amc_plan_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const cost = selectedOption.dataset.cost;
        const duration = selectedOption.dataset.duration;

        document.getElementById('total_amount').value = cost || '';
        document.getElementById('plan_duration').value = duration || '';
    });

    // Form submission
    document.getElementById('amcForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Validate branches
        if (branches.length === 0) {
            alert('Please add at least one branch');
            return;
        }

        // Validate products
        if (products.length === 0) {
            alert('Please add at least one product');
            return;
        }

        // Before submitting the form, append hidden inputs for dynamic arrays so they are sent to server
        // Remove any previously appended dynamic inputs (in case of re-submit)
        document.querySelectorAll('#amcForm .dynamic-input').forEach(el => el.remove());

        // Append branches
        branches.forEach((branch, index) => {
            Object.keys(branch).forEach(key => {
                // only append scalar values (skip index property)
                if (key === 'index') return;
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `branches[${index}][${key}]`;
                input.value = branch[key] ?? '';
                input.classList.add('dynamic-input');
                this.appendChild(input);
            });
        });

        // Append products
        products.forEach((product, index) => {
            Object.keys(product).forEach(key => {
                if (key === 'index') return;
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `products[${index}][${key}]`;
                input.value = product[key] ?? '';
                input.classList.add('dynamic-input');
                this.appendChild(input);
            });
        });

        // Now submit the form normally (files and other inputs remain intact)
        this.submit();
    });
</script>
@endsection