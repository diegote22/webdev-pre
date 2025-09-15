<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    // Crear un rol de estudiante
    $this->studentRole = Role::firstOrCreate(['name' => 'Estudiante']);

    // Crear un usuario estudiante
    $this->student = User::factory()->create([
        'name' => 'Juan Pérez',
        'email' => 'juan@example.com',
        'role_id' => $this->studentRole->id,
    ]);
});

test('student can view profile page', function () {
    $response = $this->actingAs($this->student)->get('/student/profile');

    $response->assertStatus(200);
    $response->assertViewIs('student.profile');
    $response->assertViewHas('user', $this->student);
});

test('student can update profile information', function () {
    $profileData = [
        'first_name' => 'Juan Carlos',
        'last_name' => 'Pérez García',
        'title' => 'Desarrollador Web',
        'biography' => 'Soy un desarrollador apasionado por la tecnología.',
        'language' => 'es',
        'website' => 'https://juanperez.dev',
        'facebook' => 'juanperez',
        'instagram' => 'juan_perez',
        'linkedin' => 'in/juanperez',
        'tiktok' => '@juanperez',
        'twitter' => 'juanperez',
        'youtube' => 'juanperez',
    ];

    $response = $this->actingAs($this->student)
        ->patch('/student/profile', $profileData);

    $response->assertRedirect('/student/profile');
    $response->assertSessionHas('success', 'Perfil actualizado correctamente.');

    // Verificar que los datos se guardaron correctamente
    $this->student->refresh();
    expect($this->student->name)->toBe('Juan Carlos Pérez García');
    expect($this->student->title)->toBe('Desarrollador Web');
    expect($this->student->biography)->toBe('Soy un desarrollador apasionado por la tecnología.');
    expect($this->student->website)->toBe('https://juanperez.dev');
});

test('student can update password', function () {
    $newPassword = 'new-password-123';

    $response = $this->actingAs($this->student)
        ->patch('/student/profile/password', [
            'current_password' => 'password', // La contraseña por defecto de factory
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

    $response->assertRedirect('/student/profile');
    $response->assertSessionHas('success', 'Contraseña actualizada correctamente.');

    // Verificar que la contraseña se actualizó
    $this->student->refresh();
    expect(Hash::check($newPassword, $this->student->password))->toBeTrue();
});

test('student can upload avatar', function () {
    if (! extension_loaded('gd')) {
        $this->markTestSkipped('GD extension is not installed. Skipping avatar upload test.');
    }
    Storage::fake('public');

    $file = UploadedFile::fake()->image('avatar.jpg', 200, 200);

    $response = $this->actingAs($this->student)
        ->post('/student/profile/avatar', [
            'avatar' => $file,
        ]);

    $response->assertRedirect('/student/profile');
    $response->assertSessionHas('success', 'Foto de perfil actualizada correctamente.');

    // Verificar que el archivo se subió
    $this->student->refresh();
    expect($this->student->avatar_path)->not->toBeNull();
    Storage::disk('public')->assertExists($this->student->avatar_path);
});

test('student can delete avatar', function () {
    if (! extension_loaded('gd')) {
        $this->markTestSkipped('GD extension is not installed. Skipping avatar delete test.');
    }
    Storage::fake('public');

    // Crear un avatar existente
    $file = UploadedFile::fake()->image('avatar.jpg');
    $path = $file->store('avatars', 'public');

    $this->student->update(['avatar_path' => $path]);

    $response = $this->actingAs($this->student)
        ->delete('/student/profile/avatar');

    $response->assertRedirect('/student/profile');
    $response->assertSessionHas('success', 'Foto de perfil eliminada correctamente.');

    // Verificar que el avatar se eliminó
    $this->student->refresh();
    expect($this->student->avatar_path)->toBeNull();
    Storage::disk('public')->assertMissing($path);
});

test('profile update validates required fields', function () {
    $response = $this->actingAs($this->student)
        ->patch('/student/profile', [
            'first_name' => '',
            'last_name' => '',
            'language' => 'invalid',
        ]);

    $response->assertSessionHasErrors(['first_name', 'last_name', 'language']);
});

test('password update validates current password', function () {
    $response = $this->actingAs($this->student)
        ->patch('/student/profile/password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response->assertSessionHasErrors(['current_password']);
});

test('avatar upload validates file type and size', function () {
    Storage::fake('public');

    // Test con archivo inválido
    $invalidFile = UploadedFile::fake()->create('document.pdf', 1024);

    $response = $this->actingAs($this->student)
        ->post('/student/profile/avatar', [
            'avatar' => $invalidFile,
        ]);

    $response->assertSessionHasErrors(['avatar']);
});
