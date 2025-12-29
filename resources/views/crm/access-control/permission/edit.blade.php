@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="pb-2 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0"></h4>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('permission.update', $permission->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h5 class="card-title mb-0">Edit Permission</h5>
                            </div><!-- end card header -->
                            <div class="card-body">
                                <div>
                                    @include('components.form.input', [
                                        'label' => 'Name',
                                        'name' => 'name',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Name',
                                        'model' => $permission,
                                    ])
                                </div>

                                {{-- <div class="mt-3">
                            <h5>
                                Permissions
                            </h5>

                            <div class="row g-3">
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Admin
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Admin
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_admin" name="permission[admin][view_admin] " class="form-check-input" id="view_admin">
                                                        <label class="form-check-label" for="view_admin"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Profile
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_profile" name="permission[admin][update_profile] " class="form-check-input" id="update_profile">
                                                        <label class="form-check-label" for="update_profile"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Create Admin
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="create_admin" name="permission[admin][create_admin] " class="form-check-input" id="create_admin">
                                                        <label class="form-check-label" for="create_admin"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Admin
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_admin" name="permission[admin][update_admin] " class="form-check-input" id="update_admin">
                                                        <label class="form-check-label" for="update_admin"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Delete Admin
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="delete_admin" name="permission[admin][delete_admin] " class="form-check-input" id="delete_admin">
                                                        <label class="form-check-label" for="delete_admin"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Language
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Languages
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_languages" name="permission[language][view_languages] " class="form-check-input" id="view_languages">
                                                        <label class="form-check-label" for="view_languages"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Create Languages
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="create_languages" name="permission[language][create_languages] " class="form-check-input" id="create_languages">
                                                        <label class="form-check-label" for="create_languages"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Languages
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_languages" name="permission[language][update_languages] " class="form-check-input" id="update_languages">
                                                        <label class="form-check-label" for="update_languages"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Delete Languages
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="delete_languages" name="permission[language][delete_languages] " class="form-check-input" id="delete_languages">
                                                        <label class="form-check-label" for="delete_languages"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Role
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Roles
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_roles" name="permission[role][view_roles] " class="form-check-input" id="view_roles">
                                                        <label class="form-check-label" for="view_roles"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Create Roles
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="create_roles" name="permission[role][create_roles] " class="form-check-input" id="create_roles">
                                                        <label class="form-check-label" for="create_roles"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Roles
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_roles" name="permission[role][update_roles] " class="form-check-input" id="update_roles">
                                                        <label class="form-check-label" for="update_roles"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Delete Roles
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="delete_roles" name="permission[role][delete_roles] " class="form-check-input" id="delete_roles">
                                                        <label class="form-check-label" for="delete_roles"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Dashboard
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Dashboard
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_dashboard" name="permission[dashboard][view_dashboard] " class="form-check-input" id="view_dashboard">
                                                        <label class="form-check-label" for="view_dashboard"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Order
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Order
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_order" name="permission[order][view_order] " class="form-check-input" id="view_order">
                                                        <label class="form-check-label" for="view_order"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Order
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_order" name="permission[order][update_order] " class="form-check-input" id="update_order">
                                                        <label class="form-check-label" for="update_order"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Delete Order
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="delete_order" name="permission[order][delete_order] " class="form-check-input" id="delete_order">
                                                        <label class="form-check-label" for="delete_order"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Configuration
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Configuration
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_configuration" name="permission[configuration][view_configuration] " class="form-check-input" id="view_configuration">
                                                        <label class="form-check-label" for="view_configuration"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Configuration
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_configuration" name="permission[configuration][update_configuration] " class="form-check-input" id="update_configuration">
                                                        <label class="form-check-label" for="update_configuration"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Delete Configuration
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="delete_configuration" name="permission[configuration][delete_configuration] " class="form-check-input" id="delete_configuration">
                                                        <label class="form-check-label" for="delete_configuration"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Settings
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Settings
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_settings" name="permission[settings][view_settings] " class="form-check-input" id="view_settings">
                                                        <label class="form-check-label" for="view_settings"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Settings
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_settings" name="permission[settings][update_settings] " class="form-check-input" id="update_settings">
                                                        <label class="form-check-label" for="update_settings"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Create Settings
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="create_settings" name="permission[settings][create_settings] " class="form-check-input" id="create_settings">
                                                        <label class="form-check-label" for="create_settings"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Support
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Support
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_support" name="permission[support][view_support] " class="form-check-input" id="view_support">
                                                        <label class="form-check-label" for="view_support"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Support
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_support" name="permission[support][update_support] " class="form-check-input" id="update_support">
                                                        <label class="form-check-label" for="update_support"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Create Support
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="create_support" name="permission[support][create_support] " class="form-check-input" id="create_support">
                                                        <label class="form-check-label" for="create_support"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Delete Support
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="delete_support" name="permission[support][delete_support] " class="form-check-input" id="delete_support">
                                                        <label class="form-check-label" for="delete_support"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Payment System
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Method
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_method" name="permission[Payment System][view_method] " class="form-check-input" id="view_method">
                                                        <label class="form-check-label" for="view_method"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Method
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_method" name="permission[Payment System][update_method] " class="form-check-input" id="update_method">
                                                        <label class="form-check-label" for="update_method"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Create Method
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="create_method" name="permission[Payment System][create_method] " class="form-check-input" id="create_method">
                                                        <label class="form-check-label" for="create_method"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Delete Method
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="delete_method" name="permission[Payment System][delete_method] " class="form-check-input" id="delete_method">
                                                        <label class="form-check-label" for="delete_method"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Brand
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Brand
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_brand" name="permission[brand][view_brand] " class="form-check-input" id="view_brand">
                                                        <label class="form-check-label" for="view_brand"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Brand
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_brand" name="permission[brand][update_brand] " class="form-check-input" id="update_brand">
                                                        <label class="form-check-label" for="update_brand"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Create Brand
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="create_brand" name="permission[brand][create_brand] " class="form-check-input" id="create_brand">
                                                        <label class="form-check-label" for="create_brand"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Delete Brand
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="delete_brand" name="permission[brand][delete_brand] " class="form-check-input" id="delete_brand">
                                                        <label class="form-check-label" for="delete_brand"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Category
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Category
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_category" name="permission[category][view_category] " class="form-check-input" id="view_category">
                                                        <label class="form-check-label" for="view_category"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Category
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_category" name="permission[category][update_category] " class="form-check-input" id="update_category">
                                                        <label class="form-check-label" for="update_category"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Create Category
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="create_category" name="permission[category][create_category] " class="form-check-input" id="create_category">
                                                        <label class="form-check-label" for="create_category"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Delete Category
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="delete_category" name="permission[category][delete_category] " class="form-check-input" id="delete_category">
                                                        <label class="form-check-label" for="delete_category"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Product
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Product
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_product" name="permission[product][view_product] " class="form-check-input" id="view_product">
                                                        <label class="form-check-label" for="view_product"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Product
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_product" name="permission[product][update_product] " class="form-check-input" id="update_product">
                                                        <label class="form-check-label" for="update_product"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Create Product
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="create_product" name="permission[product][create_product] " class="form-check-input" id="create_product">
                                                        <label class="form-check-label" for="create_product"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Delete Product
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="delete_product" name="permission[product][delete_product] " class="form-check-input" id="delete_product">
                                                        <label class="form-check-label" for="delete_product"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Promote
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Manage Deal
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="manage_deal" name="permission[promote][manage_deal] " class="form-check-input" id="manage_deal">
                                                        <label class="form-check-label" for="manage_deal"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Manage Offer
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="manage_offer" name="permission[promote][manage_offer] " class="form-check-input" id="manage_offer">
                                                        <label class="form-check-label" for="manage_offer"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Manage Cuppon
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="manage_cuppon" name="permission[promote][manage_cuppon] " class="form-check-input" id="manage_cuppon">
                                                        <label class="form-check-label" for="manage_cuppon"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Manage Campaign
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="manage_campaign" name="permission[promote][manage_campaign] " class="form-check-input" id="manage_campaign">
                                                        <label class="form-check-label" for="manage_campaign"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Log
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Log
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_log" name="permission[log][view_log] " class="form-check-input" id="view_log">
                                                        <label class="form-check-label" for="view_log"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Log
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_log" name="permission[log][update_log] " class="form-check-input" id="update_log">
                                                        <label class="form-check-label" for="update_log"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Delete Log
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="delete_log" name="permission[log][delete_log] " class="form-check-input" id="delete_log">
                                                        <label class="form-check-label" for="delete_log"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Blog
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Manage Blog
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="manage_blog" name="permission[blog][manage_blog] " class="form-check-input" id="manage_blog">
                                                        <label class="form-check-label" for="manage_blog"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Seller
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        View Seller
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="view_seller" name="permission[seller][view_seller] " class="form-check-input" id="view_seller">
                                                        <label class="form-check-label" for="view_seller"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Update Seller
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="update_seller" name="permission[seller][update_seller] " class="form-check-input" id="update_seller">
                                                        <label class="form-check-label" for="update_seller"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Delete Seller
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="delete_seller" name="permission[seller][delete_seller] " class="form-check-input" id="delete_seller">
                                                        <label class="form-check-label" for="delete_seller"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Customer
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Manage Customer
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="manage_customer" name="permission[customer][manage_customer] " class="form-check-input" id="manage_customer">
                                                        <label class="form-check-label" for="manage_customer"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Delivery_man
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Manage Delivery Man
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="manage_delivery_man" name="permission[delivery_man][manage_delivery_man] " class="form-check-input" id="manage_delivery_man">
                                                        <label class="form-check-label" for="manage_delivery_man"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Frontend
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Manage Frontend
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="manage_frontend" name="permission[frontend][manage_frontend] " class="form-check-input" id="manage_frontend">
                                                        <label class="form-check-label" for="manage_frontend"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Countries
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Manage Countries
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="manage_countries" name="permission[countries][manage_countries] " class="form-check-input" id="manage_countries">
                                                        <label class="form-check-label" for="manage_countries"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                States
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Manage States
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="manage_states" name="permission[states][manage_states] " class="form-check-input" id="manage_states">
                                                        <label class="form-check-label" for="manage_states"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Cities
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Manage Cities
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="manage_cities" name="permission[cities][manage_cities] " class="form-check-input" id="manage_cities">
                                                        <label class="form-check-label" for="manage_cities"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Zones
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Manage Zones
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="manage_zones" name="permission[zones][manage_zones] " class="form-check-input" id="manage_zones">
                                                        <label class="form-check-label" for="manage_zones"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">
                                                Tax
                                            </h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between gap-3 form-control p-2">
                                                    <label class="mb-0">
                                                        Manage Taxes
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" value="manage_taxes" name="permission[tax][manage_taxes] " class="form-check-input" id="manage_taxes">
                                                        <label class="form-check-label" for="manage_taxes"></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div> --}}

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
