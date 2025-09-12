<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('categories', function (Blueprint $table) {
			if (!Schema::hasColumn('categories', 'slug')) {
				$table->string('slug')->unique()->after('name');
			}
		});
	}

	public function down(): void
	{
		Schema::table('categories', function (Blueprint $table) {
			if (Schema::hasColumn('categories', 'slug')) {
				$table->dropUnique(['slug']);
				$table->dropColumn('slug');
			}
		});
	}
};
