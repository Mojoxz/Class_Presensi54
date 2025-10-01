@extends('layouts.landing')

@section('title', 'Berita - SMP 54 Surabaya')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen overflow-hidden">
    <!-- Background Image Layer -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/gedung.jpg') }}"
             alt="Gedung SMP 54 Surabaya"
             class="w-full h-full object-cover"
             onerror="this.style.display='none'; this.parentElement.style.background='linear-gradient(135deg, #9333ea 0%, #f59e0b 100%)';">
        <!-- Dark overlay for better text readability -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/80 via-purple-800/75 to-amber-900/70"></div>
    </div>

    <!-- Floating shapes -->
    <div class="absolute inset-0 z-[1] overflow-hidden pointer-events-none">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
    </div>

    <!-- Content -->
    <div class="container-custom relative z-10 py-20">
        <div class="text-center space-y-8">
            <!-- Badge -->
            <div class="animate-fade-in-down" style="animation-delay: 0.1s;">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/90 backdrop-blur-md rounded-full border border-white/30 shadow-lg">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                    </span>
                    <span class="text-sm font-medium text-gray-700">Berita dan Informasi Terkini</span>
                </span>
            </div>

            <!-- Main Heading -->
            <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 tracking-tight">
                    <span class="block text-white drop-shadow-lg">Berita</span>
                    <span class="block gradient-text-light drop-shadow-lg">SMP 54 Surabaya</span>
                </h1>
                <div class="flex items-center justify-center gap-2 mt-4">
                    <div class="h-1 w-12 bg-gradient-to-r from-white/80 to-transparent rounded-full"></div>
                    <div class="h-1 w-12 bg-gradient-to-r from-amber-400 via-purple-400 to-transparent rounded-full"></div>
                </div>
            </div>

            <!-- Description -->
            <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                <p class="text-xl md:text-2xl text-white/95 max-w-3xl mx-auto leading-relaxed drop-shadow-md">
                    Informasi Terkini dan kegiatan Sekolah<br class="hidden md:block">
                    <span class="font-semibold text-amber-200">SMP 54 Surabaya</span>
                </p>
            </div>

            <!-- Stats -->
            <div class="animate-fade-in-up grid grid-cols-3 gap-4 md:gap-8 max-w-3xl mx-auto pt-8" style="animation-delay: 0.4s;">
                <div class="text-center bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20">
                    <div class="text-xl md:text-3xl font-bold text-amber-300">{{ $berita->total() ?? 0 }}+</div>
                    <div class="text-xs md:text-sm text-white/90 mt-1">Total Berita</div>
                </div>
                <div class="text-center bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20">
                    <div class="text-xl md:text-3xl font-bold text-amber-300">{{ date('Y') }}</div>
                    <div class="text-xs md:text-sm text-white/90 mt-1">Tahun Ini</div>
                </div>
                <div class="text-center bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20">
                    <div class="text-xl md:text-3xl font-bold text-amber-300">24/7</div>
                    <div class="text-xs md:text-sm text-white/90 mt-1">Update Terbaru</div>
                </div>
            </div>
        </div>
    </div>
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>
<!-- Berita Content -->
<section class="py-20 md:py-32 bg-gradient-to-b from-white to-gray-50">
    <div class="container-custom">
        @if($berita->count() > 0)
            <!-- Featured Article -->
            @if($berita->first())
                <div class="mb-20 animate-on-scroll">
                    <div class="text-center mb-12">
                        <span class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-4">Berita Utama</span>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                            Artikel <span class="gradient-text">Terdepan</span>
                        </h2>
                    </div>

                    <article class="news-card group cursor-pointer transform hover:scale-[1.02] transition-all duration-500" onclick="window.location='{{ route('berita.detail', $berita->first()->id) }}'">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                            <div class="news-image-wrapper lg:order-1">
                                @if($berita->first()->gambar)
                                    <img src="{{ asset('storage/' . $berita->first()->gambar) }}" alt="{{ $berita->first()->judul }}" class="news-image !h-80">
                                @else
                                    <div class="news-image-placeholder !h-80">
                                        <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="news-overlay"></div>
                            </div>
                            <div class="news-content lg:order-2 !p-8">
                                <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $berita->first()->created_at->format('d F Y') }}
                                    </div>
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">Featured</span>
                                </div>
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 line-clamp-2">{{ $berita->first()->judul }}</h3>
                                <p class="text-gray-600 mb-6 line-clamp-4 text-lg">{{ $berita->first()->excerpt }}</p>
                                <div class="news-link !text-lg">
                                    <span>Baca Selengkapnya</span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @endif

            <!-- Articles Grid -->
            <div class="mb-16">
                <div class="text-center mb-12 animate-on-scroll">
                    <span class="inline-block px-4 py-2 bg-amber-100 text-amber-700 rounded-full text-sm font-semibold mb-4">Semua Berita</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Artikel <span class="gradient-text">Terbaru</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($berita->skip(1)  as $index => $item)
                        <article class="news-card group animate-on-scroll" style="animation-delay: {{ ($index % 3) * 0.1 }}s;">
                            <div class="news-image-wrapper">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="news-image">
                                @else
                                    <div class="news-image-placeholder">
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="news-overlay"></div>
                            </div>
                            <div class="news-content">
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $item->created_at->format('d F Y') }}
                                </div>
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
            </div>

