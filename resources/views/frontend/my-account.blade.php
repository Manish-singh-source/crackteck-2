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
                            <li><span class="my-account-nav-item active">Dashboard</span></li>
                            <li><a href="{{ route('my-account-orders') }}" class="my-account-nav-item">Orders</a></li>
                            <li><a href="{{ route('my-account-address') }}" class="my-account-nav-item">Address</a></li>
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
                    <div class="my-account-content account-dashboard">
                        <div class="mb_60">
                            <h3 class="fw-semibold mb-20">Hello Technofra</h3>
                            <p>
                                From your account dashboard you can view your
                                <a class="text-secondary link fw-medium" href="{{ route('my-account-orders') }}">
                                    recent orders
                                </a>
                                , manage your
                                <a class="text-secondary link fw-medium" href="{{ route('my-account-address') }}">
                                    shipping and billing address
                                </a>
                                , and
                                <a class="text-secondary link fw-medium" href="{{ route('my-account-edit') }}">
                                    edit your password and account details
                                </a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /My Account -->
@endsection
