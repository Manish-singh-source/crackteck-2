@extends('warehouse/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row pt-3">
                <div class="col-xl-8 mx-auto">

                    {{-- Warehouse Details --}}
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Warehouse Details
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <ul class="list-group list-group-flush ">
                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Id :</span>
                                    <span>{{ $warehouse->warehouse_code }}</span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Name :</span>
                                    <span>{{ $warehouse->name }}</span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Type :</span>
                                    <span>{{ $warehouse->type }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Location Details --}}
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Location Details
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">
                                        Address Line 1 :
                                    </span>
                                    <span>
                                        <span>{{ $warehouse->address1 }}</span><br>
                                    </span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Address Line 2 :</span>
                                    <span>
                                        <span>{{ $warehouse->address2 }}</span>
                                    </span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">City :</span>
                                    <span>{{ $warehouse->city }}</span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">State :</span>
                                    <span>{{ $warehouse->state }}</span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Country :</span>
                                    <span>{{ $warehouse->country }}</span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Pin Code :</span>
                                    <span>{{ $warehouse->pincode }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Contact Details --}}
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Contact Details
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">
                                        Contact Person Name :
                                    </span>
                                    <span>
                                        <span>{{ $warehouse->contact_person_name }}</span><br>
                                    </span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Phone Number:</span>
                                    <span>
                                        <span>{{ $warehouse->phone_number }}</span>
                                    </span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Alternate Phone Number :</span>
                                    <span>{{ $warehouse->alternate_phone_number }}</span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">E-mail Address:</span>
                                    <span>{{ $warehouse->email }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Operational Settings --}}
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Operational Settings
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">
                                        Working Hours :
                                    </span>
                                    <span>
                                        <span>{{ $warehouse->working_hours }}</span>
                                    </span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Working Days:</span>
                                    <span>
                                        <span>{{ $warehouse->working_days }}</span>
                                    </span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Maximum Storage Capacity :</span>
                                    <span>{{ $warehouse->max_store_capacity }}</span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Supported Operations:</span>
                                    <span>
                                        @switch($warehouse->supported_operations)
                                            @case(0)
                                                Inbound
                                            @break

                                            @case(1)
                                                Outbound
                                            @break

                                            @case(2)
                                                Returns
                                            @break

                                            @case(3)
                                                QC
                                            @break

                                            @default
                                                Unknown
                                        @endswitch
                                    </span>

                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Zone Configuration:</span>
                                    <span>
                                        @switch($warehouse->zone_conf)
                                            @case(0)
                                                Receiving Zone
                                            @break

                                            @case(1)
                                                Pick Zone
                                            @break

                                            @case(2)
                                                Cold Storage
                                            @break

                                            @default
                                                Unknown
                                        @endswitch
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN --}}
                <div class="col-xl-4">

                    {{-- Legal/Compliance --}}
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Legal/Compliance
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">
                                        GST Number/Tax ID :
                                    </span>
                                    <span>
                                        <span>{{ $warehouse->gst_no }}</span>
                                    </span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Licence/Permit Number:</span>
                                    <span>
                                        <span>{{ $warehouse->licence_no }}</span>
                                    </span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Upload Licence Document:</span>
                                    <span>
                                        <span><a class="btn btn-primary btn-sm" href="{{ asset($warehouse->licence_doc) }}">View</a></span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Status forms --}}
                    <form action="{{ route('warehouse.updateStatus', $warehouse->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="d-flex">
                                    <h5 class="card-title flex-grow-1 mb-0">
                                        Default Warehouse
                                    </h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <div>
                                    <select required name="default_warehouse" class="form-select w-100">
                                        <option value="" selected disabled>---- Select ----</option>
                                        <option value="1"
                                            {{ $warehouse->default_warehouse == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0"
                                            {{ $warehouse->default_warehouse == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="d-flex">
                                    <h5 class="card-title flex-grow-1 mb-0">
                                        Verification Status
                                    </h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <div>
                                    <select required name="verification_status" class="form-select w-100">
                                        <option value="" selected disabled>---- Select ----</option>
                                        <option value="0"
                                            {{ $warehouse->verification_status == 0 ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="1"
                                            {{ $warehouse->verification_status == 1 ? 'selected' : '' }}>
                                            Verified
                                        </option>
                                        <option value="2"
                                            {{ $warehouse->verification_status == 2 ? 'selected' : '' }}>
                                            Rejected
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="d-flex">
                                    <h5 class="card-title flex-grow-1 mb-0">
                                        Status
                                    </h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <div>
                                    <select required name="status" class="form-select w-100">
                                        <option value="" selected disabled>---- Select ----</option>
                                        <option value="1" {{ $warehouse->status == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $warehouse->status == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-end pb-3">
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
