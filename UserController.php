<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class UserController extends Controller
{
    /**
     * User Login
     */
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Find user by email (trim to avoid hidden spaces)
        $user = User::where('email', trim($request->email))->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        // Check password
        if (!Hash::check(trim($request->password), $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }
        if (!$user->email_verified_at) {
            return response()->json([
                'message' => 'Email not verified',
                'code' => 'EMAIL_NOT_VERIFIED'
            ], 403);
        }
        // revoke previous tokens and create a new one
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,

        ]);
    }
    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }

    /**
     * User Logout
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->tokens()->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out'
        ]);
    }

    /**
     * Show resource by ID
     */
    public function show($id)
    {
        return response()->json([
            'status' => 'success',
            'resource' => [
                'id' => $id,
                'name' => 'Resource ' . $id
            ]
        ]);
    }
    public function index()
    {
        $users = User::select(
            'id',
            'name',
            'email',
            'date_of_birth',
            'phone',
            'email_verified_at',
            'created_at'
        )
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'users' => $users
        ]);
    }
    /**
     * Store resource
     */
    public function store(Request $request)
    {
        $data = $request->all();

        return response()->json([
            'status' => 'success',
            'message' => 'Resource received',
            'data' => $data
        ]);
    }

    /**
     * User Registration
     */
    public function register(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            Log::warning('Registration failed', ['errors' => $validator->errors()]);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create user
        $user = User::create([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'date_of_birth' => trim($request->date_of_birth),
            'phone' => trim($request->phone),
            'password' => Hash::make(trim($request->password)), // Always hash!
        ]);

        Log::info('New user registered', ['user_id' => $user->id, 'email' => $user->email]);
        event(new Registered($user));
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'User registered successfully. log with account',
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
