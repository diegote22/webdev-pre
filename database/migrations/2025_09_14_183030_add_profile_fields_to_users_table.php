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
        Schema::table('users', function (Blueprint $table) {
            $table->string('title', 60)->nullable()->after('email');
            $table->text('biography')->nullable()->after('title');
            $table->string('language', 5)->default('es')->after('biography');
            $table->string('website')->nullable()->after('language');
            $table->string('facebook', 100)->nullable()->after('website');
            $table->string('instagram', 100)->nullable()->after('facebook');
            $table->string('linkedin')->nullable()->after('instagram');
            $table->string('tiktok', 100)->nullable()->after('linkedin');
            $table->string('twitter', 100)->nullable()->after('tiktok');
            $table->string('youtube', 100)->nullable()->after('twitter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'biography',
                'language',
                'website',
                'facebook',
                'instagram',
                'linkedin',
                'tiktok',
                'twitter',
                'youtube'
            ]);
        });
    }
};
