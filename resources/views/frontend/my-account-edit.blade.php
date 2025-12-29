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
                            <li><a href="{{ route('my-account-edit') }}" class="my-account-nav-item">Dashboard</a></li>
                            <li><a href="{{ route('my-account-orders') }}" class="my-account-nav-item">Orders</a></li>
                            <li><a href="{{ route('my-account-address') }}" class="my-account-nav-item">Address</a></li>
                            <li><span class="my-account-nav-item active">Account Details</span></li>
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
                    <div class="my-account-content account-details">
                        <div class="wrap">
                            <h4 class="fw-semibold mb-20">Account Information</h4>
                            <form class="form-account-details" id="profile-form">
                                <div class="form-content">
                                    <div class="cols">
                                        <fieldset>
                                            <label for="first-name">First Name *</label>
                                            <input type="text" id="first-name" name="first_name" placeholder="First Name"
                                                   value="{{ $user->first_name ?? '' }}" required>
                                        </fieldset>
                                        <fieldset>
                                            <label for="last-name">Last Name *</label>
                                            <input type="text" id="last-name" name="last_name" placeholder="Last Name"
                                                   value="{{ $user->last_name ?? '' }}" required>
                                        </fieldset>
                                    </div>
                                    <div class="cols">
                                        <fieldset>
                                            <label for="email">Email *</label>
                                            <input type="email" id="email" name="email" placeholder="Email"
                                                   value="{{ $user->email }}" required>
                                        </fieldset>
                                        <fieldset>
                                            <label for="phone">Phone Number</label>
                                            <input type="text" id="phone" name="phone" placeholder="Phone Number"
                                                   value="{{ $user->phone ?? '' }}">
                                        </fieldset>
                                    </div>
                                    <fieldset>
                                        <label for="primary-address">Primary Address</label>
                                        <input type="text" id="primary-address" placeholder="Primary Address"
                                               value="{{ $primaryAddress ? $primaryAddress->address_line_1 . ', ' . $primaryAddress->city . ', ' . $primaryAddress->state . ' - ' . $primaryAddress->zipcode : 'No primary address set' }}"
                                               readonly>
                                        <small class="text-muted">
                                            <a href="{{ route('my-account-address') }}" class="link text-secondary">
                                                Edit Address
                                            </a>
                                        </small>
                                    </fieldset>

                                    <div class="box-btn">
                                        <button type="submit" class="tf-btn btn-large" id="update-btn">
                                            <span class="text-white" id="update-text">Update Account</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
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

    // Profile form submission
    $('#profile-form').on('submit', function(e) {
        e.preventDefault();

        const formData = {
            first_name: $('#first-name').val(),
            last_name: $('#last-name').val(),
            email: $('#email').val(),
            phone: $('#phone').val()
        };

        // Show loading state
        $('#update-btn').prop('disabled', true);
        $('#update-text').text('Updating...');

        $.ajax({
            url: '/my-account/profile',
            method: 'PUT',
            data: formData,
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function(xhr) {
                let message = 'An error occurred while updating your profile.';

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    message = Object.values(errors).flat().join(', ');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                showNotification(message, 'error');
            },
            complete: function() {
                $('#update-btn').prop('disabled', false);
                $('#update-text').text('Update Account');
            }
        });
    });

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
