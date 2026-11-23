@extends('warehouse/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Import Opening Stock</h4>
                    <p class="text-muted mb-0">Upload new products only. Existing SKU values are rejected to prevent accidental stock duplication.</p>
                </div>
                <div class="mt-2 mt-sm-0">
                    <a href="{{ route('opening-stock.template') }}" class="btn btn-outline-primary">
                        <i class="mdi mdi-download me-1"></i>Download Excel Template
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            @if (session('import_errors'))
                                <div class="alert alert-danger">
                                    <strong>Import was not completed. Please correct these rows:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach (session('import_errors') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('opening-stock.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="opening_stock_file" class="form-label">Opening Stock File <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('opening_stock_file') is-invalid @enderror"
                                        id="opening_stock_file" name="opening_stock_file" accept=".xlsx,.csv" required>
                                    <div class="form-text">Allowed files: .xlsx or .csv, maximum 5 MB.</div>
                                    @error('opening_stock_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success">
                                    <i class="mdi mdi-upload me-1"></i>Validate and Import
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0">Before Uploading</h5></div>
                        <div class="card-body">
                            <ul class="mb-0 ps-3">
                                <li>Create the Vendor Invoice first.</li>
                                <li>Use existing Vendor Code, Brand, Category and Warehouse names. Sub Category is optional.</li>
                                <li>Every row creates a new product and its unit-wise barcodes.</li>
                                <li>If any row is invalid, no rows are imported.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
