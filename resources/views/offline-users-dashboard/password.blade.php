@extends('offline-users-dashboard/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Change Password</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row g-4">
                <!-- Security Info Card -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <div class="mb-3">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                     style="width: 90px; height: 90px; background: linear-gradient(135deg, #ea5455 0%, #ff6b6b 100%);">
                                    <i class="fas fa-shield-alt text-white" style="font-size: 36px;"></i>
                                </div>
                            </div>
                            <h5 class="fw-semibold mb-2">Password Security</h5>
                            <p class="text-muted fs-13 mb-4">Keep your account secure by using a strong password.</p>

                            <hr>

                            <!-- Password Tips -->
                            <div class="text-start">
                                <h6 class="fw-semibold mb-3 fs-14">
                                    <i class="fas fa-lightbulb text-warning me-2"></i>Password Tips
                                </h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex align-items-start mb-2">
                                        <i class="fas fa-check-circle text-success me-2 mt-1 fs-12"></i>
                                        <small class="text-muted">Use at least 8 characters</small>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <i class="fas fa-check-circle text-success me-2 mt-1 fs-12"></i>
                                        <small class="text-muted">Include uppercase & lowercase letters</small>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <i class="fas fa-check-circle text-success me-2 mt-1 fs-12"></i>
                                        <small class="text-muted">Add numbers and special characters</small>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <i class="fas fa-check-circle text-success me-2 mt-1 fs-12"></i>
                                        <small class="text-muted">Don't reuse old passwords</small>
                                    </li>
                                    <li class="d-flex align-items-start">
                                        <i class="fas fa-check-circle text-success me-2 mt-1 fs-12"></i>
                                        <small class="text-muted">Avoid personal information</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Form -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-bottom">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i class="fas fa-key text-primary me-2"></i>Update Your Password
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form id="password-form">
                                <div class="row g-3">
                                    <!-- Current Password -->
                                    <div class="col-12">
                                        <label for="current-password" class="form-label fw-medium fs-13">
                                            Current Password <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-lock text-muted fs-14"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0 border-end-0"
                                                   id="current-password" name="current_password"
                                                   placeholder="Enter your current password" required>
                                            <button class="input-group-text bg-light border-start-0 toggle-password" type="button" data-target="current-password">
                                                <i class="fas fa-eye text-muted fs-14"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="my-1">
                                    </div>

                                    <!-- New Password -->
                                    <div class="col-12">
                                        <label for="new-password" class="form-label fw-medium fs-13">
                                            New Password <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-key text-muted fs-14"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0 border-end-0"
                                                   id="new-password" name="new_password"
                                                   placeholder="Enter new password (min 8 characters)" required>
                                            <button class="input-group-text bg-light border-start-0 toggle-password" type="button" data-target="new-password">
                                                <i class="fas fa-eye text-muted fs-14"></i>
                                            </button>
                                        </div>
                                        <!-- Password Strength Indicator -->
                                        <div class="mt-2" id="password-strength-wrapper" style="display: none;">
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar" id="password-strength-bar" role="progressbar" style="width: 0%"></div>
                                            </div>
                                            <small class="mt-1 d-block" id="password-strength-text"></small>
                                        </div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="col-12">
                                        <label for="confirm-password" class="form-label fw-medium fs-13">
                                            Confirm New Password <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-lock text-muted fs-14"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0 border-end-0"
                                                   id="confirm-password" name="new_password_confirmation"
                                                   placeholder="Re-enter new password" required>
                                            <button class="input-group-text bg-light border-start-0 toggle-password" type="button" data-target="confirm-password">
                                                <i class="fas fa-eye text-muted fs-14"></i>
                                            </button>
                                        </div>
                                        <small class="text-danger mt-1 d-none" id="password-match-error">
                                            <i class="fas fa-exclamation-circle me-1"></i>Passwords do not match
                                        </small>
                                        <small class="text-success mt-1 d-none" id="password-match-success">
                                            <i class="fas fa-check-circle me-1"></i>Passwords match
                                        </small>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('index') }}" class="btn btn-light rounded-pill px-4">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="password-btn">
                                        <i class="fas fa-save me-1"></i>
                                        <span id="password-text">Update Password</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }
        .input-group-text {
            cursor: pointer;
        }
        .form-control {
            padding: 0.6rem 0.75rem;
        }
        .toggle-password:hover {
            background-color: #e9ecef !important;
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

    // Toggle password visibility
    $(document).on('click', '.toggle-password', function() {
        const targetId = $(this).data('target');
        const input = $('#' + targetId);
        const icon = $(this).find('i');

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Password strength checker
    $('#new-password').on('input', function() {
        const password = $(this).val();
        const wrapper = $('#password-strength-wrapper');
        const bar = $('#password-strength-bar');
        const text = $('#password-strength-text');

        if (password.length === 0) {
            wrapper.hide();
            return;
        }

        wrapper.show();
        let strength = 0;

        if (password.length >= 8) strength += 25;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
        if (/\d/.test(password)) strength += 25;
        if (/[^a-zA-Z0-9]/.test(password)) strength += 25;

        bar.css('width', strength + '%');

        if (strength <= 25) {
            bar.removeClass().addClass('progress-bar bg-danger');
            text.text('Weak').removeClass().addClass('text-danger mt-1 d-block fs-12');
        } else if (strength <= 50) {
            bar.removeClass().addClass('progress-bar bg-warning');
            text.text('Fair').removeClass().addClass('text-warning mt-1 d-block fs-12');
        } else if (strength <= 75) {
            bar.removeClass().addClass('progress-bar bg-info');
            text.text('Good').removeClass().addClass('text-info mt-1 d-block fs-12');
        } else {
            bar.removeClass().addClass('progress-bar bg-success');
            text.text('Strong').removeClass().addClass('text-success mt-1 d-block fs-12');
        }
    });

    // Real-time password match validation
    $('#new-password, #confirm-password').on('input', function() {
        const newPassword = $('#new-password').val();
        const confirmPassword = $('#confirm-password').val();

        if (newPassword.length > 0 && newPassword.length < 8) {
            $('#new-password').addClass('is-invalid').removeClass('is-valid');
        } else if (newPassword.length >= 8) {
            $('#new-password').addClass('is-valid').removeClass('is-invalid');
        } else {
            $('#new-password').removeClass('is-invalid is-valid');
        }

        if (confirmPassword.length > 0) {
            if (newPassword !== confirmPassword) {
                $('#confirm-password').addClass('is-invalid').removeClass('is-valid');
                $('#password-match-error').removeClass('d-none');
                $('#password-match-success').addClass('d-none');
            } else {
                $('#confirm-password').addClass('is-valid').removeClass('is-invalid');
                $('#password-match-error').addClass('d-none');
                $('#password-match-success').removeClass('d-none');
            }
        } else {
            $('#confirm-password').removeClass('is-invalid is-valid');
            $('#password-match-error').addClass('d-none');
            $('#password-match-success').addClass('d-none');
        }
    });

    // Password form submission
    $('#password-form').on('submit', function(e) {
        e.preventDefault();

        const currentPassword = $('#current-password').val();
        const newPassword = $('#new-password').val();
        const confirmPassword = $('#confirm-password').val();

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

        $('#password-btn').prop('disabled', true);
        $('#password-text').html('<i class="fas fa-spinner fa-spin me-1"></i> Updating...');

        $.ajax({
            url: 'my-account/password',
            method: 'PUT',
            data: formData,
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    $('#password-form')[0].reset();
                    $('#password-strength-wrapper').hide();
                    $('#password-match-error, #password-match-success').addClass('d-none');
                    $('.form-control').removeClass('is-valid is-invalid');

                    setTimeout(function() {
                        if (confirm('Password updated successfully! You will be logged out for security. Click OK to continue.')) {
                            window.location.href = '/demo';
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
