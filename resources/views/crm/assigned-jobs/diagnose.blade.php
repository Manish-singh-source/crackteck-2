@extends('crm/layouts/master')

@section('content')
    <div class="content">


        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Assigned Jobs</li>
                            <li class="breadcrumb-item active" aria-current="page">Start Job</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0"></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header border-bottom-dashed">
                                    <div class="d-flex">
                                        <h5 class="card-title flex-grow-1 mb-0">
                                            Product Detail
                                        </h5>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush ">

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Product Name :
                                                    </span>
                                                    <span>
                                                        {{ $serviceRequestProduct->name }}
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Product Type :
                                                    </span>
                                                    <span>
                                                        {{ $serviceRequestProduct->type }}
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Purchase Date :
                                                    </span>
                                                    <span>
                                                        {{ $serviceRequestProduct->purchase_date }}
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Brand :
                                                    </span>
                                                    <span>
                                                        {{ $serviceRequestProduct->brand }}
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Service Charge :
                                                    </span>
                                                    <span>
                                                        {{ $serviceRequestProduct->service_charge }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush ">

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Model No. :
                                                    </span>
                                                    <span>
                                                        {{ $serviceRequestProduct->model_no }}
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">SKU :
                                                    </span>
                                                    <span>
                                                        {{ $serviceRequestProduct->sku }}
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">HSN :
                                                    </span>
                                                    <span>
                                                        {{ $serviceRequestProduct->hsn }}
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Description :
                                                    </span>
                                                    <span>
                                                        {{ $serviceRequestProduct->description }}
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Status :
                                                    </span>
                                                    <span>
                                                        {{ ucwords(str_replace('_', ' ', $serviceRequestProduct?->remoteSupportDiagnose?->status)) }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons Section -->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header border-bottom-dashed">
                                    <h5 class="card-title mb-0">Workflow Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-primary start-job-btn workflow-btn"
                                                data-step="1">
                                                <i class="ri-play-line"></i> Start Job
                                                <span class="workflow-status ms-2" style="display: none;">✓</span>
                                            </button>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-info perform-diagnosis-btn workflow-btn"
                                                data-step="2">
                                                <i class="ri-stethoscope-line"></i> Perform Diagnosis
                                                <span class="workflow-status ms-2" style="display: none;">✓</span>
                                            </button>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-warning take-action-btn workflow-btn"
                                                data-step="3">
                                                <i class="ri-tools-line"></i> Take Action
                                                <span class="workflow-status ms-2" style="display: none;">✓</span>
                                            </button>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-danger escalate-btn workflow-btn"
                                                data-step="4">
                                                <i class="ri-arrow-up-line"></i> Escalate to On-Site
                                                <span class="workflow-status ms-2" style="display: none;">✓</span>
                                            </button>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-success complete-job-btn workflow-btn"
                                                data-step="5">
                                                <i class="ri-check-double-line"></i> Complete Job
                                                <span class="workflow-status ms-2" style="display: none;">✓</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (!$remoteSupportJob?->diagnosis?->client_connected_via)
                            <!-- Start Job Section -->
                            <div class="col-lg-12 start-job-section">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Start Job
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <form method="POST"
                                            action="{{ route('assigned-jobs.startDiagnose', ['id' => $serviceRequestProduct->id, 'step' => '1', 'remote_support_id' => $remote_support_id]) }}">
                                            @csrf
                                            <div class="row g-3 mb-3">
                                                <div class="col-6">
                                                    <label class="form-label">Client Connected Via <span
                                                            class="text-danger">*</span></label>
                                                    <select name="client_connected" id="client_connected"
                                                        class="form-select" required
                                                        {{ $remoteSupportJob?->diagnosis?->client_connected_via ? 'disabled' : '' }}>
                                                        <option value="">--Select--</option>
                                                        <option value="call"
                                                            {{ old('client_connected', $remoteSupportJob?->diagnosis?->client_connected_via) === 'call' ? 'selected' : '' }}>
                                                            Call</option>
                                                        <option value="email"
                                                            {{ old('client_connected', $remoteSupportJob?->diagnosis?->client_connected_via) === 'email' ? 'selected' : '' }}>
                                                            E-mail</option>
                                                        <option value="whatsapp"
                                                            {{ old('client_connected', $remoteSupportJob?->diagnosis?->client_connected_via) === 'whatsapp' ? 'selected' : '' }}>
                                                            WhatsApp</option>
                                                    </select>
                                                </div>

                                                <div class="col-6">
                                                    <label class="form-label">Client Confirmation <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="client_confirmation"
                                                        id="client_confirmation" class="form-control"
                                                        placeholder="Enter Confirmation Details"
                                                        value="{{ old('client_confirmation', $remoteSupportJob?->diagnosis?->client_confirmation) }}"
                                                        required
                                                        {{ $remoteSupportJob?->diagnosis?->client_confirmation ? 'disabled' : '' }}>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Remote Tool Used <span
                                                            class="text-danger">*</span></label>
                                                    <select name="remote_tool" id="remote_tool" class="form-select"
                                                        required
                                                        {{ $remoteSupportJob?->diagnosis?->remote_tool ? 'disabled' : '' }}>
                                                        <option value="">--Select Remote Tool--</option>
                                                        <option value="anydesk"
                                                            {{ old('remote_tool', $remoteSupportJob?->diagnosis?->remote_tool) === 'anydesk' ? 'selected' : '' }}>
                                                            Anydesk</option>
                                                        <option value="teamviewer"
                                                            {{ old('remote_tool', $remoteSupportJob?->diagnosis?->remote_tool) === 'teamviewer' ? 'selected' : '' }}>
                                                            Team Viewer</option>
                                                    </select>
                                                </div>
                                            </div>
                                            @if (!$remoteSupportJob?->diagnosis?->client_connected_via)
                                                <div class="row g-3">
                                                    <div class="text-start mb-3">
                                                        <button type="submit"
                                                            class="btn btn-success w-sm waves ripple-light">Submit</button>
                                                    </div>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($remoteSupportJob?->diagnosis?->client_connected_via)
                            <!-- Start Details Section -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="d-flex">
                                            <h5 class="card-title flex-grow-1 mb-0">
                                                Job Details
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <ul class="list-group list-group-flush ">

                                                    <li
                                                        class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                        <span class="fw-semibold text-break">Connected Via :
                                                        </span>
                                                        <span id="display_client_connected">
                                                            {{ ucfirst($remoteSupportJob?->diagnosis?->client_connected_via) }}
                                                        </span>
                                                    </li>

                                                    <li
                                                        class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                        <span class="fw-semibold text-break">Client Confirmation :
                                                        </span>
                                                        <span id="display_client_confirmation">
                                                            {{ ucfirst($remoteSupportJob?->diagnosis?->client_confirmation) }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-6">
                                                <ul class="list-group list-group-flush ">
                                                    <li
                                                        class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                        <span class="fw-semibold text-break">Remote Tool Used :
                                                        </span>
                                                        <span id="display_remote_tool">
                                                            {{ ucfirst($remoteSupportJob?->diagnosis?->remote_tool) }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($remoteSupportJob?->diagnosis?->client_connected_via && !$remoteSupportJob?->diagnosis?->diagnosis_list)
                            <!-- Diagnosis Section -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Diagnosis Details
                                                </h5>
                                            </div>
                                            @if ($remoteSupportJob?->diagnosis?->status != 'resolved' && $remoteSupportJob?->diagnosis?->status != 'escalated')
                                                <div class="text-start mb-0">
                                                    <a href="#"
                                                        class="btn btn-success w-sm waves ripple-light escalate-section-btn">Escalate</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <form method="POST"
                                            action="{{ route('assigned-jobs.startDiagnose', ['id' => $serviceRequestProduct->id, 'step' => '2', 'remote_support_id' => $remote_support_id]) }}">
                                            @csrf
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <div class="fw-bold">
                                                        Diagnosis Type <span class="text-danger">*</span>
                                                    </div>
                                                </div>
                                                @foreach ($serviceRequestProduct?->productDiagnose?->diagnosis_list as $diagnosis)
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input diagnosis-type-checkbox"
                                                                name="diagnosis_list[]" type="checkbox"
                                                                value="{{ $diagnosis }}" id="{{ $diagnosis }}">
                                                            <label class="form-check-label" for="{{ $diagnosis }}">
                                                                {{ $diagnosis }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row g-3 pt-3 mb-3">
                                                <div class="col-12">
                                                    <label for="diagnosis_notes" class="form-label">Diagnosis Notes: <span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="diagnosis_notes" id="diagnosis_notes" class="form-control" rows="4" required></textarea>
                                                </div>
                                            </div>

                                            @if (!$remoteSupportJob?->diagnosis?->diagnosis_list)
                                                <div class="row g-3">
                                                    <div class="text-start mb-3">
                                                        <button type="submit"
                                                            class="btn btn-success w-sm waves ripple-light">Submit</button>
                                                    </div>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($remoteSupportJob?->diagnosis?->diagnosis_list)
                            <!-- Diagnosis Details Section -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="d-flex">
                                            <h5 class="card-title flex-grow-1 mb-0">
                                                Diagnosis Details
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row gap-3">
                                            <div class="col-12">
                                                <div class="fw-semibold text-break">
                                                    Diagnosis Type
                                                </div>
                                                <ul class="list-group list-group-flush" id="display_diagnosis_types">
                                                    @forelse (json_decode($remoteSupportJob?->diagnosis?->diagnosis_list) as $diagnosis)
                                                        <li class="list-group-item border-0">{{ $diagnosis }}</li>
                                                    @empty
                                                        <li class="list-group-item border-0">N/A</li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                            <div class="col-12">
                                                <div class="fw-semibold text-break">Diagnosis Notes :
                                                </div>
                                                <div id="display_diagnosis_notes">
                                                    {{ $remoteSupportJob?->diagnosis?->diagnosis_notes }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($remoteSupportJob?->diagnosis?->diagnosis_list && !$remoteSupportJob?->diagnosis?->before_screenshots)
                            <!-- Action Taken Section -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Action Taken
                                                </h5>
                                            </div>
                                            @if ($remoteSupportJob?->diagnosis?->status != 'resolved' && $remoteSupportJob?->diagnosis?->status != 'escalated')
                                                <div class="text-start mb-0">
                                                    <a href="#"
                                                        class="btn btn-success w-sm waves ripple-light escalate-section-btn">Escalate</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <form method="POST"
                                            action="{{ route('assigned-jobs.startDiagnose', ['id' => $serviceRequestProduct->id, 'step' => '3', 'remote_support_id' => $remote_support_id]) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row g-3 mb-3">
                                                <div class="col-12">
                                                    <label for="fix_description" class="form-label">Fix Description: <span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="fix_description" id="fix_description" class="form-control" rows="4" required></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label for="before_screenshot" class="form-label">Before
                                                        Screenshot</label>
                                                    <input type="file" name="before_screenshot" id="before_screenshot"
                                                        class="form-control" accept="image/*">
                                                </div>
                                                <div class="col-12">
                                                    <label for="after_screenshot" class="form-label">After
                                                        Screenshot</label>
                                                    <input type="file" name="after_screenshot" id="after_screenshot"
                                                        class="form-control" accept="image/*">
                                                </div>
                                                <div class="col-12">
                                                    <label for="logs" class="form-label">Logs (if any)</label>
                                                    <input type="file" name="logs" id="logs"
                                                        class="form-control" accept=".txt,.pdf,.log">
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="text-start mb-3">
                                                    <button type="submit"
                                                        class="btn btn-success w-sm waves ripple-light">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($remoteSupportJob?->diagnosis?->before_screenshots)
                            <!-- Action Taken Details Section -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="d-flex">
                                            <h5 class="card-title flex-grow-1 mb-0">
                                                Action Taken Details
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row gap-3">
                                            <div class="col-12">
                                                <div class="fw-semibold text-break">Fix Description :
                                                </div>
                                                <div id="display_fix_description">
                                                    {{ $remoteSupportJob?->diagnosis?->fix_description }}
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <span class="fw-semibold text-break">
                                                    Before Screenshot:
                                                </span>
                                                @if ($remoteSupportJob?->diagnosis?->before_screenshots)
                                                    <span id="display_before_screenshot_container">
                                                        <a href="{{ asset($remoteSupportJob?->diagnosis?->before_screenshots) }}"
                                                            id="display_before_screenshot" class="btn btn-sm btn-primary"
                                                            target="_blank">View</a>
                                                    </span>
                                                @else
                                                    <span id="display_before_screenshot_na">N/A</span>
                                                @endif
                                            </div>
                                            <div class="col-12">
                                                <span class="fw-semibold text-break">
                                                    After Screenshot:
                                                </span>
                                                @if ($remoteSupportJob?->diagnosis?->after_screenshots)
                                                    <span id="display_after_screenshot_container">
                                                        <a href="{{ asset($remoteSupportJob?->diagnosis?->after_screenshots) }}"
                                                            id="display_after_screenshot" class="btn btn-sm btn-primary"
                                                            target="_blank">View</a>
                                                    </span>
                                                @else
                                                    <span id="display_after_screenshot_na">N/A</span>
                                                @endif
                                            </div>
                                            <div class="col-12">
                                                <span class="fw-semibold text-break">
                                                    Logs (if any):
                                                </span>
                                                @if ($remoteSupportJob?->diagnosis?->logs)
                                                    <span id="display_logs_container">
                                                        <a href="{{ asset($remoteSupportJob?->diagnosis?->logs) }}"
                                                            id="display_logs" class="btn btn-sm btn-primary"
                                                            target="_blank">View</a>
                                                    </span>
                                                @else
                                                    <span id="display_logs_na">N/A</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (
                            $remoteSupportJob?->diagnosis?->before_screenshots &&
                                $remoteSupportJob?->diagnosis?->status != 'resolved' &&
                                $remoteSupportJob?->diagnosis?->status != 'escalated')
                            <div class="col-lg-12">
                                <div class="d-flex gap-2">

                                    <div class="text-start mb-3">
                                        <a href="#"
                                            class="btn btn-success w-sm waves ripple-light escalate-section-btn">Escalate</a>
                                    </div>
                                    <div class="text-start mb-3">
                                        <a href="#"
                                            class="btn btn-success w-sm waves ripple-light job-complete-section-btn">Complete
                                            Job</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($remoteSupportJob?->diagnosis?->before_screenshots && $remoteSupportJob?->diagnosis?->status != 'resolved')
                            <!-- Complete Job Section -->
                            <div class="col-lg-12 job-complete-section">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Complete Job
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <form method="POST"
                                            action="{{ route('assigned-jobs.startDiagnose', ['id' => $serviceRequestProduct->id, 'step' => '4', 'remote_support_id' => $remote_support_id]) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row g-3 mb-3">
                                                <div class="col-12">
                                                    <label for="time_spent" class="form-label">Time Spent(HH:MM) <span
                                                            class="text-danger">*</span></label>
                                                    <input type="time" name="time_spent" id="time_spent"
                                                        class="form-control" required>
                                                </div>
                                                <div class="col-12">
                                                    <label for="result" class="form-label">Result <span
                                                            class="text-danger">*</span></label>
                                                    <select name="result" id="result" class="form-control" required>
                                                        <option value="">-- Select --</option>
                                                        <option value="resolved">Resolved - Remote</option>
                                                        <option value="unresolved">Unresolved - Remote</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label for="client_feedback" class="form-label">Client Feedback: <span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="client_feedback" id="client_feedback" class="form-control" rows="4" required></textarea>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="text-start mb-3">
                                                    <button type="submit"
                                                        class="btn btn-success w-sm waves ripple-light">Mark
                                                        as
                                                        Complete</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif


                        @if ($remoteSupportJob?->diagnosis?->status == 'resolved')
                            <!-- Action Taken Details Section -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="d-flex">
                                            <h5 class="card-title flex-grow-1 mb-0">
                                                Completed Job Details
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row gap-3">
                                            <div class="col-12">
                                                <div class="fw-semibold text-break">Time Spent(HH:MM)
                                                </div>
                                                <div id="display_fix_description">
                                                    {{ $remoteSupportJob?->diagnosis?->time_spent }}
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="fw-semibold text-break">Result
                                                </div>
                                                <div id="display_fix_description">
                                                    {{ $remoteSupportJob?->diagnosis?->status }}
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="fw-semibold text-break">Client Feedback
                                                </div>
                                                <div id="display_fix_description">
                                                    {{ $remoteSupportJob?->diagnosis?->client_feedback }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Escalate Section -->
                        <div class="col-lg-12 escalate-section">
                            <div class="card">
                                <div class="card-header border-bottom-dashed">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-sm">
                                            <h5 class="card-title mb-0">
                                                Escalate to On-Site
                                            </h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <form method="POST"
                                        action="{{ route('assigned-jobs.startDiagnose', ['id' => $serviceRequestProduct->id, 'step' => '5', 'remote_support_id' => $remote_support_id]) }}">
                                        @csrf
                                        <div class="row g-3 mb-3">
                                            <div class="col-12">
                                                <label class="form-label">Reason For Escalation <span
                                                        class="text-danger">*</span></label>
                                                <select name="reason_for_escalation" id="reason_for_escalation"
                                                    class="form-select" required>
                                                    <option value="">--Select Reason--</option>
                                                    <option value="Hardware Failure">Hardware Failure</option>
                                                    <option value="No Internet Access">No Internet Access</option>
                                                    <option value="Physical Inspection Required">Physical Inspection
                                                        Required</option>
                                                    <option value="Component Replacement">Component Replacement</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="escalation_notes" class="form-label">Additional Notes: <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="escalation_notes" id="escalation_notes" class="form-control" rows="4"
                                                    placeholder="Enter escalation reason and notes..."></textarea>
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="text-start mb-3">
                                                <button type="submit"
                                                    class="btn btn-success w-sm waves ripple-light">Escalate
                                                    Product</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $(".job-complete-section").hide();
            $(".job-complete-section-btn").on("click", function(e) {
                e.preventDefault();

                $(".escalate-section").hide();
                $(".job-complete-section").show();
            });

            $(".escalate-section").hide();
            $(".escalate-section-btn").on("click", function(e) {
                e.preventDefault();

                $(".job-complete-section").hide();
                $(".escalate-section").show();
            });
        });
    </script>

@endsection
