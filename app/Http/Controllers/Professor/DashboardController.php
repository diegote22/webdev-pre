<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Asegurar acceso solo a Profesor/Docente
        $roleName = strtolower(trim(optional($user->role)->name ?? ''));
        if (!in_array($roleName, ['profesor', 'docente'])) {
            abort(403, 'Acceso no autorizado');
        }

        // Métricas principales
        $baseQuery = Course::where('user_id', $user->id);

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'published' => (clone $baseQuery)->published()->count(),
            'under_review' => (clone $baseQuery)->underReview()->count(),
            'pending' => (clone $baseQuery)->pending()->count(),
            'rejected' => (clone $baseQuery)->rejected()->count(),
            'unpublished' => (clone $baseQuery)->unpublished()->count(),
        ];

        $recentCourses = (clone $baseQuery)
            ->select(['id', 'title', 'status', 'updated_at'])
            ->latest('updated_at')
            ->take(6)
            ->get();

        // Total de alumnos en todos los cursos del profesor
        $totalStudents = (clone $baseQuery)
            ->withCount('students')
            ->get()
            ->sum('students_count');

        $unread = (int) session('unread_messages', 0);

        return view('professor.dashboard', compact('user', 'stats', 'recentCourses', 'totalStudents', 'unread'));
    }

    public function profile(Request $request)
    {
        $user = Auth::user();

        // Asegurar acceso solo a Profesor/Docente
        $roleName = strtolower(trim(optional($user->role)->name ?? ''));
        if (!in_array($roleName, ['profesor', 'docente'])) {
            abort(403, 'Acceso no autorizado');
        }

        return view('professor.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Asegurar acceso solo a Profesor/Docente
        $roleName = strtolower(trim(optional($user->role)->name ?? ''));
        if (!in_array($roleName, ['profesor', 'docente'])) {
            abort(403, 'Acceso no autorizado');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'biography' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'first_name.required' => 'El nombre es obligatorio.',
            'last_name.required' => 'Los apellidos son obligatorios.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            'biography.max' => 'La reseña no puede exceder los 1000 caracteres.',
            'avatar.image' => 'El archivo debe ser una imagen.',
            'avatar.mimes' => 'La imagen debe ser de formato: jpeg, jpg, png.',
            'avatar.max' => 'La imagen no puede pesar más de 2MB.',
        ]);

        // Actualizar nombre completo
        $user->name = trim($request->first_name . ' ' . $request->last_name);
        $user->email = $request->email;
        $user->biography = $request->biography;

        // Manejar avatar si se subió uno
        if ($request->hasFile('avatar')) {
            // Eliminar avatar anterior si existe
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            // Subir nuevo avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_path = $avatarPath;
        }

        $user->save();

        return redirect()->route('professor.profile')->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Asegurar acceso solo a Profesor/Docente
        $roleName = strtolower(trim(optional($user->role)->name ?? ''));
        if (!in_array($roleName, ['profesor', 'docente'])) {
            abort(403, 'Acceso no autorizado');
        }

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        // Actualizar contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('professor.profile')->with('success', 'Contraseña actualizada correctamente.');
    }

    public function uploadAvatar(Request $request)
    {
        $user = Auth::user();

        // Asegurar acceso solo a Profesor/Docente
        $roleName = strtolower(trim(optional($user->role)->name ?? ''));
        if (!in_array($roleName, ['profesor', 'docente'])) {
            abort(403, 'Acceso no autorizado');
        }

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Eliminar avatar anterior si existe
        if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        // Subir nuevo avatar
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user->avatar_path = $avatarPath;
        $user->save();

        return response()->json(['success' => true, 'avatar_url' => Storage::url($avatarPath)]);
    }

    public function deleteAvatar(Request $request)
    {
        $user = Auth::user();

        // Asegurar acceso solo a Profesor/Docente
        $roleName = strtolower(trim(optional($user->role)->name ?? ''));
        if (!in_array($roleName, ['profesor', 'docente'])) {
            abort(403, 'Acceso no autorizado');
        }

        if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
            Storage::disk('public')->delete($user->avatar_path);
            $user->avatar_path = null;
            $user->save();
        }

        return response()->json(['success' => true]);
    }
}
