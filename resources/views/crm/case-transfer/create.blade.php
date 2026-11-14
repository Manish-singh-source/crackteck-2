@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="d-flex align-items-sm-center flex-sm-row flex-column py-3">
                <div class="flex-grow-1"><h4 class="fs-18 fw-semibold m-0">Transfer Case</h4></div>
                <a href="{{ route('case-transfer.index') }}" class="btn btn-light">Back to Cases</a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('case-transfer.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="service_request_id" class="form-label">Service ID <span class="text-danger">*</span></label>
                                <select id="service_request_id" name="service_request_id" class="form-select" onchange="window.location.href='{{ route('case-transfer.create') }}?service_request_id='+this.value" required>
                                    <option value="">-- Select service request --</option>
                                    @foreach ($serviceRequests as $serviceRequest)
                                        <option value="{{ $serviceRequest->id }}" @selected((string) $serviceRequest->id === (string) old('service_request_id', request('service_request_id')))>
                                            {{ $serviceRequest->request_id }} — {{ $serviceRequest->customer->first_name ?? 'Unknown customer' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="new_engineer_id" class="form-label">Transfer to engineer <span class="text-danger">*</span></label>
                                <select id="new_engineer_id" name="new_engineer_id" class="form-select" required>
                                    <option value="">-- Select engineer --</option>
                                    @foreach ($engineers as $engineer)
                                        <option value="{{ $engineer->id }}" @selected((string) $engineer->id === (string) old('new_engineer_id'))>{{ trim($engineer->first_name.' '.$engineer->last_name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="engineer_reason" class="form-label">Reason for transfer <span class="text-danger">*</span></label>
                                <textarea id="engineer_reason" name="engineer_reason" class="form-control" rows="3" required>{{ old('engineer_reason') }}</textarea>
                            </div>
                        </div>
                        <div class="mt-4 text-end"><button type="submit" class="btn btn-success px-4">Create Transfer Request</button></div>
                    </form>
                </div>
            </div>

            @if ($selectedServiceRequest)
                @php
                    $customer = $selectedServiceRequest->customer;
                    $assignment = $selectedServiceRequest->activeAssignment;
                @endphp
                <div class="card">
                    <div class="card-header border-bottom-dashed d-flex justify-content-between"><h5 class="card-title mb-0">Customer Details</h5><span class="fw-bold">{{ $selectedServiceRequest->request_id }}</span></div>
                    <div class="card-body"><div class="row g-3">
                        <div class="col-md-4"><strong>Customer:</strong> {{ trim(($customer->first_name ?? '').' '.($customer->last_name ?? '')) ?: 'N/A' }}</div>
                        <div class="col-md-4"><strong>Contact:</strong> {{ $customer->phone ?? 'N/A' }}</div>
                        <div class="col-md-4"><strong>Current engineer:</strong> {{ trim(($assignment->engineer->first_name ?? '').' '.($assignment->engineer->last_name ?? '')) ?: 'N/A' }}</div>
                        <div class="col-12"><strong>Notes:</strong> {{ $selectedServiceRequest->additional_notes ?: 'N/A' }}</div>
                    </div></div>
                </div>

                @if ($selectedServiceRequest->amcPlan)
                    <div class="card"><div class="card-header border-bottom-dashed"><h5 class="card-title mb-0">AMC Details</h5></div><div class="card-body"><div class="row g-3">
                        <div class="col-md-4"><strong>Plan:</strong> {{ $selectedServiceRequest->amcPlan->plan_name }}</div>
                        <div class="col-md-4"><strong>Duration:</strong> {{ $selectedServiceRequest->amcPlan->duration ?? 'N/A' }} months</div>
                        <div class="col-md-4"><strong>Request date:</strong> {{ $selectedServiceRequest->request_date ?? 'N/A' }}</div>
                    </div></div></div>
                @endif

                <div class="card"><div class="card-header border-bottom-dashed"><h5 class="card-title mb-0">Product Details</h5></div><div class="card-body"><div class="table-responsive"><table class="table table-striped mb-0"><thead><tr><th>Name</th><th>Type</th><th>Brand</th><th>Model Number</th><th>Serial / MAC</th><th>Purchase Date</th></tr></thead><tbody>
                    @forelse ($selectedServiceRequest->products as $product)
                        <tr><td>{{ $product->name }}</td><td>{{ $product->productType->name ?? $product->type ?? 'N/A' }}</td><td>{{ $product->brand ?? 'N/A' }}</td><td>{{ $product->model_no ?? 'N/A' }}</td><td>{{ $product->mac_address ?? $product->sku ?? 'N/A' }}</td><td>{{ $product->purchase_date ?? 'N/A' }}</td></tr>
                    @empty
                        <tr><td colspan="6" class="text-center">No products found for this service request.</td></tr>
                    @endforelse
                </tbody></table></div></div></div>
            @endif
        </div>
    </div>
@endsection
