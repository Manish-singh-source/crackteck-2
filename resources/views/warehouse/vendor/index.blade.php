@extends('warehouse/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Vendor List</h4>
                </div>
                <div>
                    <a href="{{ route('vendor_list.create') }}" class="btn btn-primary">Add Vendor</a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request()->get('status') === 'all' || request()->get('status') === null ? 'active' : '' }} p-2"
                                        href="{{ route('vendor_list.index') }}">
                                        <span class="d-block d-sm-none"><i class="mdi mdi-format-list-bulleted fs-16 me-1"></i></span>
                                        <span class="d-none d-sm-block"><i class="mdi mdi-format-list-bulleted fs-16 me-1"></i>All</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request()->get('status') === 'active' ? 'active' : '' }} p-2"
                                        href="{{ route('vendor_list.index', ['status' => 'active']) }}">
                                        <span class="d-block d-sm-none"><i class="mdi mdi-check-circle-outline fs-16 me-1 text-success"></i></span>
                                        <span class="d-none d-sm-block"><i class="mdi mdi-check-circle-outline fs-16 me-1 text-success"></i>Active</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request()->get('status') === 'inactive' ? 'active' : '' }} p-2"
                                        href="{{ route('vendor_list.index', ['status' => 'inactive']) }}">
                                        <span class="d-block d-sm-none"><i class="mdi mdi-close-circle-outline fs-16 me-1 text-danger"></i></span>
                                        <span class="d-none d-sm-block"><i class="mdi mdi-close-circle-outline fs-16 me-1 text-danger"></i>Inactive</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content text-muted">
                                <div class="tab-pane active show" id="all_vendors" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Vendor Code</th>
                                                                <th>First Name</th>
                                                                <th>Last Name</th>
                                                                <th>Phone</th>
                                                                <th>Email</th>
                                                                <th>GST No</th>
                                                                {{-- <th>No of PO</th> --}}
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($vendors as $vendor)
                                                                <tr>
                                                                    <td>{{ $vendor->id }}</td>
                                                                    <td>{{ $vendor->vendor_code }}</td>
                                                                    <td>{{ $vendor->first_name }}</td>
                                                                    <td>{{ $vendor->last_name }}</td>
                                                                    <td>{{ $vendor->phone }}</td>
                                                                    <td>{{ $vendor->email }}</td>
                                                                    <td>{{ $vendor->gst_no }}</td>
                                                                    {{-- <td>{{ $vendor->no_of_po ? $vendor->no_of_po : 'N/A' }}</td> --}}
                                                                    <td>
                                                                        <span
                                                                            class="badge bg-{{ $vendor->status == 'active' ? 'success' : 'danger' }}-subtle text-{{ $vendor->status == 'active' ? 'success' : 'danger' }} fw-semibold">
                                                                            {{ $vendor->status == 'active' ? 'Active' : 'Inactive' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('vendor_list.edit', $vendor->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('vendor_list.destroy', $vendor->id) }}"
                                                                            method="POST" style="display: inline;"
                                                                            onsubmit="return confirm('Are you sure you want to delete this vendor?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" aria-label="anchor"
                                                                                class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Delete">
                                                                                <i
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
        @endsection
