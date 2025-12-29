<?php

namespace App\Http\Controllers;

use App\Models\Engineer;
use App\Models\Job;
use App\Models\JobAssignment;
use App\Models\JobDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    //
    public function index()
    {
        $jobs = Job::all();
        $engineer = Engineer::all();

        return view('/crm/jobs/index', compact('jobs', 'engineer'));
    }

    public function create()
    {
        return view('/crm/jobs/create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'customer_type' => 'required',
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:c_jobs,email',
            'dob' => 'required|date',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin_code' => 'required',
            'priority_level' => 'required|in:High,Medium,Low',
            'products' => 'required|array|min:1',
            'products.*.product_name' => 'nullable|string',
            'products.*.product_type' => 'nullable|in:0,PC,Laptop,Accessories',
            'products.*.product_brand' => 'nullable|string',
            'products.*.model_no' => 'nullable|string',
            'products.*.serial_no' => 'nullable|string',
            'products.*.purchase_date' => 'nullable|date',
            'products.*.issue_type' => 'nullable|string',
            'products.*.description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Get the first product data (since database supports single product)
        $firstProduct = $request->products[0] ?? [];

        $job = new Job;
        $job->customer_type = $request->customer_type;
        $job->first_name = $request->first_name;
        $job->last_name = $request->last_name;
        $job->phone = $request->phone;
        $job->email = $request->email;
        $job->dob = $request->dob;

        $job->address = $request->address;
        $job->address2 = $request->address2;
        $job->country = $request->country;
        $job->state = $request->state;
        $job->city = $request->city;
        $job->pin_code = $request->pin_code;

        $job->company_name = $request->company_name;
        $job->company_address = $request->company_address;
        $job->gst_no = $request->gst_no;
        $job->pan_no = $request->pan_no;
        $job->profile_img = $request->profile_img;
        $job->priority_level = $request->priority_level;

        // Store first product data
        $job->product_name = $firstProduct['product_name'] ?? null;
        $job->product_type = $firstProduct['product_type'] ?? null;
        $job->product_brand = $firstProduct['product_brand'] ?? null;
        $job->model_no = $firstProduct['model_no'] ?? null;
        $job->serial_no = $firstProduct['serial_no'] ?? null;
        $job->purchase_date = $firstProduct['purchase_date'] ?? null;
        $job->issue_type = $firstProduct['issue_type'] ?? null;
        $job->description = $firstProduct['description'] ?? null;

        // Handle image upload for product
        if ($request->hasFile('products.0.image')) {
            $image = $request->file('products.0.image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $imagePath = $image->storeAs('products', $imageName, 'public');
            $job->image = $imagePath;
        }

        $job->save();

        if (! $job) {
            return back()->with('error', 'Something went wrong while creating the job.');
        }

        // Save all products to job_devices table
        if ($request->has('products') && is_array($request->products)) {
            foreach ($request->products as $index => $productData) {
                $device = new JobDevice;
                $device->job_id = $job->id;
                $device->product_name = $productData['product_name'] ?? null;
                $device->product_type = $productData['product_type'] ?? null;
                $device->product_brand = $productData['product_brand'] ?? null;
                $device->model_no = $productData['model_no'] ?? null;
                $device->serial_no = $productData['serial_no'] ?? null;
                $device->purchase_date = $productData['purchase_date'] ?? null;
                $device->issue_type = $productData['issue_type'] ?? null;
                $device->description = $productData['description'] ?? null;

                // Handle image upload for each product
                if ($request->hasFile("products.{$index}.image")) {
                    $image = $request->file("products.{$index}.image");
                    $imageName = time().'_'.$index.'_'.$image->getClientOriginalName();
                    $imagePath = $image->storeAs('products', $imageName, 'public');
                    $device->image = $imagePath;
                }

                $device->save();
            }
        }

        return redirect()->route('jobs.index')->with('success', 'Job created successfully!');
    }

    public function view($id)
    {
        $job = Job::with('devices')->find($id);
        $engineers = Engineer::all();
        $assignment = $job->assignment;

        return view('crm/jobs/view', compact('job', 'engineers', 'assignment'));
    }

    public function edit($id)
    {
        $job = Job::with('devices')->find($id);

        return view('crm/jobs/edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_type' => 'required',
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:c_jobs,email,'.$id,
            'dob' => 'required|date',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin_code' => 'required',
            'priority_level' => 'required|in:High,Medium,Low',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $job = Job::findOrFail($id);

        $job->customer_type = $request->customer_type;
        $job->first_name = $request->first_name;
        $job->last_name = $request->last_name;
        $job->phone = $request->phone;
        $job->email = $request->email;
        $job->dob = $request->dob;

        $job->address = $request->address;
        $job->address2 = $request->address2;
        $job->country = $request->country;
        $job->state = $request->state;
        $job->city = $request->city;
        $job->pin_code = $request->pin_code;

        $job->company_name = $request->company_name;
        $job->company_address = $request->company_address;
        $job->gst_no = $request->gst_no;
        $job->pan_no = $request->pan_no;
        $job->profile_img = $request->profile_img;
        $job->priority_level = $request->priority_level;

        // Keep the first product data in the main job table for backward compatibility
        $firstProduct = $request->products[0] ?? [];
        $job->product_name = $firstProduct['product_name'] ?? $request->product_name;
        $job->product_type = $firstProduct['product_type'] ?? $request->product_type;
        $job->product_brand = $firstProduct['product_brand'] ?? $request->product_brand;
        $job->model_no = $firstProduct['model_no'] ?? $request->model_no;
        $job->serial_no = $firstProduct['serial_no'] ?? $request->serial_no;
        $job->purchase_date = $firstProduct['purchase_date'] ?? $request->purchase_date;
        $job->issue_type = $firstProduct['issue_type'] ?? $request->issue_type;
        $job->description = $firstProduct['description'] ?? $request->description;

        $job->save();

        if (! $job) {
            return back()->with('error', 'Something went wrong.');
        }

        // Update devices if products array is provided
        if ($request->has('products') && is_array($request->products)) {
            // Delete existing devices
            JobDevice::where('job_id', $job->id)->delete();

            // Save all products to job_devices table
            foreach ($request->products as $index => $productData) {
                $device = new JobDevice;
                $device->job_id = $job->id;
                $device->product_name = $productData['product_name'] ?? null;
                $device->product_type = $productData['product_type'] ?? null;
                $device->product_brand = $productData['product_brand'] ?? null;
                $device->model_no = $productData['model_no'] ?? null;
                $device->serial_no = $productData['serial_no'] ?? null;
                $device->purchase_date = $productData['purchase_date'] ?? null;
                $device->issue_type = $productData['issue_type'] ?? null;
                $device->description = $productData['description'] ?? null;

                // Handle image upload for each product
                if ($request->hasFile("products.{$index}.image")) {
                    $image = $request->file("products.{$index}.image");
                    $imageName = time().'_'.$index.'_'.$image->getClientOriginalName();
                    $imagePath = $image->storeAs('products', $imageName, 'public');
                    $device->image = $imagePath;
                }

                $device->save();
            }
        }

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully.');
    }

    public function delete($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully.');
    }

    public function assignJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|exists:c_jobs,id',
            'engineer_id' => 'required|exists:engineers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // Check if job is already assigned
        $existingAssignment = JobAssignment::where('job_id', $request->job_id)->first();

        if ($existingAssignment) {
            // Update existing assignment
            $existingAssignment->engineer_id = $request->engineer_id;
            $existingAssignment->status = 'Pending';
            $existingAssignment->assigned_at = now();
            $existingAssignment->save();
        } else {
            // Create new assignment
            $assignment = JobAssignment::create([
                'job_id' => $request->job_id,
                'engineer_id' => $request->engineer_id,
                'status' => 'Pending',
                'assigned_at' => now(),
            ]);
        }

        $engineer = Engineer::find($request->engineer_id);

        return response()->json([
            'success' => true,
            'message' => 'Engineer assigned successfully',
            'engineer_name' => $engineer->first_name.' '.$engineer->last_name,
        ]);
    }

    public function deleteDevice($id)
    {
        $device = JobDevice::findOrFail($id);
        $device->delete();

        return response()->json([
            'success' => true,
            'message' => 'Device deleted successfully.',
        ]);
    }

    public function bulkDeleteDevices(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_ids' => 'required|array|min:1',
            'device_ids.*' => 'exists:job_devices,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        JobDevice::whereIn('id', $request->device_ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($request->device_ids).' device(s) deleted successfully.',
        ]);
    }

    public function bulkDeleteJobs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_ids' => 'required|array|min:1',
            'job_ids.*' => 'exists:c_jobs,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        Job::whereIn('id', $request->job_ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($request->job_ids).' job(s) deleted successfully.',
        ]);
    }
}
