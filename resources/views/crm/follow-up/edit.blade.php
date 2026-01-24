@extends('crm/layouts/master')

@section('content')
    <div class="content">


        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Follow-Up</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Follow-Up</li>
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
                    <form action="{{ route('follow-up.update', $followup->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">Follow-Up Information</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label for="lead_id" class="form-label">Lead Id</label>
                                                <input type="text" name="lead_id" id="lead_id" class="form-control"
                                                    value="{{ ($followup->lead_id ?? '') . ' - ' . ($followup->leadDetails->lead_number ?? '') }}" readonly>
                                            </div>

                                            <div class="col-6">
                                                <label for="first_name" class="form-label">Client Name</label>
                                                <input type="text" name="first_name" id="first_name" class="form-control"
                                                    value="{{ ($followup->leadDetails->customer->first_name ?? '') . ' ' . ($followup->leadDetails->customer->last_name ?? '') }}" readonly>
                                            </div>

                                            <div class="col-6">
                                                <label for="first_name" class="form-label">Sales Person Name</label>
                                                <input type="text" name="first_name" id="first_name" class="form-control"
                                                    value="{{ ($followup->staffDetails->first_name ?? '') . ' ' . ($followup->staffDetails->last_name ?? '') }}"
                                                    readonly>
                                            </div>


                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Contact Number',
                                                    'name' => 'phone',
                                                    'type' => 'text',
                                                    'model' => $followup->leadDetails->customer ?? '',
                                                    'readonly' => true,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Email ID',
                                                    'name' => 'email',
                                                    'type' => 'email',
                                                    'model' => $followup->leadDetails->customer ?? '',
                                                    'readonly' => true,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Follow-Up Date',
                                                    'name' => 'followup_date',
                                                    'type' => 'date',
                                                    'placeholder' => 'Enter Follow-Up Date',
                                                    'model' => $followup,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Follow-Up Time',
                                                    'name' => 'followup_time',
                                                    'type' => 'time',
                                                    'placeholder' => 'Enter Follow-Up Date',
                                                    'model' => $followup,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Status',
                                                    'name' => 'status',
                                                    'options' => [
                                                        '' => '--Select--',
                                                        'pending' => 'Pending',
                                                        'completed' => 'Completed',
                                                        'rescheduled' => 'Rescheduled',
                                                        'cancelled' => 'Cancelled',
                                                    ],
                                                    'model' => $followup,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                <label for="remarks" class="form-label">Remarks</label>
                                                <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Enter any remarks">{{ old('remarks', $followup->remarks) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="text-start mb-3">
                                    <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                        Submit
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
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
