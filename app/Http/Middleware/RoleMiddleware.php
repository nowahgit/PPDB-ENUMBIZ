<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Redirect and check role.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Jika pendaftar mencoba masuk ke panel admin, atau sebaliknya
            if (Auth::check()) {
                return Auth::user()->role === 'PANITIA' 
                    ? redirect('/admin/dashboard') 
                    : redirect('/dashboard');
            }
            return redirect('/login');
        }

        return $next($request);
    }
}