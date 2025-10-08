@extends('layouts.student')

@section('page-title', 'Presensi')

@section('content')
<!-- Current Time Card -->
<div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-xl p-6 mb-8 text-white">
    <div class="text-center">
        <h2 class="text-2xl font-bold mb-2">Presensi Siswa</h2>
        <p class="text-blue-100 mb-4">{{ auth()->user()->name }} - Kelas {{ auth()->user()->kelas->nama_kelas ?? '-' }}</p>
        <div class="text-5xl font-bold mb-2" id="current-time"></div>
        <div class="text-lg" id="current-date"></div>
    </div>
</div>

<!-- Statistik Presensi Bulan Ini -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Hadir</p>
                <p class="text-2xl font-bold text-green-600">{{ $statistik['hadir'] }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Izin</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $statistik['izin'] }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Sakit</p>
                <p class="text-2xl font-bold text-blue-600">{{ $statistik['sakit'] }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Tidak Hadir</p>
                <p class="text-2xl font-bold text-red-600">{{ $statistik['tidak_hadir'] }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Presensi Actions -->
<div class="bg-white rounded-xl shadow-xl p-6 mb-8">
    <h3 class="text-xl font-semibold text-gray-900 mb-6">Presensi Hari Ini</h3>

    @if($presensiHariIni)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Status Presensi Masuk atau Izin/Sakit -->
            @if(in_array($presensiHariIni->status, ['izin', 'sakit']))
                <div class="lg:col-span-2 bg-gradient-to-br {{ $presensiHariIni->status === 'izin' ? 'from-yellow-50 to-yellow-100 border-yellow-300' : 'from-blue-50 to-blue-100 border-blue-300' }} p-6 rounded-xl border-2 shadow-md">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-20 h-20 bg-gradient-to-br {{ $presensiHariIni->status === 'izin' ? 'from-yellow-400 to-yellow-600' : 'from-blue-400 to-blue-600' }} rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($presensiHariIni->status === 'izin')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                @endif
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <h4 class="text-lg font-bold {{ $presensiHariIni->status === 'izin' ? 'text-yellow-900' : 'text-blue-900' }} mb-2">
                            Status: {{ ucfirst($presensiHariIni->status) }}
                        </h4>
                        <p class="{{ $presensiHariIni->status === 'izin' ? 'text-yellow-700' : 'text-blue-700' }} mb-2">
                            Menunggu persetujuan admin
                        </p>

                        @if($presensiHariIni->alasan)
                            <div class="mt-4 p-4 bg-white bg-opacity-50 rounded-lg text-left">
                                <p class="text-sm font-semibold {{ $presensiHariIni->status === 'izin' ? 'text-yellow-900' : 'text-blue-900' }} mb-2">
                                    Alasan:
                                </p>
                                <p class="text-sm {{ $presensiHariIni->status === 'izin' ? 'text-yellow-800' : 'text-blue-800' }}">
                                    {{ $presensiHariIni->alasan }}
                                </p>
                            </div>
                        @endif

                        @if($presensiHariIni->foto_bukti)
                            <div class="mt-4">
                                <p class="text-sm font-semibold {{ $presensiHariIni->status === 'izin' ? 'text-yellow-900' : 'text-blue-900' }} mb-2">
                                    Bukti {{ ucfirst($presensiHariIni->status) }}:
                                </p>
                                <img src="{{ asset('storage/' . $presensiHariIni->foto_bukti) }}"
                                     alt="Foto Bukti"
                                     class="w-48 h-48 object-cover rounded-lg mx-auto border-4 {{ $presensiHariIni->status === 'izin' ? 'border-yellow-300' : 'border-blue-300' }} shadow-lg cursor-pointer hover:scale-105 transition-transform"
                                     onclick="showImageModal('{{ asset('storage/' . $presensiHariIni->foto_bukti) }}')">
                                <p class="text-xs {{ $presensiHariIni->status === 'izin' ? 'text-yellow-600' : 'text-blue-600' }} mt-2">Klik untuk memperbesar</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <!-- Status Presensi Masuk -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border-2 border-green-300 shadow-md">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <h4 class="text-lg font-bold text-green-900 mb-2">Presensi Masuk</h4>
                        <p class="text-green-700 mb-2">Status: <span class="font-semibold capitalize">{{ $presensiHariIni->status }}</span></p>
                        <p class="text-2xl font-bold text-green-800 mb-3">
                            {{ $presensiHariIni->jam_masuk ? $presensiHariIni->jam_masuk->format('H:i:s') : '-' }}
                        </p>

                        @if($presensiHariIni->foto_masuk)
                            <div class="mt-4">
                                <img src="{{ asset('storage/' . $presensiHariIni->foto_masuk) }}"
                                     alt="Foto Masuk"
                                     class="w-32 h-32 object-cover rounded-lg mx-auto border-4 border-green-300 shadow-lg cursor-pointer hover:scale-105 transition-transform"
                                     onclick="showImageModal('{{ asset('storage/' . $presensiHariIni->foto_masuk) }}')">
                                <p class="text-xs text-green-600 mt-2">Klik untuk memperbesar</p>
                            </div>
                        @endif

                        @if($presensiHariIni->keterangan)
                            <div class="mt-4 p-3 bg-yellow-100 border border-yellow-300 rounded-lg">
                                <p class="text-sm text-yellow-800">
                                    <span class="font-medium">⚠️ {{ $presensiHariIni->keterangan }}</span>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Status Presensi Keluar -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border-2 {{ $presensiHariIni->jam_keluar ? 'border-purple-300' : 'border-gray-300' }} shadow-md">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-20 h-20 bg-gradient-to-br {{ $presensiHariIni->jam_keluar ? 'from-purple-400 to-purple-600' : 'from-gray-300 to-gray-400' }} rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <h4 class="text-lg font-bold {{ $presensiHariIni->jam_keluar ? 'text-purple-900' : 'text-gray-700' }} mb-2">Presensi Keluar</h4>

                        @if($presensiHariIni->jam_keluar)
                            <p class="text-2xl font-bold text-purple-800 mb-3">
                                {{ $presensiHariIni->jam_keluar->format('H:i:s') }}
                            </p>

                            @if($presensiHariIni->foto_keluar)
                                <div class="mt-4">
                                    <img src="{{ asset('storage/' . $presensiHariIni->foto_keluar) }}"
                                         alt="Foto Keluar"
                                         class="w-32 h-32 object-cover rounded-lg mx-auto border-4 border-purple-300 shadow-lg cursor-pointer hover:scale-105 transition-transform"
                                         onclick="showImageModal('{{ asset('storage/' . $presensiHariIni->foto_keluar) }}')">
                                    <p class="text-xs text-purple-600 mt-2">Klik untuk memperbesar</p>
                                </div>
                            @endif
                        @else
                            <p class="text-gray-500 mb-4">Belum presensi keluar</p>

                            @if($bolehKeluar)
                                <button onclick="openCameraModal('keluar')" class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Presensi Keluar
                                </button>
                            @else
                                <div class="bg-gray-100 border border-gray-300 rounded-lg p-4">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600 font-medium">Presensi keluar hanya bisa dilakukan</p>
                                    <p class="text-sm text-gray-600">antara jam 14:00 - 18:00</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="text-center py-8">
            @if($bolehMasuk)
                <div class="mb-6">
                    <svg class="w-24 h-24 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7l2 2 4-4"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Presensi</h3>
                    <p class="text-gray-600 mb-6">Silakan lakukan presensi masuk untuk hari ini</p>
                </div>

                <div class="flex flex-wrap justify-center gap-4">
                    <button onclick="openCameraModal('masuk')" class="bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Presensi Masuk
                    </button>

                    <button onclick="openIzinModal()" class="bg-gradient-to-r from-yellow-500 to-yellow-700 hover:from-yellow-600 hover:to-yellow-800 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Ajukan Izin
                    </button>

                    <button onclick="openSakitModal()" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                        Lapor Sakit
                    </button>
                </div>

                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg max-w-md mx-auto">
                    <p class="text-sm text-blue-800">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <strong>Info:</strong> Batas tepat waktu jam 07:30. Presensi masuk tersedia jam 06:00 - 08:30
                    </p>
                </div>
            @else
                <div class="bg-red-50 border-2 border-red-200 rounded-xl p-8 max-w-md mx-auto mb-6">
                    <svg class="w-20 h-20 text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-red-900 mb-2">Presensi Masuk Ditutup</h3>
                    <p class="text-red-700 mb-4">Presensi masuk hanya bisa dilakukan antara jam 06:00 - 08:30</p>
                    <p class="text-sm text-red-600">Silakan hubungi admin jika ada kendala</p>
                </div>

                <div class="flex flex-wrap justify-center gap-4">
                    <button onclick="openIzinModal()" class="bg-gradient-to-r from-yellow-500 to-yellow-700 hover:from-yellow-600 hover:to-yellow-800 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Ajukan Izin
                    </button>

                    <button onclick="openSakitModal()" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                        Lapor Sakit
                    </button>
                </div>
            @endif
        </div>
    @endif
</div>

<!-- Riwayat Presensi -->
<div class="bg-white rounded-xl shadow-xl p-6">
    <h3 class="text-xl font-semibold text-gray-900 mb-6">📋 Riwayat Presensi Bulan Ini</h3>

    @if($presensiRiwayat->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jam Masuk</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jam Keluar</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($presensiRiwayat as $presensi)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $presensi->tanggal->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full
                                    {{ $presensi->status === 'hadir' ? 'bg-green-100 text-green-800' :
                                       ($presensi->status === 'izin' ? 'bg-yellow-100 text-yellow-800' :
                                        ($presensi->status === 'sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $presensi->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $presensi->jam_masuk ? $presensi->jam_masuk->format('H:i:s') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $presensi->jam_keluar ? $presensi->jam_keluar->format('H:i:s') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    @if($presensi->foto_masuk)
                                        <img src="{{ asset('storage/' . $presensi->foto_masuk) }}"
                                             alt="Masuk"
                                             class="w-10 h-10 object-cover rounded cursor-pointer hover:scale-110 transition-transform border-2 border-green-300"
                                             onclick="showImageModal('{{ asset('storage/' . $presensi->foto_masuk) }}')"
                                             title="Foto Masuk">
                                    @endif
                                    @if($presensi->foto_keluar)
                                        <img src="{{ asset('storage/' . $presensi->foto_keluar) }}"
                                             alt="Keluar"
                                             class="w-10 h-10 object-cover rounded cursor-pointer hover:scale-110 transition-transform border-2 border-purple-300"
                                             onclick="showImageModal('{{ asset('storage/' . $presensi->foto_keluar) }}')"
                                             title="Foto Keluar">
                                    @endif
                                    @if($presensi->foto_bukti)
                                        <img src="{{ asset('storage/' . $presensi->foto_bukti) }}"
                                             alt="Bukti"
                                             class="w-10 h-10 object-cover rounded cursor-pointer hover:scale-110 transition-transform border-2 {{ $presensi->status === 'izin' ? 'border-yellow-300' : 'border-blue-300' }}"
                                             onclick="showImageModal('{{ asset('storage/' . $presensi->foto_bukti) }}')"
                                             title="Foto Bukti {{ ucfirst($presensi->status) }}">
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if($presensi->alasan)
                                    <button onclick="showAlasanModal('{{ $presensi->status }}', '{{ addslashes($presensi->alasan) }}')"
                                            class="text-blue-600 hover:text-blue-800 underline">
                                        Lihat Detail
                                    </button>
                                @else
                                    {{ $presensi->keterangan ?? '-' }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <p class="text-gray-500 text-lg">Belum ada riwayat presensi bulan ini</p>
        </div>
    @endif
</div>

<!-- Modal Kamera untuk Presensi Masuk/Keluar -->
<div id="cameraModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900">Ambil Foto Presensi</h3>
            <button onclick="closeCameraModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="relative">
            <video id="camera" class="w-full rounded-lg bg-gray-900" autoplay playsinline></video>
            <canvas id="canvas" class="hidden"></canvas>

            <div id="capturedImage" class="hidden">
                <img id="photo" src="" alt="Captured" class="w-full rounded-lg">
            </div>
        </div>

        <div class="mt-4 flex justify-center gap-4">
            <button id="captureBtn" onclick="capturePhoto()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Ambil Foto
            </button>

            <button id="retakeBtn" onclick="retakePhoto()" class="hidden bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Ambil Ulang
            </button>

            <button id="submitBtn" onclick="submitPresensi()" class="hidden bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Kirim Presensi
            </button>
        </div>

        <div id="loadingIndicator" class="hidden mt-4 text-center">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-blue-600 border-t-transparent"></div>
            <p class="mt-2 text-gray-600">Memproses presensi...</p>
        </div>
    </div>
</div>

<!-- Modal Izin -->
<div id="izinModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900">Ajukan Izin</h3>
            <button onclick="closeIzinModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Izin *</label>
                <textarea id="alasanIzin" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" placeholder="Jelaskan alasan izin Anda (minimal 10 karakter)"></textarea>
                <p class="text-xs text-gray-500 mt-1">Contoh: Acara keluarga, keperluan mendadak, dll.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Bukti Izin * (Surat/Screenshot/Dokumen)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                    <div id="izinPreview" class="hidden mb-4">
                        <img id="izinPhoto" src="" alt="Preview" class="w-full rounded-lg">
                    </div>
                    <video id="izinCamera" class="w-full rounded-lg bg-gray-900 mb-4 hidden" autoplay playsinline></video>
                    <canvas id="izinCanvas" class="hidden"></canvas>

                    <div class="text-center">
                        <button id="startIzinCameraBtn" onclick="startIzinCamera()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            </svg>
                            Buka Kamera
                        </button>
                        <button id="captureIzinBtn" onclick="captureIzinPhoto()" class="hidden bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Ambil Foto
                        </button>
                        <button id="retakeIzinBtn" onclick="retakeIzinPhoto()" class="hidden bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-semibold inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Ambil Ulang
                        </button>
                    </div>
                </div>
            </div>

            <div id="izinLoadingIndicator" class="hidden text-center py-4">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-yellow-600 border-t-transparent"></div>
                <p class="mt-2 text-gray-600">Mengirim pengajuan izin...</p>
            </div>

            <button onclick="submitIzin()" class="w-full bg-gradient-to-r from-yellow-500 to-yellow-700 hover:from-yellow-600 hover:to-yellow-800 text-white px-6 py-3 rounded-lg font-bold transition-all duration-200 shadow-lg">
                Kirim Pengajuan Izin
            </button>
        </div>
    </div>
</div>

<!-- Modal Sakit -->
<div id="sakitModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900">Lapor Sakit</h3>
            <button onclick="closeSakitModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan Sakit *</label>
                <textarea id="alasanSakit" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Jelaskan kondisi/keluhan Anda (minimal 10 karakter)"></textarea>
                <p class="text-xs text-gray-500 mt-1">Contoh: Demam tinggi, sakit kepala, flu, dll.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Surat Sakit * (Dari Dokter/Klinik/Puskesmas)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                    <div id="sakitPreview" class="hidden mb-4">
                        <img id="sakitPhoto" src="" alt="Preview" class="w-full rounded-lg">
                    </div>
                    <video id="sakitCamera" class="w-full rounded-lg bg-gray-900 mb-4 hidden" autoplay playsinline></video>
                    <canvas id="sakitCanvas" class="hidden"></canvas>

                    <div class="text-center">
                        <button id="startSakitCameraBtn" onclick="startSakitCamera()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            </svg>
                            Buka Kamera
                        </button>
                        <button id="captureSakitBtn" onclick="captureSakitPhoto()" class="hidden bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Ambil Foto
                        </button>
                        <button id="retakeSakitBtn" onclick="retakeSakitPhoto()" class="hidden bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-semibold inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Ambil Ulang
                        </button>
                    </div>
                </div>
            </div>

            <div id="sakitLoadingIndicator" class="hidden text-center py-4">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-blue-600 border-t-transparent"></div>
                <p class="mt-2 text-gray-600">Mengirim laporan sakit...</p>
            </div>

            <button onclick="submitSakit()" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white px-6 py-3 rounded-lg font-bold transition-all duration-200 shadow-lg">
                Kirim Laporan Sakit
            </button>
        </div>
    </div>
</div>

<!-- Modal untuk melihat gambar -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="modalImage" src="" alt="Preview" class="max-w-full max-h-screen rounded-lg shadow-2xl">
    </div>
</div>

<!-- Modal untuk melihat alasan detail -->
<div id="alasanModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4" onclick="closeAlasanModal()">
    <div class="bg-white rounded-xl max-w-lg w-full p-6" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900" id="alasanTitle">Detail Alasan</h3>
            <button onclick="closeAlasanModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-gray-800" id="alasanContent"></p>
        </div>
    </div>
</div>

<!-- Include External JavaScript -->
<script>
    // Setup routes and CSRF token for external JS
    window.csrfToken = '{{ csrf_token() }}';
    window.routes = {
        presensiMasuk: '{{ route("student.presensi.masuk") }}',
        presensiKeluar: '{{ route("student.presensi.keluar") }}',
        presensiIzin: '{{ route("student.presensi.izin") }}',
        presensiSakit: '{{ route("student.presensi.sakit") }}'
    };
</script>
<script src="{{ asset('js/presensi.js') }}"></script>

@if(session('success'))
<script>
    alert('{{ session("success") }}');
</script>
@endif

@if(session('error'))
<script>
    alert('{{ session("error") }}');
</script>
@endif

@endsection
