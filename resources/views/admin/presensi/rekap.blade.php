@extends('layouts.admin')

@section('page-title', 'Rekap Presensi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Rekap Presensi Bulanan</h2>
    <a href="{{ route('admin.presensi.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Kembali
    </a>
</div>

<!-- Filter -->
<div class="bg-white shadow rounded-lg p-4 mb-6">
    <form method="GET" action="{{ route('admin.presensi.rekap') }}" class="flex flex-wrap items-center gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
            <select name="bulan" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
            <select name="tahun" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <select name="kelas_id" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Semua Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mr-2">
                Filter
            </button>
            <a href="{{ route('admin.presensi.rekap') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Summary Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="text-center">
            <div class="text-3xl font-bold text-blue-600">{{ $rekapData->count() }}</div>
            <p class="text-gray-600">Total Siswa</p>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="text-center">
            <div class="text-3xl font-bold text-green-600">{{ $rekapData->sum('hadir') }}</div>
            <p class="text-gray-600">Total Hadir</p>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="text-center">
            <div class="text-3xl font-bold text-yellow-600">{{ $rekapData->sum('izin') }}</div>
            <p class="text-gray-600">Total Izin</p>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="text-center">
            <div class="text-3xl font-bold text-red-600">{{ $rekapData->sum('tidak_hadir') }}</div>
            <p class="text-gray-600">Total Tidak Hadir</p>
        </div>
    </div>
</div>

<!-- Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    @if($rekapData->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hadir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Izin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sakit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tidak Hadir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">%</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($rekapData as $index => $data)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $data['siswa']->name }}</div>
                                <div class="text-sm text-gray-500">{{ $data['siswa']->nis }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $data['siswa']->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $data['total'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">
                                {{ $data['hadir'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600 font-medium">
                                {{ $data['izin'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-medium">
                                {{ $data['sakit'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium">
                                {{ $data['tidak_hadir'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $data['total'] > 0 ? round(($data['hadir'] / $data['total']) * 100, 1) : 0 }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data</h3>
            <p class="text-gray-500">Tidak ada data presensi untuk bulan dan tahun yang dipilih</p>
        </div>
    @endif
</div>
@endsection 
