@extends('crm.layouts.master')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Page: {{ $page->title }}</h4>
            </div>
            <div class="text-end">
                <a href="{{ route('admin.sdui.pages.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Pages
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Page Details and JSON Editor -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Page Configuration</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.sdui.pages.update', $page->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                               id="title" name="title" value="{{ old('title', $page->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                               id="slug" name="slug" value="{{ old('slug', $page->slug) }}" required>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="2">{{ old('description', $page->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="screen_type" class="form-label">Screen Type</label>
                                        <input type="text" class="form-control @error('screen_type') is-invalid @enderror" 
                                               id="screen_type" name="screen_type" value="{{ old('screen_type', $page->screen_type) }}">
                                        @error('screen_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active" 
                                                   name="is_active" value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Assign Roles</label>
                                <div class="border rounded p-3" style="max-height: 150px; overflow-y: auto;">
                                    @foreach($roles as $role)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="roles[]" value="{{ $role->id }}" 
                                                   id="role_{{ $role->id }}"
                                                   {{ in_array($role->id, old('roles', $page->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label for="json_schema" class="form-label">JSON Schema <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('json_schema') is-invalid @enderror" 
                                          id="json_schema" name="json_schema" rows="25" 
                                          style="font-family: monospace; font-size: 12px;" required>{{ old('json_schema', json_encode($page->json_schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) }}</textarea>
                                @error('json_schema')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Edit the complete SDUI JSON schema for this page</small>
                            </div>

                            <div class="alert alert-info">
                                <strong>JSON Schema Structure:</strong>
                                <ul class="mb-0 mt-2">
                                    <li><code>version</code> - Schema version (required)</li>
                                    <li><code>metadata</code> - Page metadata (optional)</li>
                                    <li><code>components</code> - Array of UI components (required)</li>
                                    <li><code>layout</code> - Layout configuration (optional)</li>
                                </ul>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Page
                            </button>
                            <a href="{{ route('admin.sdui.pages.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Version History Sidebar -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Version History</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @forelse($page->versions->take(10) as $version)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Version {{ $version->version_number }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $version->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <a href="{{ route('admin.sdui.pages.revert', [$page->id, $version->version_number]) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           onclick="return confirm('Revert to this version? This will replace the current JSON schema.')">
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

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.sdui.pages.duplicate', $page->id) }}" class="btn btn-sm btn-info w-100 mb-2">
                            <i class="fas fa-copy me-1"></i> Duplicate Page
                        </a>
                        <form action="{{ route('admin.sdui.pages.destroy', $page->id) }}" method="POST" 
                              onsubmit="return confirm('Delete this page?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger w-100">
                                <i class="fas fa-trash me-1"></i> Delete Page
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
});

// JSON validation on submit
document.querySelector('form').addEventListener('submit', function(e) {
    const jsonSchema = document.getElementById('json_schema').value;
    try {
        JSON.parse(jsonSchema);
    } catch (error) {
        e.preventDefault();
        alert('Invalid JSON: ' + error.message);
        return false;
    }
});
</script>
@endsection

