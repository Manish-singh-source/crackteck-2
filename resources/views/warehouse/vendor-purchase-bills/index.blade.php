@extends('warehouse/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Vendor Purchase Bills</h4>
                </div>
                <div>
                    <a href="{{ route('vendor.create') }}" class="btn btn-primary">Add Vendor Bill</a>
                </div>
            </div>


            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">

                            <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">

                                {{-- All --}}
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request('po_status') === null || request('po_status') === 'all' ? 'active' : '' }} p-2"
                                        href="{{ route('vendor.index') }}">
                                        <span class="d-block d-sm-none">
                                            <i class="mdi mdi-store fs-16 me-1"></i>
                                        </span>
                                        <span class="d-none d-sm-block">
                                            <i class="mdi mdi-store fs-16 me-1"></i> All
                                        </span>
                                    </a>
                                </li>

                                {{-- Pending --}}
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request('po_status') === 'pending' ? 'active' : '' }} p-2"
                                        href="{{ route('vendor.index', ['po_status' => 'pending']) }}">
                                        <span class="d-block d-sm-none">
                                            <i class="mdi mdi-clock-outline fs-16 me-1 text-warning"></i>
                                        </span>
                                        <span class="d-none d-sm-block">
                                            <i class="mdi mdi-clock-outline fs-16 me-1 text-warning"></i> Pending
                                        </span>
                                    </a>
                                </li>

                                {{-- Approved --}}
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request('po_status') === 'approved' ? 'active' : '' }} p-2"
                                        href="{{ route('vendor.index', ['po_status' => 'approved']) }}">
                                        <span class="d-block d-sm-none">
                                            <i class="mdi mdi-check-circle-outline fs-16 me-1 text-success"></i>
                                        </span>
                                        <span class="d-none d-sm-block">
                                            <i class="mdi mdi-check-circle-outline fs-16 me-1 text-success"></i> Approved
                                        </span>
                                    </a>
                                </li>

                                {{-- Rejected --}}
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request('po_status') === 'rejected' ? 'active' : '' }} p-2"
                                        href="{{ route('vendor.index', ['po_status' => 'rejected']) }}">
                                        <span class="d-block d-sm-none">
                                            <i class="mdi mdi-close-circle-outline fs-16 me-1 text-danger"></i>
                                        </span>
                                        <span class="d-none d-sm-block">
                                            <i class="mdi mdi-close-circle-outline fs-16 me-1 text-danger"></i> Rejected
                                        </span>
                                    </a>
                                </li>

                                {{-- Cancelled --}}
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request('po_status') === 'cancelled' ? 'active' : '' }} p-2"
                                        href="{{ route('vendor.index', ['po_status' => 'cancelled']) }}">
                                        <span class="d-block d-sm-none">
                                            <i class="mdi mdi-cancel fs-16 me-1 text-secondary"></i>
                                        </span>
                                        <span class="d-none d-sm-block">
                                            <i class="mdi mdi-cancel fs-16 me-1 text-secondary"></i> Cancelled
                                        </span>
                                    </a>
                                </li>

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
                                                                <th>Vendor Name</th>
                                                                <th>PO Number</th>
                                                                <th>Invoice Number</th>
                                                                <th>Purchase Date</th>
                                                                <th>Po Amount</th>
                                                                <th>PO Amount Paid</th>
                                                                <th>PO Amount Pending</th>
                                                                <th>Payment Status</th>
                                                                <th>Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $status = [
                                                                    'pending' => 'Pending',
                                                                    'approved' => 'Approved',
                                                                    'rejected' => 'Rejected',
                                                                    'cancelled' => 'Cancelled',
                                                                ];
                                                                $badge = [
                                                                    'pending' => 'warning',
                                                                    'approved' => 'success',
                                                                    'rejected' => 'danger',
                                                                    'cancelled' => 'secondary',
                                                                ];
                                                            @endphp
                                                            @forelse($vendorPurchaseBills as $bill)
                                                                <tr class="align-middle">
                                                                    {{-- First Name Last Name  --}}
                                                                    <td>{{ $bill->vendor->first_name . ' ' . $bill->vendor->last_name }}
                                                                    </td>
                                                                    <td>{{ $bill->po_number }}</td>
                                                                    <td>{{ $bill->invoice_number }}</td>
                                                                    <td>{{ $bill->purchase_date }}</td>
                                                                    <td>{{ $bill->po_amount }}</td>
                                                                    <td>{{ $bill->po_amount_paid }}</td>
                                                                    <td>{{ $bill->po_amount_pending }}</td>
                                                                    <td>
                                                                        <span
                                                                            class="badge bg-{{ $badge[$bill->po_status] ?? 'secondary' }}-subtle text-{{ $badge[$bill->po_status] ?? 'secondary' }} fw-semibold">{{ $status[$bill->po_status] ?? 'Unknown' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('vendor.view', $bill->id) }}"
                                                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View">
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('vendor.edit', $bill->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('vendor.destroy', $bill->id) }}"
                                                                            method="POST" style="display: inline;"
                                                                            onsubmit="return confirm('Are you sure you want to delete this vendor purchase bill?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" aria-label="anchor"
                                                                                class="btn btn-icon btn-sm bg-danger-subtle"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Delete">
                                                                                <i
                                                                                    class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9" class="text-center">No vendor
                                                                        purchase bills found.</td>
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
