@extends('crm.layouts.master')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">SDUI Settings</h4>
            </div>
            <div class="text-end">
                <a href="{{ route('admin.sdui.settings.initialize') }}" class="btn btn-secondary"
                   onclick="return confirm('Initialize default settings? This will not overwrite existing settings.')">
                    <i class="fas fa-cog me-1"></i> Initialize Defaults
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form action="{{ route('admin.sdui.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    @foreach($settings as $group => $groupSettings)
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0 text-capitalize">{{ str_replace('_', ' ', $group) }} Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($groupSettings as $setting)
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                            </label>
                                            
                                            @if($setting->type === 'boolean')
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="settings[{{ $loop->parent->index }}][value]" 
                                                           value="1"
                                                           {{ $setting->getTypedValue() ? 'checked' : '' }}>
                                                    <input type="hidden" name="settings[{{ $loop->parent->index }}][key]" value="{{ $setting->key }}">
                                                    <input type="hidden" name="settings[{{ $loop->parent->index }}][type]" value="{{ $setting->type }}">
                                                    <input type="hidden" name="settings[{{ $loop->parent->index }}][group]" value="{{ $setting->group }}">
                                                </div>
                                            @elseif($setting->type === 'json')
                                                <textarea class="form-control" 
                                                          name="settings[{{ $loop->parent->index }}][value]" 
                                                          rows="4">{{ json_encode($setting->getTypedValue(), JSON_PRETTY_PRINT) }}</textarea>
                                                <input type="hidden" name="settings[{{ $loop->parent->index }}][key]" value="{{ $setting->key }}">
                                                <input type="hidden" name="settings[{{ $loop->parent->index }}][type]" value="{{ $setting->type }}">
                                                <input type="hidden" name="settings[{{ $loop->parent->index }}][group]" value="{{ $setting->group }}">
                                            @else
                                                <input type="{{ $setting->type === 'integer' ? 'number' : 'text' }}" 
                                                       class="form-control" 
                                                       name="settings[{{ $loop->parent->index }}][value]" 
                                                       value="{{ $setting->value }}">
                                                <input type="hidden" name="settings[{{ $loop->parent->index }}][key]" value="{{ $setting->key }}">
                                                <input type="hidden" name="settings[{{ $loop->parent->index }}][type]" value="{{ $setting->type }}">
                                                <input type="hidden" name="settings[{{ $loop->parent->index }}][group]" value="{{ $setting->group }}">
                                            @endif
                                            
                                            @if($setting->description)
                                                <small class="text-muted">{{ $setting->description }}</small>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add New Setting -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Add New Setting</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.sdui.settings.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="key" class="form-label">Key <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="key" name="key" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                        <select class="form-select" id="type" name="type" required>
                                            <option value="string">String</option>
                                            <option value="integer">Integer</option>
                                            <option value="boolean">Boolean</option>
                                            <option value="json">JSON</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="group" class="form-label">Group <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="group" name="group" value="general" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="value" class="form-label">Value</label>
                                        <input type="text" class="form-control" id="value" name="value">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-plus"></i> Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <input type="text" class="form-control" id="description" name="description">
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
@endsection

