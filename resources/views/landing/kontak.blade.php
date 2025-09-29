@extends('layouts.landing')

@section('title', 'Kontak - SMP 54 Surabaya')

@section('content')
<!-- Hero Section -->
<section class="hero-section relative min-h-[60vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-50 via-purple-50 to-amber-50">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
    </div>

    <div class="container-custom relative z-10 py-20">
        <div class="text-center space-y-8">
            <!-- Badge -->
            <div class="animate-fade-in-down" style="animation-delay: 0.1s;">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full border border-purple-200 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                    </span>
                    <span class="text-sm font-medium text-gray-700">Hubungi Kami</span>
                </span>
            </div>

            <!-- Main Heading -->
            <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-4 tracking-tight">
                    <span class="block">Kontak</span>
                    <span class="block gradient-text">SMP 54 Surabaya</span>
                </h1>
                <div class="flex items-center justify-center gap-2 mt-4">
                    <div class="h-1 w-12 bg-gradient-to-r from-purple-600 to-transparent rounded-full"></div>
                    <div class="h-1 w-12 bg-gradient-to-r from-purple-600 via-amber-500 to-transparent rounded-full"></div>
                </div>
            </div>

            <!-- Description -->
            <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Kami siap membantu Anda dengan<br class="hidden md:block">
                    <span class="font-semibold text-gray-800">Pelayanan Terbaik</span> dan
                    <span class="font-semibold text-gray-800">Respon Cepat</span>
                </p>
            </div>

            <!-- Stats -->
            <div class="animate-fade-in-up grid grid-cols-3 gap-8 max-w-2xl mx-auto pt-8" style="animation-delay: 0.4s;">
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold gradient-text">24/7</div>
                    <div class="text-sm text-gray-600 mt-1">Layanan Online</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold gradient-text">&lt; 1h</div>
                    <div class="text-sm text-gray-600 mt-1">Respon Time</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold gradient-text">100%</div>
                    <div class="text-sm text-gray-600 mt-1">Satisfaction</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                Jl. Raya Gubeng No. 54<br>
                                Gubeng, Surabaya<br>
                                Jawa Timur 60281
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
                                Senin - Jumat: 07:00 - 15:00<br>
                                Sabtu: 07:00 - 12:00<br>
                                Minggu: Tutup
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

                    <form class="space-y-6" action="#" method="POST">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap
                                </label>
                                <input type="text" id="name" name="name" required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:border-purple-300">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email
                                </label>
                                <input type="email" id="email" name="email" required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:border-purple-300">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nomor Telepon
                                </label>
                                <input type="tel" id="phone" name="phone"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:border-purple-300">
                            </div>
                            <div>
                                <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Subjek
                                </label>
                                <input type="text" id="subject" name="subject" required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:border-purple-300">
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                                Pesan
                            </label>
                            <textarea id="message" name="message" rows="6" required
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:border-purple-300 resize-none"></textarea>
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

<!-- Map Section -->
<section class="py-20 md:py-32 bg-gradient-to-b from-white to-gray-50">
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
                <!-- Placeholder for map - you can integrate with Google Maps or other map services -->
                <div class="w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-amber-500/10"></div>
                    <div class="text-center relative z-10">
                        <div class="feature-icon-wrapper bg-gradient-to-br from-purple-500 to-purple-600 !w-16 !h-16 mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Peta Lokasi SMP 54 Surabaya</h3>
                        <p class="text-gray-600 mb-4">
                            Jl. Raya Gubeng No. 54, Gubeng, Surabaya
                        </p>
                        <div class="text-sm text-gray-500 bg-white/80 rounded-lg p-3 inline-block">
                            <strong>Catatan:</strong> Integrasi dengan Google Maps dapat ditambahkan di sini
                        </div>
                    </div>
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
@endsection
