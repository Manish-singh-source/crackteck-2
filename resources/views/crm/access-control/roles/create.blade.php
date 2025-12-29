@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0"></h4>
                </div>
            </div>


            <div class="row">
                <div class="col-12 py-4">
                    <div class="card">
                        <form action="{{ route('role.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="card-header">
                                <h5 class="card-title mb-0">Create Role</h5>
                            </div><!-- end card header -->
                            <div class="card-body">
                                <div>
                                    @include('components.form.input', [
                                        'label' => 'Name',
                                        'name' => 'name',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Name',
                                    ])
                                </div>

                                <div class="mt-3">
                                    <h5>
                                        Permissions
                                    </h5>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="border rounded p-3">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <h6 class="mb-0">
                                                        Admin
                                                    </h6>
                                                </div>

                                                <div class="row g-3">
                                                    @foreach ($permissions as $permission)
                                                        <div class="col-md-2">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                                <label class="mb-0">
                                                                    {{ $permission->name }}
                                                                </label>
                                                                <div class="form-check form-switch">
                                                                    <input type="checkbox" value="{{ $permission->name }}"
                                                                        name="permission[]" class="form-check-input"
                                                                        id="view_admin">
                                                                    <label class="form-check-label"
                                                                        for="view_admin"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection
