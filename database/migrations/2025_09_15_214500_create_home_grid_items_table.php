<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_grid_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('order')->unique(); // 1..8
            $table->string('title')->nullable();
            $table->string('media_path');
            $table->enum('media_type', ['image', 'video']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_grid_items');
    }
};
