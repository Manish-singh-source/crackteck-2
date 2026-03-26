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
            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Field Issues</li>
                            <li class="breadcrumb-item active" aria-current="page">Start</li>
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
                                    <div class="d-flex">
                                        <h5 class="card-title flex-grow-1 mb-0">
                                            Engineer Details
                                        </h5>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush ">
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Engineer Name :
                                                    </span>
                                                    <span>
                                                        {{ optional($engineer)->first_name }}
                                                        {{ optional($engineer)->last_name }}
                                                    </span>
                                                </li>
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Engineer Contact No :
                                                    </span>
                                                    <span>
                                                        {{ optional($engineer)->phone }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush">
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Engineer Email :
                                                    </span>
                                                    <span>
                                                        {{ optional($engineer)->email }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header border-bottom-dashed">
                                    <div class="d-flex">
                                        <h5 class="card-title flex-grow-1 mb-0">
                                            Customer Details
                                        </h5>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush ">
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Client Name :
                                                    </span>
                                                    <span>
                                                        @if ($customer)
                                                            {{ $customer->first_name }} {{ $customer->last_name }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Location :
                                                    </span>
                                                    <span>
                                                        @if ($customerAddress && ($customerAddress->address1 || $customer->city))
                                                            {{ $customerAddress->address1 }} {{ $customerAddress->city }}
                                                            {{ $customerAddress->pin_code }}
                                                        @else
                                                            Address Not Available
                                                        @endif
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush">
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Contact No :
                                                    </span>
                                                    <span>
                                                        @if ($customer && $customer->phone)
                                                            {{ $customer->phone }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-header border-bottom-dashed">
                                    <div class="d-flex">
                                        <h5 class="card-title flex-grow-1 mb-0">
                                            Devies Details
                                        </h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-borderless dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>Item Image</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Brand</th>
                                                <th>Modal Number</th>
                                                <th>Purchase Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if ($productData)
                                                <tr class="align-middle">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <img src="https://placehold.co/100x100" alt="Dummy Image"
                                                                    width="100px" class="img-fluid d-block">
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div>
                                                            {{ $productData->name }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $productData->type }}
                                                    </td>
                                                    <td>
                                                        {{ $productData->brand }}
                                                    </td>
                                                    <td>
                                                        {{ $productData->model_no }}
                                                    </td>
                                                    <td>{{ $productData->purchase_date ? \App\Helpers\DateFormat::formatDate($productData->purchase_date) : 'N/A' }}
                                                    </td>
                                                    <td>{{ isset($productData->status) ? ucwords(str_replace('_', ' ', $productData->status)) : 'N/A' }}
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="8" class="text-center">No devices found for this job.
                                                    </td>
                                                </tr>
                                            @endif

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

                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Earthing:
                                            </span>
                                            <span>
                                                <span
                                                    class="badge bg-success-subtle text-success fw-semibold request-status">Done</span>
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Power Test:
                                            </span>
                                            <span>
                                                <span
                                                    class="badge bg-success-subtle text-success fw-semibold request-status">Done</span>
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Display Output:
                                            </span>
                                            <span>
                                                <span
                                                    class="badge bg-success-subtle text-success fw-semibold request-status">Done</span>
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Keyboard / Mouse / Touchpad:
                                            </span>
                                            <span>
                                                <span
                                                    class="badge bg-success-subtle text-success fw-semibold request-status">Done</span>
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">USB / HDMI / LAN / Audio Ports:
                                            </span>
                                            <span>
                                                <span
                                                    class="badge bg-warning-subtle text-warning fw-semibold request-status">Raised
                                                    Issue</span>
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Wi-Fi / Bluetooth:
                                            </span>
                                            <span>
                                                <span
                                                    class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Overheating Symptoms:
                                            </span>
                                            <span>
                                                <span
                                                    class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">RAM / HDD / SSD Health:
                                            </span>
                                            <span>
                                                <span
                                                    class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Hinge or Body Damage:
                                            </span>
                                            <span>
                                                <span
                                                    class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                            </span>
                                        </li>

                                        <li
                                            class="list-group-item border-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                            <span class="fw-semibold text-break">Battery / Charging:
                                            </span>
                                            <span>
                                                <span
                                                    class="badge bg-danger-subtle text-danger fw-semibold request-status">Pending</span>
                                            </span>
                                        </li>


                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header border-bottom-dashed">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title flex-grow-1 mb-0">
                                            Issue Details
                                        </h5>
                                        <div>
                                            <span class="badge bg-danger-subtle text-danger fw-semibold">{{ $issue->priority }}</span>
                                            <span class="badge bg-danger-subtle text-danger fw-semibold">{{ ucwords(str_replace('_', ' ', $issue->status)) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush ">
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Priority :
                                                    </span>
                                                    <span
                                                        class="badge bg-danger-subtle text-danger fw-semibold">{{ $issue->priority }}</span>
                                                </li>
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Issue Type :
                                                    </span>
                                                    <span>
                                                        {{ $issue->issue_type }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush">
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Status :
                                                    </span>
                                                    <span
                                                        class="badge bg-danger-subtle text-danger fw-semibold">Pending</span>
                                                </li>
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Issue Description :
                                                    </span>
                                                    <span>
                                                       {{ $issue->issue_description }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 start-job-details-section">
                            <div class="card">
                                <div class="card-header border-bottom-dashed">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title flex-grow-1 mb-0">
                                            Issue Solved Details
                                        </h5>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush ">
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Connected Via :
                                                    </span>
                                                    <span>
                                                        Call
                                                    </span>
                                                </li>
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Fixed Issue Description :
                                                    </span>
                                                    <span>
                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure,
                                                        perspiciatis.
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush">
                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Remote Tool Used :
                                                    </span>
                                                    <span>
                                                        Anydesk
                                                    </span>
                                                </li>

                                                <li
                                                    class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="fw-semibold text-break">Remarks :
                                                    </span>
                                                    <span>
                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo,
                                                        veniam.
                                                    </span>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 complete-job-section">
                            <div class="d-flex justify-content-end gap-3">
                                <div class="text-start mb-3">
                                    <!-- <a href="#" class="btn btn-success w-sm waves ripple-light solve-issue">Solve Issue</a> -->
                                    <button class="btn btn-success w-sm waves ripple-light solve-issue"
                                        data-bs-toggle="modal" data-bs-target="#addVisitModal2">Solve Issue</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="addVisitModal2" tabindex="-1"
                                        aria-labelledby="addVisitModalLabel2" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="#">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addVisitModalLabel2">Assist Report
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body p-2">
                                                        <div class="card shadow-none">
                                                            <div class="card-body">
                                                                <div class="row g-3">
                                                                    <div class="col-12">
                                                                        @include('components.form.select', [
                                                                            'label' =>
                                                                                'Field Engineer Connected Via',
                                                                            'name' => 'field_engineer',
                                                                            'options' => [
                                                                                '0' => '--Select Connection --',
                                                                                '1' => 'Call',
                                                                                '2' => 'E-mail',
                                                                                '3' => 'WhatsApp',
                                                                            ],
                                                                        ])
                                                                    </div>

                                                                    <div class="col-12">
                                                                        @include('components.form.select', [
                                                                            'label' => 'Remote Tool Used',
                                                                            'name' => 'remote_tool',
                                                                            'options' => [
                                                                                '0' => '--Select Remote Tool --',
                                                                                '1' => 'Anydesk',
                                                                                '2' => 'Team Viewer',
                                                                            ],
                                                                        ])
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <label for="meetTitle" class="form-label">Fixed
                                                                            Issue Description<span
                                                                                class="text-danger">*</span></label>
                                                                        <!-- <input type="text" name="meetTitle" id="meetTitle" class="form-control" value="" required="" placeholder="Enter Confirmation Details"> -->
                                                                        <textarea name="issueDescription" id="issueDescription" rows="5" class="form-control"
                                                                            placeholder="Enter Description Report"></textarea>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="meetTitle"
                                                                            class="form-label">Remarks<span
                                                                                class="text-danger">*</span></label>
                                                                        <!-- <input type="text" name="meetTitle" id="meetTitle" class="form-control" value="" required="" placeholder="Enter Confirmation Details"> -->
                                                                        <textarea name="issueDescription" id="issueDescription" rows="5" class="form-control"
                                                                            placeholder="Enter Remarks"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success"
                                                            id="submit-issue-btn">Submit</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-success w-sm waves ripple-light convert-issue"
                                        data-bs-toggle="modal" data-bs-target="#convertIssue">Escalate Issue</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="convertIssue" tabindex="-1"
                                        aria-labelledby="addVisitModalLabel2" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="#">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addVisitModalLabel2">Escalate Issue
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body p-2">
                                                        <div class="card shadow-none">
                                                            <div class="card-body">
                                                                <div class="row g-3">
                                                                    <div class="col-12">
                                                                        <label for="status"
                                                                            class="form-label">Escalate</label>
                                                                        <select name="status" id="status"
                                                                            class="form-control">
                                                                            <option> -- Select Engineer --</option>
                                                                            <option>Engineer 1</option>
                                                                            <option>Engineer 2</option>
                                                                            <option>Engineer 3</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success"
                                                            id="submit-transfer-issue-btn">Transfer</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-start mb-3">
                                    <a href="{{ route('field-issues.index') }}"
                                        class="btn btn-success w-sm waves ripple-light">Mark as Complete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $(".start-job-details-section").hide();
            $(".convert-issue").hide();
            $('.transfer-section').hide();

            $("#submit-issue-btn").on("click", function() {
                $(".start-job-details-section").show();
                $('#addVisitModal2').modal('hide');
                $(".solve-issue").hide();
                $(".convert-issue").show();
            });

            $("#submit-transfer-issue-btn").on("click", function() {
                $('#convertIssue').modal('hide');
                $('.transfer-section').show();
            });
        });
    </script>
@endsection
