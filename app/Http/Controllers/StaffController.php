<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Models\AssignedEngineer;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreStaffRequest;
use Illuminate\Support\Facades\{Auth, DB, Log, Validator};

class StaffController extends Controller
{
    //
    public function index()
    {
        $staffs = Staff::with('role')->get();
        $roles = Role::where('name', '!=', 'Customer')->get();

        return view('/crm/access-control/staff/index', compact('staffs', 'roles'));
    }

    public function create($role = null)
    {
        $roles = Role::where('name', '!=', 'Customer')->get();
        $role = Role::find($role);

        if (! $role) {
            return view('/crm/access-control/staff/create', compact('roles'));
        }

        return view('/crm/access-control/staff/create', compact('role', 'roles'));
    }

    public function store(StoreStaffRequest $request)
    {
        $validated = $request->validated();

        try {
            \DB::transaction(function () use ($request, $validated) {

                // 1. Staff (main)
                $nextNumber = (Staff::max('id') ?? 0) + 1;
                $staffCode = 'STF' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

                $staff = Staff::create([
                    'staff_code' => $staffCode,
                    'staff_role' => $validated['role'],
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'] ?? null,
                    'phone' => $validated['phone'],
                    'email' => $validated['email'],
                    'dob' => $validated['dob'] ?? null,
                    'gender' => $validated['gender'] ?? null,
                    'marital_status' => $validated['marital_status'] ?? null,
                    'employment_type' => $validated['employment_type'] ?? null,
                    'joining_date' => $validated['joining_date'] ?? null,
                    'assigned_area' => $validated['assigned_area'] ?? null,
                    'status' => $validated['status'] ?? 'active',
                ]);

                // 2. Address
                $staff->address()->create([
                    'address1' => $validated['address1'],
                    'address2' => $validated['address2'] ?? null,
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'country' => $validated['country'],
                    'pincode' => $validated['pincode'],
                ]);
                // End

                // 3. Bank
                if ($validated['bank_acc_holder_name'] || $validated['bank_acc_number'] || $validated['bank_name'] || $validated['ifsc_code']) {
                    $passbookPath = null;
                    if ($request->hasFile('passbook_pic')) {
                        $file = $request->file('passbook_pic');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('staff/passbook'), $filename);
                        $passbookPath = 'staff/passbook/' . $filename;
                    }

                    $staff->bankDetails()->create([
                        'bank_acc_holder_name' => $validated['bank_acc_holder_name'] ?? null,
                        'bank_acc_number' => $validated['bank_acc_number'] ?? null,
                        'bank_name' => $validated['bank_name'] ?? null,
                        'ifsc_code' => $validated['ifsc_code'] ?? null,
                        'passbook_pic' => $passbookPath,
                    ]);
                }
                // End

                // 4. Work skills
                if ($validated['primary_skills'] || $validated['languages_known'] || $validated['certifications'] || $validated['experience']) {
                    $certPath = null;
                    if ($request->hasFile('certifications')) {
                        $file = $request->file('certifications');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('staff/certifications'), $filename);
                        $certPath = 'staff/certifications/' . $filename;
                    }

                    $staff->workSkills()->create([
                        'primary_skills' => isset($validated['primary_skills'])
                            ? json_encode($validated['primary_skills'])
                            : null,
                        'languages_known' => isset($validated['languages_known'])
                            ? json_encode($validated['languages_known'])
                            : null,
                        'certifications' => $certPath,
                        'experience' => $validated['experience'] ?? null,
                    ]);
                }
                // End


                // 5. Aadhar
                if ($validated['aadhar_number'] || $request->hasFile('aadhar_front_path') || $request->hasFile('aadhar_back_path')) {
                    $aadharFront = null;
                    if ($request->hasFile('aadhar_front_path')) {
                        $file = $request->file('aadhar_front_path');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('staff/aadhar'), $filename);
                        $aadharFront = 'staff/aadhar/' . $filename;
                    }

                    $aadharBack = null;
                    if ($request->hasFile('aadhar_back_path')) {
                        $file = $request->file('aadhar_back_path');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('staff/aadhar'), $filename);
                        $aadharBack = 'staff/aadhar/' . $filename;
                    }

                    $staff->aadharDetails()->create([
                        'aadhar_number' => $validated['aadhar_number'] ?? null,
                        'aadhar_front_path' => $aadharFront,
                        'aadhar_back_path' => $aadharBack,
                    ]);
                }

