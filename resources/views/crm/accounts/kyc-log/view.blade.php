@extends('crm/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">KYC Details</h4>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('kyc-log') }}" class="btn btn-secondary btn-sm">
                    <i class="mdi mdi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row">
            <!-- KYC Details Card -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Personal Details</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="40%"><strong>KYC ID:</strong></td>
                                    <td>{{ $kyc->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Role:</strong></td>
                                    <td>
                                        @if($kyc->role)
                                            <span class="badge bg-primary">{{ $kyc->role->name }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Staff:</strong></td>
                                    <td>
                                        @if($kyc->staff)
                                            {{ $kyc->staff->first_name }} {{ $kyc->staff->last_name }}
                                            <small class="text-muted d-block">Code: {{ $kyc->staff->staff_code }}</small>
                                            <small class="text-muted d-block">Phone: {{ $kyc->staff->phone }}</small>
                                            <small class="text-muted d-block">Email: {{ $kyc->staff->email }}</small>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $kyc->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $kyc->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $kyc->phone }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date of Birth:</strong></td>
                                    <td>{{ $kyc->dob ? $kyc->dob->format('Y-m-d') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Document Type:</strong></td>
                                    <td>
                                        @if($kyc->document_type)
                                        <span class="badge bg-info">{{ ucwords(str_replace('_', ' ', $kyc->document_type)) }}</span>
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Document Number:</strong></td>
                                    <td>{{ $kyc->document_no ?? '-' }}</td>
                                </tr>
                                
                                <tr>
                                    <td><strong>Current Status:</strong></td>
                                    <td>
                                        @switch($kyc->status)
                                        @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                        @case('submitted')
                                        <span class="badge bg-info">Submitted</span>
                                        @break
                                        @case('under_review')
                                        <span class="badge bg-primary">Under Review</span>
                                        @break
                                        @case('approved')
                                        <span class="badge bg-success">Approved</span>
                                        @break
                                        @case('rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                        @break
                                        @case('resubmit_required')
                                        <span class="badge bg-warning">Resubmit Required</span>
                                        @break
                                        @default
                                        <span class="badge bg-secondary">{{ $kyc->status }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Reason:</strong></td>
                                    <td>{{ $kyc->reason ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created At:</strong></td>
                                    <td>{{ $kyc->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Updated At:</strong></td>
                                    <td>{{ $kyc->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                @if($kyc->approved_at)
                                <tr>
                                    <td><strong>Approved At:</strong></td>
                                    <td>{{ $kyc->approved_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                @endif
                                @if($kyc->rejected_at)
                                <tr>
                                    <td><strong>Rejected At:</strong></td>
                                    <td>{{ $kyc->rejected_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Document Preview & Status Update Card -->
            <div class="col-lg-6">
                <!-- Document Preview -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Uploaded Document</h5>
                    </div>
                    <div class="card-body">
                        @if($kyc->document_file)
                        <div class="text-center">
                            @php
                            $extension = pathinfo($kyc->document_file, PATHINFO_EXTENSION);
                            @endphp
                            
                            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                            <a href="{{ asset('storage/' . $kyc->document_file) }}" target="_blank">
                                <img src="{{ asset('storage/' . $kyc->document_file) }}" alt="Document" class="img-fluid" style="max-height: 400px;">
                            </a>
                            @elseif($extension == 'pdf')
                            <div class="pdf-preview">
                                <iframe src="{{ asset('storage/' . $kyc->document_file) }}" width="100%" height="400px"></iframe>
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $kyc->document_file) }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-download"></i> Download PDF
                                    </a>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-info">
                                <i class="mdi mdi-file-document-outline fs-1"></i>
                                <p>Document uploaded but cannot be previewed</p>
                                <a href="{{ asset('storage/' . $kyc->document_file) }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="mdi mdi-download"></i> Download Document
                                </a>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <i class="mdi mdi-file-alert-outline fs-1"></i>
                            <p class="mt-2">No document uploaded</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Status Update Form -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Update Status</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kyc-log.update-status', $kyc->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    {{-- <option value="pending" {{ $kyc->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="submitted" {{ $kyc->status == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                    <option value="under_review" {{ $kyc->status == 'under_review' ? 'selected' : '' }}>Under Review</option> --}}
                                    <option value="approved" {{ $kyc->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $kyc->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="resubmit_required" {{ $kyc->status == 'resubmit_required' ? 'selected' : '' }}>Resubmit Required</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason / Remarks</label>
                                <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Enter reason for status change...">{{ $kyc->reason }}</textarea>
                                <small class="text-muted">Required when rejecting or requesting resubmission</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-check"></i> Update Status
                                </button>
                                <a href="{{ route('kyc-log') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->

@endsection
