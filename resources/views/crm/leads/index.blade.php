@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Leads</h4>
                </div>
                <div>
                    <a href="{{ route('leads.create') }}" class="btn btn-primary">Add New Leads</a>
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
                                        <span class="d-none d-sm-block">All Leads</span>
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
                                                                <th>Lead Id</th>
                                                                <th>Sales Person</th>
                                                                <th>Customer Name</th>
                                                                <th>Contact No</th>
                                                                <th>Company Name</th>
                                                                <th>Industry</th>
                                                                <th>Source</th>
                                                                <th>Requirement</th>
                                                                <th>Budget</th>
                                                                <th>Urgency</th>
                                                                <th>Status</th>
                                                                <th>Created By</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($lead as $lead)
                                                                <tr>
                                                                    <td>{{ $lead->id }}</td>
                                                                    <td>{{ $lead->user->first_name }}</td>
                                                                    <td>{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                                                    <td>{{ $lead->phone }}</td>
                                                                    <td>{{ $lead->company_name }}</td>
                                                                    <td>{{ $lead->industry_type }}</td>
                                                                    <td>{{ $lead->source }}</td>
                                                                    <td>{{ $lead->requirement_type }}</td>
                                                                    <td>{{ $lead->budget_range }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass = match ($lead->urgency) {
                                                                                'Low' => 'bg-success-subtle text-success',
                                                                                'Medium' => 'bg-warning-subtle text-warning',
                                                                                'High' => 'bg-danger-subtle text-danger',
                                                                                default => 'bg-secondary-subtle text-secondary',
                                                                            };
                                                                        @endphp
                                                                        <span
                                                                            class="badge fw-semibold {{ $badgeClass }}">
                                                                            {{ $lead->urgency }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass = match ($lead->status) {
                                                                                'New'
                                                                                    => 'bg-success-subtle text-success',
                                                                                'Contacted'
                                                                                    => 'bg-warning-subtle text-warning',
                                                                                'Qualified'
                                                                                    => 'bg-primary-subtle text-primary',
                                                                                'Quoted' => 'bg-info-subtle text-info',
                                                                                'Lost'
                                                                                    => 'bg-danger-subtle text-danger',
                                                                                default
                                                                                    => 'bg-secondary-subtle text-secondary',
                                                                            };
                                                                        @endphp

                                                                        <span
                                                                            class="badge fw-semibold {{ $badgeClass }}">
                                                                            {{ $lead->status }}
                                                                        </span>
                                                                    </td>
                                                                    <td>Super Admin</td>

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
