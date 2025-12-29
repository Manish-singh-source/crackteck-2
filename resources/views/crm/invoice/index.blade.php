@extends('crm/layouts/master')

@section('content')

<div class="content">
    <div class="container-fluid">

                <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Invoice</h4>
                    </div>

                   
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="panel-body">
                                    <div class="clearfix">
                                        <div class="float-start d-flex justify-content-center">
                                            <img src="{{ asset('assets/images/favicon.png') }}" class="me-2" alt="logo" height="24">
                                            <h4 class="mb-0 caption fw-semibold fs-18">Crackteck</h4>
                                        </div>
                                        <div class="float-end">
                                            <h4 class="fs-18">Invoice #4987<br>
                                                <strong class="fs-15 fw-normal">Invoice Number</strong>
                                            </h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 bg-primary rounded-2 mb-3">
                                            <div class="float-start mt-3 text-white">
                                                <address>
                                                    <strong>Invoice To:</strong><br>
                                                   Sanjay Nagar lalji Pada<br>
                                                    Kandivali West M-400067<br>
                                                    <abbr title="Phone">P: </abbr>+91 9607 78 8836
                                                </address>
                                            </div>
                                            <div class="float-end mt-3 text-white">
                                                <address>
                                                    <strong>Bill To:</strong><br>
                                                    <table>
                                                        <tbody>
                                                          <tr>
                                                            <td class="pe-4">Customer Name:</td>
                                                            <td class="fw-medium">Manish</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="pe-4">Email:</td>
                                                            <td>crackteck@gmail.com</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="pe-4">Phone:</td>
                                                            <td>+91 9607 78 8836</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="pe-4">Billing Address:</td>
                                                            <td>Borivali West Devidas Road</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="pe-4">Shipping Address:</td>
                                                            <td>Borivali West Devidas Road</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="pe-4"></td>
                                                            <td>400067</td>
                                                          </tr>
                                                        </tbody>
                                                      </table>
                                                </address>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-3">
                                            <p class="mb-1 fw-semibold">Invoice ID :</p>
                                            <p class="mb-1">#ERTW1249879</p>
                                        </div>

                                        <div class="col-xl-3">
                                            <p class="mb-1 fw-semibold">Date Issued :</p>
                                            <p class="mb-1">10, Apr 2025</p>
                                        </div>

                                        <div class="col-xl-3">
                                            <p class="mb-1 fw-semibold">Due Date :</p>
                                            <p class="mb-1">17, May 2025</p>
                                        </div>

                                        <div class="col-xl-3">
                                            <p class="mb-1 fw-semibold">Due Amount :</p>
                                            <p class="mb-1 fw-bold">₹2,032.82</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive rounded-2">
                                                <table class="table mt-4 mb-4 table-centered border">
                                                    <thead class="rounded-2">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Item</th>
                                                            <th>Description</th>
                                                            <th>Quantity</th>
                                                            <th>Unit Cost</th>
                                                            <th>GST %</th>
                                                            <th>GST Amt</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Dell Inspiron Laptop</td>
                                                            <td>Sleek, powerful laptop ideal for multitasking and productivity.</td>
                                                            <td>1</td>
                                                            <td>₹180</td>
                                                            <td>18%</td>
                                                            <td>₹32.40</td>
                                                            <td>₹180</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>HP Desktop Computer</td>
                                                            <td>Reliable desktop system perfect for office and home use.</td>
                                                            <td>5</td>
                                                            <td>₹150</td>
                                                            <td>18%</td>
                                                            <td>₹135.00</td>
                                                            <td>₹2750</td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>Hikvision CCTV Camera</td>
                                                            <td>High-definition surveillance camera with night vision.</td>
                                                            <td>2</td>
                                                            <td>₹80</td>
                                                            <td>18%</td>
                                                            <td>₹28.80</td>
                                                            <td>₹160</td>
                                                        </tr>
                                                        <tr>
                                                            <td>4</td>
                                                            <td>Canon All-in-One Printer</td>
                                                            <td>Print, scan, and copy with crisp quality and fast speed.</td>
                                                            <td>3</td>
                                                            <td>₹300</td>
                                                            <td>18%</td>
                                                            <td>₹162.00</td>
                                                            <td>₹900</td>
                                                        </tr>
                                                        <tr>
                                                            <td>5</td>
                                                            <td>Mantra Biometric Scanner</td>
                                                            <td>Secure fingerprint device for attendance and access control.</td>
                                                            <td>5</td>
                                                            <td>₹1520</td>
                                                            <td>18%</td>
                                                            <td>₹1368.00</td>
                                                            <td>₹7600</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4"></td>
                                                            <td colspan="2">
                                                                <table class="table table-sm text-nowrap mb-0 table-borderless">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <p class="mb-0">Sub-total :</p>
                                                                            </td>
                                                                            <td>
                                                                                <p class="mb-0 fw-medium fs-15">₹1,1590</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td scope="row">
                                                                                <p class="mb-0">Discout :</p>
                                                                            </td>
                                                                            <td>
                                                                                <p class="mb-0 fw-medium fs-15">₹29.98</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td scope="row">
                                                                                <p class="mb-0">Vat <span class="text-danger">(20%)</span> :</p>
                                                                            </td>
                                                                            <td>
                                                                                <p class="mb-0 fw-medium fs-15">₹472.80</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td scope="row">
                                                                                <p class="mb-0">Due Till Date :</p>
                                                                            </td>
                                                                            <td>
                                                                                <p class="mb-0 fw-medium fs-15">₹0</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td scope="row">
                                                                                <p class="mb-0 fs-14">Total :</p>
                                                                            </td>
                                                                            <td>
                                                                                <p class="mb-0 fw-medium fs-16 text-success">₹2,032.82</p>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-print-none">
                                        <div class="float-end">
                                            <a href="javascript:window.print()" class="btn btn-dark border-0"><i class="mdi mdi-printer me-1"></i>Print</a>
                                            <a href="{{ route('invoice.index') }}" class="btn btn-primary">Submit</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container-fluid -->

        </div> <!-- content -->

</div> <!-- content -->

@endsection