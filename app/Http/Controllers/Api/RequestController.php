<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequestRequest;
use App\Models\Request as ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RequestController extends Controller
{
    // GET /api/requests
    public function index(Request $request): JsonResponse
    {
        $requests = $request->user()
            ->requests()
            ->latest()
            ->get();

        return response()->json(['data' => $requests]);
    }

    // POST /api/requests
    public function store(StoreRequestRequest $request): JsonResponse
    {
        $serviceRequest = $request->user()
            ->requests()
            ->create($request->validated());

        return response()->json([
            'message' => 'Demande publiée avec succès.',
            'data'    => $serviceRequest,
        ], 201);
    }

    // DELETE /api/requests/{id}
    public function destroy(Request $request, ServiceRequest $serviceRequest): JsonResponse
    {
        if ($request->user()->id !== $serviceRequest->user_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $serviceRequest->delete();

        return response()->json(['message' => 'Demande supprimée.']);
    }
}