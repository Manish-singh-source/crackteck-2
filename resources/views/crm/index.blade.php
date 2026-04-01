@extends('crm.layouts.master')

@section('content')
<div class="content crm-dashboard-page">
    <div class="container-fluid">
        <style>
            .crm-dashboard-page { background: linear-gradient(180deg, #f4f7fb 0%, #eef2f8 100%); }
            .dashboard-surface, .metric-card, .chart-card, .insight-card, .section-shell { border: 0; border-radius: 22px; box-shadow: 0 14px 38px rgba(17, 33, 58, .08); }
            .crm-hero { border-radius: 28px; background: radial-gradient(circle at top left, #0d3b66, #102a43 52%, #081522 100%); color: #fff; padding: 2rem; overflow: hidden; position: relative; }
            .crm-hero::after { content: ''; position: absolute; right: -60px; bottom: -80px; width: 260px; height: 260px; border-radius: 50%; background: rgba(255,255,255,.08); }
            .metric-card { min-height: 190px; overflow: hidden; }
            .metric-icon { width: 54px; height: 54px; border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.25rem; }
            .metric-value { font-size: 1.85rem; font-weight: 700; color: #10243d; }
            .metric-label { color: #68798f; font-size: .92rem; }
            .metric-trend { border-radius: 999px; padding: .35rem .7rem; font-size: .78rem; font-weight: 600; }
            .metric-trend.up { background: rgba(22, 163, 74, .12); color: #15803d; }
            .metric-trend.down { background: rgba(220, 38, 38, .12); color: #b91c1c; }
            .metric-trend.neutral { background: rgba(30, 123, 255, .10); color: #1d4ed8; }
            .hero-kpi { background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.12); border-radius: 20px; padding: 1rem; }
            .hero-kpi-label { font-size: .75rem; text-transform: uppercase; letter-spacing: .08em; opacity: .75; }
            .hero-kpi-value { font-size: 1.45rem; font-weight: 700; }
            .chart-box { min-height: 310px; }
            .section-shell { background: #fff; padding: 1.35rem; }
            .section-head { display: flex; justify-content: space-between; gap: 1rem; align-items: flex-start; margin-bottom: 1rem; }
            .section-title { color: #10243d; font-size: 1.08rem; font-weight: 700; }
            .section-copy { color: #6d7f92; font-size: .9rem; margin: 0; }
            .insight-pill { background: #f6f9fc; border-radius: 18px; padding: .95rem 1rem; min-height: 100%; }
            .insight-label { color: #6d7f92; font-size: .8rem; text-transform: uppercase; letter-spacing: .06em; }
            .insight-value { color: #10243d; font-size: 1.2rem; font-weight: 700; margin-top: .35rem; }
            .note-card { background: linear-gradient(135deg, #fff7e7, #fff); border: 1px solid #fde7b0; }
            .dashboard-loading { position: fixed; inset: 0; display: none; align-items: center; justify-content: center; background: rgba(7, 21, 37, .34); z-index: 1080; }
            .dashboard-loading.show { display: flex; }
            .loading-pill { background: #fff; border-radius: 999px; padding: .9rem 1.2rem; box-shadow: 0 12px 35px rgba(16, 34, 60, .16); font-weight: 600; color: #16324f; }
        </style>

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column gap-3">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">CRM Admin Dashboard</h4>
            </div>
            <div class="d-flex flex-wrap gap-2" id="dashboardMetaChips"></div>
        </div>

        <div class="crm-hero mb-4">
            <div class="row g-4 align-items-center">
                <div class="col-xl-7">
                    <span class="badge rounded-pill text-bg-light text-dark mb-3">Analytics-rich CRM cockpit</span>
                    <h2 class="text-white mb-3" id="heroTitle"></h2>
                    <p class="mb-0 text-white text-opacity-75" id="heroSubtitle"></p>
                </div>
                <div class="col-xl-5">
                    <div class="row g-3" id="heroHighlights"></div>
                </div>
            </div>
        </div>

        @include('crm.partials.dashboard-filters')

        <div class="row g-4" id="summaryCards"></div>

        @foreach($sectionMeta as $key => $section)
            <div class="section-shell mt-4">
                <div class="section-head">
                    <div>
                        <div class="section-title">{{ $section['title'] }}</div>
                        <p class="section-copy">{{ $section['description'] }}</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <select class="form-select form-select-sm section-source-filter" data-section="{{ $key }}" style="min-width: 180px;">
                            <option value="">All {{ strtolower($section['filter_label']) }}</option>
                            @foreach(($filterOptions[$section['options_key']] ?? []) as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <select class="form-select form-select-sm section-date-filter" data-section="{{ $key }}">
                            @foreach($filterOptions['date_presets'] as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row g-3 mb-3" id="{{ $key }}Insights"></div>
                <div class="row g-4">
                    <div class="col-xl-6"><div class="chart-card card"><div class="card-body"><div class="section-title small mb-3" id="{{ $key }}TimelineLabel"></div><div class="chart-box" id="{{ $key }}Timeline"></div></div></div></div>
                    <div class="col-xl-6"><div class="chart-card card"><div class="card-body"><div class="section-title small mb-3" id="{{ $key }}DistributionLabel"></div><div class="chart-box" id="{{ $key }}Distribution"></div></div></div></div>
                    <div class="col-xl-6"><div class="chart-card card"><div class="card-body"><div class="section-title small mb-3" id="{{ $key }}SegmentsLabel"></div><div class="chart-box" id="{{ $key }}Segments"></div></div></div></div>
                    <div class="col-xl-6"><div class="chart-card card"><div class="card-body"><div class="section-title small mb-3" id="{{ $key }}ValueLabel"></div><div class="chart-box" id="{{ $key }}Value"></div></div></div></div>
                </div>
            </div>
        @endforeach

        {{-- 
        <div class="card note-card dashboard-surface mt-4">
            <div class="card-body">
                <div class="section-title mb-3">Implementation Notes</div>
                <div class="row g-3">
                    @foreach($dashboardAssumptions as $note)
                        <div class="col-xl-6"><div class="insight-pill"><div class="insight-value fs-6 mt-0">{{ $note }}</div></div></div>
                    @endforeach
                </div>
            </div>
        </div> 
        --}}
    </div>
    <div class="dashboard-loading" id="dashboardLoading"><div class="loading-pill"><span class="spinner-border spinner-border-sm me-2"></span>Refreshing CRM analytics...</div></div>
</div>
@endsection

@section('scripts')
<script>
window.crmDashboardConfig = {
    endpoint: @json($dashboardDataUrl),
    initialData: @json($dashboardData),
    initialFilters: @json($initialFilters),
    sections: @json($sectionMeta),
};
</script>
<script>
(() => {
    const config = window.crmDashboardConfig || {};
    const charts = {};
    const form = document.getElementById('crmDashboardFilters');
    const loader = document.getElementById('dashboardLoading');
    const fmt = new Intl.NumberFormat('en-IN');
    const cur = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', maximumFractionDigits: 0 });
    const tones = { primary: '#1e7bff', info: '#00a6fb', warning: '#f59e0b', success: '#16a34a', secondary: '#7c3aed', danger: '#dc2626' };

    const esc = (v) => String(v ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const num = (v, type = 'number') => type === 'currency' ? cur.format(Number(v || 0)) : fmt.format(Number(v || 0));
    const showLoading = (show) => loader.classList.toggle('show', !!show);
    const base = { chart: { toolbar: { show: false }, fontFamily: 'inherit' }, dataLabels: { enabled: false }, legend: { position: 'bottom' }, grid: { borderColor: '#ecf0f4' }, stroke: { curve: 'smooth', width: 3 }, colors: ['#1e7bff', '#16a34a', '#f59e0b', '#dc2626', '#7c3aed', '#00a6fb'], tooltip: { theme: 'light' } };
    function upsertChart(id, options) {
        const el = document.getElementById(id);
        if (!el) return;
        if (charts[id]) { charts[id].updateOptions(options, true, true); return; }
        charts[id] = new ApexCharts(el, options); charts[id].render();
    }

    function line(id, payload, area = false) {
        upsertChart(id, { ...base, chart: { ...base.chart, type: area ? 'area' : 'line', height: 310 }, series: payload.series || [], xaxis: { categories: payload.labels || [] }, fill: area ? { opacity: .18, type: 'solid' } : { opacity: 1 } });
    }

    function bar(id, payload) {
        upsertChart(id, { ...base, chart: { ...base.chart, type: 'bar', height: 310 }, plotOptions: { bar: { horizontal: true, borderRadius: 8, columnWidth: '40%' } }, series: payload.series || [], xaxis: { categories: payload.labels || [] } });
    }

    function donut(id, payload) {
        upsertChart(id, { ...base, chart: { ...base.chart, type: 'donut', height: 310 }, labels: payload.labels || [], series: payload.series || [], stroke: { width: 0 } });
    }

    function renderHero(payload) {
        document.getElementById('heroTitle').textContent = payload.hero.title || '';
        document.getElementById('heroSubtitle').textContent = payload.hero.subtitle || '';
        document.getElementById('heroHighlights').innerHTML = (payload.hero.highlights || []).map((item) => `<div class="col-sm-6"><div class="hero-kpi"><div class="hero-kpi-label">${esc(item.label)}</div><div class="hero-kpi-value">${esc(item.value)}</div></div></div>`).join('');
        document.getElementById('dashboardMetaChips').innerHTML = [`<span class="badge rounded-pill text-bg-light">${payload.meta.range.date_from} to ${payload.meta.range.date_to}</span>`, `<span class="badge rounded-pill text-bg-light">${payload.meta.range.days} days</span>`, `<span class="badge rounded-pill text-bg-light">Updated ${payload.meta.last_updated}</span>`].join('');
    }

    function renderSummary(cards) {
        document.getElementById('summaryCards').innerHTML = cards.map((card) => `<div class="col-md-6 col-xl-4"><div class="metric-card card"><div class="card-body"><div class="d-flex justify-content-between align-items-start mb-4"><div><div class="metric-label mb-2">${esc(card.label)}</div><div class="metric-value">${num(card.value)}</div></div><span class="metric-icon" style="background:${tones[card.tone]}1A;color:${tones[card.tone]};"><i class="${card.icon}"></i></span></div><div class="d-flex justify-content-between align-items-center"><span class="metric-trend ${card.trend.direction}">${card.trend.direction === 'down' ? '' : '+'}${card.trend.percentage}%</span><span class="small text-muted">vs previous window</span></div><div class="mt-3" id="spark-${card.key}"></div></div></div></div>`).join('');
        cards.forEach((card) => upsertChart(`spark-${card.key}`, { chart: { type: 'area', height: 70, sparkline: { enabled: true }, toolbar: { show: false } }, stroke: { curve: 'smooth', width: 2 }, fill: { opacity: .2 }, colors: [tones[card.tone] || '#1e7bff'], series: [{ data: card.sparkline || [] }], tooltip: { enabled: false } }));
    }

    function renderSection(key, payload) {
        document.getElementById(`${key}TimelineLabel`).textContent = payload.timeline_label || 'Timeline';
        document.getElementById(`${key}DistributionLabel`).textContent = payload.distribution_label || 'Distribution';
        document.getElementById(`${key}SegmentsLabel`).textContent = payload.segments_label || 'Segments';
        document.getElementById(`${key}ValueLabel`).textContent = payload.value_label || 'Trend';
        document.getElementById(`${key}Insights`).innerHTML = (payload.cards || []).map((card) => `<div class="col-md-4"><div class="insight-pill"><div class="insight-label">${esc(card.label)}</div><div class="insight-value">${card.type === 'number' ? num(card.value) : esc(card.value)}</div></div></div>`).join('');
        line(`${key}Timeline`, payload.charts.timeline || {});
        donut(`${key}Distribution`, payload.charts.distribution || {});
        bar(`${key}Segments`, payload.charts.segments || {});
        line(`${key}Value`, payload.charts.value || {}, true);
    }

    function renderDashboard(payload) {
        renderHero(payload);
        renderSummary(payload.summary_cards || []);
        Object.keys(config.sections || {}).forEach((key) => renderSection(key, payload.sections[key] || {}));
    }

    function buildParams() {
        const params = new URLSearchParams(new FormData(form));
        document.querySelectorAll('.section-source-filter').forEach((el) => params.set(`section_filters[${el.dataset.section}][source]`, el.value));
        document.querySelectorAll('.section-date-filter').forEach((el) => params.set(`section_filters[${el.dataset.section}][preset]`, el.value));
        return params;
    }

    async function refresh() {
        showLoading(true);
        const params = buildParams();
        const response = await fetch(`${config.endpoint}?${params.toString()}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const payload = await response.json();
        renderDashboard(payload.data);
        window.history.replaceState({}, '', `${window.location.pathname}?${params.toString()}`);
        showLoading(false);
    }

    form.addEventListener('submit', (event) => { event.preventDefault(); refresh().catch(() => showLoading(false)); });
    document.getElementById('resetCrmDashboardFilters').addEventListener('click', () => { form.reset(); document.querySelectorAll('.section-source-filter').forEach((el) => el.value = ''); document.querySelectorAll('.section-date-filter').forEach((el) => el.value = form.querySelector('[name="date_preset"]').value || 'last_30_days'); refresh().catch(() => showLoading(false)); });
    document.querySelectorAll('.section-source-filter, .section-date-filter').forEach((el) => el.addEventListener('change', () => refresh().catch(() => showLoading(false))));
    renderDashboard(config.initialData || {});
})();
</script>
@endsection
