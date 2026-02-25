<?php

namespace App\Http\Controllers;

use App\Mail\EmailOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    private function userByTempId(string $tempId): ?User
    {
        return User::where('register_token', $tempId)
            ->whereNotNull('register_token_expires_at')
            ->where('register_token_expires_at', '>=', now())
            ->first();
    }

    /**
     * STEP 1: Start registration
     */
    public function start(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:30|unique:users,phone',
            'ville' => 'nullable|string|max:30|',
            'date_of_birth' => 'nullable|date',
        ]);

        $tempId = Str::random(60);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'ville'  => $data['ville'],
            'date_of_birth'  => $data['date_of_birth'],
            'role' => 'user',
            'password' => null,
            'abonnement' => 'free',
            'register_token' => $tempId,
            'register_token_expires_at' => now()->addMinutes(20),
            'email_verified_at' => null,
            'phone_verified_at' => null,
        ]);

        // Email OTP
        $emailCode = (string) random_int(1000, 9999);
        $user->email_verification_code = $emailCode;
        $user->email_verification_expires_at = now()->addMinutes(10);

        // Phone OTP
        $phoneCode = (string) random_int(1000, 9999);
        $user->phone_verification_code = $phoneCode;
        $user->phone_verification_expires_at = now()->addMinutes(10);

        $user->save();

        Mail::to($user->email)->send(new EmailOtpMail($emailCode));


        return response()->json([
            'message' => 'OTP sent to email and phone',
            'temp_id' => $tempId,
            'email_verified' => false,
            'phone_verified' => false,
        ], 201);
    }
/**
 * ✅ RESEND EMAIL OTP (temp_id)
 * POST /api/register/artisan/resend-email
 */
public function resendEmail(Request $request)
{
    $request->validate([
        'temp_id' => 'required|string',
    ]);

    $u = $this->userByTempId($request->temp_id);
    if (!$u) return response()->json(['message' => 'Invalid or expired temp_id'], 422);

    // already verified
    if ($u->email_verified_at) {
        return response()->json(['message' => 'Email already verified', 'email_verified' => true], 200);
    }

    // generate new code
    $emailCode = (string) random_int(1000, 9999);
    $u->email_verification_code = $emailCode;
    $u->email_verification_expires_at = now()->addMinutes(10);
    $u->save();

    // send email
    Mail::to($u->email)->send(new EmailOtpMail($emailCode));

    return response()->json([
        'message' => 'Email OTP resent',
        'email_verified' => false,
    ], 200);
}

/**
 * ✅ RESEND PHONE OTP (temp_id)
 * POST /api/register/artisan/resend-phone
 */
public function resendPhone(Request $request)
{
    $request->validate([
        'temp_id' => 'required|string',
    ]);

    $u = $this->userByTempId($request->temp_id);
    if (!$u) return response()->json(['message' => 'Invalid or expired temp_id'], 422);

    // already verified
    if ($u->phone_verified_at) {
        return response()->json(['message' => 'Phone already verified', 'phone_verified' => true], 200);
    }

    // generate new code
    $phoneCode = (string) random_int(1000, 9999);
    $u->phone_verification_code = $phoneCode;
    $u->phone_verification_expires_at = now()->addMinutes(10);
    $u->save();

    // send sms
    $this->sendSms(new Request([
        'to' => $u->phone,
        'message' => "Votre code de vérification est : {$phoneCode}",
    ]));

    return response()->json([
        'message' => 'Phone OTP resent',
        'phone_verified' => false,
    ], 200);
}

    /**
     * STEP 2: Verify Email
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'temp_id' => 'required|string',
            'code' => 'required|string',
        ]);

        $u = $this->userByTempId($request->temp_id);
        if (!$u)
            return response()->json(['message' => 'Invalid or expired temp_id'], 422);

        if ($u->email_verified_at) {
            return response()->json(['message' => 'Email already verified', 'email_verified' => true], 200);
        }

        if (
            $u->email_verification_code === $request->code &&
            $u->email_verification_expires_at &&
            now()->lessThanOrEqualTo($u->email_verification_expires_at)
        ) {
            $u->email_verified_at = now();
            $u->email_verification_code = null;
            $u->email_verification_expires_at = null;
            $u->save();

            return response()->json(['message' => 'Email verified successfully', 'email_verified' => true], 200);
        }

        return response()->json(['message' => 'Invalid or expired code', 'email_verified' => false], 422);
    }

    /**
     * STEP 3: Verify Phone
     */
    public function verifyPhone(Request $request)
    {
        $request->validate([
            'temp_id' => 'required|string',
            'code' => 'required|string',
        ]);

        $u = $this->userByTempId($request->temp_id);
        if (!$u)
            return response()->json(['message' => 'Invalid or expired temp_id'], 422);

        if ($u->phone_verified_at) {
            return response()->json(['message' => 'Phone already verified', 'phone_verified' => true], 200);
        }

        if (
            $u->phone_verification_code === $request->code &&
            $u->phone_verification_expires_at &&
            now()->lessThanOrEqualTo($u->phone_verification_expires_at)
        ) {
            $u->phone_verified_at = now();
            $u->phone_verification_code = null;
            $u->phone_verification_expires_at = null;
            $u->save();

            return response()->json(['message' => 'Phone verified successfully', 'phone_verified' => true], 200);
        }

        return response()->json(['message' => 'Invalid or expired code', 'phone_verified' => false], 422);
    }

    /**
     * STEP 4: Complete profile (basic info only)
     */
    public function setPassword(Request $request)
    {
        $request->validate([
            'temp_id' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $u = $this->userByTempId($request->temp_id);
        if (!$u)
            return response()->json(['message' => 'Invalid or expired temp_id'], 422);

        $u->password = Hash::make($request->password);
        $u->register_token = null;
        $u->register_token_expires_at = null;
        $u->save();

        $token = $u->createToken('multi-app')->plainTextToken;

        return response()->json([
            'message' => 'Account activated',
            'token' => $token,
            'user' => $u,
        ], 200);
    }

    /**
     * Manual SMS Send
     */
    public function sendSms(Request $request)
    {
        $phone = $request->input('to');
        $message = $request->input('message');

        $response = Http::withHeaders([
            'Authorization' => 'App fa9af75bf804e30f693dbb1f386272e6-f0c85b88-4e22-4043-aaf2-aec0a522f1eb',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://m9mwg9.api.infobip.com/sms/2/text/advanced', [
                    'messages' => [
                        [
                            'from' => 'ServiceSM',
                            'destinations' => [['to' => $phone]],
                            'text' => $message,
                        ]
                    ]
                ]);

        return $response->json();
    }


public function googleRedirect()
{
    return Socialite::driver('google')
        ->stateless()
        ->with(['prompt' => 'select_account'])
        ->redirect();
}

public function googleCallback()
{
    $googleUser = Socialite::driver('google')
        ->stateless()
        ->user();

    // Update or create
    $user = User::updateOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName() ?? 'User',
            'google_id' => $googleUser->getId(),
            'role' => 'user',
            'abonnement' => 'free',
        ]
    );

    // ✅ if password column is NOT nullable in DB, set random hash instead of null
    if (!$user->password) {
        $user->password = Hash::make(Str::random(32));
        $user->save();
    }

    $token = $user->createToken('multi-app')->plainTextToken;

    // ✅ Redirect back to Vue with token
    $frontend = env('FRONTEND_URL', 'http://127.0.0.1:8000');
    return redirect($frontend . '?token=' . urlencode($token));
}



}
