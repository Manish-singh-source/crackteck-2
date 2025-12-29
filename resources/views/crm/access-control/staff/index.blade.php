@extends('crm.layouts.master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Staff List</h4>
                </div>
                <div>
                    <a href="{{ route('staff.create') }}" class="btn btn-primary">Add New Staff</a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            {{-- <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active p-2" id="all_staff_tab" data-bs-toggle="tab"
                                       href="#all_staff" role="tab">
                                        <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                        <span class="d-none d-sm-block">All</span>
                                    </a>
                                </li>
                            </ul> --}}

                            <div class="tab-content text-muted">

                                <div class="tab-pane active show pt-4" id="all_staff" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">

                                                    {{-- ROLE FILTER BAR --}}
                                                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                                        <h5 class="mb-0">Staff</h5>
                                                        <div class="d-flex flex-wrap gap-2" id="role-filter-wrapper">
                                                            <button type="button"
                                                                    class="btn btn-light border rounded-pill px-3 py-1 active"
                                                                    data-role-filter="all">
                                                                <span class="me-1">All</span>
                                                                <span class="badge bg-primary-subtle text-primary">
                                                                    {{ $staffs->count() }}
                                                                </span>
                                                            </button>

                                                            <button type="button"
                                                                    class="btn btn-light border rounded-pill px-3 py-1"
                                                                    data-role-filter="Admin">
                                                                <span class="me-1">Admin</span>
                                                            </button>

                                                            <button type="button"
                                                                    class="btn btn-light border rounded-pill px-3 py-1"
                                                                    data-role-filter="Engineer">
                                                                <span class="me-1">Engineer</span>
                                                            </button>

                                                            <button type="button"
                                                                    class="btn btn-light border rounded-pill px-3 py-1"
                                                                    data-role-filter="Delivery Man">
                                                                <span class="me-1">Delivery</span>
                                                            </button>

                                                            <button type="button"
                                                                    class="btn btn-light border rounded-pill px-3 py-1"
                                                                    data-role-filter="Sales Person">
                                                                <span class="me-1">Sales</span>
                                                            </button>

                                                            <button type="button"
                                                                    class="btn btn-light border rounded-pill px-3 py-1"
                                                                    data-role-filter="Customer">
                                                                <span class="me-1">Customer</span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    {{-- TABLE --}}
                                                    <table id="responsive-datatable"
                                                           class="table table-hover align-middle mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th class="text-nowrap">Staff Code</th>
                                                                <th class="text-nowrap">Role</th>
                                                                <th class="text-nowrap">Name</th>
                                                                <th class="text-nowrap">Phone</th>
                                                                <th class="text-nowrap">Email</th>
                                                                <th class="text-nowrap">Employment Type</th>
                                                                <th class="text-nowrap">Status</th>
                                                                <th class="text-nowrap text-center">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($staffs as $staff)
                                                                <tr>
                                                                    <td>{{ $staff->staff_code }}</td>
                                                                    <td>
                                                                        @if ($staff->staff_role == 0)
                                                                            Admin
                                                                        @elseif ($staff->staff_role == 1)
                                                                            Engineer
                                                                        @elseif ($staff->staff_role == 2)
                                                                            Delivery Man
                                                                        @elseif ($staff->staff_role == 3)
                                                                            Sales Person
                                                                        @elseif ($staff->staff_role == 4)
                                                                            Customer
                                                                        @else
                                                                            Unknown
                                                                        @endif
                                                                    </td>

                                                                    <td>{{ $staff->first_name }} {{ $staff->last_name }}</td>
                                                                    <td>{{ $staff->phone }}</td>
                                                                    <td>{{ $staff->email }}</td>
                                                                    <td>
                                                                        @if ($staff->employment_type == 0)
                                                                            Full-time
                                                                        @elseif ($staff->employment_type == 1)
                                                                            Part-time
                                                                        @else
                                                                            Unknown
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $statusMap = [
                                                                                0 => 'Inactive',
                                                                                1 => 'Active',
                                                                                2 => 'Resigned',
                                                                                3 => 'Terminated',
                                                                                4 => 'Blocked',
                                                                                5 => 'Suspended',
                                                                                6 => 'Pending',
                                                                            ];
                                                                        @endphp
                                                                        {{ $statusMap[$staff->status] ?? 'Unknown' }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a aria-label="anchor"
                                                                           href="{{ route('staff.view', $staff->id) }}"
                                                                           class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-original-title="View">
                                                                            <i class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                           href="{{ route('staff.edit', $staff->id) }}"
                                                                           class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-original-title="Edit">
                                                                            <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form style="display: inline-block"
                                                                              action="{{ route('staff.delete', $staff->id) }}"
                                                                              method="POST"
                                                                              onsubmit="return confirm('Are you sure?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Delete">
                                                                                <i class="mdi mdi-delete fs-14 text-danger"></i>
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
                                </div><!-- end all_staff -->

                                {{-- your other demo tabs (admins/managers/technicians) can stay or be removed --}}

                            </div> <!-- Tab panes -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('[data-role-filter]');
        const table   = document.getElementById('responsive-datatable');
        if (!table) return;

        // Staff Code(0), Role(1), ...
        const ROLE_COL_INDEX = 1;

        buttons.forEach(btn => {
            btn.addEventListener('click', function () {
                // reset styles
                buttons.forEach(b => {
                    b.classList.remove('active', 'btn-primary', 'text-white');
                    b.classList.add('btn-light', 'border');
                });

                // active style
                this.classList.remove('btn-light', 'border');
                this.classList.add('active', 'btn-primary', 'text-white');

                const filterRole = this.getAttribute('data-role-filter');
                const rows = table.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const roleCell = row.children[ROLE_COL_INDEX];
                    if (!roleCell) return;

                    const roleText = roleCell.textContent.trim();
                    const visible = (filterRole === 'all' || roleText === filterRole);

                    row.style.display = visible ? '' : 'none';
                });
            });
        });
    });
</script>
@endsection
