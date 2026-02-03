@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Pickup Requests</h4>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body pt-0">
                            @php
                                $statuses = [
                                    'all' => [
                                        'label' => 'All',
                                        'icon' => 'mdi-format-list-bulleted',
                                        'color' => '',
                                    ],
                                    'pending' => [
                                        'label' => 'Pending',
                                        'icon' => 'mdi-timer-sand',
                                        'color' => 'text-warning',
                                    ],
                                    'assigned' => [
                                        'label' => 'Assigned',
                                        'icon' => 'mdi-account-arrow-right',
                                        'color' => 'text-info',
                                    ],
                                    'approved' => [
                                        'label' => 'Approved',
                                        'icon' => 'mdi-check-circle-outline',
                                        'color' => 'text-success',
                                    ],
                                    'picked' => [
                                        'label' => 'Picked',
                                        'icon' => 'mdi-package-variant',
                                        'color' => 'text-primary',
                                    ],
                                    'received' => [
                                        'label' => 'Received',
                                        'icon' => 'mdi-package-check',
                                        'color' => 'text-success',
                                    ],
                                    'cancelled' => [
                                        'label' => 'Cancelled',
                                        'icon' => 'mdi-close-circle-outline',
                                        'color' => 'text-danger',
                                    ],
                                    'returned' => [
                                        'label' => 'Returned',
                                        'icon' => 'mdi-backup-restore',
                                        'color' => 'text-secondary',
                                    ],
                                    'completed' => [
                                        'label' => 'Completed',
                                        'icon' => 'mdi-check-all',
                                        'color' => 'text-success',
                                    ],
                                ];

                                $currentStatus = request()->get('status', 'all');
                            @endphp

                            <ul class="nav nav-underline border-bottom" role="tablist">
                                @foreach ($statuses as $key => $status)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2 {{ $currentStatus === $key ? 'active' : '' }}"
                                            href="{{ $key === 'all' ? route('pickup-requests.index') : route('pickup-requests.index', ['status' => $key]) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi {{ $status['icon'] }} fs-16 {{ $status['color'] }}"></i>
                                            </span>

                                            <span class="d-none d-sm-block">
                                                <i class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>
                                                {{ $status['label'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>


                            <div class="tab-content text-muted">
                                <div class="tab-pane active show" id="all_customer" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr No</th>
                                                                <th>Service Request Id</th>
                                                                <th>Service Type</th>
                                                                <th>Product Id</th>
                                                                <th>Requested Engineer Name</th>
                                                                <th>Assigned Person Type</th>
                                                                <th>Assigned Person Name</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($pickups as $index => $pickup)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $pickup->serviceRequest->request_id ?? 'N/A' }}</td>
                                                                    <td>
                                                                        @php 
                                                                            $serviceTypes = [
                                                                                'amc' => 'AMC',
                                                                                'installation' => 'Installation',
                                                                                'repairing' => 'Repairing',
                                                                                'quick_service' => 'Quick Service',
                                                                            ];
                                                                        @endphp
                                                                        {{ $serviceTypes[$pickup->serviceRequest->service_type ?? 'N/A'] ?? 'N/A' }}
                                                                    </td>
                                                                    <td>{{ $pickup->serviceRequestProduct->id ?? 'N/A' }}</td>
                                                                    <td>
                                                                        @if ($pickup->assignedEngineer && $pickup->assignedEngineer->engineer)
                                                                            {{ $pickup->assignedEngineer->engineer->first_name ?? '' }} {{ $pickup->assignedEngineer->engineer->last_name ?? '' }}
                                                                        @else
                                                                            N/A
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($pickup->assigned_person_type === 'engineer')
                                                                            <span class="badge bg-primary">Engineer</span>
                                                                        @elseif ($pickup->assigned_person_type === 'delivery_man')
                                                                            <span class="badge bg-info">Delivery Man</span>
                                                                        @else
                                                                            <span class="badge bg-secondary">{{ ucfirst($pickup->assigned_person_type ?? 'N/A') }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $pickup->assignedPerson->first_name ?? 'N/A' }} {{ $pickup->assignedPerson->last_name ?? '' }}</td>
                                                                    <td>
                                                                        @php
                                                                            $statusColors = [
                                                                                'pending' => 'bg-warning-subtle text-warning',
                                                                                'assigned' => 'bg-info-subtle text-info',
                                                                                'approved' => 'bg-success-subtle text-success',
                                                                                'picked' => 'bg-primary-subtle text-primary',
                                                                                'received' => 'bg-success-subtle text-success',
                                                                                'cancelled' => 'bg-danger-subtle text-danger',
                                                                                'returned' => 'bg-secondary-subtle text-secondary',
                                                                                'completed' => 'bg-success-subtle text-success',
                                                                            ];
                                                                        @endphp
                                                                        <span class="badge {{ $statusColors[$pickup->status] ?? 'bg-secondary-subtle text-secondary' }} fw-semibold">
                                                                            {{ ucfirst($pickup->status ?? 'N/A') }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $serviceTypeRoutes = [
                                                                                'quick_service' => 'service-request.view-quick-service-request',
                                                                                // Add other service types as needed
                                                                            ];
                                                                            $routeName = $serviceTypeRoutes[$pickup->serviceRequest->service_type ?? ''] ?? 'service-request.view-quick-service-request';
                                                                        @endphp
                                                                        <a aria-label="anchor"
                                                                            href="{{ route($routeName, $pickup->request_id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="8" class="text-center">No pickup requests found.</td>
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
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    @endsection
