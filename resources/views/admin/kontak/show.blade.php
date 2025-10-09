@extends('layouts.admin')

@section('title', 'Detail Pesan Kontak')
@section('page-title', 'Detail Pesan Kontak')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.kontak.index') }}" class="admin-btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Pesan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Message Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Header Card -->
            <div class="admin-card">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-amber-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                                {{ strtoupper(substr($kontak->nama, 0, 1)) }}
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $kontak->nama }}</h2>
                                <p class="text-sm text-gray-500">{{ $kontak->created_at->diffForHumans() }} • {{ $kontak->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mb-4">
                            @if(!$kontak->is_read)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                Belum Dibaca
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.94 6.412A2 2 0 002 8.108V16a2 2 0 002 2h12a2 2 0 002-2V8.108a2 2 0 00-.94-1.696l-6-3.75a2 2 0 00-2.12 0l-6 3.75zm2.615 2.423a1 1 0 10-1.11 1.664l5 3.333a1 1 0 001.11 0l5-3.333a1 1 0 00-1.11-1.664L10 11.798 5.555 8.835z" clip-rule="evenodd"></path>
                                </svg>
                                Sudah Dibaca
                            </span>
                            @endif

                            @if($kontak->is_displayed)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Ditampilkan di Web
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                                Disembunyikan
                            </span>
                            @endif
                        </div>

                        <div class="bg-purple-50 border-l-4 border-purple-500 rounded-lg p-4">
                            <h3 class="font-bold text-purple-900 text-lg mb-1">{{ $kontak->subjek }}</h3>
                            <p class="text-sm text-purple-700">Subjek Pesan</p>
                        </div>
                    </div>
                </div>

                <!-- Message Body -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Isi Pesan</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $kontak->pesan }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <!-- Contact Info Card -->
            <div class="admin-card">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Kontak</h3>

                <div class="space-y-4">
                    <!-- Email -->
                    <div class="flex items-start gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 font-medium">Email</p>
                            <a href="mailto:{{ $kontak->email }}" class="text-sm text-gray-900 hover:text-purple-600 break-all">
                                {{ $kontak->email }}
                            </a>
                        </div>
                    </div>

                    <!-- Phone -->
                    @if($kontak->telepon)
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 font-medium">Telepon</p>
                            <a href="tel:{{ $kontak->telepon }}" class="text-sm text-gray-900 hover:text-green-600">
                                {{ $kontak->telepon }}
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Date -->
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 font-medium">Tanggal Dikirim</p>
                            <p class="text-sm text-gray-900">{{ $kontak->created_at->format('d M Y, H:i') }}</p>
                            <p class="text-xs text-gray-500">{{ $kontak->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="admin-card">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>

                <div class="space-y-3">
                    <!-- Reply Email Button -->
                    <a href="mailto:{{ $kontak->email }}?subject=Re: {{ $kontak->subjek }}" class="admin-btn-primary w-full justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                        Balas via Email
                    </a>

                    @if($kontak->telepon)
                    <!-- Call Button -->
                    <a href="tel:{{ $kontak->telepon }}" class="admin-btn-success w-full justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Hubungi via Telepon
                    </a>
                    @endif

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-4"></div>

                    <!-- Mark as Read/Unread -->
                    @if(!$kontak->is_read)
                    <form method="POST" action="{{ route('admin.kontak.mark-read', $kontak->id) }}">
                        @csrf
                        <button type="submit" class="admin-btn-secondary w-full justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.94 6.412A2 2 0 002 8.108V16a2 2 0 002 2h12a2 2 0 002-2V8.108a2 2 0 00-.94-1.696l-6-3.75a2 2 0 00-2.12 0l-6 3.75zm2.615 2.423a1 1 0 10-1.11 1.664l5 3.333a1 1 0 001.11 0l5-3.333a1 1 0 00-1.11-1.664L10 11.798 5.555 8.835z" clip-rule="evenodd"></path>
                            </svg>
                            Tandai Sudah Dibaca
                        </button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('admin.kontak.mark-unread', $kontak->id) }}">
                        @csrf
                        <button type="submit" class="admin-btn-secondary w-full justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            Tandai Belum Dibaca
                        </button>
                    </form>
                    @endif

                    <!-- Toggle Display -->
                    <form method="POST" action="{{ route('admin.kontak.toggle-display', $kontak->id) }}">
                        @csrf
                        <button type="submit" class="w-full justify-center {{ $kontak->is_displayed ? 'admin-btn-warning' : 'admin-btn-info' }}">
                            @if($kontak->is_displayed)
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                            Sembunyikan dari Web
                            @else
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Tampilkan di Web
                            @endif
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-4"></div>

                    <!-- Delete Button -->
                    <form method="POST" action="{{ route('admin.kontak.destroy', $kontak->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="admin-btn-danger w-full justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Pesan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="admin-card bg-gradient-to-br from-purple-50 to-blue-50 border-purple-200">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-purple-900 mb-1">Tips</h4>
                        <p class="text-xs text-purple-700 leading-relaxed">
                            Pesan yang ditampilkan di web akan muncul di halaman kontak sebagai testimoni. Pastikan pesan yang ditampilkan sesuai dan sopan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
