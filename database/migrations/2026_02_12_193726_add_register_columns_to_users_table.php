<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // temp_id system
            if (!Schema::hasColumn('users', 'register_token')) {
                $table->string('register_token', 80)->nullable()->unique();
            }

            if (!Schema::hasColumn('users', 'register_token_expires_at')) {
                $table->timestamp('register_token_expires_at')->nullable();
            }

            // email otp
            if (!Schema::hasColumn('users', 'email_verification_code')) {
                $table->string('email_verification_code', 10)->nullable();
            }

            if (!Schema::hasColumn('users', 'email_verification_expires_at')) {
                $table->timestamp('email_verification_expires_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'register_token')) {
                $table->dropUnique(['register_token']);
                $table->dropColumn('register_token');
            }
            if (Schema::hasColumn('users', 'register_token_expires_at')) {
                $table->dropColumn('register_token_expires_at');
            }
            if (Schema::hasColumn('users', 'email_verification_code')) {
                $table->dropColumn('email_verification_code');
            }
            if (Schema::hasColumn('users', 'email_verification_expires_at')) {
                $table->dropColumn('email_verification_expires_at');
            }
        });
    }
};
