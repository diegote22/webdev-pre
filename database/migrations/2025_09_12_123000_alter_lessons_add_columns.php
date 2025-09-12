<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            if (!Schema::hasColumn('lessons', 'section_id')) {
                $table->foreignId('section_id')->nullable()->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('lessons', 'title')) {
                $table->string('title')->default('');
            }
            if (!Schema::hasColumn('lessons', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('lessons', 'video_type')) {
                $table->enum('video_type', ['youtube', 'local'])->nullable();
            }
            if (!Schema::hasColumn('lessons', 'video_url')) {
                $table->string('video_url')->nullable();
            }
            if (!Schema::hasColumn('lessons', 'thumbnail_path')) {
                $table->string('thumbnail_path')->nullable();
            }
            if (!Schema::hasColumn('lessons', 'is_published')) {
                $table->boolean('is_published')->default(false);
            }
            if (!Schema::hasColumn('lessons', 'is_preview')) {
                $table->boolean('is_preview')->default(false);
            }
            if (!Schema::hasColumn('lessons', 'position')) {
                $table->unsignedInteger('position')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // NOTA: por simplicidad no se eliminan columnas en down; evitar pérdida involuntaria de datos
        });
    }
};
