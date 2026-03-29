<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('artisan_profiles', function (Blueprint $table) {
        $table->json('portfolio_images')->nullable()->after('description');
    });
}

public function down()
{
    Schema::table('artisan_profiles', function (Blueprint $table) {
        $table->dropColumn('portfolio_images');
    });
}
};
