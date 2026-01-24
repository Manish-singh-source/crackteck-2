@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Task, Meeting & Visit Scheduler</h4>
                </div>
                <div>
                    <a href="{{ route('meets.create') }}" id="mySection" class="btn btn-primary">Create
                        Meeting</a>
                </div>
            </div>

            <!-- End Main Widgets -->
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
                                    'scheduled' => [
                                        'label' => 'Scheduled',
                                        'icon' => 'mdi-calendar-clock',
                                        'color' => 'text-primary',
                                    ],
                                    'confirmed' => [
                                        'label' => 'Confirmed',
                                        'icon' => 'mdi-check-decagram',
                                        'color' => 'text-info',
                                    ],
                                    'completed' => [
                                        'label' => 'Completed',
                                        'icon' => 'mdi-check-circle-outline',
                                        'color' => 'text-success',
                                    ],
                                    'rescheduled' => [
                                        'label' => 'Rescheduled',
                                        'icon' => 'mdi-clock-outline',
                                        'color' => 'text-warning',
                                    ],
                                    'cancelled' => [
                                        'label' => 'Cancelled',
                                        'icon' => 'mdi-close-circle-outline',
                                        'color' => 'text-danger',
                                    ],
                                ];

                                $currentStatus = request('status', 'all');

                                if (!array_key_exists($currentStatus, $statuses)) {
                                    $currentStatus = 'all';
                                }
                            @endphp

                            <ul class="nav nav-underline border-bottom" role="tablist">
                                @foreach ($statuses as $key => $status)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2 {{ $currentStatus === $key ? 'active' : '' }}"
                                            href="{{ $key === 'all' ? route('meets.index') : route('meets.index', ['status' => $key]) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>
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
                                <div class="tab-pane active show" id="all_services" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Meeting ID</th>
                                                                <th>Lead Id</th>
                                                                <th>Title</th>
                                                                <th>Type</th>
                                                                <th>Date & Time</th>
                                                                <th>Location / Link</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($meet as $meet)
                                                                <tr>
                                                                    <td>{{ $meet->id }}</td>
                                                                    <td>
                                                                        {{ $meet->leadDetails->lead_number }}
                                                                    </td>
                                                                    <td class="text-truncate" style="max-width: 200px;">
                                                                        {{ $meet->meet_title }}
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $meetingTypes = [
                                                                                'onsite_demo' => 'Onsite Demo',
                                                                                'virtual_meeting' => 'Virtual Meeting',
                                                                                'technical_visit' => 'Techncal Visit',
                                                                                'business_meeting' =>
                                                                                    'Business Meeting',
                                                                                'other' => 'Other',
                                                                            ];
                                                                        @endphp

                                                                        <span>
                                                                            {{ $meetingTypes[$meet->meeting_type] ?? 'Unknown' }}
                                                                        </span> 
                                                                    </td>
                                                                    <td>{{ $meet->date }} {{ $meet->time }}</td>
                                                                    <td>{{ $meet->location }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass = match ($meet->status) {
                                                                                'scheduled'
                                                                                    => 'bg-warning-subtle text-warning',
                                                                                'confirmed'
                                                                                    => 'bg-primary-subtle text-primary',
                                                                                'completed'
                                                                                    => 'bg-success-subtle text-success',
                                                                                'rescheduled'
                                                                                    => 'bg-info-subtle text-info',
                                                                                'cancelled'
                                                                                    => 'bg-danger-subtle text-danger',
                                                                                default
                                                                                    => 'bg-secondary-subtle text-secondary',
                                                                            };

                                                                            $statusTypes = [
                                                                                'scheduled' => 'Scheduled',
                                                                                'confirmed' => 'Confirmed',
                                                                                'completed' => 'Completed',
                                                                                'rescheduled' => 'Rescheduled',
                                                                                'cancelled' => 'Cancelled',
                                                                            ];
                                                                        @endphp

                                                                        <span
                                                                            class="badge fw-semibold {{ $badgeClass }}">
                                                                            {{ $statusTypes[$meet->status] ?? 'Unknown' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('meets.view', $meet->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('meets.edit', $meet->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form style="display: inline-block"
                                                                            action="{{ route('meets.delete', $meet->id) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Are you sure?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Delete"><i
                                                                                    class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
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
