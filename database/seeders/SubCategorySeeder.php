<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
	public function run(): void
	{
		$map = [
			'Secundaria' => ['Matemáticas', 'Física', 'Química'],
			'Pre-Universitario' => ['Biología', 'Anatomía', 'Fisiología'],
			'Universitario' => ['Bioquímica', 'Histología', 'Farmacología'],
		];

		foreach ($map as $categoryName => $subs) {
			$category = Category::where('name', $categoryName)->first();
			if (!$category) {
				continue;
			}
			foreach ($subs as $sc) {
				DB::table('sub_categories')->updateOrInsert(
					['slug' => Str::slug($sc)],
					['name' => $sc, 'category_id' => $category->id]
				);
			}
		}
	}
}
