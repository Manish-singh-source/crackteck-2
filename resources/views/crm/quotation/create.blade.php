@extends('crm/layouts/master')

@section('content')
    <div class="content">


        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Quotation</li>
                            <li class="breadcrumb-item active" aria-current="page">Create Quotation</li>
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
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('quotation.store') }}" method="POST">
                                @csrf
                                @method('POST')
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

                                            {{-- <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Lead Id',
                                                    'name' => 'lead_id',
                                                    'options' => [
                                                        '0' => '--Select Lead id--',
                                                        'L-001' => 'L-001',
                                                        'L-002' => 'L-002',
                                                        'L-003' => 'L-003',
                                                        'L-004' => 'L-004',
                                                        'L-005' => 'L-005',
                                                    ],
                                                ])
                                            </div> --}}

                                            <div class="col-6">
                                                <label for="warehouse" class="form-label">Lead Id <span
                                                        class="text-danger">*</span></label>
                                                <select required name="lead_id" id="lead_id" class="form-select w-100">
                                                    <option value="" selected disabled>-- Select Lead Id --</option>
                                                    @foreach ($leads as $lead)
                                                        <option value="{{ $lead->id }}"
                                                            {{ old('lead_id') == $lead->id ? 'selected' : '' }}>
                                                            {{ $lead->id . ' - ' . $lead->first_name . ' ' . $lead->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('lead_id'))
                                                    <span class="text-danger">{{ $errors->first('lead_id') }}</span>
                                                @endif
                                            </div>

                                            <div class="col-6">
                                                <label for="quote_id" class="form-label">Quotation ID </label>
                                                <input type="text" class="form-control" name="quote_id"
                                                    value="{{ $quoteId }}" readonly>
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Quotation Date',
                                                    'name' => 'quote_date',
                                                    'type' => 'date',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Expiration Date',
                                                    'name' => 'expiry_date',
                                                    'type' => 'date',
                                                ])
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="card pb-4">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Itemized Products/Services
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Product Name',
                                                    'name' => 'product_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Product Name',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'HSN Code',
                                                    'name' => 'hsn_code',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter HSN Code',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'SKU',
                                                    'name' => 'sku',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter SKU',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Price',
                                                    'name' => 'price',
                                                    'type' => 'number',
                                                    'placeholder' => 'Enter Price',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Quantity',
                                                    'name' => 'quantity',
                                                    'type' => 'number',
                                                    'placeholder' => 'Enter Quantity',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Tax (%)',
                                                    'name' => 'tax',
                                                    'type' => 'number',
                                                    'placeholder' => 'Enter Tax Percentage',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Total',
                                                    'name' => 'total',
                                                    'type' => 'number',
                                                    'placeholder' => 'Auto Calculated',
                                                    'readonly' => true,
                                                ])
                                            </div>

                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-success" id="add-product-btn">
                                                        Add Product
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card product-table-section" style="display: none;">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            Products/Services Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-borderless dt-responsive nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>HSN Code</th>
                                                    <th>SKU</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Tax (%)</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="products-table-body">
                                                <!-- Products will be added here dynamically -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- AMC Details Section -->
                                <div class="card mt-3">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">
                                            AMC Details
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3 pb-3">
                                            <div class="col-4">
                                                <label for="amc_plan_id" class="form-label">Select Plan <span
                                                        class="text-danger">*</span></label>
                                                <select name="amc_plan_id" id="amc_plan_id" class="form-select">
                                                    <option value="">--Select Plan--</option>
                                                    @foreach ($amcPlans as $plan)
                                                        <option value="{{ $plan->id }}"
                                                            data-cost="{{ $plan->total_cost }}"
                                                            data-duration="{{ $plan->duration }}">
                                                            {{ $plan->plan_name }} - {{ $plan->plan_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-4">
                                                <label for="plan_duration" class="form-label">Plan Duration</label>
                                                <input type="text" name="plan_duration" id="plan_duration"
                                                    class="form-control" readonly placeholder="Auto-filled">
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
                                                <input type="number" name="total_amount" id="total_amount"
                                                    class="form-control" step="0.01" readonly
                                                    placeholder="Auto-filled">
                                            </div>

                                            <div class="col-xl-4 col-lg-6">
                                                <div>
                                                    @include('components.form.select', [
                                                        'label' => 'Priority Level',
                                                        'name' => 'priority_level',
                                                        'options' => [
                                                            '' => '--Select--',
                                                            'High' => 'High',
                                                            'Medium' => 'Medium',
                                                            'Low' => 'Low',
                                                        ],
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
                                                    <a href="{{ route('service-request.index') }}"
                                                        class="btn btn-secondary">
                                                        <i class="mdi mdi-cancel"></i> Cancel
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-start mb-3">
                                    <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                        Submit
                                    </button>
                                </div>

                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let quotationId = null;
            let products = [];

            // Calculate total when price, quantity, or tax changes
            function calculateTotal() {
                const price = parseFloat($('input[name="price"]').val()) || 0;
                const quantity = parseInt($('input[name="quantity"]').val()) || 0;
                const tax = parseFloat($('input[name="tax"]').val()) || 0;

                const subtotal = price * quantity;
                const taxAmount = (subtotal * tax) / 100;
                const total = subtotal + taxAmount;

                $('input[name="total"]').val(total.toFixed(2));
            }

            $('input[name="price"], input[name="quantity"], input[name="tax"]').on('input', calculateTotal);

            // Add product to temporary array
            $('#add-product-btn').on('click', function() {
                const productData = {
                    product_name: $('input[name="product_name"]').val(),
                    hsn_code: $('input[name="hsn_code"]').val(),
                    sku: $('input[name="sku"]').val(),
                    price: parseFloat($('input[name="price"]').val()) || 0,
                    quantity: parseInt($('input[name="quantity"]').val()) || 0,
                    tax: parseFloat($('input[name="tax"]').val()) || 0,
                    total: parseFloat($('input[name="total"]').val()) || 0
                };

                // Validate required fields
                if (!productData.product_name || productData.price <= 0 || productData.quantity <= 0) {
                    alert('Please fill all product fields correctly');
                    return;
                }

                // Add to temporary array
                products.push(productData);

                // Add to table
                addProductToTable(productData, products.length - 1);

                // Show table and clear form
                $('.product-table-section').show();
                clearProductForm();
            });

            // Delete product from temporary array
            $(document).on('click', '.delete-product-temp', function() {
                const index = $(this).data('index');
                products.splice(index, 1);
                refreshProductTable();
            });

            // Add product to table
            function addProductToTable(product, index) {
                const row = `
                    <tr>
                        <td>${product.product_name}</td>
                        <td>${product.hsn_code}</td>
                        <td>${product.sku}</td>
                        <td>${product.price.toFixed(2)}</td>
                        <td>${product.quantity}</td>
                        <td>${product.tax}%</td>
                        <td>${product.total.toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-icon btn-sm bg-danger-subtle delete-product-temp" data-index="${index}">
                                <i class="mdi mdi-delete fs-14 text-danger"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#products-table-body').append(row);
            }

            // AMC Plan selection

            $('#amc_plan_id').change(function() {
                const selectedOption = $(this).find('option:selected');
                const cost = selectedOption.data('cost');
                const duration = selectedOption.data('duration');

                $('#total_amount').val(cost || '');
                $('#plan_duration').val(duration || '');
            });


            // Refresh product table
            function refreshProductTable() {
                $('#products-table-body').empty();
                products.forEach((product, index) => {
                    addProductToTable(product, index);
                });
                if (products.length === 0) {
                    $('.product-table-section').hide();
                }
            }

            // Clear product form
            function clearProductForm() {
                $('input[name="product_name"]').val('');
                $('input[name="hsn_code"]').val('');
                $('input[name="sku"]').val('');
                $('input[name="price"]').val('');
                $('input[name="quantity"]').val('');
                $('input[name="tax"]').val('');
                $('input[name="total"]').val('');
            }

            // Intercept form submission
            $('form').on('submit', function(e) {
                e.preventDefault();
                
                // Get all products from the table
                const tableProducts = [];
                $('#products-table-body tr').each(function() {
                    const cells = $(this).find('td');
                    const product = {
                        product_name: cells.eq(0).text(),
                        hsn_code: cells.eq(1).text(),
                        sku: cells.eq(2).text(),
                        price: parseFloat(cells.eq(3).text()),
                        quantity: parseInt(cells.eq(4).text()),
                        tax: parseFloat(cells.eq(5).text()),
                        total: parseFloat(cells.eq(6).text())
                    };
                    tableProducts.push(product);
                });

                // Create FormData object
                const form = $(this);
                const formData = new FormData(this);
                
                // Add products array to formData
                formData.append('products', JSON.stringify(tableProducts));

                // Add AMC details to formData
                const amcData = {
                    amc_plan_id: $('#amc_plan_id').val(),
                    plan_duration: $('#plan_duration').val(),
                    plan_start_date: $('input[name="plan_start_date"]').val(),
                    total_amount: $('#total_amount').val(),
                    priority_level: $('select[name="priority_level"]').val(),
                    additional_notes: $('input[name="additional_notes"]').val()
                };
                formData.append('amc_details', JSON.stringify(amcData));

                console.log('AMC data:', amcData);
                console.log('Form data:', tableProducts);
                // Submit the form with all data
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Form submitted successfully:', response);
                        if (response.success) {
                            // Redirect to index page
                            window.location.href = "{{ route('quotation.index') }}";
                        } else {
                            alert('Submission successful but redirect failed');
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
                            console.log('Error:', xhr.responseJSON);
                            alert('An error occurred. Please try again.');
                        }
                    }
                });
            });

            // Save all products
            function saveProducts(quotationId) {
                if (products.length === 0) return Promise.resolve();

                const promises = products.map(product => {
                    return $.ajax({
                        url: "{{ route('quotation.products.store') }}",
                        method: 'POST',
                        data: {
                            ...product,
                            quotation_id: quotationId,
                            _token: '{{ csrf_token() }}'
                        }
                    });
                });

                return Promise.all(promises);
            }

            // Save AMC details
            function saveAmcDetails(quotationId) {
                const amcData = {
                    quotation_id: quotationId,
                    amc_plan_id: $('select[name="amc_plan_id"]').val(),
                    plan_duration: $('input[name="plan_duration"]').val(),
                    start_date: $('input[name="start_date"]').val(),
                    amc_amount: $('input[name="total_amount"]').val(),
                    end_date: $('input[name="end_date"]').val(),
                    _token: '{{ csrf_token() }}'
                };

                // Only save if at least one AMC field is filled
                if (!amcData.amc_type && !amcData.amc_amount && !amcData.start_date) {
                    return Promise.resolve();
                }

                return $.ajax({
                    url: "{{ route('quotation.amc.store') }}",
                    method: 'POST',
                    data: amcData
                });
            }
        });
    </script>
@endsection
