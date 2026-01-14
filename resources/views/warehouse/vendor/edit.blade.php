@extends('warehouse/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">   

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">     
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit Vendor</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('vendor_list.update', $vendor->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Vendor Information
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'First Name',
                                                    'name' => 'first_name',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter First Name',
                                                    'model' => $vendor,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [ 
                                                    'label' => 'Last Name', 
                                                    'name' => 'last_name',  
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Last Name',
                                                    'model' => $vendor,
                                                ])
                                            </div>

                                            <div class="col-4">     
                                                @include('components.form.input', [
                                                    'label' => 'Phone number',
                                                    'name' => 'phone',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Phone number',
                                                    'model' => $vendor,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Email',
                                                    'name' => 'email',
                                                    'type' => 'email',
                                                    'placeholder' => 'Enter Email',
                                                    'model' => $vendor,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Address 1',
                                                    'name' => 'address1',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Address 1',
                                                    'model' => $vendor,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Address 2',
                                                    'name' => 'address2',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Address 2',
                                                    'model' => $vendor,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'City',
                                                    'name' => 'city',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter City',
                                                    'model' => $vendor,
                                                ])
                                            </div>  

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'State',
                                                    'name' => 'state',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter State',
                                                    'model' => $vendor,
                                                ])
                                            </div>  

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Country',
                                                    'name' => 'country',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Country',
                                                    'model' => $vendor,
                                                ])
                                            </div>  

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'Pincode',
                                                    'name' => 'pincode',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Pincode',
                                                    'model' => $vendor,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'GST No',
                                                    'name' => 'gst_no',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter GST No',
                                                    'model' => $vendor,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.input', [
                                                    'label' => 'PAN No',
                                                    'name' => 'pan_no',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter PAN No',
                                                    'model' => $vendor,
                                                ])
                                            </div>

                                            <div class="col-4">
                                                @include('components.form.select', [
                                                    'label' => 'Status',
                                                    'name' => 'status',
                                                    'value' => 'active',
                                                    'options' => [
                                                        'inactive' => 'Inactive',
                                                        'active' => 'Active',
                                                    ],
                                                    'model' => $vendor,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-12">
                                <div class="text-start mb-3">
                                    <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                        Submit
                                    </button> 
                                    {{-- <a href="{{ route('pincodes.index') }}"
                                        class="btn btn-success w-sm waves ripple-light">Submit</a> --}}
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </div> 
@endsection
