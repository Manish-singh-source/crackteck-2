<form id="crmDashboardFilters" class="card dashboard-surface crm-filter-card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-muted">Date range</label>
                <select class="form-select" name="date_preset" id="globalDatePreset">
                    @foreach($filterOptions['date_presets'] as $value => $label)
                        <option value="{{ $value }}" @selected(($initialFilters['date_preset'] ?? '') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">From</label>
                <input type="date" class="form-control" name="date_from" value="{{ $initialFilters['date_from'] }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">To</label>
                <input type="date" class="form-control" name="date_to" value="{{ $initialFilters['date_to'] }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Apply filters</button>
                <button type="button" class="btn btn-light w-100" id="resetCrmDashboardFilters">Reset</button>
            </div>
            @foreach($sectionMeta as $section)
                <div class="col-md-3">
                    <label class="form-label small text-muted">{{ $section['filter_label'] }}</label>
                    <select class="form-select" name="{{ $section['filter_key'] }}">
                        <option value="">All {{ strtolower($section['filter_label']) }}</option>
                        @foreach(($filterOptions[$section['options_key']] ?? []) as $value => $label)
                            <option value="{{ $value }}" @selected(($initialFilters[$section['filter_key']] ?? '') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>
    </div>
</form>
