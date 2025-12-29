@extends('crm/layouts/master')

@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row pt-3">
            <div class="col-xl-8 mx-auto">

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Customer Details
                            </h5>
                            <div class="fw-bold text-dark">
                                {{ $quotation->quote_id }}
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
                                            {{ $quotation->lead->first_name }} {{ $quotation->lead->last_name }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Contact no :
                                        </span>
                                        <span>
                                            {{ $quotation->lead->phone }}
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
                                            {{ $quotation->lead->email }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Company Name :
                                        </span>
                                        <span>
                                            {{ $quotation->lead->company_name ?? 'N/A' }}
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
                        @if($quotation->lead->branches && $quotation->lead->branches->count() > 0)
                            @foreach($quotation->lead->branches as $branch)
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush ">
                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Branch Name :
                                            </span>
                                            <span>
                                                {{ $branch->branch_name ?? 'N/A' }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Address Line 2 :
                                            </span>
                                            <span>
                                                {{ $branch->address_line2 ?? 'N/A' }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">State :
                                            </span>
                                            <span>
                                                {{ $branch->state ?? 'N/A' }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Pincode :
                                            </span>
                                            <span>
                                                {{ $branch->pincode ?? 'N/A' }}
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
                                                {{ $branch->address_line1 ?? 'N/A' }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">City :
                                            </span>
                                            <span>
                                                {{ $branch->city ?? 'N/A' }}
                                            </span>
                                        </li>

                                        <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Country :
                                            </span>
                                            <span>
                                                {{ $branch->country ?? 'N/A' }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr>
                            @endif
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-12">
                                    <p class="text-muted">No branch details available.</p>
                                </div>
                            </div>
                        @endif
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
                        @if($quotation->amcDetail && $quotation->amcDetail->amcPlan)
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Plan Name:
                                        </span>
                                        <span>
                                            {{ $quotation->amcDetail->amcPlan->plan_name ?? 'N/A' }}
                                        </span>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Duration (Months) :
                                        </span>
                                        <span>
                                            {{ $quotation->amcDetail->plan_duration ?? 'N/A' }}
                                        </span>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Start From :
                                        </span>
                                        <span>
                                            {{ $quotation->amcDetail->plan_start_date ? \Carbon\Carbon::parse($quotation->amcDetail->plan_start_date)->format('Y-m-d h:i A') : 'N/A' }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Total Visits :
                                        </span>
                                        <span>
                                            {{ $quotation->amcDetail->amcPlan->total_visits ?? 'N/A' }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Priority Level :
                                        </span>
                                        <span>
                                            {{ $quotation->amcDetail->priority_level ?? 'N/A' }}
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
                                            {{ $quotation->amcDetail->amcPlan->plan_type ?? 'N/A' }}
                                        </span>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Description :
                                        </span>
                                        <span>
                                            {{ $quotation->amcDetail->amcPlan->description ?? 'N/A' }}
                                        </span>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">End From :
                                        </span>
                                        <span>
                                            {{ $quotation->amcDetail->plan_end_date ? \Carbon\Carbon::parse($quotation->amcDetail->plan_end_date)->format('Y-m-d h:i A') : 'N/A' }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Total Amount :
                                        </span>
                                        <span>
                                            ₹{{ number_format($quotation->amcDetail->total_amount ?? 0, 2) }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Additional Notes :
                                        </span>
                                        <span>
                                            {{ $quotation->amcDetail->additional_notes ?? 'N/A' }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-12">
                                <p class="text-muted">No AMC details available.</p>
                            </div>
                        </div>
                        @endif

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
                        <table class="table table-striped table-borderless dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>HSN Code</th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Tax (%)</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($quotation->products && $quotation->products->count() > 0)
                                    @foreach($quotation->products as $product)
                                    <tr class="align-middle">
                                        <td>
                                            <div>
                                                {{ $product->product_name }}
                                            </div>
                                        </td>
                                        <td>
                                            {{ $product->hsn_code ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $product->sku ?? 'N/A' }}
                                        </td>
                                        <td>
                                            ₹{{ number_format($product->price, 2) }}
                                        </td>
                                        <td>
                                            {{ $product->quantity }}
                                        </td>
                                        <td>
                                            {{ $product->tax }}%
                                        </td>
                                        <td>
                                            ₹{{ number_format($product->total, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No products available.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
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
                                                                    <select required="" name="eng-location2" id="eng-location2" class="form-select w-100">
                                                                        <option value="0" selected="" disabled="">---- Select Location ----</option>
                                                                        <option value="0">Mumbai</option>
                                                                        <option value="0">Delhi</option>
                                                                        <option value="0">Kolkata</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="card hide-assign-eng-section2" id="mySection2" style="display: none;">
                                                            <div class="card-header border-bottom-dashed">
                                                                <div class="d-flex pb-3">
                                                                    <h5 class="card-title flex-grow-1 mb-0">Assign Engineer</h5>
                                                                </div>
                                                                <div class="col-sm-10 d-flex gap-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input eng-assign2" type="radio" name="gridRadios2" id="individualRadio2" value="individual" checked="">
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
                                                                    <select required="" name="status2" class="form-select w-100">
                                                                        <option value="" selected="" disabled="">---- Select Individual Engineer ----</option>
                                                                        <option value="engineer1">Engineer 1</option>
                                                                        <option value="engineer2">Engineer 2</option>
                                                                        <option value="engineer3">Engineer 3</option>
                                                                    </select>
                                                                </div>

                                                                <!-- Group Engineer Dropdown -->
                                                                <div id="groupDropdown2" style="display: none;">
                                                                    <select id="groupDropdownSelect2" class="form-select w-100">
                                                                        <option value="" selected="" disabled="">---- Select Group Engineer ----</option>
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
                        <table class="table table-striped table-borderless dt-responsive nowrap">
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

            </div>

            <div class="col-xl-4">

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <!-- Assign Engineer Card -->
                <div class="card mt-3">
                    <div class="card-header border-bottom-dashed">
                        <h5 class="card-title mb-0">Assign Engineer</h5>
                    </div>
                    <div class="card-body">
                        <form id="assignEngineerForm">
                            @csrf
                            <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Assignment Type</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="assignment_type" id="typeIndividual" value="Individual" checked>
                                        <label class="form-check-label" for="typeIndividual">Individual</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="assignment_type" id="typeGroup" value="Group">
                                        <label class="form-check-label" for="typeGroup">Group</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Individual Assignment -->
                            <div id="individualSection">
                                <div class="mb-3">
                                    <label for="engineer_id" class="form-label">Select Engineer</label>
                                    <select name="engineer_id" id="engineer_id" class="form-select">
                                        <option value="">--Select Engineer--</option>
                                        @foreach($engineers as $engineer)
                                            <option value="{{ $engineer->id }}">
                                                {{ $engineer->first_name }} {{ $engineer->last_name }} - {{ $engineer->designation }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Group Assignment -->
                            <div id="groupSection" style="display: none;">
                                <div class="mb-3">
                                    <label for="group_name" class="form-label">Group Name</label>
                                    <input type="text" name="group_name" id="group_name" class="form-control" placeholder="Enter Group Name">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Select Engineers</label>
                                    <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                        @foreach($engineers as $engineer)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input engineer-checkbox" type="checkbox" name="engineer_ids[]" value="{{ $engineer->id }}" id="eng_{{ $engineer->id }}">
                                            <label class="form-check-label" for="eng_{{ $engineer->id }}">
                                                {{ $engineer->first_name }} {{ $engineer->last_name }} - {{ $engineer->designation }}
                                            </label>
                                            <input class="form-check-input ms-3" type="radio" name="supervisor_id" value="{{ $engineer->id }}" id="sup_{{ $engineer->id }}">
                                            <label class="form-check-label small text-muted" for="sup_{{ $engineer->id }}">
                                                (Supervisor)
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <small class="text-muted">Check engineers to add to group, select one as supervisor</small>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-account-plus"></i> Assign Engineer
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Assigned Engineers Display -->
                @if($quotation->activeAssignment)
                <div class="card mt-3" id="assignedEngineersCard">
                    <div class="card-header border-bottom-dashed bg-light">
                        <h5 class="card-title mb-0">Assigned Engineers</h5>
                    </div>
                    <div class="card-body">
                        @if($quotation->activeAssignment->assignment_type === 'Individual')
                            <!-- Individual Engineer Card -->
                            <div class="border rounded p-3 bg-success-subtle">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold">
                                            {{ $quotation->activeAssignment->engineer->first_name }} {{ $quotation->activeAssignment->engineer->last_name }}
                                        </h6>
                                        <p class="mb-1 text-muted small">
                                            <i class="mdi mdi-briefcase"></i> {{ $quotation->activeAssignment->engineer->designation }}
                                        </p>
                                        <p class="mb-1 text-muted small">
                                            <i class="mdi mdi-office-building"></i> {{ $quotation->activeAssignment->engineer->department }}
                                        </p>
                                        <p class="mb-0 text-muted small">
                                            <i class="mdi mdi-phone"></i> {{ $quotation->activeAssignment->engineer->phone }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="badge bg-success">Individual Assignment</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Group Assignment Card -->
                            <div class="border rounded p-3 bg-info-subtle">
                                <h6 class="mb-3 fw-bold">
                                    <i class="mdi mdi-account-group"></i> Group: {{ $quotation->activeAssignment->group_name }}
                                    <span class="badge bg-info ms-2">{{ $quotation->activeAssignment->groupEngineers->count() }} Engineers</span>
                                </h6>

                                <div class="row">
                                    @foreach($quotation->activeAssignment->groupEngineers as $groupEngineer)
                                    <div class="col-md-6 mb-3">
                                        <div class="border rounded p-2 {{ $groupEngineer->pivot->is_supervisor ? 'bg-warning-subtle' : 'bg-white' }}">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-semibold">
                                                        {{ $groupEngineer->first_name }} {{ $groupEngineer->last_name }}
                                                        @if($groupEngineer->pivot->is_supervisor)
                                                            <span class="supervisor-badge">SUPERVISOR</span>
                                                        @endif
                                                    </h6>
                                                    <p class="mb-0 text-muted small">
                                                        <i class="mdi mdi-briefcase"></i> {{ $groupEngineer->designation }} |
                                                        <i class="mdi mdi-phone"></i> {{ $groupEngineer->phone }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mt-3 text-muted small">
                            <i class="mdi mdi-clock-outline"></i> Assigned on: {{ $quotation->activeAssignment->assigned_at->format('d M Y, h:i A') }}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="card mt-3">
                    <div class="card-body text-center">
                        <a href="{{ route('service-request.edit-amc', $quotation->id) }}" class="btn btn-warning">
                            <i class="mdi mdi-pencil"></i> Edit AMC Request
                        </a>
                        <a href="{{ route('service-request.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Toggle between Individual and Group sections
        $('input[name="assignment_type"]').change(function() {
            if ($(this).val() === 'Individual') {
                $('#individualSection').show();
                $('#groupSection').hide();
                // Clear group fields
                $('#group_name').val('');
                $('.engineer-checkbox').prop('checked', false);
                $('input[name="supervisor_id"]').prop('checked', false);
            } else {
                $('#individualSection').hide();
                $('#groupSection').show();
                // Clear individual field
                $('#engineer_id').val('');
            }
        });

        // Sync checkbox with supervisor radio
        $('.engineer-checkbox').change(function() {
            const engineerId = $(this).val();
            const supervisorRadio = $('input[name="supervisor_id"][value="' + engineerId + '"]');

            if (!$(this).is(':checked')) {
                // If unchecked, also uncheck supervisor radio
                supervisorRadio.prop('checked', false);
            }
        });

        // Ensure supervisor is also checked as engineer
        $('input[name="supervisor_id"]').change(function() {
            const engineerId = $(this).val();
            const engineerCheckbox = $('.engineer-checkbox[value="' + engineerId + '"]');

            if (!engineerCheckbox.is(':checked')) {
                engineerCheckbox.prop('checked', true);
            }
        });

        // Form submission
        $('#assignEngineerForm').submit(function(e) {
            e.preventDefault();

            const assignmentType = $('input[name="assignment_type"]:checked').val();

            // Validation
            if (assignmentType === 'Individual') {
                if (!$('#engineer_id').val()) {
                    alert('Please select an engineer');
                    return;
                }
            } else if (assignmentType === 'Group') {
                if (!$('#group_name').val()) {
                    alert('Please enter group name');
                    return;
                }

                const checkedEngineers = $('.engineer-checkbox:checked').length;
                if (checkedEngineers === 0) {
                    alert('Please select at least one engineer');
                    return;
                }

                if (!$('input[name="supervisor_id"]:checked').val()) {
                    alert('Please select a supervisor');
                    return;
                }
            }

            // Submit via AJAX
            const formData = $(this).serialize();

            $.ajax({
                url: '{{ route("quotation.assign-engineer") }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'Error assigning engineer. Please try again.';
                    alert(error);
                }
            });
        });
    });
</script>
@endsection
