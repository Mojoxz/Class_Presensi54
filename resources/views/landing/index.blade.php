@extends('layouts.landing')

@section('title', 'Beranda - SMP 54 Surabaya')

@section('content')
<!-- Hero Section -->
<section class="bg-blue-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">
                SMP 54 Surabaya
            </h1>
            <p class="text-xl md:text-2xl mb-8">
                Mencerdaskan Generasi Bangsa dengan Pendidikan Berkualitas
            </p>
            <div class="space-x-4">
                <a href="{{ route('tentang') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold transition-colors">
                    Tentang Kami
                </a>
                <a href="{{ route('student.login') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    Portal Siswa
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Sistem presensi digital yang memudahkan siswa dan guru dalam monitoring kehadiran
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 bg-gray-50 rounded-lg hover:shadow-lg transition-shadow">
                <div class="bg-blue-500 text-white p-3 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Presensi Digital</h3>
                <p class="text-gray-600">Sistem presensi online yang mudah digunakan dan real-time</p>
            </div>

            <div class="text-center p-6 bg-gray-50 rounded-lg hover:shadow-lg transition-shadow">
                <div class="bg-green-500 text-white p-3 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Statistik Lengkap</h3>
                <p class="text-gray-600">Laporan dan analisis kehadiran yang detail dan akurat</p>
            </div>

            <div class="text-center p-6 bg-gray-50 rounded-lg hover:shadow-lg transition-shadow">
                <div class="bg-purple-500 text-white p-3 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Manajemen Siswa</h3>
                <p class="text-gray-600">Pengelolaan data siswa dan kelas yang terintegrasi</p>
            </div>
        </div>
    </div>
</section>

<!-- News Section -->
@if($berita->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Berita Terbaru</h2>
            <p class="text-gray-600">Informasi terkini dari SMP 54 Surabaya</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($berita as $item)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">{{ $item->judul }}</h3>
                    <p class="text-gray-600 mb-4">{{ $item->excerpt }}</p>
                    <a href="{{ route('berita.detail', $item->id) }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                        Baca Selengkapnya →
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('berita.public') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                Lihat Semua Berita
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-16 bg-blue-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Siap Bergabung dengan Kami?</h2>
        <p class="text-xl mb-8">Mulai gunakan sistem presensi digital SMP 54 Surabaya</p>
        <div class="space-x-4">
            <a href="{{ route('student.login') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold transition-colors">
                Login Siswa
            </a>
            <a href="{{ route('kontak') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection
