@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid p-3">
            <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Pincode List</h4>
                </div>
                <div>
                    <a href="{{ route('pincodes.create') }}" class="btn btn-primary">Add New Pincode</a>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            <ul class="nav nav-underline justify-content-between border-bottom p-2" id="pills-tab"
                                role="tablist">
                                <div class="fs-18 fw-semibold m-0">
                                    Pincode Lists
                                </div>
                                <div class="row g-3">
                                    <div class="col-12 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-sliders me-1"></i>
                                                {{ ucfirst(str_replace('_', ' ', request()->get('status', 'all'))) }}
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">
                                                {{-- All Status --}}
                                                <li class="dropdown-header">Status Filter</li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->get('all') === 'active' ? 'active' : '' }}"
                                                        href="{{ route('pincodes.index', ['all' => 'active']) }}">
                                                        <i
                                                            class="fa-solid fa-circle me-2 {{ request()->get('all') === 'active' ? 'text-primary' : 'text-muted' }} fs-14"></i>
                                                        All
                                                    </a>
                                                </li>
                                                <li class="dropdown-header">Delivery Status Filter</li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->get('delivery_status') === 'active' ? 'active' : '' }}"
                                                        href="{{ route('pincodes.index', ['delivery_status' => 'active']) }}">
                                                        <i
                                                            class="fa-solid fa-circle me-2 {{ request()->get('delivery_status') === 'active' ? 'text-primary' : 'text-muted' }} fs-14"></i>
                                                        Active
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->get('delivery_status') === 'inactive' ? 'inactive' : '' }}"
                                                        href="{{ route('pincodes.index', ['delivery_status' => 'inactive']) }}">
                                                        <i
                                                            class="fa-solid fa-circle me-2 {{ request()->get('delivery_status') === 'inactive' ? 'text-primary' : 'text-muted' }} fs-14"></i>
                                                        Inactive
                                                    </a>
                                                </li>
                                                <li class="dropdown-header">Installation Status Filter</li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->get('installation_status') === 'active' ? 'active' : '' }}"
                                                        href="{{ route('pincodes.index', ['installation_status' => 'active']) }}">
                                                        <i
                                                            class="fa-solid fa-circle me-2 {{ request()->get('installation_status') === 'active' ? 'text-primary' : 'text-muted' }} fs-14"></i>
                                                        Active
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->get('installation_status') === 'inactive' ? 'inactive' : '' }}"
                                                        href="{{ route('pincodes.index', ['installation_status' => 'inactive']) }}">
                                                        <i
                                                            class="fa-solid fa-circle me-2 {{ request()->get('installation_status') === 'inactive' ? 'text-primary' : 'text-muted' }} fs-14"></i>
                                                        Inactive
                                                    </a>
                                                </li>
                                                <li class="dropdown-header">Repair Status Filter</li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->get('repair_status') === 'active' ? 'active' : '' }}"
                                                        href="{{ route('pincodes.index', ['repair_status' => 'active']) }}">
                                                        <i
                                                            class="fa-solid fa-circle me-2 {{ request()->get('repair_status') === 'active' ? 'text-primary' : 'text-muted' }} fs-14"></i>
                                                        Active
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->get('repair_status') === 'inactive' ? 'inactive' : '' }}"
                                                        href="{{ route('pincodes.index', ['repair_status' => 'inactive']) }}">
                                                        <i
                                                            class="fa-solid fa-circle me-2 {{ request()->get('repair_status') === 'inactive' ? 'text-primary' : 'text-muted' }} fs-14"></i>
                                                        Inactive
                                                    </a>
                                                </li>
                                                <li class="dropdown-header">Quick Service Status Filter</li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->get('quick_service_status') === 'active' ? 'active' : '' }}"
                                                        href="{{ route('pincodes.index', ['quick_service_status' => 'active']) }}">
                                                        <i
                                                            class="fa-solid fa-circle me-2 {{ request()->get('quick_service_status') === 'active' ? 'text-primary' : 'text-muted' }} fs-14"></i>
                                                        Active
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->get('quick_service_status') === 'inactive' ? 'inactive' : '' }}"
                                                        href="{{ route('pincodes.index', ['quick_service_status' => 'inactive']) }}">
                                                        <i
                                                            class="fa-solid fa-circle me-2 {{ request()->get('quick_service_status') === 'inactive' ? 'text-primary' : 'text-muted' }} fs-14"></i>
                                                        Inactive
                                                    </a>
                                                </li>
                                                <li class="dropdown-header">AMC Status Filter</li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->get('amc_status') === 'active' ? 'active' : '' }}"
                                                        href="{{ route('pincodes.index', ['amc_status' => 'active']) }}">
                                                        <i
                                                            class="fa-solid fa-circle me-2 {{ request()->get('amc_status') === 'active' ? 'text-primary' : 'text-muted' }} fs-14"></i>
                                                        Active
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->get('amc_status') === 'inactive' ? 'inactive' : '' }}"
                                                        href="{{ route('pincodes.index', ['amc_status' => 'inactive']) }}">
                                                        <i
                                                            class="fa-solid fa-circle me-2 {{ request()->get('amc_status') === 'inactive' ? 'text-primary' : 'text-muted' }} fs-14"></i>
                                                        Inactive
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
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
                                                                <th>Sr. No.</th>
                                                                <th>Pincode</th>
                                                                <th>Delivery Status</th>
                                                                <th>Installation Status</th>
                                                                <th>Repair Status</th>
                                                                <th>Quick Service Status</th>
                                                                <th>AMC Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($pincode as $pincode)
                                                                <tr>
                                                                    <td>{{ $pincode->id }}</td>
                                                                    <td>{{ $pincode->pincode }}</td>
                                                                    <td>
                                                                        <span
                                                                            class="badge {{ $pincode->delivery == 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fw-semibold">
                                                                            {{ $pincode->delivery == 'active' ? 'Active' : 'Inactive' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge {{ $pincode->installation == 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fw-semibold">
                                                                            {{ $pincode->installation == 'active' ? 'Active' : 'Inactive' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge {{ $pincode->repair == 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fw-semibold">
                                                                            {{ $pincode->repair == 'active' ? 'Active' : 'Inactive' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge {{ $pincode->quick_service == 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fw-semibold">
                                                                            {{ $pincode->quick_service == 'active' ? 'Active' : 'Inactive' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge {{ $pincode->amc == 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fw-semibold">
                                                                            {{ $pincode->amc == 'active' ? 'Active' : 'Inactive' }}
                                                                        </span>
                                                                    </td>

                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('pincodes.edit', $pincode->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form style="display: inline-block"
                                                                            action="{{ route('pincodes.delete', $pincode->id) }}"
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
    </div>
@endsection
