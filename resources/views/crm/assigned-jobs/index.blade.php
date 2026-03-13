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
                        <div class="card-body pt-0">
                            <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active p-2" id="all_customer_tab" data-bs-toggle="tab"
                                        href="#all_customer" role="tab">
                                        <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
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
                                                                <th>Sr. No.</th>
                                                                <th>Service Request Id</th>
                                                                <th>Service Type</th>
                                                                <th>Engineer Name</th>
                                                                <th>Customer Name</th>
                                                                <th>Assigned Date/Time</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($jobs as $key => $job)
                                                                <tr>
                                                                    <td>
                                                                        {{ $loop->iteration }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $job->serviceRequest->request_id }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $job->serviceRequest->service_type }}
                                                                    </td>
                                                                    <td>{{ $job->engineer->first_name }}
                                                                        {{ $job->engineer->last_name }}</td>
                                                                    <td>{{ $job->serviceRequest->customer->first_name }}
                                                                        {{ $job->serviceRequest->customer->last_name }}</td>
                                                                    <td>{{ $job->assigned_at }}</td>
                                                                    <td>
                                                                        {{ $job->status }}
                                                                    </td>
                                                                    <td>
                                                                        <a class="btn btn-sm btn-primary"
                                                                            href="{{ route('assigned-jobs.view', $job->id) }}">View</a>
                                                                        <a class="btn btn-sm btn-success"
                                                                            href="#">Edit</a>
                                                                        <a class="btn btn-sm btn-danger"
                                                                            href="#">Delete</a>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr class="text-center">
                                                                    No Data Found
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
