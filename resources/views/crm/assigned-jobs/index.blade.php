@extends('crm/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Assigned Jobs </h4>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">

                    

                    <!-- <div class="col-xl-2 col-sm-3 col-6">
                                    <div>
                                        <select class="form-select" name="type" id="">

                                            <option selected="" value="0">
                                                All
                                            </option>
                                            <option value="1">
                                                Laptops
                                            </option>
                                            <option value="2">
                                                Computers
                                            </option>
                                            <option value="3">
                                                Accessories
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-2 col-sm-3 col-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-100 waves ripple-light">
                                            <span class="d-none d-md-inline-flex"> Search </span>
                                            <i class="fa-solid fa-magnifying-glass "></i>

                                        </button>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-sm-3 col-6">
                                    <div>
                                        <a href="#" class="btn btn-primary w-50 waves ripple-light">
                                            <i class="ri-refresh-line me-1 align-bottom"></i>
                                            Sort
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-2 col-sm-3 col-3 btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="d-none d-md-inline-flex"> Brand </span>
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Dell</a></li>
                                        <li><a class="dropdown-item" href="#">Hp</a></li>
                                    </ul>
                                </div>
                                <div class="col-xl-2 col-md-2 col-sm-3 col-3 btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="d-none d-md-inline-flex"> Status </span>
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Approved</a></li>
                                        <li><a class="dropdown-item" href="#">Pending</a></li>
                                        <li><a class="dropdown-item" href="#">Rejected</a></li>
                                    </ul>
                                </div> -->
                    <div class="card-body pt-0">
                        <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active p-2" id="all_customer_tab" data-bs-toggle="tab"
                                    href="#all_customer" role="tab">
                                    <span class="d-block d-sm-none"><i
                                            class="mdi mdi-information"></i></span>
                                    <span class="d-none d-sm-block">All Assigned Jobs</span>
                                </a>
                            </li>

                        </ul>

                        <div class="tab-content text-muted">
                            <div class="tab-pane active show pt-4" id="all_customer" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Job Id</th>
                                                            <th>Engineer Name</th>
                                                            <th>Client Name</th>
                                                            <th>Issue Type</th>
                                                            <th>Priority</th>
                                                            <th>Schedule/Deadline</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($assignedJobs as $assignment)
                                                        <tr>
                                                            <td>
                                                                {{ $assignment->job->id }}
                                                            </td>
                                                            <td>{{ $assignment->engineer->first_name }} {{ $assignment->engineer->last_name }}</td>
                                                            <td>{{ $assignment->job->first_name }} {{ $assignment->job->last_name }}</td>
                                                            <td>{{ $assignment->job->issue_type }}</td>
                                                            <td>
                                                                @if($assignment->job->priority_level == 'High')
                                                                    <span class="badge bg-danger-subtle text-danger fw-semibold">High</span>
                                                                @elseif($assignment->job->priority_level == 'Medium')
                                                                    <span class="badge bg-warning-subtle text-warning fw-semibold">Medium</span>
                                                                @else
                                                                    <span class="badge bg-info-subtle text-info fw-semibold">Low</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $assignment->job->purchase_date ? $assignment->job->purchase_date->format('Y-m-d') : 'N/A' }}</td>
                                                            <td>
                                                                @if($assignment->status == 'Pending')
                                                                    <span class="badge bg-danger-subtle text-danger fw-semibold">Pending</span>
                                                                @elseif($assignment->status == 'In Progress')
                                                                    <span class="badge bg-warning-subtle text-warning fw-semibold">In Progress</span>
                                                                @elseif($assignment->status == 'Completed')
                                                                    <span class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                                                @else
                                                                    <span class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $assignment->status }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a aria-label="anchor" href="{{ route('assigned-jobs.view', $assignment->id) }}"
                                                                    class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="View">
                                                                    <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                </a>
                                                                <a aria-label="anchor" href="{{ route('assigned-jobs.edit', $assignment->id) }}"
                                                                    class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                    <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                </a>
                                                                <form action="{{ route('assigned-jobs.delete', $assignment->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this assigned job?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" aria-label="anchor"
                                                                        class="btn btn-icon btn-sm bg-danger-subtle"
                                                                        data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="8" class="text-center">No assigned jobs found</td>
                                                        </tr>
                                                        @endforelse
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
        </div> <!-- container-fluid -->
    </div> <!-- content -->

@endsection