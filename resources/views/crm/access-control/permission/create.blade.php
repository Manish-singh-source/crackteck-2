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


            <div class="row py-3">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('permission.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="card-header">
                                <h5 class="card-title mb-0">Create Permission</h5>
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
                                    {{-- <a href="{{ route('roles.index') }}" class="btn btn-success waves ripple-light"
                                    id="add-btn">
                                    Add
                                </a> --}}
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
