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
            <div class="row align-items-center g-0 px-3 py-3 vh-100">

                <div class="col-xl-5">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-0 p-0 p-lg-3">
                                        <div class="mb-0 border-0 p-md-4 p-lg-0">

                                            <div class="auth-title-section mb-4 text-lg-start text-center">
                                                <h3 class="text-dark fw-semibold mb-3">Welcome back! Please Sign in to continue.</h3>
                                                <p class="text-muted fs-14 mb-0">Sign up today to unlock exclusive content, enjoy special offers, and be the first to hear about exciting updates and announcements.</p>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 mt-2">
                                                    <a href="{{ route('auth.redirect', ['provider' => 'google', 'source' => 'admin']) }}" class="btn text-dark border fw-normal d-flex align-items-center justify-content-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48" class="me-2">
                                                            <path fill="#ffc107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917" />
                                                            <path fill="#ff3d00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691" />
                                                            <path fill="#4caf50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44" />
                                                            <path fill="#1976d2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917" />
                                                        </svg>
                                                        <span>Google</span>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="saprator my-4"><span>or continue</span></div>

                                            <!-- Login Type Toggle -->
                                            <div class="login-type-toggle">
                                                <ul class="nav nav-pills nav-justified bg-light rounded p-1" id="loginTypeTab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="email-tab" data-bs-toggle="tab" data-bs-target="#email-login" type="button" role="tab">
                                                            <i class="mdi mdi-email-outline me-1"></i>Email
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="phone-tab" data-bs-toggle="tab" data-bs-target="#phone-login" type="button" role="tab">
                                                            <i class="mdi mdi-phone-outline me-1"></i>Phone
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="tab-content" id="loginTypeTabContent">
                                                <!-- Email Login Tab -->
                                                <div class="tab-pane fade show active" id="email-login" role="tabpanel">
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

                                                        <div class="form-group d-flex mb-3">
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                                                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 text-end">
                                                                <a class='text-muted fs-14' href="{{ route('password.forgot', ['source' => 'staff']) }}">Forgot password?</a>
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

                                                <!-- Phone Login Tab -->
                                                <div class="tab-pane fade" id="phone-login" role="tabpanel">
                                                    <form action="{{ route('loginStore') }}" method="POST" class="my-4" id="phoneLoginForm">
                                                        @csrf
                                                        <input type="hidden" name="login_type" value="phone">
                                                        
                                                        <div class="form-group mb-3">
                                                            <label for="phone" class="form-label">Phone Number</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">+91</span>
                                                                <input class="form-control @error('phone') is-invalid @enderror"
                                                                 type="tel" id="phone" name="phone"
                                                                 value="{{ old('phone') }}" required
                                                                 placeholder="Enter your phone number"
                                                                 pattern="[0-9]{10}" maxlength="10">
                                                            </div>
                                                            @error('phone')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group mb-3" id="otpSection" style="display: none;">
                                                            <label for="otp" class="form-label">OTP (4 digit)</label>
                                                            <div class="otp-input-wrapper d-flex gap-2">
                                                                <input type="text" class="form-control text-center otp-digit @error('otp') is-invalid @enderror"
                                                                 id="otp1" maxlength="1" pattern="[0-9]" inputmode="numeric">
                                                                <input type="text" class="form-control text-center otp-digit @error('otp') is-invalid @enderror"
                                                                 id="otp2" maxlength="1" pattern="[0-9]" inputmode="numeric">
                                                                <input type="text" class="form-control text-center otp-digit @error('otp') is-invalid @enderror"
                                                                 id="otp3" maxlength="1" pattern="[0-9]" inputmode="numeric">
                                                                <input type="text" class="form-control text-center otp-digit @error('otp') is-invalid @enderror"
                                                                 id="otp4" maxlength="1" pattern="[0-9]" inputmode="numeric">
                                                            </div>
                                                            <input type="hidden" id="otp" name="otp">
                                                            @error('otp')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group mb-3" id="sendOtpBtn">
                                                            <button type="button" class="btn btn-info w-100" onclick="sendOTP()">
                                                                <i class="mdi mdi-send me-1"></i> Send OTP
                                                            </button>
                                                        </div>

                                                        <div class="form-group mb-0 row" id="phoneLoginBtn" style="display: none;">
                                                            <div class="col-12">
                                                                <div class="d-grid">
                                                                    <button class="btn btn-primary fw-semibold" type="submit"> Log In </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="text-center text-muted">
                                                <p class="mb-0">Don't have an account ?<a class='text-primary ms-2 fw-medium' href="{{ route('signup') }}">Sign up</a></p>
                                                <p class="mt-3 mb-0 fs-13">
                                                    <a class="text-muted me-3" href="{{ route('admin.privacy-policy') }}">Privacy Policy</a>
                                                    <a class="text-muted" href="{{ route('admin.terms-and-conditions') }}">Terms &amp; Conditions</a>
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-7 d-none d-xl-inline-block">
                    <div class="account-page-bg rounded-4">
                        <div class="auth-user-review text-center">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                <div class="carousel-inner">

                                    <div class="carousel-item active">
                                        <p class="prelead mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                                                <path fill="#ffffff" d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621c.537-.278 1.24-.375 1.929-.311c1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5a3.87 3.87 0 0 1-2.748-1.179m10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621c.537-.278 1.24-.375 1.929-.311c1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5a3.87 3.87 0 0 1-2.748-1.179" />
                                            </svg>
                                            Manage your team, customer requests, and daily operations from one place. Sign in with your authorized account to continue.
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                                                <path fill="#ffffff" d="M19.417 6.679C20.447 7.773 21 9 21 10.989c0 3.5-2.456 6.637-6.03 8.188l-.893-1.378c3.335-1.804 3.987-4.145 4.248-5.621c-.537.278-1.24.375-1.93.311c-1.804-.167-3.226-1.648-3.226-3.489a3.5 3.5 0 0 1 3.5-3.5c1.073 0 2.1.49 2.748 1.179m-10 0C10.447 7.773 11 9 11 10.989c0 3.5-2.456 6.637-6.03 8.188l-.893-1.378c3.335-1.804 3.987-4.145 4.247-5.621c-.537.278-1.24.375-1.929.311C4.591 12.323 3.17 10.842 3.17 9a3.5 3.5 0 0 1 3.5-3.5c1.073 0 2.1.49 2.748 1.179" />
                                            </svg>
                                        </p>
                                        <h4 class="mb-1">SRB Computers</h4>
                                        <p class="mb-0">Admin Portal</p>
                                    </div>

                                    <div class="carousel-item">
                                        <p class="prelead mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                                                <path fill="#ffffff" d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621c.537-.278 1.24-.375 1.929-.311c1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5a3.87 3.87 0 0 1-2.748-1.179m10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621c.537-.278 1.24-.375 1.929-.311c1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5a3.87 3.87 0 0 1-2.748-1.179" />
                                            </svg>
                                            Pretty nice theme, hoping you guys could add more features to this. Keep up the good work.
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                                                <path fill="#ffffff" d="M19.417 6.679C20.447 7.773 21 9 21 10.989c0 3.5-2.456 6.637-6.03 8.188l-.893-1.378c3.335-1.804 3.987-4.145 4.248-5.621c-.537.278-1.24.375-1.93.311c-1.804-.167-3.226-1.648-3.226-3.489a3.5 3.5 0 0 1 3.5-3.5c1.073 0 2.1.49 2.748 1.179m-10 0C10.447 7.773 11 9 11 10.989c0 3.5-2.456 6.637-6.03 8.188l-.893-1.378c3.335-1.804 3.987-4.145 4.247-5.621c-.537.278-1.24.375-1.929.311C4.591 12.323 3.17 10.842 3.17 9a3.5 3.5 0 0 1 3.5-3.5c1.073 0 2.1.49 2.748 1.179" />
                                            </svg>
                                        </p>
                                        <h4 class="mb-1">Palak Awoo</h4>
                                        <p class="mb-0">Lead Designer</p>
                                    </div>

                                    <div class="carousel-item">
                                        <p class="prelead mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                                                <path fill="#ffffff" d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621c.537-.278 1.24-.375 1.929-.311c1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5a3.87 3.87 0 0 1-2.748-1.179m10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621c.537-.278 1.24-.375 1.929-.311c1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5a3.87 3.87 0 0 1-2.748-1.179" />
                                            </svg>
                                            This is a great product, helped us a lot and very quick to work with and implement.
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                                                <path fill="#ffffff" d="M19.417 6.679C20.447 7.773 21 9 21 10.989c0 3.5-2.456 6.637-6.03 8.188l-.893-1.378c3.335-1.804 3.987-4.145 4.248-5.621c-.537.278-1.24.375-1.93.311c-1.804-.167-3.226-1.648-3.226-3.489a3.5 3.5 0 0 1 3.5-3.5c1.073 0 2.1.49 2.748 1.179m-10 0C10.447 7.773 11 9 11 10.989c0 3.5-2.456 6.637-6.03 8.188l-.893-1.378c3.335-1.804 3.987-4.145 4.247-5.621c-.537.278-1.24.375-1.929.311C4.591 12.323 3.17 10.842 3.17 9a3.5 3.5 0 0 1 3.5-3.5c1.073 0 2.1.49 2.748 1.179" />
                                            </svg>
                                        </p>
                                        <h4 class="mb-1">Laurent Smith</h4>
                                        <p class="mb-0">Product designer</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
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

    <script>
        // Custom Tab Switching for Login Type
        document.addEventListener('DOMContentLoaded', function() {
            const emailTab = document.getElementById('email-tab');
            const phoneTab = document.getElementById('phone-tab');
            const emailLogin = document.getElementById('email-login');
            const phoneLogin = document.getElementById('phone-login');
            
            // Email Tab Click
            if (emailTab) {
                emailTab.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Remove active class from phone tab, add to email tab
                    phoneTab.classList.remove('active');
                    emailTab.classList.add('active');
                    
                    // Hide phone login, show email login
                    phoneLogin.classList.remove('show', 'active');
                    emailLogin.classList.add('show', 'active');
                });
            }
            
            // Phone Tab Click
            if (phoneTab) {
                phoneTab.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Remove active class from email tab, add to phone tab
                    emailTab.classList.remove('active');
                    phoneTab.classList.add('active');
                    
                    // Hide email login, show phone login
                    emailLogin.classList.remove('show', 'active');
                    phoneLogin.classList.add('show', 'active');
                });
            }
            
            // OTP Input Auto-focus and Navigation
            const otpInputs = document.querySelectorAll('.otp-digit');
            
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    // Only allow numbers
                    this.value = this.value.replace(/[^0-9]/g, '');
                    
                    if (this.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                    
                    // Combine OTP values
                    combineOTP();
                });
                
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
                
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pasteData = e.clipboardData.getData('text');
                    const digits = pasteData.replace(/[^0-9]/g, '').split('').slice(0, 4);
                    
                    digits.forEach((digit, i) => {
                        if (otpInputs[i]) {
                            otpInputs[i].value = digit;
                        }
                    });
                    
                    if (digits.length > 0 && digits.length < 4) {
                        otpInputs[digits.length].focus();
                    } else if (digits.length === 4) {
                        otpInputs[3].focus();
                    }
                    
                    combineOTP();
                });
            });
        });
        
        function combineOTP() {
            const otp1 = document.getElementById('otp1')?.value || '';
            const otp2 = document.getElementById('otp2')?.value || '';
            const otp3 = document.getElementById('otp3')?.value || '';
            const otp4 = document.getElementById('otp4')?.value || '';
            const combinedOTP = otp1 + otp2 + otp3 + otp4;
            const otpHidden = document.getElementById('otp');
            if (otpHidden) {
                otpHidden.value = combinedOTP;
            }
            return combinedOTP;
        }

        const phoneLoginForm = document.getElementById('phoneLoginForm');
        if (phoneLoginForm) {
            phoneLoginForm.addEventListener('submit', function(e) {
                const combined = combineOTP();
                if (combined.length !== 4) {
                    e.preventDefault();
                    alert('Please enter a complete 4-digit OTP');
                    return false;
                }
            });
        }
        
        function sendOTP() {
            const phone = document.getElementById('phone').value;
            
            if (!phone || phone.length !== 10) {
                alert('Please enter a valid 10-digit phone number');
                return;
            }
            
            // Show loading state
            const sendOtpBtn = document.getElementById('sendOtpBtn');
            sendOtpBtn.innerHTML = '<button type="button" class="btn btn-info w-100" disabled><span class="spinner-border spinner-border-sm me-1"></span> Sending...</button>';
            
            // Make AJAX request to send OTP
            fetch("{{ route('send-otp') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ phone: phone })
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Failed to send OTP');
                }
                return data;
            })
            .then(data => {
                if (data.success) {
                    // Show OTP section and login button
                    document.getElementById('otpSection').style.display = 'block';
                    document.getElementById('phoneLoginBtn').style.display = 'block';
                    document.getElementById('sendOtpBtn').style.display = 'none';
                    
                    alert(data.message || 'OTP sent successfully to your mobile number via SMS.');
                    
                    // Focus on first OTP input
                    setTimeout(() => {
                        document.getElementById('otp1').focus();
                    }, 100);
                } else {
                    alert(data.message || 'Failed to send OTP');
                    sendOtpBtn.innerHTML = '<button type="button" class="btn btn-info w-100" onclick="sendOTP()"><i class="mdi mdi-send me-1"></i> Send OTP</button>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'An error occurred. Please check console for details.');
                sendOtpBtn.innerHTML = '<button type="button" class="btn btn-info w-100" onclick="sendOTP()"><i class="mdi mdi-send me-1"></i> Send OTP</button>';
            });
        }
    </script>

</body>


</html>
