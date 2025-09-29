@extends('layouts.landing')

@section('title', $berita->judul . ' - SMP 54 Surabaya')

@section('content')
<!-- Hero Section -->
<section class="hero-section relative min-h-[60vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-50 via-purple-50 to-amber-50">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
    </div>

    <div class="container-custom relative z-10 py-20">
        <div class="max-w-4xl mx-auto text-center space-y-8">
            <!-- Breadcrumb -->
            <div class="animate-fade-in-down" style="animation-delay: 0.1s;">
                <nav class="flex items-center justify-center space-x-2 text-gray-600 mb-6">
                    <a href="{{ route('landing') }}" class="hover:text-purple-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('berita.public') }}" class="hover:text-purple-600 transition-colors">Berita</a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-purple-600">Detail</span>
                </nav>
            </div>

            <!-- Badge -->
            <div class="animate-fade-in-down" style="animation-delay: 0.2s;">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full border border-purple-200 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                    </span>
                    <span class="text-sm font-medium text-gray-700">Berita & Informasi</span>
                </span>
            </div>

            <!-- Title -->
            <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 tracking-tight leading-tight">
                    {{ $berita->judul }}
                </h1>
                <div class="flex items-center justify-center gap-2">
                    <div class="h-1 w-12 bg-gradient-to-r from-purple-600 to-transparent rounded-full"></div>
                    <div class="h-1 w-12 bg-gradient-to-r from-purple-600 via-amber-500 to-transparent rounded-full"></div>
                </div>
            </div>

            <!-- Meta Info -->
            <div class="animate-fade-in-up flex flex-wrap items-center justify-center gap-6 text-gray-600" style="animation-delay: 0.4s;">
                <div class="flex items-center gap-2">
                    <div class="feature-icon-wrapper bg-gradient-to-br from-purple-500 to-purple-600 !w-8 !h-8">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">{{ $berita->created_at->format('d F Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="feature-icon-wrapper bg-gradient-to-br from-amber-500 to-yellow-500 !w-8 !h-8">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">{{ $berita->user->name }}</span>
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

<!-- Content Section -->
<section class="py-20 md:py-32 bg-white relative">
    <div class="container-custom">
        <div class="max-w-4xl mx-auto">
            <article class="animate-on-scroll">
                <!-- Featured Image -->
                @if($berita->gambar)
                    <div class="relative mb-12 group">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl"></div>
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                             class="w-full h-64 md:h-96 object-cover rounded-2xl shadow-2xl transform group-hover:scale-[1.02] transition-transform duration-700">
                    </div>
                @endif

                <!-- Content -->
                <div class="news-card !p-12 !bg-white !shadow-xl !border-0">
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        <div class="text-lg leading-relaxed space-y-6">
                            {!! nl2br(e($berita->konten)) !!}
                        </div>
                    </div>

                    <!-- Meta Footer -->
                    <div class="mt-12 pt-8 border-t border-gray-100">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div class="text-sm text-gray-500 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Dipublikasikan {{ $berita->created_at->format('d F Y, H:i') }}
                            </div>
                            <a href="{{ route('berita.public') }}"
                               class="group inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 via-purple-700 to-amber-500 text-white font-semibold rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105 relative overflow-hidden">
                                <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                                <svg class="w-4 h-4 relative z-10 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                <span class="relative z-10">Kembali ke Berita</span>
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- Related News Section (Optional) -->
<section class="py-20 md:py-32 bg-gradient-to-b from-white to-gray-50">
    <div class="container-custom">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block px-4 py-2 bg-amber-100 text-amber-700 rounded-full text-sm font-semibold mb-4">Berita Lainnya</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Artikel <span class="gradient-text">Terkait</span>
            </h2>
            <p class="text-lg text-gray-600">Baca juga berita menarik lainnya</p>
        </div>

        <div class="text-center">
            <a href="{{ route('berita.public') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                <span>Lihat Semua Berita</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection
