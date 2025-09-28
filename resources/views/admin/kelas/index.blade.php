@extends('layouts.admin')

@section('page-title', 'Kelola Kelas')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Kelola Kelas</h2>
    <a href="{{ route('admin.kelas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Tambah Kelas
    </a>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 sm:p-6">
        @if($kelas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kelas as $item)
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $item->nama_kelas }}</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                {{ $item->siswa_count }} siswa
                            </span>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">
                                <span class="font-medium">Wali Kelas:</span>
                            </p>
                            <p class="text-gray-900">{{ $item->wali_kelas }}</p>
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('admin.kelas.show', $item->id) }}" class="flex-1 bg-green-500 hover:bg-green-600 text-white text-sm font-medium py-2 px-3 rounded text-center">
                                Detail
                            </a>
                            <a href="{{ route('admin.kelas.edit', $item->id) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium py-2 px-3 rounded text-center">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.kelas.destroy', $item->id) }}" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-2 px-3 rounded">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada kelas</h3>
                <p class="text-gray-500 mb-4">Mulai dengan membuat kelas pertama</p>
                <a href="{{ route('admin.kelas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah Kelas
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
