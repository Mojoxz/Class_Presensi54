<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Kelas;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view (default method required by Laravel).
     */
    public function create(): View
    {
        // Default redirect ke student login
        return $this->createStudent();
    }

    /**
     * Display the admin login view.
     */
    public function createAdmin()
    {
        // Jika sudah login sebagai admin, redirect ke dashboard
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Jika login sebagai role lain, logout dulu
        if (Auth::check()) {
            Auth::logout();
        }

        return view('auth.admin-login');
    }

    /**
     * Display the student login view.
     */
    public function createStudent()
    {
        // Jika sudah login sebagai student, redirect ke dashboard
        if (Auth::check() && Auth::user()->role === 'student') {
            return redirect()->route('student.dashboard');
        }

        // Jika login sebagai role lain, logout dulu
        if (Auth::check()) {
            Auth::logout();
        }

        $kelas = Kelas::all();
        return view('auth.student-login', compact('kelas'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Clear any previous session timeout flags
        $request->session()->forget('session_expired');

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } else {
            return redirect()->intended(route('student.dashboard'));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $role = $user ? $user->role : null;

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect based on role
        if ($role === 'admin') {
            return redirect()->route('admin.login');
        } else {
            return redirect()->route('student.login');
        }
    }
}
