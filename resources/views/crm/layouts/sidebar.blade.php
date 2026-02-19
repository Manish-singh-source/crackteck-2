<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a class='logo logo-light' href="{{ route('crm/index') }}">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="">
                    </span>
                </a>
                <a class='logo logo-dark' href="{{ route('crm/index') }}">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="">
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title">Access Control</li>

                <li>
                    <a href="#accesscontrol" data-bs-toggle="collapse">
                        <i class="fas fa-user-shield"></i>
                        <span class="ps-1"> Access Control </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="accesscontrol">
                        <ul class="nav-second-level">
                            <li>
                                <a class='tp-link' href="{{ route('staff.index') }}">Staff</a>
                            </li>
                            <li>
                                <a class='tp-link' href="{{ route('roles.index') }}">Roles</a>
                            </li>
                            <li>
                                <a class='tp-link' href="{{ route('permission.index') }}">Permission</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarBaseui" data-bs-toggle="collapse">
                        <i class="fas fa-file-alt"></i>
                        <span class="ps-1"> Accounts </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseui">
                        <ul class="nav-second-level">
                            <li>
                                <a class='tp-link' href="{{ route('transactions') }}">Transactions</a>
                            </li>
                            <li>
                                <a class='tp-link' href="{{ route('payments') }}">Payment</a>
                            </li>
                            <li>
                                <a class='tp-link' href="{{ route('reimbursement') }}">Re-Imbursement</a>
                            </li>
                            <li>
                                <a class='tp-link' href="{{ route('withdraw') }}">Withdraw</a>
                            </li>
                            <li>
                                <a class='tp-link' href="{{ route('kyc-log') }}">KYC Log</a>
                            </li>
                            <li>
                                <a class='tp-link' href="{{ route('sales.index') }}">
                                    Sales Invoicing
                                </a>
                            </li>

                            <li>
                                <a class='tp-link' href="{{ route('client.index') }}">
                                    Client Receipts
                                </a>
                            </li>

                            <li>
                                <a class='tp-link' href="{{ route('pay-to-vendors.index') }}">
                                    Payments to Vendor
                                </a>
                            </li>
                            <li>
                                <a class='tp-link' href="{{ route('creditors-report.index') }}">
                                    Creditors Reports
                                </a>
                            </li>
                            <li>
                                <a class='tp-link' href="{{ route('expenses.index') }}">
                                    Expenses
                                </a>
                            </li>
                            <li>
                                <a class='tp-link' href="{{ route('stock-report.index') }}">
                                    Stock Reports
                                </a>
                            </li>
                            <li>
                                <a class='tp-link' href="{{ route('low-stock-alert') }}">
                                    Low Stock Reports
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- @can('Customer List') --}}
                <li>
                    <a class='tp-link' href="{{ route('customer.index') }}">
                        <i class="fas fa-users"></i>
                        <span class="ps-1"> Customers </span>
                    </a>
                </li>
                {{-- @endcan --}}

                {{-- @can('Engineer List') --}}
                {{-- <li>
                    <a class='tp-link' href="{{ route('engineers.index') }}">
                        <!-- <i data-feather="columns"></i> -->
                        <i class="fas fa-user-cog"></i>
                        <span class="ps-1"> Engineers </span>
                    </a>
                </li> --}}
                {{-- @endcan --}}

                {{-- @can('Delivery Man List') --}}
                {{-- <li>
                    <a class='tp-link' href="{{ route('delivery-man.index') }}">
                        <!-- <i data-feather="columns"></i> -->
                        <i class="fas fa-shipping-fast"></i>
                        <span class="ps-1"> Delivery Man </span>
                    </a>
                </li> --}}
                {{-- @endcan --}}

                {{-- <li>
                    <a class='tp-link' href="{{ route('sales-person.index') }}">
                        <i class="fas fa-user-tie"></i>
                        <span class="ps-1"> Sales Person </span>
                    </a>
                </li> --}}

                <li class="menu-title mt-2">Sales Person</li>

                <li>
                    <a class='tp-link' href="{{ route('sales-reports.index') }}">
                        <i class="fas fa-chart-line"></i>
                        <span class="ps-1"> Sales Report </span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('leads.index') }}">
                        <i class="fas fa-user-plus"></i>
                        <span class="ps-1"> Leads </span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('follow-up.index') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span class="ps-1">Follow-Up</span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('meets.index') }}">
                        <i class="fas fa-handshake"></i>
                        <span class="ps-1"> Meets </span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('quotation.index') }}">
                        <i class="fas fa-file-invoice"></i>
                        <span class="ps-1"> Quotations </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Operation Managers</li>

                <li>
                    <a class='tp-link' href="{{ route('amc-plans.index') }}">
                        <i class="fas fa-project-diagram"></i>

                        <span class="ps-1"> AMC Plans </span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('covered-items.index') }}">
                        <i class="fas fa-project-diagram"></i>

                        <span class="ps-1">Covered Items </span>
                    </a>
                </li>
                
                <li>
                    <a class='tp-link' href="{{ route('device-specific-diagnosis.index') }}">
                        <i class="fas fa-project-diagram"></i>

                        <span class="ps-1">Device Specific Diagnosis </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Services</li>
                <li>
                    <a class='tp-link' href="{{ route('amcs-lists.index') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span class="ps-1"> AMCs </span>
                    </a>
                </li>
                
                <li>
                    <a class='tp-link' href="{{ route('service-request.index') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span class="ps-1"> Service Requests </span>
                    </a>
                </li>

                <li>
                    <a class='tp-link' href="{{ route('track-request.index') }}">
                        <i class="fas fa-location-arrow"></i>

                        <span class="ps-1"> Track Request </span>
                    </a>
                </li>

                <li>
                    <a class='tp-link' href="{{ route('case-transfer.index') }}">
                        <i class="fas fa-exchange-alt"></i>
                        <span class="ps-1"> Case Transfer </span>
                    </a>
                </li>

                <li>
                    <a class='tp-link' href="{{ route('call-logs.index') }}">
                        <i class="fas fa-comments"></i>

                        <span class="ps-1"> Chat Logs </span>
                    </a>
                </li>

                <li>
                    <a class='tp-link' href="{{ route('activity-logs.index') }}">
                        <i class="fas fa-stream"></i>

                        <span class="ps-1"> Activity Logs </span>
                    </a>
                </li>

                <li>
                    <a class='tp-link' href="{{ route('pincodes.index') }}">
                        <i class="fas fa-globe-asia"></i>
                        <span> Manage Pincodes </span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('pickup-requests.index') }}">
                        <i class="fas fa-truck"></i>
                        <span> Pickup Request </span>
                    </a>
                </li>
                <li class="menu-title mt-2">Remote Support</li>
                <li>
                    <a class='tp-link' href="{{ route('jobs.index') }}">
                        <i class="fas fa-briefcase"></i>
                        <span class="ps-1"> Jobs</span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('assigned-jobs.index') }}">
                        <i class="fas fa-clipboard-check"></i>
                        <span class="ps-1"> Assigned Jobs</span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('field-issues.index') }}">
                        <i class="fas fa-tools"></i>
                        <span class="ps-1"> Field Issues</span>
                    </a>
                </li>

                <li class="menu-title mt-2">Inventory & spare parts team</li>

                <li>
                    <a class='tp-link' href="{{ route('spare-parts-requests.index') }}">
                        <i class="fas fa-cogs"></i>

                        <span class="ps-1">Spare Parts Request </span>
                    </a>
                </li>

                <li>
                    <a class='tp-link' href="{{ route('in-hand-products.index') }}">
                        <i class="fas fa-user-check"></i>
                        <span>Assign Products </span>
                    </a>
                </li>
                <li class="menu-title mt-2">Customer Care Executives</li>

                <li>
                    <a class='tp-link' href="{{ route('support-ticket.index') }}">
                        <i class="fas fa-life-ring"></i>
                        <span class="ps-1"> Tickets </span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('invoice.index') }}">
                        <i class="fas fa-file-invoice"></i>
                        <span class="ps-1"> Invoice </span>
                    </a>
                </li>

                {{-- 
                <li class="menu-title mt-2">App UI Settings</li>

                <li>
                    <a href="#sduiMenu" data-bs-toggle="collapse">
                        <i class="fas fa-mobile-alt"></i>
                        <span class="ps-1"> SDUI Management </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sduiMenu">
                        <ul class="nav-second-level">
                            <li>
                                <a class='tp-link' href="{{ route('admin.sdui.pages.index') }}">Pages</a>
                            </li>
                            <li>
                                <a class='tp-link' href="{{ route('admin.sdui.settings.index') }}">Settings</a>
                            </li>
                        </ul>
                    </div>
                </li> 
                --}}


            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
