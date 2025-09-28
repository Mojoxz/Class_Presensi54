@extends('layouts.admin')

@section('page-title', 'Kelola Berita')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Kelola Berita</h2>
    <a href="{{ route('admin.berita.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Tambah Berita
    </a>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    @if($berita->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @foreach($berita as $item)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    @if($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif

                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $item->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $item->is_published ? 'Published' : 'Draft' }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ $item->created_at->format('d/m/Y') }}
                            </span>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $item->judul }}</h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-3">{{ $item->excerpt }}</p>

                        <div class="text-xs text-gray-500 mb-4">
                            Oleh: {{ $item->user->name }}
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('admin.berita.show', $item->id) }}" class="flex-1 bg-green-500 hover:bg-green-600 text-white text-sm font-medium py-2 px-3 rounded text-center">
                                Detail
                            </a>
                            <a href="{{ route('admin.berita.edit', $item->id) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium py-2 px-3 rounded text-center">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.berita.destroy', $item->id) }}" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-2 px-3 rounded">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="px-6 py-3 border-t border-gray-200">
            {{ $berita->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada berita</h3>
            <p class="text-gray-500 mb-4">Mulai dengan membuat berita pertama</p>
            <a href="{{ route('admin.berita.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Berita
            </a>
        </div>
    @endif
</div>
@endsection 
