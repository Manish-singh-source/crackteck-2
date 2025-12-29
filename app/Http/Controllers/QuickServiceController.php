<?php

namespace App\Http\Controllers;

use App\Models\QuickService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class QuickServiceController extends Controller
{
    /**
     * Display a listing of quick services.
     */
    public function index(Request $request)
    {
        try {
            $query = QuickService::query();

            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%");
            }

            $quickServices = $query->orderBy('created_at', 'desc')->get();

            return view('/crm/app/quick-services/index', compact('quickServices'));
        } catch (\Exception $e) {
            Log::error('Quick Services Index Error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Error loading quick services: '.$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new quick service.
     */
    public function create()
    {
        return view('/crm/app/quick-services/create');
    }

    /**
     * Store a newly created quick service in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required|string|max:255',
            'service_price' => 'required|numeric|min:0',
            'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'service_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->service_name,
                'service_price' => $request->service_price,
                'service_description' => $request->service_description,
                'status' => 1,
            ];

            // Handle image upload
            if ($request->hasFile('service_image')) {
                $file = $request->file('service_image');
                $filename = time().'_'.$file->getClientOriginalName();

                // Create directory if it doesn't exist
                $uploadPath = public_path('uploads/crm/quick-services');
                if (! File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $filename);
                $data['service_image'] = 'uploads/crm/quick-services/'.$filename;
            }

            $quickService = QuickService::create($data);

            DB::commit();

            activity()
                ->performedOn($quickService)
                ->causedBy(Auth::user())
                ->log('Quick Service created');

            return redirect()->route('quick-services.index')->with('success', 'Quick Service created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quick Service Store Error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Error creating quick service: '.$e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified quick service.
     */
    public function edit($id)
    {
        try {
            $quickService = QuickService::findOrFail($id);

            return view('/crm/app/quick-services/edit', compact('quickService'));
        } catch (\Exception $e) {
            Log::error('Quick Service Edit Error: '.$e->getMessage());

            return redirect()->route('quick-services.index')->with('error', 'Quick Service not found.');
        }
    }

    /**
     * Update the specified quick service in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required|string|max:255',
            'service_price' => 'required|numeric|min:0',
            'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'service_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $quickService = QuickService::findOrFail($id);

            $data = [
                'name' => $request->service_name,
                'service_price' => $request->service_price,
                'service_description' => $request->service_description,
            ];

            // Handle image upload
            if ($request->hasFile('service_image')) {
                // Delete old image if exists
                if ($quickService->service_image && File::exists(public_path($quickService->service_image))) {
                    File::delete(public_path($quickService->service_image));
                }

                $file = $request->file('service_image');
                $filename = time().'_'.$file->getClientOriginalName();

                // Create directory if it doesn't exist
                $uploadPath = public_path('uploads/crm/quick-services');
                if (! File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $filename);
                $data['service_image'] = 'uploads/crm/quick-services/'.$filename;
            }

            $quickService->update($data);

            DB::commit();

            activity()
                ->performedOn($quickService)
                ->causedBy(Auth::user())
                ->log('Quick Service updated');

            return redirect()->route('quick-services.index')->with('success', 'Quick Service updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quick Service Update Error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Error updating quick service: '.$e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified quick service from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $quickService = QuickService::findOrFail($id);

            // Delete image if exists
            if ($quickService->service_image && File::exists(public_path($quickService->service_image))) {
                File::delete(public_path($quickService->service_image));
            }

            activity()
                ->performedOn($quickService)
                ->causedBy(Auth::user())
                ->log('Quick Service deleted');

            $quickService->delete();

            DB::commit();

            return redirect()->route('quick-services.index')->with('success', 'Quick Service deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quick Service Delete Error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Error deleting quick service: '.$e->getMessage());
        }
    }
}
