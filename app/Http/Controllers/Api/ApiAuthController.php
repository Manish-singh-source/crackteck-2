<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Helpers\FileUpload;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Staff;
use App\Models\StaffAadharDetail;
use App\Models\StaffAddress;
use App\Models\StaffBankDetail;
use App\Models\StaffPanCardDetail;
use App\Models\StaffPoliceVerification;
use App\Models\StaffVehicleDetail;
use App\Models\StaffWorkSkill;
use App\Services\Fast2smsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
                    $panFront = FileUpload::fileUpload($request->file('pan_card_front_path'), 'uploads/pan_card/');
                }

                $panBack = null;
                if ($request->hasFile('pan_card_back_path')) {
                    $panBack = FileUpload::fileUpload($request->file('pan_card_back_path'), 'uploads/pan_card/');
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
                    $aadharFront = FileUpload::fileUpload($request->file('aadhar_front_path'), 'uploads/aadhar_card/');
                }

                $aadharBack = null;
                if ($request->hasFile('aadhar_back_path')) {
                    $aadharBack = FileUpload::fileUpload($request->file('aadhar_back_path'), 'uploads/aadhar_card/');
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
            'qualification' => 'nullable|in:post-graduation,graduation,12,10',
            'qualification_certifications' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            'address_proof' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',

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

        if ($request->hasFile('aadhar_front_path')) {
            $aadharFrontPath = FileUpload::fileUpload($request->file('aadhar_front_path'), 'uploads/crm/staff/aadhar/');
        }

        if ($request->hasFile('aadhar_back_path')) {
            $aadharBackPath = FileUpload::fileUpload($request->file('aadhar_back_path'), 'uploads/crm/staff/aadhar/');
        }

        if ($request->hasFile('pan_card_front_path')) {
            $panFrontPath = FileUpload::fileUpload($request->file('pan_card_front_path'), 'uploads/crm/staff/pan/');
        }

        if ($request->hasFile('pan_card_back_path')) {
            $panBackPath = FileUpload::fileUpload($request->file('pan_card_back_path'), 'uploads/crm/staff/pan/');
        }

        if ($request->hasFile('driving_license_front_path')) {
            $drivingLicenseFrontPath = FileUpload::fileUpload($request->file('driving_license_front_path'), 'uploads/crm/staff/drivingLicense/');
        }

        if ($request->hasFile('driving_license_back_path')) {
            $drivingLicenseBackPath = FileUpload::fileUpload($request->file('driving_license_back_path'), 'uploads/crm/staff/drivingLicense/');
        }

        if ($request->hasFile('passbook_pic')) {
            $passbookPic = FileUpload::fileUpload($request->file('passbook_pic'), 'uploads/crm/staff/passbookPic/');
        }

        if ($request->hasFile('police_certificate')) {
            $policeCertificate = FileUpload::fileUpload($request->file('police_certificate'), 'uploads/crm/staff/policeCertificate/');
        }

        if ($request->hasFile('qualification_certifications')) {
            $qualificationCertifications = FileUpload::fileUpload($request->file('qualification_certifications'), 'uploads/crm/staff/qualification_certifications/');
        }

        if ($request->hasFile('address_proof')) {
            $addressProof = FileUpload::fileUpload($request->file('address_proof'), 'uploads/crm/staff/address_proof/');
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
        if ($request->filled('primary_skills') || $request->filled('experience') || $request->filled('qualification') || $request->hasFile('qualification_certifications') || $request->hasFile('address_proof')) {
            StaffWorkSkill::create([
                'staff_id' => $staff->id,
                'primary_skills' => $request->primary_skills,
                'certifications' => $request->certifications,
                'experience' => $request->experience,
                'languages_known' => $request->languages_known,
                'qualification' => $request->qualification,
                'qualification_certifications' => $qualificationCertifications ?? null,
                'address_proof' => $addressProof ?? null,
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
                $user = Customer::where('phone', $request->phone_number)
                    ->where('status', 'active')
                    ->first();
            } else {
                $user = Staff::where('phone', $request->phone_number)->where('staff_role', $staffRole)
                    ->where('status', 'active')
                    ->first();
            }
            if (! $user) {
                return response()->json(['success' => false, 'message' => 'User not found with the provided phone number.'], 404);
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
            $templateId = env('FAST2SMS_TEMPLATE_ID'); // 191040

            $success = $this->sendDltSms(
                $user->phone,           // Phone number
                $templateId,            // Template ID (191040)
                $otp                    // OTP value to replace {#var#}
            );

            if ($success) {
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

                if (! $user->vehicleDetails) {
                    return response()->json(['success' => false, 'message' => 'Vehical Details Not Found'], 401);
                }
            } else {
                $user = Staff::where('phone', $request->phone_number)->where('staff_role', $staffRole)->first();
            }
        }

        if (! $user || $user->otp != $request->otp || now()->gt($user->otp_expiry)) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired OTP'], 401);
        }

        $user->otp = null; // reset OTP after verification
        $user->otp_expiry = null;
        $user->save();

        // Choose guard based on role
        if ($staffRole == 'customers') {
            $guard = 'customer_api';
        } else {
            $guard = 'staff_api';
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
            auth()->guard('customer_api')->logout();
        } else {
            auth()->guard('staff_api')->logout();
        }

        return response()->json(['success' => true, 'message' => 'User logged out successfully'], 200);
    }

    public function refreshToken(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'user_id' => 'required',
                'role_id' => 'required|in:1,2,3,4',
            ]);

            if ($validated->fails()) {
                return ApiResponse::error('Validation failed.', 422, $validated->errors());
            }

            // Determine guard based on role_id
            if ($request->role_id == 4) {
                $guard = 'customer_api';
            } else {
                $guard = 'staff_api';
            }

            // Get authenticated user with current token
            $user = auth()->guard($guard)->user();

            if (! $user) {
                return ApiResponse::error('Invalid or expired token. Please login again.', 401);
            }

            // Attempt to refresh the token
            $newToken = auth()->guard($guard)->refresh();

            if (! $newToken) {
                return ApiResponse::error('Unable to refresh token. Please try logging in again.', 401);
            }

            // Retrieve user with the new token
            $refreshedUser = auth()->guard($guard)->setToken($newToken)->user();

            if (! $refreshedUser) {
                return ApiResponse::error('Token refresh failed. User not found after token refresh.', 401);
            }

            $data = [
                'token' => $newToken,
                'user' => $refreshedUser,
            ];

            return ApiResponse::success($data, 'Token refreshed successfully.', 200);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ApiResponse::error('Token has expired. Please login again.', 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ApiResponse::error('Invalid token provided. Please login again.', 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ApiResponse::error('Token error: ' . $e->getMessage(), 401);
        } catch (\Exception $e) {
            Log::error('Token refresh error: ' . $e->getMessage());

            return ApiResponse::error('An error occurred while refreshing token.', 500);
        }
    }

    public function generateCustomerCode()
    {
        $latestCustomer = Customer::orderBy('id', 'DESC')->first();

        if ($latestCustomer) {
            $number = (int) str_replace('CUST', '', $latestCustomer->customer_code) + 1;
        } else {
            $number = 1;
        }

        return 'CUST' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    // Login with google from App
    public function googleLogin(Request $request)
    {
        $request->validate([
            'accessToken' => 'required',
            'role_id' => 'required|in:1,2,3,4',
        ]);

        $googleResponse = Http::get(
            'https://www.googleapis.com/oauth2/v3/userinfo',
            [
                'access_token' => $request->accessToken
            ]
        );

        if ($googleResponse->failed()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Google token'
            ], 401);
        }

        $googleUser = $googleResponse->json();

        $staffRole = $this->getRoleId($request->role_id);
        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $user = Customer::where('provider_id', $googleUser['sub'])->first();

            if (!$user) {

                $user = Customer::create([
                    'customer_code' => $this->generateCustomerCode(),
                    'first_name' => $googleUser['name'],
                    'last_name' => $googleUser['name'],
                    'email' => $googleUser['email'],
                    'provider_id' => $googleUser['sub'],
                    'avatar' => $googleUser['picture'] ?? null,
                    'password' => bcrypt(Str::random(16))
                ]);
            }
        } else {
            $user = Staff::where('provider_id', $googleUser['sub'])->where('staff_role', $staffRole)->first();

            if (!$user) {
                $user = Staff::create([
                    'staff_code' => $this->generateCustomerCode(),
                    'staff_role' => $staffRole,
                    'first_name' => $googleUser['name'],
                    'last_name' => $googleUser['name'],
                    'email' => $googleUser['email'],
                    'provider_id' => $googleUser['sub'],
                    'avatar' => $googleUser['picture'] ?? null,
                    'password' => bcrypt(Str::random(16))
                ]);
            }
        }

        // $token = $user->createToken('mobile_token')->plainTextToken;
        if ($staffRole == 'customers') {
            $token = auth('customer_api')->login($user);
        } else {
            $token = auth('staff_api')->login($user);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }
}
