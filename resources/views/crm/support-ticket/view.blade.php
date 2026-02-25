@extends('crm/layouts/master')

@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12 mx-auto my-3">
                <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Ticket Details
                                </h5>
                                <a href="{{ route('support-ticket.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="mdi mdi-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush ">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Ticket No :
                                            </span>
                                            <span>
                                                {{ $amcTicket->ticket_no }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Customer Name :
                                            </span>
                                            <span>
                                                {{ $amcTicket->customer->first_name ?? '' }} {{ $amcTicket->customer->last_name ?? '' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Contact No :
                                            </span>
                                            <span>
                                                {{ $amcTicket->customer->phone ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Email :
                                            </span>
                                            <span>
                                                {{ $amcTicket->customer->email ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Description :
                                            </span>
                                            <span>
                                                {{ $amcTicket->description ?? 'N/A' }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush ">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Service ID :
                                            </span>
                                            <span>
                                                {{ $amcTicket->service_id }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Subject :
                                            </span>
                                            <span>
                                                {{ $amcTicket->subject }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Priority :
                                            </span>
                                            <span>
                                                @php
                                                    $priorityClass = match($amcTicket->priority) {
                                                        'high' => 'bg-danger-subtle text-danger',
                                                        'medium' => 'bg-warning-subtle text-warning',
                                                        'low' => 'bg-info-subtle text-info',
                                                        default => 'bg-secondary-subtle text-secondary',
                                                    };
                                                @endphp
                                                <span class="badge {{ $priorityClass }} fw-semibold">
                                                    {{ ucfirst($amcTicket->priority) }}
                                                </span>
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Status :
                                            </span>
                                            <span>
                                                @php
                                                    $statusClass = match($amcTicket->status) {
                                                        'pending' => 'bg-danger-subtle text-danger',
                                                        'in_progress' => 'bg-warning-subtle text-warning',
                                                        'resolved' => 'bg-success-subtle text-success',
                                                        default => 'bg-secondary-subtle text-secondary',
                                                    };
                                                @endphp
                                                <span class="badge {{ $statusClass }} fw-semibold">
                                                    {{ ucfirst(str_replace('_', ' ', $amcTicket->status)) }}
                                                </span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
            </div>

        </div>

    </div>
</div> <!-- content -->

@endsection