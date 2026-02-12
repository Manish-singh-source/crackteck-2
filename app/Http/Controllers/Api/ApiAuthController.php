<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\Engineer;
use App\Models\SalesPerson;
use App\Models\Staff;
use App\Models\StaffAddress;
use App\Models\StaffAadharDetail;
use App\Models\StaffBankDetail;
use App\Models\StaffPanCardDetail;
use App\Models\StaffPoliceVerification;
use App\Models\StaffVehicleDetail;
use App\Models\StaffWorkSkill;
use App\Services\Fast2smsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ApiAuthController extends Controller
{
    protected $fast2sms;

    public function __construct(Fast2smsService $fast2sms)
    {
        $this->fast2sms = $fast2sms;
    }

    protected function getRoleId($roleId)
    {
        return [
            1 => 'engineer',
            2 => 'delivery_man',
            3 => 'sales_person',
            4 => 'customers',
        ][$roleId] ?? null;
    }

    public function sendDltSms($phoneNumbers, $templateId, $variablesValues)
    {
        $apiKey = env('FAST2SMS_API_KEY');
        $senderId = env('FAST2SMS_SENDER_ID');

        $payload = [
            'route' => 'dlt',
            'sender_id' => $senderId,
            'message' => $templateId, // Template ID (numeric)
            'variables_values' => $variablesValues, // OTP value
            'flash' => 0,
            'numbers' => is_array($phoneNumbers) ? implode(',', $phoneNumbers) : $phoneNumbers,
        ];

        try {
            $response = Http::withHeaders([
                'authorization' => $apiKey,
            ])->asForm()->post('https://www.fast2sms.com/dev/bulkV2', $payload);

            // Log the response for debugging
            Log::info('Fast2SMS Response', [
                'status' => $response->status(),
                'body' => $response->body(),
                'payload' => $payload,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                return $responseData['return'] ?? false;
            }

            Log::error('Fast2SMS Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Fast2SMS Exception: ' . $e->getMessage());

            return false;
        }
    }

    public function signup(Request $request)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:1,2,3,4',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $customerValidated = Validator::make($request->all(), ([
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'phone' => 'required|unique:customers,phone|digits:10',
                'email' => 'required|email|unique:customers,email',
                'dob' => 'nullable',
                'gender' => 'required',
                'customer_type' => 'both',
                'pan_no' => 'nullable|string|max:10',
                'pan_card_front_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
                'pan_card_back_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
                'aadhar_number' => 'nullable|digits:12',
                'aadhar_front_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
                'aadhar_back_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',

                'branch_name' => 'nullable',
                'company_name' => 'nullable',
                'company_addr' => 'nullable',
                'gst_no' => 'nullable',

                'address1' => 'nullable',
                'address2' => 'nullable',
                'city' => 'nullable',
                'state' => 'nullable',
                'country' => 'nullable',
                'pincode' => 'nullable',
            ]));

            if ($customerValidated->fails()) {
                return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $customerValidated->errors()], 422);
            }

            $customer = Customer::create([
                'customer_code' => $this->generateCustomerCode(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'customer_type' => '0',
                'source_type' => '1',
            ]);

            if (! $customer) {
                return response()->json(['success' => false, 'message' => 'Failed to create customer.'], 500);
            }

            // Customer Address Details
            if ($request->address1) {
                $customer->branches()->create([
                    'branch_name' => $request->branch_name,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                    'pincode' => $request->pincode,
                    'is_primary' => 1,
                ]);
            }

            // PAN Card Details
            if ($request->filled('pan_no')) {
                $panFront = null;
                if ($request->hasFile('pan_card_front_path')) {
                    $file = $request->file('pan_card_front_path');
                    $filename = time() . '_pan_front.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/pan_card'), $filename);
                    $panFront = 'uploads/pan_card/' . $filename;
                }

                $panBack = null;
                if ($request->hasFile('pan_card_back_path')) {
                    $file = $request->file('pan_card_back_path');
                    $filename = time() . '_pan_back.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/pan_card'), $filename);
                    $panBack = 'uploads/pan_card/' . $filename;
                }

                $customer->panCardDetails()->create([
                    'pan_number' => $request->pan_no,
                    'pan_card_front_path' => $panFront ?? null,
                    'pan_card_back_path' => $panBack ?? null,
                ]);

                if (! $customer) {
                    return response()->json(['success' => false, 'message' => 'Failed to create PAN card details.'], 500);
                }
            }

            // Aadhar Card Details
            if ($request->filled('aadhar_number')) {
                $aadharFront = null;
                if ($request->hasFile('aadhar_front_path')) {
                    $file = $request->file('aadhar_front_path');
                    $filename = time() . '_aadhar_front.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/aadhar_card'), $filename);
                    $aadharFront = 'uploads/aadhar_card/' . $filename;
                }

                $aadharBack = null;
                if ($request->hasFile('aadhar_back_path')) {
                    $file = $request->file('aadhar_back_path');
                    $filename = time() . '_aadhar_back.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/aadhar_card'), $filename);
                    $aadharBack = 'uploads/aadhar_card/' . $filename;
                }

                $customer->aadharDetails()->create([
                    'aadhar_number' => $request->aadhar_number,
                    'aadhar_front_path' => $aadharFront ?? null,
                    'aadhar_back_path' => $aadharBack ?? null,
                ]);

                if (! $customer) {
                    return response()->json(['success' => false, 'message' => 'Failed to create Aadhar card details.'], 500);
                }
            }

            return response()->json(['success' => true, 'message' => 'Customer created successfully.']);
        }

        // split name in first_name and last_name
        $names = explode(' ', $request->name);
        $request->merge(['first_name' => $names[0]]);
        $request->merge(['last_name' => $names[1]]);

        $validated = Validator::make($request->all(), [
            // Staff details
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'phone' => 'required|digits:10',
            'email' => 'required|email',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'marital_status' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'assigned_area' => 'nullable|string',

            // Address details
            'address1' => 'nullable|string',
            'address2' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'pincode' => 'nullable|string',

            // Work details
            'primary_skills' => 'nullable|string',
            'certifications' => 'nullable|string',
            'experience' => 'nullable|string',
            'languages_known' => 'nullable|string',

            // Police verification details
            'police_verifications' => 'nullable|in:verified,not_verified',
            'police_verification_status' => 'nullable|in:verified,not_verified',
            'police_certificate' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',

            // Aadhar verification details
            'aadhar_number' => 'nullable|string',
            'aadhar_front_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'aadhar_back_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',

            // PAN verification details
            'pan_number' => 'nullable|string',
            'pan_card_front_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pan_card_back_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',

            // Bank account details
            'bank_acc_holder_name' => 'nullable|string',
            'bank_acc_number' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'ifsc_code' => 'nullable|string',
            'passbook_pic' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',

            // Vehicle details
            'vehicle_type' => 'nullable|string',
            'vehicle_number' => 'nullable|string',
            'driving_license_no' => 'nullable|string',
            'driving_license_front_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'driving_license_back_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        // // Handle file uploads for Aadhar
        // if ($request->hasFile('aadhar_front_path')) {
        //     $file = $request->file('aadhar_front_path');
        //     $filename = time() . '_aadhar_front.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('uploads/aadhar_card'), $filename);
        //     $request->merge(['aadhar_front_path' => 'uploads/aadhar_card/' . $filename]);
        // }

        // if ($request->hasFile('aadhar_back_path')) {
        //     $file = $request->file('aadhar_back_path');
        //     $filename = time() . '_aadhar_back.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('uploads/aadhar_card'), $filename);
        //     $request->merge(['aadhar_back_path' => 'uploads/aadhar_card/' . $filename]);
        // }

        // // Handle file uploads for PAN Card
        // if ($request->hasFile('pan_card_front_path')) {
        //     $file = $request->file('pan_card_front_path');
        //     $filename = time() . '_pan_front.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('uploads/pan_card'), $filename);
        //     $request->merge(['pan_card_front_path' => 'uploads/pan_card/' . $filename]);
        // }

        // if ($request->hasFile('pan_card_back_path')) {
        //     $file = $request->file('pan_card_back_path');
        //     $filename = time() . '_pan_back.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('uploads/pan_card'), $filename);
        //     $request->merge(['pan_card_back_path' => 'uploads/pan_card/' . $filename]);
        // }

        // // Handle file uploads for Driving License
        // $drivingLicenseFront = null;
        // if ($request->hasFile('driving_license_front_path')) {
        //     $file = $request->file('driving_license_front_path');
        //     $filename = time() . '_driving_license_front.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('uploads/driving_license'), $filename);
        //     $drivingLicenseFront = 'uploads/driving_license/' . $filename;
        // }

        // $drivingLicenseBack = null;
        // if ($request->hasFile('driving_license_back_path')) {
        //     $file = $request->file('driving_license_back_path');
        //     $filename = time() . '_driving_license_back.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('uploads/driving_license'), $filename);
        //     $drivingLicenseBack = 'uploads/driving_license/' . $filename;
        // }

        // // Handle file uploads for Police Certificate
        // $policeCertificate = null;
        // if ($request->hasFile('police_certificate')) {
        //     $file = $request->file('police_certificate');
        //     $filename = time() . '_police_certificate.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('uploads/police_certificate'), $filename);
        //     $policeCertificate = 'uploads/police_certificate/' . $filename;
        // }

        // // Handle file uploads for Passbook
        // $passbookPic = null;
        // if ($request->hasFile('passbook_pic')) {
        //     $file = $request->file('passbook_pic');
        //     $filename = time() . '_passbook.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('uploads/passbook'), $filename);
        //     $passbookPic = 'uploads/passbook/' . $filename;
        // }

        if ($request->hasFile('aadhar_front_path')) {
            $file = $request->file('aadhar_front_path');
            $filename = time() . '_aadhar_front.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/crm/staff/aadhar'), $filename);
            $aadharFrontPath = 'uploads/crm/staff/aadhar/' . $filename;
        }

        if ($request->hasFile('aadhar_back_path')) {
            $file = $request->file('aadhar_back_path');
            $filename = time() . '_aadhar_back.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/crm/staff/aadhar'), $filename);
            $aadharBackPath = 'uploads/crm/staff/aadhar/' . $filename;
        }

        if ($request->hasFile('pan_card_front_path')) {
            $file = $request->file('pan_card_front_path');
            $filename = time() . 'pan_front.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/crm/staff/pan'), $filename);
            $panFrontPath = 'uploads/crm/staff/pan/' . $filename;
        }

        if ($request->hasFile('pan_card_back_path')) {
            $file = $request->file('pan_card_back_path');
            $filename = time() . 'pan_back.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/crm/staff/pan'), $filename);
            $panBackPath = 'uploads/crm/staff/pan/' . $filename;
        }

        if ($request->hasFile('driving_license_front_path')) {
            $file = $request->file('driving_license_front_path');
            $filename = time() . 'driving_license_front.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/crm/staff/drivingLicense'), $filename);
            $drivingLicenseFrontPath = 'uploads/crm/staff/drivingLicense/' . $filename;
        }

        if ($request->hasFile('driving_license_back_path')) {
            $file = $request->file('driving_license_back_path');
            $filename = time() . 'driving_license_back.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/crm/staff/drivingLicense'), $filename);
            $drivingLicenseBackPath = 'uploads/crm/staff/drivingLicense/' . $filename;
        }

        if ($request->hasFile('passbook_pic')) {
            $file = $request->file('passbook_pic');
            $filename = time() . 'passbook_pic.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/crm/staff/passbookPic'), $filename);
            $passbookPic = 'uploads/crm/staff/passbookPic/' . $filename;
        }

        if ($request->hasFile('police_certificate')) {
            $file = $request->file('police_certificate');
            $filename = time() . 'police_certificate.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/crm/staff/policeCertificate'), $filename);
            $policeCertificate = 'uploads/crm/staff/policeCertificate/' . $filename;
        }

        // Create Staff
        $staff = Staff::create([
            'staff_code' => 'STF' . time() . rand(100, 999),
            'staff_role' => $staffRole,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status ?? 'unmarried',
            'employment_type' => $request->employment_type ?? 'full_time',
            'joining_date' => $request->joining_date,
            'assigned_area' => $request->assigned_area,
            'status' => 'pending',
        ]);

        if (! $staff) {
            return response()->json(['success' => false, 'message' => 'Failed to create staff.'], 500);
        }

        // Store Staff Address
        StaffAddress::create([
            'staff_id' => $staff->id,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'pincode' => $request->pincode,
        ]);

        // Store Aadhar Details
        if ($request->filled('aadhar_number')) {
            StaffAadharDetail::create([
                'staff_id' => $staff->id,
                'aadhar_number' => $request->aadhar_number,
                'aadhar_front_path' => $aadharFrontPath,
                'aadhar_back_path' => $aadharBackPath,
            ]);
        }

        // Store PAN Card Details
        if ($request->filled('pan_number')) {
            StaffPanCardDetail::create([
                'staff_id' => $staff->id,
                'pan_number' => $request->pan_number,
                'pan_card_front_path' => $panFrontPath,
                'pan_card_back_path' => $panBackPath,
            ]);
        }

        // Store Vehicle Details
        if ($request->filled('vehicle_type') || $request->filled('vehicle_number')) {
            StaffVehicleDetail::create([
                'staff_id' => $staff->id,
                'vehicle_type' => $request->vehicle_type,
                'vehicle_number' => $request->vehicle_number,
                'driving_license_no' => $request->driving_license_no,
                'driving_license_front_path' => $drivingLicenseFrontPath,
                'driving_license_back_path' => $drivingLicenseBackPath,
            ]);
        }

        // Store Bank Details
        if ($request->filled('bank_acc_number')) {
            StaffBankDetail::create([
                'staff_id' => $staff->id,
                'bank_acc_holder_name' => $request->bank_acc_holder_name,
                'bank_acc_number' => $request->bank_acc_number,
                'bank_name' => $request->bank_name,
                'ifsc_code' => $request->ifsc_code,
                'passbook_pic' => $passbookPic,
            ]);
        }

        // Store Work Skills
        if ($request->filled('primary_skills') || $request->filled('experience')) {
            StaffWorkSkill::create([
                'staff_id' => $staff->id,
                'primary_skills' => $request->primary_skills,
                'certifications' => $request->certifications,
                'experience' => $request->experience,
                'languages_known' => $request->languages_known,
            ]);
        }

        // Store Police Verification
        if ($request->filled('police_verifications')) {
            StaffPoliceVerification::create([
                'staff_id' => $staff->id,
                'police_verification' => $request->police_verifications,
                'police_verification_status' => $request->police_verification_status,
                'police_certificate' => $policeCertificate,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Staff created successfully.', 'staff_id' => $staff->id]);
    }

    /**
     * Handle user login and return access token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), ([
                'phone_number' => 'required',
                'role_id' => 'required|in:1,2,3,4',
            ]));

            if ($validated->fails()) {
                return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
            }

            $staffRole = $this->getRoleId($request->role_id);

            if (! $staffRole) {
                return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
            }

            if ($staffRole == 'customers') {
                $user = Customer::where('phone', $request->phone_number)->first();
            } else {
                $user = Staff::where('phone', $request->phone_number)->where('staff_role', $staffRole)->first();
            }
            if (! $user) {
                return response()->json(['success' => false, 'message' => 'User not found with the provided phone number and role.'], 404);
            }

            $otp = rand(1000, 9999);
            $user->otp = $otp;
            $user->otp_expiry = now()->addMinutes(5);
            $user->save();

            // Store OTP with phone in cache/session with 5 min expiration
            // cache()->put('otp_' . $request->phone_number, $otp, now()->addMinutes(5));

            // Send OTP via Fast2SMS DLT
            // Template ID from .env (191040) - DLT approved template
            // Template message: "Your OTP is {#var#}. Valid for 5 minutes. - CRCTK"
            // $templateId = env('FAST2SMS_TEMPLATE_ID'); // 191040

            // $success = $this->sendDltSms(
            //     $user->phone,           // Phone number
            //     $templateId,            // Template ID (191040)
            //     $otp                    // OTP value to replace {#var#}
            // );

            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP sent successfully',
                    // Remove 'otp' in production!
                    'otp' => $otp, // For testing only
                ], 200);
            } else {
                Log::error('OTP sending failed for phone: ' . $user->phone);

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send OTP. Please try again.',
                    // For testing, still save OTP in DB
                    'otp' => $otp, // Remove in production
                ], 500);
            }
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'An error occurred during login', 'error' => $e->getMessage()], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $validated = Validator::make($request->all(), ([
            'phone_number' => 'required',
            'otp' => 'required',
            'role_id' => 'required|in:1,2,3,4',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);
        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $user = Customer::where('phone', $request->phone_number)->first();
        } else {

            if ($staffRole == 'delivery_man') {


                $user = Staff::with('vehicleDetails')->where('phone', $request->phone_number)->where('staff_role', $staffRole)->first();

                if (!$user->vehicleDetails) {
                    return response()->json(['error' => 'Vehical Details Not Found']);
                }
            } else {
                $user = Staff::where('phone', $request->phone_number)->where('staff_role', $staffRole)->first();
            }
        }

        if (! $user || $user->otp != $request->otp || now()->gt($user->otp_expiry)) {
            return response()->json(['error' => 'Invalid or expired OTP'], 401);
        }

        $user->otp = null; // reset OTP after verification
        $user->otp_expiry = null;
        $user->save();

        // Choose guard based on role
        if ($staffRole == 'customers') {
            $guard = 'customers';
        } else {
            $guard = 'staff';
        }
        $token = auth($guard)->login($user); // if guard mapping in config/auth.php

        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function logout(Request $request)
    {
        $validated = Validator::make($request->all(), ([
            'user_id' => 'required',
            'role_id' => 'required|in:1,2,3,4',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if ($staffRole == 'customers') {
            auth()->guard('customers')->logout();
        } else {
            auth()->guard('staff')->logout();
        }

        return response()->json(['success' => true, 'message' => 'User logged out successfully']);
    }

    public function updateToken(Request $request)
    {
        $user = auth()->guard('staff')->user();
        if (!$user) {
            $user = auth()->guard('customers')->user();
        }
        if ($user) {
            $user->device_token = $request->token;
            $user->save();
        }

        return response()->json(['success' => true, 'message' => 'Token updated']);
    }

    public function generateCustomerCode()
    {
        $latestCustomer = Customer::orderBy('id', 'DESC')->first();

        if ($latestCustomer) {
            $number = (int) str_replace('CST-', '', $latestCustomer->customer_code) + 1;
        } else {
            $number = 1;
        }

        return 'CST-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
