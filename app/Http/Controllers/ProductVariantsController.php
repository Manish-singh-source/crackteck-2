<?php

namespace App\Http\Controllers;

use App\Models\ProductVariantAttribute;
use App\Models\ProductVariantAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductVariantsController extends Controller
{
    //
    public function index()
    {
        $status = request()->get('status') ?? 'all';
        $query = ProductVariantAttribute::query();
        if ($status != 'all') {
            $query->where('status', $status);
        }
        $attributeName = $query->get();
        return view('/e-commerce/product-variants/index', compact('attributeName'));
    }


    public function storeAttribute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $attributeName = new ProductVariantAttribute;
        $attributeName->attribute_code = strtolower(str_replace(' ', '-', $request->name));
        $attributeName->name = $request->name;
        $attributeName->status = $request->status;
        $attributeName->save();

        if (! $attributeName) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('variant.index')->with('success', 'Product Variant Attribute added successfully.');
    }

    public function view($id)
    {
        $attributeName = ProductVariantAttribute::findOrFail($id);
        $attributeValue = ProductVariantAttributeValue::where('attribute_id', $id)->get();

        return view('/e-commerce/product-variants/view', compact('attributeName', 'attributeValue'));
    }

    public function editAttribute($id)
    {
        $attributeName = ProductVariantAttribute::findOrFail($id);

        return view('/e-commerce/product-variants/edit', compact('attributeName'));
    }


    public function deleteAttribute($id)
    {
        $attributeName = ProductVariantAttribute::findOrFail($id);
        $attributeName->delete();

        return redirect()->route('variant.index')->with('success', 'Product Variant deleted successfully.');
    }

    public function updateAttribute(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $attributeName = ProductVariantAttribute::findOrFail($id);
        $attributeName->name = $request->name;
        $attributeName->status = $request->status;
        $attributeName->save();

        if (! $attributeName) {
            return back()->with('error', 'Something went wrong.');
        }

        return back()->with('success', 'Product Variant updated successfully.');
    }

    public function storeAttributeValue(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attribute_id' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $attributeValue = new ProductVariantAttributeValue;
        $attributeValue->attribute_id = $request->attribute_id;
        $attributeValue->value = $request->value;
        $attributeValue->save();

        if (! $attributeValue) {
            return back()->with('error', 'Something went wrong.');
        }

        return back()->with('success', 'Product Variant Attribute Value added successfully.');
    }

    public function updateAttributeValue(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $attributeValue = ProductVariantAttributeValue::find($id);
        $attributeValue->value = $request->value;
        $attributeValue->save();

        if (! $attributeValue) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('variant.view', $attributeValue->attribute_id)->with('success', 'Product Variant updated successfully.');
    }

    public function deleteAttributeValue($id)
    {
        $attributeValue = ProductVariantAttributeValue::findOrFail($id);
        $attributeValue->delete();

        return back()->with('success', 'Product Variant deleted successfully.');
    }
}
