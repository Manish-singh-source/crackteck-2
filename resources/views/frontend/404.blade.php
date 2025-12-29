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
                <span class="body-small">404 Not Found</span>
            </li>
        </ul>
    </div>
</div>
<!-- /Breakcrumbs -->
<!-- 404 Not Found -->
<section class="tf-sp-6">
    <div class="container">
        <div class="wg-404 text-center">
            <h1 class="text-primary">404</h1>
            <p class="notice title-normal fw-semibold"><span class="text-primary">Whoops!</span> We couldn’t
                find the page
                you were looking for.</p>
            <div class="box-btn">
                <a href="{{ route('website') }}" class="tf-btn text-white d-inline-flex">
                    Back To Home Page
                </a>
            </div>
        </div>
    </div>
</section>
<!-- /404 Not Found -->

@endsection
