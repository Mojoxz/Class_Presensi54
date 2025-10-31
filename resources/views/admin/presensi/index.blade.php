@extends('layouts.admin')

@section('page-title', 'Rekap Presensi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Rekap Presensi</h2>
    <div class="flex gap-2">
        <a href="{{ route('admin.presensi.approval') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Approval
            @php
                $pendingCount = \App\Models\Presensi::whereIn('status', ['izin', 'sakit'])->pendingApproval()->count();
            @endphp
            @if($pendingCount > 0)
                <span class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('admin.presensi.rekap') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Rekap Bulanan
        </a>
    </div>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
    <div class="bg-white shadow rounded-lg p-4">
        <div class="text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $statistik['total'] }}</div>
            <p class="text-xs text-gray-600">Total</p>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-4">
        <div class="text-center">
            <div class="text-2xl font-bold text-green-600">{{ $statistik['hadir'] }}</div>
            <p class="text-xs text-gray-600">Hadir</p>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-4">
        <div class="text-center">
            <div class="text-2xl font-bold text-yellow-600">{{ $statistik['izin'] }}</div>
            <p class="text-xs text-gray-600">Izin</p>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-4">
        <div class="text-center">
            <div class="text-2xl font-bold text-blue-400">{{ $statistik['sakit'] }}</div>
            <p class="text-xs text-gray-600">Sakit</p>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-4">
        <div class="text-center">
            <div class="text-2xl font-bold text-red-600">{{ $statistik['tidak_hadir'] }}</div>
            <p class="text-xs text-gray-600">Tidak Hadir</p>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-4">
        <div class="text-center">
            <div class="text-2xl font-bold text-orange-600">{{ $statistik['pending'] }}</div>
            <p class="text-xs text-gray-600">Pending</p>
        </div>
    </div>
</div>

<!-- Filter & Search -->
<div class="bg-white shadow rounded-lg p-4 mb-6">
    <form method="GET" action="{{ route('admin.presensi.index') }}" class="space-y-4">
        <!-- Search Bar -->
        <div class="flex gap-2">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari Siswa
                </label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama atau NIS siswa..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <!-- Filter Options -->
        <div class="flex flex-wrap items-end gap-4">
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

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Approval</label>
                <select name="approval_status" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="pending" {{ request('approval_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('approval_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('approval_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('admin.presensi.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded font-medium">
                    Reset
                </a>
            </div>
        </div>

        <!-- Active Filters Display -->
        @if(request()->hasAny(['search', 'kelas_id', 'status', 'approval_status']))
        <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-200">
            <span class="text-sm text-gray-600 font-medium">Filter Aktif:</span>

            @if(request('search'))
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                Pencarian: "{{ request('search') }}"
                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="hover:text-blue-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </span>
            @endif

            @if(request('kelas_id'))
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">
                Kelas: {{ $kelas->find(request('kelas_id'))->nama_kelas ?? '' }}
                <a href="{{ request()->fullUrlWithQuery(['kelas_id' => null]) }}" class="hover:text-purple-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </span>
            @endif

            @if(request('status'))
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                Status: {{ ucfirst(str_replace('_', ' ', request('status'))) }}
                <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="hover:text-green-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </span>
            @endif

            @if(request('approval_status'))
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">
                Approval: {{ ucfirst(request('approval_status')) }}
                <a href="{{ request()->fullUrlWithQuery(['approval_status' => null]) }}" class="hover:text-yellow-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </span>
            @endif
        </div>
        @endif
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approval</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($presensi as $item)
                        <tr id="row-{{ $item->id }}">
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
                                    @if($item->foto_bukti)
                                        <button onclick="openImageModal('{{ asset('storage/' . $item->foto_bukti) }}', 'Foto Bukti - {{ $item->user->name }}')"
                                                class="text-purple-600 hover:text-purple-800 text-xs font-medium">
                                            Bukti
                                        </button>
                                    @endif
                                    @if(!$item->foto_masuk && !$item->foto_keluar && !$item->foto_bukti)
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(in_array($item->status, ['izin', 'sakit']))
                                    @if($item->approval_status === 'approved')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            ✓ Disetujui
                                        </span>
                                    @elseif($item->approval_status === 'rejected')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            ✗ Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            ⏳ Pending
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if(in_array($item->status, ['izin', 'sakit']) && $item->approval_status === 'pending')
                                    <div class="flex gap-1">
                                        <button onclick="quickApprove({{ $item->id }}, '{{ $item->user->name }}', '{{ ucfirst($item->status) }}')"
                                                class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs font-medium"
                                                title="Setujui">
                                            ✓
                                        </button>
                                        <button onclick="quickReject({{ $item->id }}, '{{ $item->user->name }}', '{{ ucfirst($item->status) }}')"
                                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs font-medium"
                                                title="Tolak">
                                            ✗
                                        </button>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
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
            <p class="text-gray-500">
                @if(request()->hasAny(['search', 'kelas_id', 'status', 'approval_status']))
                    Tidak ada data yang sesuai dengan filter yang dipilih
                @else
                    Tidak ada data presensi untuk hari ini
                @endif
            </p>
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

<!-- Modal Quick Approve -->
<div id="quickApproveModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Konfirmasi Persetujuan</h3>
        <p class="text-gray-600 mb-6">
            Apakah Anda yakin ingin menyetujui pengajuan <span id="quickApproveTipe" class="font-medium"></span> dari
            <span id="quickApproveName" class="font-medium"></span>?
        </p>
        <div class="flex gap-3 justify-end">
            <button onclick="closeQuickApproveModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded font-medium">
                Batal
            </button>
            <button onclick="confirmQuickApprove()" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded font-medium">
                Ya, Setujui
            </button>
        </div>
    </div>
</div>

<!-- Modal Quick Reject -->
<div id="quickRejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Konfirmasi Penolakan</h3>
        <p class="text-gray-600 mb-4">
            Anda akan menolak pengajuan <span id="quickRejectTipe" class="font-medium"></span> dari
            <span id="quickRejectName" class="font-medium"></span>
        </p>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
            <textarea id="quickAlasanPenolakan"
                      rows="4"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-red-500"
                      placeholder="Jelaskan alasan penolakan (minimal 10 karakter)"></textarea>
            <p id="quickRejectError" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>
        <div class="flex gap-3 justify-end">
            <button onclick="closeQuickRejectModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded font-medium">
                Batal
            </button>
            <button onclick="confirmQuickReject()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded font-medium">
                Ya, Tolak
            </button>
        </div>
    </div>
</div>

<script>
let currentPresensiId = null;

// Image Modal
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

// Quick Approve Functions
function quickApprove(id, name, tipe) {
    currentPresensiId = id;
    document.getElementById('quickApproveName').textContent = name;
    document.getElementById('quickApproveTipe').textContent = tipe;
    document.getElementById('quickApproveModal').classList.remove('hidden');
}

function closeQuickApproveModal() {
    document.getElementById('quickApproveModal').classList.add('hidden');
    currentPresensiId = null;
}

async function confirmQuickApprove() {
    if (!currentPresensiId) return;

    try {
        const response = await fetch(`/admin/presensi/${currentPresensiId}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
            }
        });

        const data = await response.json();

        if (data.success) {
            showAlert('success', data.message);
            closeQuickApproveModal();

            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showAlert('error', data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat memproses penolakan');
    }
}

// Alert Function
function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `fixed top-4 right-4 z-50 max-w-md px-6 py-4 rounded-lg shadow-lg ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white`;
    alertDiv.innerHTML = `
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${type === 'success'
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                }
            </svg>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(alertDiv);

    setTimeout(() => {
        alertDiv.style.animation = 'slideOutRight 0.4s ease-out';
        setTimeout(() => alertDiv.remove(), 400);
    }, 3000);
}

// Prevent modal from closing when clicking on image
document.getElementById('imageModal')?.addEventListener('click', function(e) {
    if (e.target.id === 'imageModal') {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
        closeQuickApproveModal();
        closeQuickRejectModal();
    }
});
</script>

<style>
@keyframes slideOutRight {
    from {
        opacity: 1;
        transform: translateX(0);
    }
    to {
        opacity: 0;
        transform: translateX(100px);
    }
}
</style>
@endsection
