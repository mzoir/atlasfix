<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'name',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Artisans providing this service
     * Pivot table: artisan_service
     * artisan_user_id -> users.id
     */
    public function artisans(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'artisan_service',     // pivot table
            'service_id',          // foreign key on pivot (this model)
            'artisan_user_id'      // foreign key on pivot (users)
        )->withTimestamps();
    }
}
