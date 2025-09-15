<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();

        // Estadísticas del estudiante
        $totalCourses = 5; // Cursos matriculados (simulado)
        $completedCourses = 2; // Cursos completados (simulado)
        $inProgressCourses = 3; // Cursos en progreso (simulado)
        $totalHours = 45; // Horas estudiadas (simulado)

        // Cursos recientes o destacados
        $recentCourses = Course::with(['category', 'subCategory', 'professor'])
            ->latest()
            ->limit(3)
            ->get();

        // Cursos recomendados por categoría (simulado)
        $recommendedCourses = Course::with(['category', 'subCategory', 'professor'])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('student.dashboard', compact(
            'user',
            'totalCourses',
            'completedCourses',
            'inProgressCourses',
            'totalHours',
            'recentCourses',
            'recommendedCourses'
        ));
    }

    public function profile(): View
    {
        /** @var User $user */
        $user = Auth::user();
        return view('student.profile', compact('user'));
    }

    public function myCourses(Request $request): View
    {
        /** @var User $user */
        $user = Auth::user();

        $q = trim((string) $request->get('q', ''));

        // Simulando cursos del estudiante - en producción vendrían de una tabla pivot
        $query = Course::with(['category', 'subCategory', 'professor']);
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('summary', 'like', "%{$q}%");
            });
        } else {
            $query->inRandomOrder();
        }

        $enrolledCourses = $query->limit(6)->get();

        return view('student.my-courses', compact('user', 'enrolledCourses'));
    }

    public function messages(): View
    {
        /** @var User $user */
        $user = Auth::user();

        // Simulando mensajes - en producción vendrían de una tabla de mensajes
        $messages = collect([
            (object) [
                'id' => 1,
                'from' => 'Prof. María González',
                'subject' => 'Bienvenido al curso de Laravel',
                'preview' => 'Hola! Te doy la bienvenida al curso. Aquí tienes los recursos...',
                'created_at' => now()->subHours(2),
                'read' => false,
                'avatar' => null
            ],
            (object) [
                'id' => 2,
                'from' => 'Ana Paula De la Torre García',
                'subject' => 'Tarea disponible',
                'preview' => 'Hay una nueva tarea disponible en el módulo 3...',
                'created_at' => now()->subHours(5),
                'read' => true,
                'avatar' => null
            ],
            (object) [
                'id' => 3,
                'from' => 'WebDev Administrador',
                'subject' => 'Actualización del sistema',
                'preview' => 'Hemos actualizado la plataforma con nuevas funcionalidades...',
                'created_at' => now()->subDay(),
                'read' => false,
                'avatar' => null
            ]
        ]);
        // Al entrar a la bandeja, marcar como vistos: resetea el contador de no leídos
        session(['student.unread_messages' => 0]);

        return view('student.messages', compact('user', 'messages'));
    }

    public function updateProfile(UpdateStudentProfileRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        // Obtener los datos validados
        $validatedData = $request->validated();

        // Manejar la subida del avatar si se proporciona
        if ($request->hasFile('avatar')) {
            // Eliminar el avatar anterior si existe
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            // Subir el nuevo avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validatedData['avatar_path'] = $avatarPath;
        }

        // Actualizar el usuario
        $user->fill($validatedData);
        $user->save();

        return redirect()->route('student.profile')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        // Actualizar la contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('student.profile')
            ->with('success', 'Contraseña actualizada correctamente.');
    }

    public function updateEmail(UpdateEmailRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        return redirect()->route('student.profile')
            ->with('success', 'Correo electrónico actualizado correctamente.');
    }

    public function uploadAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ], [
            'avatar.required' => 'Por favor selecciona una imagen.',
            'avatar.image' => 'El archivo debe ser una imagen.',
            'avatar.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png.',
            'avatar.max' => 'La imagen no puede pesar más de 2MB.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Eliminar el avatar anterior si existe
        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        // Subir el nuevo avatar
        $avatarPath = $request->file('avatar')->store('avatars', 'public');

        // Actualizar el usuario
        $user->avatar_path = $avatarPath;
        $user->save();

        return redirect()->route('student.profile')
            ->with('success', 'Foto de perfil actualizada correctamente.');
    }

    public function deleteAvatar(): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->avatar_path) {
            // Eliminar el archivo
            Storage::disk('public')->delete($user->avatar_path);

            // Actualizar el usuario
            $user->avatar_path = null;
            $user->save();

            return redirect()->route('student.profile')
                ->with('success', 'Foto de perfil eliminada correctamente.');
        }

        return redirect()->route('student.profile')
            ->with('error', 'No tienes foto de perfil para eliminar.');
    }
}
