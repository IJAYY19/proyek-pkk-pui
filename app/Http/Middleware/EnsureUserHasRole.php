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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  // Parameter ini akan berisi 'admin' atau 'kasir'
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek jika:
        // 1. User belum login ATAU
        // 2. User tidak punya relasi 'role' ATAU
        // 3. Nama role user tidak sama dengan role yang dibutuhkan
        if (!$request->user() || !$request->user()->role || $request->user()->role->name !== $role) {
            // Jika salah satu kondisi terpenuhi, hentikan proses dan tampilkan error 403 (Akses Dilarang)
            abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
        }

        // Jika user memiliki role yang sesuai, lanjutkan ke halaman yang dituju
        return $next($request);
    }
}
