@extends('frontend/layout/master')

@section('main-content')
    <!-- Breakcrumbs -->
    <div class="tf-sp-1 pb-0">
        <div class="container">
            <ul class="breakcrumbs">
                <li>
                    <a href="{{ route('website') }}" class="body-small link">
                        Home
                    </a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="icon icon-arrow-right"></i>
                </li>
                <li>
                    <span class="body-small">Account</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->
    <!-- My Account -->
    <section class="tf-sp-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="wrap-sidebar-account ">
                        <ul class="my-account-nav content-append">
                            <li><a href="{{ route('my-account') }}" class="my-account-nav-item">Dashboard</a></li>
                            <li><a href="{{ route('my-account-orders') }}" class="my-account-nav-item">Orders</a></li>
                            <li><span class="my-account-nav-item active">Address</span></li>
                            <li><a href="{{ route('my-account-edit') }}" class="my-account-nav-item">Account Details</a>
                            </li>
                            <li><a href="{{ route('my-account-password') }}" class="my-account-nav-item">Change Password</a></li>
                            <li><a href="{{ route('my-account-amc') }}" class="my-account-nav-item">AMC</a></li>
                            <li><a href="{{ route('my-account-non-amc') }}" class="my-account-nav-item">NON AMC</a>
                            </li>
                            <li><a href="{{ route('wishlist') }}" class="my-account-nav-item">Wishlist</a></li>
                            @if (Auth::check())
                                <form method="POST" action="{{ route('frontend.logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Logout</button>
                            </form>
                            @else
                                <form method="POST" action="{{ route('frontend.login') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </form>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="my-account-content account-address">
                        <h4 class="fw-semibold mb-20">Your addresses (<span id="address-count">{{ $addresses->count() }}</span>)</h4>
                        <div class="widget-inner-address ">
                            <button class="tf-btn btn-add-address" id="btn-add-address">
                                <span class="text-white">Add new address</span>
                            </button>
                            <form class="wd-form-address show-form-address mb-20" id="address-form" style="display: none;">
                                <input type="hidden" id="address-id" name="address_id">
                                <div class="form-content">
                                    <div class="cols">
                                        <fieldset>
                                            <label for="first-name">First Name *</label>
                                            <input type="text" id="first-name" name="first_name" required>
                                        </fieldset>
                                        <fieldset>
                                            <label for="last-name">Last Name *</label>
                                            <input type="text" id="last-name" name="last_name" required>
                                        </fieldset>
                                    </div>
                                    <div class="cols">
                                        <fieldset>
                                            <label for="country">Country/Region *</label>
                                            <input type="text" id="country" name="country" required>
                                        </fieldset>
                                        <fieldset>
                                            <label for="phone">Phone Number *</label>
                                            <input type="text" id="phone" name="phone" required>
                                        </fieldset>
                                    </div>
                                    <div class="cols">
                                        <fieldset>
                                            <label for="state">State *</label>
                                            <input type="text" id="state" name="state" required>
                                        </fieldset>
                                        <fieldset>
                                            <label for="city">City *</label>
                                            <input type="text" id="city" name="city" required>
                                        </fieldset>
                                    </div>
                                    <fieldset>
                                        <label for="zipcode">Zipcode *</label>
                                        <input type="text" id="zipcode" name="zipcode" required>
                                    </fieldset>
                                    <fieldset>
                                        <label for="address-line-1">Address Line 1 *</label>
                                        <input type="text" id="address-line-1" name="address_line_1" required>
                                    </fieldset>
                                    <fieldset>
                                        <label for="address-line-2">Address Line 2</label>
                                        <input type="text" id="address-line-2" name="address_line_2">
                                    </fieldset>
                                    <div class="tf-cart-checkbox">
                                        <input type="checkbox" name="is_default" value="1" class="tf-check" id="is-default">
                                        <label for="is-default">Set as Default Address</label>
                                    </div>
                                </div>
                                <div class="box-btn">
                                    <button class="tf-btn btn-large" type="submit" id="submit-btn">
                                        <span class="text-white" id="submit-text">Save Address</span>
                                    </button>
                                    <button type="button" class="tf-btn btn-large btn-hide-address d-inline-flex" id="cancel-btn">
                                        <span class="text-white">Cancel</span>
                                    </button>
                                </div>
                            </form>
                            <ul class="list-account-address tf-grid-layout md-col-2" id="address-list">
                                @forelse($addresses as $address)
                                <li class="account-address-item" data-address-id="{{ $address->id }}">
                                    <p class="title title-sidebar fw-semibold">
                                        {{ $address->full_name }}
                                        @if($address->is_default)
                                            <span class="badge bg-primary ms-2">Default</span>
                                        @endif
                                    </p>
                                    <div class="info-detail">
                                        <div class="box-infor">
                                            <p class="title-sidebar">{{ $address->first_name }} {{ $address->last_name }}</p>
                                            <p class="title-sidebar">{{ $address->phone }}</p>
                                            <p class="title-sidebar">{{ $address->address_line_1 }}</p>
                                            @if($address->address_line_2)
                                                <p class="title-sidebar">{{ $address->address_line_2 }}</p>
                                            @endif
                                            <p class="title-sidebar">{{ $address->city }}, {{ $address->state }}</p>
                                            <p class="title-sidebar">{{ $address->country }} - {{ $address->zipcode }}</p>
                                        </div>
                                        <div class="box-btn">
                                            <button class="tf-btn btn-large btn-edit-address" data-address-id="{{ $address->id }}">
                                                <span class="text-white">Edit</span>
                                            </button>
                                            <button class="tf-btn btn-large btn-delete-address" data-address-id="{{ $address->id }}">
                                                <span class="text-white">Delete</span>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <li class="account-address-item" id="no-addresses">
                                    <div class="text-center py-4">
                                        <p class="title-sidebar">No addresses found.</p>
                                        <p class="body-text">Click "Add new address" to add your first address.</p>
                                    </div>
                                </li>
                                @endforelse
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /My Account -->
@endsection

