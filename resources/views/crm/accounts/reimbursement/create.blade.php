@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Create Staff Reimbursement</h4>
                </div>
                <div>
                    <a href="{{ route('reimbursement') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Reimbursement Details</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reimbursement.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3 pb-3">

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label class="form-label">Staff Type <span class="text-danger">*</span></label>
                                            <select name="staff_type" id="staff_type" class="form-select" required>
                                                <option value="">-- Select Staff Type --</option>
                                                <option value="engineer">Engineer</option>
                                                <option value="delivery_man">Delivery Man</option>
                                            </select>
                                            @error('staff_type')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label class="form-label">Staff <span class="text-danger">*</span></label>
                                            <select name="staff_id" id="staff_id" class="form-select" required>
                                                <option value="">-- Select Staff Type First --</option>
                                                @foreach ($staff as $staffMember)
                                                    <option value="{{ $staffMember->id }}"
                                                        data-staff-type="{{ $staffMember->staff_role }}">
                                                        {{ $staffMember->first_name }} {{ $staffMember->last_name }}
                                                        ({{ $staffMember->staff_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('staff_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                        <div>
                                            <label class="form-label">Amount <span class="text-danger">*</span></label>
                                            <input type="number" name="amount" class="form-control"
                                                placeholder="Enter Amount" step="0.01" min="0" required>
                                            @error('amount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-lg-12">
                                        <div>
                                            <label class="form-label">Reason <span class="text-danger">*</span></label>
                                            <textarea name="reason" class="form-control" rows="3" placeholder="Enter Reason for expense" required></textarea>
                                            @error('reason')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            <label class="form-label">Receipt</label>
                                            <input type="file" name="receipt" class="form-control"
                                                accept=".jpg,.jpeg,.png,.pdf">
                                            <small class="text-muted">Accepted formats: JPG, JPEG, PNG, PDF (Max:
                                                2MB)</small>
                                            @error('receipt')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">Submit Expense</button>
                                            <a href="{{ route('reimbursement') }}"
                                                class="btn btn-secondary">Cancel</a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const staffTypeSelect = document.getElementById('staff_type');
            const staffSelect = document.getElementById('staff_id');
            const staffOptions = staffSelect.querySelectorAll('option');

            function filterStaff() {
                const selectedType = staffTypeSelect.value;

                staffOptions.forEach(option => {
                    if (option.value === '') return; // Skip the default option

                    const optionStaffType = option.getAttribute('data-staff-type');
                    if (selectedType === '' || optionStaffType === selectedType) {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                });

                // Update default option text based on selection
                const defaultOption = staffSelect.querySelector('option[value=""]');
                if (selectedType === '') {
                    defaultOption.textContent = '-- Select Staff Type First --';
                } else {
                    defaultOption.textContent = '-- Select Staff --';
                }
                defaultOption.selected = true;
            }

            staffTypeSelect.addEventListener('change', filterStaff);

            // Initial filter on page load (hide all staff until type is selected)
            staffOptions.forEach(option => {
                if (option.value !== '') {
                    option.style.display = 'none';
                }
            });
        });
    </script>
@endsection
