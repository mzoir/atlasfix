<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\Api\RequestController;
use App\Models\User;
use App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\EmailOtpController;

/*
|--------------------------------------------------------------------------
| Public routes (NO token)
|--------------------------------------------------------------------------
*/

// ✅ Register client
Route::post('/register/client', [UserController::class, 'register']


);;
Route::post('/test-sms', [ArtisanController::class, 'sendSms']);

Route::post('/email/send-otp', [EmailOtpController::class, 'send']);
Route::post('/email/verify-otp', [EmailOtpController::class, 'verify']);

Route::get('/auth/google', function () { return Socialite::driver('google')->redirect(); })->name('google.login'); // Step 2: Handle callback 
// Route::get('/auth/google/callback', [UserController::class, 'googleCallback']) ->name('google.callback');

Route::middleware('auth:sanctum')->post('/phone/verify', [ArtisanController::class, 'phoneVerify']);


Route::post('/register/artisan/start', [ArtisanController::class, 'start']); // step1
Route::post('/register/artisan/verify-email', [ArtisanController::class, 'verifyEmail']); // step2
Route::post('/register/artisan/verify-phone', [ArtisanController::class, 'verifyPhone']); // step3
Route::post('/register/artisan/complete-profile', [ArtisanController::class, 'completeProfile']); // step4 multipart
Route::post('/register/artisan/set-password', [ArtisanController::class, 'setPassword']); // step5 => token


Route::middleware('auth:sanctum')->group(function () {

    // Renvoi email verification
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent']);
    });

    // Confirmer (le lien ouvre cette route)
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return response()->json(['message' => 'Email verified']);
    })->name('verification.verify');
});
// ✅ Login (keep closure)
Route::post('/login', function (Request $req) {
    $req->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string']
    ]);

    $user = User::where('email', $req->email)->first();

    if (! $user || ! Hash::check($req->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('multi-app')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => $user
    ]);
});
// STEP 1: Start registration
 Route::post('/register/user/start', [UserController::class, 'start']); 
 Route::post('/register/user/verify-email', [UserController::class, 'verifyEmail']); 
 Route::post('/register/user/verify-phone', [UserController::class, 'verifyPhone']); 
 Route::post('/register/user/complete-profile', [UserController::class, 'completeProfile']); // STEP 5: Set Password 
Route::post('/register/user/set-password', [UserController::class, 'setPassword']);
/*
|--------------------------------------------------------------------------
| Authenticated routes (token required)
|--------------------------------------------------------------------------
*/
Route::post('/register/user/resend-email', [ArtisanController::class, 'resendEmail']);
Route::post('/register/user/resend-phone', [ArtisanController::class, 'resendPhone']);


Route::middleware('auth:sanctum')->group(function () {

    // ✅ Logout
    Route::post('/logout', [UserController::class, 'logout']);

    // Current authenticated user
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // Debug route (optional)
    Route::get('/debug-user', function (Request $request) {
        return response()->json([
            'authenticated_user' => $request->user(),
            'bearer_token'       => $request->bearerToken(),
        ]);
    });

    // Send verification notification (requires token)
 
    // Verify email (token-based)
 
}); // ✅ group closed correctly


/*
|--------------------------------------------------------------------------
| get user me 
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return ['user' => $request->user()];
});

/*
|--------------------------------------------------------------------------
| Resend verification by email (NO token)
|--------------------------------------------------------------------------
*/

Route::post('/register/artisan', [ArtisanController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/artisan/me', [ArtisanController::class, 'me']);
    Route::post('/artisan/me', [ArtisanController::class, 'updateMe']); // use form-data for image
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get   ('requests',             [RequestController::class, 'index']);
    Route::post  ('requests',             [RequestController::class, 'store']);
    Route::delete('requests/{serviceRequest}', [RequestController::class, 'destroy']);
});
