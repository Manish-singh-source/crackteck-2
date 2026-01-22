@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Product Deals List</h4>
                    <p class="text-muted">Manage product deals and offers</p>
                </div>
                <div>
                    <a href="{{ route('product-deals.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add New Deal
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            @php
                                $statuses = [
                                    'all' => ['label' => 'All', 'icon' => 'mdi-format-list-bulleted', 'color' => ''],
                                    'active' => [
                                        'label' => 'Active',
                                        'icon' => 'mdi-check-circle-outline',
                                        'color' => 'text-success',
                                    ],
                                    'inactive' => [
                                        'label' => 'Inactive',
                                        'icon' => 'mdi-close-circle-outline',
                                        'color' => 'text-danger',
                                    ],
                                ];

                                $currentStatus = request()->get('status') ?? 'all';
                            @endphp

                            <ul class="nav nav-underline border-bottom" id="pills-tab" role="tablist">
                                @foreach ($statuses as $key => $status)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $currentStatus === $key ? 'active' : '' }} p-2"
                                            href="{{ $key === 'all' ? route('product-deals.index') : route('product-deals.index', ['status' => $key]) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i
                                                    class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>{{ $status['label'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content text-muted">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Deal Title</th>
                                                            <th>Products Count</th>
                                                            <th>Price Range</th>
                                                            <th>Offer Period</th>
                                                            <th>Time Left</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($deals as $index => $deal)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>
                                                                    <div class="fw-semibold">{{ $deal->deal_title }}</div>
                                                                    <small class="text-muted">Created
                                                                        {{ $deal->created_at->diffForHumans() }}</small>
                                                                </td>
                                                                <td>
                                                                    {{ $deal->dealItems->count() }}
                                                                </td>
                                                                <td>
                                                                    {{-- check min and max price  --}}
                                                                    @php
                                                                        $minPrice = $deal->dealItems->min(
                                                                            'offer_price',
                                                                        );
                                                                        $maxPrice = $deal->dealItems->max(
                                                                            'offer_price',
                                                                        );
                                                                    @endphp
                                                                    <div>
                                                                        <span
                                                                            class="fw-semibold text-success">₹{{ number_format($minPrice, 0) }}</span>
                                                                        @if ($minPrice != $maxPrice)
                                                                            <span class="text-muted"> - </span>
                                                                            <span
                                                                                class="fw-semibold text-success">₹{{ number_format($maxPrice, 0) }}</span>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $startDate = \Carbon\Carbon::parse(
                                                                            $deal->offer_start_date,
                                                                        );
                                                                        $endDate = \Carbon\Carbon::parse(
                                                                            $deal->offer_end_date,
                                                                        );
                                                                    @endphp
                                                                    <span>
                                                                        {{ $startDate->format('d M Y') }}
                                                                        <span class="text-muted">to</span>
                                                                        {{ $endDate->format('d M Y') }}
                                                                    </span>
                                                                </td>

                                                                @php
                                                                    $currentTime = \Carbon\Carbon::now();

                                                                    if ($currentTime < $startDate) {
                                                                        $timeLeft = $startDate->diffInSeconds(
                                                                            $currentTime,
                                                                        );
                                                                        $timeText = 'Upcoming';
                                                                        $badgeClass = 'bg-info'; 
                                                                    } elseif (
                                                                        $currentTime >= $startDate &&
                                                                        $currentTime <= $endDate
                                                                    ) {
                                                                        $timeLeft = $endDate->diffInSeconds(
                                                                            $currentTime,
                                                                        );
                                                                        $badgeClass = 'bg-warning';
                                                                        $days = floor($timeLeft / 86400);
                                                                        $hours = floor(($timeLeft % 86400) / 3600);
                                                                        $minutes = floor(($timeLeft % 3600) / 60);
                                                                        $timeText = "{$days}d {$hours}h {$minutes}m left";
                                                                    } else {
                                                                        $timeLeft = 0;
                                                                        $timeText = 'Deal Ended';
                                                                        $badgeClass = 'bg-danger';
                                                                    }
                                                                @endphp

                                                                <td>
                                                                    <span id="countdown_{{ $deal->id }}"
                                                                        class="badge {{ $badgeClass }} text-white fw-semibold"
                                                                        data-timeleft="{{ $timeLeft }}">
                                                                        {{ $timeText }}
                                                                    </span>
                                                                </td>

                                                                <td>
                                                                    @if ($deal->status === 'active')
                                                                        <span
                                                                            class="badge bg-success-subtle text-success fw-semibold">Active</span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-danger-subtle text-danger fw-semibold">Inactive</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a aria-label="Edit"
                                                                        href="{{ route('product-deals.edit', $deal) }}"
                                                                        class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-original-title="Edit">
                                                                        <i
                                                                            class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                    </a>
                                                                    <form
                                                                        action="{{ route('product-deals.delete', $deal) }}"
                                                                        method="POST" class="d-inline"
                                                                        onsubmit="return confirm('Are you sure you want to delete this deal?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" aria-label="Delete"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Delete">
                                                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center py-4">
                                                                    <div class="text-muted">
                                                                        <i class="fa fa-inbox fa-3x mb-3"></i>
                                                                        <h5>No Product Deals Found</h5>
                                                                        <p>Start by creating your first product deal.</p>
                                                                        <a href="{{ route('product-deals.create') }}"
                                                                            class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i> Create Deal
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if ($deals->hasPages())
                            <div class="card-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-0">
                                            Showing {{ $deals->firstItem() }} to {{ $deals->lastItem() }} of
                                            {{ $deals->total() }} results
                                        </p>
                                    </div>
                                    <div>
                                        {{ $deals->links() }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Use the correct jQuery syntax to wait for DOM ready
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Auto-hide success alerts after 5 seconds
            setTimeout(function() {
                $('.alert-success').fadeOut();
            }, 5000);

            // Countdown functionality
            const countdownElements = document.querySelectorAll('[id^="countdown_"]');

            countdownElements.forEach(countdownElement => {
                let timeLeft = parseInt(countdownElement.getAttribute(
                    'data-timeleft')); // Time left in seconds
                const dealId = countdownElement.id.split('_')[1]; // Get deal ID from the element

                // Function to update the countdown
                function updateCountdown() {
                    if (timeLeft < 0) {
                        countdownElement.textContent = 'Deal Ended';
                        countdownElement.classList.remove('bg-warning', 'bg-success');
                        countdownElement.classList.add('bg-danger');
                        return;
                    }

                    let badgeClass = 'bg-info';
                    let timeText = '';

                    if (timeLeft < 3600) { // Less than 1 hour
                        badgeClass = 'bg-warning';
                        timeText = Math.floor(timeLeft / 60) + 'm left';
                    } else if (timeLeft < 86400) { // Less than 1 day
                        badgeClass = 'bg-warning';
                        timeText = Math.floor(timeLeft / 3600) + 'h left';
                    } else { // More than 1 day
                        badgeClass = 'bg-success';
                        timeText = Math.floor(timeLeft / 86400) + 'd left';
                    }

                    countdownElement.textContent = timeText;
                    countdownElement.className = 'badge ' + badgeClass + ' text-dark fw-semibold';

                    timeLeft--;
                }

                // Update the countdown every second
                setInterval(updateCountdown, 1000);
            });
        });
    </script>
@endsection
