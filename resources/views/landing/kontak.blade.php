@extends('layouts.landing')

@section('title', 'Kontak - SMP 54 Surabaya')

@section('content')

<style>
    /* Custom map styles */
    #map {
        z-index: 1;
    }

    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .leaflet-popup-tip {
        box-shadow: 0 3px 14px rgba(0, 0, 0, 0.1);
    }

    .custom-marker {
        background: transparent;
        border: none;
    }

    /* Zoom controls styling */
    .leaflet-control-zoom {
        border: none !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }

    .leaflet-control-zoom a {
        background: white !important;
        color: #7c3aed !important;
        border: none !important;
        font-weight: bold !important;
    }

    .leaflet-control-zoom a:hover {
        background: #f3f4f6 !important;
    }

    /* Comment/Message Card Styles - Blogspot Inspired */
    .comment-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        padding: 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .comment-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, #9333ea, #f59e0b);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .comment-card:hover {
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        border-color: rgba(147, 51, 234, 0.3);
        transform: translateY(-4px);
    }

    .comment-card:hover::before {
        transform: scaleY(1);
    }

    .comment-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #9333ea 0%, #f59e0b 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 22px;
        box-shadow: 0 4px 12px rgba(147, 51, 234, 0.3);
        flex-shrink: 0;
    }

    .comment-header {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 16px;
    }

    .comment-meta {
        flex: 1;
        min-width: 0;
    }

    .comment-author {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 4px 0;
        line-height: 1.3;
    }

    .comment-date {
        font-size: 13px;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .comment-subject {
        display: inline-block;
        padding: 6px 12px;
        background: linear-gradient(135deg, #faf5ff 0%, #fef3c7 100%);
        border: 1px solid #e9d5ff;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #7c3aed;
        margin-bottom: 12px;
    }

    .comment-body {
        color: #4b5563;
        line-height: 1.7;
        font-size: 15px;
        margin-bottom: 16px;
    }

    .comment-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-top: 12px;
        border-top: 1px solid #f3f4f6;
    }

    .comment-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
    }

    .comment-action-btn.reply {
        background: #f0f9ff;
        color: #0284c7;
        border: 1px solid #e0f2fe;
    }

    .comment-action-btn.reply:hover {
        background: #e0f2fe;
        border-color: #0284c7;
    }

    .comment-action-btn.call {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #dcfce7;
    }

    .comment-action-btn.call:hover {
        background: #dcfce7;
        border-color: #16a34a;
    }

    /* Empty State */
    .empty-comments {
        text-align: center;
        padding: 60px 20px;
        background: linear-gradient(135deg, #faf5ff 0%, #fef3c7 100%);
        border-radius: 16px;
        border: 2px dashed #e5e7eb;
    }

    .empty-comments svg {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        opacity: 0.3;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

<!-- Hero Section -->
<section class="relative min-h-screen overflow-hidden">
    <!-- Background Image Layer -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/gambar6.jpg') }}"
             alt="Gedung SMP 54 Surabaya"
             class="w-full h-full object-cover"
             onerror="this.style.display='none'; this.parentElement.style.background='linear-gradient(135deg, #9333ea 0%, #f59e0b 100%)';">
        <!-- Dark overlay for better text readability -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/80 via-purple-800/75 to-amber-900/70"></div>
    </div>

    <!-- Floating shapes -->
    <div class="absolute inset-0 z-[1] overflow-hidden pointer-events-none">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
    </div>

    <!-- Content -->
    <div class="container-custom relative z-10 py-20">
        <div class="text-center space-y-8">
            <!-- Badge -->
            <div class="animate-fade-in-down" style="animation-delay: 0.1s;">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/90 backdrop-blur-md rounded-full border border-white/30 shadow-lg">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                    </span>
                    <span class="text-sm font-medium text-gray-700">Hubungi Kami</span>
                </span>
            </div>

            <!-- Main Heading -->
            <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 tracking-tight">
                    <span class="block text-white drop-shadow-lg">Kontak</span>
                    <span class="block gradient-text-light drop-shadow-lg">SMP 54 Surabaya</span>
                </h1>
                <div class="flex items-center justify-center gap-2 mt-4">
                    <div class="h-1 w-12 bg-gradient-to-r from-white/80 to-transparent rounded-full"></div>
                    <div class="h-1 w-12 bg-gradient-to-r from-amber-400 via-purple-400 to-transparent rounded-full"></div>
                </div>
            </div>

            <!-- Description -->
            <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                <p class="text-xl md:text-2xl text-white/95 max-w-3xl mx-auto leading-relaxed drop-shadow-md">
                    Kami Siap Membantu Anda Dengan<br class="hidden md:block">
                    <span class="font-semibold text-amber-200">Pelayanan Terbaik</span> dan
                    <span class="font-semibold text-amber-200">Respon Cepat</span>
                </p>
            </div>

            <!-- Stats -->
            <div class="animate-fade-in-up grid grid-cols-3 gap-4 md:gap-8 max-w-3xl mx-auto pt-8" style="animation-delay: 0.4s;">
                <div class="text-center bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20">
                    <div class="text-xl md:text-3xl font-bold text-amber-300">24/7</div>
                    <div class="text-xs md:text-sm text-white/90 mt-1">Layanan Online</div>
                </div>
                <div class="text-center bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20">
                    <div class="text-xl md:text-3xl font-bold text-amber-300"><1h</div>
                    <div class="text-xs md:text-sm text-white/90 mt-1">Respon Time</div>
                </div>
                <div class="text-center bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20">
                    <div class="text-xl md:text-3xl font-bold text-amber-300">100%</div>
                    <div class="text-xs md:text-sm text-white/90 mt-1">Satisfaction</div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<!-- Contact Section -->
<section class="py-20 md:py-32 bg-white relative">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Contact Info -->
            <div class="animate-on-scroll">
                <div class="mb-12">
                    <span class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-4">Informasi Kontak</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Hubungi <span class="gradient-text">Kami</span>
                    </h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Tim kami siap melayani dan menjawab semua pertanyaan Anda tentang SMP 54 Surabaya
                    </p>
                </div>

                <div class="space-y-8">
                    <!-- Address -->
                    <div class="feature-card group !flex-row !items-start gap-6 hover:shadow-lg">
                        <div class="feature-icon-wrapper bg-gradient-to-br from-purple-500 to-purple-600 flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Alamat Sekolah</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Jl. Kyai Tambak Deres No.293<br>
                                 Bulak, Kec. Bulak<br>
                                Surabaya, Jawa Timur 60124
                            </p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="feature-card group !flex-row !items-start gap-6 hover:shadow-lg">
                        <div class="feature-icon-wrapper bg-gradient-to-br from-green-500 to-green-600 flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Telepon</h3>
                            <p class="text-gray-600 leading-relaxed">
                                <a href="tel:031-567-8901" class="hover:text-green-600 transition-colors">(031) 567-8901</a><br>
                                <a href="tel:031-567-8902" class="hover:text-green-600 transition-colors">(031) 567-8902</a>
                            </p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="feature-card group !flex-row !items-start gap-6 hover:shadow-lg">
                        <div class="feature-icon-wrapper bg-gradient-to-br from-amber-500 to-yellow-500 flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Email</h3>
                            <p class="text-gray-600 leading-relaxed">
                                <a href="mailto:info@smp54.sch.id" class="hover:text-amber-600 transition-colors">info@smp54.sch.id</a><br>
                                <a href="mailto:admin@smp54.sch.id" class="hover:text-amber-600 transition-colors">admin@smp54.sch.id</a>
                            </p>
                        </div>
                    </div>

                    <!-- Operating Hours -->
                    <div class="feature-card group !flex-row !items-start gap-6 hover:shadow-lg">
                        <div class="feature-icon-wrapper bg-gradient-to-br from-indigo-500 to-purple-600 flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Jam Operasional</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Senin - Jumat  : 07:00 - 15:00<br>
                                Sabtu - Minggu : Tutup
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="animate-on-scroll" style="animation-delay: 0.2s;">
                <div class="news-card !p-10">
                    <div class="mb-8">
                        <span class="inline-block px-4 py-2 bg-amber-100 text-amber-700 rounded-full text-sm font-semibold mb-4">Kirim Pesan</span>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                            Mari <span class="gradient-text">Terhubung</span>
                        </h2>
                        <p class="text-gray-600">Sampaikan pesan atau pertanyaan Anda kepada kami</p>
                    </div>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg animate-fade-in-up">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-green-700 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg animate-fade-in-up">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-red-700 font-medium mb-2">Terdapat kesalahan:</p>
                                    <ul class="list-disc list-inside text-red-600 text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form class="space-y-6" action="{{ route('kontak.submit') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:border-purple-300 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:border-purple-300 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nomor Telepon
                                </label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:border-purple-300">
                            </div>
                            <div>
                                <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Subjek <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="subject" name="subject" required value="{{ old('subject') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:border-purple-300 @error('subject') border-red-500 @enderror">
                                @error('subject')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                                Pesan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" name="message" rows="6" required
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:border-purple-300 resize-none @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="group w-full inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-purple-600 via-purple-700 to-amber-500 text-white font-semibold rounded-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02] relative overflow-hidden">
                            <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                            <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            <span class="relative z-10">Kirim Pesan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pesan dari Pengunjung Section - Blogspot Style -->
@if($pesan_ditampilkan->count() > 0)
<section class="py-20 md:py-32 bg-gradient-to-b from-white to-gray-50">
    <div class="container-custom">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-4">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                {{ $pesan_ditampilkan->count() }} Komentar
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Pesan dari <span class="gradient-text">Pengunjung</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Apa yang mereka katakan tentang SMP 54 Surabaya
            </p>
        </div>

        <div class="max-w-4xl mx-auto space-y-6">
            @foreach($pesan_ditampilkan as $pesan)
            <div class="comment-card animate-on-scroll" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                <div class="comment-header">
                    <div class="comment-avatar">
                        {{ strtoupper(substr($pesan->nama, 0, 1)) }}
                    </div>
                    <div class="comment-meta">
                        <h3 class="comment-author">{{ $pesan->nama }}</h3>
                        <div class="comment-date">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $pesan->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <div class="comment-subject">
                    <svg class="w-3.5 h-3.5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    {{ $pesan->subjek }}
                </div>

                <div class="comment-body">
                    {{ $pesan->pesan }}
                </div>

                <div class="comment-actions">
                    <a href="mailto:{{ $pesan->email }}" class="comment-action-btn reply">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Balas via Email
                    </a>
                    @if($pesan->telepon)
                    <a href="tel:{{ $pesan->telepon }}" class="comment-action-btn call">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Hubungi
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
<section class="py-20 md:py-32 bg-gradient-to-b from-white to-gray-50">
    <div class="container-custom">
        <div class="max-w-3xl mx-auto">
            <div class="empty-comments animate-on-scroll">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Komentar</h3>
                <p class="text-gray-500">Jadilah yang pertama untuk meninggalkan pesan!</p>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Map Section -->
<section class="py-20 md:py-32 bg-white">
    <div class="container-custom">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold mb-4">Lokasi Kami</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Temukan <span class="gradient-text">SMP 54</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Sekolah kami terletak di lokasi strategis yang mudah dijangkau di pusat kota Surabaya
            </p>
        </div>

        <div class="animate-on-scroll">
            <div class="news-card !p-8">
                <!-- Leaflet Map -->
                <div id="map" class="w-full h-96 rounded-2xl shadow-lg relative overflow-hidden"></div>

                <!-- Map Controls -->
                <div class="mt-6 flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Kyai+Tambak+Deres+No.293+Bulak+Surabaya"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="group inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Buka di Google Maps</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=Jl.+Kyai+Tambak+Deres+No.293+Bulak+Surabaya"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="group inline-flex items-center gap-2 px-6 py-3 border-2 border-purple-600 text-purple-700 font-semibold rounded-xl hover:bg-purple-50 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <span>Dapatkan Rute</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 md:py-32 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-purple-700 to-amber-600"></div>
    <div class="absolute inset-0">
        <div class="cta-shape cta-shape-1"></div>
        <div class="cta-shape cta-shape-2"></div>
    </div>

    <div class="container-custom relative z-10">
        <div class="text-center text-white space-y-8 animate-on-scroll">
            <h2 class="text-4xl md:text-5xl font-bold">
                Siap Bergabung dengan Kami?
            </h2>
            <p class="text-xl text-purple-100 max-w-2xl mx-auto leading-relaxed">
                Daftarkan putra-putri Anda di SMP 54 Surabaya dan rasakan pendidikan berkualitas terbaik
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4">
                <a href="{{ route('student.login') }}" class="group inline-flex items-center gap-2 px-8 py-4 bg-white text-purple-700 font-semibold rounded-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Portal Siswa</span>
                </a>
                <a href="{{ route('tentang') }}" class="group inline-flex items-center gap-2 px-8 py-4 border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-purple-700 transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Tentang Kami</span>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Koordinat SMP 54 Surabaya - Bulak
        const schoolLocation = [-7.2276747808810935, 112.78512621534176];

        // Initialize map
        const map = L.map('map', {
            center: schoolLocation,
            zoom: 16,
            zoomControl: true,
            scrollWheelZoom: true
        });

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        // Custom marker icon with school colors
        const customIcon = L.divIcon({
            className: 'custom-marker',
            html: `
                <div style="position: relative;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #9333ea 0%, #f59e0b 100%); border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 3px solid white; box-shadow: 0 4px 12px rgba(147, 51, 234, 0.4);"></div>
                    <div style="position: absolute; top: 8px; left: 8px; transform: rotate(45deg);">
                        <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V7.89l7-3.11v8.21z"/>
                        </svg>
                    </div>
                </div>
            `,
            iconSize: [40, 40],
            iconAnchor: [20, 40],
            popupAnchor: [0, -40]
        });

        // Add marker with popup
        const marker = L.marker(schoolLocation, { icon: customIcon }).addTo(map);

        // Popup content
        const popupContent = `
            <div style="text-align: center; padding: 8px; min-width: 200px;">
                <h3 style="margin: 0 0 8px 0; font-size: 16px; font-weight: bold; color: #7c3aed;">
                    SMP 54 Surabaya
                </h3>
                <p style="margin: 0 0 12px 0; font-size: 13px; color: #6b7280; line-height: 1.4;">
                    Jl. Kyai Tambak Deres No.293<br>
                    Bulak, Kec. Bulak, Surabaya<br>
                    Jawa Timur 60124
                </p>
                <a href="https://www.google.com/maps/search/?api=1&query=-7.2276747808810935,112.78512621534176"
                   target="_blank"
                   style="display: inline-block; padding: 8px 16px; background: linear-gradient(135deg, #9333ea 0%, #f59e0b 100%); color: white; text-decoration: none; border-radius: 8px; font-size: 13px; font-weight: 600; transition: all 0.3s;">
                    Lihat di Google Maps →
                </a>
            </div>
        `;

        marker.bindPopup(popupContent, {
            maxWidth: 300,
            className: 'custom-popup'
        });

        // Open popup by default
        marker.openPopup();

        // Add circle to highlight school area
        L.circle(schoolLocation, {
            color: '#9333ea',
            fillColor: '#f59e0b',
            fillOpacity: 0.1,
            radius: 100
        }).addTo(map);

        // Scroll animations
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.animate-on-scroll');
            elements.forEach(el => {
                const rect = el.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight - 100;
                if (isVisible) {
                    el.classList.add('animate-in');
                }
            });
        };

        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll();
    });
</script>
@endsection
