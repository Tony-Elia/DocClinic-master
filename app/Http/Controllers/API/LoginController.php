<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
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
}
