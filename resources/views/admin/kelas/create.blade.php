@extends('layouts.admin')

@section('page-title', 'Tambah Kelas')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Tambah Kelas</h2>
    <a href="{{ route('admin.kelas.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Kembali
    </a>
</div>

<div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <form method="POST" action="{{ route('admin.kelas.store') }}">
        @csrf

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_kelas">
                Nama Kelas
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_kelas') border-red-500 @enderror"
                   id="nama_kelas" name="nama_kelas" type="text" placeholder="Contoh: 8A" value="{{ old('nama_kelas') }}" required>
            @error('nama_kelas')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="wali_kelas">
                Nama Wali Kelas
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('wali_kelas') border-red-500 @enderror"
                   id="wali_kelas" name="wali_kelas" type="text" placeholder="Contoh: Budi Santoso, S.Pd" value="{{ old('wali_kelas') }}" required>
            @error('wali_kelas')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Simpan
            </button>
            <a href="{{ route('admin.kelas.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
