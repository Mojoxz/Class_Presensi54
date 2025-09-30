@extends('layouts.admin')

@section('page-title', 'Detail Presensi Siswa')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.presensi.rekap', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
       class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-2 mb-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Rekap
    </a>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="flex items-center gap-6">
            <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                @if($siswa->foto_profil)
                    <img src="{{ asset('storage/' . $siswa->foto_profil) }}" alt="{{ $siswa->name }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $siswa->name }}</h2>
                <p class="text-gray-600">NIS: {{ $siswa->nis }}</p>
                <p class="text-gray-600">Kelas: {{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                <p class="text-gray-600">Periode: {{ \Carbon\Carbon::create()->month((int)$bulan)->format('F') }} {{ $tahun }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Summary Stats -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-white shadow rounded-lg p-4">
        <div class="text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $statistik['total'] }}</div>
            <p class="text-sm text-gray-600">Total</p>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-4">
        <div class="text-center">
            <div class="text-2xl font-bold text-green-600">{{ $statistik['hadir'] }}</div>
            <p class="text-sm text-gray-600">Hadir</p>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-4">
        <div class="text-center">
            <div class="text-2xl font-bold text-yellow-600">{{ $statistik['izin'] }}</div>
            <p class="text-sm text-gray-600">Izin</p>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-4">
        <div class="text-center">
            <div class="text-2xl font-bold text-blue-400">{{ $statistik['sakit'] }}</div>
            <p class="text-sm text-gray-600">Sakit</p>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-4">
        <div class="text-center">
            <div class="text-2xl font-bold text-red-600">{{ $statistik['tidak_hadir'] }}</div>
            <p class="text-sm text-gray-600">Tidak Hadir</p>
        </div>
    </div>
</div>

<!-- Detail Presensi -->
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Detail Presensi Harian</h3>
    </div>

    @if($presensi->count() > 0)
        <div class="divide-y divide-gray-200">
            @foreach($presensi as $item)
                <div class="p-6 hover:bg-gray-50">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="text-lg font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}
                                </div>
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $item->status === 'hadir' ? 'bg-green-100 text-green-800' :
                                       ($item->status === 'izin' ? 'bg-yellow-100 text-yellow-800' :
                                        ($item->status === 'sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-600">Jam Masuk:</p>
                                    <p class="font-medium text-gray-900">
                                        {{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i:s') : '-' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Jam Keluar:</p>
                                    <p class="font-medium text-gray-900">
                                        {{ $item->jam_keluar ? \Carbon\Carbon::parse($item->jam_keluar)->format('H:i:s') : '-' }}
                                    </p>
                                </div>
                            </div>

                            @if($item->keterangan)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600">Keterangan:</p>
                                    <p class="text-gray-900">{{ $item->keterangan }}</p>
                                </div>
                            @endif

                            <!-- Foto Presensi -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($item->foto_masuk)
                                    <div>
                                        <p class="text-sm text-gray-600 mb-2">Foto Masuk:</p>
                                        <img src="{{ asset('storage/' . $item->foto_masuk) }}"
                                             alt="Foto Masuk"
                                             class="w-full h-48 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-75 transition"
                                             onclick="openImageModal('{{ asset('storage/' . $item->foto_masuk) }}', 'Foto Masuk - {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}')">
                                    </div>
                                @endif

                                @if($item->foto_keluar)
                                    <div>
                                        <p class="text-sm text-gray-600 mb-2">Foto Keluar:</p>
                                        <img src="{{ asset('storage/' . $item->foto_keluar) }}"
                                             alt="Foto Keluar"
                                             class="w-full h-48 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-75 transition"
                                             onclick="openImageModal('{{ asset('storage/' . $item->foto_keluar) }}', 'Foto Keluar - {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}')">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data presensi</h3>
            <p class="text-gray-500">Belum ada data presensi untuk periode ini</p>
        </div>
    @endif
</div>

<!-- Modal untuk melihat foto full size -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-screen rounded-lg">
        <p id="modalCaption" class="text-white text-center mt-4 text-lg"></p>
    </div>
</div>

<script>
function openImageModal(imageSrc, caption) {
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalCaption').textContent = caption;
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Prevent modal from closing when clicking on image
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target.id === 'imageModal') {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection
