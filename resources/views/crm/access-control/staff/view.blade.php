@extends('crm/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="pt-2">
                <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">{{ ucwords(str_replace('_', ' ', $staff->staff_role)) }} Details
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-first">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="overflow-hidden ms-md-4 ms-0">
                                            <h4 class="m-0 text-dark fs-20 mt-2 mt-md-0">{{ ucwords($staff->first_name) }}
                                                {{ ucwords($staff->last_name) }}</h4>
                                            <!-- <div class="mb-0 text-dark fs-15">John Doe</div> -->
                                            <p class="my-1 text-muted fs-16">{{ $staff->designation }}</p>
                                            <span class="fs-15">KYC Status: <span
                                                    class="badge bg-success-subtle text-success px-2 py-1 fs-13 fw-normal">Verified</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-first">

                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="p-2 border border-primary border-opacity-10 bg-primary-subtle rounded-2 me-2">
                                            <div class="bg-primary rounded-circle widget-size text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24">
                                                    <path fill="#ffffff"
                                                        d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Total Tasks</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="mb-0 fs-22 text-dark me-3">54</h3>
                                        <div class="text-center">
                                            <a href="{{ route('engineers.task') }}" class="btn btn-primary btn-sm">View</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-first">

                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="p-2 border border-secondary border-opacity-10 bg-secondary-subtle rounded-2 me-2">
                                            <div class="bg-secondary rounded-circle widget-size text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24">
                                                    <path fill="#ffffff"
                                                        d="m10 17l-5-5l1.41-1.42L10 14.17l7.59-7.59L19 8m-7-6A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Tasks Completed</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="mb-0 fs-22 text-dark me-3">9</h3>
                                        <div class="text-center">
                                            <a href="{{ route('engineers.task') }}" class="btn btn-primary btn-sm">View</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-first">

                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="p-2 border border-danger border-opacity-10 bg-danger-subtle rounded-2 me-2">
                                            <div class="bg-danger rounded-circle widget-size text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24">
                                                    <path fill="#ffffff"
                                                        d="M22 19H2v2h20zM4 15c0 .5.2 1 .6 1.4s.9.6 1.4.6V6c-.5 0-1 .2-1.4.6S4 7.5 4 8zm9.5-9h-3c0-.4.1-.8.4-1.1s.6-.4 1.1-.4c.4 0 .8.1 1.1.4c.2.3.4.7.4 1.1M7 6v11h10V6h-2q0-1.2-.9-2.1C13.2 3 12.8 3 12 3q-1.2 0-2.1.9T9 6zm11 11c.5 0 1-.2 1.4-.6s.6-.9.6-1.4V8c0-.5-.2-1-.6-1.4S18.5 6 18 6z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Tasks Pending</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="mb-0 fs-22 text-dark me-3">33</h3>
                                        <div class="text-center">
                                            <a href="{{ route('engineers.task') }}" class="btn btn-primary btn-sm">View</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-first">

                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="p-2 border border-warning border-opacity-10 bg-warning-subtle rounded-2 me-2">
                                            <div class="bg-warning rounded-circle widget-size text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24">
                                                    <path fill="#ffffff"
                                                        d="M7 15h2c0 1.08 1.37 2 3 2s3-.92 3-2c0-1.1-1.04-1.5-3.24-2.03C9.64 12.44 7 11.78 7 9c0-1.79 1.47-3.31 3.5-3.82V3h3v2.18C15.53 5.69 17 7.21 17 9h-2c0-1.08-1.37-2-3-2s-3 .92-3 2c0 1.1 1.04 1.5 3.24 2.03C14.36 11.56 17 12.22 17 15c0 1.79-1.47 3.31-3.5 3.82V21h-3v-2.18C8.47 18.31 7 16.79 7 15">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Tasks In Progress</p>
                                    </div>


                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="mb-0 fs-22 text-dark me-3">12</h3>

                                        <div class="text-muted">
                                            <a href="{{ route('engineers.task') }}" class="btn btn-primary btn-sm">View</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-first">

                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="p-2 border border-warning border-opacity-10 bg-warning-subtle rounded-2 me-2">
                                            <div class="bg-warning rounded-circle widget-size text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24">
                                                    <path fill="#ffffff"
                                                        d="M7 15h2c0 1.08 1.37 2 3 2s3-.92 3-2c0-1.1-1.04-1.5-3.24-2.03C9.64 12.44 7 11.78 7 9c0-1.79 1.47-3.31 3.5-3.82V3h3v2.18C15.53 5.69 17 7.21 17 9h-2c0-1.08-1.37-2-3-2s-3 .92-3 2c0 1.1 1.04 1.5 3.24 2.03C14.36 11.56 17 12.22 17 15c0 1.79-1.47 3.31-3.5 3.82V21h-3v-2.18C8.47 18.31 7 16.79 7 15">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Balance Amount</p>
                                    </div>


                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="mb-0 fs-22 text-dark me-3">₹4500</h3>

                                        <div class="text-muted">
                                            <a href="{{ route('engineers.task') }}"
                                                class="btn btn-primary btn-sm">View</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body pt-0">
                                <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active p-2" id="profile_about_tab" data-bs-toggle="tab"
                                            href="#profile_about" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                            <span class="d-none d-sm-block">Personal Information</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link p-2" id="profile_experience_tab" data-bs-toggle="tab"
                                            href="#profile_experience" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-sitemap-outline"></i></span>
                                            <span class="d-none d-sm-block">Professional</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link p-2" id="portfolio_education_tab" data-bs-toggle="tab"
                                            href="#profile_education" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-school"></i></span>
                                            <span class="d-none d-sm-block">Employment History</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link p-2" id="logsdetiles_tab" data-bs-toggle="tab"
                                            href="#logsdetiles" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-school"></i></span>
                                            <span class="d-none d-sm-block">Login Logs</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link p-2" id="taskdetails_tab" data-bs-toggle="tab"
                                            href="#taskdetails" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-school"></i></span>
                                            <span class="d-none d-sm-block">Task Details</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link p-2" id="stockinhand_tab" data-bs-toggle="tab"
                                            href="#stockinhand" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-school"></i></span>
                                            <span class="d-none d-sm-block">Stock In Hand</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content text-muted">
                                    <div class="tab-pane active show pt-4" id="profile_about" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-md-12 mb-4">

                                                <div class="card shadow-none p-lg-3">
                                                    <div class="border-bottom-dashed">
                                                        <div class="d-flex">
                                                            <h5 class="card-title flex-grow-1 mb-0">
                                                                Personal Information
                                                            </h5>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <ul class="list-group list-group-flush">

                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">
                                                                    Full Name :
                                                                </span>
                                                                <span>
                                                                    <span>{{ $staff->first_name }}
                                                                        {{ $staff->last_name }}</span><br>
                                                                </span>
                                                            </li>

                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">Contact No. :
                                                                </span>
                                                                <span>
                                                                    <div>{{ $staff->phone }} </div>
                                                                </span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">E-mail :
                                                                </span>
                                                                <span>
                                                                    <div>{{ $staff->email }}</div>
                                                                </span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">Address :
                                                                </span>
                                                                <span>
                                                                    <div class="text-end">
                                                                        {{ $staff->address->address1 ?? '' }}</div>
                                                                    <div class="text-end">
                                                                        {{ $staff->address->address2 ?? '' }}</div>
                                                                </span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">Status :</span>
                                                                <span>
                                                                    {{ ucwords($staff->status) }}
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane pt-4" id="profile_experience" role="tabpanel">
                                        <div class="row">

                                            <div class="col-md-12 col-sm-12 col-md-12 mb-4">

                                                <div class="card shadow-none p-lg-3">
                                                    <div class="border-bottom-dashed">
                                                        <div class="d-flex">
                                                            <h5 class="card-title flex-grow-1 mb-0">
                                                                Professional Information
                                                            </h5>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <ul class="list-group list-group-flush">

                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">
                                                                    Job Title :
                                                                </span>
                                                                <span>
                                                                    <span
                                                                        class="fw-bold text-dark">{{ $staff->designation }}</span><br>
                                                                </span>
                                                            </li>

                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">Department :
                                                                </span>
                                                                <span>
                                                                    <div>AMC Support Team</div>
                                                                </span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">Employee Type :

                                                                </span>
                                                                <span>{{ ucwords(str_replace('_', ' ', $staff->employment_type)) }}</span>
                                                            </li>

                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">Date of Joining :
                                                                </span>
                                                                <span>{{ Carbon\Carbon::parse($staff->joining_date)->format('d M Y') }}</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-12 col-sm-12 col-md-12 mb-4">

                                                <div class="card shadow-none p-lg-3">
                                                    <div class="border-bottom-dashed">
                                                        <div class="d-flex">
                                                            <h5 class="card-title flex-grow-1 mb-0">
                                                                Skills and Certificates
                                                            </h5>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <ul class="list-group list-group-flush">

                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">
                                                                    Technical Skills :
                                                                </span>
                                                                <span>
                                                                    {{ $staff->workSkills->primary_skills ?? 'N/A' }}
                                                                </span>
                                                            </li>

                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">Certifications :
                                                                </span>
                                                                <span>
                                                                    <div>
                                                                        {{ $staff->workSkills->certificates ?? 'N/A' }}
                                                                    </div>
                                                                </span>
                                                            </li>

                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">Experience :
                                                                </span>
                                                                <span>
                                                                    <div>{{ $staff->workSkills->experience ?? 'N/A' }} Years</div>
                                                                </span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">Languages Known :
                                                                </span>
                                                                <span>
                                                                    <div>
                                                                        {{ $staff->workSkills->languages_known ?? 'N/A' }}
                                                                    </div>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane pt-4" id="profile_education" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-md-12 mb-4">

                                                <div class="card shadow-none p-lg-3">
                                                    <div class="border-bottom-dashed">
                                                        <div class="d-flex">
                                                            <h5 class="card-title flex-grow-1 mb-0">
                                                                Employment History
                                                            </h5>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <ul class="list-group list-group-flush">

                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">
                                                                    Previous Company :
                                                                </span>
                                                                <span>
                                                                    <span class="fw-bold text-dark">Hardware
                                                                        Maintenance</span><br>
                                                                </span>
                                                            </li>

                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">Duration of Employment
                                                                    :
                                                                </span>
                                                                <span>
                                                                    <div>CompTIA A+</div>
                                                                </span>
                                                            </li>

                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">Job Title :
                                                                </span>
                                                                <span>
                                                                    <div>5 Years</div>
                                                                </span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">Responsibilities :
                                                                </span>
                                                                <span>
                                                                    <div>English, Hindi, Marathi</div>
                                                                </span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                                <span class="fw-semibold text-break">Reason for Leaving :
                                                                </span>
                                                                <span>
                                                                    <div>NA</div>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane pt-4" id="logsdetiles" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-md-12 mb-4">

                                                <div class="card shadow-none p-lg-3">


                                                    <div class="tab-content text-muted">
                                                        <div class="tab-pane active show pt-4" id="all_customer"
                                                            role="tabpanel">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card shadow-none">
                                                                        <div class="card-body">
                                                                            <table id="responsive-datatable"
                                                                                class="table table-striped table-borderless dt-responsive nowrap">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Date</th>
                                                                                        <th>Login Time</th>
                                                                                        <th>Logout Time</th>
                                                                                        <th>Total Hours</th>
                                                                                        <th>Remarks</th>
                                                                                        <th>Status</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div>
                                                                                                2 weeks ago
                                                                                            </div>
                                                                                            <div>
                                                                                                2025-04-04 06:09 PM
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>09:15 AM</td>

                                                                                        <td>06:00 PM</td>
                                                                                        <td>8.75</td>


                                                                                        <td>Late login by 15 mins</td>
                                                                                        <td>
                                                                                            Present
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div>
                                                                                                2 weeks ago
                                                                                            </div>
                                                                                            <div>
                                                                                                2025-04-04 06:09 PM
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>09:15 AM</td>

                                                                                        <td>06:00 PM</td>
                                                                                        <td>8.75</td>


                                                                                        <td>Late login by 15 mins</td>
                                                                                        <td>
                                                                                            Present
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="taskdetails" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-md-12 mb-4">

                                                <div class="card shadow-none p-lg-3">


                                                    <div class="tab-content text-muted">
                                                        <div class="tab-pane active show" id="all_customer"
                                                            role="tabpanel">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card shadow-none">
                                                                        <div class="card-body">
                                                                            @if (session('success'))
                                                                                <div class="alert alert-success alert-dismissible fade show"
                                                                                    role="alert">
                                                                                    {{ session('success') }}
                                                                                    <button type="button"
                                                                                        class="btn-close"
                                                                                        data-bs-dismiss="alert"></button>
                                                                                </div>
                                                                            @endif
                                                                            @if (session('error'))
                                                                                <div class="alert alert-danger alert-dismissible fade show"
                                                                                    role="alert">
                                                                                    {{ session('error') }}
                                                                                    <button type="button"
                                                                                        class="btn-close"
                                                                                        data-bs-dismiss="alert"></button>
                                                                                </div>
                                                                            @endif

                                                                            <table id="task-table"
                                                                                class="table table-striped table-borderless dt-responsive nowrap">
                                                                                <thead class="table-light">
                                                                                    <tr>
                                                                                        <th>Service Request ID</th>
                                                                                        <th>Customer Name</th>
                                                                                        <th>Service Type</th>
                                                                                        <th>Assigned Date</th>
                                                                                        <th>Assignment Type</th>
                                                                                        <th>Approval Status</th>
                                                                                        <th style="width:120px;">Action
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @forelse($assignedTasks as $task)
                                                                                        @php
                                                                                            $serviceTypeMap = [
                                                                                                '0' => 'AMC',
                                                                                                '1' => 'Quick Service',
                                                                                                '2' => 'Installation',
                                                                                                '3' => 'Repair',
                                                                                            ];
                                                                                            $serviceType =
                                                                                                $serviceTypeMap[
                                                                                                    $task
                                                                                                        ->serviceRequest
                                                                                                        ->service_type ??
                                                                                                        ''
                                                                                                ] ?? 'N/A';

                                                                                            // Check if task is overdue (48 hours)
                                                                                            $isOverdue =
                                                                                                $task->is_overdue;
                                                                                        @endphp
                                                                                        <tr
                                                                                            class="{{ $isOverdue ? 'table-warning' : '' }}">
                                                                                            <td>
                                                                                                <a
                                                                                                    href="{{ route('service-request.view-quick-service-request', $task->service_request_id) }}">
                                                                                                    {{ $task->serviceRequest->request_id ?? 'N/A' }}
                                                                                                </a>
                                                                                                @if ($isOverdue)
                                                                                                    <br><small
                                                                                                        class="text-danger"><i
                                                                                                            class="bx bx-time-five"></i>
                                                                                                        Over 48
                                                                                                        hours</small>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>
                                                                                                {{ $task->serviceRequest->customer->first_name ?? '' }}
                                                                                                {{ $task->serviceRequest->customer->last_name ?? '' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                <span
                                                                                                    class="badge bg-info-subtle text-info">{{ $serviceType }}</span>
                                                                                            </td>
                                                                                            <td>{{ $task->assigned_at ? $task->assigned_at->format('d M Y, h:i A') : 'N/A' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($task->assignment_type == '0')
                                                                                                    <span
                                                                                                        class="badge bg-primary-subtle text-primary">Individual</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-secondary-subtle text-secondary">Group
                                                                                                        -
                                                                                                        {{ $task->group_name }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($task->is_approved_by_engineer)
                                                                                                    <span
                                                                                                        class="badge bg-success-subtle text-success">
                                                                                                        <i
                                                                                                            class="bx bx-check-circle"></i>
                                                                                                        Approved
                                                                                                    </span>
                                                                                                    <br><small
                                                                                                        class="text-muted">{{ $task->engineer_approved_at }}</small>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-warning-subtle text-warning">
                                                                                                        <i
                                                                                                            class="bx bx-time"></i>
                                                                                                        Pending Approval
                                                                                                    </span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>
                                                                                                <a href="{{ route('service-request.view-quick-service-request', $task->service_request_id) }}"
                                                                                                    class="btn btn-sm btn-info"
                                                                                                    data-bs-toggle="tooltip"
                                                                                                    title="View Details">
                                                                                                    <i
                                                                                                        class="bx bx-show"></i>
                                                                                                </a>
                                                                                                @if (!$task->is_approved_by_engineer)
                                                                                                    <button type="button"
                                                                                                        class="btn btn-sm btn-success approve-task-btn"
                                                                                                        data-assignment-id="{{ $task->id }}"
                                                                                                        data-bs-toggle="tooltip"
                                                                                                        title="Approve Task">
                                                                                                        <i
                                                                                                            class="bx bx-check"></i>
                                                                                                        Approve
                                                                                                    </button>
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                    @empty
                                                                                        <tr>
                                                                                            <td colspan="7"
                                                                                                class="text-center text-muted py-4">
                                                                                                No tasks assigned yet
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforelse
                                                                                    {{-- @forelse($visitAssignments as $assignment)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <a
                                                                                                    href="{{ route('amc-services.view', $assignment->visit->amc_service_id) }}">
                                                                                                    #{{ $assignment->visit->amcService->id ?? 'N/A' }}
                                                                                                </a>
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->visit->amcService->branches->first())
                                                                                                    {{ $assignment->visit->amcService->branches->first()->customer_name ?? 'N/A' }}
                                                                                                @else
                                                                                                    N/A
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>{{ $assignment->assigned_at ? $assignment->assigned_at->format('d M Y h:i A') : 'N/A' }}
                                                                                            </td>
                                                                                            <td>{{ $assignment->visit->scheduled_date ? $assignment->visit->scheduled_date->format('d M Y h:i A') : 'N/A' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->assignment_type == 'Individual')
                                                                                                    <span
                                                                                                        class="badge bg-info-subtle text-info">Individual</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-primary-subtle text-primary">Group
                                                                                                        -
                                                                                                        {{ $assignment->group_name }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>{{ $assignment->visit->issue_type ?? 'N/A' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->status == 'Transferred')
                                                                                                    <span
                                                                                                        class="badge bg-danger-subtle text-danger fw-semibold">
                                                                                                        <i
                                                                                                            class="bx bx-transfer me-1"></i>Transferred
                                                                                                    </span>
                                                                                                    @if ($assignment->transferredToAssignment)
                                                                                                        <div
                                                                                                            class="small text-muted mt-1">
                                                                                                            To:
                                                                                                            @if ($assignment->transferredToAssignment->assignment_type == 'Individual')
                                                                                                                {{ $assignment->transferredToAssignment->engineer->first_name ?? '' }}
                                                                                                                {{ $assignment->transferredToAssignment->engineer->last_name ?? '' }}
                                                                                                            @else
                                                                                                                {{ $assignment->transferredToAssignment->group_name }}
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    @endif
                                                                                                @elseif($assignment->visit->status == 'Completed')
                                                                                                    <span
                                                                                                        class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                                                                @elseif($assignment->visit->status == 'Upcoming')
                                                                                                    <span
                                                                                                        class="badge bg-warning-subtle text-warning fw-semibold">Upcoming</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $assignment->visit->status }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>
                                                                                                <a aria-label="anchor"
                                                                                                    href="{{ route('engineers.visit-detail', $assignment->visit->id) }}"
                                                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                                                    data-bs-toggle="tooltip"
                                                                                                    data-bs-original-title="View">
                                                                                                    <i
                                                                                                        class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @empty
                                                                                    @endforelse --}}

                                                                                    {{-- Quick Service Request Assignments --}}
                                                                                    {{-- @forelse($quickServiceAssignments as $assignment)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <a
                                                                                                    href="{{ route('service-request.view-quick-service-request', $assignment->quick_service_request_id) }}">
                                                                                                    #QSR-{{ str_pad($assignment->quick_service_request_id, 4, '0', STR_PAD_LEFT) }}
                                                                                                </a>
                                                                                            </td>
                                                                                            <td>
                                                                                                {{ $assignment->quickServiceRequest->customer->first_name ?? '' }}
                                                                                                {{ $assignment->quickServiceRequest->customer->last_name ?? '' }}
                                                                                            </td>
                                                                                            <td>{{ $assignment->assigned_at ? $assignment->assigned_at->format('d M Y h:i A') : 'N/A' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                <span
                                                                                                    class="badge bg-info-subtle text-info">Quick
                                                                                                    Service</span>
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->assignment_type == 'Individual')
                                                                                                    <span
                                                                                                        class="badge bg-info-subtle text-info">Individual</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-primary-subtle text-primary">Group
                                                                                                        -
                                                                                                        {{ $assignment->group_name }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>{{ $assignment->quickServiceRequest->issue ?? 'N/A' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->status == 'Transferred')
                                                                                                    <span
                                                                                                        class="badge bg-danger-subtle text-danger fw-semibold">
                                                                                                        <i
                                                                                                            class="bx bx-transfer me-1"></i>Transferred
                                                                                                    </span>
                                                                                                @elseif($assignment->status == 'Completed')
                                                                                                    <span
                                                                                                        class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                                                                @elseif($assignment->status == 'Active')
                                                                                                    <span
                                                                                                        class="badge bg-primary-subtle text-primary fw-semibold">Assigned</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $assignment->status }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>
                                                                                                <a aria-label="anchor"
                                                                                                    href="{{ route('service-request.view-quick-service-request', $assignment->quick_service_request_id) }}"
                                                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                                                    data-bs-toggle="tooltip"
                                                                                                    data-bs-original-title="View">
                                                                                                    <i
                                                                                                        class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @empty
                                                                                    @endforelse --}}

                                                                                    {{-- NON AMC Service Assignments --}}
                                                                                    {{-- @forelse($nonAmcAssignments as $assignment)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <a
                                                                                                    href="{{ route('service-request.view-non-amc', $assignment->non_amc_service_id) }}">
                                                                                                    #NON-AMC-{{ str_pad($assignment->non_amc_service_id, 4, '0', STR_PAD_LEFT) }}
                                                                                                </a>
                                                                                            </td>
                                                                                            <td>
                                                                                                {{ $assignment->nonAmcService->first_name ?? '' }}
                                                                                                {{ $assignment->nonAmcService->last_name ?? '' }}
                                                                                            </td>
                                                                                            <td>{{ $assignment->assigned_at ? $assignment->assigned_at->format('d M Y h:i A') : 'N/A' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                <span
                                                                                                    class="badge bg-warning-subtle text-warning">NON
                                                                                                    AMC</span>
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->assignment_type == 'Individual')
                                                                                                    <span
                                                                                                        class="badge bg-info-subtle text-info">Individual</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-primary-subtle text-primary">Group
                                                                                                        -
                                                                                                        {{ $assignment->group_name }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>{{ $assignment->nonAmcService->problem_type ?? ($assignment->nonAmcService->service_type ?? 'N/A') }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->status == 'Transferred')
                                                                                                    <span
                                                                                                        class="badge bg-danger-subtle text-danger fw-semibold">
                                                                                                        <i
                                                                                                            class="bx bx-transfer me-1"></i>Transferred
                                                                                                    </span>
                                                                                                    @if ($assignment->transferredToAssignment)
                                                                                                        <div
                                                                                                            class="small text-muted mt-1">
                                                                                                            To:
                                                                                                            @if ($assignment->transferredToAssignment->assignment_type == 'Individual')
                                                                                                                {{ $assignment->transferredToAssignment->engineer->first_name ?? '' }}
                                                                                                                {{ $assignment->transferredToAssignment->engineer->last_name ?? '' }}
                                                                                                            @else
                                                                                                                {{ $assignment->transferredToAssignment->group_name }}
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    @endif
                                                                                                @elseif($assignment->status == 'Completed')
                                                                                                    <span
                                                                                                        class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                                                                @elseif($assignment->status == 'Active')
                                                                                                    <span
                                                                                                        class="badge bg-primary-subtle text-primary fw-semibold">Assigned</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $assignment->status }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>
                                                                                                <a aria-label="anchor"
                                                                                                    href="{{ route('service-request.view-non-amc', $assignment->non_amc_service_id) }}"
                                                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                                                    data-bs-toggle="tooltip"
                                                                                                    data-bs-original-title="View">
                                                                                                    <i
                                                                                                        class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @empty
                                                                                    @endforelse --}}

                                                                                    {{-- Show "No tasks" message only if all are empty --}}
                                                                                    {{-- @if ($visitAssignments->isEmpty() && $quickServiceAssignments->isEmpty() && $nonAmcAssignments->isEmpty())
                                                                                        <tr>
                                                                                            <td colspan="8"
                                                                                                class="text-center text-muted py-4">
                                                                                                No tasks assigned yet</td>
                                                                                        </tr>
                                                                                    @endif --}}
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="stockinhand" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-md-12 mb-4">

                                                <div class="card shadow-none p-lg-3">


                                                    <div class="tab-content text-muted">
                                                        <div class="tab-pane active show" id="all_customer"
                                                            role="tabpanel">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card shadow-none">
                                                                        <div class="card-body">
                                                                            <table id="responsive-datatable"
                                                                                class="table table-striped table-borderless dt-responsive nowrap">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Product Name</th>
                                                                                        <th>Quantity</th>
                                                                                        <th>Service ID</th>
                                                                                        <th>Customer Name</th>
                                                                                        <th>Assigned Date</th>
                                                                                        <th>Visit Date</th>
                                                                                        <th>Assignment Type</th>
                                                                                        <th>Issue Type</th>
                                                                                        <th>Status</th>
                                                                                        <th>Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    {{-- @forelse($visitAssignments as $assignment)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <a
                                                                                                    href="{{ route('amc-services.view', $assignment->visit->amc_service_id) }}">
                                                                                                    #{{ $assignment->visit->amcService->id ?? 'N/A' }}
                                                                                                </a>
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->visit->amcService->branches->first())
                                                                                                    {{ $assignment->visit->amcService->branches->first()->customer_name ?? 'N/A' }}
                                                                                                @else
                                                                                                    N/A
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>{{ $assignment->assigned_at ? $assignment->assigned_at->format('d M Y h:i A') : 'N/A' }}
                                                                                            </td>
                                                                                            <td>{{ $assignment->visit->scheduled_date ? $assignment->visit->scheduled_date->format('d M Y h:i A') : 'N/A' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->assignment_type == 'Individual')
                                                                                                    <span
                                                                                                        class="badge bg-info-subtle text-info">Individual</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-primary-subtle text-primary">Group
                                                                                                        -
                                                                                                        {{ $assignment->group_name }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>{{ $assignment->visit->issue_type ?? 'N/A' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->status == 'Transferred')
                                                                                                    <span
                                                                                                        class="badge bg-danger-subtle text-danger fw-semibold">
                                                                                                        <i
                                                                                                            class="bx bx-transfer me-1"></i>Transferred
                                                                                                    </span>
                                                                                                    @if ($assignment->transferredToAssignment)
                                                                                                        <div
                                                                                                            class="small text-muted mt-1">
                                                                                                            To:
                                                                                                            @if ($assignment->transferredToAssignment->assignment_type == 'Individual')
                                                                                                                {{ $assignment->transferredToAssignment->engineer->first_name ?? '' }}
                                                                                                                {{ $assignment->transferredToAssignment->engineer->last_name ?? '' }}
                                                                                                            @else
                                                                                                                {{ $assignment->transferredToAssignment->group_name }}
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    @endif
                                                                                                @elseif($assignment->visit->status == 'Completed')
                                                                                                    <span
                                                                                                        class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                                                                @elseif($assignment->visit->status == 'Upcoming')
                                                                                                    <span
                                                                                                        class="badge bg-warning-subtle text-warning fw-semibold">Upcoming</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $assignment->visit->status }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>
                                                                                                <a aria-label="anchor"
                                                                                                    href="{{ route('engineers.visit-detail', $assignment->visit->id) }}"
                                                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                                                    data-bs-toggle="tooltip"
                                                                                                    data-bs-original-title="View">
                                                                                                    <i
                                                                                                        class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @empty
                                                                                    @endforelse --}}

                                                                                    {{-- Quick Service Request Assignments --}}
                                                                                    {{-- @forelse($quickServiceAssignments as $assignment)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <a
                                                                                                    href="{{ route('service-request.view-quick-service-request', $assignment->quick_service_request_id) }}">
                                                                                                    #QSR-{{ str_pad($assignment->quick_service_request_id, 4, '0', STR_PAD_LEFT) }}
                                                                                                </a>
                                                                                            </td>
                                                                                            <td>
                                                                                                {{ $assignment->quickServiceRequest->customer->first_name ?? '' }}
                                                                                                {{ $assignment->quickServiceRequest->customer->last_name ?? '' }}
                                                                                            </td>
                                                                                            <td>{{ $assignment->assigned_at ? $assignment->assigned_at->format('d M Y h:i A') : 'N/A' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                <span
                                                                                                    class="badge bg-info-subtle text-info">Quick
                                                                                                    Service</span>
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->assignment_type == 'Individual')
                                                                                                    <span
                                                                                                        class="badge bg-info-subtle text-info">Individual</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-primary-subtle text-primary">Group
                                                                                                        -
                                                                                                        {{ $assignment->group_name }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>{{ $assignment->quickServiceRequest->issue ?? 'N/A' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->status == 'Transferred')
                                                                                                    <span
                                                                                                        class="badge bg-danger-subtle text-danger fw-semibold">
                                                                                                        <i
                                                                                                            class="bx bx-transfer me-1"></i>Transferred
                                                                                                    </span>
                                                                                                @elseif($assignment->status == 'Completed')
                                                                                                    <span
                                                                                                        class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                                                                @elseif($assignment->status == 'Active')
                                                                                                    <span
                                                                                                        class="badge bg-primary-subtle text-primary fw-semibold">Assigned</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $assignment->status }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>
                                                                                                <a aria-label="anchor"
                                                                                                    href="{{ route('service-request.view-quick-service-request', $assignment->quick_service_request_id) }}"
                                                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                                                    data-bs-toggle="tooltip"
                                                                                                    data-bs-original-title="View">
                                                                                                    <i
                                                                                                        class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @empty
                                                                                    @endforelse --}}

                                                                                    {{-- NON AMC Service Assignments --}}
                                                                                    {{-- @forelse($nonAmcAssignments as $assignment)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <a
                                                                                                    href="{{ route('service-request.view-non-amc', $assignment->non_amc_service_id) }}">
                                                                                                    #NON-AMC-{{ str_pad($assignment->non_amc_service_id, 4, '0', STR_PAD_LEFT) }}
                                                                                                </a>
                                                                                            </td>
                                                                                            <td>
                                                                                                {{ $assignment->nonAmcService->first_name ?? '' }}
                                                                                                {{ $assignment->nonAmcService->last_name ?? '' }}
                                                                                            </td>
                                                                                            <td>{{ $assignment->assigned_at ? $assignment->assigned_at->format('d M Y h:i A') : 'N/A' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                <span
                                                                                                    class="badge bg-warning-subtle text-warning">NON
                                                                                                    AMC</span>
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->assignment_type == 'Individual')
                                                                                                    <span
                                                                                                        class="badge bg-info-subtle text-info">Individual</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-primary-subtle text-primary">Group
                                                                                                        -
                                                                                                        {{ $assignment->group_name }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>{{ $assignment->nonAmcService->problem_type ?? ($assignment->nonAmcService->service_type ?? 'N/A') }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($assignment->status == 'Transferred')
                                                                                                    <span
                                                                                                        class="badge bg-danger-subtle text-danger fw-semibold">
                                                                                                        <i
                                                                                                            class="bx bx-transfer me-1"></i>Transferred
                                                                                                    </span>
                                                                                                    @if ($assignment->transferredToAssignment)
                                                                                                        <div
                                                                                                            class="small text-muted mt-1">
                                                                                                            To:
                                                                                                            @if ($assignment->transferredToAssignment->assignment_type == 'Individual')
                                                                                                                {{ $assignment->transferredToAssignment->engineer->first_name ?? '' }}
                                                                                                                {{ $assignment->transferredToAssignment->engineer->last_name ?? '' }}
                                                                                                            @else
                                                                                                                {{ $assignment->transferredToAssignment->group_name }}
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    @endif
                                                                                                @elseif($assignment->status == 'Completed')
                                                                                                    <span
                                                                                                        class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                                                                @elseif($assignment->status == 'Active')
                                                                                                    <span
                                                                                                        class="badge bg-primary-subtle text-primary fw-semibold">Assigned</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $assignment->status }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>
                                                                                                <a aria-label="anchor"
                                                                                                    href="{{ route('service-request.view-non-amc', $assignment->non_amc_service_id) }}"
                                                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                                                    data-bs-toggle="tooltip"
                                                                                                    data-bs-original-title="View">
                                                                                                    <i
                                                                                                        class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @empty
                                                                                    @endforelse --}}

                                                                                    {{-- Show "No tasks" message only if all are empty --}}
                                                                                    {{-- @if ($visitAssignments->isEmpty() && $quickServiceAssignments->isEmpty() && $nonAmcAssignments->isEmpty())
                                                                                        <tr>
                                                                                            <td colspan="10"
                                                                                                class="text-center text-muted py-4">
                                                                                                No tasks assigned yet</td>
                                                                                        </tr>
                                                                                    @endif --}}
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // CSRF token setup for AJAX
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Handle approve task button click
                $('.approve-task-btn').on('click', function() {
                    const button = $(this);
                    const assignmentId = button.data('assignment-id');
                    const row = button.closest('tr');

                    // Confirm approval
                    if (!confirm('Are you sure you want to approve this task?')) {
                        return;
                    }

                    // Disable button and show loading
                    button.prop('disabled', true);
                    button.html('<i class="bx bx-loader bx-spin"></i> Approving...');

                    // Send AJAX request
                    $.ajax({
                        url: '{{ route('staff.approve.task') }}',
                        type: 'POST',
                        data: {
                            assignment_id: assignmentId
                        },
                        success: function(response) {
                            if (response.success) {
                                // Show success message
                                const alertHtml = `
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            `;
                                $('.card-body').prepend(alertHtml);

                                // Update the approval status column
                                const statusCell = row.find('td:eq(5)');
                                statusCell.html(`
                                <span class="badge bg-success-subtle text-success">
                                    <i class="bx bx-check-circle"></i> Approved
                                </span>
                                <br><small class="text-muted">${response.approved_at}</small>
                            `);

                                // Remove the approve button
                                button.remove();

                                // Remove warning highlight if present
                                row.removeClass('table-warning');

                                // Auto-dismiss alert after 5 seconds
                                setTimeout(function() {
                                    $('.alert-success').fadeOut('slow', function() {
                                        $(this).remove();
                                    });
                                }, 5000);
                            } else {
                                alert('Error: ' + response.message);
                                button.prop('disabled', false);
                                button.html('<i class="bx bx-check"></i> Approve');
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'An error occurred while approving the task.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            const alertHtml = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${errorMessage}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        `;
                            $('.card-body').prepend(alertHtml);

                            button.prop('disabled', false);
                            button.html('<i class="bx bx-check"></i> Approve');

                            // Auto-dismiss alert after 5 seconds
                            setTimeout(function() {
                                $('.alert-danger').fadeOut('slow', function() {
                                    $(this).remove();
                                });
                            }, 5000);
                        }
                    });
                });

                // Initialize tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();
            });
        </script>
    @endpush
@endsection
