<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\WebsiteBanner;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreWebsiteBannerRequest;
use App\Http\Requests\UpdateWebsiteBannerRequest;
use Illuminate\Support\Facades\{Auth, DB, File, Log, Validator};

class BannerController extends Controller
{
    /**
     * Display website banners (type = 0)
     */
    public function websiteBanner()
    {
        // 
        $status = request()->get('status') ?? 'all';

        $website = WebsiteBanner::query();

        if ($status != 'all') {
            $website->where('is_active', $status);
        }

        $website->orderBy('display_order', 'asc');
        $website = $website->paginate(15);

        return view('/e-commerce/banner/website-banner/index', compact('website'));
    }

    public function addWebsiteBanner()
    {
        return view('/e-commerce/banner/website-banner/create');
    }

    /**
     * Store website banner
     */
    public function storeWebsiteBanner(StoreWebsiteBannerRequest $request)
    {
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
                'slug'           => Str::slug($request->title),
                'description'    => $request->description,
                'image_url'      => $path,
                'type'           => $request->type,
                'channel'        => $request->channel,
                'promotion_type' => $request->promotion_type ?: null,
                'discount_value' => $request->discount_value,
                'discount_type'  => $request->discount_type ?: null,
                'promo_code'     => $request->promo_code,
                'link_url'       => $request->link_url,
                'link_target'    => $request->link_target ?? 'self',
                'position'       => $request->position,
                'display_order'  => $request->display_order,
                'start_at'       => $request->start_at,
                'end_at'         => $request->end_at,
                'is_active'      => $request->is_active,
                'metadata'       => $request->metadata
                    ? json_decode($request->metadata, true)
                    : null,
            ]);

            DB::commit();

            activity()
                ->performedOn($banner)
                ->causedBy(Auth::user())
                ->log('Banner created');

            return redirect()
                ->route('website.banner.index')
                ->with('success', 'Banner added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Banner Store Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving the banner.');
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
    public function updateWebsiteBanner(UpdateWebsiteBannerRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $banner = WebsiteBanner::findOrFail($id);

            // Image upload
            $path = $banner->image_url;
            if ($request->hasFile('image')) {
                if ($path && File::exists(public_path($path))) {
                    File::delete(public_path($path));
                }

                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/e-commerce/banner/website_banner'), $filename);
                $path = 'uploads/e-commerce/banner/website_banner/' . $filename;
            }

            $banner->update([
                'title'          => $request->title,
                'slug'           => Str::slug($request->title),
                'description'    => $request->description,
                'image_url'      => $path,
                'type'           => $request->type,
                'channel'        => $request->channel,

                // ?: explained here
                'promotion_type' => $request->promotion_type ?: null,
                'discount_type'  => $request->discount_type ?: null,

                'discount_value' => $request->discount_value,
                'promo_code'     => $request->promo_code,
                'link_url'       => $request->link_url,

                // ?? is safer for defaults
                'link_target'    => $request->link_target ?? 1,

                'position'       => $request->position,
                'display_order'  => $request->display_order,
                'start_at'       => $request->start_at,
                'end_at'         => $request->end_at,
                'is_active'      => $request->is_active,

                'metadata'       => $request->metadata
                    ? json_decode($request->metadata, true)
                    : null,
            ]);

            DB::commit();

            activity()
                ->performedOn($banner)
                ->causedBy(Auth::user())
                ->log('Banner updated');

            return redirect()
                ->route('website.banner.index')
                ->with('success', 'Banner updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Banner Update Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while updating the banner.');
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
