@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Coupons List</h4>
                </div>
                <div>
                    <a href="{{ route('coupon.create') }}" class="btn btn-primary">Add New Coupon</a>
                </div>
            </div>

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
                                        'badge' => 'bg-success-subtle',
                                    ],
                                    'inactive' => [
                                        'label' => 'Inactive',
                                        'icon' => 'mdi-close-circle-outline',
                                        'color' => 'text-secondary',
                                        'badge' => 'bg-secondary-subtle',
                                    ],
                                    'expired' => [
                                        'label' => 'Expired',
                                        'icon' => 'mdi-alert-circle-outline',
                                        'color' => 'text-danger',
                                        'badge' => 'bg-danger-subtle',
                                    ],
                                ];

                                $currentStatus = request()->get('status') ?? 'all';
                            @endphp

                            <ul class="nav nav-underline border-bottom" id="pills-tab" role="tablist">
                                @foreach ($statuses as $key => $status)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $currentStatus === $key ? 'active' : '' }} p-2"
                                            href="{{ $key === 'all' ? route('coupon.index') : route('coupon.index', ['status' => $key]) }}">
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
                                                            <th>Code</th>
                                                            <th>Title</th>
                                                            <th>Type</th>
                                                            <th>Discount</th>
                                                            <th>Status</th>
                                                            <th>Usage</th>
                                                            <th>Dates</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($coupons as $coupon)
                                                            <tr>
                                                                <td>
                                                                    <code class="text-primary">{{ $coupon->code }}</code>
                                                                </td>
                                                                <td>{{ $coupon->title }}</td>
                                                                <td>
                                                                    @if ($coupon->type == 0)
                                                                        <span
                                                                            class="badge bg-info-subtle text-info fw-semibold">Percentage</span>
                                                                    @elseif($coupon->type == 1)
                                                                        <span
                                                                            class="badge bg-success-subtle text-success fw-semibold">Fixed</span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-warning-subtle text-warning fw-semibold">Buy
                                                                            X Get Y</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $coupon->formatted_discount }}</td>
                                                                <td>
                                                                    <span
                                                                        class="badge {{ $statuses[$coupon->status]['badge'] }} fw-semibold {{ $statuses[$coupon->status]['color'] }}">
                                                                        {{ ucfirst($statuses[$coupon->status]['label']) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <small class="text-muted">
                                                                        {{ $coupon->used_count }} /
                                                                        {{ $coupon->usage_limit ?: '∞' }}
                                                                        @if ($coupon->usage_limit > 0)
                                                                            <br><span
                                                                                class="badge bg-light text-dark">{{ $coupon->usage_percentage }}%</span>
                                                                        @endif
                                                                    </small>
                                                                </td>
                                                                <td>
                                                                    <small>
                                                                        {{ $coupon->start_date->format('M d, Y') }}<br>
                                                                        {{ $coupon->end_date->format('M d, Y') }}
                                                                    </small>
                                                                </td>
                                                                <td>
                                                                    <a aria-label="anchor"
                                                                        href="{{ route('coupon.edit', $coupon->id) }}"
                                                                        class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-original-title="Edit">
                                                                        <i
                                                                            class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                    </a>
                                                                    {{-- <button type="button" aria-label="anchor"
                                                                class="btn btn-icon btn-sm bg-danger-subtle delete-coupon"
                                                                data-coupon-id="{{ $coupon->id }}"
                                                                data-coupon-name="{{ $coupon->title }}"
                                                                data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                            </button> --}}
                                                                    <form
                                                                        action="{{ route('coupon.delete', $coupon->id) }}"
                                                                        method="POST" style="display: inline-block;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" aria-label="anchor"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Delete"
                                                                            onclick="return confirm('Are you sure you want to delete the coupon &quot;{{ $coupon->title }}&quot;?');">
                                                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8" class="text-center py-4">
                                                                    <div class="text-muted">
                                                                        <i class="mdi mdi-ticket-percent fs-24 mb-2"></i>
                                                                        <p class="mb-0">No coupons found</p>
                                                                        <a href="{{ route('coupon.create') }}"
                                                                            class="btn btn-primary btn-sm mt-2">
                                                                            Create First Coupon
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Pagination -->
                                            @if ($coupons->hasPages())
                                                <div class="d-flex justify-content-between align-items-center mt-3 px-3">
                                                    <div class="text-muted">
                                                        Showing {{ $coupons->firstItem() }} to {{ $coupons->lastItem() }}
                                                        of {{ $coupons->total() }} results
                                                    </div>
                                                    <div>
                                                        {{ $coupons->links() }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- Tab panes -->
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Delete coupon functionality
            $('.delete-coupon').on('click', function() {
                const couponId = $(this).data('coupon-id');
                const couponName = $(this).data('coupon-name');

                if (confirm(`Are you sure you want to delete the coupon "${couponName}"?`)) {
                    $.ajax({
                        url: `/e-commerce/delete-coupon/${couponId}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            alert(response.message || 'Error deleting coupon');
                        }
                    });
                }
            });

            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
