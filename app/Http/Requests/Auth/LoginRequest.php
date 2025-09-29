<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'kelas' => ['nullable', 'exists:kelas,id'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        $user = Auth::user();

        // Validasi khusus untuk siswa
        if ($user->role === 'student') {
            $selectedKelas = $this->input('kelas');

            // Jika kelas dipilih tapi tidak sesuai dengan data siswa
            if ($selectedKelas && $user->kelas_id != $selectedKelas) {
                Auth::logout();

                throw ValidationException::withMessages([
                    'kelas' => 'Kelas yang dipilih tidak sesuai dengan data Anda.',
                ]);
            }

            // Jika tidak memilih kelas padahal siswa harus memilih
            if (!$selectedKelas && $user->kelas_id) {
                Auth::logout();

                throw ValidationException::withMessages([
                    'kelas' => 'Silakan pilih kelas yang sesuai.',
                ]);
            }
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
            'kelas.exists' => 'Kelas yang dipilih tidak valid.',
        ];
    }
}
