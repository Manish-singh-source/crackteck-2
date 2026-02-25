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
                            <li><a href="{{ route('my-account-orders') }}" class="my-account-nav-item">Orders</a></li>
                            <li><a href="{{ route('my-account-address') }}" class="my-account-nav-item">Address</a></li>
                            <li><a href="{{ route('my-account-edit') }}" class="my-account-nav-item">Account Details</a>
                            </li>
                            <li><a href="{{ route('my-account-password') }}" class="my-account-nav-item">Change Password</a></li>
                            <li><a href="{{ route('my-account-amc') }}" class="my-account-nav-item">AMC</a></li>
                            <li><a href="{{ route('my-account-ticket') }}" class="my-account-nav-item active">Support Tickets</a></li>
                            {{-- <li><a href="{{ route('my-account-non-amc') }}" class="my-account-nav-item">NON AMC</a> --}}
                            </li>
                            <li><a href="{{ route('wishlist') }}" class="my-account-nav-item">Wishlist</a></li>
                            @if (Auth::guard('customer_web')->check())
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
                        <h4 class="fw-semibold mb-20">Support Tickets</h4>
                        <div class="tf-order_history-table">
                            @if($amcTickets->isEmpty())
                                <div class="text-center py-5">
                                    <p class="body-text-3">No tickets found.</p>
                                    <a href="{{ route('my-account-amc') }}" class="tf-btn btn-small d-inline-flex mt-3">
                                        <span class="text-white">View AMC Services</span>
                                    </a>
                                </div>
                            @else
                                <table class="table_def">
                                    <thead>
                                        <tr>
                                            <th class="title-sidebar fw-medium">Ticket No</th>
                                            <th class="title-sidebar fw-medium">Service ID</th>
                                            <th class="title-sidebar fw-medium">Subject</th>
                                            <th class="title-sidebar fw-medium">Priority</th>
                                            <th class="title-sidebar fw-medium">Status</th>
                                            <th class="title-sidebar fw-medium">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($amcTickets as $ticket)
                                        <tr class="td-order-item">
                                            <td class="body-text-3">#{{ $ticket->ticket_no }}</td>
                                            <td class="body-text-3">{{ $ticket->service_id }}</td>
                                            <td class="body-text-3">{{ $ticket->subject }}</td>
                                            <td class="body-text-3">
                                                @php
                                                    $priorityClass = match($ticket->priority) {
                                                        'high' => 'text-danger',
                                                        'medium' => 'text-warning',
                                                        'low' => 'text-info',
                                                        default => 'text-secondary',
                                                    };
                                                @endphp
                                                <span class="{{ $priorityClass }}">{{ ucfirst($ticket->priority) }}</span>
                                            </td>
                                            <td class="body-text-3">
                                                @php
                                                    $statusClass = match($ticket->status) {
                                                        'pending' => 'text-danger',
                                                        'in_progress' => 'text-warning',
                                                        'resolved' => 'text-success',
                                                        default => 'text-secondary',
                                                    };
                                                @endphp
                                                <span class="{{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</span>
                                            </td>
                                            <td class="body-text-3">{{ $ticket->created_at->format('d M Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /My Account -->
@endsection
