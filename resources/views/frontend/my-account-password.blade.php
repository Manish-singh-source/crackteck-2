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
                            <li><a href="{{ route('my-account-edit') }}" class="my-account-nav-item">Account Details</a>
                            </li>
                            <li><span class="my-account-nav-item active">Change Password</span></li>
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
                            <h4 class="fw-semibold mb-20">Change Password</h4>
                            <form class="def form-reset-password" id="password-form">
                                <fieldset>
                                    <label for="current-password">Current Password *</label>
                                    <input type="password" id="current-password" name="current_password"
                                           placeholder="Current Password" required>
                                </fieldset>
                                <fieldset>
                                    <label for="new-password">New Password *</label>
                                    <input type="password" id="new-password" name="new_password"
                                           placeholder="New Password (minimum 8 characters)" required>
                                    <small class="text-muted">Password must be at least 8 characters long</small>
                                </fieldset>
                                <fieldset>
                                    <label for="confirm-password">Confirm New Password *</label>
                                    <input type="password" id="confirm-password" name="new_password_confirmation"
                                           placeholder="Confirm New Password" required>
                                </fieldset>
                                <div class="box-btn">
                                    <button type="submit" class="tf-btn btn-large" id="password-btn">
                                        <span class="text-white" id="password-text">Update Password</span>
                                    </button>
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

    // Password form submission
    $('#password-form').on('submit', function(e) {
        e.preventDefault();

        // Client-side validation
        const currentPassword = $('#current-password').val();
        const newPassword = $('#new-password').val();
        const confirmPassword = $('#confirm-password').val();

        // Basic validation
        if (currentPassword.length === 0) {
            showNotification('Current password is required.', 'error');
            return;
        }

        if (newPassword.length < 8) {
            showNotification('New password must be at least 8 characters long.', 'error');
            return;
        }

        if (newPassword !== confirmPassword) {
            showNotification('New password and confirm password do not match.', 'error');
            return;
        }

        if (currentPassword === newPassword) {
            showNotification('New password must be different from current password.', 'error');
            return;
        }

        const formData = {
            current_password: currentPassword,
            new_password: newPassword,
            new_password_confirmation: confirmPassword
        };

        // Show loading state
        $('#password-btn').prop('disabled', true);
        $('#password-text').text('Updating...');

        $.ajax({
            url: '/my-account/password',
            method: 'PUT',
            data: formData,
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');

                    // Clear form
                    $('#password-form')[0].reset();

                    // Optional: Redirect to login after password change
                    setTimeout(function() {
                        if (confirm('Password updated successfully! You will be logged out for security. Click OK to continue.')) {
                            window.location.href = '/frontend/logout';
                        }
                    }, 2000);
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function(xhr) {
                let message = 'An error occurred while updating your password.';

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    message = Object.values(errors).flat().join(', ');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                showNotification(message, 'error');
            },
            complete: function() {
                $('#password-btn').prop('disabled', false);
                $('#password-text').text('Update Password');
            }
        });
    });

    // Real-time password validation
    $('#new-password, #confirm-password').on('input', function() {
        const newPassword = $('#new-password').val();
        const confirmPassword = $('#confirm-password').val();

        // Check password length
        if (newPassword.length > 0 && newPassword.length < 8) {
            $('#new-password').addClass('is-invalid');
        } else {
            $('#new-password').removeClass('is-invalid');
        }

        // Check password match
        if (confirmPassword.length > 0 && newPassword !== confirmPassword) {
            $('#confirm-password').addClass('is-invalid');
        } else {
            $('#confirm-password').removeClass('is-invalid');
        }
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
