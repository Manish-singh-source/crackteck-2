@extends('crm/layouts/master')

@section('content')
    <div class="content">


        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Leads</li>
                            <li class="breadcrumb-item active" aria-current="page">Add Leads</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('customer.create') }}" class="btn btn-primary">Add New Customer</a>
                    <!-- <button class="btn btn-primary">Add New Customer</button> -->
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('leads.store') }}" method="POST" id="orderForm">
                        @csrf
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-12">
                                <!-- Customer Information Card -->
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">Customer Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="customer_search" class="form-label">Search Existing
                                                        Customer</label>
                                                    <input type="text" id="customer_search" class="form-control"
                                                        placeholder="Type to search customers..." autocomplete="off"
                                                        data-bs-toggle="dropdown">

                                                    <div id="customer_suggestions" class="dropdown-menu w-100"></div>
                                                </div>
                                                <input type="hidden" id="customer_id" name="customer_id">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="email" name="email" value="{{ old('email') }}" required
                                                        readonly>
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Branch Information Card -->
                                <div class="card">
                                    <div
                                        class="card-header border-bottom-dashed d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Branch Information</h5>
                                        <div class="d-flex gap-2 align-items-center">
                                            <select id="customer_address_select" class="form-select form-select-sm"
                                                style="min-width: 260px; display:none;">
                                                <option value="">Select Customer Address</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="shipping_first_name" class="form-label">First Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('shipping_first_name') is-invalid @enderror"
                                                        id="shipping_first_name" name="shipping_first_name"
                                                        value="{{ old('shipping_first_name') }}" required readonly>
                                                    @error('shipping_first_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="shipping_last_name" class="form-label">Last Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('shipping_last_name') is-invalid @enderror"
                                                        id="shipping_last_name" name="shipping_last_name"
                                                        value="{{ old('shipping_last_name') }}" required readonly>
                                                    @error('shipping_last_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="shipping_phone" class="form-label">Phone <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('shipping_phone') is-invalid @enderror"
                                                        id="shipping_phone" name="shipping_phone"
                                                        value="{{ old('shipping_phone') }}" required readonly>
                                                    @error('shipping_phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <input type="hidden" id="shipping_address_id"
                                                        name="shipping_address_id">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="shipping_address1" class="form-label">Address Line 1 <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('shipping_address1') is-invalid @enderror"
                                                        id="shipping_address1" name="shipping_address1"
                                                        value="{{ old('shipping_address1') }}" required readonly>
                                                    @error('shipping_address1')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="shipping_address2" class="form-label">Address Line
                                                        2</label>
                                                    <input type="text"
                                                        class="form-control @error('shipping_address2') is-invalid @enderror"
                                                        id="shipping_address2" name="shipping_address2"
                                                        value="{{ old('shipping_address2') }}" readonly>
                                                    @error('shipping_address2')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="shipping_city" class="form-label">City <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('shipping_city') is-invalid @enderror"
                                                        id="shipping_city" name="shipping_city"
                                                        value="{{ old('shipping_city') }}" required readonly>
                                                    @error('shipping_city')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="shipping_state" class="form-label">State <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('shipping_state') is-invalid @enderror"
                                                        id="shipping_state" name="shipping_state"
                                                        value="{{ old('shipping_state') }}" required readonly>
                                                    @error('shipping_state')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="shipping_pincode" class="form-label">Pincode <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('shipping_pincode') is-invalid @enderror"
                                                        id="shipping_pincode" name="shipping_pincode"
                                                        value="{{ old('shipping_pincode') }}" required readonly>
                                                    @error('shipping_pincode')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="shipping_country" class="form-label">Country <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('shipping_country') is-invalid @enderror"
                                                        id="shipping_country" name="shipping_country"
                                                        value="{{ old('shipping_country', 'India') }}" required readonly>
                                                    @error('shipping_country')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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

                                            <div class="col-3">
                                                @include('components.form.select', [
                                                    'label' => 'Requirement Type',
                                                    'name' => 'requirement_type',
                                                    'options' => [
                                                        '' => '--Select Requirement--',
                                                        'Servers' => 'Servers',
                                                        'CCTV' => 'CCTV',
                                                        'Biometric' => 'Biometric',
                                                        'Networking' => 'Networking',
                                                        'Laptops' => 'Laptops',
                                                        'Desktops' => 'Desktops',
                                                        'Accessories' => 'Accessories',
                                                        'Other' => 'Other',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-3">
                                                @include('components.form.input', [
                                                    'label' => 'Budget Range',
                                                    'name' => 'budget_range',
                                                    'type' => 'text',
                                                    'placeholder' => 'e.g., 10K-50K',
                                                ])
                                            </div>

                                            <div class="col-3">
                                                @include('components.form.select', [
                                                    'label' => 'Urgency',
                                                    'name' => 'urgency',
                                                    'options' => [
                                                        '' => '--Select Urgency--',
                                                        'low' => 'Low',
                                                        'medium' => 'Medium',
                                                        'high' => 'High',
                                                        'critical' => 'Critical',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-3">
                                                @include('components.form.select', [
                                                    'label' => 'Lead Status',
                                                    'name' => 'status',
                                                    'options' => [
                                                        '0' => '--Select Status--',
                                                        'new' => 'New',
                                                        'contacted' => 'Contacted',
                                                        'qualified' => 'Qualified',
                                                        'proposal' => 'Proposal',
                                                        'won' => 'Won',
                                                        'Lost' => 'Lost',
                                                        'nurtured' => 'Nurtured',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-3">
                                                @include('components.form.select', [
                                                    'label' => 'Sales Person',
                                                    'name' => 'sales_person_id',
                                                    'options' => $salesPersons->pluck('first_name', 'id')->prepend('--Select Sales Person--', 0),
                                                ])
                                            </div>

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
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let lastCustomer = null;

            // Payment method change handler
            $('#payment_method').on('change', function() {
                const paymentMethod = $(this).val();
                if (paymentMethod === 'online') {
                    $('#payment-details').show();
                } else {
                    $('#payment-details').hide();
                }
            });

            // Customer search functionality
            $('#customer_search').on('input', function() {
                const query = $(this).val().trim();

                if (query.length >= 2) {
                    $.ajax({
                        url: '{{ route('leads.search-customers') }}',
                        method: 'GET',
                        data: {
                            q: query
                        },
                        success: function(response) {
                            console.log(response);
                            let suggestions = '';

                            if (!response || response.length === 0) {
                                $('#customer_suggestions').removeClass('show').hide();
                                $('#customer_suggestions').html(
                                    '<a class="dropdown-item" href="#">No customers found</a>'
                                    ).show();
                                return;
                            }

                            response.forEach(function(customer) {
                                const fullName =
                                    `${customer.first_name ?? ''} ${customer.last_name ?? ''}`
                                    .trim();
                                const addresses = customer.address_details ||
                            []; // yahi sahi key hai

                                suggestions += `
                                    <a class="dropdown-item customer-suggestion" href="#"
                                    data-id="${customer.id}"
                                    data-name="${fullName}"
                                    data-email="${customer.email ?? ''}"
                                    data-phone="${customer.phone ?? ''}"
                                    data-addresses='${JSON.stringify(addresses)}'>
                                        ${fullName} - ${customer.email ?? ''}
                                    </a>`;
                            });

                            $('#customer_suggestions')
                                .html(suggestions)
                                .addClass('show')
                                .show();
                        },
                        error: function(xhr) {
                            console.log(xhr);

                            if (xhr.status === 404) {
                                $('#customer_suggestions').removeClass('show').hide();
                                $('#customer_suggestions').html(
                                    '<a class="dropdown-item" href="#">No customers found</a>'
                                    ).show();
                                return;
                            }
                        }
                    });
                } else {
                    $('#customer_suggestions').removeClass('show').hide();
                }
            });

            // Suggestion click
            $(document).on('click', '.customer-suggestion', function(e) {
                e.preventDefault();

                const id = $(this).data('id');
                const name = $(this).data('name');
                const email = $(this).data('email');
                const phone = $(this).data('phone');
                const addresses = $(this).data('addresses') || [];

                $('#customer_id').val(id);
                $('#customer_search').val(name);
                $('#email').val(email);
                $('#phone').val(phone);
                lastCustomer = {
                    id,
                    name,
                    email,
                    phone,
                    addresses
                };

                // Populate address dropdown
                const $addressSelect = $('#customer_address_select');
                $addressSelect.empty();

                if (!addresses.length) {
                    $addressSelect
                        .append('<option value="">No saved addresses found</option>')
                        .show();
                } else {
                    $addressSelect.append('<option value="">Select Customer Address</option>');
                    addresses.forEach(function(addr, index) {
                        const label = [
                            addr.address1,
                            addr.address2,
                            addr.city,
                            addr.state,
                            addr.pincode,
                            addr.country
                        ].filter(Boolean).join(', ');

                        $addressSelect.append(
                            `<option value="${index}">
                    ${label}
                 </option>`
                        );
                    });
                    $addressSelect.show();
                }

                $('#customer_suggestions').removeClass('show').hide();

                // Optionally default first address select + fill
                if (addresses.length === 1) {
                    $addressSelect.val(0).trigger('change');
                }
            });

            // Address selection change
            $('#customer_address_select').on('change', function() {
                const index = $(this).val();
                if (!lastCustomer || index === '') return;

                const addr = lastCustomer.addresses[index];
                if (!addr) return;

                $('#shipping_first_name').val(addr.first_name || lastCustomer.name.split(' ')[0] || '');
                $('#shipping_last_name').val(addr.last_name || lastCustomer.name.split(' ').slice(1).join(
                    ' ') || '');
                $('#shipping_phone').val(addr.phone || lastCustomer.phone || '');
                $('#shipping_address_id').val(addr.id);

                $('#shipping_address1').val(addr.address1 || '');
                $('#shipping_address2').val(addr.address2 || '');
                $('#shipping_city').val(addr.city || '');
                $('#shipping_state').val(addr.state || '');
                $('#shipping_pincode').val(addr.pincode || '');
                $('#shipping_country').val(addr.country || 'India');
            });


            // Form submission
            $('#orderForm').on('submit', function(e) {
                if (lastCustomer === null) {
                    e.preventDefault();
                    alert('Please select a customer');
                    return false;
                }
            });

            // Hide dropdowns when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#customer_search, #customer_suggestions').length) {
                    $('#customer_suggestions').hide();
                }
                if (!$(e.target).closest('#product_search, #product_suggestions').length) {
                    $('#product_suggestions').hide();
                }
            });
        });
    </script>
@endsection
