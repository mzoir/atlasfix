<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceType extends Model
{
    protected $table = 'service_types';

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all services of this type
     * One ServiceType has Many Services
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'service_type_id')
            ->where('is_active', true);
    }

    /**
     * Get all services including inactive ones
     */
    public function allServices(): HasMany
    {
        return $this->hasMany(Service::class, 'service_type_id');
    }

    /**
     * Get active service types with services
     */
    public static function getActive()
    {
        return self::where('is_active', true)
            ->with('services')
            ->get();
    }

    /**
     * Get all service types for home page
     */
    public static function forHomePage()
    {
        return self::where('is_active', true)
            ->with(['services' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();
    }
}