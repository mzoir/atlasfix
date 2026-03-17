<?php

namespace App\Http\Controllers;

use App\Mail\EmailOtpMail;
use App\Models\ArtisanProfile;
use App\Models\Message;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ArtisanController extends Controller
{
    /**
     * Helper: get user by temp_id (register_token) with expiry check
     */
    private function userByTempId(string $tempId): ?User
    {
        return User::where('register_token', $tempId)
            ->whereNotNull('register_token_expires_at')
            ->where('register_token_expires_at', '>=', now())
            ->first();
    }

    /**
     * STEP 1 ✅ Start registration (NO password, NO token)
     * POST /api/register/artisan/start
     */
    public function start(Request $request)
    {
        $data = $request->validate([
            'nom_complet'    => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:users,email',
            'phone'          => 'required|string|max:30|unique:users,phone',
            'date_of_birth' => 'nullable|date',
        ]);

        $tempId = Str::random(60);

        $artisan = User::create([
            'name' => $data['nom_complet'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => 'artisan',
            'password' => null,
            'abonnement' => 'free',
            'register_token' => $tempId,
            'register_token_expires_at' => now()->addMinutes(20),
            'email_verified_at' => null,
            'phone_verified_at' => null,
        ]);

        ArtisanProfile::create([
            'user_id' => $artisan->id,
            'nom_complet' => $data['nom_complet'],
            'date_naissance' => $data['date_of_birth'] ?? null,
        ]);

        $emailCode = (string) random_int(1000, 9999);
        $artisan->email_verification_code = $emailCode;
        $artisan->email_verification_expires_at = now()->addMinutes(10);

        $phoneCode = (string) random_int(1000, 9999);
        $artisan->phone_verification_code = $phoneCode;
        $artisan->phone_verification_expires_at = now()->addMinutes(10);

        $artisan->save();

        Mail::to($artisan->email)->send(new EmailOtpMail($emailCode));

        $this->sendSms(new Request([
            'to' => $artisan->phone,
            'message' => "Votre code de vérification est : {$phoneCode}",
        ]));

        return response()->json([
            'message' => 'OTP sent to email and phone',
            'temp_id' => $tempId,
            'email_verified' => false,
            'phone_verified' => false,
        ], 201);
    }

    /**
     * STEP 2 ✅ Verify Email
     * POST /api/register/artisan/verify-email
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'temp_id' => 'required|string',
            'code' => 'required|string',
        ]);

        $u = $this->userByTempId($request->temp_id);
        if (!$u) return response()->json(['message' => 'Invalid or expired temp_id'], 422);

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
     * STEP 3 ✅ Verify Phone
     * POST /api/register/artisan/verify-phone
     */
    public function verifyPhone(Request $request)
    {
        $request->validate([
            'temp_id' => 'required|string',
            'code' => 'required|string',
        ]);

        $u = $this->userByTempId($request->temp_id);
        if (!$u) return response()->json(['message' => 'Invalid or expired temp_id'], 422);

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
     * STEP 4 ✅ Complete profile
     * POST /api/register/artisan/complete-profile
     */
    public function completeProfile(Request $request)
    {
        $request->validate([
            'temp_id' => 'required|string',
            'ville' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'diplome' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'diplome_file' => 'nullable|file|max:5120',
            'images.*' => 'nullable|image|max:4096',
            'new_service_name' => 'nullable|string|max:255',
            'service_principal_id' => 'nullable|integer',
            'service_ids' => 'nullable',
        ]);

        $u = $this->userByTempId($request->temp_id);
        if (!$u) return response()->json(['message' => 'Invalid or expired temp_id'], 422);

        $profile = $u->artisanProfile;
        if (!$profile) return response()->json(['message' => 'Profile not found'], 404);

        $profile->ville = $request->ville;
        $profile->adresse = $request->adresse;
        $profile->diplome = $request->diplome;
        $profile->description = $request->description;

        if ($request->hasFile('diplome_file')) {
            $profile->diplome_file_path = $request->file('diplome_file')->store('artisans/diplomes', 'public');
        }
        $profile->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $p = $img->store('artisans/portfolio', 'public');
                $profile->medias()->create(['path' => $p, 'type' => 'image']);
            }
        }

        $newServiceId = null;
        if (!empty($request->new_service_name)) {
            $service = Service::firstOrCreate(
                ['name' => trim($request->new_service_name)],
                ['is_default' => false]
            );
            $newServiceId = $service->id;
        }

        $serviceIds = [];
        if ($request->filled('service_ids')) {
            $raw = $request->input('service_ids');
            if (is_string($raw)) {
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) $serviceIds = $decoded;
            } elseif (is_array($raw)) {
                $serviceIds = $raw;
            }
        }

        if ($newServiceId) $serviceIds[] = $newServiceId;
        if (!empty($request->service_principal_id)) $serviceIds[] = (int) $request->service_principal_id;

        $serviceIds = array_values(array_unique(array_map('intval', $serviceIds)));

        if (!empty($serviceIds)) {
            $u->artisanServices()->sync($serviceIds);
        }

        return response()->json(['message' => 'Profile completed'], 200);
    }

    /**
     * STEP 5 ✅ Set password => create sanctum token
     * POST /api/register/artisan/set-password
     */
    public function setPassword(Request $request)
    {
        $request->validate([
            'temp_id' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $u = $this->userByTempId($request->temp_id);
        if (!$u) return response()->json(['message' => 'Invalid or expired temp_id'], 422);

        $u->password = Hash::make($request->password);
        $u->register_token = null;
        $u->register_token_expires_at = null;
        $u->save();

        $token = $u->createToken('multi-app')->plainTextToken;

        return response()->json([
            'message' => 'Account activated',
            'token' => $token,
            'artisan' => $u->load('artisanProfile.medias', 'artisanServices'),
        ], 200);
    }

    /**
     * RESEND EMAIL OTP
     * POST /api/register/artisan/resend-email
     */
    public function resendEmail(Request $request)
    {
        $request->validate([
            'temp_id' => 'required|string',
        ]);

        $u = $this->userByTempId($request->temp_id);
        if (!$u) return response()->json(['message' => 'Invalid or expired temp_id'], 422);

        if ($u->email_verified_at) {
            return response()->json(['message' => 'Email already verified', 'email_verified' => true], 200);
        }

        $emailCode = (string) random_int(1000, 9999);
        $u->email_verification_code = $emailCode;
        $u->email_verification_expires_at = now()->addMinutes(10);
        $u->save();

        Mail::to($u->email)->send(new EmailOtpMail($emailCode));

        return response()->json([
            'message' => 'Email OTP resent',
            'email_verified' => false,
        ], 200);
    }

    /**
     * RESEND PHONE OTP
     * POST /api/register/artisan/resend-phone
     */
    public function resendPhone(Request $request)
    {
        $request->validate([
            'temp_id' => 'required|string',
        ]);

        $u = $this->userByTempId($request->temp_id);
        if (!$u) return response()->json(['message' => 'Invalid or expired temp_id'], 422);

        if ($u->phone_verified_at) {
            return response()->json(['message' => 'Phone already verified', 'phone_verified' => true], 200);
        }

        $phoneCode = (string) random_int(1000, 9999);
        $u->phone_verification_code = $phoneCode;
        $u->phone_verification_expires_at = now()->addMinutes(10);
        $u->save();

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
     * Manual SMS Send (Infobip)
     */
    public function sendSms(Request $request)
    {
        $phone = $request->input('to');
        $message = $request->input('message');

        $response = Http::withHeaders([
            'Authorization' => 'App fa9af75bf804e30f693dbb1f386272e6-f0c85b88-4e22-4043-aaf2-aec0a522f1eb',
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ])->post('https://m9mwg9.api.infobip.com/sms/2/text/advanced', [
            'messages' => [[
                'from' => 'ServiceSM',
                'destinations' => [['to' => $phone]],
                'text' => $message,
            ]]
        ]);

        return $response->json();
    }

    /**
     * Fetch all artisans
     */
    public function index()
    {
        $artisans = User::where('role', 'artisan')
            ->whereNotNull('password')
            ->with([
                'artisanProfile.medias',
                'artisanServices',
            ])
            ->get()
            ->map(function (User $u) {
                $profile = $u->artisanProfile;

                $photo = $profile?->medias->first()?->path
                    ? asset('storage/' . $profile->medias->first()->path)
                    : null;

                return [
                    'id'             => $u->id,
                    'name'           => $u->name,
                    'email'          => $u->email,
                    'phone'          => $u->phone,
                    'ville'          => $profile?->ville,
                    'description'    => $profile?->description,
                    'speciality'     => $u->artisanServices->first()?->name,
                    'profile_photo'  => $photo,
                    'portfolio_images' => $profile?->medias
    ->map(fn($m) => 'storage/' . $m->path)
    ->values()
    ->toArray() ?? [],
                    'rating'         => null,
                    'reviews_count'  => 0,
                    'is_verified'    => (bool) $u->email_verified_at && (bool) $u->phone_verified_at,
                    'services'       => $u->artisanServices->pluck('name'),
                ];
            });

        return response()->json(['data' => $artisans], 200);
    }

    // ==========================================
    // 💬 MESSAGE METHODS
    // ==========================================

    /**
     * Send a message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'required|string',
        ]);

        $message = Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'data'    => $message,
        ], 201);
    }

    /**
     * Get conversation with a specific user
     */
    public function getConversation($userId)
    {
        $authId = auth()->id();

        $messages = Message::where(function($q) use ($authId, $userId) {
                $q->where('sender_id', $authId)->where('receiver_id', $userId);
            })
            ->orWhere(function($q) use ($authId, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $authId);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $messages,
        ]);
    }

    /**
     * Get all sent messages
     */
    public function sentMessages()
    {
        $messages = auth()->user()
            ->sentMessages()
            ->with('receiver')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $messages,
        ]);
    }

    /**
     * Get all received messages
     */
    public function receivedMessages()
    {
        $messages = auth()->user()
            ->receivedMessages()
            ->with('sender')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $messages,
        ]);
    }

    /**
     * Mark message as read
     */
    public function markAsRead($id)
    {
        $message = Message::where('id', $id)
            ->where('receiver_id', auth()->id())
            ->firstOrFail();

        $message->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Message marked as read',
            'data'    => $message,
        ]);
    }

    /**
     * Get unread messages count
     */
    public function unreadCount()
    {
        $count = Message::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success'      => true,
            'unread_count' => $count,
        ]);
    }
    /**
 * Get all conversations (inbox)
 */
