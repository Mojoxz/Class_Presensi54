@extends('layouts.student')

@section('page-title', 'Presensi')

@section('content')
<!-- Current Time Card -->
<div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-xl p-6 mb-8 text-white">
    <div class="text-center">
        <h2 class="text-2xl font-bold mb-2">Presensi Siswa</h2>
        <p class="text-blue-100 mb-4">{{ auth()->user()->name }} - Kelas {{ auth()->user()->kelas->nama_kelas ?? '-' }}</p>
        <div class="text-5xl font-bold mb-2" id="current-time"></div>
        <div class="text-lg" id="current-date"></div>
    </div>
</div>

<!-- Presensi Actions -->
<div class="bg-white rounded-xl shadow-xl p-6 mb-8">
    <h3 class="text-xl font-semibold text-gray-900 mb-6">Presensi Hari Ini</h3>

    @if($presensiHariIni)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Status Presensi Masuk -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border-2 border-green-300 shadow-md">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    <h4 class="text-lg font-bold text-green-900 mb-2">Presensi Masuk</h4>
                    <p class="text-green-700 mb-2">Status: <span class="font-semibold capitalize">{{ $presensiHariIni->status }}</span></p>
                    <p class="text-2xl font-bold text-green-800 mb-3">
                        {{ $presensiHariIni->jam_masuk ? $presensiHariIni->jam_masuk->format('H:i:s') : '-' }}
                    </p>

                    @if($presensiHariIni->foto_masuk)
                        <div class="mt-4">
                            <img src="{{ asset('storage/' . $presensiHariIni->foto_masuk) }}"
                                 alt="Foto Masuk"
                                 class="w-32 h-32 object-cover rounded-lg mx-auto border-4 border-green-300 shadow-lg cursor-pointer hover:scale-105 transition-transform"
                                 onclick="showImageModal('{{ asset('storage/' . $presensiHariIni->foto_masuk) }}')">
                            <p class="text-xs text-green-600 mt-2">Klik untuk memperbesar</p>
                        </div>
                    @endif

                    @if($presensiHariIni->keterangan)
                        <div class="mt-4 p-3 bg-yellow-100 border border-yellow-300 rounded-lg">
                            <p class="text-sm text-yellow-800">
                                <span class="font-medium">⚠️ {{ $presensiHariIni->keterangan }}</span>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Status Presensi Keluar -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border-2 {{ $presensiHariIni->jam_keluar ? 'border-purple-300' : 'border-gray-300' }} shadow-md">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-20 h-20 bg-gradient-to-br {{ $presensiHariIni->jam_keluar ? 'from-purple-400 to-purple-600' : 'from-gray-300 to-gray-400' }} rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    <h4 class="text-lg font-bold {{ $presensiHariIni->jam_keluar ? 'text-purple-900' : 'text-gray-700' }} mb-2">Presensi Keluar</h4>

                    @if($presensiHariIni->jam_keluar)
                        <p class="text-2xl font-bold text-purple-800 mb-3">
                            {{ $presensiHariIni->jam_keluar->format('H:i:s') }}
                        </p>

                        @if($presensiHariIni->foto_keluar)
                            <div class="mt-4">
                                <img src="{{ asset('storage/' . $presensiHariIni->foto_keluar) }}"
                                     alt="Foto Keluar"
                                     class="w-32 h-32 object-cover rounded-lg mx-auto border-4 border-purple-300 shadow-lg cursor-pointer hover:scale-105 transition-transform"
                                     onclick="showImageModal('{{ asset('storage/' . $presensiHariIni->foto_keluar) }}')">
                                <p class="text-xs text-purple-600 mt-2">Klik untuk memperbesar</p>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-500 mb-4">Belum presensi keluar</p>

                        @if($bolehKeluar)
                            <button onclick="openCameraModal('keluar')" class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Presensi Keluar
                            </button>
                        @else
                            <div class="bg-gray-100 border border-gray-300 rounded-lg p-4">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-gray-600 font-medium">Presensi keluar hanya bisa dilakukan</p>
                                <p class="text-sm text-gray-600">antara jam 14:00 - 18:00</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-8">
            @if($bolehMasuk)
                <div class="mb-6">
                    <svg class="w-24 h-24 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7l2 2 4-4"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Presensi</h3>
                    <p class="text-gray-600 mb-6">Silakan lakukan presensi masuk untuk hari ini</p>
                </div>

                <button onclick="openCameraModal('masuk')" class="bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Presensi Masuk Sekarang
                </button>

                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg max-w-md mx-auto">
                    <p class="text-sm text-blue-800">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <strong>Info:</strong> Batas tepat waktu jam 07:30. Presensi masuk tersedia jam 06:00 - 08:30
                    </p>
                </div>
            @else
                <div class="bg-red-50 border-2 border-red-200 rounded-xl p-8 max-w-md mx-auto">
                    <svg class="w-20 h-20 text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-red-900 mb-2">Presensi Ditutup</h3>
                    <p class="text-red-700 mb-4">Presensi masuk hanya bisa dilakukan antara jam 06:00 - 08:30</p>
                    <p class="text-sm text-red-600">Silakan hubungi admin jika ada kendala</p>
                </div>
            @endif
        </div>
    @endif
