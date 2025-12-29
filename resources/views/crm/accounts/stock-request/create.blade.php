@extends('crm/layouts/master')

@section('content')

<div class="content">


    <div class="container-fluid">

        <div class="bradcrumb pt-3 ps-2 bg-light">
            <div class="row ">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Stock Reports</li>
                        <li class="breadcrumb-item active" aria-current="page">Add  Stock Reports</li>
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
                                             Stock Reports Information
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label for="requested_by" class="form-label">Requested By<span class="text-danger">*</span></label>
                                        <input type="text" name="requested_by" id="requested_by" class="form-control" placeholder="Enter Name and Department" required>
                                    </div>

                                    <div class="col-6">
                                        <label for="request_date" class="form-label">Date of Request <span class="text-danger">*</span></label>
                                        <input type="date" name="request_date" id="request_date" class="form-control" required>
                                    </div>

                                    <div class="col-6">
                                        <label for="item_name" class="form-label">Item Name <span class="text-danger">*</span></label>
                                        <input type="text" name="item_name" id="item_name" class="form-control" placeholder="Enter Item Name" required>
                                    </div>

                                    <div class="col-6">
                                        <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter Quantity" required>
                                    </div>

                                    <div class="col-12">
                                        <label for="reason" class="form-label">Reason / Justification <span class="text-danger">*</span></label>
                                        <textarea name="reason" id="reason" class="form-control" rows="3" placeholder="Enter Reason or Justification" required></textarea>
                                    </div>

                                    <div class="col-6">
                                        <label for="urgency" class="form-label">Urgency Level <span class="text-danger">*</span></label>
                                        <select name="urgency" id="urgency" class="form-control" required>
                                            <option selected disabled>-- Select --</option>
                                            <option value="Low">Low</option>
                                            <option value="Medium">Medium</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>

                                    <div class="col-6">
                                        <label for="approval_status" class="form-label">Approval Status</label>
                                        <select name="approval_status" id="approval_status" class="form-control">
                                            <option selected disabled>-- Select --</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Rejected">Rejected</option>
                                        </select>
                                    </div>

                                    <div class="col-6">
                                        <label for="final_status" class="form-label">Final Status</label>
                                        <select name="final_status" id="final_status" class="form-control">
                                            <option selected disabled>-- Select --</option>
                                            <option value="Purchased">Purchased</option>
                                            <option value="Issued from Stock">Issued from Stock</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="col-lg-12">
                        <div class="text-start mb-3">
                            <a href="{{ route('stock-request.index') }}" class="btn btn-success w-sm waves ripple-light">
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