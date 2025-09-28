@extends('layouts.student')

@section('page-title', 'Home')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-green-400 to-blue-500 rounded-lg shadow-lg p-6 mb-8 text-white">
    <div class="text-center">
        <h2 class="text-3xl font-bold mb-2">Selamat Datang di Portal Siswa</h2>
        <p class="text-green-100 text-lg">SMP 54 Surabaya</p>
        <p class="text-green-200 mt-2">{{ auth()->user()->name }} - Kelas {{ auth()->user()->kelas->nama_kelas ?? '-' }}</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('student.presensi') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center">
            <div class="bg-blue-500 rounded-full p-3 mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7l2 2 4-4"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Presensi</h3>
                <p class="text-gray-600 text-sm">Lakukan presensi harian</p>
            </div>
        </div>
    </a>

    <a href="{{ route('student.dashboard') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center">
            <div class="bg-green-500 rounded-full p-3 mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Statistik</h3>
                <p class="text-gray-600 text-sm">Lihat rekap presensi</p>
            </div>
        </div>
    </a>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="bg-purple-500 rounded-full p-3 mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Waktu Saat Ini</h3>
                <p class="text-gray-600 text-sm" id="current-time-home"></p>
            </div>
        </div>
    </div>
</div>

<!-- Berita Terbaru -->
@if($berita->count() > 0)
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-semibold text-gray-900">Berita Terbaru</h3>
        <a href="{{ route('berita.public') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
            Lihat Semua →
        </a>
    </div>

    <div class="space-y-6">
        @foreach($berita as $item)
            <div class="flex space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}"
                         class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                @else
                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex-shrink-0 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif

                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $item->judul }}</h4>
                    <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $item->excerpt }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">{{ $item->created_at->format('d F Y') }}</span>
                        <a href="{{ route('berita.detail', $item->id) }}"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@else
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="text-center py-8">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada berita</h3>
        <p class="text-gray-500">Berita terbaru akan muncul di sini</p>
    </div>
</div>
@endif

<script>
    function updateCurrentTimeHome() {
        const now = new Date();
        const options = {
            weekday: 'long',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById('current-time-home').textContent = now.toLocaleDateString('id-ID', options);
    }

    setInterval(updateCurrentTimeHome, 1000);
    updateCurrentTimeHome();
</script>
@endsection
