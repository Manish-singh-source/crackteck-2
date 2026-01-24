@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">AMC Plans List</h4>
                </div>
                <div>
                    <a href="{{ route('amc-plan.create') }}" class="btn btn-primary">Add Plan</a>
                    <!-- <button class="btn btn-primary">Add New Staff</button> -->
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            @php
                                $statuses = [
                                    'all' => ['label' => 'All', 'icon' => 'mdi-format-list-bulleted', 'color' => ''],
                                    'active' => [
                                        'label' => 'Active',
                                        'icon' => 'mdi-check-circle-outline',
                                        'color' => 'text-success',
                                    ],
                                    'inactive' => [
                                        'label' => 'Inactive',
                                        'icon' => 'mdi-close-circle-outline',
                                        'color' => 'text-danger',
                                    ],
                                ];

                                $currentStatus = request()->get('status') ?? 'all';
                            @endphp

                            <ul class="nav nav-underline border-bottom" id="pills-tab" role="tablist">
                                @foreach ($statuses as $key => $status)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $currentStatus === $key ? 'active' : '' }} p-2"
                                            href="{{ $key === 'all' ? route('amc-plans.index') : route('amc-plans.index', ['status' => $key]) }}">
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
                                <div class="tab-pane active show pt-4" id="all_active" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr. No.</th>
                                                                <th>Plan Name</th>
                                                                <th>Plan Code</th>
                                                                <th>Duration</th>
                                                                <th>Plan Services</th>
                                                                <th>Plan Price</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($amcPlans as $amc)
                                                                <tr>
                                                                    <td>{{ $amc->id }} </td>
                                                                    <td>{{ $amc->plan_name }}</td>
                                                                    <td>{{ $amc->plan_code }}</td>
                                                                    <td>{{ $amc->duration }} months</td>
                                                                    <td>
                                                                        <ul>
                                                                            @php
                                                                                // $items = json_decode(
                                                                                //     $amc->covered_items,
                                                                                //     true,
                                                                                // );
                                                                                if (!is_array($amc->covered_items)) {
                                                                                    $amc->covered_items = json_decode(
                                                                                        $amc->covered_items,
                                                                                        true,
                                                                                    );
                                                                                }
                                                                            @endphp

                                                                            @if (is_array($amc->covered_items))
                                                                                @foreach ($amc->covered_items as $item)
                                                                                    @php
                                                                                        $item = DB::table(
                                                                                            'covered_items',
                                                                                        )->find($item);
                                                                                    @endphp
                                                                                    <li>{{ ucwords($item->service_name) }}
                                                                                    </li>
                                                                                @endforeach
                                                                            @else
                                                                                <li>No services listed</li>
                                                                            @endif
                                                                        </ul>
                                                                    </td>
                                                                    <td>₹{{ $amc->total_cost }}/year</td>
                                                                    <td>
                                                                        @php
                                                                            $status =
                                                                                $amc->status == 'active'
                                                                                    ? 'Active'
                                                                                    : 'Inactive';
                                                                        @endphp
                                                                        <span
                                                                            class="badge {{ $amc->status == 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fw-semibold">
                                                                            {{ $status }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex gap-2">
                                                                            <a aria-label="anchor"
                                                                                href="{{ route('amc-plan.edit', $amc->id) }}"
                                                                                class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Edit">
                                                                                <i
                                                                                    class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                            </a>
                                                                            <form style="display: inline-block"
                                                                                action="{{ route('amc-plan.delete', $amc->id) }}"
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
                                                                        </div>
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
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection
