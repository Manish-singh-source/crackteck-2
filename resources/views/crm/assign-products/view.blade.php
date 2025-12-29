@extends('crm/layouts/master')

@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-8 mx-auto">




                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Spare Part Details
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <table
                            class="table table-striped table-borderless dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Item Image</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Brand</th>
                                    <th>Modal Number</th>
                                    <th>Serial Number</th>
                                    <th>Approve Date</th>
                                    <th>Status</th>
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
                                            Network Switch
                                        </div>
                                    </td>
                                    <td>
                                        Networking
                                    </td>
                                    <td>
                                        Cisco
                                    </td>
                                    <td>
                                        SG250-26
                                    </td>
                                    <td>
                                        CNSW123456
                                    </td>
                                    <td>2023-11-10</td>
                                    <td>Approved</td>
                                </tr>
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
                                            Wireless Router
                                        </div>
                                    </td>
                                    <td>
                                        Networking
                                    </td>
                                    <td>
                                        TP-Link
                                    </td>
                                    <td>
                                        Archer C6
                                    </td>
                                    <td>
                                        TPWR678901
                                    </td>
                                    <td>2023-12-15</td>
                                    <td>Pending</td>
                                </tr>
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
                                            External Hard Disk
                                        </div>
                                    </td>
                                    <td>
                                        Storage Device
                                    </td>
                                    <td>
                                        Seagate
                                    </td>
                                    <td>
                                        STDR2000100
                                    </td>
                                    <td>
                                        SGHD789012
                                    </td>
                                    <td>2024-02-05</td>
                                    <td>Approved</td>
                                </tr>
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
                                            Firewall Appliance
                                        </div>
                                    </td>
                                    <td>
                                        Security Device
                                    </td>
                                    <td>
                                        Fortinet
                                    </td>
                                    <td>
                                        FG-60F
                                    </td>
                                    <td>
                                        FTFW345678
                                    </td>
                                    <td>2023-09-21</td>
                                    <td>Approved</td>
                                </tr>
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
                                            Ethernet Cable
                                        </div>
                                    </td>
                                    <td>
                                        Accessories
                                    </td>
                                    <td>
                                        D-Link
                                    </td>
                                    <td>
                                        CAT6-305M
                                    </td>
                                    <td>
                                        DLCB567890
                                    </td>
                                    <td>2023-10-01</td>
                                    <td>Rejected</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


            <div class="col-xl-4">




                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Engineer Details
                            </h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush ">

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Engineer Name :
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
                                <span class="fw-semibold text-break">Email :
                                </span>
                                <span>
                                    abc@gmail.com
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> <!-- content -->

<script>
    $(document).ready(function() {
        $(".delivery-form").hide();

        $("#approve-request").on('click', function() {
            $(this).parent().hide();
            $(".request-status").html("Approved");
            $(".request-status").removeClass("bg-danger-subtle text-danger");
            $(".request-status").addClass("bg-success-subtle text-success");
            $(".delivery-form").show();
        });

        $("#reject-request").on('click', function() {
            $(this).parent().hide();
            $(".request-status").html("Rejected");
        });
    });
</script>

@endsection