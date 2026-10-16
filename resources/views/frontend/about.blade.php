@extends('frontend/layout/master')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/about.css') }}?v={{ filemtime(public_path('frontend-assets/css/about.css')) }}">
@endsection

@section('main-content')
    <div class="srb-about">
        <div class="container pt-4">
            <nav aria-label="Breadcrumb">
                <ol class="srb-about-breadcrumb">
                    <li><a href="{{ route('website') }}">Home</a></li>
                    <li aria-hidden="true">/</li>
                    <li aria-current="page">About SRB Computers</li>
                </ol>
            </nav>
        </div>

        <section class="srb-about-section srb-about-hero" aria-labelledby="about-title">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <p class="srb-about-eyebrow">Your technology. Our responsibility.</p>
                        <h1 id="about-title">We Are <span>SRB Computers</span></h1>
                        <p class="srb-about-lead">We’re not here to just sell IT products and services. We’re here to solve every tech challenge before it disrupts your business.</p>
                        <p>From the smallest cable to the most complex enterprise network, we make sure your systems run smoother, faster, and smarter.</p>
                        <div class="srb-about-actions">
                            <a href="{{ route('shop') }}" class="tf-btn text-white">Shop IT Products <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                            <a href="{{ route('contact') }}" class="srb-about-link">Talk to Our Team <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="srb-about-image">
                            <img src="{{ asset('frontend-assets/images/banner/about.jpg') }}"
                                alt="Professionals collaborating around a laptop" width="1080" height="719" fetchpriority="high">
                            <div class="srb-about-image-note"><i class="fa-solid fa-bolt" aria-hidden="true"></i><span>If it’s tech,<br><strong>it’s handled.</strong></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="srb-about-section srb-about-soft" aria-labelledby="who-title">
            <div class="container">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-4">
                        <p class="srb-about-eyebrow">Who We Are</p>
                        <h2 id="who-title">IT support that gets your business.</h2>
                    </div>
                    <div class="col-lg-8 srb-about-copy">
                        <p>At SRB Computers, we’re not your average IT company. We’re the crew you call when you need tech that just works—fast, smart, and without the endless jargon.</p>
                        <p>From solving last-minute IT emergencies to designing future-proof systems, we live for challenges that others avoid.</p>
                        <h3>Why We Exist</h3>
                        <p>Technology moves fast. Downtime is costly. We believe in giving businesses speed, reliability, and zero excuses when it comes to IT. That’s why SRB Computers is built around one simple principle: <strong>If it’s tech, it’s handled.</strong></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="srb-about-section" aria-labelledby="ways-title">
            <div class="container">
                <div class="srb-about-heading">
                    <p class="srb-about-eyebrow">Products &amp; Support</p>
                    <h2 id="ways-title">Two Ways to Work with Us</h2>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <article class="srb-about-card srb-about-channel">
                            <span class="srb-about-icon"><i class="fa-solid fa-cart-shopping" aria-hidden="true"></i></span>
                            <h3>E-Commerce Website</h3>
                            <p>Shop IT products online and get them delivered fast. Find the computers, accessories, and essentials that keep your business moving.</p>
                            <a href="{{ route('shop') }}" class="srb-about-link">Explore IT Products <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                        </article>
                    </div>
                    <div class="col-md-6">
                        <article class="srb-about-card srb-about-channel">
                            <span class="srb-about-icon"><i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i></span>
                            <h3>Service Mobile App</h3>
                            <p>Book repairs, installations, or urgent IT support in a few taps. Get help with the tech challenges that can’t wait.</p>
                            <a href="{{ route('contact') }}" class="srb-about-link">Ask Us About the App <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section class="srb-about-section srb-about-soft" aria-labelledby="services-title">
            <div class="container">
                <div class="srb-about-heading">
                    <p class="srb-about-eyebrow">Built Around Your Needs</p>
                    <h2 id="services-title">What We Do Best</h2>
                </div>
                <div class="row g-4">
                    @foreach ([
                        ['icon' => 'fa-bolt', 'title' => 'Same-Day IT Support & Delivery', 'copy' => 'Because “tomorrow” is too late in the tech world. Get the support and products you need to keep your business moving.'],
                        ['icon' => 'fa-network-wired', 'title' => 'End-to-End Solutions', 'copy' => 'Computers, laptops, networking, CCTV, biometrics, access control, servers, storage, and printers. If it connects, computes, or secures, we’ve got it covered.'],
                        ['icon' => 'fa-computer', 'title' => 'Custom Builds', 'copy' => 'From high-performance PCs to enterprise-grade setups, built for your exact needs. We also handle computer and laptop sales, upgrades, and repairs.'],
                        ['icon' => 'fa-screwdriver-wrench', 'title' => 'Proactive Maintenance', 'copy' => 'Annual Maintenance Contracts (AMC) that keep your IT running at peak performance—and actually give you peace of mind.'],
                    ] as $service)
                        <div class="col-md-6 col-xl-3">
                            <article class="srb-about-card">
                                <span class="srb-about-icon"><i class="fa-solid {{ $service['icon'] }}" aria-hidden="true"></i></span>
                                <h3>{{ $service['title'] }}</h3>
                                <p>{{ $service['copy'] }}</p>
                            </article>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('amc') }}" class="srb-about-link mt-4 d-inline-flex">Explore AMC Support <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </section>

        <section class="srb-about-section" aria-labelledby="work-title">
            <div class="container">
                <div class="srb-about-heading">
                    <p class="srb-about-eyebrow">How We Work</p>
                    <h2 id="work-title">IT should feel effortless.</h2>
                    <p>We keep things simple, so you can focus on your business.</p>
                </div>
                <div class="row g-4">
                    @foreach ([
                        ['title' => 'Speed over excuses', 'copy' => 'If it can be fixed today, we won’t make you wait till tomorrow.'],
                        ['title' => 'Clarity over confusion', 'copy' => 'No tech-speak that leaves you lost. We keep it simple.'],
                        ['title' => 'Solutions over sales', 'copy' => 'We recommend what’s best for you, not just what’s on our shelf.'],
                    ] as $principle)
                        <div class="col-md-4">
                            <article class="srb-about-principle">
                                <span class="srb-about-number">0{{ $loop->iteration }}</span>
                                <h3>{{ $principle['title'] }}</h3>
                                <p>{{ $principle['copy'] }}</p>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="srb-about-section srb-about-promise" aria-labelledby="promise-title">
            <div class="container">
                <div class="srb-about-heading">
                    <p class="srb-about-eyebrow">What You Can Count On</p>
                    <h2 id="promise-title">The SRB Computers Promise</h2>
                </div>
                <div class="row g-4">
                    @foreach (['Fast Response', 'Expert Engineers', 'Transparent Pricing', 'Tech That Works—Always'] as $promise)
                        <div class="col-sm-6 col-lg-3">
                            <div class="srb-about-promise-item"><i class="fa-solid fa-circle-check" aria-hidden="true"></i><h3>{{ $promise }}</h3></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="srb-about-section" aria-labelledby="journey-title">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-6 srb-about-copy">
                        <p class="srb-about-eyebrow">Our Journey</p>
                        <h2 id="journey-title">A small tech team. A bigger ambition.</h2>
                        <p>SRB Computers was born from one simple frustration: good IT support was either too slow, too complicated, or too expensive. So, we decided to flip the script.</p>
                        <p>What started as a small tech team with a big attitude has grown into a powerhouse delivering same-day solutions, custom builds, and reliable support to businesses across industries.</p>
                    </div>
                    <div class="col-lg-6">
                        <div class="srb-about-story srb-about-copy">
                            <p class="srb-about-eyebrow">Why Businesses Choose Us</p>
                            <h3>Partners in your everyday uptime.</h3>
                            <p>We’re not just tech providers—we’re partners. We slot into your workflow like we’ve always been there, keeping your systems running while you focus on your business.</p>
                            <h3>Our Clients</h3>
                            <p>We work with businesses that demand uptime: manufacturing plants, corporate offices, schools, housing societies, healthcare, and anyone who can’t afford “system down” moments.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="srb-about-section srb-about-soft" aria-labelledby="energy-title">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-4">
                        <p class="srb-about-eyebrow">Our Vibe</p>
                        <h2 id="energy-title">The SRB Computers Energy</h2>
                    </div>
                    <div class="col-lg-8 srb-about-copy">
                        <p>No endless jargon. No “we’ll get back to you next week.” We’re fast, direct, and obsessed with solving problems before they even become problems.</p>
                        <p>Fast-moving. Problem-solving. Coffee-fuelled. That’s us. We thrive in high-pressure situations and keep things friendly along the way.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="srb-about-section" aria-labelledby="talk-title">
            <div class="container">
                <div class="srb-about-cta">
                    <div>
                        <p class="srb-about-eyebrow">Let’s Get Your IT Moving</p>
                        <h2 id="talk-title">Ready to Talk?</h2>
                        <p>Whether you need urgent support, a complete IT overhaul, or just want to chat about how to make your setup faster, safer, and smarter, we’re here.</p>
                        <p>No waiting lines. No complicated forms. Just a call, and we’re on it.</p>
                    </div>
                    <div class="srb-about-cta-actions">
                        <a href="tel:+919607788836" class="tf-btn text-white"><i class="fa-solid fa-phone" aria-hidden="true"></i> Call Our Team</a>
                        <a href="{{ route('contact') }}" class="srb-about-link">Contact SRB Computers <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
