<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Administrador']); // ID: 1
        Role::firstOrCreate(['name' => 'Profesor']);      // ID: 2
        Role::firstOrCreate(['name' => 'Estudiante']);    // ID: 3
    }
}
