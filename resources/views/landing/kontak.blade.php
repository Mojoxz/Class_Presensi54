@extends('layouts.landing')

@section('title', 'Kontak - SMP 54 Surabaya')

@section('content')
<!-- Hero Section -->
<section class="bg-blue-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">Hubungi Kami</h1>
            <p class="text-xl">Kami siap membantu Anda</p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>

                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="bg-blue-500 text-white p-3 rounded-full mr-4 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Alamat</h3>
                            <p class="text-gray-600">
                                Jl. Raya Gubeng No. 54<br>
                                Gubeng, Surabaya<br>
                                Jawa Timur 60281
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-green-500 text-white p-3 rounded-full mr-4 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Telepon</h3>
                            <p class="text-gray-600">
                                (031) 567-8901<br>
                                (031) 567-8902
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-purple-500 text-white p-3 rounded-full mr-4 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Email</h3>
                            <p class="text-gray-600">
                                info@smp54.sch.id<br>
                                admin@smp54.sch.id
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-yellow-500 text-white p-3 rounded-full mr-4 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Jam Operasional</h3>
                            <p class="text-gray-600">
                                Senin - Jumat: 07:00 - 15:00<br>
                                Sabtu: 07:00 - 12:00<br>
                                Minggu: Tutup
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>

                <form class="space-y-6" action="#" method="POST">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Lengkap
                        </label>
                        <input type="text" id="name" name="name" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Nomor Telepon
                        </label>
                        <input type="tel" id="phone" name="phone"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">
                            Subjek
                        </label>
                        <input type="text" id="subject" name="subject" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                            Pesan
                        </label>
                        <textarea id="message" name="message" rows="6" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md transition duration-150">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map Section (Optional) -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Lokasi Kami</h2>
            <p class="text-gray-600">SMP 54 Surabaya terletak di lokasi strategis di pusat kota</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-4">
            <!-- Placeholder for map - you can integrate with Google Maps or other map services -->
            <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <p class="text-gray-500">
                        Peta lokasi SMP 54 Surabaya<br>
                        <span class="text-sm">Integrasi dengan Google Maps dapat ditambahkan di sini</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
