<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SduiPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class SduiPageController extends Controller
{
    /**
     * Display a listing of pages
     */
    public function index(Request $request)
    {
        $query = SduiPage::with(['roles', 'creator', 'updater']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('screen_type', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->forRole($request->role);
        }

        // Filter by screen type
        if ($request->has('screen_type') && $request->screen_type) {
            $query->byScreenType($request->screen_type);
        }

        // Include trashed if requested
        if ($request->has('show_deleted') && $request->show_deleted) {
            $query->withTrashed();
        }

        $pages = $query->latest()->paginate(15);
        $roles = Role::all();

        return view('admin.sdui.pages.index', compact('pages', 'roles'));
    }

    /**
     * Show the form for creating a new page
     */
    public function create()
    {
        $roles = Role::all();
        $defaultSchema = SduiPage::getDefaultSchema();

        return view('admin.sdui.pages.create', compact('roles', 'defaultSchema'));
    }

    /**
     * Store a newly created page
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sdui_pages,slug',
            'description' => 'nullable|string',
            'screen_type' => 'nullable|string|max:100',
            'json_schema' => 'required|json',
            'is_active' => 'boolean',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Decode and validate JSON schema
        $jsonSchema = json_decode($validated['json_schema'], true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['json_schema' => 'Invalid JSON format: '.json_last_error_msg()])->withInput();
        }

        // Create the page
        $page = SduiPage::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'screen_type' => $validated['screen_type'] ?? null,
            'json_schema' => $jsonSchema,
            'is_active' => $request->has('is_active'),
            'created_by' => auth()->user()?->id ?? 1,
            'updated_by' => auth()->user()?->id ?? 1,
        ]);

        // Validate the JSON schema structure
        $validationErrors = $page->validateJsonSchema();
        if (! empty($validationErrors)) {
            $page->delete();

            return back()->withErrors(['json_schema' => implode(', ', $validationErrors)])->withInput();
        }

        // Sync roles
        if (isset($validated['roles'])) {
            $page->roles()->sync($validated['roles']);
        }

        flash()->success('Page created successfully!');

        return redirect()->route('admin.sdui.pages.index');
    }

    /**
     * Display the specified page
     */
    public function show($id)
    {
        $page = SduiPage::with(['roles', 'versions'])->findOrFail($id);

        return view('admin.sdui.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified page
     */
    public function edit($id)
    {
        $page = SduiPage::with(['roles', 'versions'])->findOrFail($id);
        $roles = Role::all();

        return view('admin.sdui.pages.edit', compact('page', 'roles'));
    }

    /**
     * Update the specified page
     */
    public function update(Request $request, $id)
    {
        $page = SduiPage::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:sdui_pages,slug,'.$id,
            'description' => 'nullable|string',
            'screen_type' => 'nullable|string|max:100',
            'json_schema' => 'required|json',
            'is_active' => 'boolean',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Decode and validate JSON schema
        $jsonSchema = json_decode($validated['json_schema'], true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['json_schema' => 'Invalid JSON format: '.json_last_error_msg()])->withInput();
        }

        // Temporarily update to validate
        $page->json_schema = $jsonSchema;
        $validationErrors = $page->validateJsonSchema();

        if (! empty($validationErrors)) {
            return back()->withErrors(['json_schema' => implode(', ', $validationErrors)])->withInput();
        }

        // Update the page
        $page->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'screen_type' => $validated['screen_type'] ?? null,
            'json_schema' => $jsonSchema,
            'is_active' => $request->has('is_active'),
            'updated_by' => auth()->user()?->id ?? 1,
        ]);

        // Sync roles
        if (isset($validated['roles'])) {
            $page->roles()->sync($validated['roles']);
        } else {
            $page->roles()->sync([]);
        }

        flash()->success('Page updated successfully!');

        return redirect()->route('admin.sdui.pages.edit', $page->id);
    }

    /**
     * Remove the specified page (soft delete)
     */
    public function destroy($id)
    {
        $page = SduiPage::findOrFail($id);
        $page->delete();

        flash()->success('Page deleted successfully!');

        return redirect()->route('admin.sdui.pages.index');
    }

    /**
     * Restore a soft-deleted page
     */
    public function restore($id)
    {
        $page = SduiPage::withTrashed()->findOrFail($id);
        $page->restore();

        flash()->success('Page restored successfully!');

        return redirect()->route('admin.sdui.pages.index');
    }

    /**
     * Permanently delete a page
     */
    public function forceDelete($id)
    {
        $page = SduiPage::withTrashed()->findOrFail($id);
        $page->forceDelete();

        flash()->success('Page permanently deleted!');

        return redirect()->route('admin.sdui.pages.index');
    }

    /**
     * Revert to a specific version
     */
    public function revert($id, $versionNumber)
    {
        $page = SduiPage::findOrFail($id);

        if ($page->revertToVersion($versionNumber)) {
            flash()->success('Page reverted to version '.$versionNumber.' successfully!');
        } else {
            flash()->error('Failed to revert to version '.$versionNumber);
        }

        return redirect()->route('admin.sdui.pages.edit', $id);
    }

    /**
     * Show version history
     */
    public function versions($id)
    {
        $page = SduiPage::with('versions')->findOrFail($id);

        return view('admin.sdui.pages.versions', compact('page'));
    }

    /**
     * Duplicate a page
     */
    public function duplicate($id)
    {
        $originalPage = SduiPage::with('roles')->findOrFail($id);

        $newPage = $originalPage->replicate();
        $newPage->title = $originalPage->title.' (Copy)';
        $newPage->slug = $originalPage->slug.'-copy-'.time();
        $newPage->created_by = auth()->user()?->id ?? 1;
        $newPage->updated_by = auth()->user()?->id ?? 1;
        $newPage->save();

        // Sync roles
        $newPage->roles()->sync($originalPage->roles->pluck('id'));

        flash()->success('Page duplicated successfully!');

        return redirect()->route('admin.sdui.pages.edit', $newPage->id);
    }
}
