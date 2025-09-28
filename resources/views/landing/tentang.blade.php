@extends('layouts.landing')

@section('title', 'Tentang Kami - SMP 54 Surabaya')

@section('content')
<!-- Hero Section -->
<section class="bg-blue-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">Tentang SMP 54 Surabaya</h1>
            <p class="text-xl">Mengenal lebih dekat sekolah kami</p>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Sejarah Singkat</h2>
                <p class="text-gray-600 mb-4">
                    SMP 54 Surabaya didirikan pada tahun 1985 dengan visi untuk menjadi lembaga pendidikan yang unggul dalam membentuk karakter dan prestasi siswa. Selama lebih dari 35 tahun, sekolah ini telah berkomitmen untuk memberikan pendidikan berkualitas tinggi.
                </p>
                <p class="text-gray-600 mb-4">
                    Dengan tenaga pengajar yang profesional dan berpengalaman, serta fasilitas yang memadai, SMP 54 Surabaya terus berupaya menghasilkan lulusan yang siap menghadapi tantangan masa depan.
                </p>
            </div>
            <div class="bg-gray-100 p-8 rounded-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Visi & Misi</h3>
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-blue-600 mb-2">Visi</h4>
                    <p class="text-gray-600">
                        Menjadi sekolah unggulan yang menghasilkan siswa berakhlak mulia, berprestasi, dan siap menghadapi tantangan global.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-blue-600 mb-2">Misi</h4>
                    <ul class="text-gray-600 space-y-1">
                        <li>• Menyelenggarakan pendidikan yang berkualitas</li>
                        <li>• Mengembangkan karakter siswa yang berakhlak mulia</li>
                        <li>• Meningkatkan prestasi akademik dan non-akademik</li>
                        <li>• Mempersiapkan siswa untuk masa depan yang cerah</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">SMP 54 dalam Angka</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">35+</div>
                <p class="text-gray-600">Tahun Pengalaman</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">900+</div>
                <p class="text-gray-600">Siswa Aktif</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">45</div>
                <p class="text-gray-600">Tenaga Pengajar</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">27</div>
                <p class="text-gray-600">Kelas</p>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Fasilitas Sekolah</h2>
            <p class="text-gray-600">Fasilitas lengkap untuk mendukung proses pembelajaran</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="bg-blue-500 text-white p-3 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Perpustakaan</h3>
                <p class="text-gray-600">Koleksi buku lengkap dan ruang baca nyaman</p>
            </div>

            <div class="text-center p-6">
                <div class="bg-green-500 text-white p-3 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Lab Komputer</h3>
                <p class="text-gray-600">Laboratorium komputer dengan peralatan modern</p>
            </div>

            <div class="text-center p-6">
                <div class="bg-purple-500 text-white p-3 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Lab IPA</h3>
                <p class="text-gray-600">Laboratorium IPA untuk praktikum siswa</p>
            </div>

            <div class="text-center p-6">
                <div class="bg-red-500 text-white p-3 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Lapangan Olahraga</h3>
                <p class="text-gray-600">Fasilitas olahraga untuk berbagai aktivitas</p>
            </div>

            <div class="text-center p-6">
                <div class="bg-yellow-500 text-white p-3 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-5 9v6m-5-6h10a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1v-8a1 1 0 011-1z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Kantin Sekolah</h3>
                <p class="text-gray-600">Kantin bersih dengan makanan sehat</p>
            </div>

            <div class="text-center p-6">
                <div class="bg-indigo-500 text-white p-3 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Ruang Kelas</h3>
                <p class="text-gray-600">Ruang kelas nyaman dengan AC dan proyektor</p>
            </div>
        </div>
    </div>
</section>
@endsection
