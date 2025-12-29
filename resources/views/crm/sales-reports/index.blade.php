@extends('crm/layouts/master')

@section('content')

<div class="content">


    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">

                            <div class="d-flex align-items-center mb-2">
                                <div
                                    class="p-2 border border-primary border-opacity-10 bg-primary-subtle rounded-2 me-2">
                                    <div class="bg-primary rounded-circle widget-size text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24">
                                            <path fill="#ffffff"
                                                d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mb-0 text-dark fs-15">Leads Generated</p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 fs-22 text-dark me-3">120</h3>
                                <div class="text-center">
                                    <span class="text-primary fs-14"><i
                                            class="mdi mdi-trending-up fs-14"></i> 12.5%</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">

                            <div class="d-flex align-items-center mb-2">
                                <div
                                    class="p-2 border border-primary border-opacity-10 bg-primary-subtle rounded-2 me-2">
                                    <div class="bg-primary rounded-circle widget-size text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24">
                                            <path fill="#ffffff"
                                                d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mb-0 text-dark fs-15">Qualified Leads</p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 fs-22 text-dark me-3">80</h3>
                                <div class="text-center">
                                    <span class="text-primary fs-14"><i
                                            class="mdi mdi-trending-up fs-14"></i> 12.5%</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">

                            <div class="d-flex align-items-center mb-2">
                                <div
                                    class="p-2 border border-primary border-opacity-10 bg-primary-subtle rounded-2 me-2">
                                    <div class="bg-primary rounded-circle widget-size text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24">
                                            <path fill="#ffffff"
                                                d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mb-0 text-dark fs-15">Deals Closed</p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 fs-22 text-dark me-3">55</h3>
                                <div class="text-center">
                                    <span class="text-primary fs-14"><i
                                            class="mdi mdi-trending-up fs-14"></i> 12.5%</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">

                            <div class="d-flex align-items-center mb-2">
                                <div
                                    class="p-2 border border-primary border-opacity-10 bg-primary-subtle rounded-2 me-2">
                                    <div class="bg-primary rounded-circle widget-size text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24">
                                            <path fill="#ffffff"
                                                d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mb-0 text-dark fs-15">Total Revenue</p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 fs-22 text-dark me-3">1,20,000 ₹</h3>
                                <div class="text-center">
                                    <span class="text-primary fs-14"><i
                                            class="mdi mdi-trending-up fs-14"></i> 12.5%</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">

                            <div class="d-flex align-items-center mb-2">
                                <div
                                    class="p-2 border border-primary border-opacity-10 bg-primary-subtle rounded-2 me-2">
                                    <div class="bg-primary rounded-circle widget-size text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24">
                                            <path fill="#ffffff"
                                                d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mb-0 text-dark fs-15"> Conversion Rate</p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 fs-22 text-dark me-3">12.5%</h3>
                                <!-- <div class="text-center">
                                    <span class="text-primary fs-14"><i
                                            class="mdi mdi-trending-up fs-14"></i> 12.5%</span>
                                </div> -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">

                            <div class="d-flex align-items-center mb-2">
                                <div
                                    class="p-2 border border-primary border-opacity-10 bg-primary-subtle rounded-2 me-2">
                                    <div class="bg-primary rounded-circle widget-size text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24">
                                            <path fill="#ffffff"
                                                d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mb-0 text-dark fs-15"> Average Deal Time</p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 fs-22 text-dark me-3">24 Hr</h3>
                                <div class="text-center">
                                    <span class="text-primary fs-14"><i
                                            class="mdi mdi-trending-up fs-14"></i> 12.5%</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <!-- Color Range Charts -->

            <div class="col-md-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Industy Wise Sales Activity</h5>
                    </div>

                    <div class="card-body">
                        <div id="range_colors_chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>


        </div>

        <!-- start row -->
        <div class="row">

            <div class="col-md-12 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0">Sales Overview</h5>

                            <div class="ms-auto">
                                <button class="btn btn-sm bg-light border dropdown-toggle fw-medium"
                                    type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">This Month<i
                                        class="mdi mdi-chevron-down ms-1 fs-14"></i></button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">This Month</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="sales-overview" class="apex-charts"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0">Sales Pipeline</h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="top-session" class="apex-charts"></div>

                        <div class="row mt-2">
                            <div class="col">
                                <div class="d-flex justify-content-between align-items-center p-1">
                                    <div>
                                        <i class="mdi mdi-circle fs-12 align-middle me-1" style="color:#28C76F;"></i>
                                        <span class="align-middle fw-semibold">Won</span>
                                    </div>
                                    <span class="fw-medium text-muted float-end"><i
                                            class="mdi mdi-arrow-up text-success align-middle fs-14 me-1"></i>12.48%</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center p-1">
                                    <div>
                                        <i class="mdi mdi-circle fs-12 align-middle me-1"
                                            style="color:#EA5455;"></i>
                                        <span class="align-middle fw-semibold">Lost</span>
                                    </div>
                                    <span class="fw-medium text-muted float-end"><i
                                            class="mdi mdi-arrow-up text-success align-middle fs-14 me-1"></i>5.23%</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center p-1">
                                    <div>
                                        <i class="mdi mdi-circle fs-12 align-middle me-1"
                                            style="color: #FF9F43;"></i>
                                        <span class="align-middle fw-semibold">Qualified</span>
                                    </div>
                                    <span class="fw-medium text-muted float-end"><i
                                            class="mdi mdi-arrow-up text-success align-middle fs-14 me-1"></i>5.23%</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center p-1">
                                    <div>
                                        <i class="mdi mdi-circle fs-12 align-middle me-1" style="color: #B8C2CC;"></i>
                                        <span class="align-middle fw-semibold">Unqualified</span>
                                    </div>
                                    <span class="fw-medium text-muted float-end"><i
                                            class="mdi mdi-arrow-up text-success align-middle fs-14 me-1"></i>15.58%</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end start -->

    </div>
</div>

@endsection