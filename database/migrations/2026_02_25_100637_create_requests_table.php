<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();

            // ── Foreign key to users ──────────────────────────────────
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // ── Service info ──────────────────────────────────────────
            $table->string('service_name');          // e.g. "Plomberie"
            $table->string('service_type')->nullable(); // e.g. "Fuite d'eau"

            // ── Request details ───────────────────────────────────────
            $table->text('description');
            $table->string('ville');
            $table->string('address')->nullable();
            $table->text('additional_info')->nullable();

            // ── Status ────────────────────────────────────────────────
            // pending | active | completed | cancelled
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])
                  ->default('pending');

            // ── Responses count (denormalized for quick display) ──────
            $table->unsignedInteger('responses_count')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};