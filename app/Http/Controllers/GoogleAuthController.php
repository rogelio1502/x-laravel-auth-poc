<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            [
                'email' => $googleUser->getEmail()
            ],
            [
                'name' => $googleUser->getName(),
            ]
        );

        Auth::login($user);
        session()->put('auth_type', 'google');
        session()->put('access_token', $googleUser->token);

        return redirect(route('dashboard'));
    }

    /**
     * Logout the user from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public static function logout()
    {
        $response = Http::post('https://oauth2.googleapis.com/revoke', [
            'token' => session('access_token')
        ]);
    }
}
