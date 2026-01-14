@extends('warehouse/layouts/master')

@section('content')

    <div class="content">

        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Create Vendor Purchase Bills</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Vendor Purchase Details</h5>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('vendor.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="row g-3 pb-3">

                                    <div class="col-4">
                                        @include('components.form.select', [
                                            'label' => 'Vendor Name',
                                            'name' => 'vendor_id',
                                            'options' => $vendors->pluck('first_name', 'id')->prepend('--Select Vendor--', 0),
                                        ])
                                    </div>

                                    <div class="col-4">
                                        @include('components.form.input', [
                                            'label' => 'PO Number',
                                            'name' => 'po_number',
                                            'type' => 'text',
                                            'placeholder' => 'Enter PO Number',
                                        ])
                                    </div>

                                    <div class="col-4">
                                        @include('components.form.input', [
                                            'label' => 'Invoice Number',
                                            'name' => 'invoice_number',
                                            'type' => 'text',   
                                            'placeholder' => 'Enter Invoice Number',
                                        ])
                                    </div>

                                    <div class="col-4">
                                        @include('components.form.input', [
                                            'label' => 'Invoice PDF',
                                            'name' => 'invoice_pdf',
                                            'type' => 'file',
                                            'accept' => '.pdf,.doc,.docx,.jpg,.jpeg,.png',
                                        ])
                                    </div>      

                                    <div class="col-4"> 
                                        @include('components.form.input', [
                                            'label' => 'Purchase Date',
                                            'name' => 'purchase_date',
                                            'type' => 'date',
                                            'placeholder' => 'Enter Purchase Date',
                                        ])
                                    </div>  

                                    <div class="col-4">     
                                        @include('components.form.input', [
                                            'label' => 'PO Amount Due Date',
                                            'name' => 'po_amount_due_date',
                                            'type' => 'date',
                                            'placeholder' => 'Enter PO Amount Due Date',
                                        ])
                                    </div>  

                                    <div class="col-4">     
                                        @include('components.form.input', [
                                            'label' => 'PO Amount',
                                            'name' => 'po_amount',
                                            'type' => 'number',
                                            'placeholder' => 'Enter PO Amount',
                                        ])
                                    </div>  

                                    <div class="col-4">     
                                        @include('components.form.input', [
                                            'label' => 'PO Amount Paid',    
                                            'name' => 'po_amount_paid',
                                            'type' => 'number',
                                            'placeholder' => 'Enter PO Amount Paid',
                                        ])
                                    </div>  

                                    {{-- 
                                    <div class="col-4">     
                                        @include('components.form.input', [
                                            'label' => 'PO Amount Pending',    
                                            'name' => 'po_amount_pending',
                                            'type' => 'number', 
                                            'placeholder' => 'Enter PO Amount Pending',
                                        ])
                                    </div>
                                    --}}

                                    <div class="col-4">     
                                        @include('components.form.select', [
                                            'label' => 'PO Status',
                                            'name' => 'po_status',          
                                            'options' => [
                                                '' => '--Select PO Status--',
                                                'pending' => 'Pending',
                                                'approved' => 'Approved',
                                                'rejected' => 'Rejected',
                                                'cancelled' => 'Cancelled',
                                            ],
                                        ])
                                    </div>

                                    <div class="col-12">
                                        <div class="text-start">
                                            <button type="submit" class="btn btn-primary">
                                                Submit
                                            </button>
                                            <a href="{{ route('vendor.index') }}" class="btn btn-secondary ms-2">
                                                Cancel
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
