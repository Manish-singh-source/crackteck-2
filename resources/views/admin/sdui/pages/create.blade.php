@extends('crm.layouts.master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Create SDUI Page</h4>
                </div>
                <div class="text-end">
                    <a href="{{ route('admin.sdui.pages.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Pages
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.sdui.pages.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Page Title <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                id="title" name="title" value="{{ old('title') }}" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="slug" class="form-label">Slug</label>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                id="slug" name="slug" value="{{ old('slug') }}"
                                                placeholder="Leave empty to auto-generate">
                                            <small class="text-muted">URL-friendly identifier (e.g., login-page)</small>
                                            @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                                rows="3">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="screen_type" class="form-label">Screen Type</label>
                                            <input type="text"
                                                class="form-control @error('screen_type') is-invalid @enderror"
                                                id="screen_type" name="screen_type" value="{{ old('screen_type') }}"
                                                placeholder="e.g., login, dashboard">
                                            <small class="text-muted">Used for API filtering</small>
                                            @error('screen_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="is_active"
                                                    name="is_active" value="1"
                                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Active
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Assign Roles</label>
                                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                                @foreach ($roles as $role)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="roles[]"
                                                            value="{{ $role->id }}" id="role_{{ $role->id }}"
                                                            {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                                            {{ $role->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small class="text-muted">Leave empty for all roles</small>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="json_schema" class="form-label">JSON Schema <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control @error('json_schema') is-invalid @enderror" id="json_schema" name="json_schema"
                                                rows="20" style="font-family: monospace; font-size: 12px;" required>{{ old('json_schema', json_encode($defaultSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) }}</textarea>
                                            @error('json_schema')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Enter the complete SDUI JSON schema for this
                                                page</small>
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
                                    </div>
                                </div>

                                <div class="border-top pt-3 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Create Page
                                    </button>
                                    <a href="{{ route('admin.sdui.pages.index') }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                </div>
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
    </script>
@endsection
