@extends('crm/layouts/master')

@section('content')

    <div class="content">
        <div class="container-fluid">

            <div class="row py-3">

                <div class="col-12">
                    <div class="card sticky-side-div">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0 flex-grow-1">
                                    Customer Details
                                </h5>
                            </div>
                        </div>


                        <div class="card-body">
                            {{-- Customer Info Table --}}
                            <div class="row">
                                <div class="col-12 mb-3 d-flex justify-content-between align-items-start">
                                    <h4 class="mb-0">{{ $customer->first_name }} {{ $customer->last_name }}</h4>
                                    <a href="{{ route('customer.edit', $customer->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                </div>

                                <div class="col-12">
                                    <table class="table table-bordered table-striped align-middle">
                                        <tbody>
                                            <tr>
                                                <th style="width: 20%;">Customer Code</th>
                                                <td>{{ $customer->customer_code }}</td>
                                            </tr>
                                            <tr>
                                                <th style="width: 20%;">Profile Image</th>
                                                <td>
                                                    @if ($customer->profile)
                                                        <img src="{{ asset('storage/' . $customer->profile) }}"
                                                            alt="Profile Image" class="img-fluid rounded"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 20%;">Name</th>
                                                <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Joining Date</th>
                                                <td>{{ $customer->created_at->format('d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Branch</th>
                                                <td>{{ $customer->branches->count() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td class="text-break">{{ $customer->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>{{ $customer->phone }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <span class="badge bg-success">Active</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Branch Information Table --}}
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="mb-3 fw-bold">Branch Information</h6>

                                    @if ($customer->branches && $customer->branches->count() > 0)
                                        <table class="table table-bordered table-striped align-middle">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Branch Name</th>
                                                    <th>Primary</th>
                                                    <th>Address</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Country</th>
                                                    <th>Pincode</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customer->branches as $index => $branch)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $branch->branch_name }}</td>
                                                        <td>
                                                            @if ($branch->is_primary)
                                                                <span class="badge bg-success">Primary</span>
                                                            @else
                                                                <span class="badge bg-secondary">Secondary</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $branch->address1 }}
                                                            @if ($branch->address2)
                                                                {{ $branch->address2 }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $branch->city }}</td>
                                                        <td>{{ $branch->state }}</td>
                                                        <td>{{ $branch->country }}</td>
                                                        <td>{{ $branch->pincode }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="mdi mdi-information-outline"></i>
                                            No branch information available for this customer.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0 flex-grow-1">
                                    Services Source
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive mb-2">
                                <table class="table table-hover table-nowrap align-middle">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase">
                                            <th>Sr. No.</th>
                                            <th>Service ID</th>
                                            <th>Service Type</th>
                                            <th>Source</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <a href="{{ route('service-request.view-service') }}">
                                                    #1001
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">AMC</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">E-commerce AMC Page</span>
                                            </td>
                                            <td>2022-09-15</td>
                                            <td>
                                                <span class="badge bg-success">Active</span>
                                            </td>
                                            <td>
                                                <a aria-label="anchor" href="{{ route('service-request.view-service') }}"
                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                    data-bs-toggle="tooltip" data-bs-original-title="View">
                                                    <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0 flex-grow-1">
                                    Orders
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive mb-2">
                                <table class="table table-hover table-nowrap align-middle">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase">
                                            <th>Order Number</th>
                                            <th>Products & HSN</th>
                                            <th>Order Totals</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Invoice</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    {{-- <tbody class="list form-check-all">
                                        @php
                                            $allOrders = collect();

                                            foreach ($customer->allEcommerceOrders as $order) {
                                                $allOrders->push([
                                                    'type' => 'ecommerce',
                                                    'order' => $order,
                                                    'date' => $order->created_at
                                                ]);
                                            }

                                            foreach ($customer->crmOrders as $order) {
                                                $allOrders->push([
                                                    'type' => 'crm',
                                                    'order' => $order,
                                                    'date' => $order->created_at
                                                ]);
                                            }

                                            $allOrders = $allOrders->sortByDesc('date');
                                        @endphp

                                        @forelse ($allOrders as $orderData)
                                            @if ($orderData['type'] === 'ecommerce')
                                                @php $order = $orderData['order']; @endphp
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('order.view', $order->id) }}" class="fw-semibold link-primary">
                                                            #{{ $order->order_number }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="small">
                                                            @foreach ($order->orderItems as $item)
                                                                <div class="mb-2 p-2 border rounded">
                                                                    <div class="fw-medium">{{ $item->product_name }}</div>
                                                                    <div class="text-muted">
                                                                        HSN/SAC: <span class="fw-medium">{{ $item->hsn_sac_code ?? 'N/A' }}</span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between">
                                                                        <span>Qty: {{ $item->quantity }}</span>
                                                                        <span>₹{{ number_format($item->unit_price, 2) }}</span>
                                                                    </div>
                                                                    @if ($item->igst_amount > 0)
                                                                        <div class="text-muted">Tax: ₹{{ number_format($item->igst_amount, 2) }}</div>
                                                                    @endif
                                                                    <div class="fw-medium">Total: ₹{{ number_format($item->total_price, 2) }}</div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="small">
                                                            <div>Subtotal: <span class="fw-medium">₹{{ number_format($order->subtotal, 2) }}</span></div>
                                                            @if ($order->shipping_charges > 0)
                                                                <div>Shipping: <span class="fw-medium">₹{{ number_format($order->shipping_charges, 2) }}</span></div>
                                                            @endif
                                                            @if ($order->discount_amount > 0)
                                                                <div class="text-success">Discount: -₹{{ number_format($order->discount_amount, 2) }}</div>
                                                            @endif
                                                            <div class="fw-bold text-success border-top pt-1">
                                                                Grand Total: ₹{{ number_format($order->total_amount, 2) }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($order->payment_method === 'mastercard' || $order->payment_method === 'visa')
                                                            <div>
                                                                <span class="badge bg-info">{{ ucfirst($order->payment_method) }}</span>
                                                                @if ($order->card_last_four)
                                                                    <br><small class="text-muted">**** **** **** {{ $order->card_last_four }}</small>
                                                                @endif
                                                            </div>
                                                        @elseif($order->payment_method === 'cod')
                                                            <span class="badge bg-warning">Cash on Delivery</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ ucfirst($order->payment_method) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusColors = [
                                                                'pending' => 'warning',
                                                                'confirmed' => 'info',
                                                                'processing' => 'primary',
                                                                'shipped' => 'primary',
                                                                'delivered' => 'success',
                                                                'cancelled' => 'danger'
                                                            ];
                                                            $statusColor = $statusColors[$order->status] ?? 'secondary';
                                                        @endphp
                                                        <span class="badge bg-{{ $statusColor }}">{{ ucfirst($order->status) }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('order.invoice', $order->id) }}"
                                                           class="btn btn-sm btn-outline-success" title="Download Invoice" target="_blank">
                                                            <i class="fas fa-file-pdf me-1"></i> PDF
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div>{{ $order->created_at->format('d M Y') }}</div>
                                                        <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('order.view', $order->id) }}"
                                                               class="btn btn-sm btn-outline-info" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                @php $order = $orderData['order']; @endphp
                                                <tr>
                                                    <td>
                                                        <span class="fw-semibold">#CRM-{{ $order->id }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="small">
                                                            <div class="mb-2 p-2 border rounded">
                                                                <div class="fw-medium">{{ $order->product->product_name ?? 'N/A' }}</div>
                                                                <div class="d-flex justify-content-between">
                                                                    <span>Qty: {{ $order->quantity }}</span>
                                                                    <span>₹{{ number_format($order->amount, 2) }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="small">
                                                            <div class="fw-bold text-success">
                                                                Total: ₹{{ number_format($order->amount, 2) }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">N/A</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $order->status === 'Delivered' ? 'success' : 'warning' }}">
                                                            {{ $order->status ?? 'Pending' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if ($order->invoice_file)
                                                            <a href="{{ asset($order->invoice_file) }}"
                                                               class="btn btn-sm btn-outline-success" title="Download Invoice" target="_blank">
                                                                <i class="fas fa-file-pdf me-1"></i> PDF
                                                            </a>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div>{{ $order->created_at->format('d M Y') }}</div>
                                                        <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted">-</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-4">
                                                    <i class="mdi mdi-information-outline"></i>
                                                    No orders found for this customer.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody> --}}

                                    </tbody>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="mdi mdi-information-outline"></i>
                                            No orders found for this customer.
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div> <!-- content -->

@endsection
