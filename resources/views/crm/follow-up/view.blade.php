@extends('crm/layouts/master')

@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row pt-3">
            <div class="col-xl-12 mx-auto">

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Follow Up Details
                            </h5>
                            <div>
                                <b>
                                    {{ $followup->lead_id }}
                                </b>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">


                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush ">
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Lead Id :
                                        </span>
                                        <span>
                                            {{ $followup->lead_id }}
                                        </span>
                                    </li>
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Client Name :
                                        </span>
                                        <span>
                                            {{ $followup->client_name }}
                                        </span>
                                    </li>


                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Contact Number :
                                        </span>
                                        <span>
                                            {{ $followup->contact }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Follow Up Date :
                                        </span>
                                        <span>
                                            {{ $followup->followup_date }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Follow-Up Time :
                                        </span>
                                        <span>
                                            {{ $followup->followup_time }}
                                        </span>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush ">
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Email :
                                        </span>
                                        <span>
                                            {{ $followup->email }}
                                        </span>
                                    </li>
 
 
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Remarks :
                                        </span>
                                        <span>
                                            {{ $followup->remarks }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Created By :
                                        </span>
                                        <span>
                                            Admin
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Status :
                                        </span>
                                        @php
                                            $badgeClass = match ($followup->status) {
                                                'Pending' => 'bg-warning-subtle text-warning',
                                                'Done' => 'bg-success-subtle text-success',
                                                'Rescheduled' => 'bg-primary-subtle text-primary',
                                                'Cancelled' => 'bg-danger-subtle text-danger',
                                                default => 'bg-secondary-subtle text-secondary',
                                            };
                                        @endphp
                                        <span class="badge fw-semibold {{ $badgeClass }}">
                                            {{ $followup->status }}
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