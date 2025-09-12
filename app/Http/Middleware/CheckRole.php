<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Primero, verifica si el usuario está autenticado.
        // Luego, verifica si el rol del usuario coincide con el rol requerido.
        if (!Auth::check() || Auth::user()->role->name !== $role) {
            // Si no coincide, lo redirige a la página de inicio.
            return redirect('/');
        }

        return $next($request);
    }
}
