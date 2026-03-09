<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        $user = User::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        // If not found, try by email, then attach provider
        if (! $user && $socialUser->getEmail()) {
            $user = User::where('email', $socialUser->getEmail())->first();
        }

        if (! $user) {
            $user = new User();
            $user->email_verified_at = now();
        }

        $user->name = $socialUser->getName() ?? $socialUser->getNickname() ?? $user->name;
        $user->email = $socialUser->getEmail() ?? $user->email;
        $user->password = "123456789";
        $user->provider = $provider;
        $user->provider_id = $socialUser->getId();
        $user->avatar = $socialUser->getAvatar();
        $user->save();

        // Auth::guard('web')->login($user, true);
        Auth::login($user, true);

        return redirect()->intended('demo/crm/index');
    }
}
