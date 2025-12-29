@extends('warehouse/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Scrap Product list</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body border border-dashed border-end-0 border-start-0">
                            <form action="#" method="get">
                                <div class="d-flex justify-content-end">
                                    <div class="row">
                                        <div class="col">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addScrapModal">
                                                Add Scrap Product
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body pt-0">
                            <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active p-2" id="all_customer_tab" data-bs-toggle="tab"
                                        href="#all_customer" role="tab">
                                        <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                        <span class="d-none d-sm-block">All Products</span>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link p-2" id="active_customer_tab" data-bs-toggle="tab" href="#active_customer"
                                        role="tab">
                                        <span class="d-block d-sm-none"><i
                                                class="mdi mdi-sitemap-outline"></i></span>
                                        <span class="d-none d-sm-block">Laptops</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2" id="active_customer_tab" data-bs-toggle="tab" href="#active_customer"
                                        role="tab">
                                        <span class="d-block d-sm-none"><i
                                                class="mdi mdi-sitemap-outline"></i></span>
                                        <span class="d-none d-sm-block">Computers</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2" id="active_customer_tab" data-bs-toggle="tab" href="#active_customer"
                                        role="tab">
                                        <span class="d-block d-sm-none"><i
                                                class="mdi mdi-sitemap-outline"></i></span>
                                        <span class="d-none d-sm-block">Accessories</span>
                                    </a>
                                </li> -->
                            </ul>

                            <div class="tab-content text-muted">
                                <div class="tab-pane active show pt-4" id="all_customer" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Type</th>
                                                                <th>Reason</th>
                                                                <th>Module Number</th>
                                                                <th>Serial Number</th>
                                                                <!-- <th>Status</th> -->
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($scrapItems as $scrapItem)
                                                                <tr>
                                                                    <td>
                                                                        <div>
                                                                            {{ $scrapItem->product_name }}
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div>
                                                                            {{ $scrapItem->product->parentCategorie->parent_categories ?? 'N/A' }}
                                                                        </div>
                                                                        <div
                                                                            class="badge bg-primary-subtle text-primary fw-semibold">
                                                                            {{ $scrapItem->product->brand->brand_title ?? 'N/A' }}
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $scrapItem->reason }}</td>
                                                                    <td>{{ $scrapItem->product->model_no ?? 'N/A' }}</td>
                                                                    <td>{{ $scrapItem->serial_number }}</td>
                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn btn-icon btn-sm bg-success-subtle restore-btn"
                                                                            data-scrap-id="{{ $scrapItem->id }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Restore">
                                                                            <i
                                                                                class="mdi mdi-restore fs-14 text-success"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6" class="text-center py-4">
                                                                        <div class="text-muted">
                                                                            <i
                                                                                class="mdi mdi-information-outline fs-24 mb-2"></i>
                                                                            <p class="mb-0">No scrap items found</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div> <!-- content -->

        <!-- Add Scrap Product Modal -->
        <div class="modal fade" id="addScrapModal" tabindex="-1" aria-labelledby="addScrapModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addScrapModalLabel">Add Scrap Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="scrapProductForm">
                        @csrf
                        <div class="modal-body p-3">
                            <div class="mb-3">
                                <label for="serial_ids" class="form-label">Serial ID(s) <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="serial_ids" name="serial_ids" rows="3"
                                    placeholder="Enter one or multiple serial numbers (comma separated)&#10;Example: SER-001, SER-002, SER-003"
                                    required></textarea>
                                <div class="form-text">Enter serial numbers separated by commas</div>
                                <div class="invalid-feedback" id="serial_ids_error"></div>
                            </div>
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="reason" name="reason" rows="3"
                                    placeholder="Enter the reason for scrapping this product" required></textarea>
                                <div class="invalid-feedback" id="reason_error"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="scrapSubmitBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                                Scrap Product(s)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            $(document).ready(function() {
                // Handle scrap product form submission
                $('#scrapProductForm').on('submit', function(e) {
                    const form = $(this);
                    const submitBtn = $('#scrapSubmitBtn');
                    const spinner = submitBtn.find('.spinner-border');

                    // Clear previous errors
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').text('');

                    // Show loading state
                    submitBtn.prop('disabled', true);
                    spinner.removeClass('d-none');

                    $.ajax({
                        url: '{{ route('product-list.scrap-product') }}',
                        method: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            // Hide loading state first
                            submitBtn.prop('disabled', false);
                            spinner.addClass('d-none');
                            console.log(response);

                            if (response.success) {
                                // Show success message
                                toastr.success(response.message);

                                // Reset form and close modal
                                form[0].reset();
                                $('#addScrapModal').modal('hide');

                                // Reload page to show updated data
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            // Hide loading state first
                            submitBtn.prop('disabled', false);
                            spinner.addClass('d-none');

                            if (xhr.status === 422) {
                                // Validation errors
                                const errors = xhr.responseJSON.errors;
                                Object.keys(errors).forEach(function(key) {
                                    $('#' + key).addClass('is-invalid');
                                    $('#' + key + '_error').text(errors[key][0]);
                                });
                            } else {
                                toastr.error('An error occurred while processing your request.');
                            }
                        }
                    });
                });

                // Handle restore product
                $('.restore-btn').on('click', function() {
                    const scrapId = $(this).data('scrap-id');
                    const button = $(this);

                    if (confirm('Are you sure you want to restore this product?')) {
                        button.prop('disabled', true);

                        $.ajax({
                            url: '{{ route('product-list.restore-product', ':id') }}'.replace(':id',
                                scrapId),
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    // toastr.success(response.message);
                                    location.reload();
                                    // Remove the row from table
                                    button.closest('tr').fadeOut(function() {
                                        $(this).remove();

                                        // Check if table is empty and reload if needed
                                        if ($('tbody tr:visible').length === 0) {
                                            setTimeout(function() {
                                                location.reload();
                                            }, 1000);
                                        }
                                    });
                                } else {
                                    toastr.error(response.message);
                                    button.prop('disabled', false);
                                }
                            },
                            error: function() {
                                toastr.error('An error occurred while restoring the product.');
                                button.prop('disabled', false);
                            }
                        });
                    }
                });
            });
        </script>
    @endsection
