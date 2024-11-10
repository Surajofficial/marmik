<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TextlocalService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OTPLoginController extends Controller
{
    protected $textlocalService;

    public function __construct(TextlocalService $textlocalService)
    {
        $this->textlocalService = $textlocalService;
    }

    public function register(Request $request)
    {
        $otp = Session::get('otp');
        $otpExpiry = Session::get('otp_expiry');
        $mobile = Session::get('mobile');

        if ($otp && $otpExpiry && Carbon::now()->lessThanOrEqualTo($otpExpiry) && $mobile) {
            if ($otp == $request->otp_code && $mobile == $request->mobile) {
                // Register the user
                $user = User::create([
                    'mobile' => $request->mobile,
                    'status' => 'active',
                ]);

                // Log in the user
                Auth::guard('web')->login($user);
                // Clear OTP session data
                Session::forget('otp');
                Session::forget('mobile');
                Session::forget('otp_expiry');
                $request->session()->forget('previous_url');
                return redirect()->route('home'); // Redirect to dashboard or home
            } else {
                return back()->withErrors(['otp_code' => 'Invalid OTP or Mobile']);
            }
        } else {
            return back()->withErrors(['otp_code' => 'OTP has expired']);
        }
    }

    public function sendOTP(Request $request)
    {
        $request->validate(['mobile' => 'required']);
        $user = User::where('mobile', $request->mobile)->first();
        $otp = rand(100000, 999999);
        $mobileNumber = "91{$request->mobile}";
        $message = "Your OTP for logging in to Dr. Awish Clinic (drawish.clinic) is $otp. This OTP is valid for 10 minutes. Please do not share it with anyone. For assistance, contact us at 8287640479.";
        if ($user) {
            $user->otp_code = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(10);
            $user->save();
        } else {
            Session::put('otp', $otp);
            Session::put('mobile', $request->mobile);
            Session::put('otp_expiry', Carbon::now()->addMinutes(10)); // OTP valid for 10 minutes

        }
        if (env('HOST') == 'local') {
            return $otp;
        }
        $response = $this->textlocalService->sendSms($mobileNumber, $message);
        return $response['status'];
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'otp_code' => 'required'
        ]);
        $user = User::where('mobile', $request->mobile)->first();
        $redirectTo = '/';
        // return  $request->session()->get('previous_url');
        if ($request->session()->has('previous_url')) {
            if ($request->session()->get('previous_url') == env('APP_URL') . '/product-type/seerums') {
                $redirectTo = '/';
            } else {
                $redirectTo = $request->session()->get('previous_url');
            }
        }
        if ($user) {
            $user = User::where('mobile', $request->mobile)
                ->where('otp_code', $request->otp_code)
                ->where('otp_expires_at', '>', Carbon::now())
                ->first();
            if ($user) {
                $request->session()->forget('previous_url');
                Auth::guard('web')->login($user);
                return redirect()->intended($redirectTo);
            }
            return redirect('user/login')->with('error', 'Invaild Otp or expiry');
        } else {

            $this->register($request);
            return redirect()->intended($redirectTo);
        }
    }

    // here is custom auth without mobile otp 

    public function customlogin($userId)
    {
        $user = User::where('mobile', $userId)->first();
        if ($user) {
            Auth::guard('web')->login($user);
            return redirect()->intended('/dashboard')->with('success', 'Logged in as ' . $user->name);
        }
        return redirect()->route('login')->with('error', 'User not found.');
    }
}
