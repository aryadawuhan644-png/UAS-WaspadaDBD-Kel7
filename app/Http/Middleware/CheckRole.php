<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan user sudah login dan memiliki role yang diizinkan
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            // Jika role tidak sesuai, tendang balik ke dashboard
            return redirect('/dashboard')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk halaman tersebut.');
        }

        return $next($request);
    }
}