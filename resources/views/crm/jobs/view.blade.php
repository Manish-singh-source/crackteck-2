@extends('crm/layouts/master')

@section('content')

<style>
    #popupOverlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    #popupOverlay img {
        max-width: 90%;
        max-height: 90%;
        box-shadow: 0 0 10px #fff;
    }

    #popupOverlay .closeBtn {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 30px;
        color: white;
        cursor: pointer;
    }

    button {
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }
</style>
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-8 mx-auto">

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Job Details
                            </h5>
                            <div class="fw-bold text-dark">
                                {{ $job->id }}
                            </div>
                        </div>
                    </div>



                    <div class="card-body">
                        <div class="row">


                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush ">

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Client Name :
                                        </span>
                                        <span>
                                            {{ $job->first_name }} {{ $job->last_name }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Engineer Name :
                                        </span>
                                        <span>
                                            @if($assignment)
                                                {{ $assignment->engineer->first_name }} {{ $assignment->engineer->last_name }}
                                            @else
                                                Not Assigned
                                            @endif
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Issue Type :
                                        </span>
                                        <span>
                                            {{ $job->issue_type }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush ">

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Schedule/Deadline :
                                        </span>
                                        <span>
                                            {{ $job->purchase_date ? $job->purchase_date->format('Y-m-d') : 'N/A' }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Status :
                                        </span>
                                        <span>
                                            <span class="badge bg-danger-subtle text-danger fw-semibold">Pending</span>
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Priority :
                                        </span>
                                        <span>
                                            <span class="badge bg-danger-subtle text-danger fw-semibold">High</span>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Devices Details
                            </h5>
                            <button type="button" class="btn btn-danger btn-sm" id="bulk-delete-devices-btn" style="display: none;">
                                <i class="mdi mdi-delete"></i> Delete Selected
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table
                            class="table table-striped table-borderless dt-responsive nowrap" id="devices-table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="select-all-devices" class="form-check-input">
                                    </th>
                                    <th>Item Image</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Brand</th>
                                    <th>Model Number</th>
                                    <th>Serial Number</th>
                                    <th>Purchase Date</th>
                                    <th>Issue Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($job->devices as $device)
                                <tr class="align-middle device-row" data-device-id="{{ $device->id }}">
                                    <td>
                                        <input type="checkbox" class="form-check-input device-checkbox" value="{{ $device->id }}">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                @if($device->image)
                                                    {{-- Use public storage URL. device->image is stored relative to storage/app/public, e.g. "products/filename.png" --}}
                                                    <img src="{{ asset('storage/' . $device->image) }}" alt="{{ $device->product_name }}" width="100px" class="img-fluid d-block">
                                                @else
                                                    <img src="https://placehold.co/100x100?text=No+Image" alt="No Image" width="100px" class="img-fluid d-block">
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div>
                                            {{ $device->product_name ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $device->product_type ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $device->product_brand ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $device->model_no ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $device->serial_no ?? 'N/A' }}
                                    </td>
                                    <td>{{ $device->purchase_date ? $device->purchase_date->format('Y-m-d') : 'N/A' }}</td>
                                    <td>
                                        {{ $device->issue_type ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success">Approved</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger delete-device-btn" data-device-id="{{ $device->id }}">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center">No devices found</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>


                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Diagnosis Details
                            </h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush ">

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Earthing:
                                </span>
                                <span>
                                    <span class="badge bg-success-subtle text-success fw-semibold request-status">Done</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Power Test:
                                </span>
                                <span>
                                    <span class="badge bg-success-subtle text-success fw-semibold request-status">Done</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Display Output:
                                </span>
                                <span>
                                    <span class="badge bg-success-subtle text-success fw-semibold request-status">Done</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Keyboard / Mouse / Touchpad:
                                </span>
                                <span>
                                    <span class="badge bg-success-subtle text-success fw-semibold request-status">Done</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">USB / HDMI / LAN / Audio Ports:
                                </span>
                                <span>
                                    <span class="badge bg-warning-subtle text-warning fw-semibold request-status">Raised Issue</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Wi-Fi / Bluetooth:
                                </span>
                                <span>
                                    <span class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Overheating Symptoms:
                                </span>
                                <span>
                                    <span class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">RAM / HDD / SSD Health:
                                </span>
                                <span>
                                    <span class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Hinge or Body Damage:
                                </span>
                                <span>
                                    <span class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Battery / Charging:
                                </span>
                                <span>
                                    <span class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                </span>
                            </li>


                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Issue Details
                            </h5>
                            <div>
                                <span class="badge bg-danger-subtle text-danger fw-semibold">High</span>
                                <span class="badge bg-danger-subtle text-danger fw-semibold">Pending</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush ">
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Priority :
                                        </span>
                                        <span class="badge bg-danger-subtle text-danger fw-semibold">High</span>
                                    </li>
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Issue Type :
                                        </span>
                                        <span>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, ut?
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Issue Image :
                                        </span>
                                        <span>
                                            <button class="btn btn-sm btn-primary show-report">View</button>
                                            <div id="popupOverlay">
                                                <span class="closeBtn hide-report">&times;</span>
                                                <img id="popupImage" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRevxmRXifnbO19nrfkzha4QLipReqGMcM33g&s" alt="Popup Image">
                                            </div>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Status :
                                        </span>
                                        <span class="badge bg-danger-subtle text-danger fw-semibold">Pending</span>
                                    </li>
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Issue Description :
                                        </span>
                                        <span>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, ut?
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-4">

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Support Engineer
                            </h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div>
                            <select required="" name="engineer_id" id="engineer-select" class="form-select w-100">
                                <option value="" selected disabled>---- Select Engineer ----</option>
                                @foreach($engineers as $engineer)
                                    <option value="{{ $engineer->id }}">{{ $engineer->first_name }} {{ $engineer->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="text-end pb-3 hide-section">
                    <button type="button" class="btn btn-primary assign-eng-btn">
                        Assign
                    </button>
                </div>

                <div class="card @if(!$assignment) hide-selected-engineers-section @endif">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex  ">
                            <h5 class="card-title flex-grow-1 mb-0">Assigned Support Engineer</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break" id="assigned-engineer-name">
                                            @if($assignment)
                                                {{ $assignment->engineer->first_name }} {{ $assignment->engineer->last_name }}
                                            @endif
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card hide-report-section">

                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Engineer Report Details
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Before Service:
                                        </span>
                                        <span>
                                            <button class="btn btn-sm btn-primary show-report">View</button>
                                            <div id="popupOverlay">
                                                <span class="closeBtn hide-report">&times;</span>
                                                <img id="popupImage" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRevxmRXifnbO19nrfkzha4QLipReqGMcM33g&s" alt="Popup Image">
                                            </div>
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">After Service:
                                        </span>
                                        <span>
                                            <button class="btn btn-sm btn-primary show-report">View</button>
                                            <div id="popupOverlay">
                                                <span class="closeBtn hide-report">&times;</span>
                                                <img id="popupImage" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRevxmRXifnbO19nrfkzha4QLipReqGMcM33g&s" alt="Popup Image">
                                            </div>
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Service Report:
                                        </span>
                                        <span>
                                            <button class="btn btn-sm btn-primary show-report">View</button>
                                            <div id="popupOverlay">
                                                <span class="closeBtn hide-report">&times;</span>
                                                <img id="popupImage" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRevxmRXifnbO19nrfkzha4QLipReqGMcM33g&s" alt="Popup Image">
                                            </div>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-4">
                        <ul class="simple-timeline mb-0">
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-dot timeline-dot-purple"></span>
                                <div class="timeline-time mt-3">
                                    <div class="timeline-header-section mb-2">
                                        <h5 class="mb-0">Status Changed</h5>
                                        <small class="text-muted">25 min ago</small>
                                    </div>
                                    <p class="mb-2">
                                        Status has been changed pending to active.
                                    </p>
                                </div>
                            </li>

                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-dot timeline-dot-info"></span>
                                <div class="timeline-time mt-3">
                                    <div class="timeline-header-section mb-2">
                                        <h5 class="mb-0">Service Generated</h5>
                                        <small class="text-muted">6 days ago</small>
                                    </div>
                                    <p class="mb-2">
                                        A new service request has been generated by John Doe (engineer)
                                    </p>
                                </div>
                            </li>

                            <li>
                                <div class="timeline-time mt-3">
                                    <div class="timeline-header-section mb-2">
                                        <a href="#" class="mb-0 btn btn-sm btn-primary">View All History</a>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> <!-- content -->



<!-- Modal -->
<div class="modal fade" id="addVisitModal" tabindex="-1" aria-labelledby="addVisitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVisitModalLabel">Reschedule Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-2">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Engineer Location
                                </h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div>
                                <select required="" name="eng-location" id="eng-location" class="form-select w-100">
                                    <option value="0" selected disabled>---- Select Location ----</option>
                                    <option value="0">Mumbai</option>
                                    <option value="0">Delhi</option>
                                    <option value="0">Kolkata</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card hide-assign-eng-section" id="mySection">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex pb-3">
                                <h5 class="card-title flex-grow-1 mb-0">Assign Engineer</h5>
                            </div>
                            <div class="col-sm-10 d-flex gap-2">
                                <div class="form-check">
                                    <input class="form-check-input eng-assign" type="radio" name="gridRadios" id="individualRadio" value="individual" checked>
                                    <label class="form-check-label" for="individualRadio">
                                        Individual Engineer
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input eng-assign" type="radio" name="gridRadios" id="groupRadio" value="group">
                                    <label class="form-check-label" for="groupRadio">
                                        Group Engineer
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Individual Engineer Dropdown -->
                            <div id="individualDropdown">
                                <select required name="status" class="form-select w-100">
                                    <option value="" selected disabled>---- Select Individual Engineer ----</option>
                                    <option value="engineer1">Engineer 1</option>
                                    <option value="engineer2">Engineer 2</option>
                                    <option value="engineer3">Engineer 3</option>
                                </select>
                            </div>

                            <!-- Group Engineer Dropdown -->
                            <div id="groupDropdown" style="display: none;">
                                <select id="groupDropdown1" class="form-select w-100">
                                    <option value="" selected disabled>---- Select Group Engineer ----</option>
                                    <option value="group2">Engineer 1</option>
                                    <option value="group3">Engineer 2</option>
                                    <option value="group3">Engineer 3</option>
                                </select>
                                <!-- Button to display selected options -->
                                <button class="btn btn-primary mt-2 add-engineer">Add Engineer</button>

                                <!-- Table to display selected values with checkboxes -->
                                <table class="table mt-4" id="selectedTable">
                                    <thead>
                                        <tr>
                                            <th>Group Name</th>
                                            <th>Admin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Selected values will appear here -->
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- JavaScript -->
<script>
    $(document).ready(function() {
        $(".hide-section").hide();
        $(".hide-report-section").hide();
        $(".hide-assign-eng-section").hide();
        @if(!$assignment)
        $(".hide-selected-engineers-section").hide();
        @endif

        $("#engineer-select").on("change", function() {
            $(".hide-section").show();
        });

        $(".eng-assign").on("change", function() {
            $(".hide-assign-eng-section").show();
            $(".hide-section").show();
            $("#groupDropdown").fadeToggle();
            $("#individualDropdown").fadeToggle();
        });

        $(".assign-eng-btn").on("click", function() {
            var engineerId = $("#engineer-select").val();
            var jobId = {{ $job->id }};

            if (!engineerId) {
                alert('Please select an engineer');
                return;
            }

            // Send AJAX request to assign engineer
            $.ajax({
                url: '/crm/assign-job',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    job_id: jobId,
                    engineer_id: engineerId
                },
                success: function(response) {
                    if (response.success) {
                        $(".hide-section").hide();
                        $(".hide-assign-eng-section").hide();
                        $(".hide-selected-engineers-section").show();
                        $("#assigned-engineer-name").text(response.engineer_name);
                        $(".hide-report-section").show();
                        alert('Engineer assigned successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Error assigning engineer. Please try again.');
                }
            });
        });

        $(".show-report").on("click", function() {
            $("#popupOverlay").css("display", "flex");
        });

        $(".hide-report").on("click", function() {
            $("#popupOverlay").hide();
        });

        $(".add-engineer").on("click", function() {
            const $selectedOptions = $('#groupDropdown1 option:selected');
            const $tableBody = $('#selectedTable tbody');

            $selectedOptions.each(function() {
                const optionText = $(this).text();

                // Append row to table
                const newRow = `
                    <tr>
                        <td>${optionText}</td>
                        <td><input type="checkbox" class="form-check-input" /></td>
                    </tr>
                `;
                $tableBody.append(newRow);

                // Remove option from the select dropdown
                $(this).remove();
            });
        });

    });
</script>

<script>
    $(document).ready(function() {
        // Hide sections initially
        $(".hide-assign-eng-section2").hide();

        // Show on location change
        $("#eng-location2").on("change", function() {
            $(".hide-assign-eng-section2").show();
        });

        // Toggle individual/group
        $(".eng-assign2").on("change", function() {
            $("#groupDropdown2").fadeToggle();
            $("#individualDropdown2").fadeToggle();
        });

        // Add engineer to table
        $(".add-engineer2").on("click", function() {
            const $selectedOptions = $('#groupDropdownSelect2 option:selected');
            const $tableBody = $('#selectedTable2 tbody');

            $selectedOptions.each(function() {
                const optionText = $(this).text();
                const newRow = `
                <tr>
                    <td>${optionText}</td>
                    <td><input type="checkbox" class="form-check-input" /></td>
                </tr>
            `;
                $tableBody.append(newRow);
                $(this).remove();
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Select all devices checkbox
        $('#select-all-devices').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.device-checkbox').prop('checked', isChecked);
            toggleBulkDeleteButton();
        });

        // Individual device checkbox
        $('.device-checkbox').on('change', function() {
            const totalCheckboxes = $('.device-checkbox').length;
            const checkedCheckboxes = $('.device-checkbox:checked').length;

            $('#select-all-devices').prop('checked', totalCheckboxes === checkedCheckboxes);
            toggleBulkDeleteButton();
        });

        // Toggle bulk delete button visibility
        function toggleBulkDeleteButton() {
            const checkedCount = $('.device-checkbox:checked').length;
            if (checkedCount > 0) {
                $('#bulk-delete-devices-btn').show();
            } else {
                $('#bulk-delete-devices-btn').hide();
            }
        }

        // Delete single device
        $('.delete-device-btn').on('click', function() {
            const deviceId = $(this).data('device-id');

            if (confirm('Are you sure you want to delete this device?')) {
                $.ajax({
                    url: '/crm/delete-device/' + deviceId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Error deleting device. Please try again.');
                    }
                });
            }
        });

        // Bulk delete devices
        $('#bulk-delete-devices-btn').on('click', function() {
            const selectedDevices = [];
            $('.device-checkbox:checked').each(function() {
                selectedDevices.push($(this).val());
            });

            if (selectedDevices.length === 0) {
                alert('Please select at least one device to delete.');
                return;
            }

            if (confirm('Are you sure you want to delete ' + selectedDevices.length + ' device(s)?')) {
                $.ajax({
                    url: '/crm/bulk-delete-devices',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        device_ids: selectedDevices
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Error deleting devices. Please try again.');
                    }
                });
            }
        });
    });
</script>

@endsection