@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Service Types</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Service</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-2 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit Service</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('covered-items.update', $coveredItem->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Service Details
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">

                                            {{-- Service Type --}}
                                            <div class="col-md-3">
                                                @include('components.form.select', [
                                                    'label' => 'Service Type',
                                                    'name' => 'service_type',
                                                    'options' => [
                                                        '' => '--Select --',
                                                        'amc' => 'AMC',
                                                        'quick_service' => 'Quick Service',
                                                        'installation' => 'Installation',
                                                        'repair' => 'Repair',
                                                    ],
                                                    'value' => old(
                                                        'service_type',
                                                        (string) $coveredItem->service_type),
                                                ])
                                                @error('service_type')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Service Name --}}
                                            <div class="col-md-3">
                                                @include('components.form.input', [
                                                    'label' => 'Service Name',
                                                    'name' => 'service_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Service Name',
                                                    'model' => $coveredItem,
                                                ])
                                                @error('service_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Service Charge (not required for AMC) --}}
                                            <div class="col-md-3">
                                                <label for="service_charge" class="form-label">
                                                    Service Charge
                                                    <small class="text-muted">(Not required for AMC)</small>
                                                </label>
                                                <input type="number" step="0.01"
                                                    class="form-control @error('service_charge') is-invalid @enderror"
                                                    id="service_charge" name="service_charge"
                                                    placeholder="Enter Service Charge"
                                                    value="{{ old('service_charge', $coveredItem->service_charge) }}">
                                                @error('service_charge')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Status --}}
                                            <div class="col-md-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status"
                                                    class="form-select @error('status') is-invalid @enderror">
                                                    <option value="active"
                                                        {{ old('status', $coveredItem->status) == 'active' ? 'selected' : '' }}>
                                                        Active
                                                    </option>
                                                    <option value="inactive"
                                                        {{ old('status', $coveredItem->status) == 'inactive' ? 'selected' : '' }}>
                                                        Inactive
                                                    </option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Diagnosis List (JSON) --}}
                                            <div class="col-md-12">
                                                <label class="form-label" for="diagnosis_input">
                                                    Diagnosis List
                                                </label>
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" id="diagnosis_input"
                                                        placeholder="Enter a diagnosis and click Add">
                                                    <button type="button" class="btn btn-outline-primary"
                                                        id="add_diagnosis_btn">
                                                        Add
                                                    </button>
                                                </div>

                                                <div id="diagnosis_list" class="border rounded p-2"
                                                    style="min-height: 40px;">
                                                </div>

                                                @php
                                                    $oldDiagnosis = old('diagnosis_list');
                                                    if (is_string($oldDiagnosis)) {
                                                        // from validation error, still JSON string
                                                        $diagnosisInitial = $oldDiagnosis;
                                                    } else {
                                                        // from model cast array
                                                        $diagnosisInitial = json_encode(
                                                            $coveredItem->diagnosis_list ?? [],
                                                        );
                                                    }
                                                @endphp

                                                <input type="hidden" name="diagnosis_list" id="diagnosis_list_json"
                                                    value='{{ $diagnosisInitial }}'>
                                                @error('diagnosis_list')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-12">
                                <div class="text-start mb-3">
                                    <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                        Update
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
            // Service charge required toggle (AMC = 0)
            const typeSelect = document.getElementById('service_type');
            const chargeInput = document.getElementById('service_charge');

            function toggleServiceChargeRequired() {
                if (typeSelect.value === '0') {
                    chargeInput.removeAttribute('required');
                } else {
                    chargeInput.setAttribute('required', 'required');
                }
            }
            if (typeSelect && chargeInput) {
                typeSelect.addEventListener('change', toggleServiceChargeRequired);
                toggleServiceChargeRequired();
            }

            // Diagnosis list tag manager
            const diagInput = document.getElementById('diagnosis_input');
            const addDiagBtn = document.getElementById('add_diagnosis_btn');
            const listDiv = document.getElementById('diagnosis_list');
            const jsonField = document.getElementById('diagnosis_list_json');

            if (!diagInput || !addDiagBtn || !listDiv || !jsonField) {
                return;
            }

            let items = [];

            // Load existing (old or model) values
            try {
                const existing = jsonField.value ? JSON.parse(jsonField.value) : [];
                if (Array.isArray(existing)) {
                    items = existing;
                }
            } catch (e) {
                items = [];
            }

            function renderDiagnosis() {
                listDiv.innerHTML = '';

                if (!items.length) {
                    listDiv.innerHTML =
                        '<span class="text-muted small">No diagnosis added yet.</span>';
                }

                items.forEach((item, index) => {
                    const id = 'diag_' + index;
                    const wrapper = document.createElement('div');
                    wrapper.className = 'form-check form-check-inline me-3 mb-1';

                    wrapper.innerHTML = `
                <input class="form-check-input diagnosis-checkbox"
                       type="checkbox"
                       id="${id}"
                       data-index="${index}"
                       checked>
                <label class="form-check-label" for="${id}">
                    ${item}
                </label>
            `;

                    listDiv.appendChild(wrapper);
                });

                jsonField.value = JSON.stringify(items);
            }

            function addDiagnosisFromInput() {
                const value = diagInput.value.trim();
                if (!value) return;

                const exists = items.some(t => t.toLowerCase() === value.toLowerCase());
                if (!exists) {
                    items.push(value);
                    renderDiagnosis();
                }
                diagInput.value = '';
                diagInput.focus();
            }

            addDiagBtn.addEventListener('click', addDiagnosisFromInput);

            diagInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addDiagnosisFromInput();
                }
            });

            listDiv.addEventListener('change', function(e) {
                if (!e.target.classList.contains('diagnosis-checkbox')) return;
                const index = parseInt(e.target.getAttribute('data-index'), 10);
                if (!isNaN(index) && items[index] !== undefined) {
                    if (!e.target.checked) {
                        items.splice(index, 1);
                        renderDiagnosis();
                    }
                }
            });

            renderDiagnosis();
        });
    </script>
@endsection
