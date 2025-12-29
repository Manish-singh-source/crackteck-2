@extends('crm.layouts.master')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Component</h4>
            </div>
            <div class="text-end">
                <a href="{{ route('admin.sdui.pages.edit', $component->page_id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Page
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.sdui.components.update', $component->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="page_id" class="form-label">Page <span class="text-danger">*</span></label>
                                <select class="form-select @error('page_id') is-invalid @enderror" 
                                        id="page_id" name="page_id" required>
                                    @foreach($pages as $page)
                                        <option value="{{ $page->id }}" {{ old('page_id', $component->page_id) == $page->id ? 'selected' : '' }}>
                                            {{ $page->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('page_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" 
                                        id="type" name="type" required>
                                    @foreach($componentTypes as $key => $label)
                                        <option value="{{ $key }}" {{ old('type', $component->type) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="props" class="form-label">Props (JSON) <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('props') is-invalid @enderror" 
                                          id="props" name="props" rows="15" required>{{ old('props', json_encode($component->props, JSON_PRETTY_PRINT)) }}</textarea>
                                @error('props')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="order" class="form-label">Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                       id="order" name="order" value="{{ old('order', $component->order) }}" required>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" 
                                           name="is_active" value="1" {{ old('is_active', $component->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Assign Roles (Optional)</label>
                                <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                    @foreach($roles as $role)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="roles[]" value="{{ $role->id }}" 
                                                   id="role_{{ $role->id }}"
                                                   {{ in_array($role->id, old('roles', $component->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="border-top pt-3 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Update Component
                                </button>
                                <a href="{{ route('admin.sdui.pages.edit', $component->page_id) }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Version History -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Version History</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @forelse($component->versions->take(5) as $version)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Version {{ $version->version_number }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $version->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <a href="{{ route('admin.sdui.components.revert', [$component->id, $version->version_number]) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           onclick="return confirm('Revert to this version?')">
                                            <i class="fas fa-undo"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">No version history</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

