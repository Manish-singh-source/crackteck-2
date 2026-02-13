@extends('crm/layouts/master')

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
                                        {{ $stockRequests->engineer->first_name ?? 'N/A' }}
                                        {{ $stockRequests->engineer->last_name ?? '' }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Service Request ID:
                                    </span>
                                    <span>
                                        <a href="#">
                                            {{ $stockRequests->serviceRequest->request_id ?? 'N/A' }}
                                        </a>
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Request Date:
                                    </span>
                                    <span>
                                        {{ $stockRequests->created_at->format('d M Y') ?? 'N/A' }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Assigned Person Type:
                                    </span>
                                    <span>
                                        {{ $stockRequests?->assigned_person_type ? ucwords(str_replace('_', ' ', $stockRequests->assigned_person_type)) : 'N/A' }}
                                    </span>
                                </li>
                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Assigned Person Name:
                                    </span>
                                    <span>
                                        {{ $stockRequests?->assignedEngineer?->first_name }}
                                        {{ $stockRequests?->assignedEngineer?->last_name }}
                                    </span>
                                </li>
                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Request Type:
                                    </span>
                                    <span>
                                        {{ $stockRequests?->request_type ? ucwords(str_replace('_', ' ', $stockRequests->request_type)) : 'N/A' }}
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
                                            {{ ucwords(str_replace('_', ' ', $stockRequests->status)) ?? 'N/A' }}
                                        </span>
                                    </span>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <!-- Product Details -->
                    @if ($stockRequests->serviceRequestProduct)
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Product Details</h5>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Product Details</th>
                                                <th>Service Details</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if (optional($stockRequests->product)->main_product_image)
                                                            <img src="{{ asset($stockRequests->product->main_product_image) }}"
                                                                alt="{{ $stockRequests->product->product_name }}"
                                                                width="100" height="40"
                                                                class="img-fluid rounded me-2">
                                                        @else
                                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-2"
                                                                style="width: 40px; height: 40px;">
                                                                <i class="mdi mdi-package-variant text-muted"></i>
                                                            </div>
                                                        @endif

                                                        <div>
                                                            <div class="fw-semibold">
                                                                {{ $stockRequests->serviceRequestProduct->name }}
                                                            </div>
                                                            <div class="text-muted small">
                                                                SKU: {{ optional($stockRequests->product)->sku }}
                                                            </div>
                                                            <div class="text-muted small">
                                                                HSN: {{ optional($stockRequests->product)->hsn }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div>
                                                        <div class="fw-semibold">
                                                            Type: {{ $stockRequests->serviceRequestProduct->type }}
                                                        </div>
                                                        <div class="fw-semibold">
                                                            Model No: {{ $stockRequests->serviceRequestProduct->model_no }}
                                                        </div>
                                                        <div class="fw-semibold">
                                                            Brand: {{ $stockRequests->serviceRequestProduct->brand }}
                                                        </div>
                                                        <div class="fw-semibold">
                                                            Purchase Date:
                                                            {{ $stockRequests->serviceRequestProduct->purchase_date }}
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div>
                                                        <div class="fw-semibold">
                                                            Service Code:
                                                            {{ optional($stockRequests->serviceRequestProduct->itemCode)->item_code }}
                                                        </div>
                                                        <div class="fw-semibold">
                                                            Service Type:
                                                            {{ optional($stockRequests->serviceRequestProduct->itemCode)->service_type }}
                                                        </div>
                                                        <div class="fw-semibold">
                                                            Service Name:
                                                            {{ optional($stockRequests->serviceRequestProduct->itemCode)->service_name }}
                                                        </div>
                                                        <div class="fw-semibold">
                                                            Service Charge:
                                                            {{ optional($stockRequests->serviceRequestProduct->itemCode)->service_charge }}
                                                        </div>
                                                        <div class="fw-semibold">
                                                            Diagnosis List:
                                                            {{ implode(', ', optional($stockRequests->serviceRequestProduct->itemCode)->diagnosis_list ?? []) }}
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Product Details</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-0">
                                    No product details available for this spare part request.
                                </p>
                            </div>
                        </div>
                    @endif



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
                                        @if ($stockRequests->requestedPart?->product?->main_product_image)
                                            <img src="{{ asset($stockRequests->requestedPart->product->main_product_image) }}"
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
                                            <span class="fw-semibold">Product Id:</span>
                                            <span>{{ $stockRequests->product->id ?? 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Product Name:</span>
                                            <span>{{ $stockRequests->product->product_name ?? 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Brand:</span>
                                            <span>{{ $stockRequests->product->brand->name ?? 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Model No:</span>
                                            <span>{{ $stockRequests->product?->model_no ?? 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">HSN Code:</span>
                                            <span>{{ $stockRequests->product?->hsn_code ?? 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">SKU Code:</span>
                                            <span>{{ $stockRequests->product?->sku ?? 'N/A' }}</span>
                                        </li>
                                        @if ($stockRequests->requestedPart?->manual_serial)
                                            <li
                                                class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                <span class="fw-semibold">Serial Number:</span>
                                                <span>{{ $stockRequests->requestedPart->manual_serial ?? 'N/A' }}</span>
                                            </li>
                                        @endif
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Quantity Requested:</span>
                                            <span>{{ $stockRequests->requested_quantity ?? 'N/A' }}</span>
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
                                        {{ $stockRequests->serviceRequest->customer->first_name ?? 'N/A' }}
                                        {{ $stockRequests->serviceRequest->customer->last_name ?? '' }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Contact no :
                                    </span>
                                    <span>
                                        {{ $stockRequests->serviceRequest->customer->phone ?? 'N/A' }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Email :
                                    </span>
                                    <span>
                                        {{ $stockRequests->serviceRequest->customer->email ?? 'N/A' }}
                                    </span>
                                </li>

                                <li
                                    class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Address :
                                    </span>
                                    <span>
                                        {{ $stockRequests->serviceRequest->customer->primaryAddress->address1 ?? 'N/A' }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Warehouse Approval/Rejection Section -->
                    <div class="card mt-3">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Warehouse Approval
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (in_array($stockRequests->status, ['warehouse_approved', 'warehouse_rejected', 'picked']))
                                <div class="text-center">
                                    <div class="mb-2">
                                        @if ($stockRequests->status === 'warehouse_approved' || $stockRequests->status === 'picked')
                                            <span class="badge bg-success-subtle text-success fs-5 px-3 py-2">
                                                <i class="mdi mdi-check-circle me-1"></i>Warehouse Approved
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger fs-5 px-3 py-2">
                                                <i class="mdi mdi-close-circle me-1"></i>Warehouse Rejected
                                            </span>
                                        @endif
                                    </div>
                                    @if ($stockRequests->warehouse_approved_at)
                                        <small class="text-muted d-block">Approved on: {{ $stockRequests->warehouse_approved_at }}</small>
                                    @elseif ($stockRequests->warehouse_rejected_at)
                                        <small class="text-muted d-block">Rejected on: {{ $stockRequests->warehouse_rejected_at }}</small>
                                    @endif
                                </div>
                            @else
                                <form action="{{ route('spare-parts.warehouse-approval', $stockRequests->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="warehouse_status" class="form-label">Select Action</label>
                                        <select class="form-select @error('warehouse_status') is-invalid @enderror"
                                            id="warehouse_status" name="warehouse_status" required>
                                            <option value="" selected disabled>-- Select Action --</option>
                                            <option value="warehouse_approved">Approve</option>
                                            <option value="warehouse_rejected">Reject</option>
                                        </select>
                                        @error('warehouse_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 mt-3">
                                        <i class="mdi mdi-check-circle me-2"></i>Submit
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Picked by Engineer Section -->
                    @if ($stockRequests->request_type === 'stock_in_hand' && in_array($stockRequests->status, ['warehouse_approved', 'picked']))
                        <div class="card mt-3">
                            <div class="card-header border-bottom-dashed">
                                <div class="d-flex">
                                    <h5 class="card-title flex-grow-1 mb-0">
                                        Picked by Engineer
                                    </h5>
                                </div>
                            </div>

                            <div class="card-body">
                                @if ($stockRequests->status === 'picked')
                                    <div class="text-center">
                                        <div class="mb-2">
                                            <span class="badge bg-success-subtle text-success fs-5 px-3 py-2">
                                                <i class="mdi mdi-check-circle me-1"></i>Picked
                                            </span>
                                        </div>
                                        @if ($stockRequests->picked_at)
                                            <small class="text-muted d-block">Picked on: {{ $stockRequests->picked_at }}</small>
                                        @endif
                                    </div>
                                @else
                                    <form action="{{ route('spare-parts.picked', $stockRequests->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <p class="text-muted">Mark this product as picked by the engineer from warehouse.</p>
                                        </div>

                                        <button type="submit" class="btn btn-success w-100 mt-3">
                                            <i class="mdi mdi-package-variant-closed me-2"></i>Mark as Picked
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div> <!-- content -->


    <script>
        $(document).ready(function() {
            var assignedPersonType = '{{ $stockRequests->assigned_person_type }}';
            if (assignedPersonType === 'engineer') {
                $('#engineerSection').show();
                $('#deliveryManSection').hide();
            } else if (assignedPersonType === 'delivery_man') {
                $('#deliveryManSection').show();
                $('#engineerSection').hide();
            }

            $('#assigned_person_type').on('change', function() {
                var selectedValue = $(this).val();

                if (selectedValue === 'engineer') {
                    $('#deliveryManSection').hide();
                    $('#engineerSection').show();
                    $('#assigned_person_id').prop('required', true);
                } else if (selectedValue === 'delivery_man') {
                    $('#engineerSection').hide();
                    $('#deliveryManSection').show();
                    $('#assigned_person_id').prop('required', true);
                } else {
                    $('#engineerSection').hide();
                    $('#deliveryManSection').hide();
                    $('#assigned_person_id').prop('required', false);
                }
            });
        });
    </script>
@endsection
