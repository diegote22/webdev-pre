<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('title');
            }
            if (!Schema::hasColumn('courses', 'image_path')) {
                $table->string('image_path')->nullable()->after('summary');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'slug')) {
                // El nombre del índice puede variar según el motor; intentamos caer en ambos casos
                try {
                    $table->dropUnique('courses_slug_unique');
                } catch (\Throwable $e) {
                }
                try {
                    $table->dropUnique(['slug']);
                } catch (\Throwable $e) {
                }
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('courses', 'image_path')) {
                $table->dropColumn('image_path');
            }
        });
    }
};
