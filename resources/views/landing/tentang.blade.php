@extends('layouts.landing')

@section('title', 'Tentang Kami - SMP 54 Surabaya')

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
                    <span class="text-sm font-medium text-gray-700">Tentang Kami</span>
                </span>
            </div>

            <!-- Main Heading -->
            <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-4 tracking-tight">
                    <span class="block">Mengenal</span>
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
                    Lebih dari 35 tahun mengabdi untuk<br class="hidden md:block">
                    <span class="font-semibold text-gray-800">Pendidikan Berkualitas</span> dan
                    <span class="font-semibold text-gray-800">Pembentukan Karakter</span>
                </p>
            </div>

            <!-- Stats -->
            <div class="animate-fade-in-up grid grid-cols-4 gap-4 md:gap-8 max-w-3xl mx-auto pt-8" style="animation-delay: 0.4s;">
                <div class="text-center">
                    <div class="text-xl md:text-3xl font-bold gradient-text">35+</div>
                    <div class="text-xs md:text-sm text-gray-600 mt-1">Tahun</div>
                </div>
                <div class="text-center">
                    <div class="text-xl md:text-3xl font-bold gradient-text">900+</div>
                    <div class="text-xs md:text-sm text-gray-600 mt-1">Siswa</div>
                </div>
                <div class="text-center">
                    <div class="text-xl md:text-3xl font-bold gradient-text">45</div>
                    <div class="text-xs md:text-sm text-gray-600 mt-1">Guru</div>
                </div>
                <div class="text-center">
                    <div class="text-xl md:text-3xl font-bold gradient-text">27</div>
                    <div class="text-xs md:text-sm text-gray-600 mt-1">Kelas</div>
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

<!-- Story Section -->
<section class="py-20 md:py-32 bg-white relative">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Story Content -->
            <div class="animate-on-scroll">
                <div class="mb-8">
                    <span class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-4">Sejarah Kami</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Perjalanan <span class="gradient-text">35 Tahun</span>
                    </h2>
                </div>

                <div class="space-y-6 text-gray-600 leading-relaxed">
                    <p class="text-lg">
                        SMP 54 Surabaya didirikan pada tahun <strong class="text-gray-900">1985</strong> dengan visi untuk menjadi lembaga pendidikan yang unggul dalam membentuk karakter dan prestasi siswa.
                    </p>
                    <p>
                        Selama lebih dari <strong class="text-gray-900">35 tahun</strong>, sekolah ini telah berkomitmen untuk memberikan pendidikan berkualitas tinggi dengan memadukan kurikulum nasional dan pengembangan karakter yang kuat.
                    </p>
                    <p>
                        Dengan <strong class="text-gray-900">tenaga pengajar yang profesional</strong> dan berpengalaman, serta fasilitas yang terus dimodernisasi, SMP 54 Surabaya terus berupaya menghasilkan lulusan yang siap menghadapi tantangan masa depan.
                    </p>
                </div>

                <!-- Timeline -->
                <div class="mt-10 space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="feature-icon-wrapper bg-gradient-to-br from-purple-500 to-purple-600 !w-10 !h-10 flex-shrink-0">
                            <span class="text-white font-bold text-sm">85</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">1985 - Pendirian</h4>
                            <p class="text-sm text-gray-600">Berdirinya SMP 54 Surabaya</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="feature-icon-wrapper bg-gradient-to-br from-amber-500 to-yellow-500 !w-10 !h-10 flex-shrink-0">
                            <span class="text-white font-bold text-sm">00</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">2000 - Modernisasi</h4>
                            <p class="text-sm text-gray-600">Pembaruan fasilitas dan kurikulum</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="feature-icon-wrapper bg-gradient-to-br from-green-500 to-green-600 !w-10 !h-10 flex-shrink-0">
                            <span class="text-white font-bold text-sm">25</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">2025 - Digital Era</h4>
                            <p class="text-sm text-gray-600">Implementasi sistem presensi digital</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visual Element -->
            <div class="animate-on-scroll" style="animation-delay: 0.2s;">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-gradient-to-br from-purple-50 to-amber-50">
                    <div class="relative h-[600px] md:h-[850px] lg:h-[1000px]">
                        <img src="{{ asset('gedung.jpg') }}"
                            alt="Gedung Sekolah SMP 54 Surabaya"
                            class="w-full h-full object-cover" />
                    </div>
                    <div class="p-8 md:p-12 text-center">
                        <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Gedung Sekolah Modern</h3>
                        <p class="text-lg md:text-xl text-gray-600">Fasilitas lengkap dan modern untuk mendukung proses pembelajaran yang optimal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision Mission Section -->
