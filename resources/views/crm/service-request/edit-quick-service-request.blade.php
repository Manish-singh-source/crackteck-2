@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit Quick Service Request</h4>
                </div>
            </div>

            {{-- Alerts --}}
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
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('service-request.update-quick-service-request', $request->id) }}" method="POST"
                        enctype="multipart/form-data" id="nonAmcForm">
                        @csrf
                        @method('PUT')

                        {{-- Header card (request info) --}}
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        {{ $request->request_id }}
                                    </h5>
                                    {{-- <div>
                                    @php $status = $request->status; @endphp
                                    @if ($status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($status == 'processing')
                                        <span class="badge bg-info">Processing</span>
                                    @elseif($status == 'active')
                                        <span class="badge bg-primary">Active</span>
                                    @elseif($status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($status == 'cancel')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </div> --}}
                                </div>
                            </div>
                        </div>

                        {{-- CUSTOMER DETAILS (same UI as create, prefilled) --}}
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Customer Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 pb-3">

                                    {{-- hidden service_type = 1 (Quick Service) --}}
                                    <input type="hidden" name="service_type" value="1">

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Email ID',
                                                'name' => 'email',
                                                'type' => 'email',
                                                'placeholder' => 'example@gmail.com',
                                                'value' => old('email', $request->customer->email ?? ''),
                                                'model' => $request->customer,
                                            ])
                                        </div>

                                        {{-- Existing Customer Preview – optional on edit --}}
                                        <div id="existingCustomerBox" class="alert alert-info mt-2 d-none">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong id="ec_name"></strong>
                                                    <div class="small text-muted" id="ec_email"></div>
                                                    <div class="small text-muted" id="ec_phone"></div>
                                                    <div class="small text-muted" id="ec_address"></div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-primary" id="btnUseCustomer">
                                                    Use this customer
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'First Name',
                                                'name' => 'first_name',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your First Name',
                                                'value' => old('first_name', $request->customer->first_name ?? ''),
                                                'model' => $request->customer,
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
                                                'value' => old('last_name', $request->customer->last_name ?? ''),
                                                'model' => $request->customer,
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
                                                'value' => old('phone', $request->customer->phone ?? ''),
                                                'model' => $request->customer,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'DOB',
                                                'name' => 'dob',
                                                'type' => 'date',
                                                'value' => old('dob', $request->customer->dob ?? ''),
                                                'model' => $request->customer,
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
                                                    '0' => 'Male',
                                                    '1' => 'Female',
                                                    '2' => 'Other',
                                                ],
                                                'value' => old('gender', $request->customer->gender ?? ''),
                                                'model' => $request->customer,
                                            ])
                                        </div>
                                    </div>

                                    {{-- CUSTOMER ADDRESS (from customerAddress relation) --}}
                                    @php $addr = $request->customerAddress; @endphp

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Branch Name',
                                                'name' => 'branch_name',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Branch Name',
                                                'value' => old('branch_name', $addr->branch_name ?? ''),
                                                'model' => $request->customerAddress,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Address Line 1',
                                                'name' => 'address1',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Address',
                                                'value' => old('address1', $addr->address1 ?? ''),
                                                'model' => $request->customerAddress,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Address Line 2',
                                                'name' => 'address2',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Address 2',
                                                'value' => old('address2', $addr->address2 ?? ''),
                                                'model' => $request->customerAddress,
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
                                                'value' => old('country', $addr->country ?? ''),
                                                'model' => $request->customerAddress,
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
                                                'value' => old('state', $addr->state ?? ''),
                                                'model' => $request->customerAddress,
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
                                                'value' => old('city', $addr->city ?? ''),
                                                'model' => $request->customerAddress,
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
                                                'value' => old('pincode', $addr->pincode ?? ''),
                                                'model' => $request->customerAddress,
                                            ])
                                        </div>
                                    </div>

                                    {{-- Source Type --}}
                                    <input type="hidden" name="source_type_label" value="admin_panel" readonly>
                                </div>
                            </div>

                            {{-- COMPANY DETAILS (same card as create, prefilled from customerCompany) --}}
                            <div class="card-body">
                                <div class="row g-3 pb-3">
                                    @php $comp = $request->customerCompany; @endphp

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Company Name',
                                                'name' => 'company_name',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Company Name',
                                                'value' => old('company_name', $comp->company_name ?? ''),
                                                'model' => $request->customerCompany,
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
                                                'value' => old('gst_no', $comp->gst_no ?? ''),
                                                'model' => $request->customerCompany,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'PAN Number',
                                                'name' => 'pan_number',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your PAN Number',
                                                'value' => old(
                                                    'pan_number',
                                                    optional($request->customerPan)->pan_number ?? ''),
                                                'model' => $request->customerPan,
                                            ])
                                        </div>
                                    </div>

                                    {{-- Company address (reuse same fields) --}}
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Address Line 1',
                                                'name' => 'comp_address1',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Address',
                                                'value' => old('comp_address1', $comp->address1 ?? ''),
                                                'model' => $request->customerCompany,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Address Line 2',
                                                'name' => 'comp_address2',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Address 2',
                                                'value' => old('comp_address2', $comp->address2 ?? ''),
                                                'model' => $request->customerCompany,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Country',
                                                'name' => 'comp_country',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Country',
                                                'value' => old('comp_country', $comp->country ?? ''),
                                                'model' => $request->customerCompany,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'State',
                                                'name' => 'comp_state',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your State',
                                                'value' => old('comp_state', $comp->state ?? ''),
                                                'model' => $request->customerCompany,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'City',
                                                'name' => 'comp_city',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your City',
                                                'value' => old('comp_city', $comp->city ?? ''),
                                                'model' => $request->customerCompany,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Pin Code',
                                                'name' => 'comp_pincode',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Pin Code',
                                                'value' => old('comp_pincode', $comp->pincode ?? ''),
                                                'model' => $request->customerCompany,
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PRODUCT DETAILS (dynamic, same as create, prefilled from $request->products) --}}
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Product Details</h5>
                                <button type="button" class="btn btn-sm btn-primary" id="addProductBtn">
                                    <i class="mdi mdi-plus"></i> Add Product
                                </button>
                            </div>

                            <div class="card-body" id="productsContainer">
                                @forelse($request->products as $idx => $product)
                                    <div class="product-entry border rounded p-3 mb-3 position-relative"
                                        data-index="{{ $idx }}">
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-product-btn">
                                            <i class="mdi mdi-close"></i>
                                        </button>
                                        <div class="row g-3 pb-3">
                                            <div class="col-xl-4 col-lg-6">
                                                <div>
                                                    <label class="form-label">Product Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="products[{{ $idx }}][product_name]"
                                                        class="form-control"
                                                        placeholder="Dell Inspiron 15 Laptop Windows 11"
                                                        value="{{ old("products.$idx.product_name", $product->name) }}"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-6">
                                                <div>
                                                    <label class="form-label">Product Type</label>
                                                    <select name="products[{{ $idx }}][product_type]"
                                                        class="form-select">
                                                        <option value="">--Select Type--</option>
                                                        @foreach ($categories as $id => $name)
                                                            <option value="{{ $id }}"
                                                                {{ (string) old("products.$idx.product_type", $product->type) === (string) $id ? 'selected' : '' }}>
                                                                {{ $name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-6">
                                                <div>
                                                    <label class="form-label">Product Brand</label>
                                                    <select name="products[{{ $idx }}][product_brand]"
                                                        class="form-select">
                                                        <option value="">--Select Brand--</option>
                                                        @foreach ($brands as $id => $name)
                                                            <option value="{{ $id }}"
                                                                {{ (string) old("products.$idx.product_brand", $product->brand) === (string) $id ? 'selected' : '' }}>
                                                                {{ $name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-6">
                                                <div>
                                                    <label class="form-label">Model Number</label>
                                                    <input type="text" name="products[{{ $idx }}][model_no]"
                                                        class="form-control" placeholder="Inspiron 3511"
                                                        value="{{ old("products.$idx.model_no", $product->model_no) }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-6">
                                                <div>
                                                    <label class="form-label">HSN</label>
                                                    <input type="text" name="products[{{ $idx }}][hsn]"
                                                        class="form-control" placeholder="HSN12345"
                                                        value="{{ old("products.$idx.hsn", $product->hsn) }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-6">
                                                <div>
                                                    <label class="form-label">Purchase Date</label>
                                                    <input type="date"
                                                        name="products[{{ $idx }}][purchase_date]"
                                                        class="form-control"
                                                        value="{{ old("products.$idx.purchase_date", $product->purchase_date) }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-6">
                                                <div>
                                                    <label class="form-label">Product Image</label>
                                                    <input type="file"
                                                        name="products[{{ $idx }}][product_image]"
                                                        class="form-control" accept="image/*">
                                                    @if ($product->images)
                                                        <small class="text-muted d-block mt-1">Existing image
                                                            saved.</small>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-6">
                                                <div>
                                                    @include('components.form.select', [
                                                        'class' => 'quick-service-select',
                                                        'label' => 'Quick Service',
                                                        'name' => "products[$idx][quick_service_id]",
                                                        'options' => $quickServiceOptions,
                                                        'value' => old(
                                                            "products.$idx.quick_service_id",
                                                            $product->item_code_id),
                                                    ])
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-6">
                                                <div>
                                                    @include('components.form.input', [
                                                        'class' => 'quick-service-price',
                                                        'label' => 'Quick Service Price',
                                                        'name' => "products[$idx][price]",
                                                        'type' => 'text',
                                                        'readonly' => true,
                                                        'value' => old(
                                                            "products.$idx.price",
                                                            $product->service_charge),
                                                        'model' => $product->service_charge,
                                                    ])
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div>
                                                    <label class="form-label">Issue Description</label>
                                                    <textarea name="products[{{ $idx }}][issue_description]" class="form-control" rows="3"
                                                        placeholder="Describe the issue in detail">{{ old("products.$idx.issue_description", $product->description) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    {{-- Fallback: one empty product row if no products --}}
                                    @php $idx = 0; @endphp
                                    <div class="product-entry border rounded p-3 mb-3" data-index="0">
                                        <div class="row g-3 pb-3">
                                            {{-- same as create first row, skipped here for brevity --}}
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-2">
                                                <div>
                                                    @include('components.form.select', [
                                                        'label' => 'Status',
                                                        'name' => 'status',
                                                        'options' => [
                                                            'pending' => 'Pending',
                                                            'admin_approved' => 'Admin Approved',
                                                            'assigned_engineer' => 'Assigned Engineer',
                                                            'engineer_approved' => 'Engineer Approved',
                                                            'engineer_not_approved' => 'Engineer Not Approved',
                                                            'in_transfer' => 'In Transfer',
                                                            'transferred' => 'Transferred',
                                                            'in_progress' => 'In Progress',
                                                            'picking' => 'Picking',
                                                            'picked' => 'Picked',
                                                            'completed' => 'Completed',
                                                            'on_hold' => 'On Hold',
                                                        ],
                                                        'value' => old('status', $request->status),
                                                    ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="col-lg-12">
                            <div class="text-start mb-3 mt-3">
                                <a href="{{ route('service-request.view-quick-service-request', $request->id) }}"
                                    class="btn btn-secondary w-sm waves ripple-light">
                                    <i class="mdi mdi-arrow-left"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                    <i class="mdi mdi-content-save"></i> Update Service Request
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- JS: dynamic products + quick service price + customer autofill – same as create --}}
    <script>
        let productIndex = {{ $request->products->count() ?: 1 }};
    </script>
    <script>
        // Add product (same as create)
        document.getElementById('addProductBtn').addEventListener('click', function() {
            const container = document.getElementById('productsContainer');
            const i = productIndex;

            const newProduct = `
        <div class="product-entry border rounded p-3 mb-3 position-relative" data-index="${i}">
            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-product-btn">
                <i class="mdi mdi-close"></i>
            </button>
            <div class="row g-3 pb-3">
                <div class="col-xl-4 col-lg-6">
                    <div>
                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="products[${i}][product_name]" class="form-control"
                               placeholder="Dell Inspiron 15 Laptop Windows 11" required>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div>
                        <label class="form-label">Product Type</label>
                        <select name="products[${i}][product_type]" class="form-select">
                            <option value="">--Select Type--</option>
                            @foreach ($categories as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div>
                        <label class="form-label">Product Brand</label>
                        <select name="products[${i}][product_brand]" class="form-select">
                            <option value="">--Select Brand--</option>
                            @foreach ($brands as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div>
                        <label class="form-label">Model Number</label>
                        <input type="text" name="products[${i}][model_no]" class="form-control" placeholder="Inspiron 3511">
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div>
                        <label class="form-label">HSN</label>
                        <input type="text" name="products[${i}][hsn]" class="form-control" placeholder="HSN12345">
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div>
                        <label class="form-label">Purchase Date</label>
                        <input type="date" name="products[${i}][purchase_date]" class="form-control">
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div>
                        <label class="form-label">Product Image</label>
                        <input type="file" name="products[${i}][product_image]" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div>
                        @include('components.form.select', [
                            'class' => 'quick-service-select',
                            'label' => 'Quick Service',
                            'name' => 'products[__IDX__][quick_service_id]',
                            'options' => $quickServiceOptions,
                        ])
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div>
                        @include('components.form.input', [
                            'class' => 'quick-service-price',
                            'label' => 'Quick Service Price',
                            'name' => 'products[__IDX__][price]',
                            'type' => 'text',
                            'readonly' => true,
                        ])
                    </div>
                </div>
                <div class="col-12">
                    <div>
                        <label class="form-label">Issue Description</label>
                        <textarea name="products[${i}][issue_description]" class="form-control" rows="3"
                                  placeholder="Describe the issue in detail"></textarea>
                    </div>
                </div>
            </div>
        </div>`.replace(/__IDX__/g, i);

            container.insertAdjacentHTML('beforeend', newProduct);
            productIndex++;
        });

        // Remove product
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

    <script>
        // Customer search & autofill (same as create)
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.querySelector('input[name="email"]');
            const box = document.getElementById('existingCustomerBox');
            const nameEl = document.getElementById('ec_name');
            const emailEl = document.getElementById('ec_email');
            const phoneEl = document.getElementById('ec_phone');
            const addressEl = document.getElementById('ec_address');
            const useBtn = document.getElementById('btnUseCustomer');

            if (!emailInput || !box) return;

            let cachedCustomer = null;

            function hideBox() {
                box.classList.add('d-none');
                cachedCustomer = null;
            }

            function showBox(customer) {
                cachedCustomer = customer;
                nameEl.textContent = customer.first_name + ' ' + (customer.last_name ?? '');
                emailEl.textContent = customer.email ?? '';
                phoneEl.textContent = customer.phone ?? '';
                addressEl.textContent =
                    (customer.address1 ?? '') + ' ' +
                    (customer.city ?? '') + ' ' +
                    (customer.state ?? '') + ' ' +
                    (customer.pincode ?? '');
                box.classList.remove('d-none');
            }

            emailInput.addEventListener('blur', function() {
                const val = this.value.trim();
                if (!val) {
                    hideBox();
                    return;
                }

                fetch("{{ route('customers.search.by-first-name') }}?email=" + encodeURIComponent(val), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.found && data.customer) {
                            showBox(data.customer);
                        } else {
                            hideBox();
                        }
                    })
                    .catch(() => {
                        hideBox();
                    });
            });

            useBtn?.addEventListener('click', function() {
                if (!cachedCustomer) return;
                const c = cachedCustomer;

                document.querySelector('input[name="first_name"]').value = c.first_name ?? '';
                document.querySelector('input[name="last_name"]').value = c.last_name ?? '';
                document.querySelector('input[name="phone"]').value = c.phone ?? '';
                document.querySelector('input[name="email"]').value = c.email ?? '';
                document.querySelector('input[name="dob"]').value = c.dob ?? '';

                const genderSelect = document.querySelector('select[name="gender"]');
                if (genderSelect && c.gender !== null && c.gender !== undefined) {
                    genderSelect.value = String(c.gender);
                }

                document.querySelector('input[name="branch_name"]').value = c.cust_branch_name ?? '';
                document.querySelector('input[name="address1"]').value = c.cust_address1 ?? '';
                document.querySelector('input[name="address2"]').value = c.cust_address2 ?? '';
                document.querySelector('input[name="country"]').value = c.cust_country ?? '';
                document.querySelector('input[name="state"]').value = c.cust_state ?? '';
                document.querySelector('input[name="city"]').value = c.cust_city ?? '';
                document.querySelector('input[name="pincode"]').value = c.cust_pincode ?? '';

                document.querySelector('input[name="company_name"]').value = c.company_name ?? '';
                document.querySelector('input[name="gst_no"]').value = c.gst_no ?? '';
                document.querySelector('input[name="pan_no"]').value = c.pan_no ?? '';

                document.querySelector('input[name="comp_address1"]').value = c.comp_address1 ?? '';
                document.querySelector('input[name="comp_address2"]').value = c.comp_address2 ?? '';
                document.querySelector('input[name="comp_country"]').value = c.comp_country ?? '';
                document.querySelector('input[name="comp_state"]').value = c.comp_state ?? '';
                document.querySelector('input[name="comp_city"]').value = c.comp_city ?? '';
                document.querySelector('input[name="comp_pincode"]').value = c.comp_pincode ?? '';

                hideBox();
            });
        });
    </script>

    <script>
        // Quick service price mapping (same as create)
        $(document).ready(function() {
            const quickServicePrices = @json($quickService->pluck('service_charge', 'id'));

            $(document).on('change', '.quick-service-select', function() {
                const id = $(this).val();
                const priceInput = $(this)
                    .closest('.product-entry')
                    .find('.quick-service-price');

                if (quickServicePrices[id]) {
                    priceInput.val(quickServicePrices[id]);
                } else {
                    priceInput.val('');
                }
            });
        });
    </script>
@endsection
