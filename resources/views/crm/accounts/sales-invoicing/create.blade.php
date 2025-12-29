@extends('crm/layouts/master')

@section('content')

<div class="content">

    <div class="container-fluid">
        <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Create Sales Invoice</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Invoice Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <div class="row g-3 pb-3">
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Quotation ID',
                                        'name' => 'quotation_id',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Quotation ID',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Invoice No',
                                        'name' => 'invoice_no',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Invoice No',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    @include('components.form.select', [
                                    'label' => 'Client Name',
                                    'name' => 'clientName',
                                    'options' => ["0" => "--Select--", "1" => "Saurabh", "2" => "Manish"]
                                    ])
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Bill Date',
                                        'name' => 'bill_date',
                                        'type' => 'date',
                                        'placeholder' => 'Enter Bill Date',
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Bill Due Date',
                                        'name' => 'bill_due_date',
                                        'type' => 'date',
                                        'placeholder' => 'Enter Bill Due Date',
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Total Amount',
                                        'name' => 'total_amount',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Total Amount',
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Paid Amount',
                                        'name' => 'paid_amount',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Total Paid Amount',
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    @include('components.form.select', [
                                    'label' => 'Payment Status',
                                    'name' => 'payStatus',
                                    'options' => ["0" => "--Select--", "1" => "Paid", "2" => "Unpaid", "3" => "Partially Paid"]
                                    ])
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Notes/Remarks',
                                        'name' => 'remarks',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Total Notes/Remarks',
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

                            </div>
                        </form>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <div class="row g-3 pb-3">
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Product Name',
                                        'name' => 'product_name',
                                        'type' => 'text',
                                        'placeholder' => 'Dell Inspiron 15 Laptop Windows 11',
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.select', [
                                        'label' => 'Product Type',
                                        'name' => 'product_type',
                                        'options' => ["0" => "--Select--", "1" => "Computer", "2" => "Laptop", "3" => "Accessories"]
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Product Brand',
                                        'name' => 'brand',
                                        'type' => 'text',
                                        'placeholder' => 'Dell, HP, Asus',
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Model Number',
                                        'name' => 'model_no',
                                        'type' => 'text',
                                        'placeholder' => 'Inspiron 3511',
                                        ])
                                    </div>
                                </div>
                                
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Serial Number',
                                        'name' => 'serial_no',
                                        'type' => 'text',
                                        'placeholder' => 'B0BB7FQBBS',
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Purchase Date',
                                        'name' => 'purchase_date',
                                        'type' => 'date',
                                        'placeholder' => 'Enter Purchase Date',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Image',
                                        'name' => 'image',
                                        'type' => 'file',
                                        'placeholder' => 'Enter Purchase Date',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        @include('components.form.input', [
                                        'label' => 'Issue type',
                                        'name' => 'issue',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Issue type',
                                        ])
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label for="serial_no" class="form-label">
                                            Issue Description
                                        </label>
                                        <textarea name="" class="form-control" id=""></textarea>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <table
                            class="table table-striped table-borderless dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Brand</th>
                                    <th>Modal Number</th>
                                    <th>Serial Number</th>
                                    <th>Purchase Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="https://placehold.co/100x100" alt="Headphone" width="100px" class="img-fluid d-block">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            Headphone
                                        </div>
                                    </td>
                                    <td>
                                        Computer
                                    </td>
                                    <td>
                                        Sony
                                    </td>
                                    <td>
                                        Inspiron 3511
                                    </td>
                                    <td>
                                        B0BB7FQBBS
                                    </td>
                                    <td>2025-04-04 06:09 PM</td>
                                    <td>
                                        <a aria-label="anchor"
                                            class="btn btn-icon btn-sm bg-danger-subtle delete-row"
                                            data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                        </a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="text-end ">
                    <a href="{{ route('sales.index') }}" type="submit" class="btn btn-primary">
                        Submit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection