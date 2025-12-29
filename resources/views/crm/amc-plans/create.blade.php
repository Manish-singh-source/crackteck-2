@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            {{-- Breadcrumb --}}
            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">AMC Plan</li>
                            <li class="breadcrumb-item active" aria-current="page">Add AMC Plan</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Add AMC Plan</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">

                    <form action="{{ route('amc-plan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- LEFT: Plan + duration + pricing --}}
                            <div class="col-lg-8">

                                {{-- Plan Information --}}
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">Plan Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3 pb-3">

                                            {{-- Plan Name --}}
                                            <div class="col-xl-6 col-lg-6">
                                                @include('components.form.input', [
                                                    'label' => 'Plan Name',
                                                    'name' => 'plan_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Basic, Standard, etc.',
                                                    'value' => old('plan_name'),
                                                ])
                                                @error('plan_name')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Plan Code --}}
                                            <div class="col-xl-6 col-lg-6">
                                                @include('components.form.input', [
                                                    'label' => 'Plan Code',
                                                    'name' => 'plan_code',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Code',
                                                    'value' => old('plan_code'),
                                                ])
                                                @error('plan_code')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Plan Description --}}
                                            <div class="col-12">
                                                <label for="description" class="form-label">
                                                    Description <span class="text-danger">*</span>
                                                </label>
                                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                                    placeholder="Enter Description" rows="3">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- Duration & Coverage --}}
                                <div class="card pb-4 mt-3">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">Duration and Coverage</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">

                                            {{-- Contract Duration (preset + custom) --}}
                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Contract Duration',
                                                    'name' => 'duration_type',
                                                    'options' => [
                                                        '' => '--Select Duration--',
                                                        '6m' => '6 months',
                                                        '12m' => '1 year',
                                                        '24m' => '2 years',
                                                        'custom' => 'Custom',
                                                    ],
                                                    'value' => old('duration_type'),
                                                ])
                                                @error('duration_type')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Duration in months (DB field: duration) --}}
                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Duration (in months)',
                                                    'name' => 'duration',
                                                    'type' => 'number',
                                                    'placeholder' => 'e.g. 12',
                                                    'value' => old('duration'),
                                                    'attributes' => 'min=1',
                                                ])
                                                @error('duration')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">
                                                    If you select a preset duration, this will auto-fill.
                                                </small>
                                            </div>

                                            {{-- Total Visits --}}
                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Total Visits Included',
                                                    'name' => 'total_visits',
                                                    'type' => 'number',
                                                    'placeholder' => 'Enter number of visits',
                                                    'value' => old('total_visits'),
                                                ])
                                                @error('total_visits')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- Pricing --}}
                                <div class="card mt-3">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">Pricing Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">

                                            {{-- Plan Cost --}}
                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Plan Cost (₹)',
                                                    'name' => 'plan_cost',
                                                    'type' => 'number',
                                                    'placeholder' => 'Enter Plan Cost (₹)',
                                                    'value' => old('plan_cost'),
                                                    'attributes' => 'step=0.01 min=0',
                                                ])
                                                @error('plan_cost')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Tax --}}
                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Tax (%)',
                                                    'name' => 'tax',
                                                    'type' => 'number',
                                                    'placeholder' => 'Enter Tax (%)',
                                                    'value' => old('tax'),
                                                    'attributes' => 'step=0.01 min=0',
                                                ])
                                                @error('tax')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Total Cost --}}
                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Total Cost (₹)',
                                                    'name' => 'total_cost',
                                                    'type' => 'number',
                                                    'placeholder' => 'Auto calculated',
                                                    'value' => old('total_cost'),
                                                    'attributes' => 'step=0.01 min=0 readonly',
                                                ])
                                                @error('total_cost')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Payment Terms --}}
                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Payment Terms',
                                                    'name' => 'pay_terms',
                                                    'options' => [
                                                        '' => '--Select --',
                                                        '0' => 'Full Payment',
                                                        '1' => 'Installments',
                                                    ],
                                                    'value' => old('pay_terms'),
                                                ])
                                                @error('pay_terms')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- RIGHT: Support, covered items, other details, status --}}
                            <div class="col-lg-4">

                                {{-- Support & Covered Items --}}
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">Services Included</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">

                                            {{-- Support Type --}}
                                            <div class="col-12">
                                                @include('components.form.select', [
                                                    'label' => 'Support Type',
                                                    'name' => 'support_type',
                                                    'options' => [
                                                        '' => '--Select --',
                                                        '0' => 'Onsite',
                                                        '1' => 'Remote',
                                                        '2' => 'Both',
                                                    ],
                                                    'value' => old('support_type'),
                                                ])
                                                @error('support_type')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Covered Items (AMC only) + chips --}}
                                            <div class="col-12">
                                                <label class="form-label mb-1">Covered AMC Items</label>

                                                @php
                                                    $selectedCoveredItems = old(
                                                        'covered_items_ids',
                                                        $selectedCoveredItems ?? [],
                                                    );
                                                @endphp

                                                <div class="position-relative" id="covered-items-multiselect">

                                                    {{-- Input + chips container --}}
                                                    <div class="form-control d-flex flex-wrap align-items-center gap-1"
                                                        id="covered-items-control" style="cursor: text; min-height: 40px;">

                                                        {{-- Chips will be injected here by JS --}}

                                                        {{-- Search input --}}
                                                        <input type="text" id="covered-items-search"
                                                            class="border-0 flex-grow-1"
                                                            style="min-width: 120px; outline: none; box-shadow: none;"
                                                            placeholder="Search & select items">
                                                    </div>

                                                    {{-- Dropdown list --}}
                                                    <div class="border rounded bg-white shadow-sm mt-1 position-absolute w-100"
                                                        id="covered-items-dropdown"
                                                        style="z-index: 1050; max-height: 260px; overflow-y: auto; display: none;">
                                                        @forelse ($coveredItems as $item)
                                                            @if ($item->service_type == 0)
                                                                <div class="px-2 py-1 covered-item-option"
                                                                    data-id="{{ $item->id }}"
                                                                    data-label="{{ $item->service_name }}">
                                                                    {{ $item->service_name }}
                                                                </div>
                                                            @endif
                                                        @empty
                                                            <div class="px-2 py-2 text-muted small">
                                                                No AMC items available.
                                                            </div>
                                                        @endforelse
                                                    </div>

                                                    {{-- Hidden field (JSON of selected IDs) --}}
                                                    <input type="hidden" name="covered_items_ids" id="covered_items_ids"
                                                        value='@json($selectedCoveredItems)'>
                                                </div>

                                                @error('covered_items_ids')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>




                                        </div>
                                    </div>
                                </div>

                                {{-- Other Details --}}
                                <div class="card mt-3">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">Other Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">

                                            {{-- Brochure --}}
                                            <div class="col-12">
                                                @include('components.form.input', [
                                                    'label' => 'Upload Plan Brochure',
                                                    'name' => 'brochure',
                                                    'type' => 'file',
                                                ])
                                                @error('brochure')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Terms & Conditions --}}
                                            <div class="col-12">
                                                <label for="tandc" class="form-label">Terms and Conditions</label>
                                                <textarea name="tandc" id="tandc" class="form-control" placeholder="Enter Terms and Conditions"
                                                    rows="3">{{ old('tandc') }}</textarea>
                                            </div>

                                            {{-- Replacement Policy --}}
                                            <div class="col-12">
                                                <label for="replacement_policy" class="form-label">Replacement
                                                    Policy</label>
                                                <textarea name="replacement_policy" id="replacement_policy" class="form-control"
                                                    placeholder="Enter Replacement Policy" rows="3">{{ old('replacement_policy') }}</textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="card mt-3">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">Status</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                @include('components.form.select', [
                                                    'label' => 'Status',
                                                    'name' => 'status',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        '0' => 'Inactive',
                                                        '1' => 'Active',
                                                    ],
                                                    'value' => old('status', '1'),
                                                ])
                                                @error('status')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Submit --}}
                            <div class="col-lg-12">
                                <div class="text-start mb-3 mt-3">
                                    <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                        Submit
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto calculate total_cost
            const planCostInput = document.getElementById('plan_cost');
            const taxInput = document.getElementById('tax');
            const totalCostInput = document.getElementById('total_cost');

            function recalcTotal() {
                const planCost = parseFloat(planCostInput.value || 0);
                const tax = parseFloat(taxInput.value || 0);
                const taxAmt = planCost * tax / 100;
                const total = planCost + taxAmt;
                if (!isNaN(total)) {
                    totalCostInput.value = total.toFixed(2);
                }
            }

            if (planCostInput && taxInput && totalCostInput) {
                planCostInput.addEventListener('input', recalcTotal);
                taxInput.addEventListener('input', recalcTotal);
                recalcTotal();
            }

            // Duration type -> duration in months
            const durationTypeSelect = document.getElementById('duration_type');
            const durationInput = document.getElementById('duration');

            if (durationTypeSelect && durationInput) {
                function syncDuration() {
                    const type = durationTypeSelect.value;
                    if (type === '6m') {
                        durationInput.value = 6;
                        durationInput.readOnly = true;
                    } else if (type === '12m') {
                        durationInput.value = 12;
                        durationInput.readOnly = true;
                    } else if (type === '24m') {
                        durationInput.value = 24;
                        durationInput.readOnly = true;
                    } else if (type === 'custom') {
                        durationInput.value = '';
                        durationInput.readOnly = false;
                    } else {
                        durationInput.value = '';
                        durationInput.readOnly = true;
                    }
                }
                durationTypeSelect.addEventListener('change', syncDuration);
                syncDuration();
            }

            // Covered items -> chips + hidden JSON
            const coveredCheckboxes = document.querySelectorAll('input[name="covered_items_ids[]"]');
            const chipsContainer = document.getElementById('covered_items_chips');
            const hiddenJsonField = document.getElementById('covered_items_json');

            let selectedIds = [];

            // Load initial from hidden JSON / old()
            try {
                const initial = hiddenJsonField.value ? JSON.parse(hiddenJsonField.value) : [];
                if (Array.isArray(initial)) {
                    selectedIds = initial.map(id => parseInt(id, 10)).filter(id => !isNaN(id));
                }
            } catch (e) {
                selectedIds = [];
            }

            // Sync checkbox checked state from selectedIds
            coveredCheckboxes.forEach(cb => {
                const id = parseInt(cb.value, 10);
                if (selectedIds.includes(id)) {
                    cb.checked = true;
                }
                // store label in data-label for chips
                if (!cb.dataset.label) {
                    const labelEl = cb.closest('.form-check').querySelector('label.form-check-label');
                    if (labelEl) cb.dataset.label = labelEl.textContent.trim();
                }
            });

            function renderChips() {
                chipsContainer.innerHTML = '';

                if (!selectedIds.length) {
                    chipsContainer.innerHTML =
                        '<span class="text-muted small">No item selected.</span>';
                    hiddenJsonField.value = '[]';
                    return;
                }

                selectedIds.forEach(id => {
                    const cb = document.querySelector('input[name="covered_items_ids[]"][value="' + id +
                        '"]');
                    if (!cb) return;
                    const label = cb.dataset.label || ('Item ' + id);

                    const chip = document.createElement('span');
                    chip.className = 'badge bg-primary me-2 mb-2';
                    chip.dataset.id = id;

                    chip.innerHTML = `
                ${label}
                <button type="button"
                        class="btn-close btn-close-white btn-sm ms-1"
                        aria-label="Remove"
                        style="font-size: 0.6rem;"></button>
            `;

                    chipsContainer.appendChild(chip);
                });

                hiddenJsonField.value = JSON.stringify(selectedIds);
            }

            // Checkbox change
            coveredCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const id = parseInt(this.value, 10);
                    if (isNaN(id)) return;

                    if (this.checked) {
                        if (!selectedIds.includes(id)) selectedIds.push(id);
                    } else {
                        selectedIds = selectedIds.filter(x => x !== id);
                    }
                    renderChips();
                });
            });

            // Chip X click
            chipsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-close')) {
                    const chip = e.target.closest('span.badge');
                    if (!chip) return;

                    const id = parseInt(chip.dataset.id, 10);
                    if (isNaN(id)) return;

                    const cb = document.querySelector('input[name="covered_items_ids[]"][value="' + id +
                        '"]');
                    if (cb) cb.checked = false;

                    selectedIds = selectedIds.filter(x => x !== id);
                    renderChips();
                }
            });

            renderChips();
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wrapper = document.getElementById('covered-items-multiselect');
            const control = document.getElementById('covered-items-control');
            const searchInput = document.getElementById('covered-items-search');
            const dropdown = document.getElementById('covered-items-dropdown');
            const hiddenField = document.getElementById('covered_items_ids');
            const options = dropdown.querySelectorAll('.covered-item-option');

            let selectedIds = [];

            // Load initial selected IDs from hidden field (JSON)
            try {
                const initial = hiddenField.value ? JSON.parse(hiddenField.value) : [];
                if (Array.isArray(initial)) {
                    selectedIds = initial.map(id => parseInt(id, 10)).filter(id => !isNaN(id));
                }
            } catch (e) {
                selectedIds = [];
            }

            function updateHiddenField() {
                hiddenField.value = JSON.stringify(selectedIds);
            }

            function renderChips() {
                // Remove existing chips
                control.querySelectorAll('.covered-item-chip').forEach(el => el.remove());

                selectedIds.forEach(id => {
                    const opt = dropdown.querySelector('.covered-item-option[data-id="' + id + '"]');
                    if (!opt) return;
                    const label = opt.dataset.label || ('Item ' + id);

                    const chip = document.createElement('span');
                    chip.className = 'badge bg-primary covered-item-chip d-flex align-items-center';
                    chip.style.gap = '0.25rem';
                    chip.dataset.id = id;

                    chip.innerHTML = `
                <span>${label}</span>
                <button type="button"
                        class="btn-close btn-close-white btn-sm"
                        aria-label="Remove"
                        style="font-size: 0.5rem;"></button>
            `;

                    // Insert before search input
                    control.insertBefore(chip, searchInput);
                });

                updateHiddenField();
            }

            function openDropdown() {
                dropdown.style.display = 'block';
            }

            function closeDropdown() {
                dropdown.style.display = 'none';
            }

            function filterOptions() {
                const query = searchInput.value.toLowerCase().trim();

                options.forEach(opt => {
                    const label = opt.dataset.label.toLowerCase();
                    opt.style.display = label.includes(query) ? 'block' : 'none';
                });
            }

            // Click in control or focus input -> open dropdown
            control.addEventListener('click', function() {
                searchInput.focus();
                openDropdown();
            });

            searchInput.addEventListener('focus', function() {
                openDropdown();
            });

            searchInput.addEventListener('input', function() {
                filterOptions();
            });

            // Option click -> select / deselect
            options.forEach(opt => {
                opt.addEventListener('click', function() {
                    const id = parseInt(this.dataset.id, 10);
                    if (isNaN(id)) return;

                    if (selectedIds.includes(id)) {
                        // deselect
                        selectedIds = selectedIds.filter(x => x !== id);
                    } else {
                        selectedIds.push(id);
                    }

                    renderChips();
                });
            });

            // Chip X -> remove
            control.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-close')) {
                    const chip = e.target.closest('.covered-item-chip');
                    if (!chip) return;

                    const id = parseInt(chip.dataset.id, 10);
                    if (isNaN(id)) return;

                    selectedIds = selectedIds.filter(x => x !== id);
                    renderChips();
                    e.stopPropagation(); // prevent dropdown toggle
                }
            });

            // Click outside -> close dropdown
            document.addEventListener('click', function(e) {
                if (!wrapper.contains(e.target)) {
                    closeDropdown();
                }
            });

            // Initial render
            renderChips();
        });
    </script>
@endsection
