@extends('layouts.admin')

@section('page-title', 'Kelola Murid')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Kelola Murid</h2>
    <div class="space-x-2">
        <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Import Excel
        </button>
        <a href="{{ route('admin.murid.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Murid
        </a>
    </div>
</div>

<!-- Filter -->
<div class="bg-white shadow rounded-lg p-4 mb-6">
    <form method="GET" action="{{ route('admin.murid.index') }}" class="flex flex-wrap items-center gap-4">
        <div class="flex-1 min-w-0">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama, email, atau NIS..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
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
        <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Filter
        </button>
        <a href="{{ route('admin.murid.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded">
            Reset
        </a>
    </form>
</div>

<!-- Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    @if($murid->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($murid as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item->nis }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $item->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <a href="{{ route('admin.murid.show', $item->id) }}" class="text-green-600 hover:text-green-900 font-medium">
                                    Detail
                                </a>
                                <a href="{{ route('admin.murid.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-900 font-medium">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.murid.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus murid ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-3 border-t border-gray-200">
            {{ $murid->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada murid</h3>
            <p class="text-gray-500 mb-4">Mulai dengan menambahkan murid pertama</p>
            <a href="{{ route('admin.murid.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
@endsection
