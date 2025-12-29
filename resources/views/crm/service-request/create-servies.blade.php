@extends('crm/layouts/master')

@section('content')

    <div class="content">

        <div class="container-fluid">
            <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Create Non-AMC Service Request</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('service-request.store-non-amc') }}" method="POST" enctype="multipart/form-data"
                        id="nonAmcForm">
                        @csrf

                        {{-- Global validation error summary --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h5 class="mb-2">Please fix the following errors:</h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Service Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 pb-3">
                                    <div class="col-4">
                                        @include('components.form.select', [
                                            'label' => 'Service Type',
                                            'name' => 'service_type',
                                            'options' => [
                                                '' => '--Select Service Type--',
                                                'Online' => 'Online',
                                                'Offline' => 'Offline',
                                            ],
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Customer Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 pb-3">
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.select', [
                                                'label' => 'Customer Type',
                                                'name' => 'customer_type',
                                                'options' => [
                                                    '' => '--Select Customer Type--',
                                                    'Individual' => 'Individual',
                                                    'Business' => 'Business',
                                                ],
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'First Name',
                                                'name' => 'first_name',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your First Name',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Last Name',
                                                'name' => 'last_name',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Last Name',
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Phone Number',
                                                'name' => 'phone',
                                                'type' => 'text',
                                                'placeholder' => '+91 000 000 XXXX',
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Email ID',
                                                'name' => 'email',
                                                'type' => 'email',
                                                'placeholder' => 'example@gamil.com',
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Address Line 1',
                                                'name' => 'address_line1',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Address',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Address Line 2',
                                                'name' => 'address_line2',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Address 2',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Country',
                                                'name' => 'country',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Country',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'State',
                                                'name' => 'state',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your State',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'City',
                                                'name' => 'city',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your City',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Pin Code',
                                                'name' => 'pincode',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Pin Code',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'DOB',
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
                                                'options' => [
                                                    '' => '--Select Gender--',
                                                    'Male' => 'Male',
                                                    'Female' => 'Female',
                                                    'Other' => 'Other',
                                                ],
                                            ])
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
                            <div class="card-body">
                                <div class="row g-3 pb-3">
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Company Name',
                                                'name' => 'company_name',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Company Name',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Branch Name',
                                                'name' => 'branch_name',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Branch Name',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'GST Number',
                                                'name' => 'gst_no',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your GST Number',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'PAN Number',
                                                'name' => 'pan_no',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your PAN Number',
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
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.select', [
                                                'label' => 'Priority Level',
                                                'name' => 'priority_level',
                                                'options' => [
                                                    '' => '--Select Level --',
                                                    'High' => 'High',
                                                    'Medium' => 'Medium',
                                                    'Low' => 'Low',
                                                ],
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div>
                                            <label for="additional_notes" class="form-label">Additional Notes</label>
                                            <textarea name="additional_notes" class="form-control" id="additional_notes" rows="3"
                                                placeholder="Enter any additional notes"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Product Details</h5>
                                <button type="button" class="btn btn-sm btn-primary" id="addProductBtn">
                                    <i class="mdi mdi-plus"></i> Add Product
                                </button>
                            </div>
                            <div class="card-body" id="productsContainer">
                                <div class="product-entry border rounded p-3 mb-3" data-index="0">
                                    <div class="row g-3 pb-3">
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                <label for="products[0][product_name]" class="form-label">Product Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="products[0][product_name]" class="form-control"
                                                    placeholder="Dell Inspiron 15 Laptop Windows 11" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                <label for="products[0][product_type]" class="form-label">Product
                                                    Type</label>
                                                <select name="products[0][product_type]" class="form-select">
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
                                                <label for="products[0][product_brand]" class="form-label">Product
                                                    Brand</label>
                                                <input type="text" name="products[0][product_brand]" class="form-control"
                                                    placeholder="Dell, HP, Asus">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                <label for="products[0][model_no]" class="form-label">Model Number</label>
                                                <input type="text" name="products[0][model_no]" class="form-control"
                                                    placeholder="Inspiron 3511">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                <label for="products[0][serial_no]" class="form-label">Serial
                                                    Number</label>
                                                <input type="text" name="products[0][serial_no]" class="form-control"
                                                    placeholder="B0BB7FQBBS">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                <label for="products[0][purchase_date]" class="form-label">Purchase
                                                    Date</label>
                                                <input type="date" name="products[0][purchase_date]"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                <label for="products[0][product_image]" class="form-label">Product
                                                    Image</label>
                                                <input type="file" name="products[0][product_image]"
                                                    class="form-control" accept="image/*">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                <label for="products[0][issue_type]" class="form-label">Issue Type</label>
                                                <input type="text" name="products[0][issue_type]" class="form-control"
                                                    placeholder="Enter Issue Type">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                <label for="products[0][warranty_status]" class="form-label">Warranty
                                                    Status</label>
                                                <select name="products[0][warranty_status]" class="form-select">
                                                    <option value="Unknown">Unknown</option>
                                                    <option value="In Warranty">In Warranty</option>
                                                    <option value="Out of Warranty">Out of Warranty</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div>
                                                <label for="products[0][issue_description]" class="form-label">Issue
                                                    Description</label>
                                                <textarea name="products[0][issue_description]" class="form-control" rows="3"
                                                    placeholder="Describe the issue in detail"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="text-start mb-3">
                                <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                    <i class="mdi mdi-content-save"></i> Submit Service Request
                                </button>
                                <a href="{{ route('service-request.index') }}"
                                    class="btn btn-secondary w-sm waves ripple-light">
                                    <i class="mdi mdi-cancel"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let productIndex = 1;

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
                            <input type="text" name="products[${productIndex}][product_name]" class="form-control" placeholder="Dell Inspiron 15 Laptop Windows 11" required>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Product Type</label>
                            <select name="products[${productIndex}][product_type]" class="form-select">
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
                            <input type="text" name="products[${productIndex}][product_brand]" class="form-control" placeholder="Dell, HP, Asus">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Model Number</label>
                            <input type="text" name="products[${productIndex}][model_no]" class="form-control" placeholder="Inspiron 3511">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Serial Number</label>
                            <input type="text" name="products[${productIndex}][serial_no]" class="form-control" placeholder="B0BB7FQBBS">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Purchase Date</label>
                            <input type="date" name="products[${productIndex}][purchase_date]" class="form-control">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Product Image</label>
                            <input type="file" name="products[${productIndex}][product_image]" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Issue Type</label>
                            <input type="text" name="products[${productIndex}][issue_type]" class="form-control" placeholder="Enter Issue Type">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Warranty Status</label>
                            <select name="products[${productIndex}][warranty_status]" class="form-select">
                                <option value="Unknown">Unknown</option>
                                <option value="In Warranty">In Warranty</option>
                                <option value="Out of Warranty">Out of Warranty</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div>
                            <label class="form-label">Issue Description</label>
                            <textarea name="products[${productIndex}][issue_description]" class="form-control" rows="3" placeholder="Describe the issue in detail"></textarea>
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
                    productEntry.remove();
                } else {
                    alert('At least one product is required.');
                }
            }
        });
    </script>

@endsection
