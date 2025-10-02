<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - SMP 54 Surabaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
</head>
<body class="login-page">
    <!-- Floating Shapes Background -->
    <div class="login-floating-shape login-shape-1"></div>
    <div class="login-floating-shape login-shape-2"></div>

    <div class="login-container">
        <div class="login-wrapper">
            <!-- Logo -->
            <div class="login-logo">
                <img src="{{ asset('logo.png') }}" alt="SMP 54 Surabaya" >
            </div>

            <!-- Header Text -->
            <div class="login-header">
                <h2 class="gradient-text">Login Siswa</h2>
                <p>SMP 54 Surabaya</p>
            </div>

            <!-- Login Card -->
            <div class="login-card">
                <form class="login-form" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            Email
                        </label>
                        <input id="email"
                               name="email"
                               type="email"
                               autocomplete="email"
                               required
                               class="form-input @error('email') form-input-error @enderror"
                               value="{{ old('email') }}"
                               placeholder="nama@email.com">
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            Password
                        </label>
                        <div class="relative">
                            <input id="password"
                                   name="password"
                                   type="password"
                                   autocomplete="current-password"
                                   required
                                   class="form-input pr-12 @error('password') form-input-error @enderror"
                                   placeholder="Masukkan password">
                            <button type="button"
                                    id="togglePassword"
                                    class="password-toggle">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kelas Select -->
                    <div class="form-group">
                        <label for="kelas" class="form-label">
                            Kelas <span class="text-red-500">*</span>
                        </label>
                        <select id="kelas"
                                name="kelas"
                                required
                                class="form-select @error('kelas') form-input-error @enderror">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me"
                               name="remember"
                               type="checkbox"
                               class="login-checkbox">
                        <label for="remember_me" class="ml-2 text-sm text-gray-700 font-medium cursor-pointer">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="btn-primary btn-lg w-full">
                            <span>Masuk</span>
                        </button>
                    </div>

                    <!-- Back to Home Link -->
                    <div class="text-center pt-4">
                        <a href="{{ route('landing') }}" class="login-back-link">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Kembali ke Beranda</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
