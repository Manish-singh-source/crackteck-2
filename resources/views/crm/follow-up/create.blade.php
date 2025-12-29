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
                            <li class="breadcrumb-item active" aria-current="page">Add Follow-Up</li>
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

                    <form action="{{ route('follow-up.store') }}" method="POST">
                        @csrf
                        @method('POST')

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
                                            {{-- <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Lead Id',
                                                    'name' => 'lead_id',
                                                    'options' => [
                                                        '0' => '--Select Lead--',
                                                        'L-001' => 'L-001',
                                                        'L-002' => 'L-002',
                                                        'L-003' => 'L-003',
                                                        'L-004' => 'L-004',
                                                    ],
                                                ])
                                            </div> --}}
                                            <div class="col-6">
                                                <label for="warehouse" class="form-label">Lead Id <span
                                                        class="text-danger">*</span></label>
                                                <select required name="lead_id" id="lead_id" class="form-select w-100">
                                                    <option value="" selected disabled>-- Select Lead Id --</option>
                                                    @foreach ($leads as $lead)
                                                        <option value="{{ $lead->id }}"
                                                            {{ old('lead_id') == $lead->id ? 'selected' : '' }}>
                                                            {{ $lead->id . ' - ' . $lead->first_name . ' ' . $lead->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('lead_id'))
                                                    <span class="text-danger">{{ $errors->first('lead_id') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Client Name',
                                                    'name' => 'client_name',
                                                    'id' => 'client_name', // ← MUST ADD THIS
                                                    'type' => 'text',
                                                    'placeholder' => 'Select Lead',
                                                    'readonly' => true,
                                                ])

                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Contact Number',
                                                    'name' => 'contact',
                                                    'type' => 'text',
                                                    'placeholder' => 'Select Lead',
                                                    'readonly' => true,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Email ID',
                                                    'name' => 'email',
                                                    'type' => 'email',
                                                    'placeholder' => 'Select Lead',
                                                    'readonly' => true,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Follow-Up Date',
                                                    'name' => 'followup_date',
                                                    'type' => 'date',
                                                    'placeholder' => 'Enter Follow-Up Date',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Follow-Up Time',
                                                    'name' => 'followup_time',
                                                    'type' => 'time',
                                                    'placeholder' => 'Enter Follow-Up Date',
                                                ])
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.select', [
                                                    'label' => 'Status',
                                                    'name' => 'status',
                                                    'options' => [
                                                        '0' => '--Select--',
                                                        'Pending' => 'Pending',
                                                        'Done' => 'Done',
                                                        'Rescheduled' => 'Rescheduled',
                                                        'Cancelled' => 'Cancelled',
                                                    ],
                                                ])
                                            </div>

                                            <div class="col-6">
                                                <label for="remarks" class="form-label">Remarks</label>
                                                <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Enter any remarks"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <!-- <div class="text-start mb-3">
                                                            <button type="submit" class="btn btn-success w-sm waves ripple-light">
                                                                Submit
                                                            </button>
                                                        </div> -->
                            </div>


                            <div class="col-lg-12">
                                <div class="text-start mb-3">
                                    {{-- <a href="{{ route('follow-up.index') }}" class="btn btn-success w-sm waves ripple-light">
                                Submit
                            </a> --}}
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

    <script>
        document.getElementById('lead_id').addEventListener('change', function() {
            let leadId = this.value;

            if (leadId) {
                fetch(`/crm/fetch-leads/${leadId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data)
                        if (!data.error) {
                            document.querySelector('[name="client_name"]').value = data.client_name ?? '';
                            document.querySelector('[name="email"]').value = data.email ?? '';
                            document.querySelector('[name="contact"]').value = data.phone ?? '';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>
@endsection
