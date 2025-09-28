@extends('layouts.admin')

@section('page-title', 'Detail Murid')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Detail Murid</h2>
    <div class="space-x-2">
        <a href="{{ route('admin.murid.edit', $murid->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
            Edit
        </a>
        <a href="{{ route('admin.murid.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Kembali
        </a>
    </div>
</div>

<!-- Info Murid -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Murid</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-500">NIS</label>
            <p class="text-lg font-semibold text-gray-900">{{ $murid->nis }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
            <p class="text-lg font-semibold text-gray-900">{{ $murid->name }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500">Email</label>
            <p class="text-lg font-semibold text-gray-900">{{ $murid->email }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500">Kelas</label>
            <p class="text-lg font-semibold text-blue-600">{{ $murid->kelas->nama_kelas ?? '-' }}</p>
        </div>
    </div>
</div>

<!-- Statistik Presensi -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Presensi Bulan Ini</h3>
    @php
        $statistik = \App\Models\Presensi::getStatistik($murid->id, date('n'), date('Y'));
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="text-center p-4 bg-blue-50 rounded-lg">
            <div class="text-2xl font-bold text-blue-600">{{ $statistik['total'] }}</div>
            <p class="text-sm text-blue-700">Total Hari</p>
        </div>
        <div class="text-center p-4 bg-green-50 rounded-lg">
            <div class="text-2xl font-bold text-green-600">{{ $statistik['hadir'] }}</div>
            <p class="text-sm text-green-700">Hadir</p>
        </div>
        <div class="text-center p-4 bg-red-50 rounded-lg">
            <div class="text-2xl font-bold text-red-600">{{ $statistik['tidak_hadir'] }}</div>
            <p class="text-sm text-red-700">Tidak Hadir</p>
        </div>
        <div class="text-center p-4 bg-yellow-50 rounded-lg">
            <div class="text-2xl font-bold text-yellow-600">{{ $statistik['izin'] }}</div>
            <p class="text-sm text-yellow-700">Izin</p>
        </div>
        <div class="text-center p-4 bg-purple-50 rounded-lg">
            <div class="text-2xl font-bold text-purple-600">{{ $statistik['sakit'] }}</div>
            <p class="text-sm text-purple-700">Sakit</p>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="mt-6">
        <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span>Tingkat Kehadiran</span>
            <span>{{ $statistik['total'] > 0 ? round(($statistik['hadir'] / $statistik['total']) * 100, 1) : 0 }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-green-600 h-3 rounded-full transition-all duration-300"
                 style="width: {{ $statistik['total'] > 0 ? ($statistik['hadir'] / $statistik['total']) * 100 : 0 }}%">
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Presensi -->
<div class="bg-white shadow rounded-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Presensi (10 Hari Terakhir)</h3>

    @if($murid->presensi->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Keluar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($murid->presensi->take(10) as $presensi)
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
            <p class="text-gray-500">Belum ada riwayat presensi</p>
        </div>
    @endif
</div>
@endsection
