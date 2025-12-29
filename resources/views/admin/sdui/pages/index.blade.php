@extends('crm.layouts.master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">SDUI Pages</h4>
                </div>
                <div class="text-end">
                    <a href="{{ route('admin.sdui.pages.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Create Page
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">All Pages</h5>
                        </div>
                        <div class="card-body">
                            <!-- Search and Filter -->
                            <form method="GET" action="{{ route('admin.sdui.pages.index') }}" class="mb-3">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search pages..." value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="role" class="form-select">
                                            <option value="">All Roles</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ request('role') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="screen_type" class="form-control"
                                            placeholder="Screen type..." value="{{ request('screen_type') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="show_deleted" value="1"
                                        id="showDeleted" {{ request('show_deleted') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="showDeleted">
                                        Show deleted pages
                                    </label>
                                </div>
                            </form>

                            <!-- Pages Table -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Slug</th>
                                            <th>Screen Type</th>
                                            <th>Roles</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pages as $page)
                                            <tr class="{{ $page->trashed() ? 'table-danger' : '' }}">
                                                <td>{{ $page->id }}</td>
                                                <td>
                                                    <strong>{{ $page->title }}</strong>
                                                    @if ($page->trashed())
                                                        <span class="badge bg-danger ms-1">Deleted</span>
                                                    @endif
                                                </td>
                                                <td><code>{{ $page->slug }}</code></td>
                                                <td>
                                                    @if ($page->screen_type)
                                                        <span class="badge bg-info">{{ $page->screen_type }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @forelse($page->roles as $role)
                                                        <span class="badge bg-secondary me-1">{{ $role->name }}</span>
                                                    @empty
                                                        <span class="text-muted">All</span>
                                                    @endforelse
                                                </td>
                                                <td>
                                                    @if ($page->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-warning">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        @if ($page->trashed())
                                                            <a href="{{ route('admin.sdui.pages.restore', $page->id) }}"
                                                                class="btn btn-sm btn-success"
                                                                onclick="return confirm('Restore this page?')">
                                                                <i class="fas fa-undo"></i>
                                                            </a>
                                                            <form
                                                                action="{{ route('admin.sdui.pages.force-delete', $page->id) }}"
                                                                method="POST" class="d-inline"
                                                                onsubmit="return confirm('Permanently delete this page? This cannot be undone!')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="{{ route('admin.sdui.pages.edit', $page->id) }}"
                                                                class="btn btn-sm btn-primary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="{{ route('admin.sdui.pages.duplicate', $page->id) }}"
                                                                class="btn btn-sm btn-info"
                                                                onclick="return confirm('Duplicate this page?')">
                                                                <i class="fas fa-copy"></i>
                                                            </a>
                                                            <form
                                                                action="{{ route('admin.sdui.pages.destroy', $page->id) }}"
                                                                method="POST" class="d-inline"
                                                                onsubmit="return confirm('Delete this page?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <p class="text-muted mb-0">No pages found.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-3">
                                {{ $pages->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
