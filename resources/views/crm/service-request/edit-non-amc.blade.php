@extends('crm/layouts/master')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Non-AMC Service Request</h4>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('service-request.update-non-amc', $service->id) }}" method="POST" enctype="multipart/form-data" id="nonAmcEditForm">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12">
                    <!-- Customer Details Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Customer Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 pb-3">
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $service->first_name) }}" placeholder="Enter First Name" required>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $service->last_name) }}" placeholder="Enter Last Name" required>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $service->phone) }}" placeholder="Enter Phone Number" required>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $service->email) }}" placeholder="Enter Email" required>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="dob" class="form-label">Date Of Birth</label>
                                        <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob', $service->dob ? $service->dob->format('Y-m-d') : '') }}">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="gender" class="form-label">Gender</label>
                                        <select name="gender" id="gender" class="form-select">
                                            <option value="">--Select Gender--</option>
                                            <option value="Male" {{ old('gender', $service->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender', $service->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ old('gender', $service->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="customer_type" class="form-label">Customer Type</label>
                                        <select name="customer_type" id="customer_type" class="form-select">
                                            <option value="">--Select--</option>
                                            <option value="Individual" {{ old('customer_type', $service->customer_type) == 'Individual' ? 'selected' : '' }}>Individual</option>
                                            <option value="Business" {{ old('customer_type', $service->customer_type) == 'Business' ? 'selected' : '' }}>Business</option>
                                            <option value="Corporate" {{ old('customer_type', $service->customer_type) == 'Corporate' ? 'selected' : '' }}>Corporate</option>
                                            <option value="SME" {{ old('customer_type', $service->customer_type) == 'SME' ? 'selected' : '' }}>SME</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="address_line1" class="form-label">Address Line 1</label>
                                        <input type="text" name="address_line1" id="address_line1" class="form-control" value="{{ old('address_line1', $service->address_line1) }}" placeholder="Enter Address Line 1">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="address_line2" class="form-label">Address Line 2</label>
                                        <input type="text" name="address_line2" id="address_line2" class="form-control" value="{{ old('address_line2', $service->address_line2) }}" placeholder="Enter Address Line 2">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $service->city) }}" placeholder="Enter City">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="state" class="form-label">State</label>
                                        <input type="text" name="state" id="state" class="form-control" value="{{ old('state', $service->state) }}" placeholder="Enter State">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" name="country" id="country" class="form-control" value="{{ old('country', $service->country) }}" placeholder="Enter Country">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="pincode" class="form-label">Pin Code</label>
                                        <input type="text" name="pincode" id="pincode" class="form-control" value="{{ old('pincode', $service->pincode) }}" placeholder="Enter Pin Code">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company Details Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Company Details (Optional)</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 pb-3">
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="company_name" class="form-label">Company Name</label>
                                        <input type="text" name="company_name" id="company_name" class="form-control" value="{{ old('company_name', $service->company_name) }}" placeholder="Enter Company Name">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="branch_name" class="form-label">Branch Name</label>
                                        <input type="text" name="branch_name" id="branch_name" class="form-control" value="{{ old('branch_name', $service->branch_name) }}" placeholder="Enter Branch Name">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="gst_no" class="form-label">GST Number</label>
                                        <input type="text" name="gst_no" id="gst_no" class="form-control" value="{{ old('gst_no', $service->gst_no) }}" placeholder="Enter GST Number">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="pan_no" class="form-label">PAN Number</label>
                                        <input type="text" name="pan_no" id="pan_no" class="form-control" value="{{ old('pan_no', $service->pan_no) }}" placeholder="Enter PAN Number">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Service Details Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Service Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 pb-3">
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="service_type" class="form-label">Service Type</label>
                                        <select name="service_type" id="service_type" class="form-select">
                                            <option value="">--Select Type--</option>
                                            <option value="Online" {{ old('service_type', $service->service_type) == 'Online' ? 'selected' : '' }}>Online</option>
                                            <option value="Offline" {{ old('service_type', $service->service_type) == 'Offline' ? 'selected' : '' }}>Offline</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="priority_level" class="form-label">Priority Level</label>
                                        <select name="priority_level" id="priority_level" class="form-select">
                                            <option value="">--Select Level--</option>
                                            <option value="High" {{ old('priority_level', $service->priority_level) == 'High' ? 'selected' : '' }}>High</option>
                                            <option value="Medium" {{ old('priority_level', $service->priority_level) == 'Medium' ? 'selected' : '' }}>Medium</option>
                                            <option value="Low" {{ old('priority_level', $service->priority_level) == 'Low' ? 'selected' : '' }}>Low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="Pending" {{ old('status', $service->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="In Progress" {{ old('status', $service->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="Completed" {{ old('status', $service->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="Cancelled" {{ old('status', $service->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="total_amount" class="form-label">Total Amount</label>
                                        <input type="number" name="total_amount" id="total_amount" class="form-control" value="{{ old('total_amount', $service->total_amount) }}" placeholder="Enter Total Amount" step="0.01">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="profile_image" class="form-label">Profile Image</label>
                                        <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*">
                                        @if($service->profile_image)
                                            <small class="text-muted">Current: {{ $service->profile_image }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="customer_image" class="form-label">Customer Image</label>
                                        <input type="file" name="customer_image" id="customer_image" class="form-control" accept="image/*">
                                        @if($service->customer_image)
                                            <small class="text-muted">Current: {{ $service->customer_image }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div>
                                        <label for="additional_notes" class="form-label">Additional Notes</label>
                                        <textarea name="additional_notes" id="additional_notes" class="form-control" rows="3" placeholder="Enter any additional notes">{{ old('additional_notes', $service->additional_notes) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Card -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Products</h5>
                            <button type="button" class="btn btn-sm btn-primary" id="addProductBtn">
                                <i class="mdi mdi-plus"></i> Add Product
                            </button>
                        </div>
                        <div class="card-body" id="productsContainer">
                            @foreach($service->products as $index => $product)
                            <div class="product-entry border rounded p-3 mb-3 position-relative" data-index="{{ $index }}">
                                <input type="hidden" name="products[{{ $index }}][id]" value="{{ $product->id }}">
                                @if($index > 0)
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-product-btn">
                                    <i class="mdi mdi-close"></i>
                                </button>
                                @endif
                                <div class="row g-3 pb-3">
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                            <input type="text" name="products[{{ $index }}][product_name]" class="form-control" value="{{ old('products.'.$index.'.product_name', $product->product_name) }}" placeholder="Dell Inspiron 15 Laptop Windows 11" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label class="form-label">Product Type</label>
                                            <select name="products[{{ $index }}][product_type]" class="form-select">
                                                <option value="">--Select Type--</option>
                                                <option value="Computer" {{ old('products.'.$index.'.product_type', $product->product_type) == 'Computer' ? 'selected' : '' }}>Computer</option>
                                                <option value="Laptop" {{ old('products.'.$index.'.product_type', $product->product_type) == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                                                <option value="Accessories" {{ old('products.'.$index.'.product_type', $product->product_type) == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                                                <option value="Other" {{ old('products.'.$index.'.product_type', $product->product_type) == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label class="form-label">Product Brand</label>
                                            <input type="text" name="products[{{ $index }}][product_brand]" class="form-control" value="{{ old('products.'.$index.'.product_brand', $product->product_brand) }}" placeholder="Dell, HP, Asus">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label class="form-label">Model Number</label>
                                            <input type="text" name="products[{{ $index }}][model_no]" class="form-control" value="{{ old('products.'.$index.'.model_no', $product->model_no) }}" placeholder="Inspiron 3511">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label class="form-label">Serial Number</label>
                                            <input type="text" name="products[{{ $index }}][serial_no]" class="form-control" value="{{ old('products.'.$index.'.serial_no', $product->serial_no) }}" placeholder="B0BB7FQBBS">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label class="form-label">Purchase Date</label>
                                            <input type="date" name="products[{{ $index }}][purchase_date]" class="form-control" value="{{ old('products.'.$index.'.purchase_date', $product->purchase_date ? $product->purchase_date->format('Y-m-d') : '') }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label class="form-label">Product Image</label>
                                            <input type="file" name="products[{{ $index }}][product_image]" class="form-control" accept="image/*">
                                            @if($product->product_image)
                                                <small class="text-muted">Current: {{ $product->product_image }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label class="form-label">Issue Type</label>
                                            <input type="text" name="products[{{ $index }}][issue_type]" class="form-control" value="{{ old('products.'.$index.'.issue_type', $product->issue_type) }}" placeholder="Enter Issue Type">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label class="form-label">Warranty Status</label>
                                            <select name="products[{{ $index }}][warranty_status]" class="form-select">
                                                <option value="Unknown" {{ old('products.'.$index.'.warranty_status', $product->warranty_status) == 'Unknown' ? 'selected' : '' }}>Unknown</option>
                                                <option value="In Warranty" {{ old('products.'.$index.'.warranty_status', $product->warranty_status) == 'In Warranty' ? 'selected' : '' }}>In Warranty</option>
                                                <option value="Out of Warranty" {{ old('products.'.$index.'.warranty_status', $product->warranty_status) == 'Out of Warranty' ? 'selected' : '' }}>Out of Warranty</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div>
                                            <label class="form-label">Issue Description</label>
                                            <textarea name="products[{{ $index }}][issue_description]" class="form-control" rows="3" placeholder="Describe the issue in detail">{{ old('products.'.$index.'.issue_description', $product->issue_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="col-lg-12">
                        <div class="text-start mb-3">
                            <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                <i class="mdi mdi-content-save"></i> Update Service Request
                            </button>
                            <a href="{{ route('service-request.view-non-amc', $service->id) }}" class="btn btn-secondary w-sm waves ripple-light">
                                <i class="mdi mdi-cancel"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let productIndex = {{ $service->products->count() }};

    document.getElementById('addProductBtn').addEventListener('click', function() {
        const container = document.getElementById('productsContainer');
        const newProduct = `
            <div class="product-entry border rounded p-3 mb-3 position-relative" data-index="${productIndex}">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-product-btn">
                    <i class="mdi mdi-close"></i>
                </button>
                <div class="row g-3 pb-3">
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="products[\${productIndex}][product_name]" class="form-control" placeholder="Dell Inspiron 15 Laptop Windows 11" required>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Product Type</label>
                            <select name="products[\${productIndex}][product_type]" class="form-select">
                                <option value="">--Select Type--</option>
                                <option value="Computer">Computer</option>
                                <option value="Laptop">Laptop</option>
                                <option value="Accessories">Accessories</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Product Brand</label>
                            <input type="text" name="products[\${productIndex}][product_brand]" class="form-control" placeholder="Dell, HP, Asus">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Model Number</label>
                            <input type="text" name="products[\${productIndex}][model_no]" class="form-control" placeholder="Inspiron 3511">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Serial Number</label>
                            <input type="text" name="products[\${productIndex}][serial_no]" class="form-control" placeholder="B0BB7FQBBS">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Purchase Date</label>
                            <input type="date" name="products[\${productIndex}][purchase_date]" class="form-control">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Product Image</label>
                            <input type="file" name="products[\${productIndex}][product_image]" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Issue Type</label>
                            <input type="text" name="products[\${productIndex}][issue_type]" class="form-control" placeholder="Enter Issue Type">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Warranty Status</label>
                            <select name="products[\${productIndex}][warranty_status]" class="form-select">
                                <option value="Unknown">Unknown</option>
                                <option value="In Warranty">In Warranty</option>
                                <option value="Out of Warranty">Out of Warranty</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div>
                            <label class="form-label">Issue Description</label>
                            <textarea name="products[\${productIndex}][issue_description]" class="form-control" rows="3" placeholder="Describe the issue in detail"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newProduct);
        productIndex++;
    });

    // Event delegation for remove buttons
    document.getElementById('productsContainer').addEventListener('click', function(e) {
        if (e.target.closest('.remove-product-btn')) {
            const productEntry = e.target.closest('.product-entry');
            if (document.querySelectorAll('.product-entry').length > 1) {
                if (confirm('Are you sure you want to remove this product?')) {
                    productEntry.remove();
                }
            } else {
                alert('At least one product is required.');
            }
        }
    });
</script>

@endsection
