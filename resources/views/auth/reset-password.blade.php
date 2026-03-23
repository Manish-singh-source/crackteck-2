<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Reset Password | Crackteck</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Technofra" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('assets/js/head.js') }}"></script>
</head>

<body>
    <div class="account-page">
        <div class="container-fluid p-0">
            <div class="row align-items-center g-0 px-3 py-3 vh-100">
                <div class="col-xl-5">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-0 p-0 p-lg-3">
                                        <div class="mb-0 border-0 p-md-4 p-lg-0">
                                            <div class="auth-title-section mb-4 text-lg-start text-center">
                                                <div class="mb-3">
                                                    <i class="mdi mdi-lock-reset fs-1 text-primary"></i>
                                                </div>
                                                <h3 class="text-dark fw-semibold mb-3">Reset Your Password</h3>
                                                <p class="text-muted fs-14 mb-0">Please enter your new password below. Make sure to use a strong password that you haven't used before.</p>
                                            </div>

                                            <!-- Success Message -->
                                            @if(session('success'))
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    {{ session('success') }}
                                                </div>
                                            @endif

                                            <!-- Error Message -->
                                            @if(session('error'))
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    {{ session('error') }}
                                                </div>
                                            @endif

                                            <!-- Validation Errors -->
                                            @if($errors->any())
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <ul class="mb-0">
                                                        @foreach($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <form method="POST" action="{{ route('password.reset') }}" class="my-4">
                                                @csrf
                                                
                                                <!-- Hidden fields for token and user type -->
                                                <input type="hidden" name="token" value="{{ $token }}">
                                                <input type="hidden" name="email" value="{{ $email }}">
                                                <input type="hidden" name="user_type" value="{{ $userType }}">

                                                <div class="form-group mb-3">
                                                    <label for="email" class="form-label">Email Address</label>
                                                    <input class="form-control"
                                                        type="email" 
                                                        value="{{ $email }}" 
                                                        disabled>
                                                    <input type="hidden" name="email" value="{{ $email }}">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="password" class="form-label">New Password</label>
                                                    <div class="input-group">
                                                        <input class="form-control @error('password') is-invalid @enderror"
                                                            type="password" 
                                                            id="password" 
                                                            name="password"
                                                            required
                                                            placeholder="Enter new password">
                                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                            <i class="mdi mdi-eye-outline"></i>
                                                        </button>
                                                    </div>
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @else
                                                        <div class="form-text">Minimum 8 characters</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                                    <div class="input-group">
                                                        <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                                            type="password" 
                                                            id="password_confirmation" 
                                                            name="password_confirmation"
                                                            required
                                                            placeholder="Confirm new password">
                                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                                            <i class="mdi mdi-eye-outline"></i>
                                                        </button>
                                                    </div>
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-0 row">
                                                    <div class="col-12">
                                                        <div class="d-grid">
                                                            <button class="btn btn-primary" type="submit">
                                                                Reset Password
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="text-center mt-3">
                                                <p class="text-muted fs-14 mb-0">
                                                    <a href="{{ route('login') }}" class="text-muted fw-semibold">Back to Login</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right side - Image/Branding -->
                <div class="col-xl-7 d-none d-xl-block">
                    <div class="auth-page-sidebar">
                        <div class="overlay"></div>
                        <div class="auth-user-testimonial">
                            <p class="fs-18 fw-semibold mb-1">Crackteck</p>
                            <p class="fs-14">Your trusted service partner</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('mdi-eye-outline');
                icon.classList.add('mdi-eye-off-outline');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('mdi-eye-off-outline');
                icon.classList.add('mdi-eye-outline');
            }
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('mdi-eye-outline');
                icon.classList.add('mdi-eye-off-outline');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('mdi-eye-off-outline');
                icon.classList.add('mdi-eye-outline');
            }
        });
    </script>
</body>

</html>
