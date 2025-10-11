@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl shadow-lg p-6 mb-8 text-white">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-20 h-12">
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-purple-100 text-sm">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
            </div>
        </div>
        <div class="text-right">
            <p class="text-sm text-purple-100">Sistem Informasi</p>
            <p class="text-lg font-semibold">SMP 54 Surabaya</p>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Siswa -->
    <div class="admin-card bg-gradient-to-br from-blue-500 to-blue-600 text-white hover:shadow-xl transition-all duration-300">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <p class="text-blue-100 text-sm font-medium mb-2">Total Siswa</p>
                <h3 class="text-4xl font-bold mb-1">{{ $totalSiswa }}</h3>
                <p class="text-blue-100 text-xs">Siswa terdaftar</p>
            </div>
            <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Kelas -->
    <div class="admin-card bg-gradient-to-br from-green-500 to-green-600 text-white hover:shadow-xl transition-all duration-300">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <p class="text-green-100 text-sm font-medium mb-2">Total Kelas</p>
                <h3 class="text-4xl font-bold mb-1">{{ $totalKelas }}</h3>
                <p class="text-green-100 text-xs">Kelas aktif</p>
            </div>
            <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Hadir Hari Ini -->
    <div class="admin-card bg-gradient-to-br from-amber-500 to-amber-600 text-white hover:shadow-xl transition-all duration-300">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <p class="text-amber-100 text-sm font-medium mb-2">Hadir Hari Ini</p>
                <h3 class="text-4xl font-bold mb-1">{{ $presensiHariIni }}</h3>
                <p class="text-amber-100 text-xs">Siswa hadir</p>
            </div>
            <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Berita -->
    <div class="admin-card bg-gradient-to-br from-purple-500 to-purple-600 text-white hover:shadow-xl transition-all duration-300">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <p class="text-purple-100 text-sm font-medium mb-2">Total Berita</p>
                <h3 class="text-4xl font-bold mb-1">{{ $totalBerita }}</h3>
                <p class="text-purple-100 text-xs">Berita dipublikasi</p>
            </div>
            <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM8 14H6v-2h2v2zm0-3H6V9h2v2zm0-3H6V6h2v2zm7 6h-5v-2h5v2zm3-3h-8V9h8v2zm0-3h-8V6h8v2z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Tables -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Presensi Minggu Ini -->
    <div class="admin-card">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Presensi Minggu Ini</h3>
            </div>
            <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">7 Hari Terakhir</span>
        </div>

        <div class="space-y-3">
            @forelse($presensiMingguIni as $item)
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-200 hover:border-blue-300 transition-colors duration-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-600 font-bold text-sm">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d') }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd') }}</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold bg-gradient-to-r from-green-500 to-green-600 text-white shadow-sm">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                            {{ $item->total }} siswa
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm font-medium">Belum ada data presensi</p>
                    <p class="text-gray-400 text-xs mt-1">Data akan muncul setelah ada presensi</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Presensi Per Kelas Hari Ini -->
    <div class="admin-card">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Presensi Per Kelas</h3>
            </div>
            <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Hari Ini</span>
        </div>

        <div class="space-y-4">
            @forelse($presensiPerKelas as $item)
                <div class="p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-200 hover:border-purple-300 transition-colors duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-purple-600 font-bold text-xs">
                                    {{ substr($item['nama_kelas'], 0, 2) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-gray-900">{{ $item['nama_kelas'] }}</span>
                                <span class="text-xs text-gray-500 block">{{ $item['total_siswa'] }} siswa total</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-bold text-gray-900">{{ $item['total_siswa'] > 0 ? round(($item['hadir'] / $item['total_siswa']) * 100) : 0 }}%</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 text-xs mb-3">
                        <div class="flex items-center gap-1.5">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-gray-600">Hadir: <span class="font-semibold text-green-600">{{ $item['hadir'] }}</span></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                            <span class="text-gray-600">Tidak: <span class="font-semibold text-red-600">{{ $item['tidak_hadir'] }}</span></span>
                        </div>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $item['total_siswa'] > 0 ? ($item['hadir'] / $item['total_siswa']) * 100 : 0 }}%"></div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm font-medium">Belum ada data presensi</p>
                    <p class="text-gray-400 text-xs mt-1">Data akan muncul setelah ada presensi</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="admin-card">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900">Quick Actions</h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Tambah Siswa -->
        <a href="{{ route('admin.murid.create') }}" class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl p-5 border-2 border-blue-200 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-blue-900 mb-1">Tambah Siswa</p>
                    <p class="text-xs text-blue-600">Daftarkan siswa baru</p>
                </div>
                <svg class="w-5 h-5 text-blue-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Buat Berita -->
        <a href="{{ route('admin.berita.create') }}" class="group relative overflow-hidden bg-gradient-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-xl p-5 border-2 border-green-200 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-green-900 mb-1">Buat Berita</p>
                    <p class="text-xs text-green-600">Publikasi berita baru</p>
                </div>
                <svg class="w-5 h-5 text-green-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Lihat Rekap -->
        <a href="{{ route('admin.presensi.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-xl p-5 border-2 border-purple-200 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-purple-900 mb-1">Lihat Rekap</p>
                    <p class="text-xs text-purple-600">Laporan presensi</p>
                </div>
                <svg class="w-5 h-5 text-purple-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>
    </div>
</div>
@endsection
