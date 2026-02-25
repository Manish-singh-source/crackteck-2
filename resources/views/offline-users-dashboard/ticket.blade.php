@extends('offline-users-dashboard/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">My Tickets</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('offline-index') }}" class="text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tickets</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Tickets Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            @if($amcTickets->isEmpty())
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-ticket-alt fs-48 text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">No tickets found</h5>
                                    <p class="text-muted">You haven't raised any support tickets yet.</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover table-centered table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Ticket No</th>
                                                <th>Service ID</th>
                                                <th>Subject</th>
                                                <th>Priority</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($amcTickets as $ticket)
                                                <tr>
                                                    <td>
                                                        <div>{{ $ticket->created_at->format('Y-m-d') }}</div>
                                                        <small class="text-muted">{{ $ticket->created_at->format('h:i A') }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="fw-semibold">{{ $ticket->ticket_no }}</span>
                                                    </td>
                                                    <td>{{ $ticket->service_id }}</td>
                                                    <td>
                                                        <span class="text-truncate" style="max-width: 200px; display: block;">
                                                            {{ $ticket->subject }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $priorityClass = match($ticket->priority) {
                                                                'high' => 'bg-danger',
                                                                'medium' => 'bg-warning',
                                                                'low' => 'bg-info',
                                                                default => 'bg-secondary',
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $priorityClass }}">
                                                            {{ ucfirst($ticket->priority) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusClass = match($ticket->status) {
                                                                'pending' => 'bg-danger',
                                                                'in_progress' => 'bg-warning',
                                                                'resolved' => 'bg-success',
                                                                default => 'bg-secondary',
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $statusClass }}">
                                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('offline-ticket-view', $ticket->id) }}" 
                                                           class="btn btn-sm btn-primary">
                                                            <i class="fas fa-eye me-1"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
