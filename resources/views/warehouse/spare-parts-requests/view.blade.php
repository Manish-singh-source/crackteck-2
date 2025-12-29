@extends('warehouse/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row pt-3">
                <div class="col-xl-8 mx-auto">

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Spare Part Request
                                </h5>

                            </div>
                        </div>

                        <div class="card-body">
                            <ul class="list-group list-group-flush ">

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">From Engineer :
                                    </span>
                                    <span>
                                        {{ $sparePartRequest->engineer->first_name ?? 'N/A' }}
                                        {{ $sparePartRequest->engineer->last_name ?? '' }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Service Request ID:
                                    </span>
                                    <span>
                                        <a href="#">
                                            {{ $sparePartRequest->service_request_id ?? '#' . $sparePartRequest->id }}
                                        </a>
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Request Date:
                                    </span>
                                    <span>
                                        {{ $sparePartRequest->request_date->format('d-m-Y') }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Assigned Delivery Man:
                                    </span>
                                    <span>
                                        {{ $sparePartRequest->deliveryMan->first_name }} {{ $sparePartRequest->deliveryMan->last_name }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Status:
                                    </span>
                                    <span>
                                        <span
                                            class="badge fw-semibold request-status
                                        @if ($sparePartRequest->approval_status === 'Pending') bg-danger-subtle text-danger
                                        @elseif($sparePartRequest->approval_status === 'Approved') bg-success-subtle text-success
                                        @else bg-warning-subtle text-warning @endif">
                                            {{ $sparePartRequest->approval_status }}
                                        </span>
                                    </span>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Spare Part Details
                                </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        @if ($sparePartRequest->product->main_product_image)
                                            <img src="{{ asset($sparePartRequest->product->main_product_image) }}"
                                                alt="Product" width="150px" class="img-fluid d-block rounded">
                                        @else
                                            <img src="https://placehold.co/150x150" alt="Product" width="150px"
                                                class="img-fluid d-block rounded">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <ul class="list-group list-group-flush">
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Product Name:</span>
                                            <span>{{ $sparePartRequest->product->product_name ?? 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Type:</span>
                                            <span>{{ $sparePartRequest->product->parent_category_id ? $sparePartRequest->product->parentCategorie->parent_categories ?? 'N/A' : 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Brand:</span>
                                            <span>{{ $sparePartRequest->product->brand_id ? $sparePartRequest->product->brand->brand_title ?? 'N/A' : 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Model Number:</span>
                                            <span>{{ $sparePartRequest->product->model_no ?? 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Serial Number:</span>
                                            <span>{{ $sparePartRequest->product->serial_no ?? 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Quantity Requested:</span>
                                            <span>{{ $sparePartRequest->quantity }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Reason:</span>
                                            <span>{{ $sparePartRequest->reason ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="col-xl-4">




                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Customer Details
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <ul class="list-group list-group-flush ">

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Customer Name :
                                    </span>
                                    <span>
                                        {{ $sparePartRequest->customerServiceRequest->first_name ?? 'N/A' }}
                                        {{ $sparePartRequest->customerServiceRequest->last_name ?? '' }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Contact no :
                                    </span>
                                    <span>
                                        {{ $sparePartRequest->customerServiceRequest->phone ?? 'N/A' }}
                                    </span>
                                </li>
                                
                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Email :
                                    </span>
                                    <span>
                                        {{ $sparePartRequest->customerServiceRequest->email ?? 'N/A' }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Address :
                                    </span>
                                    <span>
                                        {{ $sparePartRequest->customerServiceRequest->company_address ?? 'N/A' }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Assign Delivery Man
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('spare-parts.assign-delivery-man', $sparePartRequest->id) }}"
                                method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="approval_status" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $sparePartRequest->quantity }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="delivery_man_id" class="form-label">Select Delivery Man</label>
                                    <select class="form-select @error('delivery_man_id') is-invalid @enderror"
                                        id="delivery_man_id" name="delivery_man_id" required>
                                        <option value="">-- Select Delivery Man --</option>
                                        @foreach ($deliveryMen as $deliveryMan)
                                            <option value="{{ $deliveryMan->id }}"
                                                @if ($sparePartRequest->delivery_man_id == $deliveryMan->id) selected @endif>
                                                {{ $deliveryMan->first_name }} {{ $deliveryMan->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('delivery_man_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if ($sparePartRequest->delivery_man_id)
                                    <div class="alert alert-info mb-3">
                                        <strong>Currently Assigned:</strong>
                                        {{ $sparePartRequest->deliveryMan->first_name ?? 'N/A' }}
                                        {{ $sparePartRequest->deliveryMan->last_name ?? '' }}
                                    </div>
                                @endif

                                <div class="mt-3">
                                    <label for="approval_status" class="form-label">Status</label>
                                    <select class="form-select @error('approval_status') is-invalid @enderror"
                                        name="approval_status" id="approval_status">
                                        <option value="Pending" {{ $sparePartRequest->approval_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Approved" {{ $sparePartRequest->approval_status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="Rejected" {{ $sparePartRequest->approval_status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mt-3">
                                    <i class="mdi mdi-check-circle me-2"></i>Update
                                </button>   
                            </form>
                        </div>

                    </div>
 
                </div>
            </div>

        </div>
    </div> <!-- content -->


@endsection