<div class="flex justify-center animate-on-scroll">
    @if($berita->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-4 flex-wrap">
            {{-- Previous Page Link --}}
            @if ($berita->onFirstPage())
                <span class="inline-flex items-center gap-3 px-6 sm:px-8 py-3 sm:py-4 text-base sm:text-lg text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed font-semibold transition-all duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span class="hidden sm:inline">Sebelumnya</span>
                    <span class="sm:hidden">Prev</span>
                </span>
            @else
                <a href="{{ $berita->previousPageUrl() }}" class="inline-flex items-center gap-3 px-6 sm:px-8 py-3 sm:py-4 text-base sm:text-lg text-purple-700 bg-white border-2 border-purple-200 rounded-xl hover:bg-purple-50 hover:border-purple-400 transition-all duration-300 transform hover:scale-105 hover:shadow-lg font-semibold group">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span class="hidden sm:inline">Sebelumnya</span>
                    <span class="sm:hidden">Prev</span>
                </a>
            @endif

            {{-- Page Numbers - Desktop Only --}}
            <div class="hidden md:flex items-center gap-3">
                @for ($i = 1; $i <= $berita->lastPage(); $i++)
                    @if ($i == $berita->currentPage())
                        <span class="min-w-[52px] px-5 py-4 text-center text-lg text-white font-bold rounded-xl shadow-lg transition-all duration-300" style="background: linear-gradient(135deg, #9333ea 0%, #7c3aed 50%, #f59e0b 100%);">
                            {{ $i }}
                        </span>
                    @elseif ($i == 1 || $i == $berita->lastPage() || ($i >= $berita->currentPage() - 1 && $i <= $berita->currentPage() + 1))
                        <a href="{{ $berita->url($i) }}" class="min-w-[52px] px-5 py-4 text-center text-lg text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-purple-50 hover:border-purple-300 hover:text-purple-700 transition-all duration-300 transform hover:scale-110 hover:shadow-md font-semibold">
                            {{ $i }}
                        </a>
                    @elseif ($i == $berita->currentPage() - 2 || $i == $berita->currentPage() + 2)
                        <span class="px-3 py-2 text-gray-500 font-semibold text-lg">...</span>
                    @endif
                @endfor
            </div>

            {{-- Mobile: Current Page Indicator --}}
            <div class="md:hidden flex items-center gap-2 px-5 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm">
                <span class="text-sm text-gray-600 font-semibold">Hal</span>
                <span class="font-bold text-purple-700 text-base">{{ $berita->currentPage() }}</span>
                <span class="text-sm text-gray-600 font-semibold">/</span>
                <span class="font-bold text-purple-700 text-base">{{ $berita->lastPage() }}</span>
            </div>

            {{-- Next Page Link --}}
            @if ($berita->hasMorePages())
                <a href="{{ $berita->nextPageUrl() }}" class="inline-flex items-center gap-3 px-6 sm:px-8 py-3 sm:py-4 text-base sm:text-lg text-white font-semibold rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105 group" style="background: linear-gradient(135deg, #9333ea 0%, #7c3aed 50%, #f59e0b 100%); box-shadow: 0 4px 12px rgba(147, 51, 234, 0.3);">
                    <span class="hidden sm:inline">Selanjutnya</span>
                    <span class="sm:hidden">Next</span>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <span class="inline-flex items-center gap-3 px-6 sm:px-8 py-3 sm:py-4 text-base sm:text-lg text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed font-semibold transition-all duration-300">
                    <span class="hidden sm:inline">Selanjutnya</span>
                    <span class="sm:hidden">Next</span>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            @endif
        </nav>
    @endif
</div>
            <!-- Empty State -->
            <div class="text-center py-20 animate-on-scroll">
                <div class="max-w-md mx-auto">
                    <div class="feature-icon-wrapper bg-gradient-to-br from-gray-400 to-gray-500 !w-20 !h-20 mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Berita</h3>
                    <p class="text-gray-600 mb-8">Berita dan informasi terkini akan segera tersedia. Silakan kunjungi kembali nanti.</p>
                    <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 via-purple-700 to-amber-500 text-white font-semibold rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

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
                Ingin Tahu Lebih Banyak?
            </h2>
            <p class="text-xl text-purple-100 max-w-2xl mx-auto leading-relaxed">
                Ikuti terus perkembangan SMP 54 Surabaya melalui portal siswa dan media sosial kami
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4">
                <a href="{{ route('student.login') }}" class="group inline-flex items-center gap-2 px-8 py-4 bg-white text-purple-700 font-semibold rounded-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Portal Siswa</span>
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
