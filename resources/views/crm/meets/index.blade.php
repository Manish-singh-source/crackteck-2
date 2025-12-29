@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Task, Meeting & Visit Scheduler</h4>
                </div>
                <div>
                    <a href="{{ route('meets.create') }}" id="mySection" class="btn btn-primary">Create
                        Meeting</a>
                </div>
            </div>

            <!-- End Main Widgets -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active p-2" onclick="showSection()" id="all_services_tab"
                                            data-bs-toggle="tab" href="#all_services" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                            <span class="d-none d-sm-block">Upcoming</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" onclick="showSection()" id="all_services_tab"
                                            data-bs-toggle="tab" href="#all_services" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                            <span class="d-none d-sm-block">Today</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" onclick="showSection()" id="all_services_tab"
                                            data-bs-toggle="tab" href="#all_services" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                            <span class="d-none d-sm-block">Completed</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-2" onclick="showSection()" id="all_services_tab"
                                            data-bs-toggle="tab" href="#all_services" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                            <span class="d-none d-sm-block">Missed</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content text-muted">
                                <div class="tab-pane active show pt-4" id="all_services" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Lead Id</th>
                                                                <th>Meeting ID</th>
                                                                <th>Title</th>
                                                                <th>Type</th>
                                                                <th>Date & Time</th>
                                                                <th>Location / Link</th>
                                                                {{-- <th>Assigned Rep</th> --}}
                                                                <th>Engineer (if any)</th>
                                                                <th>Status</th>
                                                                {{-- <th>Follow-up Task</th> --}}
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($meet as $meet)
                                                                <tr>
                                                                    <td>
                                                                        <a href="">
                                                                            {{ $meet->lead_id }}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ $meet->id }}</td>
                                                                    <td>{{ $meet->meet_title }}</td>
                                                                    <td>{{ $meet->meeting_type }}</td>
                                                                    <td>{{ $meet->date }} {{ $meet->time }}</td>
                                                                    <td>{{ $meet->location }}</td>
                                                                    {{-- <td>NA</td> --}}
                                                                    <td>NA</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass = match ($meet->status) {
                                                                                'Scheduled' => 'bg-warning-subtle text-warning',
                                                                                'Confirmed' => 'bg-success-subtle text-success',
                                                                                'Completed' => 'bg-info-subtle text-info',
                                                                                'Cancelled' => 'bg-danger-subtle text-danger',
                                                                                default => 'bg-secondary-subtle text-secondary',
                                                                            };
                                                                        @endphp
                                                                        <span class="badge fw-semibold {{ $badgeClass }}">
                                                                        {{ $meet->status }}
                                                                        </span>
                                                                    </td>
                                                                    {{-- <td>{{ $meet->followUp }}</td> --}}
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('meets.view', $meet->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('meets.edit', $meet->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form style="display: inline-block"
                                                                            action="{{ route('meets.delete', $meet->id) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Are you sure?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Delete"><i
                                                                                    class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
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
