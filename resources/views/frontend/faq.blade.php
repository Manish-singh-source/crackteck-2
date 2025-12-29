@extends('frontend/layout/master')

@section('main-content')

<!-- Breakcrumbs -->
<div class="tf-sp-3">
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
                <span class="body-small">FAQs</span>
            </li>
        </ul>
    </div>
</div>
<!-- /Breakcrumbs -->

<!-- Search Faq -->
<section class="s-search-faq">
    <div class="wrap">
        <div class="container">
            <div class="content">
                <div class="box-title text-center">
                    <h2 class="title fw-semibold text-white"> Frequently asked questions</h2>
                    <p class="text-white">Please check this FAQ first before contacting us.</p>
                </div>
                <form class="form-search-3">
                    <fieldset>
                        <input type="text" placeholder="Enter your question or keyword" required>
                    </fieldset>
                    <button type="submit" class="button-submit">
                        <i class="icon-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="parallax-image">
        <img src="{{ asset('frontend-assets/images/section/parallax-2.jpg') }}" data-src="{{ asset('frontend-assets/images/section/parallax-2.jpg') }}" alt=""
            class="lazyload effect-paralax">
    </div>
</section>
<!-- /Search Faq -->

<!-- Faq -->
<section class="tf-sp-2">
    <div class="container">
        <div class="s-faq flat-animate-tab">
            <div class="flat-title-tab-faq">
                <div class="tf-title">
                    <h5 class="fw-bold">
                        Hot Topics
                    </h5>
                </div>
                <ul class="menu-tab-line" role="tablist">
                    <li class="nav-tab-item" role="presentation">
                        <a href="#my-account" class="tab-link link active" data-bs-toggle="tab">My
                            account</a>
                    </li>
                    <li class="nav-tab-item" role="presentation">
                        <a href="#ordering" class="tab-link link" data-bs-toggle="tab">Ordering</a>
                    </li>
                    <li class="nav-tab-item" role="presentation">
                        <a href="#tab1" class="tab-link link" data-bs-toggle="tab">Pellentesque
                            nec erat sed ex</a>
                    </li>
                    <li class="nav-tab-item" role="presentation">
                        <a href="#tab2" class="tab-link link" data-bs-toggle="tab">Nulla
                            facilisi</a>
                    </li>
                    <li class="nav-tab-item" role="presentation">
                        <a href="#tab3" class="tab-link link" data-bs-toggle="tab">Sed
                            venenatis ullamcorper odio non tincidunt</a>
                    </li>
                    <li class="nav-tab-item" role="presentation">
                        <a href="#tab4" class="tab-link link" data-bs-toggle="tab">Morbi
                            fringilla diam turpis</a>
                    </li>
                    <li class="nav-tab-item" role="presentation">
                        <a href="#tab5" class="tab-link link" data-bs-toggle="tab">Non
                            fermentum metus tempor</a>
                    </li>
                    <li class="nav-tab-item" role="presentation">
                        <a href="#tab6" class="tab-link link" data-bs-toggle="tab">Pellentesque
                            erat odio</a>
                    </li>
                    <li class="nav-tab-item" role="presentation">
                        <a href="#tab7" class="tab-link link" data-bs-toggle="tab">Et
                            blandit mauris</a>
                    </li>
                </ul>
            </div>
            <div class="wrap">
                <div class="tab-content">
                    <div class="tab-pane active show" id="my-account" role="tabpanel">
                        <div class="faq-item">
                            <h5 class="name-faq fw-bold">
                                My Account
                            </h5>
                            <div class="faq-wrap" id="accordionMyAcc">
                                <div class="widget-accordion " id="headingOne">
                                    <div class="accordion-title" data-bs-toggle="collapse"
                                        data-bs-target="#collapseMyAcc-One" aria-expanded="true"
                                        aria-controls="collapseMyAcc-One" role="button">
                                        <span class="title-sidebar">1. What canIdo ifIforgot my
                                            password?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseMyAcc-One" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionMyAcc">
                                        <div class="accordion-body widget-desc">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingTwo">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseMyAcc-Two" aria-expanded="false"
                                        aria-controls="collapseMyAcc-Two" role="button">
                                        <span class="title-sidebar">2. Why cannotIreceive the SMS
                                            verification
                                            code?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseMyAcc-Two" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionMyAcc">
                                        <div class="accordion-body widget-material">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingThree1">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseMyAcc-Three" aria-expanded="false"
                                        aria-controls="collapseMyAcc-Three" role="button">
                                        <span class="title-sidebar">3. When willIreceive my order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseMyAcc-Three" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree1" data-bs-parent="#accordionMyAcc">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFour1">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseMyAcc-Four" aria-expanded="false"
                                        aria-controls="collapseMyAcc-Four" role="button">
                                        <span class="title-sidebar">4. How canIregister an account</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseMyAcc-Four" class="accordion-collapse collapse"
                                        aria-labelledby="headingFour1" data-bs-parent="#accordionMyAcc">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFive">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseMyAcc-Five" aria-expanded="false"
                                        aria-controls="collapseMyAcc-Five" role="button">
                                        <span class="title-sidebar">5. What can I do if my account was
                                            deactivated?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseMyAcc-Five" class="accordion-collapse collapse"
                                        aria-labelledby="headingFive" data-bs-parent="#accordionMyAcc">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSix">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseMyAcc-Six" aria-expanded="false"
                                        aria-controls="collapseMyAcc-Six" role="button">
                                        <span class="title-sidebar">6. How do I add the inspection service
                                            to my
                                            Trade Assurance order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseMyAcc-Six" class="accordion-collapse collapse"
                                        aria-labelledby="headingSix" data-bs-parent="#accordionMyAcc">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSeven">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseMyAcc-Seven" aria-expanded="false"
                                        aria-controls="collapseMyAcc-Seven" role="button">
                                        <span class="title-sidebar">7. How doIdelete verification phone
                                            number?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseMyAcc-Seven" class="accordion-collapse collapse"
                                        aria-labelledby="headingSeven" data-bs-parent="#accordionMyAcc">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingEight">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseMyAcc-Eight" aria-expanded="false"
                                        aria-controls="collapseMyAcc-Eight" role="button">
                                        <span class="title-sidebar">8. How doIleave feedback for my
                                            order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseMyAcc-Eight" class="accordion-collapse collapse"
                                        aria-labelledby="headingEight" data-bs-parent="#accordionMyAcc">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="ordering" role="tabpanel">
                        <div class="faq-item">
                            <h5 class="name-faq fw-bold">
                                Ordering
                            </h5>
                            <div class="faq-wrap" id="accordionOrdering">
                                <div class="widget-accordion " id="headingOne1">
                                    <div class="accordion-title" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne" role="button">
                                        <span class="title-sidebar">1. What canIdo ifIforgot my
                                            password?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne1" data-bs-parent="#accordionOrdering">
                                        <div class="accordion-body widget-desc">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingTwo1">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo" role="button">
                                        <span class="title-sidebar">2. Why cannotIreceive the SMS
                                            verification
                                            code?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo1" data-bs-parent="#accordionOrdering">
                                        <div class="accordion-body widget-material">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingThree2">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree" role="button">
                                        <span class="title-sidebar">3. When willIreceive my order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree2" data-bs-parent="#accordionOrdering">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFour2">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour" role="button">
                                        <span class="title-sidebar">4. How canIregister an account</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseFour" class="accordion-collapse collapse"
                                        aria-labelledby="headingFour2" data-bs-parent="#accordionOrdering">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFive2">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFive" aria-expanded="false"
                                        aria-controls="collapseFive" role="button">
                                        <span class="title-sidebar">5. What can I do if my account was
                                            deactivated?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseFive" class="accordion-collapse collapse"
                                        aria-labelledby="headingFive2" data-bs-parent="#accordionOrdering">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSix2">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSix" aria-expanded="false"
                                        aria-controls="collapseSix" role="button">
                                        <span class="title-sidebar">6. How do I add the inspection service
                                            to my
                                            Trade Assurance order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseSix" class="accordion-collapse collapse"
                                        aria-labelledby="headingSix2" data-bs-parent="#accordionOrdering">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSeven2">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSeven" aria-expanded="false"
                                        aria-controls="collapseSeven" role="button">
                                        <span class="title-sidebar">7. How doIdelete verification phone
                                            number?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseSeven" class="accordion-collapse collapse"
                                        aria-labelledby="headingSeven2" data-bs-parent="#accordionOrdering">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingEight2">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseEight" aria-expanded="false"
                                        aria-controls="collapseEight" role="button">
                                        <span class="title-sidebar">8. How doIleave feedback for my
                                            order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseEight" class="accordion-collapse collapse"
                                        aria-labelledby="headingEight2" data-bs-parent="#accordionOrdering">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab1" role="tabpanel">
                        <div class="faq-item">
                            <h5 class="name-faq fw-bold">
                                Pellentesque nec erat sed ex
                            </h5>
                            <div class="faq-wrap" id="accordionTab1">
                                <div class="widget-accordion " id="headingOne2">
                                    <div class="accordion-title" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab1-One" aria-expanded="true"
                                        aria-controls="collapseTab1-One" role="button">
                                        <span class="title-sidebar">1. What canIdo ifIforgot my
                                            password?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab1-One" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne2" data-bs-parent="#accordionTab1">
                                        <div class="accordion-body widget-desc">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingTwo2">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab1-Two" aria-expanded="false"
                                        aria-controls="collapseTab1-Two" role="button">
                                        <span class="title-sidebar">2. Why cannotIreceive the SMS
                                            verification
                                            code?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab1-Two" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo2" data-bs-parent="#accordionTab1">
                                        <div class="accordion-body widget-material">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingThree3">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab1-Three" aria-expanded="false"
                                        aria-controls="collapseTab1-Three" role="button">
                                        <span class="title-sidebar">3. When willIreceive my order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab1-Three" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree3" data-bs-parent="#accordionTab1">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFour3">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab1-Four" aria-expanded="false"
                                        aria-controls="collapseTab1-Four" role="button">
                                        <span class="title-sidebar">4. How canIregister an account</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab1-Four" class="accordion-collapse collapse"
                                        aria-labelledby="headingFour3" data-bs-parent="#accordionTab1">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFive3">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab1-Five" aria-expanded="false"
                                        aria-controls="collapseTab1-Five" role="button">
                                        <span class="title-sidebar">5. What can I do if my account was
                                            deactivated?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab1-Five" class="accordion-collapse collapse"
                                        aria-labelledby="headingFive3" data-bs-parent="#accordionTab1">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSix3">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab1-Six" aria-expanded="false"
                                        aria-controls="collapseTab1-Six" role="button">
                                        <span class="title-sidebar">6. How do I add the inspection service
                                            to my
                                            Trade Assurance order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab1-Six" class="accordion-collapse collapse"
                                        aria-labelledby="headingSix3" data-bs-parent="#accordionTab1">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSeven3">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab1-Seven" aria-expanded="false"
                                        aria-controls="collapseTab1-Seven" role="button">
                                        <span class="title-sidebar">7. How doIdelete verification phone
                                            number?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab1-Seven" class="accordion-collapse collapse"
                                        aria-labelledby="headingSeven3" data-bs-parent="#accordionTab1">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingEight3">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab1-Eight" aria-expanded="false"
                                        aria-controls="collapseTab1-Eight" role="button">
                                        <span class="title-sidebar">8. How doIleave feedback for my
                                            order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab1-Eight" class="accordion-collapse collapse"
                                        aria-labelledby="headingEight3" data-bs-parent="#accordionTab1">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2" role="tabpanel">
                        <div class="faq-item">
                            <h5 class="name-faq fw-bold">
                                Nulla facilisi
                            </h5>
                            <div class="faq-wrap" id="accordionTab2">
                                <div class="widget-accordion " id="headingOne4">
                                    <div class="accordion-title" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab2-One" aria-expanded="true"
                                        aria-controls="collapseTab2-One" role="button">
                                        <span class="title-sidebar">1. What canIdo ifIforgot my
                                            password?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab2-One" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne4" data-bs-parent="#accordionTab2">
                                        <div class="accordion-body widget-desc">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingTwo3">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab2-Two" aria-expanded="false"
                                        aria-controls="collapseTab2-Two" role="button">
                                        <span class="title-sidebar">2. Why cannotIreceive the SMS
                                            verification
                                            code?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab2-Two" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo3" data-bs-parent="#accordionTab2">
                                        <div class="accordion-body widget-material">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingThree4">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab2-Three" aria-expanded="false"
                                        aria-controls="collapseTab2-Three" role="button">
                                        <span class="title-sidebar">3. When willIreceive my order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab2-Three" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree4" data-bs-parent="#accordionTab2">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFour4">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab2-Four" aria-expanded="false"
                                        aria-controls="collapseTab2-Four" role="button">
                                        <span class="title-sidebar">4. How canIregister an account</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab2-Four" class="accordion-collapse collapse"
                                        aria-labelledby="headingFour4" data-bs-parent="#accordionTab2">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFive4">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab2-Five" aria-expanded="false"
                                        aria-controls="collapseTab2-Five" role="button">
                                        <span class="title-sidebar">5. What can I do if my account was
                                            deactivated?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab2-Five" class="accordion-collapse collapse"
                                        aria-labelledby="headingFive4" data-bs-parent="#accordionTab2">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSix4">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab2-Six" aria-expanded="false"
                                        aria-controls="collapseTab2-Six" role="button">
                                        <span class="title-sidebar">6. How do I add the inspection service
                                            to my
                                            Trade Assurance order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab2-Six" class="accordion-collapse collapse"
                                        aria-labelledby="headingSix4" data-bs-parent="#accordionTab2">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSeven4">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab2-Seven" aria-expanded="false"
                                        aria-controls="collapseTab2-Seven" role="button">
                                        <span class="title-sidebar">7. How doIdelete verification phone
                                            number?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab2-Seven" class="accordion-collapse collapse"
                                        aria-labelledby="headingSeven4" data-bs-parent="#accordionTab2">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingEight4">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab2-Eight" aria-expanded="false"
                                        aria-controls="collapseTab2-Eight" role="button">
                                        <span class="title-sidebar">8. How doIleave feedback for my
                                            order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab2-Eight" class="accordion-collapse collapse"
                                        aria-labelledby="headingEight4" data-bs-parent="#accordionTab2">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3" role="tabpanel">
                        <div class="faq-item">
                            <h5 class="name-faq fw-bold">
                                Sed venenatis ullamcorper odio non tincidunt
                            </h5>
                            <div class="faq-wrap" id="accordionTab3">
                                <div class="widget-accordion " id="headingOne5">
                                    <div class="accordion-title" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab3-One" aria-expanded="true"
                                        aria-controls="collapseTab3-One" role="button">
                                        <span class="title-sidebar">1. What canIdo ifIforgot my
                                            password?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab3-One" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne5" data-bs-parent="#accordionTab3">
                                        <div class="accordion-body widget-desc">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingTwo4">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab3-Two" aria-expanded="false"
                                        aria-controls="collapseTab3-Two" role="button">
                                        <span class="title-sidebar">2. Why cannotIreceive the SMS
                                            verification
                                            code?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab3-Two" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo4" data-bs-parent="#accordionTab3">
                                        <div class="accordion-body widget-material">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingThree5">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab3-Three" aria-expanded="false"
                                        aria-controls="collapseTab3-Three" role="button">
                                        <span class="title-sidebar">3. When willIreceive my order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab3-Three" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree5" data-bs-parent="#accordionTab3">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFour5">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab3-Four" aria-expanded="false"
                                        aria-controls="collapseTab3-Four" role="button">
                                        <span class="title-sidebar">4. How canIregister an account</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab3-Four" class="accordion-collapse collapse"
                                        aria-labelledby="headingFour5" data-bs-parent="#accordionTab3">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFive5">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab3-Five" aria-expanded="false"
                                        aria-controls="collapseTab3-Five" role="button">
                                        <span class="title-sidebar">5. What can I do if my account was
                                            deactivated?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab3-Five" class="accordion-collapse collapse"
                                        aria-labelledby="headingFive5" data-bs-parent="#accordionTab3">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSix5">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab3-Six" aria-expanded="false"
                                        aria-controls="collapseTab3-Six" role="button">
                                        <span class="title-sidebar">6. How do I add the inspection service
                                            to my
                                            Trade Assurance order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab3-Six" class="accordion-collapse collapse"
                                        aria-labelledby="headingSix5" data-bs-parent="#accordionTab3">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSeven5">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab3-Seven" aria-expanded="false"
                                        aria-controls="collapseTab3-Seven" role="button">
                                        <span class="title-sidebar">7. How doIdelete verification phone
                                            number?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab3-Seven" class="accordion-collapse collapse"
                                        aria-labelledby="headingSeven5" data-bs-parent="#accordionTab3">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingEight5">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab3-Eight" aria-expanded="false"
                                        aria-controls="collapseTab3-Eight" role="button">
                                        <span class="title-sidebar">8. How doIleave feedback for my
                                            order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab3-Eight" class="accordion-collapse collapse"
                                        aria-labelledby="headingEight5" data-bs-parent="#accordionTab3">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab4" role="tabpanel">
                        <div class="faq-item">
                            <h5 class="name-faq fw-bold">
                                Morbi fringilla diam turpis
                            </h5>
                            <div class="faq-wrap" id="accordionTab4">
                                <div class="widget-accordion " id="headingOne6">
                                    <div class="accordion-title" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab4-One" aria-expanded="true"
                                        aria-controls="collapseTab4-One" role="button">
                                        <span class="title-sidebar">1. What canIdo ifIforgot my
                                            password?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab4-One" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne6" data-bs-parent="#accordionTab4">
                                        <div class="accordion-body widget-desc">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingTwo5">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab4-Two" aria-expanded="false"
                                        aria-controls="collapseTab4-Two" role="button">
                                        <span class="title-sidebar">2. Why cannotIreceive the SMS
                                            verification
                                            code?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab4-Two" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo5" data-bs-parent="#accordionTab4">
                                        <div class="accordion-body widget-material">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingThree6">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab4-Three" aria-expanded="false"
                                        aria-controls="collapseTab4-Three" role="button">
                                        <span class="title-sidebar">3. When willIreceive my order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab4-Three" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree6" data-bs-parent="#accordionTab4">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFour6">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab4-Four" aria-expanded="false"
                                        aria-controls="collapseTab4-Four" role="button">
                                        <span class="title-sidebar">4. How canIregister an account</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab4-Four" class="accordion-collapse collapse"
                                        aria-labelledby="headingFour6" data-bs-parent="#accordionTab4">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFive6">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab4-Five" aria-expanded="false"
                                        aria-controls="collapseTab4-Five" role="button">
                                        <span class="title-sidebar">5. What can I do if my account was
                                            deactivated?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab4-Five" class="accordion-collapse collapse"
                                        aria-labelledby="headingFive6" data-bs-parent="#accordionTab4">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSix6">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab4-Six" aria-expanded="false"
                                        aria-controls="collapseTab4-Six" role="button">
                                        <span class="title-sidebar">6. How do I add the inspection service
                                            to my
                                            Trade Assurance order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab4-Six" class="accordion-collapse collapse"
                                        aria-labelledby="headingSix6" data-bs-parent="#accordionTab4">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSeven6">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab4-Seven" aria-expanded="false"
                                        aria-controls="collapseTab4-Seven" role="button">
                                        <span class="title-sidebar">7. How doIdelete verification phone
                                            number?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab4-Seven" class="accordion-collapse collapse"
                                        aria-labelledby="headingSeven6" data-bs-parent="#accordionTab4">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingEight6">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab4-Eight" aria-expanded="false"
                                        aria-controls="collapseTab4-Eight" role="button">
                                        <span class="title-sidebar">8. How doIleave feedback for my
                                            order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab4-Eight" class="accordion-collapse collapse"
                                        aria-labelledby="headingEight6" data-bs-parent="#accordionTab4">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab5" role="tabpanel">
                        <div class="faq-item">
                            <h5 class="name-faq fw-bold">
                                Non fermentum metus tempor
                            </h5>
                            <div class="faq-wrap" id="accordionTab5">
                                <div class="widget-accordion " id="headingOne7">
                                    <div class="accordion-title" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab5-One" aria-expanded="true"
                                        aria-controls="collapseTab5-One" role="button">
                                        <span class="title-sidebar">1. What canIdo ifIforgot my
                                            password?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab5-One" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne7" data-bs-parent="#accordionTab5">
                                        <div class="accordion-body widget-desc">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingTwo6">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab5-Two" aria-expanded="false"
                                        aria-controls="collapseTab5-Two" role="button">
                                        <span class="title-sidebar">2. Why cannotIreceive the SMS
                                            verification
                                            code?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab5-Two" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo6" data-bs-parent="#accordionTab5">
                                        <div class="accordion-body widget-material">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingThree7">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab5-Three" aria-expanded="false"
                                        aria-controls="collapseTab5-Three" role="button">
                                        <span class="title-sidebar">3. When willIreceive my order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab5-Three" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree7" data-bs-parent="#accordionTab5">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFour7">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab5-Four" aria-expanded="false"
                                        aria-controls="collapseTab5-Four" role="button">
                                        <span class="title-sidebar">4. How canIregister an account</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab5-Four" class="accordion-collapse collapse"
                                        aria-labelledby="headingFour7" data-bs-parent="#accordionTab5">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFive7">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab5-Five" aria-expanded="false"
                                        aria-controls="collapseTab5-Five" role="button">
                                        <span class="title-sidebar">5. What can I do if my account was
                                            deactivated?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab5-Five" class="accordion-collapse collapse"
                                        aria-labelledby="headingFive7" data-bs-parent="#accordionTab5">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSix7">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab5-Six" aria-expanded="false"
                                        aria-controls="collapseTab5-Six" role="button">
                                        <span class="title-sidebar">6. How do I add the inspection service
                                            to my
                                            Trade Assurance order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab5-Six" class="accordion-collapse collapse"
                                        aria-labelledby="headingSix7" data-bs-parent="#accordionTab5">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSeven7">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab5-Seven" aria-expanded="false"
                                        aria-controls="collapseTab5-Seven" role="button">
                                        <span class="title-sidebar">7. How doIdelete verification phone
                                            number?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab5-Seven" class="accordion-collapse collapse"
                                        aria-labelledby="headingSeven7" data-bs-parent="#accordionTab5">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingEight7">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab5-Eight" aria-expanded="false"
                                        aria-controls="collapseTab5-Eight" role="button">
                                        <span class="title-sidebar">8. How doIleave feedback for my
                                            order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab5-Eight" class="accordion-collapse collapse"
                                        aria-labelledby="headingEight7" data-bs-parent="#accordionTab5">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab6" role="tabpanel">
                        <div class="faq-item">
                            <h5 class="name-faq fw-bold">
                                Pellentesque erat odio
                            </h5>
                            <div class="faq-wrap" id="accordionTab6">
                                <div class="widget-accordion " id="headingOne8">
                                    <div class="accordion-title" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab6-One" aria-expanded="true"
                                        aria-controls="collapseTab6-One" role="button">
                                        <span class="title-sidebar">1. What canIdo ifIforgot my
                                            password?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab6-One" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne8" data-bs-parent="#accordionTab6">
                                        <div class="accordion-body widget-desc">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingTwo7">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab6-Two" aria-expanded="false"
                                        aria-controls="collapseTab6-Two" role="button">
                                        <span class="title-sidebar">2. Why cannotIreceive the SMS
                                            verification
                                            code?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab6-Two" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo7" data-bs-parent="#accordionTab6">
                                        <div class="accordion-body widget-material">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingThree8">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab6-Three" aria-expanded="false"
                                        aria-controls="collapseTab6-Three" role="button">
                                        <span class="title-sidebar">3. When willIreceive my order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab6-Three" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree8" data-bs-parent="#accordionTab6">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFour8">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab6-Four" aria-expanded="false"
                                        aria-controls="collapseTab6-Four" role="button">
                                        <span class="title-sidebar">4. How canIregister an account</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab6-Four" class="accordion-collapse collapse"
                                        aria-labelledby="headingFour8" data-bs-parent="#accordionTab6">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFive8">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab6-Five" aria-expanded="false"
                                        aria-controls="collapseTab6-Five" role="button">
                                        <span class="title-sidebar">5. What can I do if my account was
                                            deactivated?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab6-Five" class="accordion-collapse collapse"
                                        aria-labelledby="headingFive8" data-bs-parent="#accordionTab6">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion" id="headingSix8">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab6-Six" aria-expanded="false"
                                        aria-controls="collapseTab6-Six" role="button">
                                        <span class="title-sidebar">6. How do I add the inspection service
                                            to my
                                            Trade Assurance order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab6-Six" class="accordion-collapse collapse"
                                        aria-labelledby="headingSix8" data-bs-parent="#accordionTab6">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSeven8">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab6-Seven" aria-expanded="false"
                                        aria-controls="collapseTab6-Seven" role="button">
                                        <span class="title-sidebar">7. How doIdelete verification phone
                                            number?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab6-Seven" class="accordion-collapse collapse"
                                        aria-labelledby="headingSeven8" data-bs-parent="#accordionTab6">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingEight8">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab6-Eight" aria-expanded="false"
                                        aria-controls="collapseTab6-Eight" role="button">
                                        <span class="title-sidebar">8. How doIleave feedback for my
                                            order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab6-Eight" class="accordion-collapse collapse"
                                        aria-labelledby="headingEight8" data-bs-parent="#accordionTab6">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab7" role="tabpanel">
                        <div class="faq-item">
                            <h5 class="name-faq fw-bold">
                                Et blandit mauris
                            </h5>
                            <div class="faq-wrap" id="accordionTab7">
                                <div class="widget-accordion " id="headingOne9">
                                    <div class="accordion-title" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab7-One" aria-expanded="true"
                                        aria-controls="collapseTab7-One" role="button">
                                        <span class="title-sidebar">1. What canIdo ifIforgot my
                                            password?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab7-One" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne9" data-bs-parent="#accordionTab7">
                                        <div class="accordion-body widget-desc">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingTwo9">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab7-Two" aria-expanded="false"
                                        aria-controls="collapseTab7-Two" role="button">
                                        <span class="title-sidebar">2. Why cannotIreceive the SMS
                                            verification
                                            code?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab7-Two" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo9" data-bs-parent="#accordionTab7">
                                        <div class="accordion-body widget-material">
                                            <span class="icon">
                                                <i class="icon-quote"></i>
                                            </span>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingThree">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab7-Three" aria-expanded="false"
                                        aria-controls="collapseTab7-Three" role="button">
                                        <span class="title-sidebar">3. When willIreceive my order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab7-Three" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionTab7">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFour9">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab7-Four" aria-expanded="false"
                                        aria-controls="collapseTab7-Four" role="button">
                                        <span class="title-sidebar">4. How canIregister an account</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab7-Four" class="accordion-collapse collapse"
                                        aria-labelledby="headingFour9" data-bs-parent="#accordionTab7">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingFive9">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab7-Five" aria-expanded="false"
                                        aria-controls="collapseTab7-Five" role="button">
                                        <span class="title-sidebar">5. What can I do if my account was
                                            deactivated?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab7-Five" class="accordion-collapse collapse"
                                        aria-labelledby="headingFive9" data-bs-parent="#accordionTab7">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSix9">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab7-Six" aria-expanded="false"
                                        aria-controls="collapseTab7-Six" role="button">
                                        <span class="title-sidebar">6. How do I add the inspection service
                                            to my
                                            Trade Assurance order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab7-Six" class="accordion-collapse collapse"
                                        aria-labelledby="headingSix9" data-bs-parent="#accordionTab7">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingSeven9">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab7-Seven" aria-expanded="false"
                                        aria-controls="collapseTab7-Seven" role="button">
                                        <span class="title-sidebar">7. How doIdelete verification phone
                                            number?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab7-Seven" class="accordion-collapse collapse"
                                        aria-labelledby="headingSeven9" data-bs-parent="#accordionTab7">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-accordion " id="headingEight9">
                                    <div class="accordion-title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTab7-Eight" aria-expanded="false"
                                        aria-controls="collapseTab7-Eight" role="button">
                                        <span class="title-sidebar">8. How doIleave feedback for my
                                            order?</span>
                                        <span class="icon"></span>
                                    </div>
                                    <div id="collapseTab7-Eight" class="accordion-collapse collapse"
                                        aria-labelledby="headingEight9" data-bs-parent="#accordionTab7">
                                        <div class="accordion-body widget-material">
                                            <i class="icon-quote"></i>
                                            <p class="text-main">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Curabitur ac tortor sit amet est egestas lacinia vitae sit
                                                amet
                                                sem. Aliquam fringilla ex at lorem faucibus auctor. Duis
                                                sollicitudin nec nunc vitae interdum. Maecenas a tempus
                                                quam.
                                                Suspendisse sit amet erat vehicula, fermentum ipsum sit
                                                amet,
                                                tincidunt sapien. Duis scelerisque quis ligula et fermentum.
                                                Donec id finibus neque, in commodo diam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Faq -->

@endsection
