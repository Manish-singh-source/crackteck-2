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
                                    <label for="search_term" class="form-label">SKU or Serial Number <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control"
                                           id="search_term"
                                           name="search_term"
                                           placeholder="Enter SKU or Serial Number"
                                           required>
                                    <div class="invalid-feedback" id="search_term_error"></div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary" id="searchBtn">
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
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
                        <p class="text-muted mb-0">No product found with this SKU or Serial ID. Please try a different search term.</p>
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
            url: '{{ route("track-product.search") }}',
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
    function displayResults(products) {
        let html = '';

        products.forEach(function(product, index) {
            const serialNumbers = product.serial_numbers.join(', ') || 'N/A'; // Join serial numbers with comma separator for display
            const rackInfo = `${product.rack_info.rack_no} / ${product.rack_info.zone_area} / ${product.rack_info.level_no} / ${product.rack_info.position_no}`; // Format rack information for display
            const availabilityBadge = product.availability_status === 'In Stock' ?
                '<span class="badge bg-success">In Stock</span>' :
                '<span class="badge bg-danger">Out of Stock</span>'; 

            html += `
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        ${product.main_image ?
                            `<img src="${product.main_image}" alt="${product.product_name}" class="img-fluid rounded" style="max-width: 80px; max-height: 80px;">` :
                            `<div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin: 0 auto;">
                                <i class="mdi mdi-package-variant text-muted fs-24"></i>
                            </div>`
                        }
                    </div>
                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold" style="width: 150px;">Product Name:</td>
                                        <td>${product.product_name}</td>
                                        <td class="fw-semibold" style="width: 150px;">SKU:</td>
                                        <td>${product.sku}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Serial Number(s):</td>
                                        <td>
                                            <span class="badge bg-info w-100">${serialNumbers}</span>
                                        </td>
                                        <td class="fw-semibold">Warehouse:</td>
                                        <td>${product.warehouse_name}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Rack / Zone / Level / Position:</td>
                                        <td>${rackInfo}</td>
                                        <td class="fw-semibold">Availability:</td>
                                        <td>${availabilityBadge}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Quantity:</td>
                                        <td><span class="badge bg-primary">${product.quantity}</span></td>
                                        <td class="fw-semibold">Brand:</td>
                                        <td>${product.brand}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `;
        });

        $('#resultsContainer').html(html);
    }
});
</script>
@endsection