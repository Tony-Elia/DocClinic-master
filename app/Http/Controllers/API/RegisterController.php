<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Setting;
use App\ManageText;
use App\Navigation;
use App\BannerImage;
use App\Rules\Captcha;
use App\ValidationText;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response; // Import Response facade


class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:web', ['except' => ['userVerify']]);
    }

    public function userRegisterPage(){
        $setting = Setting::first(['settings_you_need']);
        $banner = BannerImage::first(['banner_fields_you_need']);
        $navigation = Navigation::first(['navigation_fields_you_need']);
        $websiteLang = ManageText::all(['fields_you_need']);

        return response()->json([
            'setting' => $setting,
            'banner' => $banner,
            'navigation' => $navigation,
            'websiteLang' => $websiteLang
        ]);
    }

    public function storeRegister(Request $request){
        if(env('PROJECT_MODE') == 0){
            return response()->json(['message' => env('NOTIFY_TEXT'), 'alert-type' => 'error'], 403);
        }

        $valid_lang = ValidationText::all();
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:3',
            'g-recaptcha-response' => new Captcha()
        ];

        $customMessages = [
            // Custom messages setup
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'patient_id' => date('ymdis'),
            'email_verified_token' => Str::random(100)
        ]);

        // Email sending logic here

        return response()->json(['message' => 'User registered successfully', 'alert-type' => 'success']);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|unique:users'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'otp' => rand(100000, 999999), // Generate a 6-digit OTP
            'otp_expires_at' => now()->addMinutes(5) // OTP expires in 5 minutes
        ]);

        $this->sendOtp($user->phone, $user->otp);

        return response()->json(['message' => 'OTP sent to your phone. Please verify to complete registration.'], 200);
    }

    protected function sendOtp($phone, $otp)
    {
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        $twilio->messages->create($phone, [
            'from' => env('TWILIO_FROM'),
            'body' => "Your OTP is: $otp"
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp !== $request->otp || now()->greaterThan($user->otp_expires_at)) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 401);
        }

        // Optionally, clear the OTP fields after successful verification
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        // Proceed with login or token generation as needed
        return response()->json(['message' => 'OTP verified successfully.'], 200);
    }

    public function userVerify($token){
        $user = User::where('email_verified_token', $token)->first();

        if($user){
            $user->email_verified_token = null;
            $user->status = 1;
            $user->email_verified = 1;
            $user->save();

            return response()->json(['message' => 'User verified successfully', 'alert-type' => 'success']);
        } else {
            return response()->json(['message' => 'Invalid token', 'alert-type' => 'error'], 404);
        }
    }
}
