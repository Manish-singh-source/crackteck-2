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
                                Transfer Request
                            </h5>
                            <div class="action-buttons">
                                <!-- <a href="#" id="approve-request" class="mb-0 btn btn-sm btn-success">Approve</a> -->
                                <!-- <a href="#" id="reject-request" class="mb-0 btn btn-sm btn-danger">Reject</a> -->
                                <button type="button" class="mb-0 btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#standard-modal">
                                    Approve
                                </button>
                                <button type="button" class="mb-0 btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#standard-modal">
                                    Reject
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="standard-modal" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="standard-modalLabel">Request</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body px-3 py-md-2">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label" for="flexRadioDefault1">
                                                Approve Reason
                                            </label>
                                            <input class="form-control" type="text" name="flexRadioDefault" id="flexRadioDefault1">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="approve-request">Approve</button>
                                    <button type="button" class="btn btn-danger" id="reject-request">Reject</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-body">
                        <ul class="list-group list-group-flush ">

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Current Engineer :
                                </span>
                                <span>
                                    Shyam Jaiswal
                                </span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Request Transfer Status:
                                </span>
                                <span>
                                    <span class="badge bg-danger-subtle text-danger request-status fw-semibold">Pending</span>
                                </span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Transfer Reason:
                                </span>
                                <span>
                                    Not able to solve at this point.
                                </span>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Customer Details
                            </h5>
                            <div class="fw-bold text-dark">
                                #1001
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">


                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush ">

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Customer Name :
                                        </span>
                                        <span>
                                            Shyam Jaiswal
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Contact no :
                                        </span>
                                        <span>
                                            9004086582
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Feedback :
                                        </span>
                                        <span>
                                            Need a AMC Service for my PC
                                        </span>
                                    </li>
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Company Name :
                                        </span>
                                        <span>
                                            Technofra
                                        </span>
                                    </li>
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">GST No :
                                        </span>
                                        <span>
                                            988498
                                        </span>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush ">

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Email :
                                        </span>
                                        <span>
                                            shyam@gmail.com
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Address :
                                        </span>
                                        <span>
                                            Lalji Pada , Kandivali West, Mumbai, Maharashtra 400067
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Customer Type :
                                        </span>
                                        <span>
                                            Retailer
                                        </span>
                                    </li>
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Company Address :
                                        </span>
                                        <span>
                                            Lalji Pada , Maharashtra 400067
                                        </span>
                                    </li>
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">PAN No :
                                        </span>
                                        <span>
                                            789MTUO
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Service Details
                            </h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">
                                            Service Id :
                                        </span>
                                        <span>
                                            <span class="fw-bold text-dark">#1001</span><br>
                                        </span>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Date :
                                        </span>
                                        <span>
                                            <div>2 weeks ago</div>
                                            <div>2025-04-04 06:09 PM</div>
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Images :

                                        </span>
                                        <span>
                                            <a class="btn btn-sm btn-primary" href="#">View</a>
                                        </span>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">
                                            Priority Level :
                                        </span>
                                        <span>
                                            <span class="fw-bold text-dark">High</span><br>
                                        </span>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Issue Type :
                                        </span>
                                        <span>
                                            <div>Server level</div>
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Issue Description :

                                        </span>
                                        <div>satuap all cctv carma in my office</div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Status :

                                        </span>
                                        <span class="badge bg-danger-subtle text-danger fw-semibold">Pending</span>
                                    </li>

                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                AMC Details
                            </h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Plan Name:
                                        </span>
                                        <span>
                                            Software Updates
                                        </span>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Duration (Months) :
                                        </span>
                                        <span>
                                            12
                                        </span>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Start From :
                                        </span>
                                        <span>
                                            2025-04-04 06:09 PM
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Total Vistor :
                                        </span>
                                        <span>
                                            50
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Plan Type :
                                        </span>
                                        <span>
                                            Standard
                                        </span>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Description :
                                        </span>
                                        <span>
                                            AMC Service for 1 year
                                        </span>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">End From :
                                        </span>
                                        <span>
                                            2025-04-04 06:09 PM
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>


                </div>
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Product Details
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <table
                            class="table table-striped table-borderless dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Brand</th>
                                    <th>Modal Number</th>
                                    <th>Serial Number</th>
                                    <th>Purchase Date</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="https://placehold.co/100x100" alt="Headphone" width="100px" class="img-fluid d-block">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            Headphone
                                        </div>
                                    </td>
                                    <td>
                                        Computer
                                    </td>
                                    <td>
                                        Sony
                                    </td>
                                    <td>
                                        Inspiron 3511
                                    </td>
                                    <td>
                                        B0BB7FQBBS
                                    </td>
                                    <td>2025-04-04 06:09 PM</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>



            <div class="col-xl-4">

                <div class="card engineer-details">
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
                                        <th>Supervisor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Selected values will appear here -->
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="text-end pb-3 hide-section">
                    <button href="#" class="btn btn-primary assign-eng-btn">
                        Assign
                    </button>
                </div>

                <div class="card hide-selected-engineers-section">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex  ">
                            <h5 class="card-title flex-grow-1 mb-0">Assigned Engineer List</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Engineer 1:
                                        </span>
                                        <span>
                                            Supervisor
                                        </span>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Engineer 2 :
                                        </span>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Engineer 3 :
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
</div>
<script>
    $(document).ready(function() {

        $("#approve-request").on('click', function() {
            $(".action-buttons").hide();
            $("#standard-modal").modal('hide');
            $(".request-status").html("Approved");
            $(".request-status").removeClass("bg-danger-subtle text-danger");
            $(".request-status").addClass("bg-success-subtle text-success");
            $(".engineer-details").show();
        });

        $("#reject-request").on('click', function() {
            $(".action-buttons").hide();
            $("#standard-modal").modal('hide');
            $(".request-status").html("Rejected");
            $(".request-status").removeClass("bg-success-subtle text-success");
            $(".request-status").addClass("bg-danger-subtle text-danger");
        });

        $(".engineer-details").hide();
        $(".hide-section").hide();
        $(".hide-report-section").hide();
        $(".hide-assign-eng-section").hide();
        $(".hide-selected-engineers-section").hide();

        $("#eng-location").on("change", function() {
            $(".hide-assign-eng-section").show();
            $(".hide-section").show();
        });

        $(".eng-assign").on("change", function() {
            $(".hide-assign-eng-section").show();
            $(".hide-section").show();
            $("#groupDropdown").fadeToggle();
            $("#individualDropdown").fadeToggle();
        });

        $(".assign-eng-btn").on("click", function() {
            $(".hide-section").hide();
            $(".hide-assign-eng-section").hide();
            $(".hide-selected-engineers-section").show();
            $(".hide-report-section").show();

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

@endsection