<section class="py-20 md:py-32 bg-gradient-to-b from-white to-gray-50">
    <div class="container-custom">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block px-4 py-2 bg-amber-100 text-amber-700 rounded-full text-sm font-semibold mb-4">Visi & Misi</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Komitmen <span class="gradient-text">Kami</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Landasan filosofis yang mengarahkan setiap langkah pendidikan di SMP 54 Surabaya
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Vision -->
            <div class="news-card group animate-on-scroll hover:shadow-xl">
                <div class="text-center mb-6">
                    <div class="feature-icon-wrapper bg-gradient-to-br from-purple-500 to-purple-600 !w-16 !h-16 mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Visi Sekolah</h3>
                </div>
                <div class="text-center">
                    <blockquote class="text-lg text-gray-700 italic leading-relaxed">
                        "Menjadi sekolah unggulan yang menghasilkan siswa berakhlak mulia, berprestasi, dan siap menghadapi tantangan global"
                    </blockquote>
                </div>
            </div>

            <!-- Mission -->
            <div class="news-card group animate-on-scroll hover:shadow-xl" style="animation-delay: 0.1s;">
                <div class="text-center mb-6">
                    <div class="feature-icon-wrapper bg-gradient-to-br from-amber-500 to-yellow-500 !w-16 !h-16 mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Misi Sekolah</h3>
                </div>
                <ul class="space-y-4 text-gray-700">
                    <li class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="flex-1">Menyelenggarakan pendidikan yang berkualitas</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="flex-1">Mengembangkan karakter siswa yang berakhlak mulia</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="flex-1">Meningkatkan prestasi akademik dan non-akademik</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="flex-1">Mempersiapkan siswa untuk masa depan yang cerah</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 md:py-32 bg-white relative">
    <div class="container-custom">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold mb-4">Pencapaian Kami</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                SMP 54 dalam <span class="gradient-text">Angka</span>
            </h2>
            <p class="text-lg text-gray-600">Data dan pencapaian yang membanggakan</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="feature-card group text-center animate-on-scroll hover:shadow-lg" style="animation-delay: 0.1s;">
                <div class="feature-icon-wrapper bg-gradient-to-br from-purple-500 to-purple-600 mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-3xl md:text-4xl font-bold gradient-text mb-2">35+</div>
                <p class="text-gray-600 font-medium">Tahun Pengalaman</p>
            </div>

            <div class="feature-card group text-center animate-on-scroll hover:shadow-lg" style="animation-delay: 0.2s;">
                <div class="feature-icon-wrapper bg-gradient-to-br from-amber-500 to-yellow-500 mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="text-3xl md:text-4xl font-bold gradient-text mb-2">900+</div>
                <p class="text-gray-600 font-medium">Siswa Aktif</p>
            </div>

            <div class="feature-card group text-center animate-on-scroll hover:shadow-lg" style="animation-delay: 0.3s;">
                <div class="feature-icon-wrapper bg-gradient-to-br from-green-500 to-green-600 mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="text-3xl md:text-4xl font-bold gradient-text mb-2">45</div>
                <p class="text-gray-600 font-medium">Tenaga Pengajar</p>
            </div>

            <div class="feature-card group text-center animate-on-scroll hover:shadow-lg" style="animation-delay: 0.4s;">
                <div class="feature-icon-wrapper bg-gradient-to-br from-indigo-500 to-purple-600 mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div class="text-3xl md:text-4xl font-bold gradient-text mb-2">27</div>
                <p class="text-gray-600 font-medium">Ruang Kelas</p>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section class="py-20 md:py-32 bg-gradient-to-b from-white to-gray-50">
    <div class="container-custom">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-4">Fasilitas Sekolah</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Fasilitas <span class="gradient-text">Lengkap</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Sarana dan prasarana modern untuk mendukung proses pembelajaran yang optimal
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Perpustakaan -->
            <div class="feature-card group animate-on-scroll hover:shadow-xl" style="animation-delay: 0.1s;">
                <div class="feature-icon-wrapper bg-gradient-to-br from-purple-500 to-purple-600 mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Perpustakaan</h3>
                <p class="text-gray-600 leading-relaxed">Koleksi buku lengkap dan ruang baca yang nyaman untuk mendukung pembelajaran siswa</p>
            </div>

            <!-- Lab Komputer -->
            <div class="feature-card group animate-on-scroll hover:shadow-xl" style="animation-delay: 0.2s;">
                <div class="feature-icon-wrapper bg-gradient-to-br from-green-500 to-green-600 mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Lab Komputer</h3>
                <p class="text-gray-600 leading-relaxed">Laboratorium komputer dengan peralatan modern untuk pembelajaran teknologi informasi</p>
            </div>

            <!-- Lab IPA -->
            <div class="feature-card group animate-on-scroll hover:shadow-xl" style="animation-delay: 0.3s;">
                <div class="feature-icon-wrapper bg-gradient-to-br from-amber-500 to-yellow-500 mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Lab IPA</h3>
                <p class="text-gray-600 leading-relaxed">Laboratorium IPA lengkap untuk praktikum fisika, kimia, dan biologi</p>
            </div>

            <!-- Lapangan Olahraga -->
            <div class="feature-card group animate-on-scroll hover:shadow-xl" style="animation-delay: 0.4s;">
                <div class="feature-icon-wrapper bg-gradient-to-br from-red-500 to-pink-500 mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Lapangan Olahraga</h3>
                <p class="text-gray-600 leading-relaxed">Fasilitas olahraga lengkap untuk berbagai aktivitas dan kompetisi siswa</p>
            </div>

            <!-- Kantin -->
            <div class="feature-card group animate-on-scroll hover:shadow-xl" style="animation-delay: 0.5s;">
                <div class="feature-icon-wrapper bg-gradient-to-br from-yellow-500 to-orange-500 mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-5 9v6m-5-6h10a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1v-8a1 1 0 011-1z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kantin Sekolah</h3>
                <p class="text-gray-600 leading-relaxed">Kantin bersih dan sehat dengan berbagai pilihan makanan bergizi</p>
            </div>

            <!-- Ruang Kelas -->
            <div class="feature-card group animate-on-scroll hover:shadow-xl" style="animation-delay: 0.6s;">
                <div class="feature-icon-wrapper bg-gradient-to-br from-indigo-500 to-blue-600 mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Ruang Kelas</h3>
                <p class="text-gray-600 leading-relaxed">Ruang kelas modern dengan AC dan proyektor untuk kenyamanan belajar</p>
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
                Bergabunglah dengan Keluarga Besar Kami
            </h2>
            <p class="text-xl text-purple-100 max-w-2xl mx-auto leading-relaxed">
                Wujudkan masa depan cerah putra-putri Anda bersama SMP 54 Surabaya
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4">
                <a href="{{ route('student.login') }}" class="group inline-flex items-center gap-2 px-8 py-4 bg-white text-purple-700 font-semibold rounded-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Portal Siswa</span>
                </a>
                <a href="{{ route('kontak') }}" class="group inline-flex items-center gap-2 px-8 py-4 border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-purple-700 transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>Hubungi Kami</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
