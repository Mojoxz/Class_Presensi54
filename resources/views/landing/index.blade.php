@extends('layouts.landing')

@section('title', 'Beranda - SMP 54 Surabaya')

@section('content')
<!-- Hero Section -->
<section class="hero-section relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-50 via-purple-50 to-amber-50">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
    </div>

    <div class="container-custom relative z-10 py-20">
        <div class="text-center space-y-8">
            <!-- Badge -->
            <div class="animate-fade-in-down" style="animation-delay: 0.1s;">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full border border-purple-200 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                    </span>
                    <span class="text-sm font-medium text-gray-700">Sistem Presensi Digital Terpadu</span>
                </span>
            </div>

            <!-- Main Heading -->
            <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                <h1 class="text-5xl md:text-7xl font-bold text-gray-900 mb-4 tracking-tight">
                    <span class="block">SMP 54</span>
                    <span class="block gradient-text">Surabaya</span>
                </h1>
                <div class="flex items-center justify-center gap-2 mt-4">
                    <div class="h-1 w-12 bg-gradient-to-r from-purple-600 to-transparent rounded-full"></div>
                    <div class="h-1 w-12 bg-gradient-to-r from-purple-600 via-amber-500 to-transparent rounded-full"></div>
                </div>
            </div>

            <!-- Description -->
            <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Mencerdaskan Generasi Bangsa dengan<br class="hidden md:block">
                    <span class="font-semibold text-gray-800">Pendidikan Berkualitas</span> dan
                    <span class="font-semibold text-gray-800">Teknologi Modern</span>
                </p>
            </div>

            <!-- CTA Buttons -->
            <div class="animate-fade-in-up flex flex-col sm:flex-row gap-4 justify-center items-center pt-4" style="animation-delay: 0.4s;">
                <a href="{{ route('tentang') }}" class="group inline-flex items-center gap-2 px-8 py-4 border-2 border-gray-900 text-gray-900 font-semibold rounded-xl hover:bg-gray-900 hover:text-white transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    <span>Tentang Kami</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ route('student.login') }}" class="group inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-purple-600 via-purple-700 to-amber-500 text-white font-semibold rounded-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="relative z-10">Portal Siswa</span>
                </a>
            </div>

            <!-- Stats -->
            <div class="animate-fade-in-up grid grid-cols-3 gap-8 max-w-2xl mx-auto pt-12" style="animation-delay: 0.5s;">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold gradient-text">1000+</div>
                    <div class="text-sm text-gray-600 mt-1">Siswa Aktif</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold gradient-text">50+</div>
                    <div class="text-sm text-gray-600 mt-1">Tenaga Pengajar</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold gradient-text">20+</div>
                    <div class="text-sm text-gray-600 mt-1">Tahun Berdiri</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 md:py-32 bg-white relative">
    <div class="container-custom">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-4">Fitur Unggulan</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Teknologi <span class="gradient-text">Terdepan</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Sistem presensi digital yang memudahkan monitoring kehadiran dengan akurasi tinggi
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="feature-card group animate-on-scroll" style="animation-delay: 0.1s;">
                <div class="relative">
                    <div class="feature-icon-wrapper bg-gradient-to-br from-purple-500 to-purple-600">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7l2 2 4-4"></path>
                        </svg>
                    </div>
                    <div class="feature-number">01</div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Presensi Digital</h3>
                <p class="text-gray-600 leading-relaxed">Sistem presensi online yang mudah digunakan dengan teknologi real-time dan akurasi tinggi</p>
            </div>

            <!-- Feature 2 -->
            <div class="feature-card group animate-on-scroll" style="animation-delay: 0.2s;">
                <div class="relative">
                    <div class="feature-icon-wrapper bg-gradient-to-br from-amber-500 to-yellow-500">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="feature-number">02</div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Statistik Lengkap</h3>
                <p class="text-gray-600 leading-relaxed">Laporan dan analisis kehadiran yang detail dengan visualisasi data yang mudah dipahami</p>
            </div>

            <!-- Feature 3 -->
            <div class="feature-card group animate-on-scroll" style="animation-delay: 0.3s;">
                <div class="relative">
                    <div class="feature-icon-wrapper bg-gradient-to-br from-purple-600 to-indigo-600">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div class="feature-number">03</div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen Siswa</h3>
                <p class="text-gray-600 leading-relaxed">Pengelolaan data siswa dan kelas yang terintegrasi dalam satu sistem terpusat</p>
            </div>
        </div>
    </div>
</section>

<!-- News Section -->
@if($berita->count() > 0)
<section class="py-20 md:py-32 bg-gradient-to-b from-white to-gray-50">
    <div class="container-custom">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block px-4 py-2 bg-amber-100 text-amber-700 rounded-full text-sm font-semibold mb-4">Berita & Informasi</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Berita <span class="gradient-text">Terbaru</span>
            </h2>
            <p class="text-lg text-gray-600">Informasi terkini dari SMP 54 Surabaya</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($berita as $index => $item)
            <article class="news-card group animate-on-scroll" style="animation-delay: {{ $index * 0.1 }}s;">
                <div class="news-image-wrapper">
                    @if($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="news-image">
                    @else
                        <div class="news-image-placeholder">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif>
                    <div class="news-overlay"></div>
                </div>
                <div class="news-content">
                    <h3 class="news-title">{{ $item->judul }}</h3>
                    <p class="news-excerpt">{{ $item->excerpt }}</p>
                    <a href="{{ route('berita.detail', $item->id) }}" class="news-link">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <div class="text-center mt-12 animate-on-scroll">
            <a href="{{ route('berita.public') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                <span>Lihat Semua Berita</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-20 md:py-32 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-purple-700 to-amber-600"></div>
    <div class="absolute inset-0">
        <div class="cta-shape cta-shape-1"></div>
        <div class="cta-shape cta-shape-2"></div>
    </div>

    <div class="container-custom relative z-10">
        <div class="text-center text-white space-y-8 animate-on-scroll">
            <h2 class="text-4xl md:text-5xl font-bold">
                Siap Bergabung dengan Kami?
            </h2>
            <p class="text-xl text-purple-100 max-w-2xl mx-auto leading-relaxed">
                Mulai gunakan sistem presensi digital SMP 54 Surabaya dan rasakan kemudahan teknologi modern
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4">
                <a href="{{ route('student.login') }}" class="group inline-flex items-center gap-2 px-8 py-4 bg-white text-purple-700 font-semibold rounded-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Login Siswa</span>
                </a>
                <a href="{{ route('kontak') }}" class="group inline-flex items-center gap-2 px-8 py-4 border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-purple-700 transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>Hubungi Kami</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
