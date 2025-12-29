@extends('frontend/layout/master')

@section('style')
<style>
    .info-card {
        background-color: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        height: 100%;
    }
    
    .info-card i {
        font-size: 24px;
        color: #007bff;
        margin-bottom: 10px;
    }
    
    .form-section {
        padding: 40px 0;
    }
    
    .contact-form input,
    .contact-form textarea {
        background-color: #fff;
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px 15px;
        margin-bottom: 15px;
    }
    
    .contact-form button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
    }
    
    .contact-form button i {
        margin-left: 5px;
    }
    
    iframe {
        width: 100%;
        height: 100%;
        border: 0;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
    
    .map-container {
        min-height: 300px;
    }
</style>
@endsection

@section('main-content')

<!-- Breakcrumbs -->
<div class="tf-sp-3 pb-0">
    <div class="container">
        <ul class="breakcrumbs">
            <li><a href="{{ route('website') }}" class="body-small link">Home</a></li>
            <li class="d-flex align-items-center">
                <i class="icon icon-arrow-right"></i>
            </li>
            <li><span class="body-small">Contact</span></li>
        </ul>
    </div>
</div>
<!-- /Breakcrumbs -->

<!-- Contact -->
<!-- <section class="tf-sp-2">
    <div class="container">
        <div class="wg-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d9339.281589765826!2d72.857249!3d19.405825!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7a8d4da6ebfc5%3A0x4250f866a9e8872c!2sSRB%20COMPUTERS!5e1!3m2!1sen!2sin!4v1751289080206!5m2!1sen!2sin"
                height="585" style="border-radius:8px; width: 100%;" allowfullscreen=""
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
            
            <div class="bottom">
                <div class="contact-wrap">
                    <div class="box-title">
                        <h5 class="fw-semibold">Get A Quote</h5>
                        <p class="body-text-3">
                            Fill up the form and our Team will get back to you within 24 hours.
                        </p>
                    </div>
                    <form class="form-contact def">
                        <fieldset>
                            <label>Name</label>
                            <input type="text" required>
                        </fieldset>
                        <fieldset>
                            <label>Subject</label>
                            <input type="text" required>
                        </fieldset>
                        <fieldset class="d-flex flex-column">
                            <label>Your message</label>
                            <textarea style="height: 170px;" required></textarea>
                        </fieldset>
                        <div class="box-btn-submit">
                            <button type="submit" class="tf-btn text-white w-100">
                                Send message
                            </button>
                        </div>
                    </form>
                </div>
                <div class="contact-info mt-2">
                    <h5 class="fw-semibold">Contact Infomation</h5>
                    <ul class="info-list">
                        <li>
                            <span class="icon"><i class="icon-location"></i></span>
                            <a href="https://www.google.com/maps?q=8500%20Lorem%20StreetChicago" class="link"
                                target="_blank">

                                Gala No.5, Sheetal Swapna Industrial Estate, Sativali Road, Bhoidapada, Vasai East, Palghar - 401208.
                            </a>
                        </li>
                        <li>
                            <span class="icon"><i class="icon-phone"></i></span>
                            <a href="tel:1234567" class="product-title fw-semibold link"><span>+91 9607 78 8836</span></a>
                        </li>
                        <li>
                            <span class="icon"><i class="icon-direction"></i></span>
                            <a href="mailto:info@crackteck.com" class="link"><span>info@crackteck.com</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section> -->

<!-- Info Cards -->

<!-- Contact Form & Map -->
<div class="container form-section">
    <div class="row g-4 px-3">
        <!-- Form Column -->
        <div class="col-md-6">
            <h4 class="mb-3">Send Us A Message</h4>
            <p class="mb-4">Fill up the form and our Team will get back to you within 24 hours.</p>
            <form class="contact-form" action="{{ route('contact.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-md-6">
                        @include('components.form.input', [
                        'label' => 'First Name',
                        'name' => 'first_name',
                        'type' => 'text',
                        'placeholder' => 'Enter First Name',
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.form.input', [
                        'label' => 'Last Name',
                        'name' => 'last_name',
                        'type' => 'text',
                        'placeholder' => 'Enter Last Name',
                        ])
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        @include('components.form.input', [
                        'label' => 'Email',
                        'name' => 'email',
                        'type' => 'email',
                        'placeholder' => 'Enter Email',
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.form.input', [
                        'label' => 'Phone',
                        'name' => 'phone',
                        'type' => 'text',
                        'placeholder' => 'Enter Phone',
                        ])
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @include('components.form.input', [
                        'label' => 'Message',
                        'name' => 'message',
                        'type' => 'textarea',
                        'placeholder' => 'Enter Message',
                        ])
                    </div>
                </div>
                <button type="submit">SEND MESSAGE <i class="fas fa-arrow-right"></i></button>
            </form>
        </div>

        <!-- Map Column -->
        <div class="col-md-6 map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d9339.281589765826!2d72.857249!3d19.405825!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7a8d4da6ebfc5%3A0x4250f866a9e8872c!2sSRB%20COMPUTERS!5e1!3m2!1sen!2sin!4v1751289080206!5m2!1sen!2sin"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-3 col-sm-6">
            <div class="info-card">
                <i class="fas fa-map-marker-alt"></i>
                <h6 class="mt-2">Location</h6>
                <p class="mb-0">
                    Gala No.5, Sheetal Swapna Industrial Estate, Sativali Road, Bhoidapada, Vasai East, Palghar - 401208.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-card">
                <i class="fas fa-phone"></i>
                <h6 class="mt-2">Contact</h6>
                <p class="mb-0">+91 9607 78 8836<br>+91 9607 78 8836</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-card">
                <i class="fas fa-envelope"></i>
                <h6 class="mt-2">Email</h6>
                <p class="mb-0">
                    info@crackteck.com
                    <br>email@example.com
                </p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-card">
                <i class="fas fa-clock"></i>
                <h6 class="mt-2">Visit Between</h6>
                <p class="mb-0">Mon - Sat: 8.00 - 5.00<br>Sunday: Closed</p>
            </div>
        </div>
    </div>
</div>
<!-- /Contact -->

@endsection