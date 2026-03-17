<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('artisan_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
            $table->tinyInteger('note')->unsigned(); // 1 à 5
            $table->text('commentaire')->nullable();
            $table->timestamps();

            // Un client ne peut laisser qu'un seul avis par réservation
            $table->unique('reservation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};