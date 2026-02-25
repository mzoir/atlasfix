<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtisanMedia extends Model
{
    protected $fillable = [
        'artisan_profile_id',
        'path',
        'type',
    ];

    public function artisanProfile()
    {
        return $this->belongsTo(ArtisanProfile::class);
    }
}
