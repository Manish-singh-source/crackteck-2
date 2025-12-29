@extends('crm/layouts/master')

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class=" d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0"></h4>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">Transfer Case</h5>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div>
                            <form action="{{ route('case-transfer.index') }}" method="GET" enctype="multipart/form-data">
                                <div class="row g-3">
                                    <div class="col-6">
                                        @include('components.form.select', [
                                        'label' => 'Service Id',
                                        'name' => 'service_id',
                                        'options' => ["0" => "--Select --", "1" => "#001", "2" => "#002", "3" => "#003", "4" => "#004", "5" => "#005"]
                                        ])
                                    </div>
                                    
                                    <div class="col-6">
                                        @include('components.form.select', [
                                        'label' => 'Transfer To Engineer',
                                        'name' => 'transfer_id',
                                        'options' => ["0" => "--Select --", "1" => "Engineer 1", "2" => "Engineer 2", "3" => "Engineer 3", "4" => "Engineer 4", "5" => "Engineer 5"]
                                        ])
                                    </div>

                                </div>

                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-md btn-success btn-xl px-4 fs-6 text-light waves ripple-light">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card service-info">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Customer Details
                            </h5>
                            <div class="fw-bold text-dark">
                                #1001
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush ">

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Customer Name :
                                </span>
                                <span>
                                    Shyam Jaiswal
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Contact no :
                                </span>
                                <span>
                                    9004086582
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Feedback :
                                </span>
                                <span>
                                    Need a AMC Service for my PC
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card service-info">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                AMC Details
                            </h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">

                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">AMC Plan :
                                </span>
                                <span>
                                    Standard
                                </span>
                            </li>

                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Duration (Months) :
                                </span>
                                <span>
                                    12
                                </span>
                            </li>

                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Start From :
                                </span>
                                <span>
                                    2025-04-04 06:09 PM
                                </span>
                            </li>
                        </ul>
                    </div>


                </div>


                <div class="card service-info">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Product Details
                            </h5>
                        </div>
                    </div>
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
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="./assets/images/products/headphone.png" alt="Headphone" width="100px" class="img-fluid d-block">
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
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

<script>
    $(document).ready(function(){
        $(".service-info").hide();
        
        $("#service_id").on('change', function() {
            $(".service-info").show();
        })
    });
</script>

@endsection