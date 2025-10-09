<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeoutMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika request adalah AJAX dan session sudah habis
        if ($request->ajax() || $request->wantsJson()) {
            if (!Auth::check()) {
                $user = $request->user();
                $redirectRoute = $user && $user->role === 'admin'
                    ? route('admin.login')
                    : route('student.login');

                return response()->json([
                    'error' => 'Session expired',
                    'message' => 'Sesi Anda telah berakhir. Silakan login kembali.',
                    'redirect' => $redirectRoute
                ], 401);
            }
        }

        return $next($request);
    }
}
