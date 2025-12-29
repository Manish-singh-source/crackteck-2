@extends('frontend/layout/master')

@section('style')
<style>
    .tf-table-page-cart thead {
        border-top: 0px solid var(--gray-5);
        border-bottom: 1px solid var(--gray-5);
    }

    .tf-table-page-cart tr>*:last-child {
        width: 0px;
    }

    .tf-table-page-cart th:last-child {
        padding: 0px 0px 0px 0px;
    }

    .tf-table-page-cart tr>* {
        width: 0px;
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
            <li><span class="body-small">AMC Details</span></li>
        </ul>
    </div>
</div>
<!-- /Breakcrumbs -->

<!-- Shopping Cart -->
<div class="s-shoping-cart tf-sp-1">
    <div class="container">
        <ul class="col-12 list-group list-group-flush" style="
    border: 1px solid #dee2e6;">
            <li class="list-group-item d-flex justify-content-between align-items-center mb-2">
                <span><b>AMC Plan No:</b></span>
                <span class="text-delivered">#6284</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center mb-2">
                <span><b>Plan Name</b></span>
                <span class="text-delivered"> Premium AMC</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center mb-2">
                <span><b>Purchase Date</b></span>
                <span class="text-delivered"> March 6, 2025</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center mb-2">
                <span><b>Expiry Date</b></span>
                <span class="text-delivered">March 6, 2026</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center mb-2">
                <span><b>Payment method</b></span>
                <span class="text-delivered"> Direct bank transfer</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center mb-2">
                <span><b>Status</b></span>
                <span class="text-delivered"> Active</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center mb-2">
                <span><b>Invoices PDF</b></span>
                <span class="text-delivered"> BK159.pdf</span>
            </li>
        </ul>
        <form class="form-discount mt-3">
            <div class="overflow-x-auto">
                <table class="tf-table-page-cart">
                    <thead>
                        <tr>
                            <th>Product List</th>
                            <th>Type</th>
                            <th>Modal Number</th>
                            <th>Product Serial Number</th>
                            <th>Crackteck Serial Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tf-cart-item">
                            <td class="tf-cart-item_product">
                                <a href="#" class="img-box"><img src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                        alt=""></a>
                                <div class="cart-info">
                                    <a href="#" class="cart-title body-md-2 fw-semibold link">
                                        Qubo Smart Cam 360 1296p WiFi CCTV
                                    </a>
                                    <div class="variant-box">
                                        <p class="body-text-3">Color:</p>
                                        <div class="tf-select">
                                            <select>
                                                <option selected="selected">Yellow</option>
                                                <option>Green</option>
                                                <option>Black</option>
                                                <option>Red</option>
                                                <option>Beige</option>
                                                <option>Pink</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p>CCTV</p>
                            </td>
                            <td>
                                <p>1</p>
                            </td>
                            <td>
                                <p>B0BB7FQBBQ</p>
                            </td>
                            <td>
                                <p>B0BB7FQBBQ</p>
                            </td>
                        </tr>
                        <tr class="tf-cart-item">
                            <td class="tf-cart-item_product">
                                <a href="#" class="img-box"><img src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                        alt=""></a>
                                <div class="cart-info">
                                    <a href="#" class="cart-title body-md-2 fw-semibold link">
                                        HP MFP 1188W Multi-function WiFi <br
                                            class="d-none d-xl-block"> Monochrome Laser Printer
                                    </a>
                                    <div class="variant-box">
                                        <p class="body-text-3">Color:</p>
                                        <div class="tf-select">
                                            <select>
                                                <option>Yellow</option>
                                                <option>Green</option>
                                                <option selected="selected">Black</option>
                                                <option>Red</option>
                                                <option>Beige</option>
                                                <option>Pink</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p>Printer</p>
                            </td>
                            <td>
                                <p>1</p>
                            </td>
                            <td>
                                <p>B0BB7FQBPF</p>
                            </td>
                            <td>
                                <p>B0BB7FQBPF</p>
                            </td>
                        </tr>
                        <tr class="tf-cart-item">
                            <td class="tf-cart-item_product">
                                <a href="#" class="img-box"><img src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                        alt=""></a>
                                <div class="cart-info">
                                    <a href="#" class="cart-title body-md-2 fw-semibold link">
                                        RICH POLO Biometric Time & Attendance (Fingerprint)
                                    </a>
                                    <div class="variant-box">
                                        <p class="body-text-3">Color:</p>
                                        <div class="tf-select">
                                            <select>
                                                <option>Yellow</option>
                                                <option selected="selected">Green</option>
                                                <option>Black</option>
                                                <option>Red</option>
                                                <option>Beige</option>
                                                <option>Pink</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p>Laptop</p>
                            </td>
                            <td>
                                <p>1</p>
                            </td>
                            <td>
                                <p>B0BB7FQBBZ</p>
                            </td>
                            <td>
                                <p>B0BB7FQBBZ</p>
                            </td>
                        </tr>
                        <tr class="tf-cart-item">
                            <td class="tf-cart-item_product">
                                <a href="#" class="img-box"><img src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                        alt=""></a>
                                <div class="cart-info">
                                    <a href="#" class="cart-title body-md-2 fw-semibold link">
                                        Lenovo G27Q 27" QHD (2560 x 1440) IPS 165Hz 1ms <br
                                            class="d-none d-xl-block"> FreeSync Premium Gaming
                                        Monitor
                                    </a>
                                    <div class="variant-box">
                                        <p class="body-text-3">Color:</p>
                                        <div class="tf-select">
                                            <select>
                                                <option>Yellow</option>
                                                <option>Green</option>
                                                <option selected="selected">Black</option>
                                                <option>Red</option>
                                                <option>Beige</option>
                                                <option>Pink</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p>Biometric</p>
                            </td>
                            <td>
                                <p>1</p>
                            </td>
                            <td>
                                <p>B0BB7FQBBS</p>
                            </td>
                            <td>
                                <p>B0BB7FQBBS</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>

    </div>
</div>
<!-- /Shopping Cart -->

@endsection