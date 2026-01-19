@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Collections</h4>
                </div>
                <div class="text-end">
                    <a href="{{ route('collection.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Collection
                    </a>
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
                        <div class="card-body">
                            @php
                                $statuses = [
                                    'all' => [
                                        'label' => 'All',
                                        'icon' => 'mdi-format-list-bulleted',
                                        'color' => 'text-secondary',
                                    ],
                                    'active' => [
                                        'label' => 'Active',
                                        'icon' => 'mdi-check-circle',
                                        'color' => 'text-success',
                                    ],
                                    'inactive' => [
                                        'label' => 'Inactive',
                                        'icon' => 'mdi-close-circle',
                                        'color' => 'text-danger',
                                    ],
                                ];

                                $currentStatus = request()->get('status', 'all');
                            @endphp

                            <ul class="nav nav-underline border-bottom" role="tablist">
                                @foreach ($statuses as $key => $status)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $currentStatus === $key ? 'active' : '' }} p-2"
                                            href="{{ route('collection.index', $key !== 'all' ? ['status' => $key] : []) }}">

                                            <span class="d-block d-sm-none">
                                                <i class="mdi {{ $status['icon'] }} fs-16 {{ $status['color'] }}"></i>
                                            </span>

                                            <span class="d-none d-sm-block">
                                                <i class="mdi {{ $status['icon'] }} fs-16 me-1 {{ $status['color'] }}"></i>
                                                {{ $status['label'] }}
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
                                                                <th>#</th>
                                                                <th>Image</th>
                                                                <th>Collection Name</th>
                                                                <th>Categories Count</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($collections as $index => $collection)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>
                                                                        @if ($collection->image_url)
                                                                            <img src="{{ asset($collection->image_url) }}"
                                                                                alt="{{ $collection->name }}"
                                                                                class="img-fluid rounded"
                                                                                style="width: 80px; height: 80px; object-fit: cover;">
                                                                        @else
                                                                            <img src="{{ asset('images/default-collection.png') }}"
                                                                                alt="Default" class="img-fluid rounded"
                                                                                style="width: 80px; height: 80px; object-fit: cover;">
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ ucwords($collection->name) }}</td>
                                                                    <td>
                                                                        <span class="badge bg-info-subtle text-info">
                                                                            {{ $collection->categories->count() }}
                                                                            categories
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge bg-info-subtle fw-semibold {{ $statuses[$collection->status]['color'] }}">
                                                                            {{ ucfirst($statuses[$collection->status]['label']) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a aria-label="anchor"
                                                                            href="{{ route('collection.edit', $collection->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit Collection">
                                                                            <i
                                                                                class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form style="display: inline-block"
                                                                            action="{{ route('collection.delete', $collection->id) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Are you sure you want to delete this collection?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" aria-label="Delete"
                                                                                class="btn btn-icon btn-sm bg-danger-subtle"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Delete Collection">
                                                                                <i
                                                                                    class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6" class="text-center">No collections
                                                                        found.</td>
                                                                </tr>
                                                            @endforelse
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
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    @endsection
