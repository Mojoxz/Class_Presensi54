@extends('layouts.landing')

@section('title', 'Beranda - SMP 54 Surabaya')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center space-y-8">
            <h1 class="text-5xl md:text-7xl font-bold mb-6">
                <span class="text-white drop-shadow-lg">
                    SMP 54 Surabaya
                </span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-purple-100 max-w-3xl mx-auto leading-relaxed">
                Mencerdaskan Generasi Bangsa dengan Pendidikan Berkualitas dan Teknologi Modern
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('tentang') }}" class="bg-white/20 text-white hover:bg-white hover:text-purple-700 px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105 border border-white/30">
                    <span class="flex items-center space-x-2">
                        <span>Tentang Kami</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                </a>
                <a href="{{ route('student.login') }}" class="bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                    <span class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Portal Siswa</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-6">
                <span class="bg-gradient-to-r from-purple-600 to-amber-500 bg-clip-text text-transparent">
                    Fitur Unggulan
                </span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Sistem presensi digital yang memudahkan siswa dan guru dalam monitoring kehadiran dengan teknologi terdepan
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-purple-100">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-4 rounded-2xl w-16 h-16 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-center text-gray-800">Presensi Digital</h3>
                <p class="text-gray-600 text-center leading-relaxed">Sistem presensi online yang mudah digunakan dan real-time dengan akurasi tinggi</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-purple-100">
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 text-white p-4 rounded-2xl w-16 h-16 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-center text-gray-800">Statistik Lengkap</h3>
                <p class="text-gray-600 text-center leading-relaxed">Laporan dan analisis kehadiran yang detail dan akurat untuk evaluasi berkala</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-purple-100">
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white p-4 rounded-2xl w-16 h-16 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-center text-gray-800">Manajemen Siswa</h3>
                <p class="text-gray-600 text-center leading-relaxed">Pengelolaan data siswa dan kelas yang terintegrasi dengan sistem terpusat</p>
            </div>
        </div>
    </div>
</section>

<!-- News Section -->
@if($berita->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-6">
                <span class="bg-gradient-to-r from-purple-600 to-amber-500 bg-clip-text text-transparent">
                    Berita Terbaru
                </span>
            </h2>
            <p class="text-lg text-gray-600">Informasi terkini dari SMP 54 Surabaya</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($berita as $item)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-purple-100">
                @if($item->gambar)
                    <div class="overflow-hidden">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-56 object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                @else
                    <div class="w-full h-56 bg-gradient-to-br from-purple-100 to-amber-50 flex items-center justify-center">
                        <svg class="w-16 h-16 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                <div class="p-6 space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800 hover:text-purple-700 transition-colors duration-300">{{ $item->judul }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $item->excerpt }}</p>
                    <a href="{{ route('berita.detail', $item->id) }}" class="inline-flex items-center space-x-2 text-purple-600 hover:text-amber-600 font-medium transition-colors duration-300">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('berita.public') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
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
<section class="py-20 bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-800 text-white relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-1/3 left-1/3 w-72 h-72 bg-amber-400/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/3 right-1/3 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>
        </div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
        <h2 class="text-4xl font-bold mb-6">
            <span class="bg-gradient-to-r from-white to-amber-200 bg-clip-text text-transparent">
                Siap Bergabung dengan Kami?
            </span>
        </h2>
        <p class="text-xl mb-8 text-purple-100 max-w-2xl mx-auto leading-relaxed">
            Mulai gunakan sistem presensi digital SMP 54 Surabaya dan rasakan kemudahan teknologi modern
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('student.login') }}" class="group bg-white/10 backdrop-blur-sm text-white hover:bg-white hover:text-purple-700 px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105 border border-white/20 shadow-lg">
                <span class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Login Siswa</span>
                </span>
            </a>
            <a href="{{ route('kontak') }}" class="group bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                <span class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>Hubungi Kami</span>
                </span>
            </a>
        </div>
    </div>
</section>
@endsection
