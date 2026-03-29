<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtisanProfile extends Model
{
    protected $fillable = [
        'user_id',
        'nom_complet',
        'date_naissance',
        'ville',
        'adresse',
        'diplome',
        'diplome_file_path',
        'description',
        'phone_verified_at',
        'phone_verification_code',
        'phone_verification_expires_at',
         'portfolio_images',  // ← ADD THIS
    ];

    protected $casts = [
        'portfolio_images' => 'array',
        'phone_verified_at' => 'datetime',
        'phone_verification_expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns this artisan profile
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get media files for this artisan
     * (existing relationship)
     */
    public function medias(): HasMany
    {
        return $this->hasMany(ArtisanMedia::class);
    }

    /**
     * ✅ NEW: Get services provided by this artisan
     * Many ArtisanProfiles have Many Services (through artisan_service pivot table)
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            Service::class,
            'artisan_service',           // pivot table
            'artisan_profile_id',        // foreign key on pivot (this model)
            'service_id'                 // foreign key on pivot (services)
        )
        ->withPivot('price', 'availability')  // Include additional pivot data
        ->withTimestamps()
        ->where('services.is_active', true);  // Only active services
    }

    /**
     * ✅ NEW: Get service types provided by this artisan
     * Convenience method to get unique service types
     */
    public function serviceTypes(): BelongsToMany
    {
        return $this->services()
            ->with('serviceType')
            ->get()
            ->groupBy('serviceType.name');
    }

    /**
     * ✅ NEW: Check if artisan provides a specific service
     */
    public function hasService($serviceId): bool
    {
        return $this->services()
            ->where('service_id', $serviceId)
            ->exists();
    }

    /**
     * ✅ NEW: Check if artisan provides services of a specific type
     */
    public function hasServiceType($serviceTypeId): bool
    {
        return $this->services()
            ->whereHas('serviceType', function ($query) use ($serviceTypeId) {
                $query->where('id', $serviceTypeId);
            })
            ->exists();
    }

    /**
     * ✅ NEW: Get services grouped by type
     */
    public function getServicesByType()
    {
        return $this->services()
            ->with('serviceType')
            ->get()
            ->groupBy('serviceType.name');
    }

    /**
     * ✅ NEW: Get all services with pricing
     */
    public function getServicesWithPricing()
    {
        return $this->services()
            ->with('serviceType')
            ->get()
            ->map(function ($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'type' => $service->serviceType->name,
                    'price' => $service->pivot->price,
                    'availability' => $service->pivot->availability,
                ];
            });
    }
}