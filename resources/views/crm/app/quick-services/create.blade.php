@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('quick-services.index') }}">Quick Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Quick Service</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Create Quick Service</h4>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('quick-services.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Quick Service Information
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="service_name" class="form-label">Service Name <span class="text-danger">*</span></label>
                                                <input type="text"
                                                       class="form-control @error('service_name') is-invalid @enderror"
                                                       id="service_name"
                                                       name="service_name"
                                                       value="{{ old('service_name') }}"
                                                       placeholder="Enter Service Name"
                                                       required>
                                                @error('service_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="service_price" class="form-label">Min Service Price <span class="text-danger">*</span></label>
                                                <input type="number"
                                                       class="form-control @error('service_price') is-invalid @enderror"
                                                       id="service_price"
                                                       name="service_price"
                                                       value="{{ old('service_price') }}"
                                                       placeholder="Enter Service Price"
                                                       step="0.01"
                                                       min="0"
                                                       required>
                                                @error('service_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="service_image" class="form-label">Service Image</label>
                                                <input type="file"
                                                       class="form-control @error('service_image') is-invalid @enderror"
                                                       id="service_image"
                                                       name="service_image"
                                                       accept="image/jpeg,image/png,image/jpg,image/gif">
                                                <small class="text-muted">Allowed: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                                                @error('service_image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-12">
                                                <label for="service_description" class="form-label">Service Description</label>
                                                <textarea name="service_description"
                                                          id="service_description"
                                                          class="form-control @error('service_description') is-invalid @enderror"
                                                          rows="3"
                                                          placeholder="Enter Service Description">{{ old('service_description') }}</textarea>
                                                @error('service_description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-start mb-3">
                                    <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                        <i class="mdi mdi-content-save me-1"></i> Submit
                                    </button>
                                    <a href="{{ route('quick-services.index') }}" class="btn btn-secondary w-sm ms-2">
                                        <i class="mdi mdi-cancel me-1"></i> Cancel
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
