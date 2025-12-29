@extends('e-commerce/layouts/master')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="bradcrumb pt-3 ps-2 bg-light">
            <div class="row">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Orders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Order</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Create New E-Commerce Order</h4>
            </div>
            <div>
                <a href="{{ route('order.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Orders
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('order.store') }}" method="POST" id="orderForm">
            @csrf
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Customer Information Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Customer Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="user_search" class="form-label">Search Existing Customer</label>
                                        <input type="text" id="user_search" class="form-control" placeholder="Type to search customers..." autocomplete="off">
                                        <input type="hidden" id="user_id" name="user_id">
                                        <div id="user_suggestions" class="dropdown-menu w-100" style="display: none;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Shipping Address</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="shipping_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('shipping_first_name') is-invalid @enderror"
                                               id="shipping_first_name" name="shipping_first_name" value="{{ old('shipping_first_name') }}" required>
                                        @error('shipping_first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="shipping_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('shipping_last_name') is-invalid @enderror"
                                               id="shipping_last_name" name="shipping_last_name" value="{{ old('shipping_last_name') }}" required>
                                        @error('shipping_last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="shipping_phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('shipping_phone') is-invalid @enderror"
                                               id="shipping_phone" name="shipping_phone" value="{{ old('shipping_phone') }}" required>
                                        @error('shipping_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="shipping_address_line_1" class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('shipping_address_line_1') is-invalid @enderror"
                                               id="shipping_address_line_1" name="shipping_address_line_1" value="{{ old('shipping_address_line_1') }}" required>
                                        @error('shipping_address_line_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="shipping_address_line_2" class="form-label">Address Line 2</label>
                                        <input type="text" class="form-control @error('shipping_address_line_2') is-invalid @enderror"
                                               id="shipping_address_line_2" name="shipping_address_line_2" value="{{ old('shipping_address_line_2') }}">
                                        @error('shipping_address_line_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="shipping_city" class="form-label">City <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('shipping_city') is-invalid @enderror"
                                               id="shipping_city" name="shipping_city" value="{{ old('shipping_city') }}" required>
                                        @error('shipping_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="shipping_state" class="form-label">State <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('shipping_state') is-invalid @enderror"
                                               id="shipping_state" name="shipping_state" value="{{ old('shipping_state') }}" required>
                                        @error('shipping_state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="shipping_zipcode" class="form-label">Zipcode <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('shipping_zipcode') is-invalid @enderror"
                                               id="shipping_zipcode" name="shipping_zipcode" value="{{ old('shipping_zipcode') }}" required>
                                        @error('shipping_zipcode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="shipping_country" class="form-label">Country <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('shipping_country') is-invalid @enderror"
                                               id="shipping_country" name="shipping_country" value="{{ old('shipping_country', 'India') }}" required>
                                        @error('shipping_country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Order Items</h5>
                                <button type="button" class="btn btn-primary btn-sm" id="add-item-btn">
                                    <i class="fas fa-plus me-1"></i> Add Item
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="order-items-container">
                                <!-- Order items will be added here dynamically -->
                            </div>
                            <div class="alert alert-info" id="no-items-message">
                                <i class="fas fa-info-circle me-1"></i>
                                No items added yet. Click "Add Item" to start adding products to this order.
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Payment Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                        <select class="form-select @error('payment_method') is-invalid @enderror"
                                                id="payment_method" name="payment_method" required>
                                            <option value="">Select Payment Method</option>
                                            <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                                            <option value="visa" {{ old('payment_method') == 'visa' ? 'selected' : '' }}>Visa Card</option>
                                            <option value="mastercard" {{ old('payment_method') == 'mastercard' ? 'selected' : '' }}>Mastercard</option>
                                        </select>
                                        @error('payment_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6" id="card-details" style="display: none;">
                                    <div class="mb-3">
                                        <label for="card_last_four" class="form-label">Card Last 4 Digits</label>
                                        <input type="text" class="form-control @error('card_last_four') is-invalid @enderror"
                                               id="card_last_four" name="card_last_four" value="{{ old('card_last_four') }}"
                                               maxlength="4" pattern="[0-9]{4}">
                                        @error('card_last_four')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6" id="card-name-field" style="display: none;">
                                    <div class="mb-3">
                                        <label for="card_name" class="form-label">Card Holder Name</label>
                                        <input type="text" class="form-control @error('card_name') is-invalid @enderror"
                                               id="card_name" name="card_name" value="{{ old('card_name') }}">
                                        @error('card_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Order Summary Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="shipping_charges" class="form-label">Shipping Charges</label>
                                <input type="number" class="form-control @error('shipping_charges') is-invalid @enderror"
                                       id="shipping_charges" name="shipping_charges" value="{{ old('shipping_charges', 0) }}"
                                       min="0" step="0.01">
                                @error('shipping_charges')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="discount_amount" class="form-label">Discount Amount</label>
                                <input type="number" class="form-control @error('discount_amount') is-invalid @enderror"
                                       id="discount_amount" name="discount_amount" value="{{ old('discount_amount', 0) }}"
                                       min="0" step="0.01">
                                @error('discount_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span id="subtotal-display">₹0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax Amount:</span>
                                    <span id="tax-display">₹0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span id="shipping-display">₹0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Discount:</span>
                                    <span id="discount-display" class="text-success">-₹0.00</span>
                                </div>
                                <div class="d-flex justify-content-between fw-bold border-top pt-2">
                                    <span>Grand Total:</span>
                                    <span id="total-display" class="text-success">₹0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Status Card -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Order Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="status" class="form-label">Initial Status</label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status">
                                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Actions Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Create Order
                                </button>
                                <a href="{{ route('order.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add Order Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="product_search" class="form-label">Search Product <span class="text-danger">*</span></label>
                    <input type="text" id="product_search" class="form-control" placeholder="Type to search products..." autocomplete="off">
                    <div id="product_suggestions" class="dropdown-menu w-100" style="display: none;"></div>
                </div>

                <div id="selected_product_details" style="display: none;">
                    <div class="alert alert-info">
                        <h6>Selected Product:</h6>
                        <p class="mb-1"><strong>Name:</strong> <span id="selected_product_name"></span></p>
                        <p class="mb-1"><strong>SKU:</strong> <span id="selected_product_sku"></span></p>
                        <p class="mb-1"><strong>HSN/SAC:</strong> <span id="selected_product_hsn"></span></p>
                        <p class="mb-0"><strong>Price:</strong> ₹<span id="selected_product_price"></span></p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="item_quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="item_quantity" min="1" value="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="item_unit_price" class="form-label">Unit Price <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="item_unit_price" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="item_tax_percentage" class="form-label">Tax Percentage</label>
                                <input type="number" class="form-control" id="item_tax_percentage" step="0.01" min="0" max="100" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Total Price</label>
                                <input type="text" class="form-control" id="item_total_display" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="add-item-confirm" disabled>Add Item</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    let orderItems = [];
    let selectedProduct = null;

    // Payment method change handler
    $('#payment_method').on('change', function() {
        const paymentMethod = $(this).val();
        if (paymentMethod === 'visa' || paymentMethod === 'mastercard') {
            $('#card-details, #card-name-field').show();
        } else {
            $('#card-details, #card-name-field').hide();
        }
    });

    // User search functionality
    $('#user_search').on('input', function() {
        const query = $(this).val();
        if (query.length >= 2) {
            $.ajax({
                url: '/e-commerce/search-users',
                method: 'GET',
                data: { query: query },
                success: function(users) {
                    let suggestions = '';
                    users.forEach(function(user) {
                        suggestions += `<a class="dropdown-item user-suggestion" href="#"
                                          data-id="${user.id}"
                                          data-name="${user.name}"
                                          data-email="${user.email}">
                                          ${user.name} - ${user.email}
                                        </a>`;
                    });
                    $('#user_suggestions').html(suggestions).show();
                }
            });
        } else {
            $('#user_suggestions').hide();
        }
    });

    // User selection
    $(document).on('click', '.user-suggestion', function(e) {
        e.preventDefault();
        const userId = $(this).data('id');
        const userName = $(this).data('name');
        const userEmail = $(this).data('email');

        $('#user_id').val(userId);
        $('#user_search').val(userName);
        $('#email').val(userEmail);
        $('#user_suggestions').hide();

        // Auto-fill shipping address if available
        // You can extend this to fetch user's saved address
    });

    // Product search functionality
    $('#product_search').on('input', function() {
        const query = $(this).val();
        if (query.length >= 2) {
            $.ajax({
                url: '/e-commerce/search-products',
                method: 'GET',
                data: { query: query },
                success: function(products) {
                    let suggestions = '';
                    products.forEach(function(product) {
                        suggestions += `<a class="dropdown-item product-suggestion" href="#"
                                          data-id="${product.id}"
                                          data-name="${product.product_name}"
                                          data-sku="${product.sku}"
                                          data-hsn="${product.hsn_code || 'N/A'}"
                                          data-price="${product.price}">
                                          ${product.product_name} - ${product.sku}
                                        </a>`;
                    });
                    $('#product_suggestions').html(suggestions).show();
                }
            });
        } else {
            $('#product_suggestions').hide();
        }
    });

    // Product selection
    $(document).on('click', '.product-suggestion', function(e) {
        e.preventDefault();
        selectedProduct = {
            id: $(this).data('id'),
            name: $(this).data('name'),
            sku: $(this).data('sku'),
            hsn: $(this).data('hsn'),
            price: parseFloat($(this).data('price'))
        };

        $('#product_search').val(selectedProduct.name);
        $('#product_suggestions').hide();

        // Update modal with product details
        $('#selected_product_name').text(selectedProduct.name);
        $('#selected_product_sku').text(selectedProduct.sku);
        $('#selected_product_hsn').text(selectedProduct.hsn);
        $('#selected_product_price').text(selectedProduct.price.toFixed(2));
        $('#item_unit_price').val(selectedProduct.price);

        $('#selected_product_details').show();
        $('#add-item-confirm').prop('disabled', false);

        calculateItemTotal();
    });

    // Add item button
    $('#add-item-btn').on('click', function() {
        $('#addItemModal').modal('show');
        resetItemModal();
    });

    // Calculate item total
    function calculateItemTotal() {
        const quantity = parseInt($('#item_quantity').val()) || 0;
        const unitPrice = parseFloat($('#item_unit_price').val()) || 0;
        const taxPercentage = parseFloat($('#item_tax_percentage').val()) || 0;

        const subtotal = quantity * unitPrice;
        const taxAmount = (subtotal * taxPercentage) / 100;
        const total = subtotal + taxAmount;

        $('#item_total_display').val('₹' + total.toFixed(2));
    }

    // Item quantity/price change handlers
    $('#item_quantity, #item_unit_price, #item_tax_percentage').on('input', calculateItemTotal);

    // Add item confirm
    $('#add-item-confirm').on('click', function() {
        if (!selectedProduct) return;

        const quantity = parseInt($('#item_quantity').val());
        const unitPrice = parseFloat($('#item_unit_price').val());
        const taxPercentage = parseFloat($('#item_tax_percentage').val()) || 0;

        const subtotal = quantity * unitPrice;
        const taxAmount = (subtotal * taxPercentage) / 100;
        const total = subtotal + taxAmount;

        const item = {
            product_id: selectedProduct.id,
            product_name: selectedProduct.name,
            product_sku: selectedProduct.sku,
            hsn_sac_code: selectedProduct.hsn,
            quantity: quantity,
            unit_price: unitPrice,
            tax_percentage: taxPercentage,
            taxable_value: subtotal,
            igst_amount: taxAmount,
            total_price: total
        };

        orderItems.push(item);
        updateOrderItemsDisplay();
        updateOrderSummary();

        $('#addItemModal').modal('hide');
    });

    // Reset item modal
    function resetItemModal() {
        selectedProduct = null;
        $('#product_search').val('');
        $('#selected_product_details').hide();
        $('#add-item-confirm').prop('disabled', true);
        $('#item_quantity').val(1);
        $('#item_unit_price').val('');
        $('#item_tax_percentage').val(0);
        $('#item_total_display').val('');
    }

    // Update order items display
    function updateOrderItemsDisplay() {
        const container = $('#order-items-container');

        if (orderItems.length === 0) {
            $('#no-items-message').show();
            container.empty();
            return;
        }

        $('#no-items-message').hide();

        let html = '<div class="table-responsive"><table class="table table-bordered"><thead class="table-light"><tr><th>Product</th><th>HSN/SAC</th><th>Qty</th><th>Unit Price</th><th>Tax</th><th>Total</th><th>Action</th></tr></thead><tbody>';

        orderItems.forEach(function(item, index) {
            html += `<tr>
                <td>
                    <div><strong>${item.product_name}</strong></div>
                    <small class="text-muted">SKU: ${item.product_sku}</small>
                </td>
                <td>${item.hsn_sac_code}</td>
                <td>${item.quantity}</td>
                <td>₹${item.unit_price.toFixed(2)}</td>
                <td>₹${item.igst_amount.toFixed(2)} (${item.tax_percentage}%)</td>
                <td>₹${item.total_price.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-item" data-index="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>`;

            // Add hidden inputs for form submission
            html += `
                <input type="hidden" name="items[${index}][product_id]" value="${item.product_id}">
                <input type="hidden" name="items[${index}][product_name]" value="${item.product_name}">
                <input type="hidden" name="items[${index}][product_sku]" value="${item.product_sku}">
                <input type="hidden" name="items[${index}][hsn_sac_code]" value="${item.hsn_sac_code}">
                <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                <input type="hidden" name="items[${index}][unit_price]" value="${item.unit_price}">
                <input type="hidden" name="items[${index}][tax_percentage]" value="${item.tax_percentage}">
                <input type="hidden" name="items[${index}][taxable_value]" value="${item.taxable_value}">
                <input type="hidden" name="items[${index}][igst_amount]" value="${item.igst_amount}">
                <input type="hidden" name="items[${index}][total_price]" value="${item.total_price}">
            `;
        });

        html += '</tbody></table></div>';
        container.html(html);
    }

    // Remove item
    $(document).on('click', '.remove-item', function() {
        const index = $(this).data('index');
        orderItems.splice(index, 1);
        updateOrderItemsDisplay();
        updateOrderSummary();
    });

    // Update order summary
    function updateOrderSummary() {
        const subtotal = orderItems.reduce((sum, item) => sum + item.taxable_value, 0);
        const taxAmount = orderItems.reduce((sum, item) => sum + item.igst_amount, 0);
        const shippingCharges = parseFloat($('#shipping_charges').val()) || 0;
        const discountAmount = parseFloat($('#discount_amount').val()) || 0;
        const grandTotal = subtotal + taxAmount + shippingCharges - discountAmount;

        $('#subtotal-display').text('₹' + subtotal.toFixed(2));
        $('#tax-display').text('₹' + taxAmount.toFixed(2));
        $('#shipping-display').text('₹' + shippingCharges.toFixed(2));
        $('#discount-display').text('-₹' + discountAmount.toFixed(2));
        $('#total-display').text('₹' + grandTotal.toFixed(2));
    }

    // Shipping and discount change handlers
    $('#shipping_charges, #discount_amount').on('input', updateOrderSummary);

    // Form submission
    $('#orderForm').on('submit', function(e) {
        if (orderItems.length === 0) {
            e.preventDefault();
            alert('Please add at least one item to the order.');
            return false;
        }
    });

    // Hide dropdowns when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#user_search, #user_suggestions').length) {
            $('#user_suggestions').hide();
        }
        if (!$(e.target).closest('#product_search, #product_suggestions').length) {
            $('#product_suggestions').hide();
        }
    });
});
</script>

@endsection