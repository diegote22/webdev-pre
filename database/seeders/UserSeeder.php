<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Administrador')->first();
        $profRole = Role::where('name', 'Profesor')->first();
        $studRole = Role::where('name', 'Estudiante')->first();

        $admin = User::firstOrCreate(
            ['email' => 'admin@demo.test'],
            [
                'name' => 'Admin Demo',
                'password' => Hash::make('password'),
                'role_id' => $adminRole?->id,
            ]
        );

        $prof = User::firstOrCreate(
            ['email' => 'profesor@demo.test'],
            [
                'name' => 'Profesor Demo',
                'password' => Hash::make('password'),
                'role_id' => $profRole?->id,
            ]
        );

        foreach ([1, 2, 3] as $i) {
            User::firstOrCreate(
                ['email' => "estudiante{$i}@demo.test"],
                [
                    'name' => "Estudiante {$i}",
                    'password' => Hash::make('password'),
                    'role_id' => $studRole?->id,
                ]
            );
        }
    }
}
