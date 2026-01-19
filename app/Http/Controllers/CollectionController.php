<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ParentCategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreCollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;

class CollectionController extends Controller
{
    /**
     * Display a listing of collections
     */
    public function index()
    {
        $status = request()->get('status') ?? 'all';
        $query = Collection::query();
        if ($status != 'all') {
            $query = $query->where('status', $status);
        }
        $collections = $query->with('categories')
            ->orderBy('created_at', 'desc')->get();
        return view('e-commerce.collections.index', compact('collections'));
    }

    /**
     * Show the form for creating a new collection
     */
    public function create()
    {
        return view('e-commerce.collections.create');
    }

    /**
     * Store a newly created collection in storage
     */
    public function store(StoreCollectionRequest $request)
    {
        // Image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            $uploadPath = public_path('images/collections');
            if (! File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $filename);
            $imagePath = 'images/collections/' . $filename;
        }

        // Create collection
        $collection = Collection::create([
            'name'            => $request->name,
            'slug'            => Str::slug($request->name),
            'description'     => $request->description,
            'image_url'       => $imagePath,
            'status'          => $request->status,
        ]);

        // Attach categories
        $collection->categories()->attach($request->categories);

        return redirect()
            ->route('collection.index')
            ->with('success', 'Collection created successfully.');
    }

    /**
     * Show the form for editing the specified collection
     */
    public function edit($id)
    {
        $collection = Collection::with('categories')->findOrFail($id);
        return view('e-commerce.collections.edit', compact('collection'));
    }

    /**
     * Update the specified collection in storage
     */
    public function update(UpdateCollectionRequest $request, $id)
    {
        $collection = Collection::findOrFail($id);

        // Image upload
        $imagePath = $collection->image_url;

        if ($request->hasFile('image')) {
            if ($imagePath && File::exists(public_path($imagePath))) {
                File::delete(public_path($imagePath));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            $uploadPath = public_path('images/collections');
            if (! File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $filename);
            $imagePath = 'images/collections/' . $filename;
        }

        // Update collection
        $collection->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name), // optional, if you want to update slug
            'description' => $request->description,
            'image_url'   => $imagePath,
            'status'      => $request->status,
        ]);

        // Sync categories
        $collection->categories()->sync($request->categories);

        return redirect()
            ->route('collection.index')
            ->with('success', 'Collection updated successfully.');
    }

    /**
     * Remove the specified collection from storage
     */
    public function destroy($id)
    {
        $collection = Collection::findOrFail($id);

        // Delete image file if exists
        if ($collection->image && File::exists(public_path($collection->image))) {
            File::delete(public_path($collection->image));
        }

        // Delete collection (categories will be detached automatically due to cascade)
        $collection->delete();

        return redirect()->route('collection.index')->with('success', 'Collection deleted successfully.');
    }

    /**
     * Search categories for AJAX requests
     */
    public function searchCategories(Request $request)
    {
        $query = $request->get('q', '');

        $categories = ParentCategory::withCount('products')
            ->where('name', 'LIKE', "%$query%")
            ->limit(10)
            ->get();

        return response()->json($categories);
    }
}
