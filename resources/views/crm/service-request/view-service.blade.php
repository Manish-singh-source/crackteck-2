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

        <div class="row py-3">
            <div class="col-xl-8 mx-auto">

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
                                Address/Branch Details
                            </h5>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">


                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush ">
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Branch Name :
                                        </span>
                                        <span>
                                            KD
                                        </span>
                                    </li>


                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Address Line 2 :
                                        </span>
                                        <span>
                                            Sanjay Gandhi National Park, Borivali East,
                                        </span>
                                    </li>


                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">State :
                                        </span>
                                        <span>
                                            Maharashtra
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Pincode :
                                        </span>
                                        <span>
                                            400067
                                        </span>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush ">

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Address Line 1 :
                                        </span>
                                        <span>
                                            Sanjay Gandhi National Park, Borivali East,
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">City :
                                        </span>
                                        <span>
                                            Mumbai
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Country :
                                        </span>
                                        <span>
                                            India
                                        </span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title flex-grow-1 mb-0">
                                    Service History Details
                                </h5>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center gap-2">
                                <div>
                                    <span>
                                        Next Visit Date:
                                    </span>
                                    <span class="p-1 rounded bg-warning-subtle text-warning fw-semibold">2025-07-16</span>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addVisitModal2">Add Visit</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="addVisitModal2" tabindex="-1" aria-labelledby="addVisitModalLabel2" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="#">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addVisitModalLabel2">Reschedule Appointment</h5>
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
                                                                    <select required name="eng-location2" id="eng-location2" class="form-select w-100">
                                                                        <option value="0" selected disabled>---- Select Location ----</option>
                                                                        <option value="0">Mumbai</option>
                                                                        <option value="0">Delhi</option>
                                                                        <option value="0">Kolkata</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="card hide-assign-eng-section2" id="mySection2">
                                                            <div class="card-header border-bottom-dashed">
                                                                <div class="d-flex pb-3">
                                                                    <h5 class="card-title flex-grow-1 mb-0">Assign Engineer</h5>
                                                                </div>
                                                                <div class="col-sm-10 d-flex gap-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input eng-assign2" type="radio" name="gridRadios2" id="individualRadio2" value="individual" checked>
                                                                        <label class="form-check-label" for="individualRadio2">
                                                                            Individual Engineer
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input eng-assign2" type="radio" name="gridRadios2" id="groupRadio2" value="group">
                                                                        <label class="form-check-label" for="groupRadio2">
                                                                            Group Engineer
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="card-body">
                                                                <!-- Individual Engineer Dropdown -->
                                                                <div id="individualDropdown2">
                                                                    <select required name="status2" class="form-select w-100">
                                                                        <option value="" selected disabled>---- Select Individual Engineer ----</option>
                                                                        <option value="engineer1">Engineer 1</option>
                                                                        <option value="engineer2">Engineer 2</option>
                                                                        <option value="engineer3">Engineer 3</option>
                                                                    </select>
                                                                </div>

                                                                <!-- Group Engineer Dropdown -->
                                                                <div id="groupDropdown2" style="display: none;">
                                                                    <select id="groupDropdownSelect2" class="form-select w-100">
                                                                        <option value="" selected disabled>---- Select Group Engineer ----</option>
                                                                        <option value="group1">Engineer 1</option>
                                                                        <option value="group2">Engineer 2</option>
                                                                        <option value="group3">Engineer 3</option>
                                                                    </select>

                                                                    <!-- Button to display selected options -->
                                                                    <button class="btn btn-primary mt-2 add-engineer2">Add Engineer</button>

                                                                    <!-- Table to display selected values with checkboxes -->
                                                                    <table class="table mt-4" id="selectedTable2">
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

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table
                            class="table table-striped table-borderless dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Engineer Name</th>
                                    <th>Visit Date</th>
                                    <th>Issue Type</th>
                                    <th>Report</th>
                                    <th>Status</th>
                                    <th>Action </th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="align-middle">
                                    <td>
                                        1
                                    </td>
                                    <td>
                                        Chris Doe
                                    </td>
                                    <td>2025-07-16 12:09 PM</td>
                                    <td>
                                        Maintanance
                                    </td>
                                    <td>
                                        NA
                                    </td>
                                    <td>
                                        <span class="badge bg-warning-subtle text-warning fw-semibold">Upcoming</span>
                                    </td>
                                    <td>
                                        <!-- Re-Scheduled Button -->
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#rescheduleModal">
                                            Re-Scheduled
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="#">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="rescheduleModalLabel">Reschedule Appointment</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body p-2">
                                                            <p>Please enter new schedule date:</p>
                                                            <input type="date" id="newSchedule" class="form-control" placeholder="Enter new date/time">
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-success">Submit</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>


                                    </td>
                                </tr>

                                <tr class="align-middle">
                                    <td>
                                        2
                                    </td>
                                    <td>
                                        John Doe
                                    </td>
                                    <td>2025-04-04 06:09 PM</td>
                                    <td>
                                        Maintanance
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="./view-detailed-service-history.php">View Report</a>
                                        <!-- <div id="popupOverlay">
                                            <span class="closeBtn hide-report">&times;</span>
                                            <img id="popupImage" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRevxmRXifnbO19nrfkzha4QLipReqGMcM33g&s" alt="Popup Image">
                                        </div> -->
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary disabled">Re-Scheduled</button>

                                    </td>
                                </tr>

                            </tbody>
                        </table>

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
                                        <span class="fw-semibold text-break">Total Visits :
                                        </span>
                                        <span>
                                            5 Per Year
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
                                    <th>Modal Number</th>
                                    <th>Product Serial Number</th>
                                    <th>Crackteck Serial Number</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="https://placehold.co/80x80" alt="Headphone" width="100px" class="img-fluid d-block">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            ZKTeco MB20 Biometric Attendance Device
                                        </div>
                                    </td>
                                    <td>
                                        Biometric
                                    </td>
                                    <td>
                                        Inspiron 3511
                                    </td>
                                    <td>B0BB7FQBBS</td>
                                    <td>
                                        B0BB7FQBBS
                                    </td>
                                </tr>

                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="https://placehold.co/80x80" alt="Headphone" width="100px" class="img-fluid d-block">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            ZKTeco MB20 Biometric Attendance Device
                                        </div>
                                    </td>
                                    <td>
                                        Biometric
                                    </td>
                                    <td>
                                        Inspiron 3511
                                    </td>
                                    <td>B0BB7FQBBS</td>
                                    <td>
                                        B0BB7FQBBQ
                                    </td>
                                </tr>

                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="https://placehold.co/80x80" alt="Headphone" width="100px" class="img-fluid d-block">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            ZKTeco MB20 Biometric Attendance Device
                                        </div>
                                    </td>
                                    <td>
                                        Biometric
                                    </td>
                                    <td>
                                        Inspiron 3511
                                    </td>
                                    <td>B0BB7FQBBS</td>
                                    <td>
                                        B0BB7FQBBR
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


            <div class="col-xl-4">

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

@endsection