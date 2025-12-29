@extends('crm/layouts/master')

@section('content')

<div class="content">


    <div class="container-fluid">

        <div class="bradcrumb pt-3 ps-2 bg-light">
            <div class="row ">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('assigned-jobs.index') }}">Assigned Jobs</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Assigned Job</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Assigned Job</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form action="{{ route('assigned-jobs.update', $assignment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">
                                            Job Assignment Details
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Job ID</label>
                                            <input type="text" class="form-control" value="{{ $assignment->job->id }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Customer Name</label>
                                            <input type="text" class="form-control" value="{{ $assignment->job->first_name }} {{ $assignment->job->last_name }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Engineer Name</label>
                                            <input type="text" class="form-control" value="{{ $assignment->engineer->first_name }} {{ $assignment->engineer->last_name }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Issue Type</label>
                                            <input type="text" class="form-control" value="{{ $assignment->job->issue_type }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-select" required>
                                                <option value="Pending" {{ $assignment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="In Progress" {{ $assignment->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="Completed" {{ $assignment->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="Cancelled" {{ $assignment->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Assigned Date</label>
                                            <input type="text" class="form-control" value="{{ $assignment->assigned_at ? $assignment->assigned_at->format('Y-m-d H:i') : 'N/A' }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Notes</label>
                                            <textarea name="notes" class="form-control" rows="4" placeholder="Enter any notes or comments">{{ $assignment->notes }}</textarea>
                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>

                    <div class="col-lg-12">
                        <div class="text-start mb-3 ms-3">
                            <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                Update Assignment
                            </button>
                            <a href="{{ route('assigned-jobs.index') }}" class="btn btn-secondary w-sm waves ripple-light ms-2">
                                Cancel
                            </a>
                        </div>
                    </div>

                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection