<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artisan_media', function (Blueprint $table) {
            $table->id();

            $table->foreignId('artisan_profile_id')
                  ->constrained('artisan_profiles')
                  ->cascadeOnDelete();

            $table->string('path'); // image path
            $table->string('type')->default('image');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artisan_media');
    }
};
