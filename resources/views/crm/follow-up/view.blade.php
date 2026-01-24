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
                                        {{ $followup->id }}
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
                                                {{ $followup->leadDetails->lead_number }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Client Name :
                                            </span>
                                            <span>
                                                {{ $followup->leadDetails->customer->first_name }}
                                                {{ $followup->leadDetails->customer->last_name }}
                                            </span>
                                        </li>


                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Contact Number :
                                            </span>
                                            <span>
                                                {{ $followup->leadDetails->customer->phone }}
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
                                                {{ $followup->leadDetails->customer->email }}
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
                                            <span class="fw-semibold text-break">Sales Person Name :
                                            </span>
                                            <span>
                                                {{ $followup->staffDetails->first_name }} {{ $followup->staffDetails->last_name }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Status :
                                            </span>
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
