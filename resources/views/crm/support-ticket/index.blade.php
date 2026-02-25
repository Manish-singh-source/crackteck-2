@extends('crm/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Ticket List</h4>
            </div>
        </div>


        <div class="row">

            <div class="col-12">
                <div class="card">
                    
                    <div class="card-body pt-0">
                        <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active p-2" id="all_tickets_tab" data-bs-toggle="tab"
                                    href="#all_tickets" role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-information"></i></span>
                                    <span class="d-none d-sm-block">All Tickets</span>
                                </a>
                            </li>
                            <!-- 
                            <li class="nav-item">
                                <a class="nav-link p-2" id="running_tickets_tab" data-bs-toggle="tab" href="#running_tickets"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Running Tickets</span>
                                </a>
                            </li> 
                            <li class="nav-item">
                                <a class="nav-link p-2" id="answered_tickets_tab" data-bs-toggle="tab"
                                    href="#answered_tickets" role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-sitemap-outline"></i></span>
                                    <span class="d-none d-sm-block">Answered Tickets</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="replied_tickets_tab" data-bs-toggle="tab"
                                    href="#replied_tickets" role="tab">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-school"></i></span>
                                    <span class="d-none d-sm-block">Replied Tickets</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2" id="closed_tickets_tab" data-bs-toggle="tab"
                                    href="#closed_tickets" role="tab">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-school"></i></span>
                                    <span class="d-none d-sm-block">Closed Tickets</span>
                                </a>
                            </li> -->
                        </ul>

                        <div class="tab-content text-muted">

                            <div class="tab-pane active show" id="all_tickets" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>Ticket No</th>
                                                            <th>Customer</th>
                                                            <th>Service ID</th>
                                                            <th>Subject</th>
                                                            <th>Priority</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($amcTickets as $ticket)
                                                            <tr>
                                                                <td>
                                                                    <div>{{ $ticket->created_at->diffForHumans() }}</div>
                                                                    <div>{{ $ticket->created_at->format('Y-m-d h:i A') }}</div>
                                                                </td>
                                                                <td>
                                                                    <a href="#">
                                                                        {{ $ticket->ticket_no }}
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <div>
                                                                        {{ $ticket->customer->first_name ?? '' }} {{ $ticket->customer->last_name ?? '' }}
                                                                    </div>
                                                                    <div class="badge bg-primary-subtle text-primary fw-semibold">
                                                                        Customer
                                                                    </div>
                                                                </td>
                                                                <td>{{ $ticket->service_id }}</td>
                                                                <td>{{ $ticket->subject }}</td>
                                                                <td>
                                                                    @php
                                                                        $priorityClass = match($ticket->priority) {
                                                                            'high' => 'bg-danger-subtle text-danger',
                                                                            'medium' => 'bg-warning-subtle text-warning',
                                                                            'low' => 'bg-info-subtle text-info',
                                                                            default => 'bg-secondary-subtle text-secondary',
                                                                        };
                                                                    @endphp
                                                                    <div class="badge {{ $priorityClass }} fw-semibold">
                                                                        {{ ucfirst($ticket->priority) }}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $statusClass = match($ticket->status) {
                                                                            'pending' => 'bg-danger-subtle text-danger',
                                                                            'in_progress' => 'bg-warning-subtle text-warning',
                                                                            'resolved' => 'bg-success-subtle text-success',
                                                                            default => 'bg-secondary-subtle text-secondary',
                                                                        };
                                                                    @endphp
                                                                    <div class="badge {{ $statusClass }} fw-semibold">
                                                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-2">
                                                                        <a aria-label="anchor" href="{{ route('amcs-request.view', $ticket->amc_id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                            <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        {{-- <a aria-label="anchor"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                            data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                        </a> --}}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8" class="text-center">No tickets found</td>
                                                            </tr>
                                                        @endforelse
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