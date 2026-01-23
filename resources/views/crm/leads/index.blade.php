@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Leads List</h4>
                </div>
                <div>
                    <a href="{{ route('leads.create') }}" class="btn btn-primary">Add New Lead</a>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            @php
                                $statuses = [
                                    'all' => ['label' => 'All', 'icon' => 'mdi-format-list-bulleted', 'color' => ''],
                                    'new' => [
                                        'label' => 'New',
                                        'icon' => 'mdi-plus-circle-outline',
                                        'color' => 'text-success',
                                    ],
                                    'contacted' => [
                                        'label' => 'Contacted',
                                        'icon' => 'mdi-phone-check',
                                        'color' => 'text-warning',
                                    ],
                                    'qualified' => [
                                        'label' => 'Qualified',
                                        'icon' => 'mdi-check-circle-outline',
                                        'color' => 'text-primary',
                                    ],
                                    'proposal' => [
                                        'label' => 'Proposal',
                                        'icon' => 'mdi-file-document-outline',
                                        'color' => 'text-info',
                                    ],
                                    'won' => [
                                        'label' => 'Won',
                                        'icon' => 'mdi-trophy-outline',
                                        'color' => 'text-success',
                                    ],
                                    'lost' => [
                                        'label' => 'Lost',
                                        'icon' => 'mdi-close-circle-outline',
                                        'color' => 'text-danger',
                                    ],
                                    'nurture' => [
                                        'label' => 'Nurture',
                                        'icon' => 'mdi-leaf',
                                        'color' => 'text-secondary',
                                    ],
                                ];

                                $currentStatus = request()->get('status') ?? 'all';
                            @endphp

                            <ul class="nav nav-underline border-bottom" id="pills-tab" role="tablist">
                                @foreach ($statuses as $key => $status)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $currentStatus === $key ? 'active' : '' }} p-2"
                                            href="{{ $key === 'all' ? route('leads.index') : route('leads.index', ['status' => $key]) }}">
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
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Lead Id</th>
                                                                <th>Lead Number</th>
                                                                <th>Sales Person</th>
                                                                <th>Customer Name</th>
                                                                <th>Contact No</th>
                                                                <th>Company Name</th>
                                                                <th>Industry</th>
                                                                <th>Requirement</th>
                                                                <th>Budget</th>
                                                                <th>Urgency</th>
                                                                <th>Status</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($leads as $lead)
                                                                <tr>
                                                                    <td>{{ $lead->id }}</td>
                                                                    <td>{{ $lead->lead_number }}</td>
                                                                    <td>{{ $lead->staff->first_name . ' ' . $lead->staff->last_name }}
                                                                    </td>
                                                                    <td>{{ $lead->customer->first_name }}
                                                                        {{ $lead->customer->last_name }}</td>
                                                                    <td>{{ $lead->customer->phone }}</td>
                                                                    <td>{{ $lead->companyDetails?->company_name ?? 'N/A' }}
                                                                    </td>
                                                                    <td>{{ $lead->customer->industry_type ?? 'N/A' }}</td>
                                                                    <td>
                                                                        @php
                                                                            $requirementTypes = [
                                                                                'servers' => 'Servers',
                                                                                'cctv' => 'CCTV',
                                                                                'biometric' => 'Biometric',
                                                                                'networking' => 'Networking',
                                                                                'laptops' => 'Laptops',
                                                                                'desktops' => 'Desktops',
                                                                                'accessories' => 'Accessories',
                                                                                'other' => 'Other',
                                                                            ];
                                                                        @endphp
                                                                        {{ $requirementTypes[$lead->requirement_type] }}
                                                                    </td>
                                                                    <td>{{ $lead->budget_range }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass = match ($lead->urgency) {
                                                                                'low'
                                                                                    => 'bg-success-subtle text-success',
                                                                                'medium'
                                                                                    => 'bg-warning-subtle text-warning',
                                                                                'high'
                                                                                    => 'bg-danger-subtle text-danger',
                                                                                default
                                                                                    => 'bg-secondary-subtle text-secondary',
                                                                            };
                                                                        @endphp
                                                                        @php
                                                                            $urgencyTypes = [
                                                                                'low' => 'Low',
                                                                                'medium' => 'Medium',
                                                                                'high' => 'High',
                                                                            ];
                                                                        @endphp
                                                                        <span
                                                                            class="badge fw-semibold {{ $badgeClass }}">
                                                                            {{ $urgencyTypes[$lead->urgency] }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass = match ($lead->status) {
                                                                                'new'
                                                                                    => 'bg-success-subtle text-success',
                                                                                'contacted'
                                                                                    => 'bg-warning-subtle text-warning',
                                                                                'qualified'
                                                                                    => 'bg-primary-subtle text-primary',
                                                                                'proposal'
                                                                                    => 'bg-info-subtle text-info',
                                                                                'won'
                                                                                    => 'bg-success-subtle text-success',
                                                                                'lost'
                                                                                    => 'bg-danger-subtle text-danger',
                                                                                'nurture'
                                                                                    => 'bg-secondary-subtle text-secondary',
                                                                            };
                                                                        @endphp
                                                                        @php
                                                                            $statusTypes = [
                                                                                'new' => 'New',
                                                                                'contacted' => 'Contacted',
                                                                                'qualified' => 'Qualified',
                                                                                'proposal' => 'Proposal',
                                                                                'won' => 'Won',
                                                                                'lost' => 'Lost',
                                                                                'nurture' => 'Nurtured',
                                                                            ];
                                                                        @endphp

                                                                        <span
                                                                            class="badge fw-semibold {{ $badgeClass }}">
                                                                            {{ $statusTypes[$lead->status] }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('leads.view', $lead->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('leads.edit', $lead->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form style="display: inline-block"
                                                                            action="{{ route('leads.delete', $lead->id) }}"
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

                                </div><!-- end Experience -->

                            </div> <!-- Tab panes -->
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection
