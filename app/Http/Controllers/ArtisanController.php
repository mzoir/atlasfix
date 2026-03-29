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
    // ==========================================
    // 🔧 HELPERS
    // ==========================================

    private function userByTempId(string $tempId): ?User
    {
        return User::where('register_token', $tempId)
            ->whereNotNull('register_token_expires_at')
            ->where('register_token_expires_at', '>=', now())
            ->first();
    }

    private function formatArtisan(User $u): array
    {
        $profile = $u->artisanProfile;

        $portfolioImages = collect($profile?->portfolio_images ?? [])
            ->map(fn($path) => asset('storage/' . $path))
            ->values()
            ->toArray();

        return [
            'id'               => $u->id,
            'name'             => $u->name,
            'email'            => $u->email,
            'phone'            => $u->phone,
            'ville'            => $profile?->ville,
            'adresse'          => $profile?->adresse,
            'diplome'          => $profile?->diplome,
            'description'      => $profile?->description,
            'speciality'       => $u->artisanServices->first()?->name,
            'profile_photo'    => $portfolioImages[0] ?? null,
            'portfolio_images' => $portfolioImages,
            'services'         => $u->artisanServices->pluck('name'),
            'is_verified'      => (bool) $u->email_verified_at && (bool) $u->phone_verified_at,
            'rating'           => null,
            'reviews_count'    => 0,
        ];
    }

    // ==========================================
    // 📋 REGISTRATION STEPS
    // ==========================================

    /**
     * STEP 1 — Start registration
     * POST /api/register/artisan/start
     */
    public function start(Request $request)
    {
        $data = $request->validate([
            'nom_complet'   => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email',
            'phone'         => 'required|string|max:30|unique:users,phone',
            'date_of_birth' => 'nullable|date',
        ]);

        $tempId = Str::random(60);

        $artisan = User::create([
            'name'                      => $data['nom_complet'],
            'email'                     => $data['email'],
            'phone'                     => $data['phone'],
            'role'                      => 'artisan',
            'password'                  => null,
            'abonnement'                => 'free',
            'register_token'            => $tempId,
            'register_token_expires_at' => now()->addMinutes(20),
            'email_verified_at'         => null,
            'phone_verified_at'         => null,
        ]);

        ArtisanProfile::create([
            'user_id'        => $artisan->id,
            'nom_complet'    => $data['nom_complet'],
            'date_naissance' => $data['date_of_birth'] ?? null,
        ]);

        $emailCode = (string) random_int(1000, 9999);
        $phoneCode = (string) random_int(1000, 9999);

        $artisan->update([
            'email_verification_code'       => $emailCode,
            'email_verification_expires_at' => now()->addMinutes(10),
            'phone_verification_code'       => $phoneCode,
            'phone_verification_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($artisan->email)->send(new EmailOtpMail($emailCode));

        $this->sendSms(new Request([
            'to'      => $artisan->phone,
            'message' => "Votre code de vérification est : {$phoneCode}",
        ]));

        return response()->json([
            'message'        => 'OTP sent to email and phone',
            'temp_id'        => $tempId,
            'email_verified' => false,
            'phone_verified' => false,
        ], 201);
    }

    /**
     * STEP 2 — Verify email OTP
     * POST /api/register/artisan/verify-email
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'temp_id' => 'required|string',
            'code'    => 'required|string',
        ]);

        $u = $this->userByTempId($request->temp_id);
        if (!$u) {
            return response()->json(['message' => 'Invalid or expired temp_id'], 422);
        }

        if ($u->email_verified_at) {
            return response()->json(['message' => 'Email already verified', 'email_verified' => true], 200);
        }

        $valid = $u->email_verification_code === $request->code
            && $u->email_verification_expires_at
            && now()->lessThanOrEqualTo($u->email_verification_expires_at);

        if (!$valid) {
            return response()->json(['message' => 'Invalid or expired code', 'email_verified' => false], 422);
        }

        $u->update([
            'email_verified_at'             => now(),
            'email_verification_code'       => null,
            'email_verification_expires_at' => null,
        ]);

        return response()->json(['message' => 'Email verified successfully', 'email_verified' => true], 200);
    }

    /**
     * STEP 3 — Verify phone OTP
     * POST /api/register/artisan/verify-phone
     */
    public function verifyPhone(Request $request)
    {
        $request->validate([
            'temp_id' => 'required|string',
            'code'    => 'required|string',
        ]);

        $u = $this->userByTempId($request->temp_id);
        if (!$u) {
            return response()->json(['message' => 'Invalid or expired temp_id'], 422);
        }

        if ($u->phone_verified_at) {
            return response()->json(['message' => 'Phone already verified', 'phone_verified' => true], 200);
        }

        $valid = $u->phone_verification_code === $request->code
            && $u->phone_verification_expires_at
            && now()->lessThanOrEqualTo($u->phone_verification_expires_at);

        if (!$valid) {
            return response()->json(['message' => 'Invalid or expired code', 'phone_verified' => false], 422);
        }

        $u->update([
            'phone_verified_at'             => now(),
            'phone_verification_code'       => null,
            'phone_verification_expires_at' => null,
        ]);

        return response()->json(['message' => 'Phone verified successfully', 'phone_verified' => true], 200);
    }

    /**
     * STEP 4 — Complete artisan profile
     * POST /api/register/artisan/complete-profile
     */
    public function completeProfile(Request $request)
    {
        $request->validate([
            'temp_id'              => 'required|string',
            'ville'                => 'nullable|string|max:255',
            'adresse'              => 'nullable|string|max:255',
            'diplome'              => 'nullable|string|max:255',
            'description'          => 'nullable|string|max:255',
            'diplome_file'         => 'nullable|file|max:5120',
            'images.*'             => 'nullable|image|max:4096',
            'new_service_name'     => 'nullable|string|max:255',
            'service_principal_id' => 'nullable|integer',
            'service_ids'          => 'nullable',
        ]);

        $u = $this->userByTempId($request->temp_id);
        if (!$u) {
            return response()->json(['message' => 'Invalid or expired temp_id'], 422);
        }

        $profile = $u->artisanProfile;
        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        // ── Basic fields ──────────────────────────────────────────────────
        $profileData = [
            'ville'       => $request->ville,
            'adresse'     => $request->adresse,
            'diplome'     => $request->diplome,
            'description' => $request->description,
        ];

        if ($request->hasFile('diplome_file')) {
            $profileData['diplome_file_path'] = $request->file('diplome_file')
                ->store('artisans/diplomes', 'public');
        }

        // ── Portfolio images → stored as JSON array in artisan_profiles ───
        $existingImages = $profile->portfolio_images ?? [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                if (!$img->isValid()) {
                    continue;
                }
                $existingImages[] = $img->store('artisans/portfolio', 'public');
            }
        }

        $profileData['portfolio_images'] = $existingImages;

        $profile->update($profileData);

        // ── Services ──────────────────────────────────────────────────────
        $serviceIds = [];

        if ($request->filled('service_ids')) {
            $raw     = $request->input('service_ids');
            $decoded = is_string($raw) ? json_decode($raw, true) : $raw;
            if (is_array($decoded)) {
                $serviceIds = $decoded;
            }
        }

        if (!empty($request->new_service_name)) {
            $service      = Service::firstOrCreate(
                ['name'       => trim($request->new_service_name)],
                ['is_default' => false]
            );
            $serviceIds[] = $service->id;
        }

        if (!empty($request->service_principal_id)) {
            $serviceIds[] = (int) $request->service_principal_id;
        }

        $serviceIds = array_values(array_unique(array_map('intval', $serviceIds)));

        if (!empty($serviceIds)) {
            $u->artisanServices()->sync($serviceIds);
        }

        return response()->json([
            'message'          => 'Profile completed',
            'images_saved'     => count($existingImages),
            'portfolio_images' => collect($existingImages)
                                    ->map(fn($p) => asset('storage/' . $p))
                                    ->values(),
        ], 200);
    }

    /**
     * STEP 5 — Set password and activate account
     * POST /api/register/artisan/set-password
     */
    public function setPassword(Request $request)
    {
        $request->validate([
            'temp_id'  => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $u = $this->userByTempId($request->temp_id);
        if (!$u) {
            return response()->json(['message' => 'Invalid or expired temp_id'], 422);
        }

        $u->update([
            'password'                  => Hash::make($request->password),
            'register_token'            => null,
            'register_token_expires_at' => null,
        ]);

        $token = $u->createToken('multi-app')->plainTextToken;

        return response()->json([
            'message' => 'Account activated',
            'token'   => $token,
            'artisan' => $u->load('artisanProfile', 'artisanServices'),
        ], 200);
    }

    // ==========================================
    // 🔁 OTP RESEND
    // ==========================================

    /**
     * POST /api/register/artisan/resend-email
     */
    public function resendEmail(Request $request)
    {
        $request->validate(['temp_id' => 'required|string']);

        $u = $this->userByTempId($request->temp_id);
        if (!$u) {
            return response()->json(['message' => 'Invalid or expired temp_id'], 422);
        }

        if ($u->email_verified_at) {
            return response()->json(['message' => 'Email already verified', 'email_verified' => true], 200);
        }

        $emailCode = (string) random_int(1000, 9999);

        $u->update([
            'email_verification_code'       => $emailCode,
            'email_verification_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($u->email)->send(new EmailOtpMail($emailCode));

        return response()->json(['message' => 'Email OTP resent', 'email_verified' => false], 200);
    }

    /**
     * POST /api/register/artisan/resend-phone
     */
    public function resendPhone(Request $request)
    {
        $request->validate(['temp_id' => 'required|string']);

        $u = $this->userByTempId($request->temp_id);
        if (!$u) {
            return response()->json(['message' => 'Invalid or expired temp_id'], 422);
        }

        if ($u->phone_verified_at) {
            return response()->json(['message' => 'Phone already verified', 'phone_verified' => true], 200);
        }

        $phoneCode = (string) random_int(1000, 9999);

        $u->update([
            'phone_verification_code'       => $phoneCode,
            'phone_verification_expires_at' => now()->addMinutes(10),
        ]);

        $this->sendSms(new Request([
            'to'      => $u->phone,
            'message' => "Votre code de vérification est : {$phoneCode}",
        ]));

        return response()->json(['message' => 'Phone OTP resent', 'phone_verified' => false], 200);
    }

    // ==========================================
    // 📡 SMS
    // ==========================================

    public function sendSms(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'App fa9af75bf804e30f693dbb1f386272e6-f0c85b88-4e22-4043-aaf2-aec0a522f1eb',
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ])->post('https://m9mwg9.api.infobip.com/sms/2/text/advanced', [
            'messages' => [[
                'from'         => 'ServiceSM',
                'destinations' => [['to' => $request->input('to')]],
                'text'         => $request->input('message'),
            ]],
        ]);

        return $response->json();
    }

    // ==========================================
    // 👷 ARTISAN LISTING
    // ==========================================

    /**
     * GET /api/artisans
     */
    public function index()
    {
        $artisans = User::where('role', 'artisan')
            ->whereNotNull('password')
            ->with(['artisanProfile', 'artisanServices'])
            ->get()
            ->map(fn(User $u) => $this->formatArtisan($u));

        return response()->json(['data' => $artisans], 200);
    }

    /**
     * GET /api/artisan/me
     */
    public function me(Request $request)
    {
        $user = $request->user()->load('artisanProfile', 'artisanServices');

        return response()->json([
            'success' => true,
            'data'    => $this->formatArtisan($user),
        ]);
    }

    // ==========================================
    // 💬 MESSAGING
    // ==========================================

    /**
     * POST /api/messages
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
     * GET /api/messages/conversation/{userId}
     */
    public function getConversation($userId)
    {
        $authId = auth()->id();

        $messages = Message::where(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $authId)->where('receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $authId);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['success' => true, 'data' => $messages]);
    }

    /**
     * GET /api/messages/sent
     */
    public function sentMessages()
    {
        $messages = auth()->user()
            ->sentMessages()
            ->with('receiver')
            ->latest()
            ->get();

        return response()->json(['success' => true, 'data' => $messages]);
    }

    /**
     * GET /api/messages/received
     */
    public function receivedMessages()
    {
        $messages = auth()->user()
            ->receivedMessages()
            ->with('sender')
            ->latest()
            ->get();

        return response()->json(['success' => true, 'data' => $messages]);
    }

    /**
     * PATCH /api/messages/{id}/read
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
     * GET /api/messages/unread-count
     */
    public function unreadCount()
    {
        $count = Message::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json(['success' => true, 'unread_count' => $count]);
    }

    /**
     * GET /api/messages/conversations
     */
    public function allConversations()
    {
        $authId = auth()->id();

        $conversations = Message::where('sender_id', $authId)
            ->orWhere('receiver_id', $authId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn($msg) => $msg->sender_id == $authId ? $msg->receiver_id : $msg->sender_id)
            ->map(function ($msgs) use ($authId) {
                $last      = $msgs->first();
                $otherUser = $last->sender_id == $authId ? $last->receiver : $last->sender;

                return [
                    'user'         => $otherUser,
                    'last_message' => $last->message,
                    'is_read'      => $last->is_read,
                    'date'         => $last->created_at,
                    'unread_count' => $msgs->where('receiver_id', $authId)
                                          ->where('is_read', false)
                                          ->count(),
                ];
            })
            ->values();

        return response()->json(['success' => true, 'data' => $conversations]);
    }
}