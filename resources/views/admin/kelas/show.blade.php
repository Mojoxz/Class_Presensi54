@extends('layouts.admin')

@section('page-title', 'Detail Kelas')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Detail Kelas {{ $kelas->nama_kelas }}</h2>
    <div class="space-x-2">
        <a href="{{ route('admin.kelas.edit', $kelas->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
            Edit
        </a>
        <a href="{{ route('admin.kelas.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Kembali
        </a>
    </div>
</div>

<!-- Info Kelas -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kelas</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-500">Nama Kelas</label>
            <p class="text-lg font-semibold text-gray-900">{{ $kelas->nama_kelas }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500">Wali Kelas</label>
            <p class="text-lg font-semibold text-gray-900">{{ $kelas->wali_kelas }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500">Jumlah Siswa</label>
            <p class="text-lg font-semibold text-blue-600">{{ $kelas->siswa->count() }} siswa</p>
        </div>
    </div>
</div>

<!-- Daftar Siswa -->
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Daftar Siswa</h3>
        <a href="{{ route('admin.murid.create') }}?kelas={{ $kelas->id }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded text-sm">
            Tambah Siswa
        </a>
    </div>

    @if($kelas->siswa->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($kelas->siswa as $index => $siswa)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $siswa->nis }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $siswa->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $siswa->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <a href="{{ route('admin.murid.show', $siswa->id) }}" class="text-blue-600 hover:text-blue-900">
                                    Detail
                                </a>
                                <a href="{{ route('admin.murid.edit', $siswa->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada siswa</h3>
            <p class="text-gray-500 mb-4">Kelas ini belum memiliki siswa</p>
            <a href="{{ route('admin.murid.create') }}?kelas={{ $kelas->id }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                Tambah Siswa Pertama
            </a>
        </div>
    @endif
</div>
@endsection
