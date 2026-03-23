<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Forgot Password | Crackteck</title>
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
                                                <h3 class="text-dark fw-semibold mb-3">Forgot Your Password?</h3>
                                                <p class="text-muted fs-14 mb-0">No problem. Just enter your email address below and we'll send you a link to reset your password.</p>
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

                                            <form method="POST" action="{{ route('password.send-reset-link') }}" class="my-4">
                                                @csrf
                                                
                                                <!-- Hidden user_type field -->
                                                <input type="hidden" name="user_type" value="{{ $source === 'staff' ? 'staff' : 'customer' }}">

                                                <div class="form-group mb-3">
                                                    <label for="email" class="form-label">Email address</label>
                                                    <input class="form-control @error('email') is-invalid @enderror"
                                                        type="email" id="email" name="email"
                                                        value="{{ old('email') }}" required
                                                        placeholder="Enter your email">
                                                    
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-0 row">
                                                    <div class="col-12">
                                                        <div class="d-grid">
                                                            <button class="btn btn-primary" type="submit">
                                                                Send Password Reset Link
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="text-center mt-3">
                                                <p class="text-muted fs-14 mb-0">
                                                    Remember your password? 
                                                    <a href="{{ route('login') }}" class="text-muted fw-semibold">Login here</a>
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
</body>

</html>
