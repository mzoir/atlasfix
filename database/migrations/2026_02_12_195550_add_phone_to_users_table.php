<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users','phone_verification_code')) {
                $table->string('phone_verification_code',10)->nullable();
            }

            if (!Schema::hasColumn('users','phone_verification_expires_at')) {
                $table->timestamp('phone_verification_expires_at')->nullable();
            }

            if (!Schema::hasColumn('users','phone_verified_at')) {
                $table->timestamp('phone_verified_at')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'phone_verification_code',
                'phone_verification_expires_at',
                'phone_verified_at'
            ]);

        });
    }
};
