@extends('crm.layouts.master')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">SDUI Components</h4>
            </div>
            <div class="text-end">
                <a href="{{ route('admin.sdui.components.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Create Component
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">All Components</h5>
                    </div>
                    <div class="card-body">
                        <!-- Filter -->
                        <form method="GET" action="{{ route('admin.sdui.components.index') }}" class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <select name="page_id" class="form-select">
                                        <option value="">All Pages</option>
                                        @foreach($pages as $p)
                                            <option value="{{ $p->id }}" {{ request('page_id') == $p->id ? 'selected' : '' }}>
                                                {{ $p->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="type" class="form-control" placeholder="Component type..." value="{{ request('type') }}">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="show_deleted" value="1" id="showDeleted" {{ request('show_deleted') ? 'checked' : '' }}>
                                <label class="form-check-label" for="showDeleted">
                                    Show deleted components
                                </label>
                            </div>
                        </form>

                        <!-- Components Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Page</th>
                                        <th>Type</th>
                                        <th>Order</th>
                                        <th>Roles</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($components as $component)
                                        <tr class="{{ $component->trashed() ? 'table-danger' : '' }}">
                                            <td>{{ $component->id }}</td>
                                            <td>
                                                <a href="{{ route('admin.sdui.pages.edit', $component->page_id) }}">
                                                    {{ $component->page->title }}
                                                </a>
                                            </td>
                                            <td><span class="badge bg-info">{{ $component->type }}</span></td>
                                            <td>{{ $component->order }}</td>
                                            <td>
                                                @forelse($component->roles as $role)
                                                    <span class="badge bg-secondary me-1">{{ $role->name }}</span>
                                                @empty
                                                    <span class="text-muted">All</span>
                                                @endforelse
                                            </td>
                                            <td>
                                                @if($component->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-warning">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if($component->trashed())
                                                        <a href="{{ route('admin.sdui.components.restore', $component->id) }}" 
                                                           class="btn btn-sm btn-success">
                                                            <i class="fas fa-undo"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.sdui.components.edit', $component->id) }}" 
                                                           class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.sdui.components.destroy', $component->id) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('Delete this component?')">
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
                                            <td colspan="7" class="text-center py-4">
                                                <p class="text-muted mb-0">No components found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-3">
                            {{ $components->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

