@extends('offline-users-dashboard/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">My Addresses</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Addresses</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <button class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm" id="btn-add-address">
                        <i class="fas fa-plus me-1"></i> Add New Address
                    </button>
                </div>
            </div>

            <!-- Address Count Badge -->
            <div class="row mb-3">
                <div class="col-12">
                    <span class="badge bg-light text-dark border px-3 py-2 fs-12">
                        <i class="fas fa-map-marker-alt text-primary me-1"></i>
                        <span id="address-count">{{ $addresses->count() }}</span> Address(es) saved
                    </span>
                </div>
            </div>

            <!-- Add/Edit Address Form -->
            <div class="row mb-4" id="address-form-wrapper" style="display: none;">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-bottom">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i class="fas fa-plus-circle text-primary me-2" id="form-icon"></i>
                                <span id="form-title">Add New Address</span>
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form id="address-form">
                                <input type="hidden" id="customer-id" name="customer_id">
                                <div class="row g-3">
                                    <!-- Address Line 1 -->
                                    <div class="col-md-6">
                                        <label for="address1" class="form-label fw-medium fs-13">
                                            Address Line 1 <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-home text-muted fs-14"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="address1"
                                                   name="address1" placeholder="Enter address line 1" required>
                                        </div>
                                    </div>

                                    <!-- Address Line 2 -->
                                    <div class="col-md-6">
                                        <label for="address2" class="form-label fw-medium fs-13">
                                            Address Line 2
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-building text-muted fs-14"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="address2"
                                                   name="address2" placeholder="Enter address line 2">
                                        </div>
                                    </div>

                                    <!-- State -->
                                    <div class="col-md-6">
                                        <label for="state" class="form-label fw-medium fs-13">
                                            State <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-map text-muted fs-14"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="state"
                                                   name="state" placeholder="Enter state" required>
                                        </div>
                                    </div>

                                    <!-- City -->
                                    <div class="col-md-6">
                                        <label for="city" class="form-label fw-medium fs-13">
                                            City <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-city text-muted fs-14"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="city"
                                                   name="city" placeholder="Enter city" required>
                                        </div>
                                    </div>

                                    <!-- Country -->
                                    <div class="col-md-6">
                                        <label for="country" class="form-label fw-medium fs-13">
                                            Country/Region <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-globe text-muted fs-14"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="country"
                                                   name="country" placeholder="Enter country" required>
                                        </div>
                                    </div>

                                    <!-- Pincode -->
                                    <div class="col-md-6">
                                        <label for="pincode" class="form-label fw-medium fs-13">
                                            Pincode <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-mail-bulk text-muted fs-14"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="pincode"
                                                   name="pincode" placeholder="Enter pincode" required>
                                        </div>
                                    </div>

                                    <!-- Default Checkbox -->
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="is_default" value="1" id="is-default">
                                            <label class="form-check-label fw-medium fs-13" for="is-default">
                                                <i class="fas fa-star text-warning me-1"></i> Set as Default Address
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-light rounded-pill px-4" id="cancel-btn">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="submit-btn">
                                        <i class="fas fa-save me-1"></i>
                                        <span id="submit-text">Save Address</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Cards -->
            <div class="row g-3" id="address-list">
                @forelse($addresses as $address)
                    <div class="col-lg-6 col-xl-4 address-card-item" data-address-id="{{ $address->id }}">
                        <div class="card border-0 shadow-sm h-100 address-card">
                            <div class="card-body p-4">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                             style="width: 42px; height: 42px; background: rgba(102, 126, 234, 0.15);">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="fw-semibold mb-0">{{ $address->branch_name ?? 'Address' }}</h6>
                                            @if ($address->is_primary === 'yes')
                                                <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1 fs-11 mt-1">
                                                    <i class="fas fa-star me-1"></i>Default
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown" style="width: 32px; height: 32px; padding: 0;">
                                            <i class="fas fa-ellipsis-v fs-12"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li>
                                                <button class="dropdown-item btn-edit-address" data-address-id="{{ $address->id }}">
                                                    <i class="fas fa-pen text-primary me-2 fs-13"></i> Edit
                                                </button>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button class="dropdown-item text-danger btn-delete-address" data-address-id="{{ $address->id }}">
                                                    <i class="fas fa-trash me-2 fs-13"></i> Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Address Details -->
                                <div class="ps-0">
                                    <p class="mb-1 fs-13 text-dark">{{ $address->address1 }}</p>
                                    @if ($address->address2)
                                        <p class="mb-1 fs-13 text-muted">{{ $address->address2 }}</p>
                                    @endif
                                    <p class="mb-1 fs-13 text-muted">{{ $address->city }}, {{ $address->state }}</p>
                                    <p class="mb-0 fs-13 text-muted">{{ $address->country }} - {{ $address->pincode }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="col-12" id="no-addresses">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <div class="mb-3" style="font-size: 64px; opacity: 0.15;">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                                <h5 class="fw-semibold text-dark mb-2">No Addresses Added Yet</h5>
                                <p class="text-muted fs-14 mb-4">
                                    You haven't added any address yet. Add your first address to get started with deliveries and services.
                                </p>
                                <button class="btn btn-primary rounded-pill px-4 btn-trigger-add">
                                    <i class="fas fa-plus me-1"></i> Add Your First Address
                                </button>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <style>
        .card {
            border-radius: 12px;
        }
        .shadow-sm {
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06) !important;
        }
        .address-card {
            transition: all 0.3s ease;
        }
        .address-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }
        .input-group-text {
            border-radius: 0.375rem 0 0 0.375rem;
        }
        .form-control {
            padding: 0.6rem 0.75rem;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // CSRF token setup for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let isEditMode = false;
            let editingAddressId = null;

            // Show/Hide form functionality
            $('#btn-add-address, .btn-trigger-add').on('click', function() {
                resetForm();
                isEditMode = false;
                $('#form-title').text('Add New Address');
                $('#form-icon').removeClass('fa-edit').addClass('fa-plus-circle');
                $('#submit-text').text('Save Address');
                $('#address-form-wrapper').slideDown();
                $('html, body').animate({
                    scrollTop: $('#address-form-wrapper').offset().top - 80
                }, 400);
            });

            $('#cancel-btn').on('click', function() {
                $('#address-form-wrapper').slideUp();
                resetForm();
            });

            // Form submission
            $('#address-form').on('submit', function(e) {
                e.preventDefault();

                const formData = {
                    address1: $('#address1').val(),
                    address2: $('#address2').val(),
                    state: $('#state').val(),
                    city: $('#city').val(),
                    country: $('#country').val(),
                    pincode: $('#pincode').val(),
                    is_default: $('#is-default').is(':checked')
                };

                // Show loading state
                $('#submit-btn').prop('disabled', true);
                $('#submit-text').html('<i class="fas fa-spinner fa-spin me-1"></i>' + (isEditMode ? 'Updating...' : 'Saving...'));

                const url = isEditMode ?
                    `my-account/address/${editingAddressId}` :
                    'my-account/address';
                const method = isEditMode ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');
                            $('#address-form-wrapper').slideUp();

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            showNotification(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let message = 'An error occurred while saving the address.';

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            message = Object.values(errors).flat().join(', ');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        showNotification(message, 'error');
                    },
                    complete: function() {
                        $('#submit-btn').prop('disabled', false);
                        $('#submit-text').text(isEditMode ? 'Update Address' : 'Save Address');
                    }
                });
            });

            // Edit address functionality
            $(document).on('click', '.btn-edit-address', function() {
                const addressId = $(this).data('address-id');
                editingAddressId = addressId;
                isEditMode = true;

                $(this).prop('disabled', true);
                $(this).html('<i class="fas fa-spinner fa-spin me-2 fs-13"></i> Loading...');

                $.ajax({
                    url: `my-account/address/${addressId}`,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const address = response.address;

                            $('#address1').val(address.address1);
                            $('#address2').val(address.address2 || '');
                            $('#state').val(address.state);
                            $('#city').val(address.city);
                            $('#country').val(address.country);
                            $('#pincode').val(address.pincode);
                            $('#is-default').prop('checked', address.is_primary === 'yes');

                            $('#form-title').text('Edit Address');
                            $('#form-icon').removeClass('fa-plus-circle').addClass('fa-edit');
                            $('#submit-text').text('Update Address');
                            $('#address-form-wrapper').slideDown();

                            $('html, body').animate({
                                scrollTop: $('#address-form-wrapper').offset().top - 80
                            }, 400);
                        } else {
                            showNotification(response.message, 'error');
                        }
                    },
                    error: function() {
                        showNotification('Error loading address data.', 'error');
                    },
                    complete: function() {
                        $('.btn-edit-address').prop('disabled', false);
                        $('.btn-edit-address').html('<i class="fas fa-pen text-primary me-2 fs-13"></i> Edit');
                    }
                });
            });

            // Delete address functionality
            $(document).on('click', '.btn-delete-address', function() {
                const addressId = $(this).data('address-id');
                const $button = $(this);
                const $addressItem = $(this).closest('.address-card-item');

                if (!confirm('Are you sure you want to delete this address? This action cannot be undone.')) {
                    return;
                }

                $button.prop('disabled', true);
                $button.html('<i class="fas fa-spinner fa-spin me-2 fs-13"></i> Deleting...');

                $.ajax({
                    url: `my-account/address/${addressId}`,
                    method: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');

                            $addressItem.fadeOut(300, function() {
                                $(this).remove();

                                const currentCount = parseInt($('#address-count').text());
                                $('#address-count').text(currentCount - 1);

                                if ($('.address-card-item').length === 0) {
                                    $('#address-list').html(`
                                        <div class="col-12" id="no-addresses">
                                            <div class="card border-0 shadow-sm">
                                                <div class="card-body text-center py-5">
                                                    <div class="mb-3" style="font-size: 64px; opacity: 0.15;">
                                                        <i class="fas fa-map-marked-alt"></i>
                                                    </div>
                                                    <h5 class="fw-semibold text-dark mb-2">No Addresses Added Yet</h5>
                                                    <p class="text-muted fs-14 mb-4">
                                                        You haven't added any address yet. Add your first address to get started with deliveries and services.
                                                    </p>
                                                    <button class="btn btn-primary rounded-pill px-4 btn-trigger-add">
                                                        <i class="fas fa-plus me-1"></i> Add Your First Address
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    `);
                                }
                            });
                        } else {
                            showNotification(response.message, 'error');
                            $button.prop('disabled', false);
                            $button.html('<i class="fas fa-trash me-2 fs-13"></i> Delete');
                        }
                    },
                    error: function() {
                        showNotification('Error deleting address.', 'error');
                        $button.prop('disabled', false);
                        $button.html('<i class="fas fa-trash me-2 fs-13"></i> Delete');
                    }
                });
            });

            // Helper function to reset form
            function resetForm() {
                $('#address-form')[0].reset();
                $('#address-id').val('');
                isEditMode = false;
                editingAddressId = null;
            }

            // Helper function to show notifications
            function showNotification(message, type) {
                const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
                const bgClass = type === 'success' ? 'alert-success' : 'alert-danger';

                const notification = $(`
                    <div class="alert ${bgClass} alert-dismissible fade show position-fixed d-flex align-items-center shadow-lg"
                         style="top: 20px; right: 20px; z-index: 9999; min-width: 320px; border-radius: 12px; border: none;">
                        <i class="fas ${icon} me-2 fs-18"></i>
                        <div class="flex-grow-1">${message}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);

                $('body').append(notification);

                setTimeout(function() {
                    notification.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 5000);
            }
        });
    </script>
@endsection
