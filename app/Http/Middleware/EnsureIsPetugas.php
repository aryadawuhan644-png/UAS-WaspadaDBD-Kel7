<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsPetugas
{
    public function handle(Request $request, Closure $next)
    {
        // Jika user bukan admin, dan dia mencoba mengakses route sensitif
        if (auth()->user()->role !== 'petugas' && auth()->user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}