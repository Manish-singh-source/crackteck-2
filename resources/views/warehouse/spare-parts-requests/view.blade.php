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
                                            {{ $stockRequests->serviceRequest->request_id ?? 'N/A' }}
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
                                        {{ $stockRequests?->assignedEngineer?->first_name }}
                                        {{ $stockRequests?->assignedEngineer?->last_name }}
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
                                            {{-- <th>Type</th>
                                            <th>Model No</th>
                                            <th>Brand</th>
                                            <th>Purchase Date</th> --}}
                                            <th>Product Details</th>
                                            <th>Service Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($stockRequests->product->main_product_image)
                                                        <img src="{{ asset($stockRequests->product->main_product_image) }}"
                                                            alt="{{ $stockRequests->product->product_name }}" width="100"
                                                            height="40" class="img-fluid rounded me-2">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-2"
                                                            style="width: 40px; height: 40px;">
                                                            <i class="mdi mdi-package-variant text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="fw-semibold">
                                                            {{ $stockRequests->serviceRequestProduct->name }}</div>
                                                        <div class="text-muted small">SKU:
                                                            {{ $stockRequests->product->sku }}</div>
                                                        <div class="text-muted small">HSN:
                                                            {{ $stockRequests->product->hsn }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- <td>
                                                <div class="fw-semibold">{{ $stockRequests->serviceRequestProduct->type }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">
                                                    {{ $stockRequests->serviceRequestProduct->model_no }}</div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $stockRequests->serviceRequestProduct->brand }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">
                                                    {{ $stockRequests->serviceRequestProduct->purchase_date }}</div>
                                            </td> --}}
                                            <td>
                                                <div>
                                                    <div class="fw-semibold">Type:
                                                        {{ $stockRequests->serviceRequestProduct->type }}
                                                    </div>
                                                    <div class="fw-semibold">Model No:
                                                        {{ $stockRequests->serviceRequestProduct->model_no }}
                                                    </div>
                                                    <div class="fw-semibold">Brand:
                                                        {{ $stockRequests->serviceRequestProduct->brand }}
                                                    </div>
                                                    <div class="fw-semibold">Purchase Date:
                                                        {{ $stockRequests->serviceRequestProduct->purchase_date }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-semibold">Service Code:
                                                        {{ $stockRequests->serviceRequestProduct->itemCode->item_code }}
                                                    </div>
                                                    <div class="fw-semibold">Service Type:
                                                        {{ $stockRequests->serviceRequestProduct->itemCode->service_type }}
                                                    </div>
                                                    <div class="fw-semibold">Service Name:
                                                        {{ $stockRequests->serviceRequestProduct->itemCode->service_name }}
                                                    </div>
                                                    <div class="fw-semibold">Service Charge:
                                                        {{ $stockRequests->serviceRequestProduct->itemCode->service_charge }}
                                                    </div>
                                                    <div class="fw-semibold">Diagnosis List:
                                                        {{ implode(', ', $stockRequests->serviceRequestProduct->itemCode->diagnosis_list) }}
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Assign Delivery Man
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('spare-parts.assign-person', $stockRequests->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="approval_status" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity"
                                        value="{{ $stockRequests->requested_quantity }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="approval_status" class="form-label">Select Assignment Type</label>
                                    <select class="form-select @error('assigned_person_type') is-invalid @enderror"
                                        id="assigned_person_type" name="assigned_person_type" required>
                                        <option value="" selected disabled>-- Select Assignment Type --</option>
                                        <option value="engineer"
                                            {{ $stockRequests->assigned_person_type == 'engineer' ? 'selected' : '' }}>
                                            Engineer</option>
                                        <option value="delivery_man"
                                            {{ $stockRequests->assigned_person_type == 'delivery_man' ? 'selected' : '' }}>
                                            Delivery
                                            Man</option>
                                    </select>
                                    @error('assigned_person_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3" id="deliveryManSection" style="display: none;">
                                    <label for="delivery_man_id" class="form-label">Select Delivery Man</label>
                                    <select class="form-select @error('delivery_man_id') is-invalid @enderror"
                                        id="delivery_man_id" name="delivery_man_id">
                                        <option value="" selected disabled>-- Select Delivery Man --</option>
                                        @foreach ($deliveryMen as $deliveryMan)
                                            <option value="{{ $deliveryMan->id }}"
                                                @if ($stockRequests->assigned_person_id == $deliveryMan->id) selected @endif>
                                                {{ $deliveryMan->first_name }} {{ $deliveryMan->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('delivery_man_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3" id="engineerSection" style="display: none;">
                                    <label for="engineer_id" class="form-label">Select Engineer</label>
                                    <select class="form-select @error('engineer_id') is-invalid @enderror"
                                        id="engineer_id" name="engineer_id">
                                        <option value="" selected disabled>-- Select Engineer --</option>
                                        @foreach ($engineers as $engineer)
                                            <option value="{{ $engineer->id }}"
                                                @if ($stockRequests->assigned_person_id == $engineer->id) selected @endif>
                                                {{ $engineer->first_name }} {{ $engineer->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('engineer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
