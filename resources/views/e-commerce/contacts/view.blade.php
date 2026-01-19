@extends('e-commerce/layouts/master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Contacts Details</h4>
                </div>
                <div>
                    <a href="{{ route('contact.index') }}" class="btn btn-secondary">Back to Contacts</a>
                </div>
            </div>

            <div class="row pt-3">
                <div class="col-xl-12 mx-auto">

                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">
                                        First Name :
                                    </span>
                                    <span>
                                        <span>{{ $contact->first_name }}</span><br>
                                    </span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Last Name :
                                    </span>
                                    <span>
                                        <span>{{ $contact->last_name }}</span>
                                    </span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Email :

                                    </span>
                                    <span>{{ $contact->email }}</span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Phone :
                                    </span>
                                    <span>{{ $contact->phone }}</span>
                                </li>

                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <span class="fw-semibold text-break">Message :
                                    </span>
                                    <span>{{ $contact->description }}</span>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div> <!-- content -->
@endsection
