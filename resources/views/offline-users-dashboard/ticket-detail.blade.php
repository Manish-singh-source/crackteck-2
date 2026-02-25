@extends('offline-users-dashboard/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Ticket Details</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('offline-index') }}" class="text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('offline-ticket') }}" class="text-muted">Tickets</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Ticket</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('offline-ticket') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to Tickets
                    </a>
                </div>
            </div>

            <!-- Ticket Details -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">Ticket No:</span>
                                    <span class="fw-semibold ms-2">{{ $amcTicket->ticket_no }}</span>
                                </div>
                                <div>
                                    @php
                                        $statusClass = match($amcTicket->status) {
                                            'pending' => 'bg-danger',
                                            'in_progress' => 'bg-warning',
                                            'resolved' => 'bg-success',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} fs-6">
                                        {{ ucfirst(str_replace('_', ' ', $amcTicket->status)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column - Customer & Service Info -->
                                <div class="col-lg-6">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Customer Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item px-0 d-flex justify-content-between">
                                                    <span class="text-muted">Name:</span>
                                                    <span class="fw-semibold">
                                                        {{ $amcTicket->customer->first_name ?? '' }} {{ $amcTicket->customer->last_name ?? '' }}
                                                    </span>
                                                </li>
                                                <li class="list-group-item px-0 d-flex justify-content-between">
                                                    <span class="text-muted">Email:</span>
                                                    <span>{{ $amcTicket->customer->email ?? 'N/A' }}</span>
                                                </li>
                                                <li class="list-group-item px-0 d-flex justify-content-between">
                                                    <span class="text-muted">Phone:</span>
                                                    <span>{{ $amcTicket->customer->phone ?? 'N/A' }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Ticket Info -->
                                <div class="col-lg-6">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Ticket Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item px-0 d-flex justify-content-between">
                                                    <span class="text-muted">Service ID:</span>
                                                    <span class="fw-semibold">{{ $amcTicket->service_id }}</span>
                                                </li>
                                                <li class="list-group-item px-0 d-flex justify-content-between">
                                                    <span class="text-muted">Priority:</span>
                                                    <span>
                                                        @php
                                                            $priorityClass = match($amcTicket->priority) {
                                                                'high' => 'text-danger',
                                                                'medium' => 'text-warning',
                                                                'low' => 'text-info',
                                                                default => 'text-secondary',
                                                            };
                                                        @endphp
                                                        <span class="{{ $priorityClass }} fw-semibold">
                                                            {{ ucfirst($amcTicket->priority) }}
                                                        </span>
                                                    </span>
                                                </li>
                                                <li class="list-group-item px-0 d-flex justify-content-between">
                                                    <span class="text-muted">Created:</span>
                                                    <span>{{ $amcTicket->created_at->format('Y-m-d h:i A') }}</span>
                                                </li>
                                                <li class="list-group-item px-0 d-flex justify-content-between">
                                                    <span class="text-muted">Last Updated:</span>
                                                    <span>{{ $amcTicket->updated_at->format('Y-m-d h:i A') }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Subject and Description -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Subject</h5>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0 fw-semibold fs-5">{{ $amcTicket->subject }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($amcTicket->description)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Description</h5>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">{{ $amcTicket->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
