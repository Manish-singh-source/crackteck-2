@extends('crm.layouts.master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Leads</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Lead</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('customer.create') }}" class="btn btn-primary">Add New Customer</a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('leads.update', $lead->id) }}" method="POST" id="orderForm">
                        @csrf
                        @method('PUT')
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
                                                    <label for="customer_search" class="form-label">Search Existing Customer</label>
                                                    <input type="text" id="customer_search" class="form-control" placeholder="Type to search customers..." autocomplete="off" data-bs-toggle="dropdown" value="{{ $lead->customer->first_name }} {{ $lead->customer->last_name }}">
                                                    <div id="customer_suggestions" class="dropdown-menu w-100"></div>
                                                </div>
                                                <input type="hidden" id="customer_id" name="customer_id" value="{{ $lead->customer_id }}">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $lead->customer->email }}" required readonly>
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
                                    <div class="card-header border-bottom-dashed d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Branch Information</h5>
                                        <div class="d-flex gap-2 align-items-center">
                                            <select id="customer_address_select" class="form-select form-select-sm" style="min-width: 260px;">
                                                <option value="">Select Customer Address</option>
                                                @foreach($lead->customer->branches as $address)
                                                    <option value="{{ $address->id }}" {{ old('shipping_address_id', $lead->customer_address_id) == $address->id ? 'selected' : '' }}>
                                                        {{ $address->address1 }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Pre-filled customer branch details -->
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="shipping_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_first_name" name="shipping_first_name" value="{{ old('shipping_first_name', $lead->customer->first_name) }}" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="shipping_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_last_name" name="shipping_last_name" value="{{ old('shipping_last_name', $lead->customer->last_name) }}" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="shipping_phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_phone" name="shipping_phone" value="{{ old('shipping_phone', $lead->customer->phone) }}" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <input type="hidden" id="shipping_address_id" name="shipping_address_id" value="{{ old('shipping_address_id', $lead->shipping_address_id) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="shipping_address1" class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_address1" name="shipping_address1" value="{{ old('shipping_address1', $lead->customerAddress->address1) }}" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="shipping_address2" class="form-label">Address Line 2</label>
                                                    <input type="text" class="form-control" id="shipping_address2" name="shipping_address2" value="{{ old('shipping_address2', $lead->customerAddress->address2) }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="shipping_city" class="form-label">City <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_city" name="shipping_city" value="{{ old('shipping_city', $lead->customerAddress->city) }}" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="shipping_state" class="form-label">State <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_state" name="shipping_state" value="{{ old('shipping_state', $lead->customerAddress->state) }}" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="shipping_pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_pincode" name="shipping_pincode" value="{{ old('shipping_pincode', $lead->customerAddress->pincode) }}" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="shipping_country" class="form-label">Country <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_country" name="shipping_country" value="{{ old('shipping_country', $lead->customerAddress->country) }}" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Personal Information Card -->
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">Personal Information</h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-3">
                                                @include('components.form.select', [
                                                    'label' => 'Requirement Type',
                                                    'name' => 'requirement_type',
                                                    'options' => [
                                                        '' => '--Select Requirement--',
                                                        'servers' => 'Servers',
                                                        'cctv' => 'CCTV',
                                                        'biometric' => 'Biometric',
                                                        'networking' => 'Networking',
                                                        'laptops' => 'Laptops',
                                                        'desktops' => 'Desktops',
                                                        'accessories' => 'Accessories',
                                                        'other' => 'Other',
                                                    ],
                                                    'model' => $lead,
                                                    'selected' => old('requirement_type', $lead->requirement_type),
                                                ])
                                            </div>

                                            <div class="col-3">
                                                @include('components.form.input', [
                                                    'label' => 'Budget Range',
                                                    'name' => 'budget_range',
                                                    'type' => 'text',
                                                    'placeholder' => 'e.g., 10K-50K',
                                                    'model' => $lead,
                                                    'value' => old('budget_range', $lead->budget_range),
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
                                                    'model' => $lead,
                                                    'selected' => old('urgency', $lead->urgency),
                                                ])
                                            </div>

                                            <div class="col-3">
                                                @include('components.form.select', [
                                                    'label' => 'Lead Status',
                                                    'name' => 'status',
                                                    'options' => [
                                                        '' => '--Select Status--',
                                                        'new' => 'New',
                                                        'contacted' => 'Contacted',
                                                        'qualified' => 'Qualified',
                                                        'proposal' => 'Proposal',
                                                        'won' => 'Won',
                                                        'lost' => 'Lost',
                                                        'nurtured' => 'Nurtured',
                                                    ],
                                                    'model' => $lead,
                                                    'selected' => old('status', $lead->status),
                                                ])
                                            </div>

                                            <div class="col-3">
                                                @include('components.form.select', [
                                                    'label' => 'Sales Person',
                                                    'name' => 'staff_id',
                                                    'options' => $salesPersons->pluck('first_name', 'id')->prepend('--Select Sales Person--', ''),
                                                    'model' => $lead,
                                                    'selected' => old('staff_id', $lead->staff_id),
                                                ])
                                            </div>

                                            <div class="col-3">
                                                @include('components.form.input', [
                                                    'label' => 'Estimated Value',
                                                    'name' => 'estimated_value',
                                                    'type' => 'number',
                                                    'placeholder' => 'Enter Estimated Value',
                                                    'model' => $lead,
                                                    'value' => old('estimated_value', $lead->estimated_value),
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Notes',
                                                    'name' => 'notes',
                                                    'placeholder' => 'Enter any notes',
                                                    'model' => $lead,
                                                    'value' => old('notes', $lead->notes),
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="text-start mb-3">
                                        <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                            Update
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
            const orderId = {{ $lead->id }};
            let lastCustomer = {
                id: {{ $lead->customer->id }},
                name: "{{ $lead->customer->first_name }} {{ $lead->customer->last_name }}",
                email: "{{ $lead->customer->email }}",
                phone: "{{ $lead->customer->phone }}",
                addresses: @json($lead->customer->branches->toArray())
            };

            // Initialize address select
            const $addressSelect = $('#customer_address_select');
            $addressSelect.empty();
            if (lastCustomer.addresses.length) {
                $addressSelect.append('<option value="">Select Customer Address</option>');
                lastCustomer.addresses.forEach(function(addr) {
                    const label = [addr.address1, addr.city, addr.state, addr.pincode].filter(Boolean).join(', ');
                    const selected = {{ $lead->customer_address_id }} == addr.id ? 'selected' : '';
                    $addressSelect.append(`<option value="${addr.id}" ${selected}>${label}</option>`);
                });
                $addressSelect.show();
            }

            // Customer search functionality
            $('#customer_search').on('input', function() {
                const query = $(this).val().trim();

                if (query.length >= 2) {
                    $.ajax({
                        url: '{{ route('leads.search-customers') }}',
                        method: 'GET',
                        data: { q: query },
                        success: function(response) {
                            let suggestions = '';
                            if (!response || response.length === 0) {
                                $('#customer_suggestions').removeClass('show').hide();
                                return;
                            }
                            response.forEach(function(customer) {
                                const fullName = `${customer.first_name ?? ''} ${customer.last_name ?? ''}`.trim();
                                const addresses = customer.address_details || [];
                                suggestions += `<a class="dropdown-item customer-suggestion" href="#" data-id="${customer.id}" data-name="${fullName}" data-email="${customer.email ?? ''}" data-phone="${customer.phone ?? ''}" data-addresses='${JSON.stringify(addresses)}'>${fullName} - ${customer.email ?? ''}</a>`;
                            });
                            $('#customer_suggestions').html(suggestions).addClass('show').show();
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
                lastCustomer = { id, name, email, phone, addresses };

                // Populate address dropdown
                $addressSelect.empty();
                if (!addresses.length) {
                    $addressSelect.append('<option value="">No saved addresses found</option>').show();
                } else {
                    $addressSelect.append('<option value="">Select Customer Address</option>');
                    addresses.forEach(function(addr) {
                        const label = [addr.address1, addr.city, addr.state, addr.pincode].filter(Boolean).join(', ');
                        $addressSelect.append(`<option value="${addr.id}">${label}</option>`);
                    });
                    $addressSelect.show();
                }
                $('#customer_suggestions').removeClass('show').hide();
            });

            // Address selection change
            $addressSelect.on('change', function() {
                const index = $(this).val();
                if (!lastCustomer || index === '') return;

                const addr = lastCustomer.addresses.find(a => a.id == index);
                if (!addr) return;

                $('#shipping_first_name').val(lastCustomer.name.split(' ')[0] || '');
                $('#shipping_last_name').val(lastCustomer.name.split(' ').slice(1).join(' ') || '');
                $('#shipping_phone').val(lastCustomer.phone || '');
                $('#shipping_address_id').val(addr.id);

                $('#shipping_address1').val(addr.address1 || '');
                $('#shipping_address2').val(addr.address2 || '');
                $('#shipping_city').val(addr.city || '');
                $('#shipping_state').val(addr.state || '');
                $('#shipping_pincode').val(addr.pincode || '');
                $('#shipping_country').val(addr.country || 'India');
            });

            // Trigger change to populate fields initially
            $addressSelect.trigger('change');

            $('#confirmDelete').on('click', function() {
                const button = $(this);
                const originalText = button.html();

                // Show loading state
                button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Deleting...');

                $.ajax({
                    url: `/crm/leads/${orderId}`,
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.success) {
                            $('#deleteModal').modal('hide');
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message);
                            } else {
                                alert(response.message);
                            }
                            setTimeout(() => {
                                window.location.href = '{{ route('leads.index') }}';
                            }, 1000);
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(response.message);
                            } else {
                                alert(response.message);
                            }
                        }
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON?.message || 'Failed to delete order';
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }
                    },
                    complete: function() {
                        button.prop('disabled', false).html(originalText);
                    }
                });
            });
        });
    </script>
@endsection
