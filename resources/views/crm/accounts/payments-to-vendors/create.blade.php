@extends('crm/layouts/master')

@section('content')

<div class="content">

    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Create Vendor Payment</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Payment Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <div class="row g-3 pb-3">
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.select', [
                                        'label' => 'Paid To (Vendor)',
                                        'name' => 'vendorName',
                                        'options' => ["0" => "--Select--", "1" => "Saurabh", "2" => "Manish"]
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Date',
                                        'name' => 'date',
                                        'type' => 'date'
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Amount',
                                        'name' => 'amount',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Total Paid Amount'
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.select', [
                                            'label' => 'Payment Mode',
                                        'name' => 'payStatus',
                                        'options' => ["0" => "--Select--", "1" => "Cash", "2" => "Bank Transfer", "3" => "UPI", "4" => "Cheque"]
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.select', [
                                        'label' => 'Linked Bill',
                                        'name' => 'linkedBill',
                                        'options' => ["0" => "--Select--", "1" => "PB-1023", "2" => "PB-1021", "3" => "PB-1022", "4" => "PB-1023", "5" => "PB-1024"]
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Notes/Remarks',
                                        'name' => 'remarks',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Notes/Remarks'
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Attachment',
                                        'name' => 'attachment',
                                        'type' => 'file',
                                        ])  
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="text-start">
                                        <a href="{{ route('pay-to-vendors.index') }}" class="btn btn-primary">
                                            Submit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection