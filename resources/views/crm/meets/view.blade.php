@extends('crm/layouts/master')

@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12 mx-auto my-3">

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                Meeting Details
                            </h5>
                            <div>
                                {{ $meet->id }}
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">


                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush ">
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Lead Id :
                                        </span>
                                        <span>
                                            {{ $meet->lead_id ?? 'N/A' }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Client/Lead :
                                        </span>
                                        <span>
                                            {{ $meet->client_name ?? 'N/A' }}
                                        </span>
                                    </li>      
                                    
                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Meeting Title :
                                        </span>
                                        <span>
                                            {{ $meet->meet_title ?? 'N/A' }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Meeting Type :
                                        </span>
                                        <span>
                                            {{ $meet->meeting_type ?? 'N/A' }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Date & Time :
                                        </span>
                                        <span>
                                            {{ $meet->date }} - {{ $meet->time }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Location :
                                        </span>
                                        <span>
                                            {{ $meet->location ?? 'N/A' }}
                                        </span>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush ">

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break"> Meeting Agenda :
                                        </span>
                                        <span>
                                            {{ $meet->meetAgenda ?? 'N/A' }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break"> Follow-up Task :
                                        </span>
                                        <span>
                                            {{ $meet->followUp ?? 'N/A' }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Attachments :
                                        </span>
                                        <span>
                                            @if($meet->attachment)
                                                <a href="{{ asset('uploads/crm/meets/' . $meet->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                            @else
                                                <span class="text-muted">No attachment</span>
                                            @endif
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Follow-up Task :
                                        </span>
                                        <span>
                                            {{ $meet->followUp ?? 'N/A' }}
                                        </span>
                                    </li>

                                    <li class="list-group-item border-0 d-flex align-items-center gap-3 flex-wrap">
                                        <span class="fw-semibold text-break">Status :
                                        </span>
                                        <span class="badge bg-primary-subtle text-primary fw-semibold">
                                            {{ $meet->status ?? 'N/A' }}
                                        </span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div> <!-- content -->


<!-- JavaScript -->
<script>
    $(document).ready(function() {
        $(".hide-section").hide();
        $(".hide-report-section").hide();
        $(".hide-assign-eng-section").hide();
        $(".hide-selected-engineers-section").hide();

        $("#eng-location").on("change", function() {
            $(".hide-assign-eng-section").show();
            $(".hide-section").show();
        });

        $(".eng-assign").on("change", function() {
            $(".hide-assign-eng-section").show();
            $(".hide-section").show();
            $("#groupDropdown").fadeToggle();
            $("#individualDropdown").fadeToggle();
        });

        $(".assign-eng-btn").on("click", function() {
            $(".hide-section").hide();
            $(".hide-assign-eng-section").hide();
            $(".hide-selected-engineers-section").show();
            $(".hide-report-section").show();

        });

        $(".show-report").on("click", function() {
            $("#popupOverlay").css("display", "flex");
        });

        $(".hide-report").on("click", function() {
            $("#popupOverlay").hide();
        });

        $(".add-engineer").on("click", function() {
            const $selectedOptions = $('#groupDropdown1 option:selected');
            const $tableBody = $('#selectedTable tbody');

            $selectedOptions.each(function() {
                const optionText = $(this).text();

                // Append row to table
                const newRow = `
                    <tr>
                        <td>${optionText}</td>
                        <td><input type="checkbox" class="form-check-input" /></td>
                    </tr>
                `;
                $tableBody.append(newRow);

                // Remove option from the select dropdown
                $(this).remove();
            });
        });

    });
</script>

@endsection