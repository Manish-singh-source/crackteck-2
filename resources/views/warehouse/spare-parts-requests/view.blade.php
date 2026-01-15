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
                                        {{ $stockRequests->fromEngineer->first_name ?? 'N/A' }}
                                        {{ $stockRequests->fromEngineer->last_name ?? '' }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Service Request ID:
                                    </span>
                                    <span>
                                        <a href="#">
                                            {{ $stockRequests->serviceRequest->request_id ?? 'N/A'  }}
                                        </a>
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Request Date:
                                    </span>
                                    <span>
                                        {{ $stockRequests->serviceRequest->created_at ? $stockRequests->serviceRequest->created_at->format('Y-m-d') : 'N/A' }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Assigned Delivery Man:
                                    </span>
                                    <span>
                                        {{ $stockRequests?->assignedEngineer?->first_name }} {{ $stockRequests?->assignedEngineer?->last_name }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Status:
                                    </span>
                                    <span>
                                        <span
                                            class="badge fw-semibold request-status
                                        @if ($stockRequests->status === 'Pending') bg-danger-subtle text-danger
                                        @elseif($stockRequests->status === 'Approved') bg-success-subtle text-success
                                        @else bg-warning-subtle text-warning @endif">
                                            {{ $stockRequests->status }}
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
                                        @if ($stockRequests->requestedPart->main_product_image)
                                            <img src="{{ asset($stockRequests->requestedPart->main_product_image) }}"
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
                                            <span>{{ $stockRequests->requestedPart->product_name ?? 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Type:</span>
                                            <span>{{ $stockRequests->requestedPart->parent_category_id ? $stockRequests->requestedPart->parentCategorie->name : 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Brand:</span>
                                            <span>{{ $stockRequests->requestedPart->brand_id ? $stockRequests->requestedPart->brand->name : 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Model Number:</span>
                                            <span>{{ $stockRequests->requestedPart->model_no ?? 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Serial Number:</span>
                                            <span>{{ $stockRequests->requestedPart->serial_no ?? 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Quantity Requested:</span>
                                            <span>{{ $stockRequests->quantity }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Reason:</span>
                                            <span>{{ $stockRequests->reason ?? 'N/A' }}</span>
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
                                        {{ $stockRequests->customerServiceRequest->first_name ?? 'N/A' }}
                                        {{ $stockRequests->customerServiceRequest->last_name ?? '' }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Contact no :
                                    </span>
                                    <span>
                                        {{ $stockRequests->customerServiceRequest->phone ?? 'N/A' }}
                                    </span>
                                </li>
                                
                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Email :
                                    </span>
                                    <span>
                                        {{ $stockRequests->customerServiceRequest->email ?? 'N/A' }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Address :
                                    </span>
                                    <span>
                                        {{ $stockRequests->customerServiceRequest->company_address ?? 'N/A' }}
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
                            <form action="#"
                            {{-- <form action="{{ route('spare-parts.assign-delivery-man', $stockRequests->id) }}" --}}
                                method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="approval_status" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $stockRequests->quantity }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="delivery_man_id" class="form-label">Select Delivery Man</label>
                                    <select class="form-select @error('delivery_man_id') is-invalid @enderror"
                                        id="delivery_man_id" name="delivery_man_id" required>
                                        <option value="">-- Select Delivery Man --</option>
                                        @foreach ($deliveryMen as $deliveryMan)
                                            <option value="{{ $deliveryMan->id }}"
                                                @if ($stockRequests->delivery_man_id == $deliveryMan->id) selected @endif>
                                                {{ $deliveryMan->first_name }} {{ $deliveryMan->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('delivery_man_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if ($stockRequests->delivery_man_id)
                                    <div class="alert alert-info mb-3">
                                        <strong>Currently Assigned:</strong>
                                        {{ $stockRequests->deliveryMan->first_name ?? 'N/A' }}
                                        {{ $stockRequests->deliveryMan->last_name ?? '' }}
                                    </div>
                                @endif

                                <div class="mt-3">
                                    <label for="approval_status" class="form-label">Status</label>
                                    <select class="form-select @error('approval_status') is-invalid @enderror"
                                        name="approval_status" id="approval_status">
                                        <option value="Pending" {{ $stockRequests->approval_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Approved" {{ $stockRequests->approval_status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="Rejected" {{ $stockRequests->approval_status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
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
