@extends('layouts.admin')

@section('page-title', 'Kelola Murid')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Kelola Murid</h2>
    <div class="flex space-x-2">
        <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            Import Excel
        </button>
        <a href="#" onclick="exportData()" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export
        </a>
        <a href="{{ route('admin.murid.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Murid
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Murid</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $murid->total() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Kelas</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $kelas->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Hadir Hari Ini</dt>
                        <dd class="text-lg font-medium text-gray-900">
                            {{ \App\Models\Presensi::where('tanggal', date('Y-m-d'))->where('status', 'hadir')->count() }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Tidak Hadir</dt>
                        <dd class="text-lg font-medium text-gray-900">
                            {{ \App\Models\Presensi::where('tanggal', date('Y-m-d'))->where('status', 'tidak_hadir')->count() }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flash Messages -->
@if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Berhasil!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
            <svg class="fill-current h-6 w-6 text-green-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
@endif

@if(session('error'))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
            <svg class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
@endif

<!-- Filter -->
<div class="bg-white shadow rounded-lg p-4 mb-6">
    <form method="GET" action="{{ route('admin.murid.index') }}" class="flex flex-wrap items-center gap-4">
        <div class="flex-1 min-w-0">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama, email, atau NIS..."
                       class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
        </div>
        <div>
            <select name="kelas_id" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Semua Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="per_page" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 per halaman</option>
                <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 per halaman</option>
                <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 per halaman</option>
                <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 per halaman</option>
            </select>
        </div>
        <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filter
        </button>
        <a href="{{ route('admin.murid.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Reset
        </a>
    </form>
</div>

<!-- Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    @if($murid->count() > 0)
        <div class="px-4 py-3 border-b border-gray-200 sm:px-6">
            <p class="text-sm text-gray-700">
                Menampilkan <span class="font-medium">{{ $murid->firstItem() }}</span> sampai
                <span class="font-medium">{{ $murid->lastItem() }}</span> dari
                <span class="font-medium">{{ $murid->total() }}</span> hasil
            </p>
        </div>

        <!-- Mobile Scroll Hint -->
        <div class="table-scroll-hint">
            <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
            </svg>
            Geser tabel ke kanan untuk melihat lebih banyak
            <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
        </div>

        <!-- Table Wrapper with Horizontal Scroll -->
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-20">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky right-0 bg-gray-50 z-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($murid as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap sticky left-0 bg-white z-10 border-r border-gray-100">
                                <input type="checkbox" name="selected_ids[]" value="{{ $item->id }}" class="rounded border-gray-300 row-checkbox">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item->nis }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center min-w-[200px]">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                            <span class="text-white font-medium text-sm">
                                                {{ strtoupper(substr($item->name, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                        <div class="text-sm text-gray-500">Bergabung {{ $item->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $item->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $todayPresensi = $item->presensi()->where('tanggal', date('Y-m-d'))->first();
                                @endphp
                                @if($todayPresensi)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $todayPresensi->status === 'hadir' ? 'bg-green-100 text-green-800' :
                                           ($todayPresensi->status === 'izin' ? 'bg-yellow-100 text-yellow-800' :
                                            ($todayPresensi->status === 'sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $todayPresensi->status)) }}
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Belum Absen
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm sticky right-0 bg-white z-10 border-l border-gray-100">
                                <div class="flex space-x-2 min-w-[180px]">
                                    <a href="{{ route('admin.murid.show', $item->id) }}"
                                       class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.murid.edit', $item->id) }}"
                                       class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-yellow-600 hover:bg-yellow-700 rounded">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <button onclick="deleteItem({{ $item->id }}, '{{ $item->name }}')"
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Bulk Actions -->
        <div id="bulkActions" class="hidden bg-yellow-50 px-4 py-3 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center flex-wrap gap-2">
                    <span class="text-sm text-gray-700">
                        <span id="selectedCount">0</span> item dipilih
                    </span>
                    <button onclick="bulkDelete()" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-sm font-medium">
                        Hapus Terpilih
                    </button>
                </div>
                <button onclick="clearSelection()" class="text-sm text-gray-600 hover:text-gray-800 underline">
                    Batalkan Pilihan
                </button>
            </div>
        </div>

        <!-- Pagination -->
        <div class="px-4 sm:px-6 py-3 border-t border-gray-200">
            {{ $murid->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-12 px-4">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada murid</h3>
            <p class="text-gray-500 mb-4">Mulai dengan menambahkan murid pertama</p>
            <a href="{{ route('admin.murid.create') }}" class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Murid
            </a>
        </div>
    @endif
</div>

<!-- Import Modal -->
<div id="importModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Import Data Murid</h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.murid.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        File Excel (.xlsx, .xls, .csv)
                    </label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>

                <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
                    <p class="text-sm text-yellow-800">
                        <strong>Format Excel:</strong><br>
                        Kolom: nama | email | nis | kelas | password
                    </p>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded">
                        Batal
                    </button>
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Hapus Murid</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Yakin ingin menghapus murid <strong id="deleteName"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <form id="deleteForm" method="POST" class="mt-4">
                @csrf
                @method('DELETE')
                <div class="flex justify-center space-x-2">
                    <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded">
                        Batal
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Select All functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActions();
});

// Individual checkbox functionality
document.querySelectorAll('.row-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActions);
});

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');

    if (checkedBoxes.length > 0) {
        bulkActions.classList.remove('hidden');
        selectedCount.textContent = checkedBoxes.length;
    } else {
        bulkActions.classList.add('hidden');
    }

    // Update select all checkbox
    const selectAll = document.getElementById('selectAll');
    const allCheckboxes = document.querySelectorAll('.row-checkbox');
    selectAll.checked = checkedBoxes.length === allCheckboxes.length;
    selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < allCheckboxes.length;
}

function clearSelection() {
    document.querySelectorAll('.row-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    updateBulkActions();
}

function deleteItem(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/murid/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function bulkDelete() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    if (checkedBoxes.length === 0) return;

    const ids = Array.from(checkedBoxes).map(cb => cb.value);

    if (confirm(`Yakin ingin menghapus ${ids.length} murid yang dipilih? Tindakan ini tidak dapat dibatalkan.`)) {
        // Create form for bulk delete
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.murid.bulk-delete") }}'; // You need to add this route

        // Add CSRF token
        const csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = '{{ csrf_token() }}';
        form.appendChild(csrfField);

        // Add method field
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);

        // Add selected IDs
        ids.forEach(id => {
            const idField = document.createElement('input');
            idField.type = 'hidden';
            idField.name = 'ids[]';
            idField.value = id;
            form.appendChild(idField);
        });

        document.body.appendChild(form);
        form.submit();
    }
}

function exportData() {
    const params = new URLSearchParams(window.location.search);
    const exportUrl = '{{ route("admin.murid.export") }}?' + params.toString();
    window.open(exportUrl, '_blank');
}

document.addEventListener('DOMContentLoaded', function() {
    const tableWrapper = document.querySelector('.admin-table-wrapper');
    const scrollHint = document.querySelector('.table-scroll-hint');

    if (tableWrapper && scrollHint) {
        // Hide hint after user scrolls
        let scrollTimeout;
        tableWrapper.addEventListener('scroll', function() {
            clearTimeout(scrollTimeout);
            scrollHint.style.opacity = '0.5';

            scrollTimeout = setTimeout(function() {
                if (tableWrapper.scrollLeft > 50) {
                    scrollHint.style.display = 'none';
                } else {
                    scrollHint.style.opacity = '1';
                }
            }, 1000);
        });

        // Auto-hide hint after 5 seconds on mobile
        if (window.innerWidth <= 768) {
            setTimeout(function() {
                scrollHint.style.transition = 'opacity 0.5s';
                scrollHint.style.opacity = '0.5';
            }, 5000);
        }
    }

    // Touch swipe enhancement for better mobile experience
    if (tableWrapper && 'ontouchstart' in window) {
        let startX, scrollLeft;

        tableWrapper.addEventListener('touchstart', function(e) {
            startX = e.touches[0].pageX - tableWrapper.offsetLeft;
            scrollLeft = tableWrapper.scrollLeft;
        });

        tableWrapper.addEventListener('touchmove', function(e) {
            if (!startX) return;
            const x = e.touches[0].pageX - tableWrapper.offsetLeft;
            const walk = (x - startX) * 2; // Scroll speed multiplier
            tableWrapper.scrollLeft = scrollLeft - walk;
        });

        tableWrapper.addEventListener('touchend', function() {
            startX = null;
        });
    }


// Auto-hide flash messages
setTimeout(function() {
    const flashMessages = document.querySelectorAll('.bg-green-100, .bg-red-100');
    flashMessages.forEach(function(message) {
        message.style.transition = 'opacity 0.5s';
        message.style.opacity = '0';
        setTimeout(function() {
            message.remove();
        }, 500);
    });
}, 5000);
</script>
@endsection
