<?php
// app/Http/Middleware/GuestMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    /**
     * Redirect user yang sudah login agar tidak bisa akses halaman login/register.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $role = auth()->user()->role;

            return match($role) {
                'PANITIA'    => redirect()->route('admin.dashboard'),
                'PENDAFTAR'  => redirect()->route('pendaftar.dashboard'),
                default      => redirect()->route('login'),
            };
        }

        return $next($request);
    }
}