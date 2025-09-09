<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Llamamos a nuestros nuevos seeders
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
        ]);
    }
}
