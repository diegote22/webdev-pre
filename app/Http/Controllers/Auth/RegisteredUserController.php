<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable', 'in:Estudiante,Profesor'],
            'professor_token' => ['nullable', 'string'],
        ]);

        // Si se registra como profesor, exigir token válido
        $roleId = null;
        if ($request->role === 'Profesor') {
            $token = $request->string('professor_token')->trim();
            if ($token->isEmpty()) {
                return back()->withErrors(['professor_token' => 'Se requiere un token válido para registrarse como Profesor.'])->withInput();
            }
            $record = \App\Models\ProfessorInvitationToken::where('token', $token)->first();
            if (!$record) {
                return back()->withErrors(['professor_token' => 'El token proporcionado no existe.'])->withInput();
            }
            if ($record->expires_at && now()->greaterThan($record->expires_at)) {
                return back()->withErrors(['professor_token' => 'El token ha expirado.'])->withInput();
            }
            if ($record->used_at || $record->used_by) {
                return back()->withErrors(['professor_token' => 'El token ya fue utilizado.'])->withInput();
            }

            // Asignar rol Profesor
            $roleId = \App\Models\Role::where('name', 'Profesor')->value('id');
        } else {
            // Por defecto Estudiante
            $roleId = \App\Models\Role::where('name', 'Estudiante')->value('id');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleId,
        ]);

        // Consumir token si corresponde
        if (isset($record) && $record) {
            $record->update([
                'used_by' => $user->id,
                'used_at' => now(),
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
