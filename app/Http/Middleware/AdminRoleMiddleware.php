<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika pengguna tidak login, arahkan ke halaman login admin
        if (!Auth::check()) {
            return redirect('/admin/login');
        }

        // Jika pengguna login tetapi bukan admin
        if (Auth::user()->role !== 'admin') {
            Auth::logout(); // Logout pengguna jika bukan admin
            return redirect('/admin/login')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        // Lanjutkan jika pengguna adalah admin
        return $next($request);
    }
}
