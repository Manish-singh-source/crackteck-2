@extends('crm/layouts/master')

@section('content')

    <div class="content">
        <div class="container-fluid">

            <div class="row pt-3">
                <div class="col-xl-12 mx-auto">

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Customer Details
                                </h5>
                                <div class="fw-bold text-dark">
                                    {{ $quotation->quote_id }}
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">


                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush ">

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Customer Name :
                                            </span>
                                            <span>
                                                {{ $quotation->leadDetails->customer->first_name }}
                                                {{ $quotation->leadDetails->customer->last_name }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Contact no :
                                            </span>
                                            <span>
                                                {{ $quotation->leadDetails->customer->phone }}
                                            </span>
                                        </li>

                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush ">

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Email :
                                            </span>
                                            <span>
                                                {{ $quotation->leadDetails->customer->email }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Company Name :
                                            </span>
                                            <span>
                                                {{ $quotation->leadDetails->companyDetails->company_name ?? 'N/A' }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Address/Branch Details
                                </h5>

                            </div>
                        </div>

                        <div class="card-body">
                            @if ($quotation->leadDetails->customerAddress)
                                @php
                                    $branch = $quotation->leadDetails->customerAddress;
                                @endphp
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <ul class="list-group list-group-flush ">
                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">Branch Name :
                                                </span>
                                                <span>
                                                    {{ $branch->branch_name ?? 'N/A' }}
                                                </span>
                                            </li>
                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">Address Line 1 :
                                                </span>
                                                <span>
                                                    {{ $branch->address1 ?? 'N/A' }}
                                                </span>
                                            </li>
                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">City :
                                                </span>
                                                <span>
                                                    {{ $branch->city ?? 'N/A' }}
                                                </span>
                                            </li>
                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">Country :
                                                </span>
                                                <span>
                                                    {{ $branch->country ?? 'N/A' }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="list-group list-group-flush ">
                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">
                                                </span>
                                            </li>
                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">Address Line 2 :
                                                </span>
                                                <span>
                                                    {{ $branch->address2 ?? 'N/A' }}
                                                </span>
                                            </li>
                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">State :
                                                </span>
                                                <span>
                                                    {{ $branch->state ?? 'N/A' }}
                                                </span>
                                            </li>
                                            <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                <span class="fw-semibold text-break">Pincode :
                                                </span>
                                                <span>
                                                    {{ $branch->pincode ?? 'N/A' }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-muted">No branch details available.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    AMC Details
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            @if ($quotation->amcDetail)
                                @foreach ($quotation->amcDetail as $amcDetail)
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush">
                                                <li
                                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Plan Name:
                                                    </span>
                                                    <span>
                                                        {{ $amcDetail->amcPlan->plan_name ?? 'N/A' }}
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Duration (Months) :
                                                    </span>
                                                    <span>
                                                        {{ $amcDetail->plan_duration ?? 'N/A' }}
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Start From :
                                                    </span>
                                                    <span>
                                                        {{ $amcDetail->plan_start_date ? \Carbon\Carbon::parse($amcDetail->plan_start_date)->format('Y-m-d h:i A') : 'N/A' }}
                                                    </span>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Total Visits :
                                                    </span>
                                                    <span>
                                                        {{ $amcDetail->amcPlan->total_visits ?? 'N/A' }}
                                                    </span>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Priority Level :
                                                    </span>
                                                    <span>
                                                        {{ $amcDetail->priority_level ?? 'N/A' }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush">

                                                <li
                                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Plan Type :
                                                    </span>
                                                    <span>
                                                        AMC
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Description :
                                                    </span>
                                                    <span>
                                                        {{ $amcDetail->amcPlan->description ?? 'N/A' }}
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">End From :
                                                    </span>
                                                    <span>
                                                        {{ $amcDetail->plan_end_date ? \Carbon\Carbon::parse($amcDetail->plan_end_date)->format('Y-m-d h:i A') : 'N/A' }}
                                                    </span>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Total Amount :
                                                    </span>
                                                    <span>
                                                        ₹{{ number_format($amcDetail->total_amount ?? 0, 2) }}
                                                    </span>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Additional Notes :
                                                    </span>
                                                    <span>
                                                        {{ $amcDetail->additional_notes ?? 'N/A' }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-muted">No AMC details available.</p>
                                    </div>
                                </div>
                            @endif
                        </div>


                    </div>

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Product Details
                                </h5>
                            </div>
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
                                        <th>Sub Total</th>
                                        <th>Tax (%)</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($quotation->products && $quotation->products->count() > 0)
                                        @foreach ($quotation->products as $product)
                                            <tr class="align-middle">
                                                <td>
                                                    <div>
                                                        {{ $product->product_name }}
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $product->hsn_code ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ $product->sku ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    ₹{{ number_format($product->unit_price, 2) }}
                                                </td>
                                                <td>
                                                    {{ $product->quantity }}
                                                </td>
                                                <td>
                                                    ₹{{ number_format($product->unit_price * $product->quantity, 2) }}
                                                </td>
                                                <td>
                                                    {{ $product->tax_rate }}%
                                                </td>
                                                <td>
                                                    ₹{{ number_format($product->line_total, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">No products available.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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
            // Toggle between Individual and Group sections
            $('input[name="assignment_type"]').change(function() {
                if ($(this).val() === 'Individual') {
                    $('#individualSection').show();
                    $('#groupSection').hide();
                    // Clear group fields
                    $('#group_name').val('');
                    $('.engineer-checkbox').prop('checked', false);
                    $('input[name="supervisor_id"]').prop('checked', false);
                } else {
                    $('#individualSection').hide();
                    $('#groupSection').show();
                    // Clear individual field
                    $('#engineer_id').val('');
                }
            });

            // Sync checkbox with supervisor radio
            $('.engineer-checkbox').change(function() {
                const engineerId = $(this).val();
                const supervisorRadio = $('input[name="supervisor_id"][value="' + engineerId + '"]');

                if (!$(this).is(':checked')) {
                    // If unchecked, also uncheck supervisor radio
                    supervisorRadio.prop('checked', false);
                }
            });

            // Ensure supervisor is also checked as engineer
            $('input[name="supervisor_id"]').change(function() {
                const engineerId = $(this).val();
                const engineerCheckbox = $('.engineer-checkbox[value="' + engineerId + '"]');

                if (!engineerCheckbox.is(':checked')) {
                    engineerCheckbox.prop('checked', true);
                }
            });

            // Form submission
            $('#assignEngineerForm').submit(function(e) {
                e.preventDefault();

                const assignmentType = $('input[name="assignment_type"]:checked').val();

                // Validation
                if (assignmentType === 'Individual') {
                    if (!$('#engineer_id').val()) {
                        alert('Please select an engineer');
                        return;
                    }
                } else if (assignmentType === 'Group') {
                    if (!$('#group_name').val()) {
                        alert('Please enter group name');
                        return;
                    }

                    const checkedEngineers = $('.engineer-checkbox:checked').length;
                    if (checkedEngineers === 0) {
                        alert('Please select at least one engineer');
                        return;
                    }

                    if (!$('input[name="supervisor_id"]:checked').val()) {
                        alert('Please select a supervisor');
                        return;
                    }
                }

                // Submit via AJAX
                const formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('quotation.assign-engineer') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON?.message ||
                            'Error assigning engineer. Please try again.';
                        alert(error);
                    }
                });
            });
        });
    </script>
@endsection
