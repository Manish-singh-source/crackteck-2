@extends('warehouse/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Warehouses List</h4>
                </div>
                <div>
                    <a href="{{ route('warehouse-list.create') }}" class="btn btn-primary">Create Warehouse</a>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">

                            <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active p-2" id="all_amc_tab" data-bs-toggle="tab" href="#all_amc"
                                        role="tab">
                                        <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                        <span class="d-none d-sm-block">All Warehouses</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content text-muted">
                                <div class="tab-pane active show pt-4" id="all_amc" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Warehouse Code</th>
                                                                <th>Name</th>
                                                                <th>Type</th>
                                                                <th>Address</th>
                                                                <th>Contact Person</th>
                                                                <th>Contact Detail</th>
                                                                <th>Default</th>
                                                                <th>Verified</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $status = ['0' => 'Inactive', '1' => 'Active'];
                                                                $badge = [
                                                                    '0' => 'bg-danger-subtle text-danger',
                                                                    '1' => 'bg-success-subtle text-success',
                                                                ];

                                                                $default = ['0' => 'No', '1' => 'Yes'];
                                                                $defaultBadge = [
                                                                    '0' => 'bg-danger-subtle text-danger',
                                                                    '1' => 'bg-success-subtle text-success',
                                                                ];

                                                                $verificationStatus = [
                                                                    '0' => 'Pending',
                                                                    '1' => 'Verified',
                                                                    '2' => 'Rejected',
                                                                ];
                                                                $verificationBadge = [
                                                                    '0' => 'bg-danger-subtle text-danger',
                                                                    '1' => 'bg-success-subtle text-success',
                                                                    '2' => 'bg-warning-subtle text-warning',
                                                                ];
                                                            @endphp
                                                            @foreach ($warehouses as $warehouse)
                                                                <tr>
                                                                    <td>
                                                                        {{ $warehouse->id }}
                                                                    </td>
                                                                    <td>{{ $warehouse->warehouse_code }}</td>
                                                                    <td>{{ $warehouse->name }}</td>
                                                                    <td>{{ $warehouse->type }}</td>
                                                                    <td>{{ $warehouse->address1 }}</td>
                                                                    <td>{{ $warehouse->contact_person_name }}</td>
                                                                    <td>{{ $warehouse->phone_number }}</td>
                                                                    <td>
                                                                        <span
                                                                            class="badge {{ $defaultBadge[$warehouse->default_warehouse] }} fw-semibold">{{ $default[$warehouse->default_warehouse] }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge {{ $verificationBadge[$warehouse->verification_status] }} fw-semibold">{{ $verificationStatus[$warehouse->verification_status] }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge {{ $badge[$warehouse->status] }} fw-semibold">{{ $status[$warehouse->status] }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('warehouses-list.view', $warehouse->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('warehouses-list.edit', $warehouse->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form style="display: inline-block"
                                                                            action="{{ route('warehouse.delete', $warehouse->id) }}"
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
            </div>
        </div>
    @endsection
