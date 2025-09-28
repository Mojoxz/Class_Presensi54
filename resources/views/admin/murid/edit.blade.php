@extends('layouts.admin')

@section('page-title', 'Edit Murid')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Edit Murid</h2>
    <a href="{{ route('admin.murid.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Kembali
    </a>
</div>

<div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <form method="POST" action="{{ route('admin.murid.update', $murid->id) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Nama Lengkap
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                       id="name" name="name" type="text" placeholder="Masukkan nama lengkap" value="{{ old('name', $murid->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nis">
                    NIS
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nis') border-red-500 @enderror"
                       id="nis" name="nis" type="text" placeholder="Masukkan NIS" value="{{ old('nis', $murid->nis) }}" required>
                @error('nis')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                       id="email" name="email" type="email" placeholder="Masukkan email" value="{{ old('email', $murid->email) }}" required>
                @error('email')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="kelas_id">
                    Kelas
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('kelas_id') border-red-500 @enderror"
                        id="kelas_id" name="kelas_id" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id', $murid->kelas_id) == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password (Kosongkan jika tidak ingin mengubah)
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                   id="password" name="password" type="password" placeholder="Masukkan password baru">
            @error('password')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
            <p class="text-gray-600 text-xs italic mt-1">Kosongkan jika tidak ingin mengubah password</p>
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Update
            </button>
            <a href="{{ route('admin.murid.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
