@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Contacts List</h4>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body pt-0">
                            <ul class="nav nav-underline border-bottom" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active p-2"
                                        href="{{ route('contact.index') }}">
                                        <span class="d-block d-sm-none">
                                            <i class="mdi mdi-format-list-bulleted fs-16 me-1 text-primary"></i>
                                        </span>
                                        <span class="d-none d-sm-block">
                                            <i class="mdi mdi-format-list-bulleted fs-16 me-1 text-primary"></i>All
                                        </span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content text-muted">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <table id="responsive-datatable"
                                                    class="table table-striped table-borderless dt-responsive nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Message</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($contacts as $contact)
                                                            <tr>
                                                                <td>{{ $contact->first_name }} {{ $contact->last_name }}
                                                                </td>
                                                                <td>{{ $contact->email }}</td>
                                                                <td>{{ $contact->phone }}</td>
                                                                <td>{{ $contact->description }}</td>
                                                                <td>
                                                                    <a aria-label="anchor"
                                                                        href="{{ route('contact.view', $contact->id) }}"
                                                                        class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-original-title="View">
                                                                        <i
                                                                            class="mdi mdi-eye-outline fs-14 text-primary"></i>
                                                                    </a>
                                                                    <form style="display: inline-block"
                                                                        action="{{ route('contact.delete', $contact->id) }}"
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
                            </div> <!-- Tab panes -->
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection
