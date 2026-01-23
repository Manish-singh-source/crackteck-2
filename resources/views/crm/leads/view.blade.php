@extends('crm/layouts/master')

@section('content')
    <style>
        #popupOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        #popupOverlay img {
            max-width: 90%;
            max-height: 90%;
            box-shadow: 0 0 10px #fff;
        }

        #popupOverlay .closeBtn {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 30px;
            color: white;
            cursor: pointer;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
    <div class="content">
        <div class="container-fluid">

            <div class="row pt-3">
                <div class="col mx-auto">

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Customer Details
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush ">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Customer Code :
                                            </span>
                                            <span>
                                                {{ $lead->customer->customer_code }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Customer Name :
                                            </span>
                                            <span>
                                                {{ $lead->customer->first_name }} {{ $lead->customer->last_name }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Contact No :
                                            </span>
                                            <span>
                                                {{ $lead->customer->phone }}
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
                                                {{ $lead->customer->email }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Gender :
                                            </span>
                                            <span>
                                                {{ $lead->customer->gender }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Date of Birth :
                                            </span>
                                            <span>
                                                {{ $lead->customer->dob }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Address/Branch Details
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush ">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Branch Name :
                                            </span>
                                            <span>
                                                {{ $lead->customerAddress->branch_name ?? 'N/A' }}
                                            </span>
                                        </li>
                                        
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Address Line 2 :
                                            </span>
                                            <span>
                                                {{ $lead->customerAddress->address2 ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">State :
                                            </span>
                                            <span>
                                                {{ $lead->customerAddress->state ?? 'N/A' }}
                                            </span>
                                        </li>                                        
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush ">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Address Line 1 :
                                            </span>
                                            <span>
                                                {{ $lead->customerAddress->address1 ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">City :
                                            </span>
                                            <span>
                                                {{ $lead->customerAddress->city ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Pincode :
                                            </span>
                                            <span>
                                                {{ $lead->customerAddress->pincode ?? 'N/A' }}
                                            </span>
                                        </li>
                                         
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Lead Details
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                {{-- lead_number
                                requirement_type
                                budget_range
                                urgency
                                status
                                estimated_value
                                notes --}}

                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush ">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Lead Number :
                                            </span>
                                            <span>
                                                {{ $lead->lead_number }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Requirement Type :
                                            </span>
                                            <span>
                                                {{ $lead->requirement_type }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Budget Range :
                                            </span>
                                            <span>
                                                {{ $lead->budget_range }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Notes :
                                            </span>
                                            <span>
                                                {{ $lead->notes }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush ">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Urgency :
                                            </span>
                                            @php
                                                $urgencyTypes = [
                                                    'low' => 'Low',
                                                    'medium' => 'Medium',
                                                    'high' => 'High',
                                                ];
                                            @endphp
                                            @php
                                                $badgeClass = match ($lead->urgency) {
                                                    'low' => 'bg-success-subtle text-success',
                                                    'medium' => 'bg-warning-subtle text-warning',
                                                    'high' => 'bg-danger-subtle text-danger',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} fw-semibold">
                                                {{ $urgencyTypes[$lead->urgency] }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Status :
                                            </span>
                                            @php
                                                $statusTypes = [
                                                    'new' => 'New',
                                                    'contacted' => 'Contacted',
                                                    'qualified' => 'Qualified',
                                                    'proposal' => 'Proposal',
                                                    'won' => 'Won',
                                                    'lost' => 'Lost',
                                                    'nurture' => 'Nurtured',
                                                ];
                                            @endphp
                                            @php
                                                $badgeClass = match ($lead->status) {
                                                    'new' => 'bg-success-subtle text-success',
                                                    'contacted' => 'bg-warning-subtle text-warning',
                                                    'qualified' => 'bg-primary-subtle text-primary',
                                                    'proposal' => 'bg-info-subtle text-info',
                                                    'won' => 'bg-success-subtle text-success',
                                                    'lost' => 'bg-danger-subtle text-danger',
                                                    'nurture' => 'bg-secondary-subtle text-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} fw-semibold">
                                                {{ $statusTypes[$lead->status] }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Estimated Value :
                                            </span>
                                            <span>
                                                {{ $lead->estimated_value }}
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
    </div>
@endsection
