@extends('crm/layouts/master')

@section('content')

<style>
    #popupOverlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    #popupOverlay img {
        max-width: 90%;
        max-height: 90%;
        box-shadow: 0 0 10px #fff;
    }

    #popupOverlay .closeBtn {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 30px;
        color: white;
        cursor: pointer;
    }

    button {
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }
</style>
<div class="content">
    <div class="container-fluid">

        <div class="row pt-3">
            <div class="col-xl-8 mx-auto">

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Pickup Request
                            </h5>
                            <div>
                                <!-- <a href="#" id="approve-request" class="mb-0 btn btn-sm btn-success">Approve</a>
                                <a href="#" id="reject-request" class="mb-0 btn btn-sm btn-danger">Reject</a> -->

                                <button type="button" class="mb-0 btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#standard-modal">
                                    Approve
                                </button>
                                <button type="button" class="mb-0 btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#standard-modal">
                                    Reject
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="standard-modal" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="standard-modalLabel">Request</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body px-3 py-md-2">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label" for="flexRadioDefault1">
                                                Approve Reason
                                            </label>
                                            <input class="form-control" type="text" name="flexRadioDefault" id="flexRadioDefault1">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="approve-request">Approve</button>
                                    <button type="button" class="btn btn-danger" id="reject-request">Reject</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush ">

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">From Engineer :
                                </span>
                                <span>
                                    Shyam Jaiswal
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Service Id:
                                </span>
                                <span>
                                    <a href="javascript:void(0)">
                                        #1001
                                    </a>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Status:
                                </span>
                                <span>
                                    <span class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Pickup Reason:
                                </span>
                                <span>
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore, cupiditate.
                                </span>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Devies Details
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

                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Diagnosis Details
                            </h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush ">

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Earthing:
                                </span>
                                <span>
                                    <span class="badge bg-success-subtle text-success fw-semibold request-status">Done</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Power Test:
                                </span>
                                <span>
                                    <span class="badge bg-success-subtle text-success fw-semibold request-status">Done</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Display Output:
                                </span>
                                <span>
                                    <span class="badge bg-success-subtle text-success fw-semibold request-status">Done</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Keyboard / Mouse / Touchpad:
                                </span>
                                <span>
                                    <span class="badge bg-success-subtle text-success fw-semibold request-status">Done</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">USB / HDMI / LAN / Audio Ports:
                                </span>
                                <span>
                                    <span class="badge bg-warning-subtle text-warning fw-semibold request-status">Raised Issue</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Wi-Fi / Bluetooth:
                                </span>
                                <span>
                                    <span class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Overheating Symptoms:
                                </span>
                                <span>
                                    <span class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">RAM / HDD / SSD Health:
                                </span>
                                <span>
                                    <span class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Hinge or Body Damage:
                                </span>
                                <span>
                                    <span class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                </span>
                            </li>

                            <li class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span class="fw-semibold text-break">Battery / Charging:
                                </span>
                                <span>
                                    <span class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                </span>
                            </li>


                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Issue Details
                            </h5>
                            <div>
                                <span class="badge bg-danger-subtle text-danger fw-semibold">High</span>
                                <span class="badge bg-danger-subtle text-danger fw-semibold">Pending</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush ">
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Priority :
                                        </span>
                                        <span class="badge bg-danger-subtle text-danger fw-semibold">High</span>
                                    </li>
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Issue Type :
                                        </span>
                                        <span>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, ut?
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Issue Image :
                                        </span>
                                        <span>
                                            <button class="btn btn-sm btn-primary show-report">View</button>
                                            <div id="popupOverlay">
                                                <span class="closeBtn hide-report">&times;</span>
                                                <img id="popupImage" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRevxmRXifnbO19nrfkzha4QLipReqGMcM33g&s" alt="Popup Image">
                                            </div>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Status :
                                        </span>
                                        <span class="badge bg-danger-subtle text-danger fw-semibold">Pending</span>
                                    </li>
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Issue Description :
                                        </span>
                                        <span>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, ut?
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Customer Details
                            </h5>
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
            </div>
        </div>

    </div>
</div> <!-- content -->

<script>
    $(document).ready(function() {
        $(".delivery-form").hide();

        $("#approve-request").on('click', function() {
            $(".action-buttons").hide();
            $("#standard-modal").modal('hide');
            $(".request-status").html("Approved");
            $(".request-status").removeClass("bg-danger-subtle text-danger");
            $(".request-status").addClass("bg-success-subtle text-success");
            $(".engineer-details").show();
        });

        $("#reject-request").on('click', function() {
            $(".action-buttons").hide();
            $("#standard-modal").modal('hide');
            $(".request-status").html("Rejected");
        });

        // $("#approve-request").on('click', function() {
        //     $(this).parent().hide();
        //     $(".request-status").html("Approved");
        //     $(".request-status").removeClass("bg-danger-subtle text-danger");
        //     $(".request-status").addClass("bg-success-subtle text-success");
        //     $(".delivery-form").show();
        // });

        // $("#reject-request").on('click', function() {
        //     $(this).parent().hide();
        //     $(".request-status").html("Rejected");
        // });
    });
</script>

@endsection