@extends('crm/layouts/master')

@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">
                                        Ticket Details
                                    </h5>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="ticket-chat-wrapper p-3 bg-soft-gray rounded" data-simplebar="init">
                            <div class="simplebar-wrapper" style="margin: -16px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; ">
                                            <div class="simplebar-content" style="padding: 16px;">
                                                <div class="mb-2 fs-4">
                                                    <span class="badge badge-soft-danger">Closed</span>
                                                </div>

                                                <div class="row">
                                                    <div class="col-11 col-lg-6">
                                                        <div class="border p-lg-3 p-2 rounded mt-3 bg-soft-white">
                                                            <div class="text-start">
                                                                <h6>Demo User</h6>
                                                                <p class="mt -2 fs-12">2025-04-04 04:41 PM</p>
                                                            </div>
                                                            <p class="p-2 mb-0 bg-light rounded">okk</p>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-11 offset-1 col-lg-6 offset-lg-6 text-end">
                                                        <div class="border p-lg-3 p-2 rounded mt-3 bg-soft-white">
                                                            <div class="text-end">
                                                                <h6 class="m-0">Admin</h6>
                                                                <p>2025-04-04 04:39 PM</p>

                                                            </div>
                                                            <p class="bg-light p-2 mb-0 rounded">ok i ll check</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-11 col-lg-6">
                                                        <div class="border p-lg-3 p-2 rounded mt-3 bg-soft-white">
                                                            <div class="text-start">
                                                                <h6>Demo User</h6>
                                                                <p class="mt -2 fs-12">2025-04-04 04:13 PM</p>

                                                            </div>
                                                            <p class="p-2 mb-0 bg-light rounded">test</p>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: 678px; height: 482px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                            </div>
                        </div>

                        <div class="mt-5">


                            <form action="" method="POST" enctype="multipart/form-data">
                                
                                <div class="row g-3 my-3">
                                    <div class="col-12">
                                        <textarea class="form-control" rows="5" name="message" placeholder="Enter message" required=""></textarea>
                                    </div>

                                    <div class="col-12">
                                        <div class="row g-3">
                                            <div class="col-lg-10 col-md-9">
                                                <input type="file" name="file[]" class="form-control">
                                            </div>

                                            <div class="col-lg-2 col-md-3">
                                                <button type="button" class="btn btn-md btn-primary w-100 addnewfile">Add New</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 addnewdata"></div>

                                    <div class="col-12 mt-4 mt-md-0">
                                        <div class="d-flex flex-row justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-md btn-success fs-6 px-4 me-1">Reply</button>
                                            <!-- <button type="submit" class="btn btn-md btn-primary fs-6 px-4 me-1">Close Ticket</button> -->
                                            <a href="{{ route('support-ticket.index') }}" class="btn btn-md btn-primary fs-6 px-4 me-1">Close Ticket</a>
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
</div> <!-- content -->

@endsection