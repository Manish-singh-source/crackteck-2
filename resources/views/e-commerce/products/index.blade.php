@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Products List</h4>
                </div>
                <div>
                    <a href="{{ route('ec.product.create') }}" class="btn btn-primary">Add New Product</a>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            @php
                                $statuses = [
                                    'all' => ['label' => 'All', 'icon' => 'mdi-format-list-bulleted', 'color' => ''],
                                    'active' => [
                                        'label' => 'Active',
                                        'icon' => 'mdi-check-circle-outline',
                                        'color' => 'text-success',
                                    ],
                                    'inactive' => [
                                        'label' => 'Inactive',
                                        'icon' => 'mdi-close-circle-outline',
                                        'color' => 'text-danger',
                                    ],
                                    'draft' => [
                                        'label' => 'Draft',
                                        'icon' => 'mdi-pause-circle-outline',
                                        'color' => 'text-warning',
                                    ],
                                ];

                                $currentStatus = request()->get('status') ?? 'all';
                            @endphp

                            <ul class="nav nav-underline border-bottom" id="pills-tab" role="tablist">
                                @foreach ($statuses as $key => $status)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $currentStatus === $key ? 'active' : '' }} p-2"
                                            href="{{ $key === 'all' ? route('ec.product.index') : route('ec.product.index', ['status' => $key]) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i
                                                    class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>{{ $status['label'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content text-muted">

                                <div class="tab-pane active show" id="all_customer" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Categories - Sold Item</th>
                                                                <th>Info</th>
                                                                <th>Top Item - Todays Deal</th>
                                                                <th>Quantity</th>
                                                                <th>Time - Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($products as $product)
                                                                <tr class="align-middle">
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="me-3">
                                                                                @if ($product->warehouseProduct && $product->warehouseProduct->main_product_image)
                                                                                    <img src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                                                        alt="{{ $product->product_name }}"
                                                                                        width="80" height="80"
                                                                                        class="img-fluid rounded">
                                                                                @else
                                                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                                                        style="width: 80px; height: 80px;">
                                                                                        <i
                                                                                            class="mdi mdi-image fs-24 text-muted"></i>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                            <div>
                                                                                <div class="fw-semibold">
                                                                                    {{ $product->warehouseProduct->product_name }}
                                                                                </div>
                                                                                <div class="text-muted">
                                                                                    Brand:
                                                                                    {{ $product->warehouseProduct->brand->name ?? 'N/A' }}
                                                                                </div>
                                                                                <div class="text-muted small">
                                                                                    SKU: {{ $product->sku }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        @if ($product->warehouseProduct && $product->warehouseProduct->parentCategorie)
                                                                            <span
                                                                                class="badge bg-primary-subtle text-primary fw-semibold">
                                                                                {{ $product->warehouseProduct->parentCategorie->name }}
                                                                            </span>
                                                                        @endif
                                                                        <div class="mt-1">
                                                                            Total Sold: {{ $product->total_sold }}
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div>
                                                                            Regular price:
                                                                            ₹{{ number_format($product->warehouseProduct->final_price, 2) }}
                                                                        </div>
                                                                        @if ($product->warehouseProduct->discount_price)
                                                                            <div>
                                                                                Discount Price:
                                                                                ₹{{ number_format($product->warehouseProduct->discount_price, 2) }}
                                                                            </div>
                                                                        @endif
                                                                        <div>
                                                                            <span
                                                                                class="text-{{ $product->is_best_seller ? 'success' : 'muted' }}">
                                                                                Best Seller:
                                                                                {{ $product->is_best_seller ? 'Yes' : 'No' }}
                                                                            </span>
                                                                        </div>
                                                                        <div>
                                                                            <span
                                                                                class="text-{{ $product->is_suggested ? 'success' : 'muted' }}">
                                                                                Suggested:
                                                                                {{ $product->is_suggested ? 'Yes' : 'No' }}
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="text-{{ $product->is_featured ? 'success' : 'muted' }}">
                                                                            Featured:
                                                                            {{ $product->is_featured ? 'Yes' : 'No' }}
                                                                        </span>
                                                                        <span><br></span>
                                                                        <span
                                                                            class="text-{{ $product->is_todays_deal ? 'success' : 'muted' }}">
                                                                            Today's Deal:
                                                                            {{ $product->is_todays_deal ? 'Yes' : 'No' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>{{ $product->warehouseProduct->stock_quantity }}</td>
                                                                    <td>
                                                                        <div>
                                                                            {{ $product->created_at->format('d M Y') }}
                                                                        </div>
                                                                        {{-- active 
                                                                        inactive
                                                                        draft --}}
                                                                        <span class="badge bg-{{ $product->status === 'active' ? 'success' : ($product->status === 'inactive' ? 'danger' : 'warning') }}-subtle text-{{ $product->status === 'active' ? 'success' : ($product->status === 'inactive' ? 'danger' : 'warning') }} fw-semibold">
                                                                            {{ ucfirst($product->status) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('ec.product.view', $product->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('ec.product.edit', $product->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <button aria-label="anchor" type="button"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle delete-product"
                                                                            data-product-id="{{ $product->id }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Delete">
                                                                            <i
                                                                                class="mdi mdi-delete fs-14 text-danger"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7" class="text-center py-4">
                                                                        <div class="text-muted">
                                                                            <i
                                                                                class="mdi mdi-package-variant-closed fs-48 mb-3 d-block"></i>
                                                                            <h5>No E-commerce Products Found</h5>
                                                                            <p>Start by creating your first e-commerce
                                                                                product from warehouse inventory.</p>
                                                                            <a href="{{ route('ec.product.create') }}"
                                                                                class="btn btn-primary">
                                                                                <i class="mdi mdi-plus me-1"></i> Add New
                                                                                Product
                                                                            </a>
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

                                    <!-- Pagination -->
                                    @if ($products->hasPages())
                                        <div class="card-footer">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="text-muted">
                                                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of
                                                    {{ $products->total() }} results
                                                </div>
                                                <div>
                                                    {{ $products->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center me-2"
                            style="width: 40px; height: 40px;">
                            <i class="mdi mdi-alert-circle-outline fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="deleteModalLabel">
                                Delete E-commerce Product
                            </h5>
                            <small class="text-muted">This action cannot be undone</small>
                        </div>
                    </div>
                    {{-- <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>

                <div class="modal-body pt-3">
                    <div class="alert alert-danger border-0 d-flex align-items-start">
                        <i class="mdi mdi-trash-can-outline me-2 fs-4"></i>
                        <div>
                            <p class="mb-1">
                                Are you sure you want to permanently remove this product from the e-commerce store?
                            </p>
                            <p class="mb-0 text-muted">
                                <strong>Note:</strong> The underlying warehouse product will remain in the warehouse system.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="mdi mdi-delete-forever me-1"></i> Delete from E-commerce
                    </button>
                </div>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            let productIdToDelete = null;

            // Handle delete button click
            $('.delete-product').on('click', function() {
                productIdToDelete = $(this).data('product-id');
                $('#deleteModal').modal('show');
            });

            // Handle confirm delete
            $('#confirmDelete').on('click', function() {
                if (productIdToDelete) {
                    $.ajax({
                        url: `{{ route('ec.product.delete', ':id') }}`.replace(':id',
                            productIdToDelete),
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#deleteModal').modal('hide');
                                location.reload(); // Reload the page to reflect changes
                            } else {
                                alert(response.message || 'Error deleting product');
                            }
                        },
                        error: function(xhr) {
                            let message = 'Error deleting product';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            alert(message);
                        }
                    });
                }
            });

            // Clear productIdToDelete when modal is hidden
            $('#deleteModal').on('hidden.bs.modal', function() {
                productIdToDelete = null;
            });
        });
    </script>
@endsection
