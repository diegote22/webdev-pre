<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Llamamos a nuestros nuevos seeders
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            UserSeeder::class,
            CourseSeeder::class,
        ]);
    }
}
