<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\ParentCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategorieController extends Controller
{
    //
    public function index()
    {
        $status = request()->get('status') ?? 'all';
        $status_ecommerce = request()->get('status_ecommerce') ?? 'all';
        $query = ParentCategory::query();

        if ($status != 'all') {
            $query->where('status', $status);
        }

        if ($status_ecommerce != 'all') {
            $query->where('status_ecommerce', $status_ecommerce);
        }

        $parentCategorie = $query->get();

        return view('/e-commerce/categories/index', compact('parentCategorie'));
    }

    public function storeParent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:parent_categories,name,NULL,id,deleted_at,NULL',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:inactive,active',
            'status_ecommerce' => 'required|in:inactive,active',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // sort order
        $sortOrder = ParentCategory::max('sort_order') + 1;
        if ($sortOrder == 0) {
            $sortOrder = 1;
        }

        $parentCategorie = new ParentCategory;
        $parentCategorie->name = $request->name;
        $parentCategorie->slug = strtolower(str_replace(' ', '-', $request->name));
        $parentCategorie->sort_order = $sortOrder;
        $parentCategorie->status = $request->status;
        $parentCategorie->status_ecommerce = $request->status_ecommerce;

        if ($request->hasFile('image')) {
            $parentCategorie->image = FileUpload::fileUpload($request->file('image'), 'uploads/e-commerce/categories');
        }

        $parentCategorie->save();

        if (! $parentCategorie) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('category.index')->with('success', 'Parent Category added successfully.');
    }

    public function storeSubCategorie(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_category_id' => 'required|exists:parent_categories,id',
            'name' => 'required|string|max:255|unique:sub_categories,name,NULL,id,deleted_at,NULL',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:inactive,active',
            'status_ecommerce' => 'required|in:no,yes',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('image')) {
            $image = FileUpload::fileUpload($request->file('image'), 'uploads/e-commerce/categories');
        }

        if ($request->hasFile('icon_image')) {
            $icon_image = FileUpload::fileUpload($request->file('icon_image'), 'uploads/e-commerce/categories');
        }

        $subCategorie = SubCategory::create([
            'parent_category_id' => $request->parent_category_id,
            'name' => $request->name,
            'status' => $request->status,
            'status_ecommerce' => $request->status_ecommerce,
            'image' => $image ?? null,
            'icon_image' => $icon_image ?? null,
        ]);

        if (! $subCategorie) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->back()->with('success', 'Sub Category added successfully.');
    }

    public function parentCategorie($id)
    {
        $parentCategorie = ParentCategory::with('subCategories')->findOrFail($id);
        $subCategories = SubCategory::where('parent_category_id', $id)->get();

        return view('/e-commerce/categories/view', compact('parentCategorie', 'subCategories'));
    }

    public function getSubcategories(Request $request)
    {
        $parentId = $request->parent_category_id;

        $subcategories = SubCategory::where('parent_category_id', $parentId)
            ->pluck('name', 'id');

        return response()->json($subcategories);
    }

    public function delete($id)
    {
        $parentCategorie = ParentCategory::findOrFail($id);
        $parentCategorie->delete();

        return redirect()->route('category.index')->with('success', 'Parent Category deleted successfully.');
    }

    public function edit($id)
    {
        $parentCategorie = ParentCategory::findOrFail($id);
        $subCategories = SubCategory::where('parent_category_id', $id)->get();

        return view('/e-commerce/categories/edit', compact('parentCategorie', 'subCategories'));
    }

    public function editChild($id)
    {
        $subCategorie = SubCategory::findOrFail($id);
        $parentCategories = ParentCategory::where('status', 'Active')->get();

        return view('/e-commerce/categories/edit-child', compact('subCategorie', 'parentCategories'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:sub_categories,name,' . $id . ',id,deleted_at,NULL',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:inactive,active',
            'status_ecommerce' => 'required|in:inactive,active',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $parentCategorie = ParentCategory::findOrFail($id);
        $parentCategorie->name = $request->name;
        $parentCategorie->status = $request->status;
        $parentCategorie->status_ecommerce = $request->status_ecommerce;

        if ($request->hasFile('image')) {
            $parentCategorie->image = FileUpload::updateFileUpload($request->file('image'), $parentCategorie->image, 'uploads/e-commerce/categories');
        }

        $parentCategorie->save();

        return redirect()->route('category.index')->with('success', 'Parent Category updated successfully.');
    }

    public function updateChild(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'parent_category_id' => 'required|exists:parent_categories,id',
            'name' => 'required|string|max:255|unique:sub_categories,name,' . $id . ',id,deleted_at,NULL',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:inactive,active',
            'status_ecommerce' => 'required|in:no,yes',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $subCategorie = SubCategory::findOrFail($id);
        $subCategorie->parent_category_id = $request->parent_category_id;
        $subCategorie->name = $request->name;
        $subCategorie->status = $request->status;
        $subCategorie->status_ecommerce = $request->status_ecommerce;

        // Handle image upload
        if ($request->hasFile('image')) {
            $subCategorie->image = FileUpload::updateFileUpload($request->file('image'), $subCategorie->image, 'uploads/e-commerce/categories');
        }

        if ($request->hasFile('icon_image')) {
            $subCategorie->icon_image = FileUpload::updateFileUpload($request->file('icon_image'), $subCategorie->icon_image, 'uploads/e-commerce/categories');
        }

        $subCategorie->save();

        return redirect()->back()->with('success', 'Sub Category updated successfully.');
    }

    public function destroyChild($id)
    {
        $subCategorie = SubCategory::findOrFail($id);
        $subCategorie->delete();

        return redirect()->back()->with('success', 'Sub Category deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:parent_categories,id',
            'categories.*.sort_order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            foreach ($request->categories as $categoryData) {
                ParentCategory::where('id', $categoryData['id'])
                    ->update(['sort_order' => $categoryData['sort_order']]);
            }

            return response()->json(['success' => true, 'message' => 'Category order updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update category order.'], 500);
        }
    }

    /**
     * Get child category data for AJAX requests
     */
    public function getChildCategoryData($id)
    {
        try {
            $subCategorie = SubCategory::find($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $subCategorie->id,
                    'name' => $subCategorie->name,
                    'parent_category_id' => $subCategorie->parent_category_id,
                    'image' => $subCategorie->image,
                    'icon_image' => $subCategorie->icon_image,
                    'status' => $subCategorie->status,
                    'status_ecommerce' => $subCategorie->status_ecommerce,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Child category not found.',
            ], 404);
        }
    }

    public function checkSortOrderUnique(Request $request)
    {
        $sortOrder = $request->input('sort_order');
        $id = $request->input('id');

        $exists = ParentCategory::where('sort_order', $sortOrder)
            ->where('id', '!=', $id)
            ->exists();

        return response()->json([
            'exists' => $exists,
        ]);
    }

    public function getCategories()
    {
        $categories = ParentCategory::where('status', 'Active')
            ->where('status_ecommerce', true)
            ->pluck('name', 'id');

        return response()->json($categories);
    }
}
