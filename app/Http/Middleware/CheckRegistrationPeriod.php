<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRegistrationPeriod
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $periode = \App\Models\SelectionPeriod::where('status', 'AKTIF')->first();

        if (!$periode || !now()->between($periode->tanggal_buka, $periode->tanggal_tutup)) {
            $tutup = $periode ? $periode->tanggal_tutup->format('d M Y H:i') : '-';
            
            if ($request->expectsJson()) {
                return response()->json(['message' => "Maaf, periode pendaftaran sudah ditutup pada $tutup."], 403);
            }

            return redirect()->route('pendaftar.dashboard')->with('error', "Maaf, periode pendaftaran sudah ditutup pada $tutup.");
        }

        return $next($request);
    }
}
