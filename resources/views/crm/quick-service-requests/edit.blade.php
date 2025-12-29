@extends('crm.layouts.master')

@section('title', 'Edit Quick Service Request')

@section('content')
    <div class="content">
        <div class="container-fluid py-3">

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Edit Quick Service Request #QSR-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('quick-service-requests.update', $request->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- Status -->
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                            <option value="pending" {{ old('status', $request->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ old('status', $request->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="active" {{ old('status', $request->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="completed" {{ old('status', $request->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancel" {{ old('status', $request->status) == 'cancel' ? 'selected' : '' }}>Cancel</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Product Name -->
                                    <div class="col-md-6 mb-3">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name', $request->product_name) }}">
                                        @error('product_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Model No -->
                                    <div class="col-md-6 mb-3">
                                        <label for="model_no" class="form-label">Model No</label>
                                        <input type="text" class="form-control @error('model_no') is-invalid @enderror" id="model_no" name="model_no" value="{{ old('model_no', $request->model_no) }}">
                                        @error('model_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- SKU -->
                                    <div class="col-md-6 mb-3">
                                        <label for="sku" class="form-label">SKU</label>
                                        <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku', $request->sku) }}">
                                        @error('sku')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- HSN -->
                                    <div class="col-md-6 mb-3">
                                        <label for="hsn" class="form-label">HSN</label>
                                        <input type="text" class="form-control @error('hsn') is-invalid @enderror" id="hsn" name="hsn" value="{{ old('hsn', $request->hsn) }}">
                                        @error('hsn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Brand -->
                                    <div class="col-md-6 mb-3">
                                        <label for="brand" class="form-label">Brand</label>
                                        <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand', $request->brand) }}">
                                        @error('brand')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Issue Description -->
                                    <div class="col-12 mb-3">
                                        <label for="issue" class="form-label">Issue Description</label>
                                        <textarea class="form-control @error('issue') is-invalid @enderror" id="issue" name="issue" rows="4">{{ old('issue', $request->issue) }}</textarea>
                                        @error('issue')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Readonly Information -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6 class="mb-3">Request Information (Read Only)</h6>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Quick Service</label>
                                        <input type="text" class="form-control" value="{{ $request->quickService->name ?? 'N/A' }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" value="{{ $request->customer->first_name ?? '' }} {{ $request->customer->last_name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Created At</label>
                                        <input type="text" class="form-control" value="{{ $request->created_at->format('d M Y, h:i A') }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Last Updated</label>
                                        <input type="text" class="form-control" value="{{ $request->updated_at->diffForHumans() }}" readonly>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save me-1"></i> Update Request
                                    </button>
                                    <a href="{{ route('service-request.index') }}" class="btn btn-secondary">
                                        <i class="bx bx-x me-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

