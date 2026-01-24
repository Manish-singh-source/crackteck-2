@extends('crm/layouts/master')

@section('content')
    <div class="content">


        <div class="container-fluid">

            <div class="bradcrumb pt-3 ps-2 bg-light">
                <div class="row ">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Meetings</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Meeting Details</li>
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
                    <form action="{{ route('meets.update', $meet->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0">
                                                    Meeting Scheduler
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label for="lead_id" class="form-label">Lead Id <span
                                                        class="text-danger">*</span></label>
                                                <input type="hidden" name="lead_id" value="{{ $meet->lead_id }}">
                                                <input type="text" class="form-control"
                                                    value="{{ $meet->lead_id }} - {{ $meet->leadDetails->lead_number }}"
                                                    disabled>
                                            </div>

                                            <div class="col-6">
                                                <label for="client_name" class="form-label">Client / Lead Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="client_name"
                                                    value="{{ $meet->leadDetails->customer->first_name }} {{ $meet->leadDetails->customer->last_name }}"
                                                    disabled>
                                            </div>

                                            <div class="col-6">
                                                <label for="staff_name" class="form-label">Sales Person Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="staff_name"
                                                    value="{{ $meet->staffDetails->first_name }} {{ $meet->staffDetails->last_name }}"
                                                    disabled>
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Meeting Title',
                                                    'name' => 'meet_title',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Meeting Title',
                                                    'model' => $meet,
                                                    'disabled' => true,
                                                ])
                                            </div>

                                            <div class="col-3">
                                                @include('components.form.select', [
                                                    'label' => 'Meeting Type',
                                                    'name' => 'meeting_type',
                                                    'options' => [
                                                        '' => '--Select Meeting Type--',
                                                        'onsite_demo' => 'Onsite Demo',
                                                        'virtual_meeting' => 'Virtual Meeting',
                                                        'technical_visit' => 'Technical Visit',
                                                        'business_meeting' => 'Business Meeting',
                                                        'other' => 'Other',
                                                    ],
                                                    'model' => $meet,
                                                ])
                                            </div>

                                            <div class="col-3">
                                                @include('components.form.input', [
                                                    'label' => 'Start Date',
                                                    'name' => 'date',
                                                    'type' => 'date',
                                                    'model' => $meet,
                                                ])
                                            </div>

                                            <div class="col-3">
                                                @include('components.form.input', [
                                                    'label' => 'Start Time',
                                                    'name' => 'start_time',
                                                    'type' => 'time',
                                                    'model' => $meet,
                                                ])
                                            </div>

                                            <div class="col-3">
                                                @include('components.form.input', [
                                                    'label' => 'End Time',
                                                    'name' => 'end_time',
                                                    'type' => 'time',
                                                    'model' => $meet,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                <label for="meetAgenda" class="form-label">Meeting Agenda<span
                                                        class="text-danger">*</span></label>
                                                <textarea name="meet_agenda" id="meet_agenda" class="form-control"> {{ $meet->meet_agenda }} </textarea>
                                            </div>

                                            <div class="col-6">
                                                <label for="followUp" class="form-label">Follow-up Task<span
                                                        class="text-danger">*</span></label>
                                                <textarea name="follow_up_action" id="follow_up_action" class="form-control"> {{ $meet->follow_up_action }} </textarea>
                                            </div>

                                            <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Location / Meeting Link',
                                                    'name' => 'location',
                                                    'type' => 'text',
                                                    'placeholder' => 'Enter Location / Meeting Link',
                                                    'model' => $meet,
                                                ])
                                            </div>

                                            {{-- <div class="col-6">
                                                @include('components.form.input', [
                                                    'label' => 'Attachments',
                                                    'name' => 'attachment',
                                                    'type' => 'file',
                                                    'placeholder' => 'Enter Attachments',
                                                    'model' => $meet,
                                                ])
                                                @if ($meet->attachment)
                                                    <a href="{{ asset('uploads/crm/meets/' . $meet->attachment) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                                @endif
                                            </div> --}}

                                            <div class="col-3">
                                                <label class="form-label">Attachments</label>

                                                <div class="input-group">
                                                    <input type="file" name="attachment" class="form-control">

                                                    @if ($meet->attachment)
                                                        <a href="{{ asset('uploads/crm/meets/' . $meet->attachment) }}"
                                                            target="_blank" class="btn btn-outline-primary">
                                                            <i class="mdi mdi-eye-outline"></i>
                                                        </a>
                                                    @endif
                                                </div>

                                                @if ($meet->attachment)
                                                    <small class="text-muted d-block mt-1">
                                                        Current: {{ $meet->attachment }}
                                                    </small>
                                                @endif
                                            </div>


                                            <div class="col-3">
                                                @include('components.form.select', [
                                                    'label' => 'Status',
                                                    'name' => 'status',
                                                    'options' => [
                                                        '' => '--Select Sales Rep--',
                                                        'scheduled' => 'Scheduled',
                                                        'confirmed' => 'Confirmed',
                                                        'completed' => 'Completed',
                                                        'cancelled' => 'Cancelled',
                                                        'rescheduled' => 'Rescheduled',
                                                    ],
                                                    'model' => $meet,
                                                ])
                                            </div>

                                            <div class="col-6">
                                                <label for="meeting_notes" class="form-label">Meeting Notes<span
                                                        class="text-danger">*</span></label>
                                                <textarea name="meeting_notes" id="meeting_notes" class="form-control"> {{ $meet->meeting_notes }} </textarea>
                                            </div>

                                            <div class="col-6">
                                                <label class="form-label">Attendees</label>
                                                <div id="attendee-input-container" class="d-flex">
                                                    <input type="text" id="new-attendee" class="form-control" placeholder="Enter attendee name">
                                                    <button type="button" id="add-attendee" class="btn btn-primary" style="display:none; margin-left:15px">Add</button>
                                                </div>
                                                <div id="attendees-list" class="mt-2">
                                                    @php
                                                        $attendees = is_array($meet->attendees) ? $meet->attendees : (isset($meet->attendees) ? explode(',', $meet->attendees) : []);
                                                    @endphp
                                                    @foreach($attendees as $attendee)
                                                        @if(trim($attendee))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="attendees[]" value="{{ trim($attendee) }}" checked>
                                                                <label class="form-check-label">{{ trim($attendee) }}</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
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
            $('#new-attendee').on('input', function() {
                if ($(this).val().trim() !== '') {
                    $('#add-attendee').show();
                } else {
                    $('#add-attendee').hide();
                }
            });

            $('#add-attendee').on('click', function() {
                var name = $('#new-attendee').val().trim();
                if (name !== '') {
                    $('#attendees-list').append('<div class="form-check"><input class="form-check-input" type="checkbox" name="attendees[]" value="' + name + '" checked><label class="form-check-label">' + name + '</label></div>');
                    $('#new-attendee').val('');
                    $('#add-attendee').hide();
                }
            });

            $('#attendees-list').on('change', '.form-check-input', function() {
                if (!$(this).is(':checked')) {
                    $(this).closest('.form-check').remove();
                }
            });
        });
    </script>
@endsection
