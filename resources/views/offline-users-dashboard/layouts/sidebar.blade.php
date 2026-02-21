<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <div id="sidebar-menu">

            <div class="logo-box">
                <a class='logo logo-light' href="{{ route('offline-index') }}">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="">
                    </span>
                </a>
                <a class='logo logo-dark' href="{{ route('offline-index') }}">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="">
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title mt-2">Dashboard</li>
                <li>
                    <a class='tp-link' href="{{ route('offline-index') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="ps-1">Dashboard</span>
                    </a>
                </li>
                {{-- <li>
                    <a class='tp-link' href="{{ route('rack.index') }}">
                        <i class="fas fa-th"></i>
                        <span class="ps-1">Warehouse Rack</span>
                    </a>
                </li> --}}

                <li class="menu-title mt-2">My Services</li>
                <li>
                    <a class='tp-link' href="{{ route('offline-amc') }}">
                        <i class="fas fa-clipboard-check"></i>
                        <span class="ps-1">AMC</span>
                    </a>
                </li>


                <li class="menu-title mt-2">Personal Details</li>
                <li>
                    <a class='tp-link' href="{{ route('accountDetail') }}">
                        <i class="fas fa-user-circle"></i>
                        <span class="ps-1">Account Details</span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('address') }}">
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="ps-1"> Address </span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('changePassword') }}">
                        <i class="fas fa-lock"></i>
                        <span class="ps-1">Change Password</span>
                    </a>
                </li>
            </ul>

        </div>

        <div class="clearfix"></div>

    </div>
</div>
