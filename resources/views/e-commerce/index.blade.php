@extends('e-commerce/layouts/master')

@section('content')
@php
    $dashboard = $data;
    $summaryCards = $dashboard['summary_cards']['cards'] ?? [];
@endphp

<div class="content">
    <div class="container-fluid ecommerce-dashboard" id="ecDashboardApp">
        <div class="dashboard-hero">
            <div>
                <span class="dashboard-kicker">E-commerce intelligence hub</span>
                <h2 class="dashboard-title">Modern Admin Dashboard</h2>
                <p class="dashboard-subtitle mb-0">A responsive analytics layer built on live orders, products, customers, reviews, inventory, payments, variants, categories, brands, and contacts.</p>
            </div>
            <div class="hero-badge">
                <span class="hero-badge-label">Range</span>
                <strong>{{ \Carbon\Carbon::parse($filters['date_from'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($filters['date_to'])->format('d M Y') }}</strong>
            </div>
        </div>

        <div class="dashboard-card assumption-card">
            <div class="d-flex align-items-start gap-3">
                <div class="assumption-icon"><i class="fa-solid fa-circle-info"></i></div>
                <div>
                    <h6 class="mb-2">Implementation assumptions used for this dashboard</h6>
                    <ul class="assumption-list mb-0">
                        @foreach ($dashboard['meta']['assumptions'] as $assumption)
                            <li>{{ $assumption }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <form id="dashboardFilters" class="dashboard-card filter-shell">
            <div class="section-heading mb-3">
                <div>
                    <span class="eyebrow">Global Filters</span>
                    <h5 class="mb-0">Slice every analytics block from one control bar</h5>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <button type="button" class="btn btn-soft active" data-preset="last_30_days">Last 30 Days</button>
                    <button type="button" class="btn btn-soft" data-preset="last_7_days">Last 7 Days</button>
                    <button type="button" class="btn btn-soft" data-preset="today">Today</button>
                    <button type="button" class="btn btn-soft" data-preset="this_month">This Month</button>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Date From</label>
                    <input type="date" class="form-control dashboard-input" name="date_from" value="{{ $filters['date_from'] }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date To</label>
                    <input type="date" class="form-control dashboard-input" name="date_to" value="{{ $filters['date_to'] }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Category</label>
                    <select class="form-select dashboard-input" name="category_id" id="globalCategory">
                        <option value="">All Categories</option>
                        @foreach ($filters['categories'] as $category)
                            <option value="{{ $category->id }}" @selected(($filters['category_id'] ?? null) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Subcategory</label>
                    <select class="form-select dashboard-input" name="sub_category_id" id="globalSubCategory">
                        <option value="">All Subcategories</option>
                        @foreach ($filters['subCategories'] as $subCategory)
                            <option value="{{ $subCategory->id }}" data-parent="{{ $subCategory->parent_category_id }}" @selected(($filters['sub_category_id'] ?? null) == $subCategory->id)>{{ $subCategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Brand</label>
                    <select class="form-select dashboard-input" name="brand_id">
                        <option value="">All Brands</option>
                        @foreach ($filters['brands'] as $brand)
                            <option value="{{ $brand->id }}" @selected(($filters['brand_id'] ?? null) == $brand->id)>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Order Status</label>
                    <select class="form-select dashboard-input" name="order_status">
                        <option value="">All Order Statuses</option>
                        @foreach ($filters['orderStatuses'] as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['order_status'] ?? null) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Payment Method</label>
                    <select class="form-select dashboard-input" name="payment_method">
                        <option value="">All Payment Methods</option>
                        @foreach ($filters['paymentMethods'] as $method)
                            <option value="{{ $method }}" @selected(($filters['payment_method'] ?? null) === $method)>{{ ucwords(str_replace('_', ' ', $method)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Review Status</label>
                    <select class="form-select dashboard-input" name="review_status">
                        <option value="">All Reviews</option>
                        @foreach ($filters['reviewStatuses'] as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['review_status'] ?? null) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Customer Type</label>
                    <select class="form-select dashboard-input" name="customer_type">
                        <option value="">All Customers</option>
                        @foreach ($filters['customerTypes'] as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['customer_type'] ?? null) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="applyFilters" class="btn btn-primary w-100">Apply Filters</button>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="resetFilters" class="btn btn-light w-100">Reset</button>
                </div>
            </div>
            <input type="hidden" name="date_preset" value="{{ $filters['date_preset'] }}">
        </form>

        <div class="row g-3 mb-4" id="summaryCardsGrid">
            @foreach ($summaryCards as $card)
                @include('e-commerce.partials.dashboard-stat-card', ['card' => $card])
            @endforeach
        </div>

        <div class="row g-3">
            <div class="col-xl-8">
                <div class="dashboard-card section-card h-100">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow">Sales Analytics</span>
                            <h5 class="mb-1">Revenue and order movement</h5>
                            <p class="section-copy mb-0">Track current period performance against the previous period.</p>
                        </div>
                        <div class="chip-group">
                            <button type="button" class="chip active" data-sales-preset="today">Today</button>
                            <button type="button" class="chip" data-sales-preset="last_7_days">7D</button>
                            <button type="button" class="chip" data-sales-preset="last_30_days">30D</button>
                            <button type="button" class="chip" data-sales-preset="this_month">Month</button>
                        </div>
                    </div>
                    <div class="row g-3 mb-3" id="salesOverview"></div>
                    <div id="salesChart" class="chart-shell chart-lg"></div>
                    <div class="row g-3 mt-1" id="salesComparisonTiles"></div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="dashboard-card section-card h-100">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow">Order Insights</span>
                            <h5 class="mb-1">Status mix and fulfillment health</h5>
                            <p class="section-copy mb-0">Normalized from the project-specific delivery lifecycle.</p>
                        </div>
                    </div>
                    <div id="orderStatusChart" class="chart-shell chart-md"></div>
                    <div class="row g-3 mt-1" id="orderInsightMetrics"></div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-xl-7">
                <div class="dashboard-card section-card h-100">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow">Recent Orders</span>
                            <h5 class="mb-1">Latest transactions in card view</h5>
                        </div>
                        <div class="chip-group">
                            <button type="button" class="chip active" data-order-filter="">All</button>
                            <button type="button" class="chip" data-order-filter="pending">Pending</button>
                            <button type="button" class="chip" data-order-filter="delivered">Delivered</button>
                            <button type="button" class="chip" data-order-filter="cancelled">Cancelled</button>
                        </div>
                    </div>
                    <div id="recentOrdersList" class="stack-list"></div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="dashboard-card section-card h-100">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow">Revenue Breakdown</span>
                            <h5 class="mb-1">Payment method distribution</h5>
                        </div>
                    </div>
                    <div id="paymentChart" class="chart-shell chart-md"></div>
                    <div id="paymentBreakdownList" class="stack-list compact-list"></div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-xl-12">
                <div class="dashboard-card section-card">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow">Product Performance</span>
                            <h5 class="mb-1">Best sellers, slow movers, and most reviewed SKUs</h5>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-xl-6">
                            <h6 class="subsection-title">Top Selling Products</h6>
                            <div id="topSellingGrid" class="product-grid"></div>
                        </div>
                        <div class="col-xl-3">
                            <h6 class="subsection-title">Worst Performing</h6>
                            <div id="worstProductsList" class="stack-list compact-list"></div>
                        </div>
                        <div class="col-xl-3">
                            <h6 class="subsection-title">Most Reviewed</h6>
                            <div id="reviewedProductsList" class="stack-list compact-list"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-xl-6">
                <div class="dashboard-card section-card h-100">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow">Category & Subcategory</span>
                            <h5 class="mb-1">Category contribution to revenue</h5>
                        </div>
                    </div>
                    <div class="row g-3 mb-3" id="categoryHighlights"></div>
                    <div id="categorySalesChart" class="chart-shell chart-md"></div>
                    <div id="subcategoryList" class="stack-list compact-list mt-3"></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="dashboard-card section-card h-100">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow">Brands</span>
                            <h5 class="mb-1">Brand-wise contribution and activity</h5>
                        </div>
                    </div>
                    <div class="row g-3 mb-3" id="brandHighlights"></div>
                    <div id="brandSalesChart" class="chart-shell chart-md"></div>
                    <div id="brandList" class="stack-list compact-list mt-3"></div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-xl-5">
                <div class="dashboard-card section-card h-100">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow">Variant Insights</span>
                            <h5 class="mb-1">Attribute and value usage across catalog</h5>
                        </div>
                    </div>
                    <div class="row g-3 mb-3" id="variantHighlights"></div>
                    <div id="variantAttributeList" class="stack-list compact-list"></div>
                    <div id="variantValueList" class="stack-list compact-list mt-3"></div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="dashboard-card section-card h-100">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow">Customer Insights</span>
                            <h5 class="mb-1">Growth, value, and loyalty signals</h5>
                        </div>
                        <div class="chip-group">
                            <button type="button" class="chip active" data-customer-filter="">All</button>
                            <button type="button" class="chip" data-customer-filter="new">New</button>
                            <button type="button" class="chip" data-customer-filter="returning">Returning</button>
                        </div>
                    </div>
                    <div class="row g-3 mb-3" id="customerHighlights"></div>
                    <div id="customerGrowthChart" class="chart-shell chart-md"></div>
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <h6 class="subsection-title">Top by Orders</h6>
                            <div id="topCustomersByOrders" class="stack-list compact-list"></div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="subsection-title">Top by Spend</h6>
                            <div id="topCustomersBySpend" class="stack-list compact-list"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-xl-7">
                <div class="dashboard-card section-card h-100">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow">Reviews & Ratings</span>
                            <h5 class="mb-1">Review quality, moderation, and product sentiment</h5>
                        </div>
                        <div class="chip-group">
                            <button type="button" class="chip active" data-review-filter="">All</button>
                            <button type="button" class="chip" data-review-filter="active">Active</button>
                            <button type="button" class="chip" data-review-filter="inactive">Inactive</button>
                        </div>
                    </div>
                    <div class="row g-3 mb-3" id="reviewHighlights"></div>
                    <div id="ratingDistributionChart" class="chart-shell chart-md"></div>
                    <div class="row g-3 mt-1">
                        <div class="col-md-4">
                            <h6 class="subsection-title">Most Reviewed</h6>
                            <div id="mostReviewedProducts" class="stack-list compact-list"></div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="subsection-title">Best Rated</h6>
                            <div id="bestRatedProducts" class="stack-list compact-list"></div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="subsection-title">Needs Attention</h6>
                            <div id="poorRatedProducts" class="stack-list compact-list"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="dashboard-card section-card h-100">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow">Latest Reviews</span>
                            <h5 class="mb-1">Fresh feedback cards</h5>
                        </div>
                    </div>
                    <div id="latestReviewsList" class="stack-list"></div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1 mb-4">
            <div class="col-xl-6">
                <div class="dashboard-card section-card h-100">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow">Inventory Overview</span>
                            <h5 class="mb-1">Stock health and depletion watchlist</h5>
                        </div>
                    </div>
                    <div class="row g-3 mb-3" id="inventoryHighlights"></div>
                    <div id="inventoryDistributionChart" class="chart-shell chart-md"></div>
                    <div id="inventoryWatchList" class="stack-list compact-list mt-3"></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="dashboard-card section-card h-100">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow">Contact & Inquiry Activity</span>
                            <h5 class="mb-1">Inbound lead pulse from contact requests</h5>
                        </div>
                    </div>
                    <div class="row g-3 mb-3" id="contactHighlights"></div>
                    <div id="contactTrendChart" class="chart-shell chart-md"></div>
                    <div id="contactMessageList" class="stack-list mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .ecommerce-dashboard {
        padding-top: 1.25rem;
        padding-bottom: 2rem;
        background:
            radial-gradient(circle at top left, rgba(72, 164, 255, 0.12), transparent 24%),
            radial-gradient(circle at top right, rgba(42, 188, 148, 0.10), transparent 20%),
            linear-gradient(180deg, #f5f8fc 0%, #f7fafc 100%);
    }

    .dashboard-hero,
    .dashboard-card {
        border-radius: 24px;
        border: 1px solid rgba(16, 24, 40, 0.08);
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.08);
    }

    .dashboard-hero {
        padding: 1.6rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .dashboard-kicker,
    .eyebrow {
        text-transform: uppercase;
        font-size: 0.73rem;
        letter-spacing: 0.14em;
        color: #4f7cff;
        font-weight: 700;
    }

    .dashboard-title {
        font-size: 2rem;
        font-weight: 800;
        color: #122033;
        margin-bottom: 0.4rem;
    }

    .dashboard-subtitle,
    .section-copy {
        color: #5f6f86;
        max-width: 760px;
    }

    .hero-badge {
        padding: 1rem 1.2rem;
        border-radius: 18px;
        background: linear-gradient(135deg, #0f172a, #1d3557);
        color: #fff;
        min-width: 210px;
    }

    .hero-badge-label {
        display: block;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        opacity: 0.8;
        margin-bottom: 0.35rem;
    }

    .dashboard-card {
        padding: 1.2rem;
    }

    .filter-shell .form-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #4f5d73;
    }

    .dashboard-input,
    .form-select.dashboard-input {
        border-radius: 14px;
        min-height: 46px;
        border-color: #dbe3ef;
        background: #fbfdff;
    }

    .btn-soft,
    .chip {
        border: 1px solid #dbe3ef;
        background: #f8fbff;
        color: #3f4f67;
        border-radius: 999px;
        font-weight: 600;
    }

    .btn-soft.active,
    .chip.active {
        background: #102033;
        color: #fff;
        border-color: #102033;
    }

    .chip-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .chip {
        padding: 0.45rem 0.85rem;
    }

    .section-card {
        padding: 1.25rem;
    }

    .section-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .stat-card {
        position: relative;
        overflow: hidden;
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        margin-bottom: 1rem;
    }

    .stat-label {
        display: block;
        color: #61748f;
        font-size: 0.86rem;
        margin-bottom: 0.3rem;
    }

    .stat-value {
        font-size: 1.55rem;
        font-weight: 800;
        color: #122033;
    }

    .trend-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border-radius: 999px;
        padding: 0.3rem 0.7rem;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .trend-chip.positive {
        background: rgba(12, 166, 120, 0.12);
        color: #0b8d67;
    }

    .trend-chip.negative {
        background: rgba(228, 76, 76, 0.12);
        color: #cc3d3d;
    }

    .sparkline {
        width: 104px;
        min-height: 48px;
    }

    .metric-mini,
    .highlight-tile {
        border-radius: 20px;
        padding: 1rem;
        background: #f7fafc;
        border: 1px solid #e8eef6;
        min-height: 100%;
    }

    .metric-mini h4,
    .highlight-tile h4 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #102033;
        margin-bottom: 0.2rem;
    }

    .metric-mini span,
    .highlight-tile span {
        color: #61748f;
        font-size: 0.82rem;
    }

    .chart-shell {
        min-height: 290px;
    }

    .chart-lg {
        min-height: 340px;
    }

    .chart-md {
        min-height: 280px;
    }

    .stack-list {
        display: grid;
        gap: 0.85rem;
    }

    .compact-list {
        gap: 0.65rem;
    }

    .list-card {
        border-radius: 18px;
        border: 1px solid #e8eef6;
        background: #fbfdff;
        padding: 0.95rem 1rem;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
    }

    .product-card {
        border-radius: 22px;
        border: 1px solid #e6edf5;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        overflow: hidden;
    }

    .product-cover {
        height: 150px;
        background: linear-gradient(135deg, #d9e8ff, #eff6ff);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-cover i {
        font-size: 2rem;
        color: #7d92b0;
    }

    .product-body {
        padding: 1rem;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border-radius: 999px;
        padding: 0.32rem 0.72rem;
        font-size: 0.78rem;
        font-weight: 700;
    }

    .status-pill.success,
    .status-pill.delivered,
    .status-pill.in_stock,
    .status-pill.active {
        background: rgba(16, 185, 129, 0.12);
        color: #0b8d67;
    }

    .status-pill.warning,
    .status-pill.pending,
    .status-pill.processing,
    .status-pill.low_stock,
    .status-pill.inactive,
    .status-pill.shipped {
        background: rgba(245, 158, 11, 0.12);
        color: #c27a00;
    }

    .status-pill.danger,
    .status-pill.cancelled,
    .status-pill.out_of_stock,
    .status-pill.unpaid,
    .status-pill.failed,
    .status-pill.returned {
        background: rgba(239, 68, 68, 0.12);
        color: #d23d3d;
    }

    .subsection-title {
        font-weight: 700;
        color: #122033;
        margin-bottom: 0.85rem;
    }

    .assumption-card {
        margin-bottom: 1rem;
    }

    .assumption-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: rgba(79, 124, 255, 0.12);
        color: #4f7cff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .assumption-list {
        padding-left: 1rem;
        color: #607086;
    }

    .muted-copy {
        color: #6c7d94;
        font-size: 0.84rem;
    }

    @media (max-width: 767.98px) {
        .dashboard-title {
            font-size: 1.55rem;
        }

        .chart-shell,
        .chart-lg,
        .chart-md {
            min-height: 240px;
        }
    }
</style>
<script>
    const initialDashboardData = @json($dashboard);
    const filterEndpoint = @json(route('e-commerce.dashboard.filter'));
    const baseIndexRoute = @json(route('e-commerce/index'));

    const state = {
        data: initialDashboardData,
        charts: {},
    };

    const formatCurrency = value => `Rs. ${Number(value || 0).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    const formatNumber = value => Number(value || 0).toLocaleString('en-IN');
    const titleize = value => (value || '').replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase());
    const statusClass = value => (value || 'pending').toLowerCase().replace(/\s+/g, '_');
    const resolveImage = path => {
        if (!path) return null;
        if (path.startsWith('http')) return path;
        return `/${String(path).replace(/^\/+/, '')}`;
    };

    const emptyState = message => `<div class="list-card muted-copy">${message}</div>`;

    function renderSparkline(el, series, color) {
        if (!el || !window.ApexCharts) return;
        const chart = new ApexCharts(el, {
            chart: { type: 'line', height: 48, sparkline: { enabled: true }, animations: { enabled: false } },
            series: [{ data: series || [] }],
            stroke: { curve: 'smooth', width: 3 },
            fill: { opacity: 0.16, type: 'solid' },
            colors: [color],
            tooltip: { enabled: false },
        });
        chart.render();
    }

    function setChart(key, selector, options) {
        const el = document.querySelector(selector);
        if (!el || !window.ApexCharts) return;
        if (state.charts[key]) {
            state.charts[key].destroy();
        }
        state.charts[key] = new ApexCharts(el, options);
        state.charts[key].render();
    }

    function highlightTile(label, value, helper = '') {
        return `<div class="col-md-6"><div class="highlight-tile"><span>${label}</span><h4>${value}</h4>${helper ? `<small class="muted-copy">${helper}</small>` : ''}</div></div>`;
    }

    function compactList(items, renderItem) {
        if (!items || !items.length) return emptyState('No records available for this filter combination.');
        return items.map(renderItem).join('');
    }

    function renderSummaryCards(cards) {
        const grid = document.getElementById('summaryCardsGrid');
        if (!grid) return;

        grid.innerHTML = cards.map(card => `
            <div class="col-sm-6 col-xl-4 col-xxl-2">
                <div class="dashboard-card stat-card h-100">
                    <div class="stat-icon bg-${card.direction === 'up' ? 'success' : 'danger'}-subtle text-${card.direction === 'up' ? 'success' : 'danger'}">
                        <i class="${card.icon}"></i>
                    </div>
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <span class="stat-label">${card.label}</span>
                            <h3 class="stat-value mb-1">${card.format === 'currency' ? formatCurrency(card.value) : formatNumber(card.value)}</h3>
                            <div class="trend-chip ${card.direction === 'up' ? 'positive' : 'negative'}">
                                <i class="fa-solid ${card.direction === 'up' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down'}"></i>
                                ${Math.abs(Number(card.change || 0)).toFixed(1)}%
                            </div>
                        </div>
                        <div class="sparkline" id="spark-${card.key}"></div>
                    </div>
                </div>
            </div>
        `).join('');

        cards.forEach(card => renderSparkline(document.getElementById(`spark-${card.key}`), card.trend, card.direction === 'up' ? '#16a34a' : '#ef4444'));
    }

    function renderSales(data) {
        const overview = data.overview;
        document.getElementById('salesOverview').innerHTML = [
            highlightTile('Revenue', formatCurrency(overview.revenue), `${overview.revenue_change.toFixed(1)}% vs previous`),
            highlightTile('Orders', formatNumber(overview.orders), `${overview.order_change.toFixed(1)}% vs previous`),
            highlightTile('Average Order Value', formatCurrency(overview.avg_order_value)),
            highlightTile('Average Daily Revenue', formatCurrency(overview.avg_daily_revenue)),
        ].join('');

        setChart('salesChart', '#salesChart', {
            chart: { type: 'area', height: 340, toolbar: { show: false } },
            series: [
                { name: 'Revenue', data: data.revenue_series },
                { name: 'Previous Revenue', data: data.previous_revenue_series },
                { name: 'Orders', data: data.orders_series },
            ],
            colors: ['#2563eb', '#94a3b8', '#14b8a6'],
            stroke: { curve: 'smooth', width: [3, 2, 3], dashArray: [0, 6, 0] },
            fill: { opacity: [0.25, 0.1, 0.14] },
            xaxis: { categories: data.labels },
            yaxis: [{ title: { text: 'Revenue' } }, { opposite: true, title: { text: 'Orders' } }],
            dataLabels: { enabled: false },
            legend: { position: 'top' },
            grid: { borderColor: '#e6edf5' }
        });

        document.getElementById('salesComparisonTiles').innerHTML = data.comparison_tiles.map(tile => `
            <div class="col-md-3">
                <div class="metric-mini">
                    <span>${tile.label}</span>
                    <h4>${formatCurrency(tile.revenue)}</h4>
                    <small class="muted-copy">${formatNumber(tile.orders)} orders · ${Number(tile.change || 0).toFixed(1)}%</small>
                </div>
            </div>
        `).join('');
    }

    function renderOrders(data, recentOrders) {
        const metrics = [
            ['Average Order Value', formatCurrency(data.average_order_value)],
            ['Items Sold', formatNumber(data.total_items_sold)],
            ['Highest Order', formatCurrency(data.highest_order_value)],
            ['Lowest Order', formatCurrency(data.lowest_order_value)],
            ['Delivery Rate', `${Number(data.delivery_performance.delivery_rate || 0).toFixed(1)}%`],
            ['Avg Delivery Time', `${Number(data.delivery_performance.avg_delivery_hours || 0).toFixed(1)} hrs`],
        ];

        document.getElementById('orderInsightMetrics').innerHTML = metrics.map(metric => `
            <div class="col-md-6"><div class="metric-mini"><span>${metric[0]}</span><h4>${metric[1]}</h4></div></div>
        `).join('');

        setChart('orderStatusChart', '#orderStatusChart', {
            chart: { type: 'donut', height: 290 },
            series: Object.values(data.status_distribution),
            labels: Object.keys(data.status_distribution).map(titleize),
            colors: ['#f59e0b', '#2563eb', '#0ea5e9', '#10b981', '#ef4444', '#8b5cf6'],
            legend: { position: 'bottom' },
            dataLabels: { enabled: false },
        });

        document.getElementById('recentOrdersList').innerHTML = compactList(recentOrders, order => `
            <div class="list-card">
                <div class="d-flex justify-content-between gap-3 flex-wrap">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <strong>${order.order_number}</strong>
                            <span class="status-pill ${statusClass(order.status)}">${titleize(order.status)}</span>
                        </div>
                        <div class="muted-copy">${order.customer_name}</div>
                        <div class="muted-copy">${order.product_count} products · ${titleize(order.payment_type)}</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-dark">${formatCurrency(order.amount)}</div>
                        <div class="muted-copy">${order.date}</div>
                        <a class="btn btn-sm btn-light mt-2" href="${order.view_url}">View</a>
                    </div>
                </div>
            </div>
        `);
    }

    function renderProducts(data) {
        document.getElementById('topSellingGrid').innerHTML = compactList(data.top_selling, product => `
            <div class="product-card">
                <div class="product-cover">${resolveImage(product.image) ? `<img src="${resolveImage(product.image)}" alt="${product.name}">` : '<i class="fa-solid fa-box-open"></i>'}</div>
                <div class="product-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="status-pill ${statusClass(product.stock_status)}">${titleize(product.stock_status)}</span>
                        <strong>${product.rating ? product.rating.toFixed(1) : '0.0'} ★</strong>
                    </div>
                    <h6 class="mb-1">${product.name}</h6>
                    <div class="muted-copy mb-2">${product.brand} · ${product.category}</div>
                    <div class="d-flex justify-content-between"><span>Qty Sold</span><strong>${formatNumber(product.quantity_sold)}</strong></div>
                    <div class="d-flex justify-content-between"><span>Revenue</span><strong>${formatCurrency(product.revenue)}</strong></div>
                    <div class="d-flex justify-content-between"><span>Reviews</span><strong>${formatNumber(product.review_count)}</strong></div>
                </div>
            </div>
        `);

        document.getElementById('worstProductsList').innerHTML = compactList(data.worst_performing, product => `
            <div class="list-card">
                <strong>${product.name}</strong>
                <div class="muted-copy">${product.brand} · ${product.category}</div>
                <div class="d-flex justify-content-between mt-2"><span>Sold</span><strong>${formatNumber(product.quantity_sold)}</strong></div>
                <div class="d-flex justify-content-between"><span>Revenue</span><strong>${formatCurrency(product.revenue)}</strong></div>
            </div>
        `);

        document.getElementById('reviewedProductsList').innerHTML = compactList(data.most_reviewed, product => `
            <div class="list-card">
                <strong>${product.name}</strong>
                <div class="muted-copy">${product.brand} · ${product.category}</div>
                <div class="d-flex justify-content-between mt-2"><span>Reviews</span><strong>${formatNumber(product.review_count)}</strong></div>
                <div class="d-flex justify-content-between"><span>Rating</span><strong>${product.rating ? product.rating.toFixed(1) : '0.0'} ★</strong></div>
            </div>
        `);
    }

    function renderCategories(data) {
        document.getElementById('categoryHighlights').innerHTML = [
            highlightTile('Parent Categories', formatNumber(data.total_parent_categories)),
            highlightTile('Subcategories', formatNumber(data.total_sub_categories)),
            highlightTile('Best Category', data.best_category ? data.best_category.name : 'N/A', data.best_category ? formatCurrency(data.best_category.revenue) : ''),
            highlightTile('Best Subcategory', data.best_subcategory ? data.best_subcategory.name : 'N/A', data.best_subcategory ? formatCurrency(data.best_subcategory.revenue) : ''),
        ].join('');

        setChart('categorySalesChart', '#categorySalesChart', {
            chart: { type: 'bar', height: 280, toolbar: { show: false } },
            series: [{ name: 'Revenue', data: data.category_sales.map(item => item.revenue) }],
            xaxis: { categories: data.category_sales.map(item => item.name) },
            colors: ['#4f7cff'],
            dataLabels: { enabled: false },
            plotOptions: { bar: { borderRadius: 8, horizontal: true } },
        });

        document.getElementById('subcategoryList').innerHTML = compactList(data.subcategory_sales, item => `
            <div class="list-card d-flex justify-content-between align-items-center">
                <div><strong>${item.name}</strong></div>
                <strong>${formatCurrency(item.revenue)}</strong>
            </div>
        `);
    }

    function renderBrands(data) {
        document.getElementById('brandHighlights').innerHTML = [
            highlightTile('Total Brands', formatNumber(data.total_brands)),
            highlightTile('Top Performer', data.top_performing ? data.top_performing.name : 'N/A', data.top_performing ? formatCurrency(data.top_performing.revenue) : ''),
            highlightTile('Most Ordered', data.most_ordered ? data.most_ordered.name : 'N/A', data.most_ordered ? `${formatNumber(data.most_ordered.quantity_sold)} units` : ''),
            highlightTile('Least Active', data.least_active ? data.least_active.name : 'N/A', data.least_active ? `${formatNumber(data.least_active.product_count)} products` : ''),
        ].join('');

        setChart('brandSalesChart', '#brandSalesChart', {
            chart: { type: 'donut', height: 280 },
            series: data.brands.map(item => item.contribution),
            labels: data.brands.map(item => item.name),
            colors: ['#1d4ed8', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'],
            legend: { position: 'bottom' },
            dataLabels: { enabled: false },
        });

        document.getElementById('brandList').innerHTML = compactList(data.brands, item => `
            <div class="list-card">
                <div class="d-flex justify-content-between"><strong>${item.name}</strong><strong>${item.contribution}%</strong></div>
                <div class="muted-copy">${formatNumber(item.product_count)} products · ${formatNumber(item.quantity_sold)} units</div>
            </div>
        `);
    }

    function renderVariants(data) {
        document.getElementById('variantHighlights').innerHTML = [
            highlightTile('Attributes', formatNumber(data.total_attributes)),
            highlightTile('Attribute Values', formatNumber(data.total_attribute_values)),
            highlightTile('Products With Variants', formatNumber(data.products_with_variants)),
            highlightTile('Catalog Coverage', `${Number(data.catalog_coverage || 0).toFixed(1)}%`, data.top_combination ? data.top_combination.label : ''),
        ].join('');

        document.getElementById('variantAttributeList').innerHTML = compactList(data.most_used_attributes, item => `
            <div class="list-card d-flex justify-content-between align-items-center">
                <div><strong>${item.name}</strong><div class="muted-copy">${formatNumber(item.value_count)} values</div></div>
                <strong>${formatNumber(item.usage)}</strong>
            </div>
        `);

        document.getElementById('variantValueList').innerHTML = compactList(data.most_used_values, item => `
            <div class="list-card d-flex justify-content-between align-items-center">
                <div><strong>${item.value}</strong><div class="muted-copy">${item.attribute}</div></div>
                <strong>${formatNumber(item.usage)}</strong>
            </div>
        `);
    }

    function renderCustomers(data) {
        document.getElementById('customerHighlights').innerHTML = [
            highlightTile('Total Customers', formatNumber(data.total_customers)),
            highlightTile('New Customers', formatNumber(data.new_customers)),
            highlightTile('Returning Customers', formatNumber(data.returning_customers)),
            highlightTile('Recently Active', formatNumber((data.recently_active || []).length)),
        ].join('');

        setChart('customerGrowthChart', '#customerGrowthChart', {
            chart: { type: 'line', height: 280, toolbar: { show: false } },
            series: [{ name: 'New Customers', data: data.growth.series }],
            xaxis: { categories: data.growth.labels },
            colors: ['#0ea5e9'],
            stroke: { curve: 'smooth', width: 3 },
            dataLabels: { enabled: false },
        });

        document.getElementById('topCustomersByOrders').innerHTML = compactList(data.top_by_orders, item => `
            <div class="list-card">
                <strong>${item.name}</strong>
                <div class="muted-copy">${item.email}</div>
                <div class="d-flex justify-content-between mt-2"><span>Orders</span><strong>${formatNumber(item.order_count)}</strong></div>
            </div>
        `);

        document.getElementById('topCustomersBySpend').innerHTML = compactList(data.top_by_spend, item => `
            <div class="list-card">
                <strong>${item.name}</strong>
                <div class="muted-copy">${item.email}</div>
                <div class="d-flex justify-content-between mt-2"><span>Spend</span><strong>${formatCurrency(item.total_spend)}</strong></div>
            </div>
        `);
    }

    function renderPayments(data) {
        setChart('paymentChart', '#paymentChart', {
            chart: { type: 'donut', height: 280 },
            series: data.distribution.map(item => item.amount),
            labels: data.distribution.map(item => titleize(item.method)),
            colors: ['#2563eb', '#14b8a6', '#f59e0b', '#ef4444', '#8b5cf6', '#475569'],
            legend: { position: 'bottom' },
            dataLabels: { enabled: false },
        });

        document.getElementById('paymentBreakdownList').innerHTML = compactList(data.distribution, item => `
            <div class="list-card">
                <div class="d-flex justify-content-between align-items-center">
                    <strong>${titleize(item.method)}</strong>
                    <span class="status-pill success">${formatNumber(item.count)} tx</span>
                </div>
                <div class="fw-bold mt-2">${formatCurrency(item.amount)}</div>
            </div>
        `);
    }

    function renderReviews(data) {
        document.getElementById('reviewHighlights').innerHTML = [
            highlightTile('Average Rating', `${Number(data.average_rating || 0).toFixed(1)} ★`),
            highlightTile('Total Reviews', formatNumber(data.total_reviews)),
            highlightTile('Active Reviews', formatNumber(data.active_reviews)),
            highlightTile('Inactive Reviews', formatNumber(data.inactive_reviews)),
        ].join('');

        setChart('ratingDistributionChart', '#ratingDistributionChart', {
            chart: { type: 'bar', height: 280, toolbar: { show: false } },
            series: [{ name: 'Reviews', data: data.rating_distribution.map(item => item.count) }],
            xaxis: { categories: data.rating_distribution.map(item => `${item.star} Star`) },
            colors: ['#f59e0b'],
            dataLabels: { enabled: false },
            plotOptions: { bar: { borderRadius: 10, columnWidth: '42%' } },
        });

        document.getElementById('mostReviewedProducts').innerHTML = compactList(data.most_reviewed, item => `<div class="list-card"><strong>${item.product_name}</strong><div class="muted-copy">${formatNumber(item.review_count)} reviews · ${item.rating.toFixed(1)} ★</div></div>`);
        document.getElementById('bestRatedProducts').innerHTML = compactList(data.best_rated, item => `<div class="list-card"><strong>${item.product_name}</strong><div class="muted-copy">${formatNumber(item.review_count)} reviews · ${item.rating.toFixed(1)} ★</div></div>`);
        document.getElementById('poorRatedProducts').innerHTML = compactList(data.poor_rated, item => `<div class="list-card"><strong>${item.product_name}</strong><div class="muted-copy">${formatNumber(item.review_count)} reviews · ${item.rating.toFixed(1)} ★</div></div>`);
        document.getElementById('latestReviewsList').innerHTML = compactList(data.latest_reviews, item => `
            <div class="list-card">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <strong>${item.customer_name || 'Customer'}</strong>
                        <div class="muted-copy">${item.product_name}</div>
                        <div class="mt-2">${'★'.repeat(item.rating)}${'☆'.repeat(5 - item.rating)}</div>
                        <p class="muted-copy mt-2 mb-0">${item.feedback || 'No written feedback provided.'}</p>
                    </div>
                    <span class="status-pill ${statusClass(item.status)}">${titleize(item.status)}</span>
                </div>
            </div>
        `);
    }

    function renderInventory(data) {
        document.getElementById('inventoryHighlights').innerHTML = [
            highlightTile('In Stock', formatNumber(data.in_stock)),
            highlightTile('Low Stock', formatNumber(data.low_stock)),
            highlightTile('Out of Stock', formatNumber(data.out_of_stock)),
            highlightTile('Stock Health', `${Number(data.stock_health || 0).toFixed(1)}%`),
        ].join('');

        setChart('inventoryDistributionChart', '#inventoryDistributionChart', {
            chart: { type: 'donut', height: 280 },
            series: data.distribution.map(item => item.value),
            labels: data.distribution.map(item => item.label),
            colors: ['#10b981', '#f59e0b', '#ef4444'],
            dataLabels: { enabled: false },
            legend: { position: 'bottom' },
        });

        document.getElementById('inventoryWatchList').innerHTML = compactList(data.nearing_depletion, item => `
            <div class="list-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${item.name}</strong>
                        <div class="muted-copy">${item.brand} · ${item.category}</div>
                    </div>
                    <span class="status-pill ${statusClass(item.stock_status)}">${titleize(item.stock_status)}</span>
                </div>
                <div class="fw-bold mt-2">${formatNumber(item.stock_quantity)} units left</div>
            </div>
        `);
    }

    function renderContacts(data) {
        document.getElementById('contactHighlights').innerHTML = [
            highlightTile('Total Inquiries', formatNumber(data.total_inquiries)),
            highlightTile('New Inquiries', formatNumber(data.new_inquiries)),
            highlightTile('Latest Messages', formatNumber((data.recent_inquiries || []).length)),
            highlightTile('Growth Signal', `${Number(data.growth || 0).toFixed(1)}%`),
        ].join('');

        setChart('contactTrendChart', '#contactTrendChart', {
            chart: { type: 'area', height: 280, toolbar: { show: false } },
            series: [{ name: 'Inquiries', data: data.trend.map(item => item.count) }],
            xaxis: { categories: data.trend.map(item => item.label) },
            colors: ['#8b5cf6'],
            stroke: { curve: 'smooth', width: 3 },
            dataLabels: { enabled: false },
        });

        document.getElementById('contactMessageList').innerHTML = compactList(data.recent_inquiries, item => `
            <div class="list-card">
                <div class="d-flex justify-content-between"><strong>${item.name}</strong><span class="muted-copy">${item.date}</span></div>
                <div class="muted-copy">${item.email} · ${item.phone}</div>
                <div class="fw-semibold mt-2">${item.subject}</div>
                <p class="muted-copy mb-0 mt-2">${item.description}</p>
            </div>
        `);
    }

    function renderDashboard(data) {
        state.data = data;
        renderSummaryCards(data.summary_cards.cards || []);
        renderSales(data.sales_analytics);
        renderOrders(data.order_insights, data.recent_orders);
        renderProducts(data.product_insights);
        renderCategories(data.category_insights);
        renderBrands(data.brand_insights);
        renderVariants(data.variant_insights);
        renderCustomers(data.customer_insights);
        renderPayments(data.revenue_breakdown);
        renderReviews(data.review_insights);
        renderInventory(data.inventory_overview);
        renderContacts(data.contact_overview);
    }

    async function fetchDashboard() {
        const form = document.getElementById('dashboardFilters');
        const params = new URLSearchParams(new FormData(form));
        const response = await fetch(`${filterEndpoint}?${params.toString()}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!response.ok) return;
        const payload = await response.json();
        renderDashboard(payload);
    }

    function syncSubcategories() {
        const category = document.getElementById('globalCategory').value;
        document.querySelectorAll('#globalSubCategory option[data-parent]').forEach(option => {
            option.hidden = category && option.dataset.parent !== category;
        });
    }

    function applyPresetToDates(preset) {
        const today = new Date();
        const from = new Date(today);
        const to = new Date(today);

        if (preset === 'last_7_days') {
            from.setDate(today.getDate() - 6);
        } else if (preset === 'last_30_days') {
            from.setDate(today.getDate() - 29);
        } else if (preset === 'this_month') {
            from.setDate(1);
            to.setMonth(today.getMonth() + 1, 0);
        }

        const normalize = date => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };
        document.querySelector('[name="date_from"]').value = normalize(from);
        document.querySelector('[name="date_to"]').value = normalize(to);
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderDashboard(initialDashboardData);
        syncSubcategories();

        document.getElementById('applyFilters').addEventListener('click', fetchDashboard);
        document.getElementById('resetFilters').addEventListener('click', () => window.location.href = baseIndexRoute);
        document.getElementById('globalCategory').addEventListener('change', syncSubcategories);

        document.querySelectorAll('[data-preset]').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('[data-preset]').forEach(item => item.classList.remove('active'));
                button.classList.add('active');
                document.querySelector('[name="date_preset"]').value = button.dataset.preset;
                applyPresetToDates(button.dataset.preset);
                fetchDashboard();
            });
        });

        document.querySelectorAll('[data-sales-preset]').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('[data-sales-preset]').forEach(item => item.classList.remove('active'));
                button.classList.add('active');
                document.querySelector('[name="date_preset"]').value = button.dataset.salesPreset;
                applyPresetToDates(button.dataset.salesPreset);
                fetchDashboard();
            });
        });

        document.querySelectorAll('[data-order-filter]').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('[data-order-filter]').forEach(item => item.classList.remove('active'));
                button.classList.add('active');
                document.querySelector('[name="order_status"]').value = button.dataset.orderFilter;
                fetchDashboard();
            });
        });

        document.querySelectorAll('[data-review-filter]').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('[data-review-filter]').forEach(item => item.classList.remove('active'));
                button.classList.add('active');
                document.querySelector('[name="review_status"]').value = button.dataset.reviewFilter;
                fetchDashboard();
            });
        });

        document.querySelectorAll('[data-customer-filter]').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('[data-customer-filter]').forEach(item => item.classList.remove('active'));
                button.classList.add('active');
                document.querySelector('[name="customer_type"]').value = button.dataset.customerFilter;
                fetchDashboard();
            });
        });
    });
</script>
@endsection
