@extends('warehouse/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Add Rack</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Rack Details</h5>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <form action="{{ route('rack.store') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="row g-3 pb-3">
                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            <label for="warehouse" class="form-label">Warehouse Name <span
                                                    class="text-danger">*</span></label>
                                            <select required name="warehouse_id" id="warehouse" class="form-select w-100">
                                                <option value="" selected disabled>-- Select Warehouse --</option>
                                                @foreach ($warehouses as $warehouse)
                                                    <option value="{{ $warehouse->id }}"
                                                        {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                                        {{ $warehouse->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('warehouse_id'))
                                                <span class="text-danger">{{ $errors->first('warehouse_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Rack Name',
                                                'name' => 'rack_name',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Rack Name',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Zone Area',
                                                'name' => 'zone_area',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Zone Area',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Rack No',
                                                'name' => 'rack_no',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Rack No',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Level No',
                                                'name' => 'level_no',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Level No',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Position No',
                                                'name' => 'position_no',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Position No',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Floor',
                                                'name' => 'floor',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Floor No',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div>
                                            @include('components.form.input', [
                                                'label' => 'Quantity',
                                                'name' => 'quantity',
                                                'type' => 'text',
                                                'placeholder' => 'Enter Quantity',
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-start">
                                            {{-- <a href="{{ route('rack.index') }}" class="btn btn-success">
                                            Add
                                        </a> --}}
                                            <button type="submit" class="btn btn-success">
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection
