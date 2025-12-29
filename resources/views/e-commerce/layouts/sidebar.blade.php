<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a class='logo logo-light' href="{{ route('e-commerce/index') }}">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="">
                    </span>
                </a>
                <a class='logo logo-dark' href="{{ route('e-commerce/index') }}">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="">
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title mt-2">USERS & ORDERS</li>

                <li>
                    <a class='tp-link' href="{{ route('ec.customer.index') }}">
                        <i class="fas fa-user"></i>
                        <span class="ps-1"> Customers </span>
                    </a>
                </li>

                <li>
                    <a class='tp-link' href="{{ route('order.index') }}">
                        <i class="fas fa-receipt"></i>
                        <span class="ps-1"> Orders </span>
                    </a>
                </li>

                <li class="menu-title mt-2">PRODUCTS</li>
                <li>
                    <a class='tp-link' href="{{ route('ec.product.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="ps-1"> Products </span>
                    </a>
                </li>

                <li>
                    <a class='tp-link' href="{{ route('category.index') }}">
                        <i class="fas fa-th-list"></i>
                        <span class="ps-1"> Categories </span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('brand.index') }}">
                        <i class="fas fa-tag"></i>
                        <span class="ps-1"> Brands </span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('variant.index') }}">
                        <i class="fas fa-palette"></i>
                        <span class="ps-1"> Product Variants </span>
                    </a>
                </li>

                <li class="menu-title mt-2">MARKETING</li>

                <li>
                    <a class='tp-link' href="{{ route('coupon.index') }}">
                        <i class="fas fa-tags"></i>
                        <span class="ps-1"> Coupons </span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('subscriber.index') }}">
                        <i class="fas fa-envelope-open-text"></i>

                        <span class="ps-1"> Subscribers </span>
                    </a>
                </li>

                <li>
                    <a class='tp-link' href="{{ route('contact.index') }}">
                        <i class="fas fa-address-book"></i>
                        <span class="ps-1"> Contacts </span>
                    </a>
                </li>

                <li class="menu-title">Website Setup</li>
                <li>
                    <a href="#sidebarBaseui1" data-bs-toggle="collapse">
                        <i class="fas fa-flag"></i>
                        <span class="ps-1"> Banner </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseui1">
                        <ul class="nav-second-level">
                            <li>
                                <a class='tp-link' href="{{ route('website.banner.index') }}">Website Banner</a>
                            </li>
                            <li>
                                <a class='tp-link' href="{{ route('promotional.banner.index') }}">Promotional Banner</a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('product-deals.index') }}">
                    <i class="fas fa-bolt"></i>
                        <span class="ps-1"> Product Deal Offer </span>
                    </a>
                </li>

                <li>
                    <a class='tp-link' href="{{ route('collection.index') }}">
                      <i class="fas fa-th-large"></i>
                        <span> Collection </span>
                    </a>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>