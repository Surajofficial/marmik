<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    //
    public function showSocialLoginForm()
    {
        return view('frontend.pages.login');
    }

    public function socialLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        // try {
        //     $googleUser = Socialite::driver('google')->user();
        //     dd($googleUser); 
        // } catch (Exception $e) {
        //     // Log::error('Google Login Error: ' . $e->getMessage());
        //     // return redirect()->route('login.form')->with('error', 'Failed to login: ' . $e->getMessage());
        // }
        $googleUser = Socialite::driver('google')->user();
        // dd($googleUser);
        
        $user = User::where('email', $googleUser->getEmail())->first();

        // dd($user);
        if (!$user) {
            
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                // 'photo' => $googleUser->getAvatar(),
            ]);
        }
        Auth::login($user);

        return redirect()->intended('/account');

    }
}