public function allConversations()
{
    $authId = auth()->id();

    $messages = Message::where('sender_id', $authId)
        ->orWhere('receiver_id', $authId)
        ->with(['sender', 'receiver'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy(function ($msg) use ($authId) {
            // Group by the other person's ID
            return $msg->sender_id == $authId ? $msg->receiver_id : $msg->sender_id;
        })
        ->map(function ($msgs) use ($authId) {
            $lastMessage = $msgs->first();
            $otherUser   = $lastMessage->sender_id == $authId
                ? $lastMessage->receiver
                : $lastMessage->sender;

            return [
                'user'          => $otherUser,
                'last_message'  => $lastMessage->message,
                'is_read'       => $lastMessage->is_read,
                'date'          => $lastMessage->created_at,
                'unread_count'  => $msgs->where('receiver_id', $authId)->where('is_read', false)->count(),
            ];
        })
        ->values();

    return response()->json([
        'success' => true,
        'data'    => $messages,
    ]);
}
/**
 * GET /api/artisan/me
 */
public function me(Request $request)
{
    $user = $request->user()->load('artisanProfile.medias', 'artisanServices');
    $profile = $user->artisanProfile;

    $photo = $profile?->medias->first()?->path
        ? asset('storage/' . $profile->medias->first()->path)
        : null;

    return response()->json([
        'success' => true,
        'data' => [
            'id'            => $user->id,
            'name'          => $user->name,
            'email'         => $user->email,
            'phone'         => $user->phone,
            'ville'         => $profile?->ville,
            'description'   => $profile?->description,
            'profile_photo' => $photo,

            // In me() method, add to the data array:
           'portfolio_images' => $profile?->medias->map(fn($m) => asset('storage/' . $m->path))->values() ?? [],
            'services'      => $user->artisanServices->pluck('name'),
            'is_verified'   => (bool) $user->email_verified_at && (bool) $user->phone_verified_at,
        ],
    ]);
}
}