                // 6. PAN
                if ($validated['pan_number'] || $request->hasFile('pan_card_front_path') || $request->hasFile('pan_card_back_path')) {
                    $panFront = null;
                    if ($request->hasFile('pan_card_front_path')) {
                        $file = $request->file('pan_card_front_path');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('staff/pan'), $filename);
                        $panFront = 'staff/pan/' . $filename;
                    }

                    $panBack = null;
                    if ($request->hasFile('pan_card_back_path')) {
                        $file = $request->file('pan_card_back_path');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('staff/pan'), $filename);
                        $panBack = 'staff/pan/' . $filename;
                    }

                    $staff->panDetails()->create([
                        'pan_number' => $validated['pan_number'] ?? null,
                        'pan_card_front_path' => $panFront,
                        'pan_card_back_path' => $panBack,
                    ]);
                }

                // 7. Vehicle
                if ($validated['vehicle_type'] || $validated['vehicle_number'] || $validated['driving_license_no']) {
                    $dlFront = null;
                    if ($request->hasFile('driving_license_front_path')) {
                        $file = $request->file('driving_license_front_path');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('staff/license'), $filename);
                        $dlFront = 'staff/license/' . $filename;
                    }

                    $dlBack = null;
                    if ($request->hasFile('driving_license_back_path')) {
                        $file = $request->file('driving_license_back_path');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('staff/license'), $filename);
                        $dlBack = 'staff/license/' . $filename;
                    }

                    $staff->vehicleDetails()->create([
                        'vehicle_type' => $validated['vehicle_type'] ?? null,
                        'vehicle_number' => $validated['vehicle_number'] ?? null,
                        'driving_license_no' => $validated['driving_license_no'] ?? null,
                        'driving_license_front_path' => $dlFront,
                        'driving_license_back_path' => $dlBack,
                    ]);
                }

                // 8. Police verification
                if ($validated['police_verification'] || $validated['police_verification_status'] || $request->hasFile('police_certificate')) {
                    $policeCert = null;
                    if ($request->hasFile('police_certificate')) {
                        $file = $request->file('police_certificate');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('staff/police'), $filename);
                        $policeCert = 'staff/police/' . $filename;
                    }

                    $staff->policeVerification()->create([
                        'police_verification' => $validated['police_verification'] ?? null,
                        'police_verification_status' => $validated['police_verification_status'] ?? null,
                        'police_certificate' => $policeCert,
                    ]);
                }
                // End
            });
        } catch (\Exception $e) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating staff: ' . $e->getMessage());
        }

        return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
    }

    public function delete($id)
    {
        $staff = Staff::find($id);
        if (! $staff) {
            return redirect()->route('staff.index')->with('error', 'Staff not found.');
        }
        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff deleted successfully.');
    }

    public function edit($id)
    {
        $staff = Staff::with(['address', 'bankDetails', 'workSkills', 'aadharDetails', 'panDetails', 'vehicleDetails', 'policeVerification'])->findOrFail($id);
        $roles = Role::where('name', '!=', 'Customer')->get();
        // dd($staff);

        return view('/crm/access-control/staff/edit', compact('staff', 'roles'));
    }

    public function view($id)
    {
        $staff = Staff::with(['address', 'bankDetails', 'workSkills', 'aadharDetails', 'panDetails', 'vehicleDetails', 'policeVerification'])->findOrFail($id);
        $roles = Role::where('name', '!=', 'Customer')->get();
        // dd($staff);
        // Fetch assigned tasks for this engineer
        $assignedTasks = AssignedEngineer::with([
            'serviceRequest.customer',
            'serviceRequest.customerAddress',
            'groupEngineers'
        ])
            ->where(function ($query) use ($id) {
                // Individual assignments
                $query->where('engineer_id', $id)
                    ->where('assignment_type', 'individual');
            })
            ->orWhereHas('groupEngineers', function ($query) use ($id) {
                // Group assignments where this engineer is a member
                $query->where('engineer_id', $id);
            })
            ->where('status', 'active') // Active assignments only
            ->orderBy('assigned_at', 'desc')
            ->get();

        return view('/crm/access-control/staff/view', compact('staff', 'roles', 'assignedTasks'));
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $validated = $request->validate([
            // Staff main
            'staff_role' => 'required',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:staff,email,' . $id . ',id',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'marital_status' => 'nullable|in:unmarried,married,divorced',
            'employment_type' => 'nullable|in:full_time,part_time,contractual',
            'joining_date' => 'nullable|date',
            'assigned_area' => 'nullable|string|max:255',
            'status' => 'nullable|in:inactive,active,resigned,terminated,blocked,suspended,pending',

            // Address
            'address1' => 'required',
            'address2' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required|string|max:20',

            // Bank
            'bank_acc_holder_name' => 'nullable|string|max:255',
            'bank_acc_number' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:20',
            'passbook_pic' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // Work skills
            'primary_skills' => 'nullable|array',
            'primary_skills.*' => 'string',
            'languages_known' => 'nullable|array',
            'languages_known.*' => 'string',
            'certifications' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'experience' => 'nullable|integer',

            // Aadhar
            'aadhar_number' => 'nullable|string|max:20',
            'aadhar_front_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'aadhar_back_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // PAN
            'pan_number' => 'nullable|string|max:20',
            'pan_card_front_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'pan_card_back_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // Vehicle
            'vehicle_type' => 'nullable|in:two_wheeler,three_wheeler,four_wheeler,other',
            'vehicle_number' => 'nullable|string|max:50|unique:staff_vehicle_details,vehicle_number,' . $id . ',staff_id',
            'driving_license_no' => 'nullable|string|max:50|unique:staff_vehicle_details,driving_license_no,' . $id . ',staff_id',
            'driving_license_front_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'driving_license_back_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // Police verification
            'police_verification' => 'nullable|in:no,yes',
            'police_verification_status' => 'nullable|in:pending,completed',
            'police_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        try {
            \DB::transaction(function () use ($request, $validated, $staff) {

                // 1. Staff
                $staff->update([
                    'staff_role' => $validated['staff_role'],
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'] ?? null,
                    'phone' => $validated['phone'],
                    'email' => $validated['email'],
                    'dob' => $validated['dob'] ?? null,
                    'gender' => $validated['gender'] ?? null,
                    'marital_status' => $validated['marital_status'] ?? null,
                    'employment_type' => $validated['employment_type'] ?? null,
                    'joining_date' => $validated['joining_date'] ?? null,
                    'assigned_area' => $validated['assigned_area'] ?? null,
                    'status' => $validated['status'] ?? 1,
                ]);

                // 2. Address
                $staff->address()->updateOrCreate([], [
                    'address1' => $validated['address1'],
                    'address2' => $validated['address2'] ?? null,
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'country' => $validated['country'],
                    'pincode' => $validated['pincode'],
                ]);

                // ---------- File uploads to public disk (storage/app/public) ----------
                $passbookPath = null;
                if ($request->hasFile('passbook_pic')) {
                    $file = $request->file('passbook_pic');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $passbookPath = $file->storeAs('staff/passbook', $filename, 'public');
                }

                $certPath = null;
                if ($request->hasFile('certifications')) {
                    $file = $request->file('certifications');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $certPath = $file->storeAs('staff/certifications', $filename, 'public');
                }

                $aadharFront = null;
                if ($request->hasFile('aadhar_front_path')) {
                    $file = $request->file('aadhar_front_path');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $aadharFront = $file->storeAs('staff/aadhar', $filename, 'public');
                }

                $aadharBack = null;
                if ($request->hasFile('aadhar_back_path')) {
                    $file = $request->file('aadhar_back_path');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $aadharBack = $file->storeAs('staff/aadhar', $filename, 'public');
                }

                $panFront = null;
                if ($request->hasFile('pan_card_front_path')) {
                    $file = $request->file('pan_card_front_path');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $panFront = $file->storeAs('staff/pan', $filename, 'public');
                }

                $panBack = null;
                if ($request->hasFile('pan_card_back_path')) {
                    $file = $request->file('pan_card_back_path');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $panBack = $file->storeAs('staff/pan', $filename, 'public');
                }

                $dlFront = null;
                if ($request->hasFile('driving_license_front_path')) {
                    $file = $request->file('driving_license_front_path');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $dlFront = $file->storeAs('staff/license', $filename, 'public');
                }

                $dlBack = null;
                if ($request->hasFile('driving_license_back_path')) {
                    $file = $request->file('driving_license_back_path');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $dlBack = $file->storeAs('staff/license', $filename, 'public');
                }

                $policeCert = null;
                if ($request->hasFile('police_certificate')) {
                    $file = $request->file('police_certificate');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $policeCert = $file->storeAs('staff/police', $filename, 'public');
                }

                // 3. Bank
                $staff->bankDetails()->updateOrCreate([], [
                    'bank_acc_holder_name' => $validated['bank_acc_holder_name'] ?? optional($staff->bankDetails)->bank_acc_holder_name,
                    'bank_acc_number' => $validated['bank_acc_number'] ?? optional($staff->bankDetails)->bank_acc_number,
                    'bank_name' => $validated['bank_name'] ?? optional($staff->bankDetails)->bank_name,
                    'ifsc_code' => $validated['ifsc_code'] ?? optional($staff->bankDetails)->ifsc_code,
                    'passbook_pic' => $passbookPath ?? optional($staff->bankDetails)->passbook_pic,
                ]);

                // 4. Work skills
                $staff->workSkills()->updateOrCreate([], [
                    'primary_skills' => isset($validated['primary_skills'])
                        ? json_encode($validated['primary_skills'])
                        : optional($staff->workSkills)->primary_skills,
                    'languages_known' => isset($validated['languages_known'])
                        ? json_encode($validated['languages_known'])
                        : optional($staff->workSkills)->languages_known,
                    'certifications' => $certPath ?? optional($staff->workSkills)->certifications,
                    'experience' => $validated['experience'] ?? optional($staff->workSkills)->experience,
                ]);

                // 5. Aadhar
                $staff->aadharDetails()->updateOrCreate([], [
                    'aadhar_number' => $validated['aadhar_number'] ?? optional($staff->aadharDetails)->aadhar_number,
                    'aadhar_front_path' => $aadharFront ?? optional($staff->aadharDetails)->aadhar_front_path,
                    'aadhar_back_path' => $aadharBack ?? optional($staff->aadharDetails)->aadhar_back_path,
                ]);

                // 6. PAN
                $staff->panDetails()->updateOrCreate([], [
                    'pan_number' => $validated['pan_number'] ?? optional($staff->panDetails)->pan_number,
                    'pan_card_front_path' => $panFront ?? optional($staff->panDetails)->pan_card_front_path,
                    'pan_card_back_path' => $panBack ?? optional($staff->panDetails)->pan_card_back_path,
                ]);

                // 7. Vehicle
                $staff->vehicleDetails()->updateOrCreate([], [
                    'vehicle_type' => $validated['vehicle_type'] ?? optional($staff->vehicleDetails)->vehicle_type,
                    'vehicle_number' => $validated['vehicle_number'] ?? optional($staff->vehicleDetails)->vehicle_number,
                    'driving_license_no' => $validated['driving_license_no'] ?? optional($staff->vehicleDetails)->driving_license_no,
                    'driving_license_front_path' => $dlFront ?? optional($staff->vehicleDetails)->driving_license_front_path,
                    'driving_license_back_path' => $dlBack ?? optional($staff->vehicleDetails)->driving_license_back_path,
                ]);

                // 8. Police verification
                $staff->policeVerification()->updateOrCreate([], [
                    'police_verification' => $validated['police_verification'] ?? optional($staff->policeVerification)->police_verification,
                    'police_verification_status' => $validated['police_verification_status'] ?? optional($staff->policeVerification)->police_verification_status,
                    'police_certificate' => $policeCert ?? optional($staff->policeVerification)->police_certificate,
                ]);
            });
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while updating the staff data. Please try again.']);
        }

        return redirect()->route('staff.index')
            ->with('success', 'Staff updated successfully.');
    }

    public function assignRole(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|exists:roles,name',
        ]);

        $users = User::find($id);

        if (! $users) {
            return redirect()->route('roles.index')->with('error', 'User not found.');
        }

        $users->syncRoles($request->name);

        return redirect()->route('roles.index')->with('success', 'Role assigned successfully.');
    }

    public function approveTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assignment_id' => 'required|exists:assigned_engineers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $assignment = AssignedEngineer::findOrFail($request->assignment_id);

            // Check if already approved
            if ($assignment->is_approved_by_engineer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task has already been approved.',
                ], 422);
            }

            // Update approval status
            $assignment->update([
                'is_approved_by_engineer' => true,
                'engineer_approved_at' => now(),
            ]);

            DB::commit();
            activity()->performedOn($assignment)->causedBy(Auth::user())->log('Engineer approved the assigned task');

            return response()->json([
                'success' => true,
                'message' => 'Task approved successfully.',
                'approved_at' => $assignment->engineer_approved_at->format('d M Y, h:i A'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Task approval error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error approving task: ' . $e->getMessage(),
            ], 500);
        }
    }
}
