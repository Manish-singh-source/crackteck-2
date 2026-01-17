@extends('warehouse/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Track Product</h4>
                    <p class="text-muted mb-0">Search products by SKU or Serial Number</p>
                </div>
            </div>

            <!-- Search Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Search Product</h5>
                        </div>
                        <div class="card-body">
                            <form id="trackProductForm">
                                @csrf
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-8">
                                        <label for="search_term" class="form-label">SKU or Serial Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="search_term" name="search_term"
                                            placeholder="Enter SKU or Serial Number" required>
                                        <div class="invalid-feedback" id="search_term_error"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary" id="searchBtn">
                                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                                aria-hidden="true"></span>
                                            <i class="fas fa-search me-1"></i>
                                            Search
                                        </button>
                                        <button type="button" class="btn btn-secondary" id="clearBtn">
                                            <i class="fas fa-times me-1"></i>
                                            Clear
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Results -->
            <div class="row" id="searchResults" style="display: none;">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Search Results</h5>
                        </div>
                        <div class="card-body">
                            <div id="resultsContainer">
                                <!-- Results will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- No Results Message -->
            <div class="row" id="noResults" style="display: none;">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-search text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="text-muted">No Product Found</h5>
                            <p class="text-muted mb-0">No product found with this SKU or Serial ID. Please try a different
                                search term.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Handle track product form submission
            $('#trackProductForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const submitBtn = $('#searchBtn');
                const spinner = submitBtn.find('.spinner-border');
                const searchTerm = $('#search_term').val().trim();

                if (!searchTerm) {
                    $('#search_term').addClass('is-invalid');
                    $('#search_term_error').text('Please enter a SKU or Serial Number');
                    return;
                }

                // Clear previous errors and results
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#searchResults, #noResults').hide();

                // Show loading state
                submitBtn.prop('disabled', true);
                spinner.removeClass('d-none');

                $.ajax({
                    url: '{{ route('track-product.search') }}',
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success && response.data.length > 0) {
                            displayResults(response.data);
                            $('#searchResults').show();
                        } else {
                            $('#noResults').show();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(function(key) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '_error').text(errors[key][0]);
                            });
                        } else {
                            console.log(xhr.responseText);
                            toastr.error('An error occurred while searching for products.');
                        }
                    },
                    complete: function() {
                        // Hide loading state
                        submitBtn.prop('disabled', false);
                        spinner.addClass('d-none');
                    }
                });
            });

            // Handle clear button
            $('#clearBtn').on('click', function() {
                $('#trackProductForm')[0].reset();
                $('#searchResults, #noResults').hide();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });

            // Function to display search results
            // function displayResults(results) {
            //     console.log(results);
            //     const resultsContainer = $('#resultsContainer');
            //     resultsContainer.empty();

            //     results.forEach(function(result) {
            //         const serialNumbers = result.product_serials.map(serial => serial.manual_serial ||
            //             serial
            //             .auto_generated_serial).join(', ') || 'N/A';
            //         const availabilityBadge = result.stock_status === 'in_stock' ?
            //             '<span class="badge bg-success">In Stock</span>' :
            //             '<span class="badge bg-danger">Out of Stock</span>';

            //         const row = `
        //             <div class="row align-items-center">
        //                 <div class="col-md-2 text-center">
        //                     ${result.main_product_image ? `<img src="${result.main_product_image}" alt="${result.product_name}" class="img-fluid rounded" style="max-width: 80px; max-height: 80px;">` : `<div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin: 0 auto;"><i class="mdi mdi-package-variant text-muted fs-24"></i></div>`}
        //                 </div>
        //                 <div class="col-md-10">
        //                     <div class="table-responsive">
        //                         <table class="table table-borderless">
        //                             <tbody>
        //                                 <tr>
        //                                     <td class="fw-semibold" style="width: 150px;">Product Name:</td>
        //                                     <td>${result.product_name}</td>
        //                                 </tr>
        //                                 <tr>
        //                                     <td class="fw-semibold" style="width: 150px;">SKU:</td>
        //                                     <td>${result.sku}</td>
        //                                 </tr>
        //                                 <tr>
        //                                     <td class="fw-semibold" style="width: 150px;">Serial Number:</td>
        //                                     <td>${serialNumbers}</td>
        //                                 </tr>
        //                                 <tr>
        //                                     <td class="fw-semibold" style="width: 150px;">Availability:</td>
        //                                     <td>${availabilityBadge}</td>
        //                                 </tr>
        //                             </tbody>
        //                         </table>
        //                     </div>
        //                 </div>
        //             </div>
        //         `;
            //         resultsContainer.append(row);
            //     });
            // }


            function displayResults(results) {
                const resultsContainer = $('#resultsContainer');
                resultsContainer.empty();
                console.log(results);

                results.forEach(function(result) {
                    // Serial rows
                    let serialRows = `
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">
                                No serial numbers found.
                            </td>
                        </tr>
                    `;

                    if (result.product_serials && result.product_serials.length > 0) {
                        serialRows = result.product_serials.map(function(serial, index) {
                            const serialNum = serial.manual_serial || serial
                                .auto_generated_serial || 'N/A';
                            const warehouse = result.warehouse.name || 'N/A';
                            console.log(warehouse);
                            const status = (serial.status || 'unknown').replace('_', ' ');
                            const statusClass =
                                serial.status === 'active' ?
                                'bg-success-subtle text-success' :
                                serial.status === 'used' ?
                                'bg-warning-subtle text-warning' :
                                serial.status === 'scrapped' ?
                                'bg-danger-subtle text-danger' :
                                'bg-secondary-subtle text-secondary';

                            return `
                    <tr>
                        <td class="text-muted">${index + 1}</td>
                        <td class="fw-medium">${serialNum}</td>
                        <td>${warehouse}</td>
                        <td>
                            <span class="badge ${statusClass} text-capitalize">
                                ${status}
                            </span>
                        </td>
                    </tr>
                `;
                        }).join('');
                    }

                    // Availability
                    const availabilityBadge =
                        result.stock_status === 'in_stock' ?
                        '<span class="badge bg-success-subtle text-success"><i class="fas fa-check me-1"></i>In Stock</span>' :
                        '<span class="badge bg-danger-subtle text-danger"><i class="fas fa-times me-1"></i>Out of Stock</span>';

                    // Product image
                    const imageHtml = result.main_product_image ?
                        `<img src="/${result.main_product_image}" alt="${result.product_name}"
                     class="img-fluid rounded-3 shadow-sm w-100"
                     style="max-height: 260px; object-fit: contain; background: #f9fafb;">` :
                        `<div class="bg-light rounded-3 d-flex align-items-center justify-content-center shadow-sm w-100"
                     style="height: 260px;">
                    <i class="mdi mdi-package-variant-outline text-muted" style="font-size: 3rem;"></i>
               </div>`;

                    const block = `
            <div class="product-track-card mb-4">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="row g-0">
                        <!-- Left: Big image -->
                        <div class="col-md-2 border-end">
                            <div class="p-3 h-100 d-flex align-items-center justify-content-center">
                                ${imageHtml}
                            </div>
                        </div>

                        <!-- Right: Details + serial table -->
                        <div class="col-md-10">
                            <div class="card-body">
                                <!-- Top details -->
                                <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                                    <div>
                                        <h5 class="card-title mb-1 fw-semibold">
                                            ${result.product_name}
                                        </h5>
                                        <p class="mb-1 text-muted small">
                                            SKU: <span class="fw-medium">${result.sku}</span>
                                        </p>
                                        ${
                                            result.category_name
                                                ? `<p class="mb-0 text-muted small">
                                                                Category: <span class="fw-medium">${result.category_name}</span>
                                                           </p>`
                                                : ''
                                        }
                                    </div>
                                    <div class="text-end">
                                        ${availabilityBadge}
                                        ${
                                            result.total_quantity !== undefined
                                                ? `<p class="mb-0 mt-2 text-muted small">
                                                                Total Qty: <span class="fw-medium">${result.total_quantity}</span>
                                                           </p>`
                                                : ''
                                        }
                                    </div>
                                </div>

                                <!-- Serial table -->
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0 fw-semibold">Serial Numbers</h6>
                                        <span class="badge bg-soft-primary text-primary">
                                            ${result.product_serials ? result.product_serials.length : 0} serials
                                        </span>
                                    </div>

                                    <div class="table-responsive border rounded-3">
                                        <table class="table table-sm mb-0 align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 60px;">#</th>
                                                    <th>Serial Number</th>
                                                    <th>Warehouse</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${serialRows}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Optional action buttons -->
                                ${
                                    result.view_url || result.edit_url
                                        ? `<div class="mt-3 d-flex justify-content-end gap-2">
                                                        ${
                                                            result.view_url
                                                                ? `<a href="${result.view_url}" class="btn btn-sm btn-outline-primary">
                                                                <i class="mdi mdi-eye-outline me-1"></i>View Details
                                                           </a>`
                                                                : ''
                                                        }
                                                        ${
                                                            result.edit_url
                                                                ? `<a href="${result.edit_url}" class="btn btn-sm btn-outline-secondary">
                                                                <i class="mdi mdi-pencil-outline me-1"></i>Edit
                                                           </a>`
                                                                : ''
                                                        }
                                                   </div>`
                                        : ''
                                }
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

                    resultsContainer.append(block);
                });
            }

        });
    </script>
@endsection
