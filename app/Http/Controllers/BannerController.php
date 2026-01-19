<?php

namespace App\Http\Controllers;

use App\Models\WebsiteBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, File, Log, Validator};
use Illuminate\Validation\Rule;

class BannerController extends Controller
{
    /**
     * Display website banners (type = 0)
     */
    public function websiteBanner()
    {
        // 
        $website = WebsiteBanner::where('is_active', '1')
            ->orderBy('display_order', 'asc')
            ->paginate(15);

        return view('/e-commerce/banner/website-banner/index', compact('website'));
    }

    public function addWebsiteBanner()
    {
        return view('/e-commerce/banner/website-banner/create');
    }

    /**
     * Store website banner
     */
    public function storeWebsiteBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'           => 'required|string|min:3|max:255',
            'image'           => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'type'            => 'required|in:0,1',
            'channel'         => 'required|in:0,1',
            'description'     => 'nullable|string|min:3',
            'promotion_type'  => 'nullable|in:0,1,2,3',
            'discount_value'  => 'nullable|numeric|min:0',
            'discount_type'   => 'nullable|in:0,1',
            'promo_code'      => 'nullable|string|max:100',
            'link_url'        => 'nullable|url|max:255',
            'link_target'     => 'nullable|in:0,1',
            'position'        => 'required|in:0,1,2,3,4,5',
            'display_order'   => [
                'required',
                'integer',
                'min:0',
                Rule::unique('website_banners', 'display_order')
                    ->where('type', $request->type)
                    ->whereNull('deleted_at')
            ],
            'start_at'        => 'required|date',
            'end_at'          => 'required|date|after:start_at',
            'is_active'       => 'required|in:0,1',
            'metadata'        => 'nullable|json',
        ], [
            'display_order.unique' => 'This display order is already taken for this banner type. Please choose a different order.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Image upload
            $path = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/e-commerce/banner/website_banner'), $filename);
                $path = 'uploads/e-commerce/banner/website_banner/' . $filename;
            }

            $banner = WebsiteBanner::create([
                'title'          => $request->title,
                'slug'           => \Illuminate\Support\Str::slug($request->title),
                'description'    => $request->description,
                'image_url'      => $path,
                'type'           => $request->type,
                'channel'        => $request->channel,
                'promotion_type' => $request->promotion_type !== '' ? $request->promotion_type : null,
                'discount_value' => $request->discount_value,
                'discount_type'  => $request->discount_type !== '' ? $request->discount_type : null,
                'promo_code'     => $request->promo_code,
                'link_url'       => $request->link_url,
                'link_target'    => $request->link_target ?? 1,
                'position'       => $request->position,
                'display_order'  => $request->display_order ?? 0,
                'start_at'       => $request->start_at,
                'end_at'         => $request->end_at,
                'is_active'      => $request->is_active,
                'click_count'    => 0,
                'view_count'     => 0,
                'metadata'       => $request->metadata ? json_decode($request->metadata, true) : null,
            ]);

            DB::commit();
            activity()->performedOn($banner)->causedBy(Auth::user())->log('Banner created');
            return redirect()->route('website.banner.index')->with('success', 'Banner added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Banner Store Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show banner details
     */
    public function showWebsiteBanner($id)
    {
        $website = WebsiteBanner::findOrFail($id);
        return view('/e-commerce/banner/website-banner/show', compact('website'));
    }

    /**
     * Edit website banner
     */
    public function editWebsiteBanner($id)
    {
        $website = WebsiteBanner::findOrFail($id);
        return view('/e-commerce/banner/website-banner/edit', compact('website'));
    }

    /**
     * Update website banner
     */
    public function updateWebsiteBanner(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'           => 'required|string|min:3|max:255',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'type'            => 'required|in:0,1',
            'channel'         => 'required|in:0,1',
            'description'     => 'nullable|string|min:3',
            'promotion_type'  => 'nullable|in:0,1,2,3',
            'discount_value'  => 'nullable|numeric|min:0',
            'discount_type'   => 'nullable|in:0,1',
            'promo_code'      => 'nullable|string|max:100',
            'link_url'        => 'nullable|url|max:255',
            'link_target'     => 'nullable|in:0,1',
            'position'        => 'required|in:0,1,2,3,4,5',
            'display_order'   => [
                'required',
                'integer',
                'min:0',
                Rule::unique('website_banners', 'display_order')
                    ->where('type', $request->type)
                    ->ignore($id)
                    ->whereNull('deleted_at')
            ],
            'start_at'        => 'required|date',
            'end_at'          => 'required|date|after:start_at',
            'is_active'       => 'required|in:0,1',
            'metadata'        => 'nullable|json',
        ], [
            'display_order.unique' => 'This display order is already taken for this banner type. Please choose a different order.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $banner = WebsiteBanner::findOrFail($id);

            // Handle image upload
            $path = $banner->image_url;
            if ($request->hasFile('image')) {
                // Delete old image
                if ($banner->image_url && File::exists(public_path($banner->image_url))) {
                    File::delete(public_path($banner->image_url));
                }

                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/e-commerce/banner/website_banner'), $filename);
                $path = 'uploads/e-commerce/banner/website_banner/' . $filename;
            }

            $banner->update([
                'title'          => $request->title,
                'slug'           => \Illuminate\Support\Str::slug($request->title),
                'description'    => $request->description,
                'image_url'      => $path,
                'type'           => $request->type,
                'channel'        => $request->channel,
                'promotion_type' => $request->promotion_type !== '' ? $request->promotion_type : null,
                'discount_value' => $request->discount_value,
                'discount_type'  => $request->discount_type !== '' ? $request->discount_type : null,
                'promo_code'     => $request->promo_code,
                'link_url'       => $request->link_url,
                'link_target'    => $request->link_target ?? 1,
                'position'       => $request->position,
                'display_order'  => $request->display_order ?? 0,
                'start_at'       => $request->start_at,
                'end_at'         => $request->end_at,
                'is_active'      => $request->is_active,
                'metadata'       => $request->metadata ? json_decode($request->metadata, true) : null,
            ]);

            DB::commit();
            activity()->performedOn($banner)->causedBy(Auth::user())->log('Banner updated');
            return redirect()->route('website.banner.index')->with('success', 'Banner updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Banner Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete website banner
     */
    public function deleteWebsiteBanner($id)
    {
        DB::beginTransaction();
        try {
            $banner = WebsiteBanner::findOrFail($id);

            // Delete image file
            if ($banner->image_url && File::exists(public_path($banner->image_url))) {
                File::delete(public_path($banner->image_url));
            }

            $banner->delete();

            DB::commit();
            activity()->performedOn($banner)->causedBy(Auth::user())->log('Banner deleted');
            return redirect()->route('website.banner.index')->with('success', 'Banner deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Banner Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display promotional banners (type = 1)
     */
    public function promotionalBanner()
    {
        $promotionalBanner = WebsiteBanner::where('type', '1')
            ->orderBy('display_order', 'asc')
            ->paginate(15);

        return view('/e-commerce/banner/promotional-banner/index', compact('promotionalBanner'));
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
            Log::error('Banner sort order update failed: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to update banner order']);
        }
    }
}
