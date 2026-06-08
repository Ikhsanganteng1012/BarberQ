<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login.index');
        }

        $user = auth()->user();
        if (! $user->is_admin) {
            abort(403);
        }

        if (! $user->is_active) {
            abort(403, 'Akun admin dinonaktifkan.');
        }

        return $next($request);
    }
}

