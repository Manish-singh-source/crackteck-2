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
                                    Leads Details
                                </h5>
                                <div class="fw-bold text-dark">
                                    #{{ $lead->id }}
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">


                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush ">

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Client Name :
                                            </span>
                                            <span>
                                                {{ $lead->first_name }} {{ $lead->last_name }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Contact no :
                                            </span>
                                            <span>
                                                {{ $lead->phone ?? 'N/A' }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Gender :
                                            </span>
                                            <span>
                                                {{ $lead->gender ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Date of Birth :
                                            </span>
                                            <span>
                                                {{ $lead->dob ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Source :
                                            </span>
                                            <span>
                                                {{ $lead->source ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Budget Range :
                                            </span>
                                            <span>
                                                {{ $lead->budget_range ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Lead Status :
                                            </span>
                                            @php
                                                $badgeClass = match ($lead->status) {
                                                    'New' => 'bg-success-subtle text-success',
                                                    'Contacted' => 'bg-warning-subtle text-warning',
                                                    'Qualified' => 'bg-primary-subtle text-primary',
                                                    'Quoted' => 'bg-info-subtle text-info',
                                                    'Lost' => 'bg-danger-subtle text-danger',
                                                    default => 'bg-secondary-subtle text-secondary',
                                                };
                                            @endphp
                                            <span>
                                                <span class="badge fw-semibold {{ $badgeClass }}">
                                                    {{ $lead->status ?? 'N/A' }}
                                                </span>
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
                                                {{ $lead->email ?? 'N/A' }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Company Name :
                                            </span>
                                            <span>
                                                {{ $lead->company_name ?? 'N/A' }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Designation :
                                            </span>
                                            <span>
                                                {{ $lead->designation ?? 'N/A' }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Industry Type :
                                            </span>
                                            <span>
                                                {{ $lead->industry_type ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Requirement Type :
                                            </span>
                                            <span>
                                                {{ $lead->requirement_type ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Urgency :
                                            </span>
                                            <span>
                                                {{ $lead->urgency ?? 'N/A' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Sales Person :
                                            </span>
                                            <span>
                                                {{ $lead->user->first_name ?? 'N/A' }}
                                            </span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Branch Information Section -->
                    @if($lead->branches && $lead->branches->count() > 0)
                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">
                                Branch Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-borderless dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>Branch Name</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th>Pincode</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lead->branches as $branch)
                                        <tr>
                                            <td>{{ $branch->branch_name }}</td>
                                            <td>
                                                {{ $branch->address_line1 }}
                                                @if($branch->address_line2)
                                                    , {{ $branch->address_line2 }}
                                                @endif
                                            </td>
                                            <td>{{ $branch->city }}</td>
                                            <td>{{ $branch->state }}</td>
                                            <td>{{ $branch->country }}</td>
                                            <td>{{ $branch->pincode }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
                {{-- <div class="col-xl-4 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form class="row g-3">
                                <div class="col-12">
                                    @include('components.form.select', [
                                        'label' => 'Lead Status',
                                        'name' => 'status',
                                        'options' => [
                                            '0' => '--Select Status--',
                                            '1' => 'New',
                                            '2' => 'Contacted',
                                            '3' => 'Qualified',
                                            '4' => 'Quoted',
                                            'Converted',
                                            '5' => 'Lost',
                                        ],
                                    ])
                                </div>
                                <div class="col-12">
                                    @include('components.form.select', [
                                        'label' => 'AMC Type',
                                        'name' => 'amc_type',
                                        'options' => [
                                            '0' => '--Select AMC Type--',
                                            '1' => 'AMC',
                                            '2' => 'Non AMC',
                                        ],
                                    ])
                                </div>
                                <div class="col-12">
                                    @include('components.form.input', [
                                        'label' => 'Reasons',
                                        'name' => 'region',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Reasons',
                                    ])
                                </div>


                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
