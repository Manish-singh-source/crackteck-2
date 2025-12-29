@extends('crm/layouts/master')

@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="bradcrumb pt-3 ps-2 bg-light">
            <div class="row ">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Client</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Client Receipts</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0"></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0">
                                            Personal Information
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        @include('components.form.input', [
                                        'label' => 'Client Name',
                                        'name' => 'clientName',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Client Name',
                                        ])
                                    </div>
                                    
                                    <div class="col-6">
                                        @include('components.form.input', [
                                        'label' => 'Amount Received',
                                        'name' => 'amountReceived',
                                        'type' => 'number',
                                        'placeholder' => 'Enter Amount Received',
                                        ])
                                    </div>
                                    
                                    <div class="col-6">
                                        @include('components.form.input', [
                                        'label' => 'Date',
                                        'name' => 'paymentDate',
                                        'type' => 'date',
                                        'placeholder' => 'Enter Date',
                                        ])
                                    </div>

                                    <div class="col-6">
                                        @include('components.form.select', [
                                        'label' => 'Payment Mode',
                                        'name' => 'paymentMode',
                                        'options' => ["0" => "--Select Payment Mode--", "1" => "Cash", "2" => "Bank", "3" => "Cheque", "4" => "UPI"]
                                        ])
                                    </div>

                                    <div class="col-6">
                                        @include('components.form.input', [
                                        'label' => 'Linked Invoice',
                                        'name' => 'linkedInvoice',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Linked Invoice',
                                        ])
                                    </div>
                                    
                                    <div class="col-6">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <textarea name="remarks" id="remarks" class="form-control" placeholder="Enter Remarks" rows="2"></textarea>
                                    </div>
                                    
                                    <div class="col-6">
                                        @include('components.form.input', [
                                        'label' => 'Upload Proof',
                                        'name' => 'uploadProof',
                                        'type' => 'file',
                                        'placeholder' => 'Enter Linked Invoice',
                                        ])
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>


                    <div class="col-lg-12">
                        <div class="text-start mb-3">
                            <a href="{{ route('client.index') }}" class="btn btn-success w-sm waves ripple-light">
                                Submit
                            </a>
                            <!-- <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                Submit
                            </button> -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // $(".branch-section").hide();

        $("#branch-form").on("submit", function(e) {
            e.preventdefault();
            let formData = e.serialize();
            console.log(formData);
        });
    });
</script>

@endsection