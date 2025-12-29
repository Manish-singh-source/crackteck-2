@extends('crm/layouts/master')

@section('content')

    <div class="content">

        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Create Quick Service Request</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('quick-service-requests.store') }}" method="POST" enctype="multipart/form-data"
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
                                <h5 class="card-title mb-0">Customer Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 pb-3">

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <input type="hidden" name="service_type" value="1">
                                        </div>
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Email ID',
                                                'name' => 'email',
                                                'type' => 'email',
                                                'placeholder' => 'example@gamil.com',
                                            ])
                                        </div>
                                        {{-- Existing Customer Preview --}}
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
                                                    '0' => 'Male',
                                                    '1' => 'Female',
                                                    '2' => 'Other',
                                                ],
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
                                                'label' => 'Address Line 1',
                                                'name' => 'address1',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Address',
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
                                                'label' => 'Address Line 1',
                                                'name' => 'comp_address1',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Address',
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
                                            ])
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
                                                    @foreach ($categories as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                <label for="products[0][product_brand]" class="form-label">Product
                                                    Brand</label>
                                                <select name="products[0][product_brand]" class="form-select">
                                                    <option value="">--Select Brand--</option>
                                                    @foreach ($brands as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
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
                                                <label for="products[0][hsn]" class="form-label">HSN</label>
                                                <input type="text" name="products[0][hsn]" class="form-control"
                                                    placeholder="HSN12345">
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

                                        {{-- Select Qucik service --}}
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.select', [
                                                    'class' => 'quick-service-select',
                                                    'label' => 'Quick Service',
                                                    'name' => 'products[0][quick_service_id]',
                                                    'options' => $quickServiceOptions,
                                                ])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'class' => 'quick-service-price',
                                                    'label' => 'Quick Service Price',
                                                    'name' => 'products[0][price]',
                                                    'type' => 'text',
                                                    'readonly' => true,
                                                ])
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
                                @foreach ($categories as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Product Brand</label>
                            <select name="products[${productIndex}][product_brand]" class="form-select">
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
                            <input type="text" name="products[${productIndex}][model_no]" class="form-control" placeholder="Inspiron 3511">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">HSN</label>
                            <input type="text" name="products[${productIndex}][hsn]" class="form-control" placeholder="HSN12345">
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
                            @include('components.form.select', [
                                'class' => 'quick-service-select',
                                'label' => 'Quick Service',
                                'name' => 'products[${productIndex}][quick_service_id]',
                                'options' => $quickServiceOptions,
                            ])
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            @include('components.form.input', [
                                'class' => 'quick-service-price',
                                'label' => 'Quick Service Price',
                                'name' => 'products[${productIndex}][price]',
                                'type' => 'text',
                                'readonly' => true,
                            ])
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

    <script>
        // existing product JS yahan already hai ...

        // ===== Customer search & autofill =====
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.querySelector('input[name="email"]'); // Changed to email input
            const box = document.getElementById('existingCustomerBox');
            const nameEl = document.getElementById('ec_name');
            const emailEl = document.getElementById('ec_email');
            const phoneEl = document.getElementById('ec_phone');
            const addressEl = document.getElementById('ec_address');
            const useBtn = document.getElementById('btnUseCustomer');

            if (!emailInput || !box) return;

            let cachedCustomer = null; // latest fetched customer data

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

            // Email blur par search fire karo
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

            // Button: “Use this customer” → saare fields auto-fill
            useBtn.addEventListener('click', function() {
                if (!cachedCustomer) return;

                const c = cachedCustomer;

                // Basic customer
                document.querySelector('input[name="first_name"]').value = c.first_name ?? '';
                document.querySelector('input[name="last_name"]').value = c.last_name ?? '';
                document.querySelector('input[name="phone"]').value = c.phone ?? '';
                document.querySelector('input[name="email"]').value = c.email ?? '';
                document.querySelector('input[name="dob"]').value = c.dob ?? '';

                const genderSelect = document.querySelector('select[name="gender"]');
                if (genderSelect && c.gender !== null && c.gender !== undefined) {
                    genderSelect.value = String(c.gender); // options: '0','1','2'
                }

                // CUSTOMER ADDRESS section (upper card)
                document.querySelector('input[name="branch_name"]').value = c.cust_branch_name ?? '';
                document.querySelector('input[name="address1"]').value = c.cust_address1 ?? '';
                document.querySelector('input[name="address2"]').value = c.cust_address2 ?? '';
                document.querySelector('input[name="country"]').value = c.cust_country ?? '';
                document.querySelector('input[name="state"]').value = c.cust_state ?? '';
                document.querySelector('input[name="city"]').value = c.cust_city ?? '';
                document.querySelector('input[name="pincode"]').value = c.cust_pincode ?? '';

                // COMPANY DETAILS (lower card)
                document.querySelector('input[name="company_name"]').value = c.company_name ?? '';
                document.querySelector('input[name="gst_no"]').value = c.gst_no ?? '';
                document.querySelector('input[name="pan_no"]').value = c.pan_no ?? '';

                // COMPANY ADDRESS fields in same “company” card
                document.querySelector('input[name="comp_address1"]').value = c.comp_address1 ?? '';
                document.querySelector('input[name="comp_address2"]').value = c.comp_address2 ?? '';
                document.querySelector('input[name="comp_country"]').value = c.comp_country ?? '';
                document.querySelector('input[name="comp_state"]').value = c.comp_state ?? '';
                document.querySelector('input[name="comp_city"]').value = c.comp_city ?? '';
                document.querySelector('input[name="comp_pincode"]').value = c.comp_pincode ?? '';
                // console.log('Customer used:', c);

                // Box hide after using
                hideBox();
            });
        });
    </script>

    <script>
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
