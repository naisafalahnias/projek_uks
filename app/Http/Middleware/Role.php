<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Kalau belum login, lempar ke login, jangan di-abort 403
        if (!Auth::check()) {
            return redirect()->route('siswa.login');
        }

        // 2. Ambil role user & pastikan ada di daftar $roles
        // Pakai strtolower buat jaga-jaga kalau di DB ada huruf besar
        $userRole = strtolower(Auth::user()->role);
        
        if (!in_array($userRole, array_map('strtolower', $roles))) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}