<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $professor = User::whereHas('role', fn($q) => $q->where('name', 'Profesor'))->first();
        if (!$professor) {
            // Si no hay profesor, creamos uno temporal
            $professor = User::factory()->create(['name' => 'Profesor Demo', 'email' => 'profesor@demo.test']);
        }

        $defs = [
            'Secundaria' => [
                'Matemáticas' => [
                    ['Álgebra y Funciones', 19.99, 'Inicial'],
                    ['Geometría y Trigonometría', 24.99, 'Intermedio'],
                ],
                'Física' => [
                    ['Mecánica Básica', 21.99, 'Inicial'],
                ],
            ],
            'Pre-Universitario' => [
                'Biología' => [
                    ['Biología Celular', 29.99, 'Intermedio'],
                ],
                'Anatomía' => [
                    ['Anatomía Humana I', 39.99, 'Avanzado'],
                ],
            ],
        ];

        foreach ($defs as $catName => $subs) {
            $category = Category::where('name', $catName)->first();
            if (!$category) {
                continue;
            }
            foreach ($subs as $subName => $courses) {
                $sub = SubCategory::where('name', $subName)->first();
                foreach ($courses as [$title, $price, $level]) {
                    Course::updateOrCreate(
                        ['title' => $title],
                        [
                            'user_id' => $professor->id,
                            'category_id' => $category->id,
                            'sub_category_id' => $sub?->id,
                            'description' => 'Curso de ' . $title . ' con enfoque práctico y evaluaciones.',
                            'summary' => 'Aprende los fundamentos indispensables.',
                            'price' => $price,
                            'level' => $level,
                            'promo_video_url' => null,
                        ]
                    );
                }
            }
        }
    }
}
