<div class="col-sm-6 col-xl-4 col-xxl-2">
    <div class="dashboard-card stat-card h-100">
        <div class="stat-icon bg-{{ $card['direction'] === 'up' ? 'success' : 'danger' }}-subtle text-{{ $card['direction'] === 'up' ? 'success' : 'danger' }}">
            <i class="{{ $card['icon'] }}"></i>
        </div>
        <div class="d-flex align-items-start justify-content-between gap-3">
            <div>
                <span class="stat-label">{{ $card['label'] }}</span>
                <h3 class="stat-value mb-1">
                    @if ($card['format'] === 'currency')
                        Rs. {{ number_format($card['value'], 2) }}
                    @else
                        {{ number_format($card['value']) }}
                    @endif
                </h3>
                <div class="trend-chip {{ $card['direction'] === 'up' ? 'positive' : 'negative' }}">
                    <i class="fa-solid {{ $card['direction'] === 'up' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                    {{ number_format(abs($card['change']), 1) }}%
                </div>
            </div>
            <div class="sparkline" data-series='@json($card['trend'])'></div>
        </div>
    </div>
</div>
