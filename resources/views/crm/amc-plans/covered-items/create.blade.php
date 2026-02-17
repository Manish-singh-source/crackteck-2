@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Service Types</li>
                            <li class="breadcrumb-item active" aria-current="page">Add Service</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-2 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Add Service</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('covered-items.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

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
                                            <div class="col-md-4">
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
                                                ])
                                                @error('service_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Service Name --}}
                                            <div class="col-md-4">
                                                @include('components.form.input', [
                                                    'label' => 'Service Name',
                                                    'name' => 'service_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Service Name',
                                                ])
                                            </div>

                                            {{-- Service Charge (not required for AMC) --}}
                                            <div class="col-md-4">
                                                <label for="service_charge" class="form-label">
                                                    Service Charge
                                                    <small class="text-muted">(Not required for AMC)</small>
                                                </label>
                                                <input type="number" step="0.01"
                                                    class="form-control @error('service_charge') is-invalid @enderror"
                                                    id="service_charge" name="service_charge"
                                                    placeholder="Enter Service Charge" value="{{ old('service_charge') }}">
                                                @error('service_charge')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Status --}}
                                            <div class="col-md-4">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status"
                                                    class="form-select @error('status') is-invalid @enderror">
                                                    <option value="active"
                                                        {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ old('status') === '0' ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                @include('components.form.input', [
                                                    'label' => 'Covered Item Image',
                                                    'name' => 'image',
                                                    'type' => 'file',
                                                    'placeholder' => 'Upload Image',
                                                    'accept' => 'image/*',
                                                ])
                                                {{-- <div id="emailHelp" class="text-danger">Image Size Should Be
                                                    800x650
                                                </div> --}}
                                            </div>

                                            {{-- Diagnosis List deviceSpecificDiagnosis --}}
                                            <div class="col-md-4">
                                                <label class="form-label" for="device_specific_diagnosis_id">
                                                    Device Specific Diagnosis
                                                </label>
                                                <select name="device_specific_diagnosis_id"
                                                    id="device_specific_diagnosis_id"
                                                    class="form-select @error('device_specific_diagnosis_id') is-invalid @enderror">
                                                    <option value="">Select Diagnosis</option>
                                                    @foreach ($deviceSpecificDiagnosis as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('device_specific_diagnosis_id') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->device_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('device_specific_diagnosis_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <div id="diagnosis_list" class="mb-2"></div>
                                                <input type="hidden" name="diagnosis_list" id="diagnosis_list_json"
                                                    value="{{ old('diagnosis_list_json') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="text-start mb-3">
                                        <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                            Submit
                                        </button>
                                    </div>
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
            const deviceDiagnosisSelect = document.getElementById('device_specific_diagnosis_id');
            const diagnosisList = document.getElementById('diagnosis_list');
            const diagnosisListJson = document.getElementById('diagnosis_list_json');

            // Listen for changes on device diagnosis select
            deviceDiagnosisSelect.addEventListener('change', function() {
                const deviceId = this.value;

                // Clear previous diagnoses
                diagnosisList.innerHTML = '';
                diagnosisListJson.value = '';

                if (!deviceId) {
                    return;
                }

                // Fetch diagnosis list via AJAX
                fetch(`{{ route('get-diagnosis-list', '') }}/${deviceId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.diagnosis_list && data.diagnosis_list.length > 0) {
                            displayDiagnoses(data.diagnosis_list);
                        } else {
                            diagnosisList.innerHTML =
                                '<p class="text-muted">No diagnoses available for this device type</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching diagnoses:', error);
                        diagnosisList.innerHTML = '<p class="text-danger">Error loading diagnoses</p>';
                    });
            });

            // Function to display diagnoses as checkboxes
            function displayDiagnoses(diagnoses) {
                const checkboxesHtml = diagnoses.map((diagnosis, index) => {
                    return `
                        <div class="form-check">
                            <input class="form-check-input diagnosis-checkbox" type="checkbox" 
                                   value="${diagnosis}" id="diagnosis_${index}" checked>
                            <label class="form-check-label" for="diagnosis_${index}">
                                ${diagnosis}
                            </label>
                        </div>
                    `;
                }).join('');

                diagnosisList.innerHTML = checkboxesHtml;

                // Add change listeners to checkboxes
                document.querySelectorAll('.diagnosis-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', updateDiagnosisJson);
                });

                // Auto-select all checkboxes and update the hidden field
                updateDiagnosisJson();
            }

            // Function to update the hidden JSON field with selected diagnoses
            function updateDiagnosisJson() {
                const selectedDiagnoses = Array.from(document.querySelectorAll('.diagnosis-checkbox:checked'))
                    .map(checkbox => checkbox.value);

                diagnosisListJson.value = JSON.stringify(selectedDiagnoses);
            }
        });
    </script>
@endsection
