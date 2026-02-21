<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>

    <meta charset="utf-8" />
    <title>Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta name="description" content="" /> -->
    <meta name="author" content="Technofra" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('assets/js/head.js') }}"></script>


</head>

<body>
    <!-- Begin page -->
    <div class="account-page">
        <div class="container-fluid p-0">
            {{-- <div class="row align-items-center g-0 px-3 py-3 vh-100"> --}}

                <div class="col">
                    <div class="row">
                        <div class="col-3 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-0 p-0 p-lg-3">
                                        <div class="mb-0 border-0 p-md-4 p-lg-0">

                                            <div class="auth-title-section mb-4 text-lg-start text-center">
                                                <h3 class="text-dark fw-semibold mb-3">Welcome back! Please Sign in to continue.</h3>
                                                <p class="text-muted fs-14 mb-0">Log in to your account to continue exploring our services, manage your information, and stay connected with the latest updates.</p>
                                            </div>

                                            <div class="pt-0">
                                                <form action="{{ route('loginStore') }}" method="POST" class="my-4">
                                                    @csrf
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

                                                    <div class="form-group mb-3">
                                                        <label for="password" class="form-label">Password</label>
                                                        <input class="form-control @error('password') is-invalid @enderror"
                                                         type="password" required id="password"
                                                         name="password"
                                                         placeholder="Enter your password">

                                                         @error('password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                         @enderror
                                                    </div>

                                                    <!-- 
                                                    <div class="otp from-group mb-3">
                                                        <label for="otp" class="form-label"><strong> We need to verify you </strong> </label>
                                                        <p>code has been send to ****@gmail.com</p>
                                                        <input style="width: 25px;" type="text">
                                                        <input style="width: 25px;" type="text">
                                                        <input style="width: 25px;" type="text">
                                                        <input style="width: 25px;" type="text">
                                                    </div> 
                                                    -->

                                                    <div class="form-group d-flex mb-3">
                                                        <div class="col-sm-6">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 text-end">
                                                            <a class='text-muted fs-14' href="{{ route('recover-password') }}">Forgot password?</a>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-0 row">
                                                        <div class="col-12">
                                                            <div class="d-grid">
                                                                <button class="btn btn-primary fw-semibold" type="submit"> Log In </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            {{-- </div> --}}
        </div>
    </div>

    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>

    <!-- App js-->
    <script src="assets/js/app.js"></script>

</body>


</html>