@section('script')
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
    $('#btn-add-address').on('click', function() {
        resetForm();
        isEditMode = false;
        $('#submit-text').text('Save Address');
        $('#address-form').slideDown();
        $(this).hide();
    });

    $('#cancel-btn').on('click', function() {
        $('#address-form').slideUp();
        $('#btn-add-address').show();
        resetForm();
    });

    // Form submission
    $('#address-form').on('submit', function(e) {
        e.preventDefault();

        const formData = {
            first_name: $('#first-name').val(),
            last_name: $('#last-name').val(),
            country: $('#country').val(),
            phone: $('#phone').val(),
            state: $('#state').val(),
            city: $('#city').val(),
            zipcode: $('#zipcode').val(),
            address_line_1: $('#address-line-1').val(),
            address_line_2: $('#address-line-2').val(),
            is_default: $('#is-default').is(':checked')
        };

        // Show loading state
        $('#submit-btn').prop('disabled', true);
        $('#submit-text').text(isEditMode ? 'Updating...' : 'Saving...');

        const url = isEditMode ?
            `/my-account/address/${editingAddressId}` :
            '/my-account/address';
        const method = isEditMode ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');

                    // Hide form and show add button
                    $('#address-form').slideUp();
                    $('#btn-add-address').show();

                    // Reload page to show updated addresses
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

        // Show loading state
        $(this).prop('disabled', true);
        $(this).find('span').text('Loading...');

        $.ajax({
            url: `/my-account/address/${addressId}`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const address = response.address;

                    // Populate form with address data
                    $('#first-name').val(address.first_name);
                    $('#last-name').val(address.last_name);
                    $('#country').val(address.country);
                    $('#phone').val(address.phone);
                    $('#state').val(address.state);
                    $('#city').val(address.city);
                    $('#zipcode').val(address.zipcode);
                    $('#address-line-1').val(address.address_line_1);
                    $('#address-line-2').val(address.address_line_2);
                    $('#is-default').prop('checked', address.is_default);

                    // Update form UI
                    $('#submit-text').text('Update Address');
                    $('#address-form').slideDown();
                    $('#btn-add-address').hide();

                    // Scroll to form
                    $('html, body').animate({
                        scrollTop: $('#address-form').offset().top - 100
                    }, 500);
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function() {
                showNotification('Error loading address data.', 'error');
            },
            complete: function() {
                $('.btn-edit-address').prop('disabled', false);
                $('.btn-edit-address span').text('Edit');
            }
        });
    });

    // Delete address functionality
    $(document).on('click', '.btn-delete-address', function() {
        const addressId = $(this).data('address-id');
        const $button = $(this);
        const $addressItem = $(this).closest('.account-address-item');

        // Confirm deletion
        if (!confirm('Are you sure you want to delete this address? This action cannot be undone.')) {
            return;
        }

        // Show loading state
        $button.prop('disabled', true);
        $button.find('span').text('Deleting...');

        $.ajax({
            url: `/my-account/address/${addressId}`,
            method: 'DELETE',
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');

                    // Remove address item with animation
                    $addressItem.fadeOut(300, function() {
                        $(this).remove();

                        // Update address count
                        const currentCount = parseInt($('#address-count').text());
                        $('#address-count').text(currentCount - 1);

                        // Show "no addresses" message if no addresses left
                        if ($('.account-address-item').length === 0) {
                            $('#address-list').append(`
                                <li class="account-address-item" id="no-addresses">
                                    <div class="text-center py-4">
                                        <p class="title-sidebar">No addresses found.</p>
                                        <p class="body-text">Click "Add new address" to add your first address.</p>
                                    </div>
                                </li>
                            `);
                        }
                    });
                } else {
                    showNotification(response.message, 'error');
                    $button.prop('disabled', false);
                    $button.find('span').text('Delete');
                }
            },
            error: function() {
                showNotification('Error deleting address.', 'error');
                $button.prop('disabled', false);
                $button.find('span').text('Delete');
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
        // Create notification element
        const notification = $(`
            <div class="alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed"
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

        // Add to body
        $('body').append(notification);

        // Auto remove after 5 seconds
        setTimeout(function() {
            notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);

        // Allow manual close on click
        notification.on('click', function() {
            $(this).fadeOut(300, function() {
                $(this).remove();
            });
        });
    }
});
</script>
@endsection
