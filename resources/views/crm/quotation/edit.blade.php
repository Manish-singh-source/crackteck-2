@extends('crm/layouts/master')

@section('content')
    <div class="content">


        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Quotation</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Quotation</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0"></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header border-bottom-dashed">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-sm">
                                            <h5 class="card-title mb-0">
                                                Personal Information
                                            </h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row g-3">

                                        <div class="col-6">
                                            <label for="lead_id" class="form-label">Lead <span
                                                    class="text-danger">*</span></label>
                                            <select name="lead_id" id="lead_id" class="form-select" required>
                                                <option value="">--Select Lead--</option>
                                                @foreach ($leads as $lead)
                                                    <option value="{{ $lead->id }}"
                                                        {{ $quotation->lead_id == $lead->id ? 'selected' : '' }}>
                                                        {{ $lead->first_name }} {{ $lead->last_name }} ({{ $lead->email }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-6">
                                            <label for="quote_id" class="form-label">Quotation ID</label>
                                            <input type="text" name="quote_id" id="quote_id" class="form-control"
                                                value="{{ $quotation->quote_id }}" readonly>
                                        </div>

                                        <div class="col-6">
                                            <label for="quote_date" class="form-label">Quotation Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" name="quote_date" id="quote_date" class="form-control"
                                                value="{{ $quotation->quote_date }}" required readonly>
                                        </div>

                                        <div class="col-6">
                                            <label for="expiry_date" class="form-label">Expiration Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" name="expiry_date" id="expiry_date" class="form-control"
                                                value="{{ $quotation->expiry_date }}" required readonly>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card branch-section">
                                <div
                                    class="card-header border-bottom-dashed d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        Products/Services Information
                                    </h5>
                                    <button type="button" class="btn btn-sm btn-primary" id="addBranchBtn">
                                        <i class="mdi mdi-plus"></i> Add Product/Service
                                    </button>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-borderless dt-responsive nowrap">
                                        <thead>
                                            <tr>

                                                <th>Product Name</th>
                                                <th>HSN Code</th>
                                                <th>SKU</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Tax (%)</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($quotation->products as $product)
                                                <tr>
                                                    <td>{{ $product->product_name }}</td>
                                                    <td>{{ $product->hsn_code }}</td>
                                                    <td>{{ $product->sku }}</td>
                                                    <td>{{ $product->price }}</td>
                                                    <td>{{ $product->quantity }}</td>
                                                    <td>{{ $product->tax }}</td>
                                                    <td>{{ $product->total }}</td>
                                                    <td>
                                                    <button type="button"
                                                        class="btn btn-icon btn-sm bg-warning-subtle editProductBtn"
                                                        data-product-id="{{ $product->id }}"
                                                        data-product-name="{{ $product->product_name }}"
                                                        data-product-hsn-code="{{ $product->hsn_code }}"
                                                        data-product-sku="{{ $product->sku }}"
                                                        data-product-price="{{ $product->price }}"
                                                        data-product-quantity="{{ $product->quantity }}"
                                                        data-product-tax="{{ $product->tax }}"
                                                        data-product-total="{{ $product->total }}">
                                                        <i class="mdi mdi-pencil fs-14 text-warning"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-icon btn-sm bg-danger-subtle removeProductBtn"
                                                        data-product-id="{{ $product->id }}">
                                                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                    </button>
                                                </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card pb-4" id="edit-product-section" style="display: none;">
                                <div class="card-header border-bottom-dashed">
                                    <h5 class="card-title mb-0">
                                        Edit Products/Services
                                    </h5>
                                </div>

                                <div class="card-body">
                                    <input type="hidden" id="edit_product_id" value="">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            @include('components.form.input', [
                                                'label' => 'Product Name',
                                                'name' => 'product_name',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Product Name',
                                            ])
                                        </div>

                                        <div class="col-6">
                                            @include('components.form.input', [
                                                'label' => 'HSN Code',
                                                'name' => 'hsn_code',
                                                'type' => 'text',
                                                'placeholder' => 'Enter HSN Code',
                                            ])
                                        </div>

                                        <div class="col-6">
                                            @include('components.form.input', [
                                                'label' => 'SKU',
                                                'name' => 'sku',
                                                'type' => 'text',
                                                'placeholder' => 'Enter SKU',
                                            ])
                                        </div>

                                        <div class="col-6">
                                            @include('components.form.input', [
                                                'label' => 'Price',
                                                'name' => 'price',
                                                'type' => 'number',
                                                'placeholder' => 'Enter Price',
                                            ])
                                        </div>

                                        <div class="col-6">
                                            @include('components.form.input', [
                                                'label' => 'Quantity',
                                                'name' => 'quantity',
                                                'type' => 'number',
                                                'placeholder' => 'Enter Quantity',
                                            ])
                                        </div>

                                        <div class="col-6">
                                            @include('components.form.input', [
                                                'label' => 'Tax (%)',
                                                'name' => 'tax',
                                                'type' => 'number',
                                                'placeholder' => 'Enter Tax Percentage',
                                            ])
                                        </div>

                                        <div class="col-6">
                                            @include('components.form.input', [
                                                'label' => 'Total',
                                                'name' => 'total',
                                                'type' => 'number',
                                                'placeholder' => 'Auto Calculated',
                                                'readonly' => true,
                                            ])
                                        </div>

                                        <div class="col-12">
                                            <div class="text-end">
                                                <button type="button" class="btn btn-success" id="save-product-btn">
                                                    <span id="btn-text">Add Product</span>
                                                </button>
                                                <button type="button" class="btn btn-secondary" id="cancel-edit-btn" style="display: none;">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12">
                            <div class="text-start mb-3">
                                <!-- <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                        Submit
                                    </button> -->
                                <a href="{{ route('quotation.index') }}"
                                    class="btn btn-success w-sm waves ripple-light">Submit</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const quotationId = {{ $quotation->id }};
            let editMode = false;
            let editProductId = null;

            // Calculate total when price, quantity, or tax changes
            function calculateTotal() {
                const price = parseFloat($('input[name="price"]').val()) || 0;
                const quantity = parseInt($('input[name="quantity"]').val()) || 0;
                const tax = parseFloat($('input[name="tax"]').val()) || 0;

                const subtotal = price * quantity;
                const taxAmount = (subtotal * tax) / 100;
                const total = subtotal + taxAmount;

                $('input[name="total"]').val(total.toFixed(2));
            }

            $('input[name="price"], input[name="quantity"], input[name="tax"]').on('input', calculateTotal);

            // Save Product Button Click (Add or Update)
            $('#save-product-btn').on('click', function(e) {
                e.preventDefault();

                const productData = {
                    quotation_id: quotationId,
                    product_name: $('input[name="product_name"]').val(),
                    hsn_code: $('input[name="hsn_code"]').val(),
                    sku: $('input[name="sku"]').val(),
                    price: $('input[name="price"]').val(),
                    quantity: $('input[name="quantity"]').val(),
                    tax: $('input[name="tax"]').val(),
                    total: $('input[name="total"]').val()
                };

                // Validation
                if (!productData.product_name || !productData.hsn_code || !productData.sku ||
                    !productData.price || !productData.quantity || !productData.tax) {
                    alert('Please fill all required fields');
                    return;
                }

                if (editMode) {
                    // Update existing product
                    updateProduct(editProductId, productData);
                } else {
                    // Add new product
                    addProduct(productData);
                }
            });

            // Add Product via AJAX
            function addProduct(productData) {
                $.ajax({
                    url: '{{ route("quotation.products.store") }}',
                    method: 'POST',
                    data: productData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            clearForm();
                            location.reload(); // Reload to refresh the product table
                        }
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON?.message || 'Error adding product';
                        alert(error);
                    }
                });
            }

            // Update Product via AJAX
            function updateProduct(productId, productData) {
                $.ajax({
                    url: '{{ route("quotation.products.update", ":id") }}'.replace(':id', productId),
                    method: 'PUT',
                    data: productData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            clearForm();
                            cancelEdit();
                            location.reload(); // Reload to refresh the product table
                        }
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON?.message || 'Error updating product';
                        alert(error);
                    }
                });
            }

            // Edit Product Button Click
            $(document).on('click', '.editProductBtn', function() {
                $('#edit-product-section').slideDown(); 
                
                editMode = true;
                editProductId = $(this).data('product-id');

                // Populate form with product data
                $('input[name="product_name"]').val($(this).data('product-name'));
                $('input[name="hsn_code"]').val($(this).data('product-hsn-code'));
                $('input[name="sku"]').val($(this).data('product-sku'));
                $('input[name="price"]').val($(this).data('product-price'));
                $('input[name="quantity"]').val($(this).data('product-quantity'));
                $('input[name="tax"]').val($(this).data('product-tax'));
                $('input[name="total"]').val($(this).data('product-total'));

                // Update button text and show cancel button
                $('#btn-text').text('Update Product');
                $('#cancel-edit-btn').show();

                // Scroll to form
                $('html, body').animate({
                    scrollTop: $('#save-product-btn').offset().top - 100
                }, 500);
            });

            // Delete Product Button Click
            $(document).on('click', '.removeProductBtn', function() {
                if (!confirm('Are you sure you want to delete this product?')) {
                    return;
                }

                const productId = $(this).data('product-id');

                $.ajax({
                    url: '{{ route("quotation.products.delete", ":id") }}'.replace(':id', productId),
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload(); // Reload to refresh the product table
                        }
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON?.message || 'Error deleting product';
                        alert(error);
                    }
                });
            });

            // Cancel Edit Button Click
            $('#cancel-edit-btn').on('click', function() {
                cancelEdit();
            });

            // Cancel Edit Mode
            function cancelEdit() {
                editMode = false;
                editProductId = null;
                clearForm();
                $('#btn-text').text('Add Product');
                $('#cancel-edit-btn').hide();
            }

            // Clear Form
            function clearForm() {
                $('input[name="product_name"]').val('');
                $('input[name="hsn_code"]').val('');
                $('input[name="sku"]').val('');
                $('input[name="price"]').val('');
                $('input[name="quantity"]').val('');
                $('input[name="tax"]').val('');
                $('input[name="total"]').val('');
            }

            // Add Product Button Click
            $('#addBranchBtn').on('click', function() {
                $('#edit-product-section').slideDown();
            });
        });
    </script>
@endsection
