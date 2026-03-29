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
// App\Models\ArtisanMedia.php

protected $table = 'artisan_media'; // match exactly what your migration created
    public function artisanProfile()
    {
        return $this->belongsTo(ArtisanProfile::class);
    }
}
