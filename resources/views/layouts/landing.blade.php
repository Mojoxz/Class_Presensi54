<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('logo_header.png') }}">
    <title>@yield('title', 'SMP 54 Surabaya')</title>
    @vite(['resources/css/app.css', 'resources/css/landing.css', 'resources/js/app.js', 'resources/js/landing.js'])
</head>
<body class="bg-white antialiased">
    <!-- Modern Navigation -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-12">
            <div class="flex items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mr-8">
                    <div class="flex items-center">
                       <img src="{{ asset('logo.png') }}" alt="Logo" class="h-12">
                    </div>
                    <div class="hidden md:block">
                        <div class="text-lg font-bold text-gray-900">SMP 54 Surabaya</div>
                        <div class="text-xs text-gray-500">Sistem Presensi Digital</div>
                    </div>
                </div>

                <!-- Desktop Navigation - Moved to Left -->
                <div class="hidden lg:flex items-center space-x-2 flex-1 justify-end ">
                    <a href="{{ route('landing') }}" class="nav-link  {{ request()->routeIs('landing') ? 'nav-link-active' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('tentang') }}" class="nav-link {{ request()->routeIs('tentang') ? 'nav-link-active' : '' }}">
                        Tentang
                    </a>
                    <a href="{{ route('berita.public') }}" class="nav-link {{ request()->routeIs('berita.*') ? 'nav-link-active' : '' }}">
                        Berita
                    </a>
                    <a href="{{ route('kontak') }}" class="nav-link {{ request()->routeIs('kontak') ? 'nav-link-active' : '' }}">
                        Kontak
                    </a>
                </div>

                <!-- CTA Buttons - Now on the Right -->
                <div class="hidden lg:flex items-center space-x-3 ml-auto">
                    <a href="{{ route('student.login') }}" class="btn-gradient">
                        <span>Portal Siswa</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors ml-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="fixed inset-0 z-40 lg:hidden hidden">
        <div class="mobile-menu-backdrop" id="mobile-backdrop"></div>
        <div class="mobile-menu-panel">
            <div class="p-6 space-y-6">
                <!-- Mobile Logo -->
                <div class="flex items-center space-x-3 pb-6 border-b border-gray-200">
                    <div class="logo-circle">
                        <span class="text-xl font-bold gradient-text">54</span>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-gray-900">SMP 54 Surabaya</div>
                        <div class="text-xs text-gray-500">Sistem Presensi Digital</div>
                    </div>
                </div>

                <!-- Mobile Navigation Links -->
                <div class="space-y-2">
                    <a href="{{ route('landing') }}" class="mobile-nav-link">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Beranda</span>
                    </a>
                    <a href="{{ route('tentang') }}" class="mobile-nav-link">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Tentang</span>
                    </a>
                    <a href="{{ route('berita.public') }}" class="mobile-nav-link">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <span>Berita</span>
                    </a>
                    <a href="{{ route('kontak') }}" class="mobile-nav-link">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>Kontak</span>
                    </a>
                </div>

                <!-- Mobile CTA Buttons -->
                <div class="space-y-3 pt-6 border-t border-gray-200">
                    <!-- <a href="{{ route('admin.login') }}" class="mobile-btn-secondary">
                        Login Admin
                    </a> -->
                    <a href="{{ route('student.login') }}" class="mobile-btn-primary">
                        Portal Siswa
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Modern Footer -->
    <footer class="bg-gray-900 text-gray-300 relative overflow-hidden">
        <div class="footer-pattern"></div>

        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-12 relative z-10">
            <!-- Main Footer Content -->
            <div class="py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- About Column -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3 mb-6">
                        <img src="{{ asset('logo_header.png') }}" alt="Logo SMP 54" class="h-12">
                        <div>
                            <div class="text-lg font-bold text-white">SMP 54 Surabaya</div>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-400">
                        Sekolah menengah pertama yang berkomitmen untuk mencerdaskan generasi bangsa dengan pendidikan berkualitas.
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="social-icon">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-icon">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-icon">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-semibold mb-6">Menu Cepat</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('tentang') }}" class="footer-link">Tentang Kami</a></li>
                        <li><a href="{{ route('berita.public') }}" class="footer-link">Berita</a></li>
                        <li><a href="{{ route('kontak') }}" class="footer-link">Kontak</a></li>
                    </ul>
                </div>

                <!-- Portal -->
                <div>
                    <h3 class="text-white font-semibold mb-6">Portal</h3>
                    <ul class="space-y-3">
                        <!-- <li><a href="{{ route('admin.login') }}" class="footer-link">Login Admin</a></li> -->
                        <li><a href="{{ route('student.login') }}" class="footer-link">Login Siswa</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-white font-semibold mb-6">Kontak Kami</h3>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <a href="https://maps.google.com/?q=Jl.+Kyai+Tambak+Deres+No.293,+Bulak,+Kec.+Bulak,+Surabaya,+Jawa+Timur+60124" target="_blank" rel="noopener noreferrer" class="footer-link">
                                Jl. Kyai Tambak Deres No.293<br>Bulak, Kec. Bulak, Surabaya<br>Jawa Timur 60124
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-purple-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <a href="tel:+6231123456" class="footer-link">(031) 123-4567</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-purple-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:info@smp54.sch.id" class="footer-link">info@smp54.sch.id</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-gray-800 py-8 text-center">
                <p class="text-sm text-gray-400">
                    &copy; {{ date('Y') }} SMP 54 Surabaya. All rights reserved. Made with
                    <span class="text-red-500">❤</span> for education
                </p>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scroll-to-top" class="scroll-to-top hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>
</body>
</html>
