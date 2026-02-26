@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Invoice</h4>
                </div>
            </div>

            <!-- End Main Widgets -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-2">
                            <div class="d-flex justify-content-between align-items-center border-bottom">
                                <ul class="nav nav-underline pt-2" id="pills-tab" role="tablist">

                                    {{-- Quotation --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active p-2" id="quotation-tab" data-bs-toggle="tab" href="#quotation" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-sitemap-outline"></i></span>
                                            <span class="d-none d-sm-block">Quotation Invoices</span>
                                        </a>
                                    </li>

                                    {{-- E-commerce --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" id="e-commerce-tab" data-bs-toggle="tab" href="#e-commerce" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                            <span class="d-none d-sm-block">E-commerce Invoice</span>
                                        </a>
                                    </li>

                                    {{-- Service --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" id="service-tab" data-bs-toggle="tab" href="#service" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-sitemap-outline"></i></span>
                                            <span class="d-none d-sm-block">Services Invoice</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content text-muted">

                                <div class="tab-pane active show" id="quotation" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table
                                                        class="table table-striped table-borderless dt-responsive nowrap service-datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>Request ID</th>
                                                                <th>Customer Name</th>
                                                                <th>Request Date</th>
                                                                <th>Product Count</th>
                                                                <th>Payment Status</th>
                                                                <th>Status</th>
                                                                <th>Invoice PDF</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($quotationInvoices as $invoice)
                                                                <tr>
                                                                    <td>{{ $invoice->invoice_number ?? $invoice->id }}</td>
                                                                    <td>
                                                                        <div class="fw-semibold">
                                                                            {{ $invoice->Customer->first_name . ' ' . $invoice->customer->last_name ?? 'N/A' }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $invoice->Customer->email ?? 'N/A' }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $invoice->Customer->phone ?? 'N/A' }}
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                                                                    <td>
                                                                        <div class="fw-semibold">
                                                                            {{ $invoice->items->count() }} Product(s)
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ ucfirst($invoice->payment_status) }}</td>
                                                                    @php
                                                                        $sourceLabels = [
                                                                            'customer' => 'Customer',
                                                                            'system' => 'System',
                                                                            'lead_won' => 'Lead Won',
                                                                        ];
                                                                    @endphp
                                                                    @php
                                                                        $statuses = [
                                                                            'draft' => ['Drafy', 'warning'],
                                                                            'sent' => ['Send', 'info'],
                                                                            'accepted' => ['Accepted', 'success'],
                                                                            'rejected' => ['Rejected', 'danger'],
                                                                            'cancelled' => ['Cancelled', 'danger'],
                                                                        ];
                                                                        [$label, $color] = $statuses[
                                                                            $invoice->status
                                                                        ] ?? [
                                                                            ucfirst($invoice->status ?? 'N/A'),
                                                                            'secondary',
                                                                        ];
                                                                    @endphp
                                                                    <td>
                                                                        <span
                                                                            class="badge bg-{{ $color }}-subtle text-{{ $color }} fw-semibold">
                                                                            {{ $label }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <div class="mt-2">
                                                                            <a href="{{ route('quotation.viewInvoice', $invoice->id) }}" target="_blank"
                                                                                class="btn btn-primary btn-sm">View
                                                                                Invoice</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7" class="text-center text-muted py-4">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-information-outline fs-1"></i>
                                                                            <p class="mt-2">
                                                                                No Quotation Invoices found.
                                                                            </p>
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

                                {{-- E-commerce --}}
                                <div class="tab-pane" id="e-commerce" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table
                                                        class="table table-striped table-borderless dt-responsive nowrap service-datatable" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Order Number</th>
                                                                <th>Customer Info</th>
                                                                <th>Order Date</th>
                                                                <th>Products</th>
                                                                <th>Total Amount</th>
                                                                <th>Payment Method</th>
                                                                <th>Status</th>
                                                                <th>Invoice</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($ecommerceOrders as $order)
                                                                <tr>
                                                                    <td>
                                                                        <a href="{{ route('order.view', $order->id) }}" class="fw-semibold link-primary">
                                                                            #{{ $order->order_number }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="fw-medium">
                                                                            {{ $order->customer ? $order->customer->first_name . ' ' . $order->customer->last_name : 'N/A' }}
                                                                        </div>
                                                                        <small class="text-muted">
                                                                            {{ $order->customer ? $order->customer->email : 'N/A' }}
                                                                        </small>
                                                                    </td>
                                                                    <td>
                                                                        <div>{{ $order->created_at->format('d M Y') }}</div>
                                                                        <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                                                    </td>
                                                                    <td>
                                                                        {{ $order->orderItems->sum('quantity') }} Product(s)
                                                                    </td>
                                                                    <td>
                                                                        <span class="fw-semibold">₹{{ number_format($order->total_amount, 2) }}</span>
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $paymentMethods = [
                                                                                'online' => 'Online',
                                                                                'cod' => 'Cash on Delivery',
                                                                                'cheque' => 'Cheque',
                                                                                'bank_transfer' => 'Bank Transfer',
                                                                            ];
                                                                        @endphp
                                                                        {{ $paymentMethods[$order->orderPayments->first()->payment_method ?? 'cod'] ?? ucfirst($order->orderPayments->first()->payment_method ?? 'N/A') }}
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $statusColors = [
                                                                                'pending' => 'warning',
                                                                                'confirmed' => 'info',
                                                                                'processing' => 'primary',
                                                                                'shipped' => 'primary',
                                                                                'delivered' => 'success',
                                                                                'cancelled' => 'danger',
                                                                            ];
                                                                        @endphp
                                                                        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}-subtle text-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                                            {{ ucfirst($order->status) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('order.invoice', $order->id) }}" target="_blank"
                                                                            class="btn btn-sm btn-outline-primary">
                                                                            <i class="fas fa-file-pdf me-1"></i> View
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="8" class="text-center text-muted py-4">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-information-outline fs-1"></i>
                                                                            <p class="mt-2">
                                                                                No E-commerce Orders found.
                                                                            </p>
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

                                {{-- Repairing services --}}
                                <div class="tab-pane" id="service" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table
                                                        class="table table-striped table-borderless dt-responsive nowrap service-datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>Request ID</th>
                                                                <th>Customer Name</th>
                                                                <th>Request Date</th>
                                                                <th>Product Name / Model No</th>
                                                                <th>Request Status</th>
                                                                <th>Request Source</th>
                                                                <th>Assign Engineer</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="9" class="text-center text-muted py-4">
                                                                    <div class="text-muted">
                                                                        <i class="mdi mdi-information-outline fs-1"></i>
                                                                        <p class="mt-2">
                                                                            No Services Invoices found.
                                                                        </p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> {{-- tab-content --}}
                        </div>
                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- container-fluid -->
    </div> <!-- content -->

    <script>
        $(document).ready(function() {
            $('.service-datatable').each(function() {
                if (!$.fn.DataTable.isDataTable(this)) {
                    $(this).DataTable({
                        pageLength: 10
                    });
                }
            });
        });
    </script>
@endsection
