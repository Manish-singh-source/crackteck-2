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
                                        @if ($stockRequests->requestedPart->product->main_product_image)
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
                                            <span class="fw-semibold">Product Name:</span>
                                            <span>{{ $stockRequests->requestedPart->product->product_name ?? 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Type:</span>
                                            <span>{{ $stockRequests->requestedPart->product->parent_category_id ? $stockRequests->requestedPart->product->parentCategorie->name : 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Brand:</span>
                                            <span>{{ $stockRequests->requestedPart->product->brand_id ? $stockRequests->requestedPart->product->brand->name : 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Model Number:</span>
                                            <span>{{ $stockRequests->requestedPart->product->model_no ?? 'N/A' }}</span>
                                        </li>
                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold">Serial Number:</span>
                                            <span>{{ $stockRequests->requestedPart->auto_generated_serial ?? 'N/A' }}</span>
                                        </li>
                                        @if ($stockRequests->requestedPart->manual_serial)
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
                                            {{ $stockRequests->assigned_person_type == 'delivery_man' ? 'selected' : '' }} >Delivery
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
