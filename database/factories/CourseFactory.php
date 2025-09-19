<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        $user = \App\Models\User::factory()->create();
        $category = \App\Models\Category::factory()->create();
        return [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'price' => 100,
            'status' => 'published',
            'sub_category_id' => null,
        ];
    }
}
