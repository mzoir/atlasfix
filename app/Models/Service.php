<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'name',
        'service_type_id',
        'description',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the service type this service belongs to
     * Many Services belong to One ServiceType
     */
    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    /**
     * Get artisans that provide this service
     * Many Services have Many ArtisanProfiles (through pivot table)
     */
    public function artisans(): BelongsToMany
    {
        return $this->belongsToMany(
            ArtisanProfile::class,
            'artisan_service',           // pivot table
            'service_id',                // foreign key in pivot (this model)
            'artisan_profile_id'         // foreign key in pivot (artisan_profiles)
        )
        ->withPivot('price', 'availability')  // Include additional pivot data
        ->withTimestamps()
        ->where('artisan_profiles.is_active', true);  // Only active artisans
    }

    /**
     * Scope to get only active services
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get service with type and artisans
     */
    public function getWithDetails()
    {
        return $this->load('serviceType', 'artisans');
    }
}