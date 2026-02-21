<style>
    .app-wrapper {
        padding: 1rem;
        background-color: #ffffff;
        border-radius: 0rem;
        cursor: pointer;
    }

    .border-end {
        border-right: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color) !important;
    }
</style>
<!-- Topbar Start -->
<div class="topbar-custom">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center gap-2">
                <li>
                    <button class="button-toggle-menu nav-link">
                        <i data-feather="menu" class="noti-icon"></i>
                    </button>
                </li>

                <li class="px-2 py-1 rounded-lg">
                    <h5 class="mb-0">
                        <a class='tp-link' href="{{ route('offline-index') }}">
                            <i class="fas fa-clipboard-check"></i>
                            <!-- <img width="" height="20" src="https://img.icons8.com/external-outline-design-circle/66/1A1A1A/external-Crm-customer-service-outline-design-circle.png" alt="external-Crm-customer-service-outline-design-circle" /> -->
                            <span class="d-none d-md-inline-flex ps-1"> AMC </span>
                        </a>
                    </h5>
                </li>
            </ul>

            <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">

                <li class="d-none d-sm-flex dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-haspopup="false" aria-expanded="false">
                        <i data-feather="bell" class="noti-icon"></i>
                        <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-lg">
                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0">
                                <span class="float-end"><a href="#" class="text-dark"><small>Clear
                                            All</small></a></span>Notification
                            </h5>
                        </div>

                        <div class="noti-scroll" data-simplebar>
                            <!-- item-->
                            <a href="javascript:void(0);"
                                class="dropdown-item notify-item text-muted link-primary active">
                                <div class="notify-icon">
                                    <img src="{{ asset('assets/images/users/user-12.jpg') }}" class="img-fluid rounded-circle"
                                        alt="" />
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="notify-details">Carl Steadham</p>
                                    <small class="text-muted">5 min ago</small>
                                </div>
                                <p class="mb-0 user-msg">
                                    <small class="fs-14">Completed <span class="text-reset">Improve workflow in
                                            Figma</span></small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);"
                                class="dropdown-item notify-item text-muted link-primary">
                                <div class="notify-icon">
                                    <img src="{{ asset('assets/images/users/user-2.jpg') }}" class="img-fluid rounded-circle"
                                        alt="" />
                                </div>
                                <div class="notify-content">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="notify-details">Olivia McGuire</p>
                                        <small class="text-muted">1 min ago</small>
                                    </div>

                                    <div class="d-flex mt-2 align-items-center">
                                        <div class="notify-sub-icon">
                                            <i class="mdi mdi-download-box text-dark"></i>
                                        </div>

                                        <div>
                                            <p class="notify-details mb-0">dark-themes.zip</p>
                                            <small class="text-muted">2.4 MB</small>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);"
                                class="dropdown-item notify-item text-muted link-primary">
                                <div class="notify-icon">
                                    <img src="{{ asset('assets/images/users/user-3.jpg') }}" class="img-fluid rounded-circle"
                                        alt="" />
                                </div>
                                <div class="notify-content">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="notify-details">Travis Williams</p>
                                        <small class="text-muted">7 min ago</small>
                                    </div>
                                    <p class="noti-mentioned p-2 rounded-2 mb-0 mt-2">
                                        <span class="text-primary">@Patryk</span> Please make sure that
                                        you're....
                                    </p>
                                </div>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);"
                                class="dropdown-item notify-item text-muted link-primary">
                                <div class="notify-icon">
                                    <img src="{{ asset('assets/images/users/user-8.jpg') }}" class="img-fluid rounded-circle"
                                        alt="" />
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="notify-details">Violette Lasky</p>
                                    <small class="text-muted">5 min ago</small>
                                </div>
                                <p class="mb-0 user-msg">
                                    <small class="fs-14">Completed <span class="text-reset">Create new
                                            components</span></small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);"
                                class="dropdown-item notify-item text-muted link-primary">
                                <div class="notify-icon">
                                    <img src="{{ asset('assets/images/users/user-5.jpg') }}" class="img-fluid rounded-circle"
                                        alt="" />
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="notify-details">Ralph Edwards</p>
                                    <small class="text-muted">5 min ago</small>
                                </div>
                                <p class="mb-0 user-msg">
                                    <small class="fs-14">Completed<span class="text-reset">Improve workflow in
                                            React</span></small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);"
                                class="dropdown-item notify-item text-muted link-primary">
                                <div class="notify-icon">
                                    <img src="{{ asset('assets/images/users/user-6.jpg') }}" class="img-fluid rounded-circle"
                                        alt="" />
                                </div>
                                <div class="notify-content">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="notify-details">Jocab jones</p>
                                        <small class="text-muted">7 min ago</small>
                                    </div>
                                    <p class="noti-mentioned p-2 rounded-2 mb-0 mt-2">
                                        <span class="text-reset">@Patryk</span> Please make sure that you're....
                                    </p>
                                </div>
                            </a>
                        </div>

                        <!-- All-->
                        <a href="javascript:void(0);"
                            class="dropdown-item text-center text-primary notify-item notify-all">View all
                            <i class="fe-arrow-right"></i>
                        </a>
                    </div>
                </li>

                <!-- User Dropdown -->
                @php
                    $customer = Auth::guard('customer_web')->user();
                @endphp
                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ asset('assets/images/users/user-13.jpg') }}" alt="user-image" class="rounded-circle" />
                        <span class="d-none d-sm-inline-block pro-user-name ms-1">
                            {{ $customer ? $customer->first_name . ' ' . $customer->last_name : 'Guest' }}
                            <i class="mdi mdi-chevron-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                        
                        <!-- item-->
                        <form action="{{ route('offline-logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item notify-item">
                                <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- end Topbar -->