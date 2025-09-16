<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roleName): Response
    {
        $user = $request->user();
        // Permitir lista de roles separados por coma: role:Profesor,Administrador
        $allowed = array_map('trim', explode(',', $roleName));
        $hasRole = $user && $user->role && collect($allowed)->contains(function ($r) use ($user) {
            return strcasecmp($user->role->name, $r) === 0;
        });
        if (!$hasRole) abort(403);
        return $next($request);
    }
}
