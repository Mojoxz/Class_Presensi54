<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SMP 54 Surabaya')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-bold text-white">SMP 54 Surabaya</h1>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="{{ route('landing') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Beranda</a>
                            <a href="{{ route('tentang') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Tentang</a>
                            <a href="{{ route('berita.public') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Berita</a>
                            <a href="{{ route('kontak') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Kontak</a>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('admin.login') }}" class="bg-blue-800 hover:bg-blue-900 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">Login Admin</a>
                        <a href="{{ route('student.login') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">Login Siswa</a>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button id="mobile-menu-button" type="button" class="text-white hover:bg-blue-700 p-2 rounded-md" aria-controls="mobile-menu" aria-expanded="false">
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
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-blue-700">
                <a href="{{ route('landing') }}" class="text-white hover:bg-blue-800 block px-3 py-2 rounded-md text-base font-medium">Beranda</a>
                <a href="{{ route('tentang') }}" class="text-white hover:bg-blue-800 block px-3 py-2 rounded-md text-base font-medium">Tentang</a>
                <a href="{{ route('berita.public') }}" class="text-white hover:bg-blue-800 block px-3 py-2 rounded-md text-base font-medium">Berita</a>
                <a href="{{ route('kontak') }}" class="text-white hover:bg-blue-800 block px-3 py-2 rounded-md text-base font-medium">Kontak</a>
                <div class="border-t border-blue-600 pt-4 pb-3">
                    <a href="{{ route('admin.login') }}" class="bg-blue-800 hover:bg-blue-900 text-white block px-3 py-2 rounded-md text-base font-medium mb-2">Login Admin</a>
                    <a href="{{ route('student.login') }}" class="bg-green-600 hover:bg-green-700 text-white block px-3 py-2 rounded-md text-base font-medium">Login Siswa</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">SMP 54 Surabaya</h3>
                    <p class="text-gray-300">Sekolah menengah pertama yang berkomitmen untuk mencerdaskan generasi bangsa.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Kontak</h3>
                    <p class="text-gray-300">Jl. Contoh No. 123, Surabaya</p>
                    <p class="text-gray-300">Telp: (031) 123-4567</p>
                    <p class="text-gray-300">Email: info@smp54.sch.id</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('tentang') }}" class="text-gray-300 hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('berita.public') }}" class="text-gray-300 hover:text-white transition-colors">Berita</a></li>
                        <li><a href="{{ route('kontak') }}" class="text-gray-300 hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center">
                <p class="text-gray-300">&copy; {{ date('Y') }} SMP 54 Surabaya. All rights reserved.</p>
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
        });
    </script>
</body>
</html>
