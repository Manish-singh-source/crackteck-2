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
        $brand = Brand::all();

        return view('e-commerce/brands/index', compact('brand'));
    }

    public function create()
    {
        return view('e-commerce/brands/create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required',
            'status_ecommerce' => 'required',
            'status' => 'required',
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
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/e-commerce/brands'), $filename);
            $brand->image = 'uploads/e-commerce/brands/'.$filename;
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
            'name' => 'required',
            'status_ecommerce' => 'required',
            'status' => 'required',
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
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/e-commerce/brands'), $filename);
            $brand->image = 'uploads/e-commerce/brands/'.$filename;
        }

        $brand->save();

        return redirect()->route('brand.index')->with('success', 'Brand updated successfully.');
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->route('brand.index')->with('success', 'Brand deleted successfully.');
    }
}
