<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    //
    public function index()
    {
        $status = request()->get('status') ?? 'all';
        $status_ecommerce = request()->get('status_ecommerce') ?? 'all';
        $query = Brand::query();
        if ($status != 'all') {
            $query->where('status', $status);
        }
        if ($status_ecommerce != 'all') {
            $query->where('status_ecommerce', $status_ecommerce);
        }
        $brand = $query->get();
        return view('e-commerce/brands/index', compact('brand'));
    }

    public function create()
    {
        return view('e-commerce/brands/create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_ecommerce' => 'required|in:active,inactive',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $brand = new Brand;
        $brand->name = $request->name;
        $brand->slug = strtolower(str_replace(' ', '-', $request->name));
        $brand->status_ecommerce = $request->status_ecommerce;
        $brand->status = $request->status;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/e-commerce/brands'), $filename);
            $brand->image = 'uploads/e-commerce/brands/' . $filename;
        }

        $brand->save();

        if (! $brand) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('brand.index')->with('success', 'Brand added successfully.');
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('e-commerce/brands/edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_ecommerce' => 'required|in:active,inactive',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->slug = strtolower(str_replace(' ', '-', $request->name));
        $brand->status_ecommerce = $request->status_ecommerce;
        $brand->status = $request->status;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($brand->image && File::exists(public_path($brand->image))) {
                File::delete(public_path($brand->image));
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/e-commerce/brands'), $filename);
            $brand->image = 'uploads/e-commerce/brands/' . $filename;
        }

        $brand->save();

        return redirect()->route('brand.index')->with('success', 'Brand updated successfully.');
    }

    public function delete($id)
    {
        $brand = Brand::withCount('products')->find($id);
        if (! $brand) {
            return back()->with('error', 'Something went wrong.');
        }

        if ($brand->products_count > 0) {
            return back()->with('error', 'Cannot delete brand with associated products.');
        }

        if ($brand->image && File::exists(public_path($brand->image))) {
            File::delete(public_path($brand->image));
        }

        $brand->delete();

        return redirect()->route('brand.index')->with('success', 'Brand deleted successfully.');
    }
}
