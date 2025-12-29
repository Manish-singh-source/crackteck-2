@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Jobs </h4>
                </div>
                <div>
                    <a href="{{ route('jobs.create') }}" class="btn btn-primary">Create Job</a>
                    <!-- <button class="btn btn-primary">Add New Customer</button> -->
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
                                        <span class="d-none d-sm-block">All Jobs</span>
                                    </a>
                                </li>

                            </ul>

                            <div class="tab-content text-muted">
                                <div class="tab-pane active show pt-4" id="all_customer" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-header border-bottom-dashed">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h5 class="card-title mb-0">Jobs List</h5>
                                                        <button type="button" class="btn btn-danger btn-sm" id="bulk-delete-jobs-btn" style="display: none;">
                                                            <i class="mdi mdi-delete"></i> Delete Selected
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <input type="checkbox" id="select-all-jobs" class="form-check-input">
                                                                </th>
                                                                <th>Job Id</th>
                                                                <th>Customer Name</th>
                                                                <th>Client Name</th>
                                                                <th>Issue Type</th>
                                                                <th>Priority</th>
                                                                <th>Purchase Date</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($jobs as $job)
                                                                <tr class="job-row" data-job-id="{{ $job->id }}">
                                                                    <td>
                                                                        <input type="checkbox" class="form-check-input job-checkbox" value="{{ $job->id }}">
                                                                    </td>
                                                                    <td>
                                                                        {{ $job->id }}
                                                                    </td>
                                                                    <td>{{ $job->first_name }} {{ $job->last_name }}</td>
                                                                    <td>{{ $job->company_name }}</td>
                                                                    <td>{{ $job->issue_type }}</td>
                                                                    <td>{{ $job->priority_level }}</td>
                                                                    <td>{{ $job->purchase_date ? $job->purchase_date->format('Y-m-d') : 'N/A' }}</td>
                                                                    <td>
                                                                        <span class="badge bg-warning-subtle text-warning fw-semibold">Open</span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('jobs.view',$job->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('jobs.edit',$job->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form style="display: inline-block"
                                                                            action="{{ route('jobs.delete', $job->id) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Are you sure?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button
                                                                            type="submit"
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

<script>
    $(document).ready(function() {
        // Select all jobs checkbox
        $('#select-all-jobs').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.job-checkbox').prop('checked', isChecked);
            toggleBulkDeleteButton();
        });

        // Individual job checkbox
        $('.job-checkbox').on('change', function() {
            const totalCheckboxes = $('.job-checkbox').length;
            const checkedCheckboxes = $('.job-checkbox:checked').length;

            $('#select-all-jobs').prop('checked', totalCheckboxes === checkedCheckboxes);
            toggleBulkDeleteButton();
        });

        // Toggle bulk delete button visibility
        function toggleBulkDeleteButton() {
            const checkedCount = $('.job-checkbox:checked').length;
            if (checkedCount > 0) {
                $('#bulk-delete-jobs-btn').show();
            } else {
                $('#bulk-delete-jobs-btn').hide();
            }
        }

        // Bulk delete jobs
        $('#bulk-delete-jobs-btn').on('click', function() {
            const selectedJobs = [];
            $('.job-checkbox:checked').each(function() {
                selectedJobs.push($(this).val());
            });

            if (selectedJobs.length === 0) {
                alert('Please select at least one job to delete.');
                return;
            }

            if (confirm('Are you sure you want to delete ' + selectedJobs.length + ' job(s)? This will also delete all associated devices.')) {
                $.ajax({
                    url: '/crm/bulk-delete-jobs',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        job_ids: selectedJobs
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
                        alert('Error deleting jobs. Please try again.');
                    }
                });
            }
        });
    });
</script>

    @endsection
