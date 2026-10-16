@extends('crm.layouts.master')

@section('content')
<div class="content">
    <div class="container-fluid py-3">
        <h4 class="fs-18 fw-semibold mb-3">Edit AMC — {{ $amc->request_id }}</h4>
        @if ($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul></div>
        @endif
        <form action="{{ route('amcs-request.update', $amc->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card"><div class="card-body">
                <p><strong>Customer:</strong> {{ $amc->customer?->first_name }} {{ $amc->customer?->last_name }} ({{ $amc->customer?->email }})</p>
                <p><strong>AMC Plan:</strong> {{ $amc->amcPlan?->plan_name ?? 'N/A' }}</p>
                <div class="row g-3">
                    <div class="col-md-4">
                        @include('components.form.select', ['name' => 'amc_type', 'label' => 'AMC Type', 'required' => true, 'value' => $amc->amc_type, 'options' => ['remote' => 'Remote', 'onsite' => 'Onsite']])
                    </div>
                    <div class="col-md-4">
                        @include('components.form.input', ['name' => 'request_date', 'label' => 'Request Date', 'type' => 'date', 'required' => true, 'value' => $amc->request_date ? \Carbon\Carbon::parse($amc->request_date)->format('Y-m-d') : ''])
                    </div>
                    <div class="col-md-4">
                        @include('components.form.select', ['name' => 'status', 'label' => 'Status', 'required' => true, 'value' => $amc->status, 'options' => ['pending' => 'Pending', 'active' => 'Active', 'completed' => 'Completed', 'expired' => 'Expired', 'cancelled' => 'Cancelled']])
                    </div>
                </div>
            </div></div>
            @foreach ($amc->amcProducts as $index => $product)
                <div class="card"><div class="card-body">
                    <h5 class="mb-3">Product {{ $loop->iteration }}</h5>
                    <input type="hidden" name="products[{{ $index }}][id]" value="{{ $product->id }}">
                    <div class="row g-3">
                        @foreach (['name' => 'Product Name', 'brand' => 'Brand', 'model_no' => 'Model Number', 'sku' => 'SKU', 'hsn' => 'HSN'] as $field => $label)
                            <div class="col-md-4">
                                <label for="product-{{ $index }}-{{ $field }}" class="form-label">{{ $label }} @if ($field === 'name')<span class="text-danger">*</span>@endif</label>
                                <input id="product-{{ $index }}-{{ $field }}" name="products[{{ $index }}][{{ $field }}]" class="form-control" value="{{ old('products.'.$index.'.'.$field, $product->$field) }}" maxlength="255" @required($field === 'name')>
                            </div>
                        @endforeach
                        <div class="col-md-4">
                            <label for="product-{{ $index }}-purchase-date" class="form-label">Purchase Date</label>
                            <input type="date" id="product-{{ $index }}-purchase-date" name="products[{{ $index }}][purchase_date]" class="form-control" value="{{ old('products.'.$index.'.purchase_date', preg_match('/^\d{4}-\d{2}-\d{2}$/', $product->purchase_date ?? '') ? $product->purchase_date : '') }}">
                        </div>
                        <div class="col-12">
                            <label for="product-{{ $index }}-description" class="form-label">Issue Description</label>
                            <textarea id="product-{{ $index }}-description" name="products[{{ $index }}][description]" class="form-control" rows="3">{{ old('products.'.$index.'.description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div></div>
            @endforeach
            <button type="submit" class="btn btn-success">Save AMC</button>
            <a href="{{ route('amcs-lists.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
