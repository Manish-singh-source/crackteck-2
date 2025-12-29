@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Quick Services</h4>
                </div>
                <div>
                    <a href="{{ route('quick-services.create') }}" class="btn btn-primary">Create Quick Service</a>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- End Main Widgets -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active p-2" id="all_services_tab"
                                            data-bs-toggle="tab" href="#all_services" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                            <span class="d-none d-sm-block">All Quick Services</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>

                            <div class="tab-content text-muted">
                                <div class="tab-pane active show" id="all_services" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table class="table table-striped table-borderless table-hover" id="datatable">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:100px;">Service ID</th>
                                                                <th style="width:120px;">Service Image</th>
                                                                <th>Service Name</th>
                                                                <th style="width:150px;">Min Service Price</th>
                                                                <th>Service Description</th>
                                                                <th style="width:120px;">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($quickServices as $service)
                                                                <tr>
                                                                    <td>#{{ $service->id }}</td>
                                                                    <td>
                                                                        @if($service->service_image)
                                                                            <img src="{{ asset($service->service_image) }}"
                                                                                 alt="{{ $service->name }}"
                                                                                 width="80px"
                                                                                 class="img-fluid d-block rounded">
                                                                        @else
                                                                            <img src="https://placehold.co/80x80?text=No+Image"
                                                                                 alt="No Image"
                                                                                 width="80px"
                                                                                 class="img-fluid d-block rounded">
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $service->name }}</td>
                                                                    <td>₹{{ number_format($service->service_price, 2) }}</td>
                                                                    <td>{{ Str::limit($service->service_description, 50) }}</td>
                                                                    <td>
                                                                        <a aria-label="Edit"
                                                                            href="{{ route('quick-services.edit', $service->id) }}"
                                                                            class="btn btn-icon btn-sm bg-warning-subtle me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit">
                                                                            <i class="mdi mdi-pencil-outline fs-14 text-warning"></i>
                                                                        </a>
                                                                        <form action="{{ route('quick-services.destroy', $service->id) }}"
                                                                              method="POST"
                                                                              class="d-inline"
                                                                              onsubmit="return confirm('Are you sure you want to delete this quick service?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                    aria-label="Delete"
                                                                                    class="btn btn-icon btn-sm bg-danger-subtle"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-original-title="Delete">
                                                                                <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6" class="text-center text-muted py-4">
                                                                        <div class="py-4">
                                                                            <h5 class="mt-4">No Quick Services Found</h5>
                                                                            <p>Start by creating your first quick service.</p>
                                                                        </div>
                                                                    </td>
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
