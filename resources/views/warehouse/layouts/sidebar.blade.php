<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <div id="sidebar-menu">

            <div class="logo-box">
                <a class='logo logo-light' href="{{ route('warehouse/index') }}">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="">
                    </span>
                </a>
                <a class='logo logo-dark' href="{{ route('warehouse/index') }}">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="">
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title mt-2">Manage Warehouse</li>
                <li>
                    <a class='tp-link' href="{{ route('warehouses-list.index') }}">
                        <i class="fas fa-warehouse"></i>
                        <span class="ps-1">Warehouses</span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('rack.index') }}">
                        <i class="fas fa-th"></i>
                        <span class="ps-1">Warehouse Rack</span>
                    </a>
                </li>

                <li class="menu-title mt-2">Manage Vendor</li>
                <li>
                    <a class='tp-link' href="{{ route('vendor_list.index') }}">
                        <i class="fas fa-person"></i>
                        <span class="ps-1">Vendor</span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('vendor.index') }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span class="ps-1"> Vendor Purchase Bills </span>
                    </a>
                </li>


                <li class="menu-title mt-2">Manage Products</li>
                <li>
                    <a class='tp-link' href="{{ route('products.index') }}">
                        <i class="fas fa-list"></i>
                        <span class="ps-1">Product List</span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('product-list.scrap-items') }}">
                        <i class="fas fa-trash"></i>
                        <span class="ps-1"> Scrap items </span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('track-product.index') }}">
                        <i class="fas fa-shipping-fast"></i>
                        <span class="ps-1">Track Product</span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('spare-parts.index') }}">
                        <i class="fas fa-tools"></i>
                        <span class="ps-1">Spare Parts Request </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Manage Stock Alerts</li>
                
                <li>
                    <a class='tp-link' href="{{ route('stock-reports.index') }}">
                        <i class="fas fa-chart-bar"></i>
                        <span class="ps-1"> Stock Requests </span>
                    </a>
                </li>
                <li>
                    <a class='tp-link' href="{{ route('low-stock.index') }}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span class="ps-1"> Low Stock Reports </span>
                    </a>
                </li>
            </ul>

        </div>

        <div class="clearfix"></div>

    </div>
</div>
