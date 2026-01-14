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
                                        {{ ucwords($warehouse->supported_operations) }}
                                    </span>

                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Zone Configuration:</span>
                                    <span>
                                        {{-- Receiving_zone --}}
                                        {{ ucwords(str_replace('_', ' ', $warehouse->zone_conf)) }}
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
                                        <option value="yes"
                                            {{ $warehouse->default_warehouse == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no"
                                            {{ $warehouse->default_warehouse == 'no' ? 'selected' : '' }}>No</option>
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
                                        <option value="pending"
                                            {{ $warehouse->verification_status == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="verified"
                                            {{ $warehouse->verification_status == 'verified' ? 'selected' : '' }}>
                                            Verified
                                        </option>
                                        <option value="rejected"
                                            {{ $warehouse->verification_status == 'rejected' ? 'selected' : '' }}>
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
                                        <option value="active" {{ $warehouse->status == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ $warehouse->status == 'inactive' ? 'selected' : '' }}>Inactive
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
