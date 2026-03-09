@extends('crm/layouts.master')

@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Profile</h4>
            </div>

            <!-- <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Components</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div> -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="align-items-center">

                            <div class="hando-main-sections">
                                <div class="hando-profile-main">
                                    <img src="{{ Auth::guard('staff_web')->user()->avatar ?? asset('assets/images/users/user-13.jpg') }}" class="rounded-circle img-fluid avatar-xxl img-thumbnail float-start" alt="image profile">

                                    <span class="sil-profile_main-pic-change img-thumbnail">
                                        <i class="mdi mdi-camera text-white"></i>
                                    </span>
                                </div>

                                <div class="overflow-hidden ms-md-4 ms-0">
                                    <h4 class="m-0 text-dark fs-20 my-2 mt-md-0">{{ Auth::guard('staff_web')->user()->first_name .' '. Auth::guard('staff_web')->user()->last_name ?? 'Guest' }}</h4>
                                    {{-- <p class="my-1 text-muted fs-16">
                                        <span class="badge bg-primary-subtle text-primary px-2 py-1 fs-13 fw-normal">
                                            Superadmin
                                        </span>
                                    </p> --}}
                                    <p>
                                        <span class="fw-bold">Contact No:</span> {{ Auth::guard('staff_web')->user()->phone }}
                                        <br>
                                        <span class="fw-bold">E-mail:</span> {{ Auth::guard('staff_web')->user()->email }}
                                    </p>
                                    <p>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pt-0">
                        <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active p-2" id="setting_tab" data-bs-toggle="tab" href="#profile_setting" role="tab">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                    <span class="d-none d-sm-block">Setting</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content text-muted">
                            <div class="tab-pane active pt-4" id="profile_setting" role="tabpanel">
                                <div class="row">

                                    <div class="row">
                                        <div class="col-lg-6 col-xl-6">
                                            <div class="card border">

                                                <div class="card-header">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <h4 class="card-title mb-0">Personal Information</h4>
                                                        </div><!--end col-->
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <form action="{{ route('staff.profile.update') }}" method="POST">
                                                        @csrf
                                                        <div class="form-group mb-3 row">
                                                            <label class="form-label">First Name</label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <input class="form-control" type="text" 
                                                                    name="first_name"
                                                                    value="{{ Auth::guard('staff_web')->user()->first_name }}"
                                                                    {{ Auth::guard('staff_web')->user()->first_name ? 'readonly' : '' }}>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3 row">
                                                            <label class="form-label">Last Name</label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <input class="form-control" type="text" 
                                                                    name="last_name"
                                                                    value="{{ Auth::guard('staff_web')->user()->last_name }}"
                                                                    {{ Auth::guard('staff_web')->user()->last_name ? 'readonly' : '' }}>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3 row">
                                                            <label class="form-label">Contact Phone</label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><i class="mdi mdi-phone-outline"></i></span>
                                                                    <input class="form-control" type="text" 
                                                                        name="phone"
                                                                        placeholder="Phone" 
                                                                        value="{{ Auth::guard('staff_web')->user()->phone }}"
                                                                        {{ Auth::guard('staff_web')->user()->phone ? 'readonly' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3 row">
                                                            <label class="form-label">Email Address</label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                                                                    <input type="text" class="form-control" 
                                                                        name="email"
                                                                        value="{{ Auth::guard('staff_web')->user()->email }}"
                                                                        placeholder="Email" 
                                                                        {{ Auth::guard('staff_web')->user()->email ? 'readonly' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3 row">
                                                            <div class="text-end">
                                                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div><!--end card-body-->
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-xl-6">
                                            <div class="card border mb-0">

                                                <div class="card-header">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <h4 class="card-title mb-0">Change Password</h4>
                                                        </div><!--end col-->
                                                    </div>
                                                </div>

                                                <div class="card-body mb-0">
                                                    <form action="{{ route('staff.password.update') }}" method="POST" id="passwordForm">
                                                        @csrf
                                                        
                                                        @php
                                                            $hasPassword = !empty(Auth::guard('staff_web')->user()->password);
                                                        @endphp
                                                        
                                                        @if($hasPassword)
                                                        <div class="form-group mb-3 row">
                                                            <label class="form-label">Old Password</label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <input class="form-control" type="password" name="old_password" placeholder="Old Password">
                                                            </div>
                                                        </div>
                                                        @endif
                                                        
                                                        <div class="form-group mb-3 row">
                                                            <label class="form-label">New Password</label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <input class="form-control" type="password" name="new_password" placeholder="New Password">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3 row">
                                                            <label class="form-label">Confirm Password</label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <input class="form-control" type="password" name="new_password_confirmation" placeholder="Confirm Password">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-lg-12 col-xl-12">
                                                                <button type="submit" class="btn btn-primary mb-2 mb-md-0">Change Password</button>
                                                                <button type="button" class="btn btn-danger">Cancel</button>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div><!--end card-body-->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- end education -->

                        </div>
                        <!-- Tab panes -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

<script>
    // Show validation errors
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error('{{ $error }}');
        @endforeach
    @endif

    // Show success message
    @if(session('success'))
        toastr.success('{{ session('success') }}');
    @endif

    // Show error message
    @if(session('error'))
        toastr.error('{{ session('error') }}');
    @endif
</script>
@endsection
