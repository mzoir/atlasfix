<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use App\Models\ServiceType;
use App\Models\ArtisanProfile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ServiceController
{
    /**
     * Get all service types with their services
     * GET /api/services/types
     */
    public function getServiceTypes(): JsonResponse
    {
        try {
            $serviceTypes = ServiceType::where('is_active', true)
                ->with(['services' => function ($query) {
                    $query->where('is_active', true);
                }])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $serviceTypes,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a specific service type with its services
     * GET /api/services/types/{id}
     */
    public function getServiceType($id): JsonResponse
    {
        try {
            $serviceType = ServiceType::where('is_active', true)
                ->with('services')
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $serviceType,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Service type not found',
            ], 404);
        }
    }

    /**
     * Get all services
     * GET /api/services
     */
    public function getAllServices(): JsonResponse
    {
        try {
            $services = Service::where('is_active', true)
                ->with('serviceType')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $services,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get artisans by service type
     * GET /api/services/types/{serviceTypeId}/artisans
     */
    public function getArtisansByServiceType($serviceTypeId): JsonResponse
    {
        try {
            // Get all services of this type
            $services = Service::where('service_type_id', $serviceTypeId)
                ->pluck('id');

            // Get artisans providing these services
            $artisans = ArtisanProfile::whereHas('services', function ($query) use ($services) {
                $query->whereIn('service_id', $services);
            })
            ->select([
                'id',
                'nom_complet',
                'ville',
                'description',
            ])
            ->with(['services' => function ($query) use ($serviceTypeId) {
                $query->where('service_type_id', $serviceTypeId);
            }])
            ->get();

            return response()->json([
                'success' => true,
                'data' => $artisans,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get artisans by specific service
     * GET /api/services/{serviceId}/artisans
     */
    public function getArtisansByService($serviceId): JsonResponse
    {
        try {
            $service = Service::findOrFail($serviceId);

            $artisans = $service->artisans()
                ->select([
                    'artisan_profiles.id',
                    'artisan_profiles.nom_complet',
                    'artisan_profiles.ville',
                    'artisan_profiles.description',
                ])
                ->with('services')
                ->get();

            return response()->json([
                'success' => true,
                'service' => $service,
                'artisans' => $artisans,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
            ], 404);
        }
    }

    /**
     * Get artisan's services by type
     * GET /api/artisans/{artisanId}/services
     */
    public function getArtisanServices($artisanId): JsonResponse
    {
        try {
            $artisan = ArtisanProfile::findOrFail($artisanId);

            // Get services grouped by type
            $services = $artisan->services()
                ->with('serviceType')
                ->get()
                ->groupBy('serviceType.name');

            return response()->json([
                'success' => true,
                'artisan' => [
                    'id' => $artisan->id,
                    'name' => $artisan->nom_complet,
                    'ville' => $artisan->ville,
                    'description' => $artisan->description,
                ],
                'services_by_type' => $services,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Artisan not found',
            ], 404);
        }
    }

    /**
     * Add a service to an artisan
     * POST /api/artisans/{artisanId}/services
     */
    public function attachServiceToArtisan(Request $request, $artisanId): JsonResponse
    {
        try {
            $validated = $request->validate([
                'service_id' => 'required|exists:services,id',
                'price' => 'nullable|numeric|min:0',
                'availability' => 'nullable|in:available,unavailable',
            ]);

            $artisan = ArtisanProfile::findOrFail($artisanId);

            // Attach service with pivot data
            $artisan->services()->attach($validated['service_id'], [
                'price' => $validated['price'] ?? null,
                'availability' => $validated['availability'] ?? 'available',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service attached successfully',
                'data' => $artisan->services,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove a service from an artisan
     * DELETE /api/artisans/{artisanId}/services/{serviceId}
     */
    public function detachServiceFromArtisan($artisanId, $serviceId): JsonResponse
    {
        try {
            $artisan = ArtisanProfile::findOrFail($artisanId);

            $artisan->services()->detach($serviceId);

            return response()->json([
                'success' => true,
                'message' => 'Service removed successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update service pivot data (price, availability)
     * PUT /api/artisans/{artisanId}/services/{serviceId}
     */
    public function updateServiceForArtisan(Request $request, $artisanId, $serviceId): JsonResponse
    {
        try {
            $validated = $request->validate([
                'price' => 'nullable|numeric|min:0',
                'availability' => 'nullable|in:available,unavailable',
            ]);

            $artisan = ArtisanProfile::findOrFail($artisanId);

            // Update pivot data
            $artisan->services()->updateExistingPivot($serviceId, [
                'price' => $validated['price'] ?? null,
                'availability' => $validated['availability'] ?? 'available',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}