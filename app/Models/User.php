<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\ArtisanProfile;
use App\Models\Service;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
        'ville',
        'phone',
        'register_token',
        'register_token_expires_at',
        'email_verification_code',
        'email_verification_expires_at',
        // phone otp
        'phone_verification_code',
        'phone_verification_expires_at',
        'phone_verified_at',
        'role',


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * User's tasks.
     */

    /**
     * Send email verification notification using custom notification.
     */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',

        ];
    }
    public function artisanProfile()
    {
        return $this->hasOne(ArtisanProfile::class, 'user_id');
    }
    public function artisanServices()
    {
        return $this->belongsToMany(
            Service::class,
            'artisan_service',
            'artisan_user_id',
            'service_id'
        )->withTimestamps();
    }
    public function requests(): HasMany
{
    return $this->hasMany(Request::class);
}
public function sentMessages()
{
    return $this->hasMany(Message::class, 'sender_id');
}

public function receivedMessages()
{
    return $this->hasMany(Message::class, 'receiver_id');
}
// -- Réservations en tant que CLIENT --
public function reservationsClient()
{
    return $this->hasMany(Reservation::class, 'client_id');
}

// -- Réservations en tant qu'ARTISAN --
public function reservationsArtisan()
{
    return $this->hasMany(Reservation::class, 'artisan_id');
}

// -- Avis laissés par ce client --
public function avisLaisses()
{
    return $this->hasMany(Avis::class, 'client_id');
}

// -- Avis reçus par cet artisan --
public function avisRecus()
{
    return $this->hasMany(Avis::class, 'artisan_id');
}

}

