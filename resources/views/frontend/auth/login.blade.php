@extends('frontend.layout.master')

@section('main-content')
<div class="tf-page-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading text-center">
                    <h1>Login</h1>
                    <p class="text-center text-2 text-gray-600 mt-3">
                        Sign in to your account to access your cart and wishlist
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="flat-spacing-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="tf-login-form">
                    <div class="tf-heading-section text-center mb-4">
                        <h2 class="heading">Welcome Back</h2>
                        <p class="sub-heading">Please sign in to your account</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('ecommerce.login.post') }}" class="form-login">
                        @csrf
                        <fieldset class="email">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" 
                                   value="{{ old('email') }}" required>
                        </fieldset>
                        <fieldset class="password">
                            <label for="password">Password *</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        </fieldset>
                        <div class="bottom">
                            <div class="w-100">
                                <button type="submit" class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center">
                                    <span>Sign In</span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-gray-600">
                            Don't have an account? 
                            <a href="{{ route('ecommerce.signup') }}" class="text-primary fw-semibold">Sign up here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('style')
<style>
.tf-login-form {
    background: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.tf-login-form fieldset {
    margin-bottom: 20px;
}

.tf-login-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.tf-login-form input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.tf-login-form input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.tf-btn {
    background: #007bff;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 4px;
    font-weight: 500;
    transition: background-color 0.3s ease;
}

.tf-btn:hover {
    background: #0056b3;
}

.alert {
    padding: 12px 16px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}
</style>
@endsection
