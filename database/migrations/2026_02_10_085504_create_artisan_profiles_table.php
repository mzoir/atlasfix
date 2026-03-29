<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artisan_profiles', function (Blueprint $table) {
            $table->id();

            // Relation user
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Infos perso
            $table->string('nom_complet');
            $table->date('date_naissance')->nullable();
            $table->string('ville')->nullable();
            $table->string('adresse')->nullable();

            // Diplôme texte (ex: Bac+2 plomberie)
            $table->string('diplome')->nullable();

            // Diplôme fichier (PDF ou image)
            $table->string('diplome_file_path')->nullable();

            // Description
            $table->text('description')->nullable();

            // Image profil principale

            // ===== Phone Verification =====
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('phone_verification_code', 10)->nullable();
            $table->timestamp('phone_verification_expires_at')->nullable();
   

            $table->timestamps();

            // 1 profile par user
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artisan_profiles');
    }
};
