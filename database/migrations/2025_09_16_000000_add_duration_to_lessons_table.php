<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            if (!Schema::hasColumn('lessons', 'duration')) {
                $table->unsignedInteger('duration')->nullable()->after('position'); // minutos
            }
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            if (Schema::hasColumn('lessons', 'duration')) {
                $table->dropColumn('duration');
            }
        });
    }
};
