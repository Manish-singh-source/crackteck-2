@extends('warehouse/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Vendor Details</h4>
                </div>
                <div class="mt-2 mt-sm-0">
                    <a href="{{ route('vendor_list.index') }}" class="btn btn-secondary me-2">Back to List</a>
                    <a href="{{ route('vendor_list.edit', $vendor->id) }}" class="btn btn-primary">Edit Vendor</a>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">Vendor Information</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">First Name :</span>
                                    <span>{{ $vendor->first_name ?? 'N/A' }}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Last Name :</span>
                                    <span>{{ $vendor->last_name ?? 'N/A' }}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Phone Number :</span>
                                    <span>{{ $vendor->phone ?? 'N/A' }}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Email :</span>
                                    <span>{{ $vendor->email ?? 'N/A' }}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">GST Number :</span>
                                    <span>{{ $vendor->gst_no ?? 'N/A' }}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">PAN Number :</span>
                                    <span>{{ $vendor->pan_no ?? 'N/A' }}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Status :</span>
                                    <span>{{ ucfirst($vendor->status ?? 'N/A') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">Address Details</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Address 1 :</span>
                                    <span>{{ $vendor->address1 ?? 'N/A' }}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Address 2 :</span>
                                    <span>{{ $vendor->address2 ?? 'N/A' }}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">City :</span>
                                    <span>{{ $vendor->city ?? 'N/A' }}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">State :</span>
                                    <span>{{ $vendor->state ?? 'N/A' }}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Country :</span>
                                    <span>{{ $vendor->country ?? 'N/A' }}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Pincode :</span>
                                    <span>{{ $vendor->pincode ?? 'N/A' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
