<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $user = auth()->user();

        // Check if user is active
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Hubungi administrator.');
        }

        // Check if user has required role
        if (!in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
