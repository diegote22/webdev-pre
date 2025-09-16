<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lesson_attachments', function (Blueprint $table) {
            $table->string('kind')->default('download')->after('mime'); // 'online' | 'download'
        });
    }

    public function down(): void
    {
        Schema::table('lesson_attachments', function (Blueprint $table) {
            $table->dropColumn('kind');
        });
    }
};
