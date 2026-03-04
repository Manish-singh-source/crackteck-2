@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">KYC Log List</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            @php
                                $statuses = [
                                    'all' => [
                                        'label' => 'All',
                                        'icon' => 'mdi-format-list-bulleted',
                                        'color' => 'text-secondary',
                                    ],

                                    'under_review' => [
                                        'label' => 'Under Review',
                                        'icon' => 'mdi-file-search-outline',
                                        'color' => 'text-primary',
                                    ],

                                    'approved' => [
                                        'label' => 'Approved',
                                        'icon' => 'mdi-check-circle',
                                        'color' => 'text-success',
                                    ],

                                    'rejected' => [
                                        'label' => 'Rejected',
                                        'icon' => 'mdi-close-circle',
                                        'color' => 'text-danger',
                                    ],

                                    'resubmit_required' => [
                                        'label' => 'Resubmit Required',
                                        'icon' => 'mdi-refresh-circle',
                                        'color' => 'text-warning',
                                    ],
                                ];

                                $currentStatus = request()->get('status') ?? 'all';
                            @endphp

                            <ul class="nav nav-underline border-bottom" id="pills-tab" role="tablist">
                                @foreach ($statuses as $key => $status)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $currentStatus === $key ? 'under_review' : '' }} p-2"
                                            href="{{ $key === 'all' ? route('kyc-log') : route('kyc-log', ['status' => $key]) }}">
                                            <span class="d-block d-sm-none">
                                                <i class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>
                                            </span>
                                            <span class="d-none d-sm-block">
                                                <i
                                                    class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>{{ $status['label'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content text-muted">
                                <div class="tab-pane active show" id="all_customer" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    @if (session('success'))
                                                        <div class="alert alert-success alert-dismissible fade show"
                                                            role="alert">
                                                            {{ session('success') }}
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                                aria-label="Close"></button>
                                                        </div>
                                                    @endif

                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Role</th>
                                                                <th>Staff ID</th>
                                                                <th>Name</th>
                                                                <th>Phone</th>
                                                                <th>Email</th>
                                                                <th>Document Type</th>
                                                                <th>Document No.</th>
                                                                <th>Submitted On</th>
                                                                <th>Status</th>
                                                                <th>Verified On</th>
                                                                <th>Reason</th>
                                                                {{-- <th>Document</th> --}}
                                                                <th>Action</th>
                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            @forelse($kycs as $kyc)
                                                                <tr>
                                                                    <td>{{ $kyc->id }}</td>
                                                                    <td>
                                                                        @if($kyc->role)
                                                                            <span class="badge bg-primary">{{ $kyc->role->name }}</span>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($kyc->staff)
                                                                            <a href="#" class="text-decoration-none">
                                                                                {{ $kyc->staff->first_name }} {{ $kyc->staff->last_name }}
                                                                                <small class="text-muted d-block">{{ $kyc->staff->staff_code }}</small>
                                                                            </a>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $kyc->name }}</td>
                                                                    <td>{{ $kyc->phone }}</td>
                                                                    <td>{{ $kyc->email ?? '-' }}</td>
                                                                    <td>
                                                                        @if ($kyc->document_type)
                                                                            <span
                                                                                class="badge bg-info">{{ ucwords(str_replace('_', ' ', $kyc->document_type)) }}</span>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $kyc->document_no ?? '-' }}</td>
                                                                    <td>{{ $kyc->created_at->format('Y-m-d') }}</td>
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
                                                                                <span class="badge bg-warning">Resubmit
                                                                                    Required</span>
                                                                            @break

                                                                            @default
                                                                                <span
                                                                                    class="badge bg-secondary">{{ $kyc->status }}</span>
                                                                        @endswitch
                                                                    </td>
                                                                    <td>
                                                                        @if ($kyc->approved_at)
                                                                            {{ $kyc->approved_at->format('Y-m-d') }}
                                                                        @elseif($kyc->rejected_at)
                                                                            {{ $kyc->rejected_at->format('Y-m-d') }}
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $kyc->reason ?? '-' }}</td>
                                                                    {{-- <td>
                                                                        @if ($kyc->document_file)
                                                                            <a href="{{ asset('storage/' . $kyc->document_file) }}"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-outline-primary">
                                                                                <i class="mdi mdi-file-document"></i> View
                                                                            </a>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td> --}}
                                                                    <td>
                                                                        {{-- <a href="{{ route('kyc-log.view', $kyc->id) }}"
                                                                            class="btn btn-sm btn-outline-info">
                                                                            <i class="mdi mdi-eye"></i> View
                                                                        </a> --}}

                                                                        <a aria-label="anchor"
                                                                            href="{{ route('kyc-log.view', $kyc->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="12" class="text-center">No KYC records
                                                                            found</td>
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
