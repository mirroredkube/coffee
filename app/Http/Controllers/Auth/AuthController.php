<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Log the raw user data
            Log::info('Google User Data: ', [
                'id' => $googleUser->id ?? 'null',
                'name' => $googleUser->name ?? 'null',
                'email' => $googleUser->email ?? 'null'
            ]);

            // Find the user by email
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // If the user already exists, log them in
                Auth::login($user);
            } else {
                // If the user does not exist, create a new one
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => encrypt('123456dummy')
                ]);

                Auth::login($newUser);
            }

            return redirect()->intended('shop');
        } catch (Exception $e) {
            Log::error('Error during Google callback: ' . $e->getMessage());
            return redirect('/login')->withErrors('Something went wrong. Please try again.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
