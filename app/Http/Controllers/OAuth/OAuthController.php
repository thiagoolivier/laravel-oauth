<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        $driver = Socialite::driver($provider)->stateless();

        if ($provider === 'google') {
            $driver->scopes(['openid', 'profile', 'email'])
                ->with([
                    'access_type' => 'offline',
                    'prompt' => 'consent',
                ]);
        }

        return $driver->redirect();
    }

    public function getProviderUrl(Request $request, $provider): JsonResponse
    {
        $driver = Socialite::driver($provider)->stateless();

        if ($provider === 'google') {
            $driver->scopes(['openid', 'profile', 'email'])
                ->with([
                    'access_type' => 'offline',
                    'prompt' => 'consent',
                ]);
        }

        $authorizationUrl = $driver->redirect()->getTargetUrl();

        return response()->json([
            'url' => $authorizationUrl,
        ]);
    }

    public function handleProviderCallback($provider)
    {
        $oauthUser = Socialite::driver($provider)->stateless()->user();

        $socialAccount = SocialAccount::where('provider_name', $provider)
            ->where('provider_id', $oauthUser->getId())
            ->first();

        if ($socialAccount) {
            // Log in the linked user
            Auth::login($socialAccount->user);
            return view('oauth.callback');
        }

        // If no account is linked, try to find a local user by email
        $user = User::where('email', $oauthUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $oauthUser->getName(),
                'email' => $oauthUser->getEmail(),
                'password' => bcrypt(str()->random(16)),
            ]);
        }

        // Create the social account link
        $user->socialAccounts()->updateOrCreate(
            [
                'provider_name' => $provider,
                'provider_id' => $oauthUser->getId(),
            ],
            [
                'token' => $oauthUser->token,
                'refresh_token' => $oauthUser->refreshToken,
                'expires_at' => $oauthUser->expiresIn
                    ? now()->addSeconds($oauthUser->expiresIn)
                    : null,
            ]
        );

        Auth::login($user);

        return view('oauth.callback');
    }

    public function unlink(Request $request, string $provider)
    {
        $request->user()->socialAccounts()->where('provider_name', $provider)->delete();

        return back()->with('status', ucfirst($provider) . ' account unlinked.');
    }
}