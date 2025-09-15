<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test student user for testing profile functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Crear el rol de estudiante si no existe
        $studentRole = Role::firstOrCreate(['name' => 'Estudiante']);

        // Crear el usuario de prueba
        $user = User::updateOrCreate(
            ['email' => 'estudiante@test.com'],
            [
                'name' => 'Ana María González',
                'password' => Hash::make('password123'),
                'role_id' => $studentRole->id,
                'title' => 'Estudiante de Desarrollo Web',
                'biography' => 'Soy una estudiante apasionada por el desarrollo web y la programación.',
                'language' => 'es',
                'website' => 'https://anamaria.dev',
                'facebook' => 'anamaria.gonzalez',
                'instagram' => 'ana_maria_dev',
                'linkedin' => 'in/anamariagonzalez',
                'twitter' => 'anamaria_dev',
            ]
        );

        $this->info('Usuario de prueba creado exitosamente:');
        $this->info('Email: estudiante@test.com');
        $this->info('Password: password123');
        $this->info('Nombre: ' . $user->name);
        $this->info('Rol: ' . $user->role->name);

        return 0;
    }
}
