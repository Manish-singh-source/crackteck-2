<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\ParentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CollectionController extends Controller
{
    /**
     * Display a listing of collections
     */
    public function index()
    {
        $collections = Collection::with('categories')->orderBy('created_at', 'desc')->get();

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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|boolean',
            'is_active' => 'required|boolean',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:parent_categories,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();

            // Create directory if it doesn't exist
            $uploadPath = public_path('images/collections');
            if (! File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $filename);
            $imagePath = 'images/collections/'.$filename;
        }

        // Create collection
        $collection = Collection::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->status,
            'is_active' => $request->is_active,
        ]);

        // Attach categories
        $collection->categories()->attach($request->categories);

        return redirect()->route('collection.index')->with('success', 'Collection created successfully.');
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
    public function update(Request $request, $id)
    {
        $collection = Collection::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|boolean',
            'is_active' => 'required|boolean',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:parent_categories,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle image upload
        $imagePath = $collection->image; // Keep existing image by default
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($collection->image && File::exists(public_path($collection->image))) {
                File::delete(public_path($collection->image));
            }

            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();

            // Create directory if it doesn't exist
            $uploadPath = public_path('images/collections');
            if (! File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $filename);
            $imagePath = 'images/collections/'.$filename;
        }

        // Update collection
        $collection->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->status,
            'is_active' => $request->is_active,
        ]);

        // Sync categories
        $collection->categories()->sync($request->categories);

        return redirect()->route('collection.index')->with('success', 'Collection updated successfully.');
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

        $categories = ParentCategory::where('name', 'LIKE', "%$query%")
            ->select('id', 'name')
            ->limit(10)
            ->get();

        return response()->json($categories);
    }
}
