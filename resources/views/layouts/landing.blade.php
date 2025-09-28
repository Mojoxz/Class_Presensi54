<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SMP 54 Surabaya')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 to-purple-50">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 shadow-xl backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-bold text-white drop-shadow-sm">SMP 54 Surabaya</h1>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="{{ route('landing') }}" class="text-purple-100 hover:text-white hover:bg-purple-800/50 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">Beranda</a>
                            <a href="{{ route('tentang') }}" class="text-purple-100 hover:text-white hover:bg-purple-800/50 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">Tentang</a>
                            <a href="{{ route('berita.public') }}" class="text-purple-100 hover:text-white hover:bg-purple-800/50 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">Berita</a>
                            <a href="{{ route('kontak') }}" class="text-purple-100 hover:text-white hover:bg-purple-800/50 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">Kontak</a>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="hidden md:flex items-center space-x-3">
                        <a href="{{ route('admin.login') }}" class="bg-gradient-to-r from-purple-800 to-purple-900 hover:from-purple-900 hover:to-purple-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105 shadow-md">Login Admin</a>
                        <a href="{{ route('student.login') }}" class="bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105 shadow-md">Login Siswa</a>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button id="mobile-menu-button" type="button" class="text-white hover:bg-purple-800/50 p-2 rounded-lg transition-all duration-200" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-2 sm:px-3 bg-gradient-to-b from-purple-700 to-purple-800">
                <a href="{{ route('landing') }}" class="text-purple-100 hover:text-white hover:bg-purple-800/50 block px-3 py-2 rounded-lg text-base font-medium transition-all duration-200">Beranda</a>
                <a href="{{ route('tentang') }}" class="text-purple-100 hover:text-white hover:bg-purple-800/50 block px-3 py-2 rounded-lg text-base font-medium transition-all duration-200">Tentang</a>
                <a href="{{ route('berita.public') }}" class="text-purple-100 hover:text-white hover:bg-purple-800/50 block px-3 py-2 rounded-lg text-base font-medium transition-all duration-200">Berita</a>
                <a href="{{ route('kontak') }}" class="text-purple-100 hover:text-white hover:bg-purple-800/50 block px-3 py-2 rounded-lg text-base font-medium transition-all duration-200">Kontak</a>
                <div class="border-t border-purple-600/50 pt-4 pb-3 space-y-2">
                    <a href="{{ route('admin.login') }}" class="bg-gradient-to-r from-purple-800 to-purple-900 hover:from-purple-900 hover:to-purple-800 text-white block px-3 py-2 rounded-lg text-base font-medium transition-all duration-200">Login Admin</a>
                    <a href="{{ route('student.login') }}" class="bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white block px-3 py-2 rounded-lg text-base font-medium transition-all duration-200">Login Siswa</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-900 via-purple-900 to-gray-900 text-white mt-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold mb-4 text-purple-200">SMP 54 Surabaya</h3>
                    <p class="text-gray-300 leading-relaxed">Sekolah menengah pertama yang berkomitmen untuk mencerdaskan generasi bangsa dengan pendidikan berkualitas.</p>
                </div>
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold mb-4 text-purple-200">Kontak</h3>
                    <div class="space-y-2 text-gray-300">
                        <p class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Jl. Contoh No. 123, Surabaya</span>
                        </p>
                        <p class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>Telp: (031) 123-4567</span>
                        </p>
                        <p class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>Email: info@smp54.sch.id</span>
                        </p>
                    </div>
                </div>
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold mb-4 text-purple-200">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('tentang') }}" class="text-gray-300 hover:text-amber-400 transition-colors duration-200 hover:translate-x-1 inline-block">→ Tentang Kami</a></li>
                        <li><a href="{{ route('berita.public') }}" class="text-gray-300 hover:text-amber-400 transition-colors duration-200 hover:translate-x-1 inline-block">→ Berita</a></li>
                        <li><a href="{{ route('kontak') }}" class="text-gray-300 hover:text-amber-400 transition-colors duration-200 hover:translate-x-1 inline-block">→ Kontak</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-purple-800/50 text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} SMP 54 Surabaya. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });

            // Add smooth scroll behavior
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
