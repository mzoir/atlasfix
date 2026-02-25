<?php

namespace App\Http\Controllers;

use App\Mail\EmailOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailOtpController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $code = (string) random_int(100000, 999999);

        $user->email_verification_code = $code;
        $user->email_verification_expires_at = now()->addMinutes(10);
        $user->save();

        // ✅ Send via SMTP
        Mail::to($user->email)->send(new EmailOtpMail($code));

        return response()->json(['message' => 'OTP sent']);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|string|min:4|max:10',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (!$user->email_verification_code || !$user->email_verification_expires_at) {
            return response()->json(['message' => 'No OTP requested'], 400);
        }

        if (now()->greaterThan($user->email_verification_expires_at)) {
            return response()->json(['message' => 'OTP expired'], 400);
        }

        if ($request->code !== $user->email_verification_code) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        // ✅ Verified
        $user->email_verified_at = now();
        $user->email_verification_code = null;
        $user->email_verification_expires_at = null;
        $user->save();

        return response()->json(['message' => 'Email verified']);
    }
}
