<?php

namespace App\Http\Controllers;

use App\Models\PromotionalBanner;
use App\Models\WebsiteBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    //
    public function websiteBanner()
    {
        $website = WebsiteBanner::ordered()->get();

        return view('/e-commerce/banner/website-banner/index', compact('website'));
    }

    public function addWebsiteBanner()
    {
        return view('/e-commerce/banner/website-banner/create');
    }

    public function storeWebsiteBanner(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'banner_title' => 'required|min:3',
            'banner_heading' => 'nullable|string|max:255',
            'banner_sub_heading' => 'nullable|string|max:255',
            'banner_url' => 'required|min:3',
            'banner_description' => 'required|min:15',
            'button_text' => 'nullable|string|max:100',
            'website_banner' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Get the next sort order
        $maxSortOrder = WebsiteBanner::max('sort_order') ?? 0;

        $websiteBanner = new WebsiteBanner;
        $websiteBanner->banner_title = $request->banner_title;
        $websiteBanner->banner_heading = $request->banner_heading;
        $websiteBanner->banner_sub_heading = $request->banner_sub_heading;
        $websiteBanner->banner_url = $request->banner_url;
        $websiteBanner->banner_description = $request->banner_description;
        $websiteBanner->button_text = $request->button_text;
        $websiteBanner->sort_order = $maxSortOrder + 1;

        if ($request->hasFile('website_banner')) {
            $file = $request->file('website_banner');
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/e-commerce/banner/website_banner'), $filename);
            $websiteBanner->website_banner = 'uploads/e-commerce/banner/website_banner/'.$filename;
        }

        $websiteBanner->status = $request->status;

        $websiteBanner->save();

        if (! $websiteBanner) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('website.banner.index')->with('success', 'Banner added successfully.');
    }

    public function editWebsiteBanner($id)
    {
        $website = WebsiteBanner::find($id);

        return view('/e-commerce/banner/website-banner/edit', compact('website'));
    }

    public function updateWebsiteBanner(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'banner_title' => 'required|min:3',
            'banner_heading' => 'nullable|string|max:255',
            'banner_sub_heading' => 'nullable|string|max:255',
            'banner_url' => 'required|min:3',
            'banner_description' => 'required|min:15',
            'button_text' => 'nullable|string|max:100',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $websiteBanner = WebsiteBanner::findOrFail($id);
        $websiteBanner->banner_title = $request->banner_title;
        $websiteBanner->banner_heading = $request->banner_heading;
        $websiteBanner->banner_sub_heading = $request->banner_sub_heading;
        $websiteBanner->banner_url = $request->banner_url;
        $websiteBanner->banner_description = $request->banner_description;
        $websiteBanner->button_text = $request->button_text;

        if ($request->hasFile('website_banner')) {

            // Only if updating profile
            if ($websiteBanner->website_banner != '') {
                if (File::exists(public_path($websiteBanner->website_banner))) {
                    File::delete(public_path($websiteBanner->website_banner));
                }
            }
            // updating profile end

            $file = $request->file('website_banner');
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/e-commerce/banner/website_banner'), $filename);
            $websiteBanner->website_banner = 'uploads/e-commerce/banner/website_banner/'.$filename;
        }

        $websiteBanner->status = $request->status;
        $websiteBanner->save();

        return redirect()->route('website.banner.index')->with('success', 'Banner updated successfully.');
    }

    public function deleteWebsiteBanner($id)
    {
        $website = WebsiteBanner::findOrFail($id);
        $website->delete();

        return redirect()->route('website.banner.index')->with('success', 'Website Banner deleted successfully.');
    }

    public function promotionalBanner()
    {
        $promotionalBanner = PromotionalBanner::all();

        return view('/e-commerce/banner/promotional-banner/index', compact('promotionalBanner'));
    }

    public function addPromotionalBanner()
    {
        return view('/e-commerce/banner/promotional-banner/create');
    }

    public function storePromotionalBanner(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'banner_title' => 'required|min:3',
            'banner_url' => 'required|min:3',
            'banner_description' => 'required|min:15',
            'promotional_banner' => 'required',
            'start_datetime' => 'required',
            'end_datetime' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $promotionalBanner = new PromotionalBanner;
        $promotionalBanner->banner_title = $request->banner_title;
        $promotionalBanner->banner_url = $request->banner_url;
        $promotionalBanner->banner_description = $request->banner_description;

        if ($request->hasFile('promotional_banner')) {
            $file = $request->file('promotional_banner');
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/e-commerce/banner/promotional_banner'), $filename);
            $promotionalBanner->promotional_banner = 'uploads/e-commerce/banner/promotional_banner/'.$filename;
        }

        $promotionalBanner->start_datetime = $request->start_datetime;
        $promotionalBanner->end_datetime = $request->end_datetime;
        $promotionalBanner->status = $request->status;

        $promotionalBanner->save();

        if (! $promotionalBanner) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('promotional.banner.index')->with('success', 'Customer added successfully.');
    }

    public function editPromotionalBanner($id)
    {
        $promotionalBanner = PromotionalBanner::find($id);

        return view('/e-commerce/banner/promotional-banner/edit', compact('promotionalBanner'));
    }

    public function updatePromotionalBanner(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'banner_title' => 'required|min:3',
            'banner_url' => 'required|min:3',
            'banner_description' => 'required|min:15',
            'start_datetime' => 'required',
            'end_datetime' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $promotionalBanner = PromotionalBanner::findOrFail($id);
        $promotionalBanner->banner_title = $request->banner_title;
        $promotionalBanner->banner_url = $request->banner_url;
        $promotionalBanner->banner_description = $request->banner_description;

        if ($request->hasFile('promotional_banner')) {

            // Only if updating profile
            if ($promotionalBanner->promotional_banner != '') {
                if (File::exists(public_path($promotionalBanner->promotional_banner))) {
                    File::delete(public_path($promotionalBanner->promotional_banner));
                }
            }
            // updating profile end

            $file = $request->file('promotional_banner');
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/e-commerce/banner/promotional_banner'), $filename);
            $promotionalBanner->promotional_banner = 'uploads/e-commerce/banner/promotional_banner/'.$filename;
        }

        $promotionalBanner->start_datetime = $request->start_datetime;
        $promotionalBanner->end_datetime = $request->end_datetime;
        $promotionalBanner->status = $request->status;

        $promotionalBanner->save();

        return redirect()->route('promotional.banner.index')->with('success', 'Banner updated successfully.');
    }

    public function deletePromotionalBanner($id)
    {
        $promotionalBanner = PromotionalBanner::findOrFail($id);
        $promotionalBanner->delete();

        return redirect()->route('promotional.banner.index')->with('success', 'Promotional Banner deleted successfully.');
    }

    /**
     * Update banner sort order via AJAX for drag & drop functionality
     */
    public function updateSortOrder(Request $request)
    {
        $bannerIds = $request->input('banner_ids');

        if (! $bannerIds || ! is_array($bannerIds)) {
            return response()->json(['success' => false, 'message' => 'Invalid data provided']);
        }

        try {
            foreach ($bannerIds as $index => $bannerId) {
                WebsiteBanner::where('id', $bannerId)->update(['sort_order' => $index + 1]);
            }

            return response()->json(['success' => true, 'message' => 'Banner order updated successfully']);
        } catch (\Exception $e) {
            Log::error('Banner sort order update failed: '.$e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to update banner order']);
        }
    }
}
