@extends('layouts.admin')

@section('page-title', 'Detail Berita')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Detail Berita</h2>
    <div class="space-x-2">
        <a href="{{ route('admin.berita.edit', $berita->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
            Edit
        </a>
        <a href="{{ route('admin.berita.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Kembali
        </a>
    </div>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold text-gray-900">{{ $berita->judul }}</h3>
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                {{ $berita->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $berita->is_published ? 'Published' : 'Draft' }}
            </span>
        </div>
        <div class="mt-2 text-sm text-gray-600">
            <span>Dibuat oleh: {{ $berita->user->name }}</span> •
            <span>{{ $berita->created_at->format('d F Y, H:i') }}</span>
            @if($berita->updated_at != $berita->created_at)
                • <span>Diupdate: {{ $berita->updated_at->format('d F Y, H:i') }}</span>
            @endif
        </div>
    </div>

    <!-- Image -->
    @if($berita->gambar)
        <div class="px-6 py-4">
            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                 class="w-full max-w-2xl mx-auto rounded-lg shadow-md">
        </div>
    @endif

    <!-- Content -->
    <div class="px-6 py-4">
        <div class="prose max-w-none">
            {!! nl2br(e($berita->konten)) !!}
        </div>
    </div>
</div>
@endsection
