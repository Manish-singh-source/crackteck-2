@extends('warehouse/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit Warehouse</h4>
                </div>
            </div>

            <form action="{{ route('warehouse.update', $warehouse->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        {{-- Warehouse Details --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Warehouse Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 pb-3">
                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'Warehouse Name',
                                                'name'        => 'name',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter Warehouse Name',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.select', [
                                                'label'   => 'Warehouse Type',
                                                'name'    => 'type',
                                                'options' => [
                                                    '0'            => '--Select--',
                                                    'Storage Hub'  => 'Storage Hub',
                                                    'Return Center'=> 'Return Center',
                                                ],
                                                'model'   => $warehouse,
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Location Details --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Location Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 pb-3">
                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'Address Line 1',
                                                'name'        => 'address1',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter Address Line 1',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'Address Line 2',
                                                'name'        => 'address2',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter Address Line 2',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'City',
                                                'name'        => 'city',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter City',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'State',
                                                'name'        => 'state',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter State',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'Country',
                                                'name'        => 'country',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter Country',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'Pin Code',
                                                'name'        => 'pincode',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter Pincode',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Contact Details --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Contact Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 pb-3">
                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'Contact Person Name',
                                                'name'        => 'contact_person_name',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter Contact Person Name',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'Phone Number',
                                                'name'        => 'phone_number',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter Phone Number',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'Alternate Phone Number',
                                                'name'        => 'alternate_phone_number',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter Alternate Phone Number',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'Email Address',
                                                'name'        => 'email',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter Email Address',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Operational Settings --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Operational Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 pb-3">
                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'Working Hours',
                                                'name'        => 'working_hours',
                                                'type'        => 'text',
                                                'placeholder' => 'E.g. 9AM - 6PM',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'Working Days',
                                                'name'        => 'working_days',
                                                'type'        => 'text',
                                                'placeholder' => 'Monday - Sunday',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'Maximum Storage Capacity',
                                                'name'        => 'max_store_capacity',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter Maximum Storage Capacity',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.select', [
                                                'label'   => 'Supported Operations',
                                                'name'    => 'supported_operations',
                                                'options' => [
                                                    ''  => '--Select Supported Operations--',
                                                    '0' => 'Inbound',
                                                    '1' => 'Outbound',
                                                    '2' => 'Returns',
                                                    '3' => 'QC',
                                                ],
                                                'model'   => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.select', [
                                                'label'   => 'Zone Configuration',
                                                'name'    => 'zone_conf',
                                                'options' => [
                                                    ''  => '--Select Zone Configuration--',
                                                    '0' => 'Receiving Zone',
                                                    '1' => 'Pick Zone',
                                                    '2' => 'Cold Storage',
                                                ],
                                                'model'   => $warehouse,
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT SIDE --}}
                    <div class="col-lg-4">
                        {{-- Legal/Compliance --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Legal/Compliance</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 pb-3">
                                    <div class="col-12">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'GST Number/Tax ID',
                                                'name'        => 'gst_no',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter GST Number/Tax ID',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div>
                                            @include('components.form.input', [
                                                'label'       => 'Licence/Permit Number',
                                                'name'        => 'licence_no',
                                                'type'        => 'text',
                                                'placeholder' => 'Enter Licence/Permit Number',
                                                'model'       => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Upload Licence Document',
                                                'name'  => 'licence_doc',
                                                'type'  => 'file',
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- System Settings --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">System Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 pb-3">
                                    <div class="col-12">
                                        <div>
                                            @include('components.form.select', [
                                                'label'   => 'Default Warehouse',
                                                'name'    => 'default_warehouse',
                                                'options' => [
                                                    '0' => 'No',
                                                    '1' => 'Yes',
                                                ],
                                                'model'   => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div>
                                            @include('components.form.select', [
                                                'label'   => 'Verification Status',
                                                'name'    => 'verification_status',
                                                'options' => [
                                                    '0' => 'Pending',
                                                    '1' => 'Verified',
                                                    '2' => 'Rejected',
                                                ],
                                                'model'   => $warehouse,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div>
                                            @include('components.form.select', [
                                                'label'   => 'Status',
                                                'name'    => 'status',
                                                'options' => [
                                                    '0' => 'Inactive',
                                                    '1' => 'Active',
                                                ],
                                                'model'   => $warehouse,
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="col-12 mb-3">
                        <div class="text-start">
                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
