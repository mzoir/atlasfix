<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

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
        "phone_verification_code",
        'phone_verification_code',
        'phone_verification_expires_at',
    ];

    protected $casts = [
        'phone_verified_at' => 'datetime',
        'phone_verification_expires_at' => 'datetime',
    ];

    // Multiple images
    public function medias()
    {
        return $this->hasMany(ArtisanMedia::class);
    }
}