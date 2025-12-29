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
                    <span class="body-small">Account</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->
    <!-- My Account -->
    <section class="tf-sp-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="wrap-sidebar-account ">
                        <ul class="my-account-nav content-append">
                            <li><a href="{{ route('my-account') }}" class="my-account-nav-item">Dashboard</a></li>
                            <li><span class="my-account-nav-item active">Orders</span></li>
                            <li><a href="{{ route('my-account-address') }}" class="my-account-nav-item">Address</a></li>
                            <li><a href="{{ route('my-account-edit') }}" class="my-account-nav-item">Account Details</a>
                            </li>
                            <li><a href="{{ route('my-account-password') }}" class="my-account-nav-item">Change Password</a></li>
                            <li><a href="{{ route('my-account-amc') }}" class="my-account-nav-item">AMC</a></li>
                            <li><a href="{{ route('my-account-non-amc') }}" class="my-account-nav-item">NON AMC</a>
                            </li>
                            <li><a href="{{ route('wishlist') }}" class="my-account-nav-item">Wishlist</a></li>
                            @if (Auth::check())
                                <form method="POST" action="{{ route('frontend.logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Logout</button>
                            </form>
                            @else
                                <form method="POST" action="{{ route('frontend.login') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </form>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="my-account-content account-dashboard">
                        <h4 class="fw-semibold mb-20">Order History</h4>
                        <div class="tf-order_history-table">
                            <table class="table_def">
                                <thead>
                                    <tr>
                                        <th class="title-sidebar fw-medium">Order ID</th>
                                        <th class="title-sidebar fw-medium">Date</th>
                                        <th class="title-sidebar fw-medium">Status</th>
                                        <th class="title-sidebar fw-medium">Total</th>
                                        <th class="title-sidebar fw-medium">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr class="td-order-item">
                                        <td class="body-text-3">#{{ $order->order_number }}</td>
                                        <td class="body-text-3">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="body-text-3 text-{{ $order->status === 'delivered' ? 'delivered' : ($order->status === 'shipped' ? 'on-the-way' : 'pending') }}">
                                            {{ ucfirst($order->status) }}
                                        </td>
                                        <td class="body-text-3">₹{{ number_format($order->total_amount, 2) }} / {{ $order->orderItems->count() }} items</td>
                                        <td>
                                            <a href="{{ route('order-details', ['orderNumber' => $order->order_number]) }}"
                                               class="tf-btn btn-small d-inline-flex">
                                                <span class="text-white">Detail</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <p class="body-text-3">No orders found. <a href="{{ route('website') }}" class="link">Start shopping</a></p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($orders->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /My Account -->
@endsection
