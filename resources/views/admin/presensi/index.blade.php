@extends('layouts.admin')

@section('page-title', 'Rekap Presensi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Rekap Presensi</h2>
    <a href="{{ route('admin.presensi.rekap') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        Rekap Bulanan
    </a>
</div>

<!-- Filter -->
<div class="bg-white shadow rounded-lg p-4 mb-6">
    <form method="GET" action="{{ route('admin.presensi.index') }}" class="flex flex-wrap items-center gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}"
                   class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <select name="kelas_id" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Semua Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="tidak_hadir" {{ request('status') == 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mr-2">
                Filter
            </button>
            <a href="{{ route('admin.presensi.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    @if($presensi->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Keluar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($presensi as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $item->user->nis }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $item->user->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $item->status === 'hadir' ? 'bg-green-100 text-green-800' :
                                       ($item->status === 'izin' ? 'bg-yellow-100 text-yellow-800' :
                                        ($item->status === 'sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->jam_keluar ? \Carbon\Carbon::parse($item->jam_keluar)->format('H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex gap-2">
                                    @if($item->foto_masuk)
                                        <button onclick="openImageModal('{{ asset('storage/' . $item->foto_masuk) }}', 'Foto Masuk - {{ $item->user->name }}')"
                                                class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                            Masuk
                                        </button>
                                    @endif
                                    @if($item->foto_keluar)
                                        <button onclick="openImageModal('{{ asset('storage/' . $item->foto_keluar) }}', 'Foto Keluar - {{ $item->user->name }}')"
                                                class="text-green-600 hover:text-green-800 text-xs font-medium">
                                            Keluar
                                        </button>
                                    @endif
                                    @if(!$item->foto_masuk && !$item->foto_keluar)
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-3 border-t border-gray-200">
            {{ $presensi->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data presensi</h3>
            <p class="text-gray-500">Tidak ada data presensi untuk filter yang dipilih</p>
        </div>
    @endif
</div>

<!-- Modal untuk melihat foto -->
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
