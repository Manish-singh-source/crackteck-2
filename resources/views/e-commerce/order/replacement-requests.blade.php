@extends('e-commerce/layouts/master')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header border-bottom-dashed d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Replacement Requests</h5>
            <a href="{{ route('order.index') }}" class="btn btn-sm btn-outline-secondary">Back to Orders</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Request</th>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Current Product</th>
                            <th>Replacement</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($replacementRequests as $request)
                            <tr>
                                <td>{{ $request->request_number }}</td>
                                <td>{{ $request->order->order_number ?? 'N/A' }}</td>
                                <td>{{ $request->order->customer->first_name ?? '' }} {{ $request->order->customer->last_name ?? '' }}</td>
                                <td>{{ $request->originalProduct->product_name ?? $request->orderItem->product_name ?? 'N/A' }}</td>
                                <td>{{ $request->replacementProduct->warehouseProduct->product_name ?? 'N/A' }}</td>
                                <td><span class="badge bg-info">{{ ucfirst($request->status) }}</span></td>
                                <td>{{ $request->assignedPerson->first_name ?? 'Not assigned' }} {{ $request->assignedPerson->last_name ?? '' }}</td>
                                <td><a href="{{ route('order.view', $request->order_id) }}" class="btn btn-sm btn-primary">Manage</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No replacement requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $replacementRequests->links() }}
        </div>
    </div>
</div>
@endsection

