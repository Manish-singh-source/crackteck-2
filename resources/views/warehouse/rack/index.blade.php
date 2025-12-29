@extends('warehouse/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Rack List</h4>
                </div>
                <div>
                    <a href="{{ route('rack.create') }}" class="btn btn-primary">Create Rack</a>
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
                                        <span class="d-none d-sm-block">All Racks</span>
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
                                                                <th>Warehouse Name</th>
                                                                <th>Rack No</th>
                                                                <th>Level No</th>
                                                                <th>Position No</th>
                                                                <th>Storage Quantity</th>
                                                                <th>Filled Quantity</th>
                                                                <th>Stored Date</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($warehouse_racks as $warehouse_rack)
                                                                <tr>
                                                                    <td>
                                                                        {{ $warehouse_rack->warehouse?->name ?? 'N/A' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $warehouse_rack->zone_area }} -
                                                                        {{ $warehouse_rack->rack_no }}
                                                                    </td>
                                                                    <td>{{ $warehouse_rack->level_no }}</td>
                                                                    <td>{{ $warehouse_rack->position_no }}</td>
                                                                    <td>{{ $warehouse_rack->quantity }}</td>
                                                                    <td>{{ $warehouse_rack->filled_quantity ?? 0 }}</td>
                                                                    <td>{{ $warehouse_rack->created_at?->format('d M Y') ?? '' }}</td>
                                                                     <td>
                                                                        <span
                                                                            class="badge {{ $warehouse_rack->filled_quantity < $warehouse_rack->quantity ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fw-semibold">{{ $warehouse_rack->filled_quantity < $warehouse_rack->quantity ? 'Available' : 'Filled' }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('rack.edit', $warehouse_rack->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form style="display: inline-block"
                                                                            action="{{ route('rack.delete', $warehouse_rack->id) }}"
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
