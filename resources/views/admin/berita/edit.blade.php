@extends('layouts.admin')

@section('page-title', 'Edit Berita')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Edit Berita</h2>
    <a href="{{ route('admin.berita.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Kembali
    </a>
</div>

<div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <form method="POST" action="{{ route('admin.berita.update', $berita->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="judul">
                Judul Berita
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('judul') border-red-500 @enderror"
                   id="judul" name="judul" type="text" placeholder="Masukkan judul berita" value="{{ old('judul', $berita->judul) }}" required>
            @error('judul')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="gambar">
                Gambar
            </label>
            @if($berita->gambar)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Current image" class="w-32 h-32 object-cover rounded">
                    <p class="text-sm text-gray-600 mt-1">Gambar saat ini</p>
                </div>
            @endif
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('gambar') border-red-500 @enderror"
                   id="gambar" name="gambar" type="file" accept="image/*">
            @error('gambar')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
            <p class="text-gray-600 text-xs italic mt-1">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="konten">
                Konten Berita
            </label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('konten') border-red-500 @enderror"
                      id="konten" name="konten" rows="10" placeholder="Masukkan konten berita" required>{{ old('konten', $berita->konten) }}</textarea>
            @error('konten')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $berita->is_published) ? 'checked' : '' }}
                       class="form-checkbox h-4 w-4 text-blue-600">
                <span class="ml-2 text-gray-700">Publikasikan berita</span>
            </label>
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Update
            </button>
            <a href="{{ route('admin.berita.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
