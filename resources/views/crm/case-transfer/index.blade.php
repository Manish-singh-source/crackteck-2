@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Cases List</h4>
                </div>
                <div>
                    <a href="{{ route('case-transfer.create') }}" class="btn btn-primary">Transfer Case</a>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            @php
                                $statuses = [
                                    'all' => ['label' => 'All', 'icon' => 'mdi-format-list-bulleted', 'color' => ''],
                                    'approved' => [
                                        'label' => 'Approved',
                                        'icon' => 'mdi-check-circle-outline',
                                        'color' => 'text-success',
                                    ],
                                    'pending' => [
                                        'label' => 'Pending',
                                        'icon' => 'mdi-clock-outline',
                                        'color' => 'text-warning',
                                    ],
                                    'rejected' => [
                                        'label' => 'Rejected',
                                        'icon' => 'mdi-block-helper',
                                        'color' => 'text-danger',
                                    ],
                                ];

                                $currentStatus = request()->get('status') ?? 'all';
                            @endphp

                            <ul class="nav nav-underline border-bottom" id="pills-tab" role="tablist">
                                @foreach ($statuses as $key => $status)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $currentStatus === $key ? 'active' : '' }} p-2"
                                            href="{{ $key === 'all' ? route('case-transfer.index') : route('case-transfer.index', ['status' => $key]) }}">
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

                                <div class="tab-pane active show" id="all_case" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Service Id</th>
                                                                <th>Created At</th>
                                                                <th>Transfer From</th>
                                                                <th>Transfer To</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($caseTransferRequests as $request)
                                                                <tr>
                                                                    <td>
                                                                        <a
                                                                            href="{{ route('service-request.view-service', $request->serviceRequest->id) }}">
                                                                            {{ $request->serviceRequest->request_id }}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ $request->created_at }}</td>
                                                                    <td>{{ $request->requestingEngineer->first_name ?? 'N/A' }} {{ $request->requestingEngineer->last_name ?? ''}}</td>
                                                                    <td>{{ $request->transferringEngineer->first_name ?? 'N/A' }} {{ $request->transferringEngineer->last_name ?? ''}}</td>

                                                                    <td>
                                                                        @if ($request->status == 'pending')
                                                                            <span
                                                                                class="badge bg-danger-subtle text-danger fw-semibold">Pending</span>
                                                                        @elseif($request->status == 'approved')
                                                                            <span
                                                                                class="badge bg-success-subtle text-success fw-semibold">Approved</span>
                                                                        @elseif($request->status == 'rejected')
                                                                            <span
                                                                                class="badge bg-warning-subtle text-warning fw-semibold">Rejected</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('case-transfer.view', $request->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        {{-- <a aria-label="anchor"
                                                                            class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Delete">
                                                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                        </a> --}}
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center">No case transfer
                                                                        requests found.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- end Experience -->

                            </div> <!-- Tab panes -->
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection
