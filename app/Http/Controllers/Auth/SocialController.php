<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    /**
     * Redirect the user to the OAuth provider.
     */
    public function redirectToProvider(string $provider)
    {

        // Extra validation layer in case route constraints change later
        validator(['provider' => $provider], [
            'provider' => 'required|in:google,facebook,github',
        ])->validate();

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the callback from provider.
     */
    public function handleProviderCallback(Request $request, string $provider)
    {
        // dd($request);
        validator(['provider' => $provider], [
            'provider' => 'required|in:google,facebook,github',
        ])->validate();

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')
                ->with('error', 'Unable to login using ' . $provider . '. Please try again.');
        }

        // Find existing by provider + provider_id first
        $staff = Staff::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        // If not found, try by email, then attach provider
        if (! $staff && $socialUser->getEmail()) {
            $staff = Staff::where('email', $socialUser->getEmail())->first();
        }

        if (! $staff) {
            $staff = new Staff();
            $staff->email_verified_at = now();
            $name = $socialUser->getName() ?? $socialUser->getNickname() ?? $staff->name;

            $parts = explode(' ', $name);

            $staff->first_name = array_shift($parts);
            $staff->last_name  = implode(' ', $parts);

            $nextNumber = (Staff::max('id') ?? 0) + 1;
            $staffCode = 'STF' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            $staff->staff_code = $staffCode;
            $staff->staff_role = 'staff';

            $staff->email = $socialUser->getEmail() ?? $staff->email;
            // $staff->password = "123456789";
            $staff->joining_date = now();
            $staff->provider = $provider;
            $staff->provider_id = $socialUser->getId();
            $staff->avatar = $socialUser->getAvatar();
            $staff->save();
        } else {
            $name = $socialUser->getName() ?? $socialUser->getNickname() ?? $staff->name;

            $parts = explode(' ', $name);

            $staff->first_name = array_shift($parts);
            $staff->last_name  = implode(' ', $parts);

            $staff->provider = $provider;
            $staff->provider_id = $socialUser->getId();
            $staff->avatar = $socialUser->getAvatar();
            $staff->save();
        }
        // dd($staff);

        // Auth::guard('web')->login($user, true);
        Auth::guard('staff_web')->login($staff, true);

        // dd(Auth::guard('staff_web')->user());
        return redirect()->intended('demo/crm/index');
    }
}
