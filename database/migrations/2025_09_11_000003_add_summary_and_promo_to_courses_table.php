<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('courses', function (Blueprint $table) {
			if (!Schema::hasColumn('courses', 'summary')) {
				$table->text('summary')->nullable();
			}
			if (!Schema::hasColumn('courses', 'promo_video_url')) {
				$table->string('promo_video_url')->nullable();
			}
		});
	}

	public function down(): void
	{
		Schema::table('courses', function (Blueprint $table) {
			if (Schema::hasColumn('courses', 'summary')) {
				$table->dropColumn('summary');
			}
			if (Schema::hasColumn('courses', 'promo_video_url')) {
				$table->dropColumn('promo_video_url');
			}
		});
	}
};
