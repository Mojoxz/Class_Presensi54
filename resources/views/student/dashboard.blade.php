@extends('layouts.student')

@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Card -->
<div class="bg-gradient-to-r from-green-400 to-blue-500 rounded-lg shadow-lg p-6 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="text-green-100">Kelas {{ auth()->user()->kelas->nama_kelas ?? '-' }} • NIS: {{ auth()->user()->nis }}</p>
        </div>
        <div class="text-right">
            <div class="text-sm text-green-100">Hari ini</div>
            <div class="text-lg font-semibold" id="current-date"></div>
        </div>
    </div>
</div>

<!-- Presensi Hari Ini -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Presensi Hari Ini</h3>

    @if($presensiHariIni)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-900">Status</p>
                        <p class="text-lg font-semibold text-green-700 capitalize">{{ $presensiHariIni->status }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-blue-900">Jam Masuk</p>
                        <p class="text-lg font-semibold text-blue-700">
                            {{ $presensiHariIni->jam_masuk ? \Carbon\Carbon::parse($presensiHariIni->jam_masuk)->format('H:i') : '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-purple-900">Jam Keluar</p>
                        <p class="text-lg font-semibold text-purple-700">
                            {{ $presensiHariIni->jam_keluar ? \Carbon\Carbon::parse($presensiHariIni->jam_keluar)->format('H:i') : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @if($presensiHariIni->keterangan)
            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800">
                    <span class="font-medium">Keterangan:</span> {{ $presensiHariIni->keterangan }}
                </p>
            </div>
        @endif
    @else
        <div class="text-center py-8">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7l2 2 4-4"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Presensi</h3>
            <p class="text-gray-500 mb-4">Anda belum melakukan presensi hari ini</p>
            <a href="{{ route('student.presensi') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg">
                Presensi Sekarang
            </a>
        </div>
    @endif
</div>

<!-- Statistik Bulan Ini -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Presensi Bulan Ini</h3>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="text-center p-4 bg-blue-50 rounded-lg">
            <div class="text-2xl font-bold text-blue-600">{{ $statistikBulanIni['total'] }}</div>
            <p class="text-sm text-blue-700">Total Hari</p>
        </div>

        <div class="text-center p-4 bg-green-50 rounded-lg">
            <div class="text-2xl font-bold text-green-600">{{ $statistikBulanIni['hadir'] }}</div>
            <p class="text-sm text-green-700">Hadir</p>
        </div>

        <div class="text-center p-4 bg-yellow-50 rounded-lg">
            <div class="text-2xl font-bold text-yellow-600">{{ $statistikBulanIni['izin'] }}</div>
            <p class="text-sm text-yellow-700">Izin</p>
        </div>

        <div class="text-center p-4 bg-red-50 rounded-lg">
            <div class="text-2xl font-bold text-red-600">{{ $statistikBulanIni['tidak_hadir'] }}</div>
            <p class="text-sm text-red-700">Tidak Hadir</p>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="mt-6">
        <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span>Tingkat Kehadiran</span>
            <span>{{ $statistikBulanIni['total'] > 0 ? round(($statistikBulanIni['hadir'] / $statistikBulanIni['total']) * 100, 1) : 0 }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-green-600 h-3 rounded-full transition-all duration-300"
                 style="width: {{ $statistikBulanIni['total'] > 0 ? ($statistikBulanIni['hadir'] / $statistikBulanIni['total']) * 100 : 0 }}%">
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Presensi 7 Hari Terakhir -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Presensi 7 Hari Terakhir</h3>

    @if($presensi7Hari->count() > 0)
        <div class="space-y-3">
            @foreach($presensi7Hari as $presensi)
                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3
                                    {{ $presensi->status === 'hadir' ? 'bg-green-100 text-green-600' :
                                       ($presensi->status === 'izin' ? 'bg-yellow-100 text-yellow-600' :
                                        ($presensi->status === 'sakit' ? 'bg-blue-100 text-blue-600' : 'bg-red-100 text-red-600')) }}">
                            @if($presensi->status === 'hadir')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($presensi->tanggal)->format('l, d M Y') }}
                            </p>
                            <p class="text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', $presensi->status) }}</p>
                        </div>
                    </div>
                    <div class="text-right text-sm text-gray-600">
                        @if($presensi->jam_masuk)
                            <div>Masuk: {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') }}</div>
                        @endif
                        @if($presensi->jam_keluar)
                            <div>Keluar: {{ \Carbon\Carbon::parse($presensi->jam_keluar)->format('H:i') }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <p class="text-gray-500">Belum ada riwayat presensi</p>
        </div>
    @endif
</div>

<script>
    function updateCurrentDate() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', options);
    }

    updateCurrentDate();
</script>
@endsection
