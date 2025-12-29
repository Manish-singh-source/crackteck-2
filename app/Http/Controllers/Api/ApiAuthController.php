<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\Engineer;
use App\Models\SalesPerson;
use App\Models\Staff;
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

    protected function getModelByRoleId($roleId)
    {
        return [
            1 => Engineer::class,
            2 => DeliveryMan::class,
            3 => SalesPerson::class,
            4 => Customer::class,
        ][$roleId] ?? null;
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
            Log::error('Fast2SMS Exception: '.$e->getMessage());

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
                'pan_no' => 'nullable',

                'branch_name' => 'nullable',
                'company_name' => 'nullable',
                'company_addr' => 'nullable',
                'gst_no' => 'nullable',
                'customer_type' => 'required',

                'address' => 'required',
                'address2' => 'nullable',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'pincode' => 'required',
            ]));

            if ($customerValidated->fails()) {
                return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $customerValidated->errors()], 422);
            }

            $customer = Customer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'pan_no' => $request->pan_no,

                'branch_name' => $request->branch_name,
                'company_name' => $request->company_name,
                'company_addr' => $request->company_addr,
                'gst_no' => $request->gst_no,
                'customer_type' => $request->customer_type,
            ]);

            $customer->branches()->create([
                'branch_name' => $request->branch_name,
                'address' => $request->address,
                'address2' => $request->address2,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'pincode' => $request->pincode,
            ]);

            return response()->json(['success' => true, 'message' => 'Customer created successfully.']);
        }

        // split name in first_name and last_name
        $names = explode(' ', $request->name);
        $request->merge(['first_name' => $names[0]]);
        $request->merge(['last_name' => $names[1]]);

        // if ($request->filled('pan_card')) {
        //     $request->validate([
        //         'pan_card' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     ]);
        // }

        // if ($request->filled('aadhar_card')) {
        //     $request->validate([
        //         'aadhar_card' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     ]);
        // }

        // if ($request->hasFile('aadhar_card')) {

        //     $aadharCard = $request->file('aadhar_card');
        //     $ext = $aadharCard->getClientOriginalExtension();
        //     $aadharCardName = time() . '.' . $ext;

        //     // Store original image
        //     $aadharCard->move(public_path('uploads/aadhar_card'), $aadharCardName);
        // }

        // if ($request->hasFile('pan_card')) {
        //     $panCard = $request->file('pan_card');
        //     $ext = $panCard->getClientOriginalExtension();
        //     $panCardName = time() . '.' . $ext;

        //     // Store original image
        //     $panCard->move(public_path('uploads/pan_card'), $panCardName);
        // }

        $model = $this->getModelByRoleId($request->role_id);
        if (! $model) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        $validated = Validator::make($request->all(), [
            'primary_skills' => 'nullable|string',
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'phone' => 'required|digits:10',
            'email' => 'required|email',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',

            'address' => 'required|string',
            'address2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'pincode' => 'required|string',

            'designation' => 'required|string',
            'department' => 'required|string',
            'aadhar_pic' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pan_card' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        // Handle file uploads
        $aadharPicPath = null;
        if ($request->hasFile('aadhar_pic')) {
            $file = $request->file('aadhar_pic');
            $filename = time().'_aadhar.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/aadhar_card'), $filename);
            $aadharPicPath = 'uploads/aadhar_card/'.$filename;
        }

        $panCardName = null;
        if ($request->hasFile('pan_card')) {
            $file = $request->file('pan_card');
            $filename = time().'_pan.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/pan_card'), $filename);
            $panCardName = 'uploads/pan_card/'.$filename;
        }

        // $user = new $model();
        $user = new Engineer;

        $user->primary_skills = $request->primary_skills ?? 'Network Engineer';
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->dob = $request->dob;
        $user->gender = $request->gender;

        $user->address = $request->address;
        $user->address2 = $request->address2;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->pincode = $request->pincode;

        $user->designation = $request->designation;
        $user->department = $request->department;
        $user->join_date = date('Y-m-d');
        $user->aadhar_pic = $aadharPicPath;
        $user->pan_card = $panCardName;

        $user->save();

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Failed to create user.'], 500);
        }

        // $staff = Staff::create([
        //     'staff_role' => $staffRole,
        //     'first_name' => $request->first_name,
        //     'last_name' => $request->last_name,
        //     'phone' => $request->phone,
        //     'email' => $request->email,
        //     'current_address' => $request->current_address,
        //     'pan_no' => $request->pan_no,
        //     'aadhar_no' => $request->aadhar_no,
        //     'pan_card' => $panCardName,
        //     'aadhar_card' => $aadharCardName,
        // ]);

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Failed to create staff.'], 500);
        }

        return response()->json(['success' => true, 'message' => 'Staff created successfully.']);
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

            $model = $this->getModelByRoleId($request->role_id);
            if (! $model) {
                return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
            }

            $user = $model::where('phone', $request->phone_number)->first();
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

            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP sent successfully',
                    // Remove 'otp' in production!
                    'otp' => $otp, // For testing only
                ], 200);
            } else {
                Log::error('OTP sending failed for phone: '.$user->phone);

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
            Log::error('Login error: '.$e->getMessage());

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

        $model = $this->getModelByRoleId($request->role_id);
        if (! $model) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        $user = $model::where('phone', $request->phone_number)->first();
        if (! $user || $user->otp != $request->otp || now()->gt($user->otp_expiry)) {
            return response()->json(['error' => 'Invalid or expired OTP'], 401);
        }

        $user->otp = null; // reset OTP after verification
        $user->otp_expiry = null;
        $user->save();

        // Choose guard based on role
        $guards = ['1' => 'engineer', '2' => 'delivery_man', '3' => 'sales_person', '4' => 'customers'];
        $guard = $guards[$request->role_id] ?? 'api';
        $token = auth($guard)->login($user); // if guard mapping in config/auth.php

        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function logout(Request $request)
    {
        $validated = Validator::make($request->all(), ([
            'role_id' => 'required|in:1,2,3,4',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $guards = ['1' => 'engineer', '2' => 'delivery_man', '3' => 'sales_person', '4' => 'customers'];
        $guard = $guards[$request->role_id] ?? 'api';

        try {
            auth($guard)->logout();

            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Failed to logout'], 500);
        }
    }

    public function refreshToken(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1,2,3,4',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $guards = ['1' => 'engineer', '2' => 'delivery_man', '3' => 'sales_person', '4' => 'customers'];
        $guard = $guards[$validated['role_id']] ?? 'api';

        try {
            $newToken = auth($guard)->refresh();

            return response()->json([
                'access_token' => $newToken,
                'token_type' => 'bearer',
                'expires_in' => auth($guard)->factory()->getTTL() * 60,
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Failed to refresh token'], 401);
        }
    }
}
