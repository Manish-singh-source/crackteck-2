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

                            <div class="tab-content text-muted">

                                <div class="tab-pane active show pt-4" id="all_staff" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">

                                                    {{-- ROLE FILTER DROPDOWN --}}
                                                    <div
                                                        class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                                        <h5 class="mb-0">Staff</h5>
                                                        <div class="d-flex align-items-center" id="role-filter-wrapper">
                                                            <label for="role-filter-select"
                                                                class="form-label visually-hidden">Filter by role</label>
                                                            <select id="role-filter-select" class="form-select w-auto">
                                                                <option value="all">All ({{ $staffs->count() }})</option>
                                                                @foreach ($roles as $role)
                                                                    <option value="{{ $role->name }}">{{ $role->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
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
                                                                        {{ $staff->staff_role }}
                                                                    </td>
                                                                    <td>{{ $staff->first_name }} {{ $staff->last_name }}
                                                                    </td>
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
                                                                            <i
                                                                                class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                        </a>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('staff.edit', $staff->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
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

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#responsive-datatable').DataTable();

            $('#role-filter-select').on('change', function() {
                var selectedRole = $(this).val();

                if (selectedRole === 'all') {
                    table.columns(1).search('').draw(); 
                } else {
                    table.columns(1).search('^' + selectedRole + '$', true, false)
                .draw(); 
                }
            });
        });
    </script>
@endsection
