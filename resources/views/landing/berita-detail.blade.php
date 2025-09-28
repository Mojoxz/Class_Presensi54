@extends('layouts.landing')

@section('title', $berita->judul . ' - SMP 54 Surabaya')

@section('content')
<!-- Hero Section -->
<section class="bg-blue-600 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-blue-200 mb-4">
            <a href="{{ route('landing') }}" class="hover:text-white">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('berita.public') }}" class="hover:text-white">Berita</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span>Detail</span>
        </nav>

        <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $berita->judul }}</h1>

        <div class="flex items-center text-blue-200 space-x-4">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ $berita->created_at->format('d F Y') }}
            </div>
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                {{ $berita->user->name }}
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <article class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                     class="w-full h-64 md:h-96 object-cover">
            @endif

            <div class="p-8">
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($berita->konten)) !!}
                </div>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Dipublikasikan {{ $berita->created_at->format('d F Y, H:i') }}
                        </div>
                        <a href="{{ route('berita.public') }}"
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Kembali ke Berita
                        </a>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
@endsection 
