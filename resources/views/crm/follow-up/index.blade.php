@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Follow-Up List</h4>
                </div>
                <div>
                    <a href="{{ route('follow-up.create') }}" class="btn btn-primary">Follow-Up Form</a>
                    <!-- <button class="btn btn-primary">Add New Customer</button> -->
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            @php
                                $statuses = [
                                    'all' => ['label' => 'All', 'icon' => 'mdi-format-list-bulleted', 'color' => ''],
                                    'pending' => [
                                        'label' => 'Pending',
                                        'icon' => 'mdi-timer-sand',
                                        'color' => 'text-warning',
                                    ],
                                    'completed' => [
                                        'label' => 'Completed',
                                        'icon' => 'mdi-check-circle-outline',
                                        'color' => 'text-success',
                                    ],
                                    'rescheduled' => [
                                        'label' => 'Rescheduled',
                                        'icon' => 'mdi-clock-outline',
                                        'color' => 'text-primary',
                                    ],
                                    'cancelled' => [
                                        'label' => 'Cancelled',
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
                                            href="{{ $key === 'all' ? route('follow-up.index') : route('follow-up.index', ['status' => $key]) }}">
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

                                <div class="tab-pane active show" id="all_customer" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Follow-Up Id</th>
                                                                <th>Lead Number</th>
                                                                <th>Client Name</th>
                                                                <th>Contact Number</th>
                                                                <th>Email</th>
                                                                <th>Follow-Up Date</th>
                                                                <th>Follow-Up Time</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($followup as $followup)
                                                                <tr>
                                                                    <td>
                                                                        {{ $followup->id }}
                                                                    </td>
                                                                    <td>{{ $followup->leadDetails->lead_number }}</td>
                                                                    <td>{{ $followup->leadDetails->customer->first_name }}
                                                                        {{ $followup->leadDetails->customer->last_name }}
                                                                    </td>
                                                                    <td>{{ $followup->leadDetails->customer->phone }}</td>
                                                                    <td>{{ $followup->leadDetails->customer->email }}</td>
                                                                    <td>{{ $followup->followup_date }}</td>
                                                                    <td>{{ $followup->followup_time }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass = match ($followup->status) {
                                                                                'pending' => 'bg-warning-subtle text-warning',
                                                                                'completed' => 'bg-success-subtle text-success',
                                                                                'rescheduled' => 'bg-primary-subtle text-primary',
                                                                                'cancelled' => 'bg-danger-subtle text-danger',
                                                                            };
                                                                        @endphp
                                                                        @php
                                                                            $statusTypes = [
                                                                                'pending' => 'Pending',
                                                                                'completed' => 'Completed',
                                                                                'rescheduled' => 'Rescheduled',
                                                                                'cancelled' => 'Cancelled',
                                                                            ];
                                                                        @endphp
                                                                        <span class="badge fw-semibold {{ $badgeClass }}">
                                                                            {{ $statusTypes[$followup->status] }}
                                                                        </span> 
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('follow-up.view-page', $followup->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            href="{{ route('follow-up.edit', $followup->id) }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form style="display: inline-block"
                                                                            action="{{ route('follow-up.delete', $followup->id) }}"
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

                                </div><!-- end Experience -->

                            </div> <!-- Tab panes -->
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection
