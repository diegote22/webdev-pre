<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
	public function up(): void
	{
		if (!Schema::hasTable('courses')) {
			return;
		}

		Schema::table('courses', function (Blueprint $table) {
			if (!Schema::hasColumn('courses', 'price_tmp')) {
				$table->decimal('price_tmp', 12, 2)->default(0.00);
			}
		});

		if (Schema::hasColumn('courses', 'price')) {
			DB::table('courses')->update(['price_tmp' => DB::raw('price')]);

			Schema::table('courses', function (Blueprint $table) {
				$table->dropColumn('price');
			});
		}

		Schema::table('courses', function (Blueprint $table) {
			if (!Schema::hasColumn('courses', 'price')) {
				$table->decimal('price', 12, 2)->default(0.00);
			}
		});

		DB::table('courses')->update(['price' => DB::raw('price_tmp')]);

		Schema::table('courses', function (Blueprint $table) {
			if (Schema::hasColumn('courses', 'price_tmp')) {
				$table->dropColumn('price_tmp');
			}
		});
	}

	public function down(): void
	{
		if (!Schema::hasTable('courses')) {
			return;
		}

		Schema::table('courses', function (Blueprint $table) {
			if (!Schema::hasColumn('courses', 'price_tmp')) {
				$table->decimal('price_tmp', 8, 2)->default(0.00);
			}
		});

		if (Schema::hasColumn('courses', 'price')) {
			DB::table('courses')->update(['price_tmp' => DB::raw('price')]);

			Schema::table('courses', function (Blueprint $table) {
				$table->dropColumn('price');
			});
		}

		Schema::table('courses', function (Blueprint $table) {
			if (!Schema::hasColumn('courses', 'price')) {
				$table->decimal('price', 8, 2)->default(0.00);
			}
		});

		DB::table('courses')->update(['price' => DB::raw('price_tmp')]);

		Schema::table('courses', function (Blueprint $table) {
			if (Schema::hasColumn('courses', 'price_tmp')) {
				$table->dropColumn('price_tmp');
			}
		});
	}
};
