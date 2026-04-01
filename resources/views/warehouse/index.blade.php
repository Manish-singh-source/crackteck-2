@extends('warehouse/layouts/master')

@section('content')
<div class="content warehouse-dashboard-page">
    <div class="container-fluid">
        <style>
            .warehouse-dashboard-page { background: linear-gradient(180deg, #f4f7fb 0%, #eef3f8 100%); }
            .dashboard-hero { background: radial-gradient(circle at top left, #133c6b, #0c213b 60%, #081728 100%); border-radius: 24px; color: #fff; padding: 2rem; position: relative; overflow: hidden; }
            .dashboard-hero::after { content: ''; position: absolute; inset: auto -8% -45% auto; width: 280px; height: 280px; background: rgba(255,255,255,.08); border-radius: 50%; }
            .dashboard-chip { background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.18); color: #fff; border-radius: 999px; padding: .45rem .9rem; font-size: .82rem; }
            .dashboard-section-title { font-size: 1rem; font-weight: 700; color: #16324f; margin-bottom: 1rem; }
            .dashboard-surface { border: 0; border-radius: 22px; box-shadow: 0 12px 35px rgba(16, 34, 60, .08); }
            .warehouse-filter-card { margin-top: -1.5rem; position: relative; z-index: 3; }
            .metric-card { border: 0; border-radius: 22px; box-shadow: 0 12px 35px rgba(16, 34, 60, .08); overflow: hidden; min-height: 180px; }
            .metric-card .metric-icon { width: 52px; height: 52px; border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.15rem; }
            .metric-card .metric-value { font-size: 1.8rem; font-weight: 700; color: #102640; }
            .metric-card .metric-label { color: #5e6f82; font-size: .92rem; }
            .metric-card .metric-trend { border-radius: 999px; font-size: .75rem; padding: .3rem .65rem; font-weight: 600; }
            .metric-card .metric-trend.up { background: rgba(33, 150, 83, .12); color: #157347; }
            .metric-card .metric-trend.down { background: rgba(220, 53, 69, .12); color: #b02a37; }
            .metric-card .metric-trend.neutral { background: rgba(13, 110, 253, .08); color: #375a7f; }
            .overview-card { border-radius: 22px; background: #fff; padding: 1.15rem; min-height: 100%; }
            .overview-meta { color: #637588; font-size: .82rem; text-transform: uppercase; letter-spacing: .08em; }
            .overview-value { font-size: 1.6rem; font-weight: 700; color: #0f253d; }
            .chart-card { border: 0; border-radius: 22px; box-shadow: 0 12px 35px rgba(16, 34, 60, .08); min-height: 100%; }
            .chart-box { min-height: 320px; }
            .list-card { border: 0; border-radius: 22px; box-shadow: 0 12px 35px rgba(16, 34, 60, .08); min-height: 100%; }
            .list-shell { display: grid; gap: .9rem; }
            .list-item { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; padding: .9rem 1rem; border-radius: 18px; background: #f7fafc; }
            .list-item h6 { margin: 0; color: #102640; font-size: .95rem; }
            .list-item p { margin: .2rem 0 0; color: #627487; font-size: .82rem; }
            .list-badge { background: #fff; border-radius: 999px; padding: .35rem .7rem; font-size: .8rem; font-weight: 700; color: #102640; white-space: nowrap; }
            .progress-shell { height: 9px; background: #e8eef5; border-radius: 999px; overflow: hidden; }
            .progress-shell span { display: block; height: 100%; border-radius: 999px; background: linear-gradient(90deg, #1e7bff, #00b4d8); }
            .dashboard-loading { position: fixed; inset: 0; background: rgba(7, 21, 37, .34); display: none; align-items: center; justify-content: center; z-index: 1080; }
            .dashboard-loading.show { display: flex; }
            .loading-pill { background: #fff; border-radius: 999px; padding: .9rem 1.2rem; box-shadow: 0 12px 35px rgba(16, 34, 60, .16); font-weight: 600; color: #16324f; }
            .notes-card { background: linear-gradient(135deg, #fff8ea, #fff); border: 1px solid #ffe7b0; }
            @media (max-width: 991.98px) { .dashboard-hero, .warehouse-filter-card { margin-top: 0; } }
        </style>

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column gap-3">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Warehouse Intelligence Dashboard</h4>
            </div>
            <div class="d-flex flex-wrap gap-2" id="dashboardMetaChips"></div>
        </div>

        <div class="dashboard-hero mb-4">
            <div class="row align-items-center g-4">
                <div class="col-xl-7">
                    <span class="dashboard-chip mb-3 d-inline-flex">Operational analytics across inventory, vendors, purchase orders, serials and revenue</span>
                    <h2 class="mb-3 text-white">A card-first warehouse cockpit built for fast decisions.</h2>
                    <p class="mb-0 text-white text-opacity-75">This view combines warehouse, rack, inventory, serial, scrap, vendor, purchase and order-linked revenue signals into one responsive admin surface.</p>
                </div>
                <div class="col-xl-5">
                    <div class="row g-3" id="overviewHighlights"></div>
                </div>
            </div>
        </div>

        @include('warehouse.partials.dashboard-filters')

        <div class="row g-4 mt-1" id="summaryCards"></div>

        <div class="row g-4 mt-1">
            <div class="col-xl-8"><div class="chart-card card"><div class="card-body"><div class="d-flex justify-content-between align-items-start mb-3"><div><p class="dashboard-section-title mb-1">Warehouse Performance Analytics</p><p class="text-muted mb-0 small">Purchase order velocity and value movement across the selected range.</p></div></div><div id="purchaseOrdersTimeline" class="chart-box"></div></div></div></div>
            <div class="col-xl-4"><div class="chart-card card"><div class="card-body"><p class="dashboard-section-title">PO Status Mix</p><div id="purchaseOrderStatus" class="chart-box"></div></div></div></div>
            <div class="col-xl-6"><div class="chart-card card"><div class="card-body"><p class="dashboard-section-title">Top Vendors by Purchase Volume</p><div id="topVendorsChart" class="chart-box"></div></div></div></div>
            <div class="col-xl-6"><div class="chart-card card"><div class="card-body"><p class="dashboard-section-title">Purchase Order Value Trend</p><div id="purchaseOrderValue" class="chart-box"></div></div></div></div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-xl-7"><div class="chart-card card"><div class="card-body"><p class="dashboard-section-title">Products by Category</p><div id="productsByCategory" class="chart-box"></div></div></div></div>
            <div class="col-xl-5"><div class="chart-card card"><div class="card-body"><p class="dashboard-section-title">Stock Status Distribution</p><div id="stockStatus" class="chart-box"></div></div></div></div>
            <div class="col-xl-6"><div class="chart-card card"><div class="card-body"><p class="dashboard-section-title">Best Selling Products</p><div id="bestSellersChart" class="chart-box"></div></div></div></div>
            <div class="col-xl-6"><div class="chart-card card"><div class="card-body"><p class="dashboard-section-title">Product Performance Trend</p><div id="topProductTrend" class="chart-box"></div></div></div></div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-xl-4"><div class="chart-card card"><div class="card-body"><p class="dashboard-section-title">Product Serials Status</p><div id="serialStatus" class="chart-box"></div></div></div></div>
            <div class="col-xl-4"><div class="chart-card card"><div class="card-body"><p class="dashboard-section-title">Scrap Trend</p><div id="scrapTrend" class="chart-box"></div></div></div></div>
            <div class="col-xl-4"><div class="chart-card card"><div class="card-body"><p class="dashboard-section-title">Low vs Out of Stock Trend</p><div id="stockAlertTrend" class="chart-box"></div></div></div></div>
            <div class="col-xl-8"><div class="chart-card card"><div class="card-body"><p class="dashboard-section-title">Products Revenue Trend</p><div id="revenueTrend" class="chart-box"></div></div></div></div>
            <div class="col-xl-4"><div class="chart-card card"><div class="card-body"><p class="dashboard-section-title">Revenue Contribution by Category</p><div id="revenueContribution" class="chart-box"></div></div></div></div>
        </div>

        <div class="row g-4 mt-1 mb-1">
            <div class="col-xl-6"><div class="list-card card"><div class="card-body"><p class="dashboard-section-title">Warehouse Capacity Snapshot</p><div class="list-shell" id="warehousePerformanceList"></div></div></div></div>
            <div class="col-xl-3"><div class="list-card card"><div class="card-body"><p class="dashboard-section-title">Low Stock Focus</p><div class="list-shell" id="lowStockList"></div></div></div></div>
            <div class="col-xl-3"><div class="list-card card"><div class="card-body"><p class="dashboard-section-title">Out of Stock Focus</p><div class="list-shell" id="outStockList"></div></div></div></div>
            <div class="col-xl-4"><div class="list-card card"><div class="card-body"><p class="dashboard-section-title">Top Revenue Products</p><div class="list-shell" id="topRevenueList"></div></div></div></div>
            <div class="col-xl-4"><div class="list-card card"><div class="card-body"><p class="dashboard-section-title">Scrap by Brand</p><div class="list-shell" id="scrapBrandList"></div></div></div></div>
            <div class="col-xl-4"><div class="list-card card"><div class="card-body"><p class="dashboard-section-title">Revenue by Category</p><div class="list-shell" id="revenueCategoryList"></div></div></div></div>
            {{-- <div class="col-12"><div class="list-card card notes-card"><div class="card-body"><p class="dashboard-section-title">Implementation Notes</p><div class="list-shell" id="assumptionNotes">@foreach ($dashboardAssumptions as $note)<div class="list-item"><div><h6>{{ $note }}</h6></div></div>@endforeach</div></div></div></div> --}}
        </div>
    </div>
    <div class="dashboard-loading" id="dashboardLoading"><div class="loading-pill"><span class="spinner-border spinner-border-sm me-2"></span>Refreshing dashboard analytics...</div></div>
</div>
@endsection

@section('scripts')
<script>
window.warehouseDashboardConfig = {
    endpoint: @json($dashboardDataUrl),
    initialData: @json($dashboardData),
    subcategories: @json($filterOptions['subcategories']),
    initialFilters: @json($initialFilters),
};
</script>
<script>
(() => {
    const config = window.warehouseDashboardConfig || {};
    const charts = {};
    const formatter = new Intl.NumberFormat('en-IN');
    const currency = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', maximumFractionDigits: 0 });
    const form = document.getElementById('warehouseDashboardFilters');
    const loader = document.getElementById('dashboardLoading');
    const subcategories = config.subcategories || [];
    const categoryFilter = document.getElementById('dashboardCategoryFilter');
    const subcategoryFilter = document.getElementById('dashboardSubcategoryFilter');

    const valueLabel = (value, type = 'number') => type === 'currency' ? currency.format(Number(value || 0)) : formatter.format(Number(value || 0));
    const showLoading = (show) => loader.classList.toggle('show', !!show);
    const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (char) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[char]));

    const renderSimpleList = (selector, items, mode = 'metric') => {
        const shell = document.querySelector(selector);
        if (!shell) return;
        if (!items || !items.length) { shell.innerHTML = '<div class="list-item"><div><h6>No data for the current filters.</h6></div></div>'; return; }
        shell.innerHTML = items.map((item) => {
            if (mode === 'warehouse') {
                return `<div class="list-item"><div class="w-100"><div class="d-flex justify-content-between align-items-start gap-3"><div><h6>${escapeHtml(item.name)}</h6><p>${escapeHtml(item.location)} � ${escapeHtml(item.verification_status)}</p></div><span class="list-badge">${formatter.format(item.products_count)} products</span></div><div class="mt-3"><div class="d-flex justify-content-between small text-muted mb-1"><span>Capacity usage</span><span>${item.capacity_usage}%</span></div><div class="progress-shell"><span style="width:${Math.min(item.capacity_usage, 100)}%"></span></div></div><div class="mt-3"><div class="d-flex justify-content-between small text-muted mb-1"><span>Rack utilization</span><span>${item.rack_usage}%</span></div><div class="progress-shell"><span style="width:${Math.min(item.rack_usage, 100)}%; background: linear-gradient(90deg, #00a86b, #54d6a1);"></span></div></div></div></div>`;
            }
            if (mode === 'product') {
                return `<div class="list-item"><div><h6>${escapeHtml(item.name)}</h6><p>${escapeHtml(item.brand)} � ${escapeHtml(item.category)} � ${escapeHtml(item.warehouse)}</p></div><span class="list-badge">${formatter.format(item.quantity)} units</span></div>`;
            }
            if (mode === 'revenue') {
                return `<div class="list-item"><div><h6>${escapeHtml(item.label)}</h6><p>${formatter.format(item.quantity || 0)} units moved</p></div><span class="list-badge">${currency.format(item.revenue || item.value || 0)}</span></div>`;
            }
            return `<div class="list-item"><div><h6>${escapeHtml(item.label)}</h6></div><span class="list-badge">${item.type === 'currency' ? currency.format(item.value || 0) : formatter.format(item.value || 0)}</span></div>`;
        }).join('');
    };

    const summaryTone = { primary: '#1e7bff', info: '#00a6fb', warning: '#f39c12', danger: '#e74c3c', secondary: '#6c7ae0', success: '#16a34a' };
    const renderSummaryCards = (cards) => {
        const shell = document.getElementById('summaryCards');
        shell.innerHTML = cards.map((card) => `<div class="col-md-6 col-xl-4"><div class="metric-card card"><div class="card-body"><div class="d-flex justify-content-between align-items-start mb-4"><div><div class="metric-label mb-2">${escapeHtml(card.label)}</div><div class="metric-value">${valueLabel(card.value, card.type)}</div></div><span class="metric-icon" style="background:${summaryTone[card.tone]}1A; color:${summaryTone[card.tone]};"><i class="${card.icon}"></i></span></div><div class="d-flex justify-content-between align-items-center"><span class="metric-trend ${card.trend.direction}">${card.trend.direction === 'down' ? '' : '+'}${card.trend.percentage}%</span><span class="small text-muted">vs previous window</span></div><div class="mt-3" id="spark-${card.key}"></div></div></div></div>`).join('');
        cards.forEach((card) => upsertChart(`spark-${card.key}`, { chart: { type: 'area', height: 70, sparkline: { enabled: true }, toolbar: { show: false } }, stroke: { curve: 'smooth', width: 2 }, fill: { opacity: .2 }, colors: [summaryTone[card.tone] || '#1e7bff'], series: [{ data: card.sparkline || [] }], tooltip: { enabled: false } }));
    };

    const renderOverview = (overview, meta) => {
        const shell = document.getElementById('overviewHighlights');
        shell.innerHTML = [
            { label: 'Inventory Value', value: currency.format(overview.inventory_value || 0) },
            { label: 'Rack Utilization', value: `${overview.rack_utilization || 0}%` },
            { label: 'Inventory Turnover', value: `${overview.inventory_turnover || 0}x` },
            { label: 'Return Rate', value: `${overview.return_rate || 0}%` },
        ].map((item) => `<div class="col-sm-6"><div class="overview-card"><div class="overview-meta">${item.label}</div><div class="overview-value mt-2">${item.value}</div></div></div>`).join('');
        document.getElementById('dashboardMetaChips').innerHTML = [`<span class="dashboard-chip">${meta.range.date_from} to ${meta.range.date_to}</span>`, `<span class="dashboard-chip">Low stock threshold: ${meta.low_stock_threshold}</span>`, `<span class="dashboard-chip">Updated ${meta.last_updated}</span>`].join('');
    };

    const baseOptions = { chart: { toolbar: { show: false }, fontFamily: 'inherit' }, dataLabels: { enabled: false }, legend: { position: 'bottom' }, grid: { borderColor: '#ecf0f4' }, stroke: { curve: 'smooth', width: 3 }, colors: ['#1e7bff', '#16a34a', '#f39c12', '#e74c3c', '#8b5cf6', '#00b4d8'], xaxis: { labels: { style: { colors: '#738496' } } }, yaxis: { labels: { style: { colors: '#738496' } } }, tooltip: { theme: 'light' } };
    const lineChart = (id, payload, type = 'line') => upsertChart(id, { ...baseOptions, chart: { ...baseOptions.chart, type, height: 320 }, series: payload.series || [], xaxis: { ...baseOptions.xaxis, categories: payload.labels || [] }, fill: type === 'area' ? { opacity: .18, type: 'solid' } : { opacity: 1 } });
    const barChart = (id, payload, horizontal = false) => upsertChart(id, { ...baseOptions, chart: { ...baseOptions.chart, type: 'bar', height: 320 }, plotOptions: { bar: { horizontal, borderRadius: 8, columnWidth: '42%' } }, series: payload.series || [], xaxis: { ...baseOptions.xaxis, categories: payload.labels || [] } });
    const donutChart = (id, payload) => upsertChart(id, { ...baseOptions, chart: { ...baseOptions.chart, type: 'donut', height: 320 }, series: payload.series || [], labels: payload.labels || [], stroke: { width: 0 }, legend: { position: 'bottom' } });

    function upsertChart(id, options) {
        const element = document.getElementById(id);
        if (!element) return;
        if (charts[id]) { charts[id].updateOptions(options, true, true); return; }
        charts[id] = new ApexCharts(element, options); charts[id].render();
    }

    function hydrateSubcategories(selectedCategory, selectedSubcategory) {
        const available = selectedCategory ? subcategories.filter((item) => Number(item.parent_category_id) === Number(selectedCategory)) : subcategories;
        subcategoryFilter.innerHTML = `<option value="">All Subcategories</option>${available.map((item) => `<option value="${item.id}">${escapeHtml(item.name)}</option>`).join('')}`;
        if (selectedSubcategory) subcategoryFilter.value = String(selectedSubcategory);
    }

    function renderDashboard(payload) {
        renderSummaryCards(payload.summary_cards || []);
        renderOverview(payload.overview || {}, payload.meta || {});
        lineChart('purchaseOrdersTimeline', payload.charts.purchase_orders_timeline || {});
        donutChart('purchaseOrderStatus', payload.charts.purchase_order_status || {});
        barChart('topVendorsChart', payload.charts.top_vendors || {}, true);
        lineChart('purchaseOrderValue', payload.charts.purchase_order_value || {}, 'area');
        barChart('productsByCategory', payload.charts.products_by_category || {}, true);
        donutChart('stockStatus', payload.charts.stock_status || {});
        barChart('bestSellersChart', payload.charts.best_sellers || {}, true);
        lineChart('topProductTrend', payload.charts.top_product_trend || {});
        donutChart('serialStatus', payload.charts.serial_status || {});
        lineChart('scrapTrend', payload.charts.scrap_trend || {}, 'area');
        lineChart('stockAlertTrend', payload.charts.stock_alert_trend || {});
        lineChart('revenueTrend', payload.charts.revenue_trend || {}, 'area');
        donutChart('revenueContribution', payload.charts.revenue_contribution || {});
        renderSimpleList('#warehousePerformanceList', payload.lists.warehouse_performance || [], 'warehouse');
        renderSimpleList('#lowStockList', payload.lists.low_stock_products || [], 'product');
        renderSimpleList('#outStockList', payload.lists.out_of_stock_products || [], 'product');
        renderSimpleList('#topRevenueList', payload.lists.top_revenue_products || [], 'revenue');
        renderSimpleList('#scrapBrandList', payload.lists.scrap_by_brand || []);
        renderSimpleList('#revenueCategoryList', payload.lists.revenue_by_category || []);
    }

    async function fetchDashboard() {
        showLoading(true);
        const params = new URLSearchParams(new FormData(form));
        const response = await fetch(`${config.endpoint}?${params.toString()}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const payload = await response.json();
        window.history.replaceState({}, '', `${window.location.pathname}?${params.toString()}`);
        renderDashboard(payload.data);
        showLoading(false);
    }

    form.addEventListener('submit', (event) => { event.preventDefault(); fetchDashboard().catch(() => showLoading(false)); });
    document.getElementById('resetDashboardFilters').addEventListener('click', () => { form.reset(); hydrateSubcategories('', ''); fetchDashboard().catch(() => showLoading(false)); });
    categoryFilter.addEventListener('change', () => hydrateSubcategories(categoryFilter.value, ''));

    hydrateSubcategories(config.initialFilters.category_id, config.initialFilters.subcategory_id || subcategoryFilter.dataset.selected);
    renderDashboard(config.initialData);
})();
</script>
@endsection
