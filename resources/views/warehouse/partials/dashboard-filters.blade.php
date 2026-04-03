<div class="card border-0 shadow-sm warehouse-filter-card">
    <div class="card-body p-3 p-xl-4">
        <form id="warehouseDashboardFilters" class="row g-3 align-items-end">
            <div class="col-md-3 col-xl-2">
                <label class="form-label small text-muted">Date From</label>
                <input type="date" class="form-control" name="date_from" value="{{ $initialFilters['date_from'] }}">
            </div>
            <div class="col-md-3 col-xl-2">
                <label class="form-label small text-muted">Date To</label>
                <input type="date" class="form-control" name="date_to" value="{{ $initialFilters['date_to'] }}">
            </div>
            <div class="col-md-3 col-xl-2">
                <label class="form-label small text-muted">Warehouse</label>
                <select class="form-select" name="warehouse_id"><option value="">All Warehouses</option>@foreach ($filterOptions['warehouses'] as $warehouse)<option value="{{ $warehouse->id }}" @selected((int) $initialFilters['warehouse_id'] === $warehouse->id)>{{ $warehouse->name }}</option>@endforeach</select>
            </div>
            <div class="col-md-3 col-xl-2">
                <label class="form-label small text-muted">Vendor</label>
                <select class="form-select" name="vendor_id"><option value="">All Vendors</option>@foreach ($filterOptions['vendors'] as $vendor)<option value="{{ $vendor->id }}" @selected((int) $initialFilters['vendor_id'] === $vendor->id)>{{ trim($vendor->first_name . ' ' . $vendor->last_name) }}</option>@endforeach</select>
            </div>
            <div class="col-md-3 col-xl-2">
                <label class="form-label small text-muted">Category</label>
                <select class="form-select" name="category_id" id="dashboardCategoryFilter"><option value="">All Categories</option>@foreach ($filterOptions['categories'] as $category)<option value="{{ $category->id }}" @selected((int) $initialFilters['category_id'] === $category->id)>{{ $category->name }}</option>@endforeach</select>
            </div>
            <div class="col-md-3 col-xl-2">
                <label class="form-label small text-muted">Subcategory</label>
                <select class="form-select" name="subcategory_id" id="dashboardSubcategoryFilter" data-selected="{{ $initialFilters['subcategory_id'] }}"><option value="">All Subcategories</option></select>
            </div>
            <div class="col-md-3 col-xl-2">
                <label class="form-label small text-muted">Brand</label>
                <select class="form-select" name="brand_id"><option value="">All Brands</option>@foreach ($filterOptions['brands'] as $brand)<option value="{{ $brand->id }}" @selected((int) $initialFilters['brand_id'] === $brand->id)>{{ $brand->name }}</option>@endforeach</select>
            </div>
            <div class="col-md-3 col-xl-2">
                <label class="form-label small text-muted">Order Status</label>
                <select class="form-select" name="order_status"><option value="">All Statuses</option>@foreach ($filterOptions['order_statuses'] as $value => $label)<option value="{{ $value }}" @selected($initialFilters['order_status'] === $value)>{{ $label }}</option>@endforeach</select>
            </div>
            <div class="col-md-3 col-xl-2">
                <label class="form-label small text-muted">Payment Method</label>
                <select class="form-select" name="payment_method"><option value="">All Methods</option>@foreach ($filterOptions['payment_methods'] as $value => $label)<option value="{{ $value }}" @selected($initialFilters['payment_method'] === $value)>{{ $label }}</option>@endforeach</select>
            </div>
            <div class="col-md-3 col-xl-2">
                <label class="form-label small text-muted">Review Status</label>
                <select class="form-select" name="review_status"><option value="">All Reviews</option>@foreach ($filterOptions['review_statuses'] as $value => $label)<option value="{{ $value }}" @selected($initialFilters['review_status'] === $value)>{{ $label }}</option>@endforeach</select>
            </div>
            <div class="col-md-3 col-xl-2">
                <label class="form-label small text-muted">Customer Type</label>
                <select class="form-select" name="customer_type"><option value="">All Customers</option>@foreach ($filterOptions['customer_types'] as $value => $label)<option value="{{ $value }}" @selected($initialFilters['customer_type'] === $value)>{{ $label }}</option>@endforeach</select>
            </div>
            <div class="col-12 d-flex flex-wrap gap-2 justify-content-end">
                <button type="submit" class="btn btn-primary px-4"><i class="fas fa-filter me-2"></i>Apply Filters</button>
                <button type="button" class="btn btn-light border" id="resetDashboardFilters">Reset</button>
            </div>
        </form>
    </div>
</div>
