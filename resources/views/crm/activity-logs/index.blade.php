@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Activity Logs</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">                        
                        <div class="card-body pt-0">
                            <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active p-2" id="all_customer_tab" data-bs-toggle="tab"
                                        href="#all_customer" role="tab">
                                        <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                        <span class="d-none d-sm-block">All Logs</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content text-muted">
                                <div class="tab-pane active show pt-4" id="all_customer" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="activity-logs-table"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>User</th>
                                                                <th>Role</th>
                                                                <th>Action (CRUD)</th>
                                                                <th>Description</th>
                                                                <th>Changes</th>
                                                                <th>Date & Time</th>
                                                                <th>IP Address</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($activities as $activity)
                                                                <tr>
                                                                    <td>
                                                                        @if ($activity->causer)
                                                                            {{ $activity->causer->name ?? ($activity->causer->email ?? 'N/A') }}
                                                                        @else
                                                                            System
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{-- @if ($activity->causer && $activity->causer->getRoleNames())
                                                                            {{ $activity->causer->getRoleNames() }}
                                                                        @else
                                                                            N/A
                                                                        @endif --}}
                                                                        N/A
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge
                                                                            @if ($activity->event == 'created') bg-success
                                                                            @elseif($activity->event == 'updated') bg-primary
                                                                            @elseif($activity->event == 'deleted') bg-danger
                                                                            @else bg-secondary @endif"
                                                                        >
                                                                            {{ ucfirst($activity->event) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        {{ $activity->description }}
                                                                    </td>
                                                                    <td>
                                                                        @if ($activity->changes())
                                                                            <pre>{{ json_encode($activity->changes(), JSON_PRETTY_PRINT) }}</pre>
                                                                        @else
                                                                            No changes
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $activity->created_at->format('Y-m-d h:i A') }}
                                                                    </td>
                                                                    <td>{{ $activity->properties['ip'] ?? request()->ip() }}
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7" class="text-center">No activity
                                                                        logs found.</td>
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
            </div>
        </div> 
    </div> 
@endsection
