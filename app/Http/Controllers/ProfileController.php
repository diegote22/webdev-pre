<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Reglas adicionales para profesor: foto obligatoria si no tiene una
        $roleName = strtolower(trim(optional($request->user()->role)->name ?? ''));
        $isProfessor = in_array($roleName, ['profesor', 'docente']);
        if ($isProfessor) {
            if (empty($request->user()->avatar_path)) {
                $request->validate([
                    'avatar' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
                ], [
                    'avatar.required' => 'La fotografía del profesor es obligatoria.',
                ]);
            } else {
                // Si envía avatar, validarlo
                if ($request->hasFile('avatar')) {
                    $request->validate([
                        'avatar' => ['image', 'mimes:jpeg,jpg,png', 'max:2048'],
                    ]);
                }
            }
        } else {
            // Para otros roles, si envía avatar, validarlo pero no obligar
            if ($request->hasFile('avatar')) {
                $request->validate([
                    'avatar' => ['image', 'mimes:jpeg,jpg,png', 'max:2048'],
                ]);
            }
        }

        // Procesar avatar si viene
        if ($request->hasFile('avatar')) {
            // Eliminar el anterior si existía
            if (!empty($request->user()->avatar_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($request->user()->avatar_path);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar_path'] = $path;
        }

        // Permitir biografía corta
        if (isset($data['biography'])) {
            $data['biography'] = trim($data['biography']);
        }

        $request->user()->fill($data);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
