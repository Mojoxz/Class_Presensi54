@extends('layouts.student')

@section('page-title', 'Presensi')

@section('content')
<!-- Current Time Card -->
<div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-lg p-6 mb-8 text-white">
    <div class="text-center">
        <h2 class="text-2xl font-bold mb-2">Presensi Siswa</h2>
        <p class="text-blue-100 mb-4">{{ auth()->user()->name }} - Kelas {{ auth()->user()->kelas->nama_kelas ?? '-' }}</p>
        <div class="text-4xl font-bold mb-2" id="current-time"></div>
        <div class="text-lg" id="current-date"></div>
    </div>
</div>

<!-- Presensi Actions -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Presensi Hari Ini</h3>

    @if($presensiHariIni)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Status Presensi -->
            <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    <h4 class="text-lg font-semibold text-green-900 mb-2">Presensi Tercatat</h4>
                    <p class="text-green-700 mb-4">Status: <span class="font-semibold capitalize">{{ $presensiHariIni->status }}</span></p>

                    <div class="space-y-2">
                        @if($presensiHariIni->jam_masuk)
                            <p class="text-sm text-green-600">
                                <span class="font-medium">Jam Masuk:</span> {{ \Carbon\Carbon::parse($presensiHariIni->jam_masuk)->format('H:i:s') }}
                            </p>
                        @endif

                        @if($presensiHariIni->jam_keluar)
                            <p class="text-sm text-green-600">
                                <span class="font-medium">Jam Keluar:</span> {{ \Carbon\Carbon::parse($presensiHariIni->jam_keluar)->format('H:i:s') }}
                            </p>
                        @else
                            <form method="POST" action="{{ route('student.presensi.keluar') }}" class="mt-4">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-medium transition duration-150">
                                    Presensi Keluar
                                </button>
                            </form>
                        @endif

                        @if($presensiHariIni->keterangan)
                            <p class="text-sm text-yellow-600 mt-2">
                                <span class="font-medium">Keterangan:</span> {{ $presensiHariIni->keterangan }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Info Tambahan -->
            <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                <h4 class="text-lg font-semibold text-blue-900 mb-4">Informasi</h4>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-blue-700 text-sm">Batas waktu presensi: 08:00</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-blue-700 text-sm">Presensi hanya bisa dilakukan sekali sehari</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-blue-700 text-sm">Hubungi admin jika ada masalah</span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-8">
            <div class="mb-6">
                <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7l2 2 4-4"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Presensi</h3>
                <p class="text-gray-600 mb-6">Silakan lakukan presensi masuk untuk hari ini</p>
            </div>

            <form method="POST" action="{{ route('student.presensi.masuk') }}">
                @csrf
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg font-semibold text-lg transition duration-150 shadow-lg">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7l2 2 4-4"></path>
                    </svg>
                    Presensi Masuk
                </button>
            </form>

            <p class="text-gray-500 text-sm mt-4">
                Pastikan Anda berada di lingkungan sekolah saat melakukan presensi
            </p>
        </div>
    @endif
</div>

<!-- Riwayat Presensi -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Presensi Bulan Ini</h3>

    @if($presensiRiwayat->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jam Masuk
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jam Keluar
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Keterangan
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($presensiRiwayat as $presensi)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($presensi->tanggal)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $presensi->status === 'hadir' ? 'bg-green-100 text-green-800' :
                                       ($presensi->status === 'izin' ? 'bg-yellow-100 text-yellow-800' :
                                        ($presensi->status === 'sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $presensi->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $presensi->jam_masuk ? \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $presensi->jam_keluar ? \Carbon\Carbon::parse($presensi->jam_keluar)->format('H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $presensi->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <p class="text-gray-500">Belum ada riwayat presensi bulan ini</p>
        </div>
    @endif
</div>

<script>
    function updateDateTime() {
        const now = new Date();
        const timeOptions = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        const dateOptions = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };

        document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', timeOptions);
        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>
@endsection
