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
        if (!$user || !$user->role || strcasecmp($user->role->name, $roleName) !== 0) {
            abort(403);
        }
        return $next($request);
    }
}