</div>

<!-- Riwayat Presensi -->
<div class="bg-white rounded-xl shadow-xl p-6">
    <h3 class="text-xl font-semibold text-gray-900 mb-6">📋 Riwayat Presensi Bulan Ini</h3>

    @if($presensiRiwayat->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jam Masuk</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jam Keluar</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($presensiRiwayat as $presensi)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $presensi->tanggal->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full
                                    {{ $presensi->status === 'hadir' ? 'bg-green-100 text-green-800' :
                                       ($presensi->status === 'izin' ? 'bg-yellow-100 text-yellow-800' :
                                        ($presensi->status === 'sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $presensi->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $presensi->jam_masuk ? $presensi->jam_masuk->format('H:i:s') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $presensi->jam_keluar ? $presensi->jam_keluar->format('H:i:s') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    @if($presensi->foto_masuk)
                                        <img src="{{ asset('storage/' . $presensi->foto_masuk) }}"
                                             alt="Masuk"
                                             class="w-10 h-10 object-cover rounded cursor-pointer hover:scale-110 transition-transform border-2 border-green-300"
                                             onclick="showImageModal('{{ asset('storage/' . $presensi->foto_masuk) }}')"
                                             title="Foto Masuk">
                                    @endif
                                    @if($presensi->foto_keluar)
                                        <img src="{{ asset('storage/' . $presensi->foto_keluar) }}"
                                             alt="Keluar"
                                             class="w-10 h-10 object-cover rounded cursor-pointer hover:scale-110 transition-transform border-2 border-purple-300"
                                             onclick="showImageModal('{{ asset('storage/' . $presensi->foto_keluar) }}')"
                                             title="Foto Keluar">
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $presensi->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <p class="text-gray-500 text-lg">Belum ada riwayat presensi bulan ini</p>
        </div>
    @endif
</div>

<!-- Modal Kamera -->
<div id="cameraModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900">Ambil Foto Presensi</h3>
            <button onclick="closeCameraModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="relative">
            <video id="camera" class="w-full rounded-lg bg-gray-900" autoplay playsinline></video>
            <canvas id="canvas" class="hidden"></canvas>

            <div id="capturedImage" class="hidden">
                <img id="photo" src="" alt="Captured" class="w-full rounded-lg">
            </div>
        </div>

        <div class="mt-4 flex justify-center gap-4">
            <button id="captureBtn" onclick="capturePhoto()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Ambil Foto
            </button>

            <button id="retakeBtn" onclick="retakePhoto()" class="hidden bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Ambil Ulang
            </button>

            <button id="submitBtn" onclick="submitPresensi()" class="hidden bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Kirim Presensi
            </button>
        </div>

        <div id="loadingIndicator" class="hidden mt-4 text-center">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-blue-600 border-t-transparent"></div>
            <p class="mt-2 text-gray-600">Memproses presensi...</p>
        </div>
    </div>
</div>

<!-- Modal untuk melihat gambar -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="modalImage" src="" alt="Preview" class="max-w-full max-h-screen rounded-lg shadow-2xl">
    </div>
</div>

<script>
    let stream = null;
    let capturedImageData = null;
    let presensiType = null; // 'masuk' atau 'keluar'

    function updateDateTime() {
        const now = new Date();
        const timeOptions = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        const dateOptions = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };

        document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', timeOptions);
        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
    }

    async function openCameraModal(type) {
        presensiType = type;
        const modal = document.getElementById('cameraModal');
        const video = document.getElementById('camera');
        const capturedImage = document.getElementById('capturedImage');
        const captureBtn = document.getElementById('captureBtn');
        const retakeBtn = document.getElementById('retakeBtn');
        const submitBtn = document.getElementById('submitBtn');

        modal.classList.remove('hidden');
        capturedImage.classList.add('hidden');
        video.classList.remove('hidden');
        captureBtn.classList.remove('hidden');
        retakeBtn.classList.add('hidden');
        submitBtn.classList.add('hidden');

        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user',
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                }
            });
            video.srcObject = stream;
        } catch (err) {
            console.error('Error accessing camera:', err);
            alert('Gagal mengakses kamera. Pastikan Anda telah memberikan izin akses kamera.');
            closeCameraModal();
        }
    }

    function capturePhoto() {
        const video = document.getElementById('camera');
        const canvas = document.getElementById('canvas');
        const photo = document.getElementById('photo');
        const capturedImage = document.getElementById('capturedImage');
        const captureBtn = document.getElementById('captureBtn');
        const retakeBtn = document.getElementById('retakeBtn');
        const submitBtn = document.getElementById('submitBtn');

        // Set canvas size to match video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // Draw video frame to canvas
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Convert canvas to base64
        capturedImageData = canvas.toDataURL('image/jpeg', 0.8);

        // Show captured image
        photo.src = capturedImageData;
        video.classList.add('hidden');
        capturedImage.classList.remove('hidden');
        captureBtn.classList.add('hidden');
        retakeBtn.classList.remove('hidden');
        submitBtn.classList.remove('hidden');

        // Stop camera stream
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    }

    function retakePhoto() {
        const video = document.getElementById('camera');
        const capturedImage = document.getElementById('capturedImage');
        const captureBtn = document.getElementById('captureBtn');
        const retakeBtn = document.getElementById('retakeBtn');
        const submitBtn = document.getElementById('submitBtn');

        capturedImageData = null;
        video.classList.remove('hidden');
        capturedImage.classList.add('hidden');
        captureBtn.classList.remove('hidden');
        retakeBtn.classList.add('hidden');
        submitBtn.classList.add('hidden');

        // Restart camera
        openCameraModal(presensiType);
    }

    async function submitPresensi() {
        if (!capturedImageData) {
            alert('Silakan ambil foto terlebih dahulu');
            return;
        }

        const loadingIndicator = document.getElementById('loadingIndicator');
        const submitBtn = document.getElementById('submitBtn');
        const retakeBtn = document.getElementById('retakeBtn');

        loadingIndicator.classList.remove('hidden');
        submitBtn.disabled = true;
        retakeBtn.disabled = true;

        try {
            const url = presensiType === 'masuk'
                ? '{{ route("student.presensi.masuk") }}'
                : '{{ route("student.presensi.keluar") }}';

            const fieldName = presensiType === 'masuk' ? 'foto_masuk' : 'foto_keluar';

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    [fieldName]: capturedImageData
                })
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                closeCameraModal();
                location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan saat memproses presensi');
                submitBtn.disabled = false;
                retakeBtn.disabled = false;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim presensi');
            submitBtn.disabled = false;
            retakeBtn.disabled = false;
        } finally {
            loadingIndicator.classList.add('hidden');
        }
    }

    function closeCameraModal() {
        const modal = document.getElementById('cameraModal');
        modal.classList.add('hidden');

        // Stop camera stream
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }

        capturedImageData = null;
        presensiType = null;
    }

    function showImageModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc;
        modal.classList.remove('hidden');
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>

@if(session('success'))
<script>
    alert('{{ session("success") }}');
</script>
@endif

@if(session('error'))
<script>
    alert('{{ session("error") }}');
</script>
@endif

@endsection
