<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('marquee_items', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->unsignedSmallInteger('order')->default(0); // orden en la fila
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('marquee_items');
    }
};
