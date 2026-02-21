@extends('offline-users-dashboard/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Account Details</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Account Details</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row g-4">
                <!-- Profile Card -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <!-- Avatar -->
                            <div class="mb-3">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                     style="width: 90px; height: 90px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <span class="text-white fw-bold" style="font-size: 36px;">
                                        {{ strtoupper(substr($customer->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($customer->last_name ?? '', 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                            <h5 class="fw-semibold mb-1">{{ ($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '') }}</h5>
                            <p class="text-muted fs-13 mb-3">{{ $customer->email ?? '' }}</p>
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">
                                <i class="fas fa-check-circle me-1"></i>Active Account
                            </span>

                            <hr class="my-4">

                            <!-- Quick Info -->
                            <div class="text-start">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="rounded d-flex align-items-center justify-content-center"
                                             style="width: 38px; height: 38px; background: rgba(102, 126, 234, 0.1);">
                                            <i class="fas fa-envelope text-primary fs-14"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <small class="text-muted d-block">Email</small>
                                        <span class="fw-medium fs-13">{{ $customer->email ?? 'Not set' }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="rounded d-flex align-items-center justify-content-center"
                                             style="width: 38px; height: 38px; background: rgba(40, 199, 111, 0.1);">
                                            <i class="fas fa-phone text-success fs-14"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <small class="text-muted d-block">Phone</small>
                                        <span class="fw-medium fs-13">{{ $customer->phone ?? 'Not set' }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded d-flex align-items-center justify-content-center"
                                             style="width: 38px; height: 38px; background: rgba(255, 159, 67, 0.1);">
                                            <i class="fas fa-map-marker-alt" style="color: #ff9f43; font-size: 14px;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <small class="text-muted d-block">Primary Address</small>
                                        <span class="fw-medium fs-13">
                                            {{ $primaryAddress ? $primaryAddress->city . ', ' . $primaryAddress->state : 'Not set' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Form -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-bottom">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i class="fas fa-user-edit text-primary me-2"></i>Edit Account Information
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form id="profile-form">
                                <div class="row g-3">
                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <label for="first-name" class="form-label fw-medium fs-13">
                                            First Name <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-user text-muted fs-14"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="first-name"
                                                   name="first_name" placeholder="Enter first name"
                                                   value="{{ $customer->first_name ?? '' }}" required>
                                        </div>
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-md-6">
                                        <label for="last-name" class="form-label fw-medium fs-13">
                                            Last Name <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-user text-muted fs-14"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="last-name"
                                                   name="last_name" placeholder="Enter last name"
                                                   value="{{ $customer->last_name ?? '' }}" required>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-medium fs-13">
                                            Email Address <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-envelope text-muted fs-14"></i>
                                            </span>
                                            <input type="email" class="form-control border-start-0" id="email"
                                                   name="email" placeholder="Enter email address"
                                                   value="{{ $customer->email }}" required>
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-medium fs-13">
                                            Phone Number
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-phone text-muted fs-14"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="phone"
                                                   name="phone" placeholder="Enter phone number"
                                                   value="{{ $customer->phone ?? '' }}">
                                        </div>
                                    </div>

                                    <!-- Primary Address (Read Only) -->
                                    <div class="col-12">
                                        <label for="primary-address" class="form-label fw-medium fs-13">
                                            Primary Address
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-map-marker-alt text-muted fs-14"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 bg-light" id="primary-address"
                                                   placeholder="Primary Address"
                                                   value="{{ $primaryAddress ? $primaryAddress->address1 . ', ' . $primaryAddress->city . ', ' . $primaryAddress->state . ' - ' . $primaryAddress->pincode : 'No primary address set' }}"
                                                   readonly>
                                            <a href="{{ route('my-account-address') }}" class="input-group-text bg-primary text-white text-decoration-none border-0">
                                                <i class="fas fa-pen fs-13"></i>
                                            </a>
                                        </div>
                                        <small class="text-muted fs-12 mt-1 d-block">
                                            <i class="fas fa-info-circle me-1"></i>To change your address, click the edit button above.
                                        </small>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('index') }}" class="btn btn-light rounded-pill px-4">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="update-btn">
                                        <i class="fas fa-save me-1"></i>
                                        <span id="update-text">Update Account</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-transparent border-bottom">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i class="fas fa-shield-alt text-warning me-2"></i>Security
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 48px; height: 48px; background: rgba(234, 84, 85, 0.1);">
                                            <i class="fas fa-lock" style="color: #ea5455; font-size: 18px;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fw-semibold mb-1">Password</h6>
                                        <small class="text-muted">Last changed: Unknown</small>
                                    </div>
                                </div>
                                <a href="{{ route('my-account-edit') }}" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                    <i class="fas fa-key me-1"></i> Change Password
                                </a>
                            </div>
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
        $('#update-text').html('<i class="fas fa-spinner fa-spin me-1"></i> Updating...');

        $.ajax({
            url: 'my-account/profile',
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
                $('#update-text').html('Update Account');
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
