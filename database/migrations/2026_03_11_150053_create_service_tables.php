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
        // ════════════════════════════════════════════
        // Create service_types table
        // ════════════════════════════════════════════
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();           // Plombier, Electricien, etc.
            $table->string('slug')->unique();           // plombier, electricien
            $table->string('icon')->nullable();         // Icon URL or path
            $table->text('description')->nullable();    // Type description
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Index for faster queries
            $table->index('slug');
            $table->index('is_active');
        });

        // ════════════════════════════════════════════
        // Create services table
        // ════════════════════════════════════════════
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_type_id')        // Foreign key to service_types
                  ->constrained('service_types')
                  ->onDelete('cascade');
            $table->string('name');                     // Service name
            $table->text('description')->nullable();    // Service description
            $table->string('icon')->nullable();         // Service icon
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index('service_type_id');
            $table->index('is_active');
        });

        // ════════════════════════════════════════════
        // Create artisan_service pivot table
        // ════════════════════════════════════════════
        Schema::create('artisan_service', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('artisan_profile_id')     // Foreign key to artisan_profiles
                  ->constrained('artisan_profiles')
                  ->onDelete('cascade');
            $table->foreignId('service_id')             // Foreign key to services
                  ->constrained('services')
                  ->onDelete('cascade');
            
            // Additional data
            $table->decimal('price', 10, 2)->nullable(); // Price for this service
            $table->string('availability')->default('available'); // available, unavailable
            $table->timestamps();

            // Unique constraint: one artisan can only have one record per service
            $table->unique(['artisan_profile_id', 'service_id']);
            
            // Indexes
            $table->index('artisan_profile_id');
            $table->index('service_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artisan_service');
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_types');
    }
};