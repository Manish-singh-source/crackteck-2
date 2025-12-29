@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Create Job</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> Please fix the following issues:
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                                    'label' => 'Customer Type',
                                                    'name' => 'customer_type',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Customer Type',
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
                                                    'placeholder' => 'Enter Your Phone Number',
                                                ])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Email',
                                                    'name' => 'email',
                                                    'type' => 'email',
                                                    'placeholder' => 'Enter Your Email',
                                                ])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Date Of Birth',
                                                    'name' => 'dob',
                                                    'type' => 'date',
                                                    'placeholder' => 'Enter Your Date Of Birth',
                                                ])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Address Line 1',
                                                    'name' => 'address',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Your Address Line 1',
                                                ])
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Address Line 2',
                                                    'name' => 'address2',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Your Address Line 2',
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
                                                    'name' => 'pin_code',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Your Pin Code',
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
                                                'label' => 'Company Address',
                                                'name' => 'company_address',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Your Company Address',
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
                                                'name' => 'profile_img',
                                                'type' => 'file',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Image',
                                                'name' => 'image',
                                                'type' => 'file',
                                            ])
                                        </div>
                                        <div id="image-preview-section">

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            @include('components.form.select', [
                                                'label' => 'Priority Level',
                                                'name' => 'priority_level',
                                                'options' => [
                                                    '0' => '--Select --',
                                                    'High' => 'High',
                                                    'Medium' => 'Medium',
                                                    'Low' => 'Low',
                                                ],
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Product Details</h5>
                                    <button type="button" class="btn btn-primary btn-sm" id="add-product-btn">
                                        <i class="mdi mdi-plus"></i> Add Product
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="products-container">
                                    <div class="product-item border rounded p-3 mb-3" data-product-index="0">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Product #1</h6>
                                            <button type="button" class="btn btn-danger btn-sm remove-product-btn" style="display: none;">
                                                <i class="mdi mdi-delete"></i> Remove
                                            </button>
                                        </div>
                                    <div class="row g-3 pb-3">
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Product Name',
                                                    'name' => 'products[0][product_name]',
                                                    'type' => 'text',
                                                    'placeholder' => 'Dell Inspiron 15 Laptop Windows 11',
                                                ])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.select', [
                                                    'label' => 'Product Type',
                                                    'name' => 'products[0][product_type]',
                                                    'options' => [
                                                        '0' => '--Select --',
                                                        'PC' => 'PC',
                                                        'Laptop' => 'Laptop',
                                                        'Accessories' => 'Accessories',
                                                    ],
                                                ])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Product Brand',
                                                    'name' => 'products[0][product_brand]',
                                                    'type' => 'text',
                                                    'placeholder' => 'Dell, HP, Asus',
                                                ])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Model Number',
                                                    'name' => 'products[0][model_no]',
                                                    'type' => 'text',
                                                    'placeholder' => 'Inspiron 3511',
                                                ])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Serial Number',
                                                    'name' => 'products[0][serial_no]',
                                                    'type' => 'text',
                                                    'placeholder' => 'B0BB7FQBBS',
                                                ])
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Purchase Date',
                                                    'name' => 'products[0][purchase_date]',
                                                    'type' => 'date',
                                                ])
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Image',
                                                    'name' => 'products[0][image]',
                                                    'type' => 'file',
                                                ])
                                            </div>
                                            <div class="image-preview-section">

                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                @include('components.form.input', [
                                                    'label' => 'Issue type',
                                                    'name' => 'products[0][issue_type]',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Issue',
                                                ])
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <div>
                                                <label for="serial_no" class="form-label">
                                                    Issue Description
                                                </label>
                                                <textarea name="products[0][description]" class="form-control" id=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="text-start mb-3 ms-3">
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
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    console.log('Create Job Page - JavaScript Loaded');
    let productIndex = 1;

    // Add Product Button Click
    $('#add-product-btn').on('click', function(e) {
        e.preventDefault();
        console.log('Add Product Button Clicked');
        const productHtml = `
            <div class="product-item border rounded p-3 mb-3" data-product-index="${productIndex}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Product #${productIndex + 1}</h6>
                    <button type="button" class="btn btn-danger btn-sm remove-product-btn">
                        <i class="mdi mdi-delete"></i> Remove
                    </button>
                </div>
                <div class="row g-3 pb-3">
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Product Name</label>
                            <input type="text" name="products[${productIndex}][product_name]" class="form-control" placeholder="Dell Inspiron 15 Laptop Windows 11">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Product Type</label>
                            <select name="products[${productIndex}][product_type]" class="form-select">
                                <option value="0">--Select --</option>
                                <option value="PC">PC</option>
                                <option value="Laptop">Laptop</option>
                                <option value="Accessories">Accessories</option>
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
                            <label class="form-label">Image</label>
                            <input type="file" name="products[${productIndex}][image]" class="form-control">
                        </div>
                        <div class="image-preview-section"></div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Issue type</label>
                            <input type="text" name="products[${productIndex}][issue_type]" class="form-control" placeholder="Enter Issue">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div>
                            <label class="form-label">Issue Description</label>
                            <textarea name="products[${productIndex}][description]" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#products-container').append(productHtml);
        productIndex++;
        console.log('Product added. Total products:', $('.product-item').length);

        // Show remove button on all products if more than 1
        if ($('.product-item').length > 1) {
            $('.remove-product-btn').show();
        }
    });

    // Remove Product Button Click
    $(document).on('click', '.remove-product-btn', function(e) {
        e.preventDefault();
        console.log('Remove Product Button Clicked');
        $(this).closest('.product-item').remove();

        // Hide remove button if only 1 product left
        if ($('.product-item').length === 1) {
            $('.remove-product-btn').hide();
        }

        // Renumber products
        $('.product-item').each(function(index) {
            $(this).find('h6').text('Product #' + (index + 1));
        });
        console.log('Product removed. Total products:', $('.product-item').length);
    });

    // Form submission validation
    $('form').on('submit', function(e) {
        console.log('Form submitting...');
        const productCount = $('.product-item').length;
        console.log('Total products:', productCount);

        if (productCount === 0) {
            e.preventDefault();
            alert('Please add at least one product!');
            return false;
        }
    });
});
</script>
@endsection
