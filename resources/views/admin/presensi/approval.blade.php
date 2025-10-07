@extends('layouts.admin')

@section('page-title', 'Approval Presensi')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Approval Pengajuan Izin & Sakit</h2>
    <p class="text-gray-600 mt-1">Kelola persetujuan pengajuan izin dan sakit dari siswa</p>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Menunggu</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $statistik['pending'] }}</p>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Disetujui</p>
                <p class="text-3xl font-bold text-green-600">{{ $statistik['approved'] }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Ditolak</p>
                <p class="text-3xl font-bold text-red-600">{{ $statistik['rejected'] }}</p>
            </div>
            <div class="p-3 bg-red-100 rounded-full">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total</p>
                <p class="text-3xl font-bold text-blue-600">{{ $statistik['total'] }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="bg-white shadow rounded-lg mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
            <a href="{{ route('admin.presensi.approval', ['filter' => 'pending'] + request()->except('filter')) }}"
               class="px-6 py-3 text-sm font-medium border-b-2 {{ $filter === 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Menunggu Persetujuan
            </a>
            <a href="{{ route('admin.presensi.approval', ['filter' => 'approved'] + request()->except('filter')) }}"
               class="px-6 py-3 text-sm font-medium border-b-2 {{ $filter === 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Disetujui
            </a>
            <a href="{{ route('admin.presensi.approval', ['filter' => 'rejected'] + request()->except('filter')) }}"
               class="px-6 py-3 text-sm font-medium border-b-2 {{ $filter === 'rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Ditolak
            </a>
            <a href="{{ route('admin.presensi.approval', ['filter' => 'all'] + request()->except('filter')) }}"
               class="px-6 py-3 text-sm font-medium border-b-2 {{ $filter === 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Semua
            </a>
        </nav>
    </div>

    <!-- Filter Form -->
    <div class="p-4">
        <form method="GET" action="{{ route('admin.presensi.approval') }}" class="flex flex-wrap items-end gap-4">
            <input type="hidden" name="filter" value="{{ $filter }}">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                       class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                <select name="tipe" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="izin" {{ request('tipe') == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ request('tipe') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Filter
                </button>
                <a href="{{ route('admin.presensi.approval', ['filter' => $filter]) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Daftar Pengajuan -->
<div class="bg-white shadow rounded-lg">
    @if($pengajuan->count() > 0)
        <div class="divide-y divide-gray-200">
            @foreach($pengajuan as $item)
                <div class="p-6 hover:bg-gray-50 transition" id="pengajuan-{{ $item->id }}">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <!-- Info Siswa & Pengajuan -->
                        <div class="flex-1">
                            <div class="flex items-start gap-4 mb-4">
                                <!-- Avatar -->
                                <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if($item->user->foto_profil)
                                        <img src="{{ asset('storage/' . $item->user->foto_profil) }}" alt="{{ $item->user->name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $item->user->name }}</h3>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $item->status === 'izin' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $item->user->nis }} • {{ $item->user->kelas->nama_kelas ?? '-' }}</p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <span class="font-medium">Tanggal:</span> {{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <span class="font-medium">Diajukan:</span> {{ $item->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            <!-- Alasan -->
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-700 mb-1">Alasan:</p>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-md">{{ $item->alasan }}</p>
                            </div>

                            <!-- Foto Bukti -->
                            @if($item->foto_bukti)
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Foto Bukti:</p>
                                    <img src="{{ asset('storage/' . $item->foto_bukti) }}"
                                         alt="Foto Bukti"
                                         class="w-64 h-48 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-75 transition"
                                         onclick="openImageModal('{{ asset('storage/' . $item->foto_bukti) }}', 'Foto Bukti {{ ucfirst($item->status) }} - {{ $item->user->name }}')">
                                </div>
                            @endif

                            <!-- Status Approval -->
                            @if($item->approval_status === 'approved')
                                <div class="flex items-center gap-2 text-green-700 bg-green-50 p-3 rounded-md">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Disetujui oleh {{ $item->approver->name ?? 'Admin' }}</p>
                                        <p class="text-sm">{{ $item->approved_at->format('d F Y H:i') }}</p>
                                    </div>
                                </div>
                            @elseif($item->approval_status === 'rejected')
                                <div class="text-red-700 bg-red-50 p-3 rounded-md">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="font-medium">Ditolak oleh {{ $item->rejecter->name ?? 'Admin' }}</p>
                                            <p class="text-sm">{{ $item->rejected_at->format('d F Y H:i') }}</p>
                                        </div>
                                    </div>
                                    @if($item->alasan_penolakan)
                                        <p class="text-sm mt-2"><span class="font-medium">Alasan:</span> {{ $item->alasan_penolakan }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        @if($item->approval_status === 'pending')
                            <div class="flex md:flex-col gap-2 md:w-32 flex-shrink-0">
                                <button onclick="approveModal({{ $item->id }}, '{{ $item->user->name }}', '{{ ucfirst($item->status) }}')"
                                        class="flex-1 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md font-medium flex items-center justify-center gap-2 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm">Setujui</span>
                                </button>
                                <button onclick="rejectModal({{ $item->id }}, '{{ $item->user->name }}', '{{ ucfirst($item->status) }}')"
                                        class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-medium flex items-center justify-center gap-2 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="text-sm">Tolak</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="px-6 py-3 border-t border-gray-200">
            {{ $pengajuan->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pengajuan</h3>
            <p class="text-gray-500">Tidak ada pengajuan untuk filter yang dipilih</p>
        </div>
    @endif
</div>

<!-- Modal Approve -->
<div id="approveModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Konfirmasi Persetujuan</h3>
        <p class="text-gray-600 mb-6">
            Apakah Anda yakin ingin menyetujui pengajuan <span id="approveTipe" class="font-medium"></span> dari
            <span id="approveName" class="font-medium"></span>?
        </p>
        <div class="flex gap-3 justify-end">
            <button onclick="closeApproveModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded font-medium">
                Batal
            </button>
            <button onclick="confirmApprove()" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded font-medium">
                Ya, Setujui
            </button>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Konfirmasi Penolakan</h3>
        <p class="text-gray-600 mb-4">
            Anda akan menolak pengajuan <span id="rejectTipe" class="font-medium"></span> dari
            <span id="rejectName" class="font-medium"></span>
        </p>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
            <textarea id="alasanPenolakan"
                      rows="4"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-red-500"
                      placeholder="Jelaskan alasan penolakan (minimal 10 karakter)"></textarea>
            <p id="rejectError" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>
        <div class="flex gap-3 justify-end">
            <button onclick="closeRejectModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded font-medium">
                Batal
            </button>
            <button onclick="confirmReject()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded font-medium">
                Ya, Tolak
            </button>
        </div>
    </div>
</div>

<!-- Modal Image -->
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
let currentPengajuanId = null;

// Modal Functions
function approveModal(id, name, tipe) {
    currentPengajuanId = id;
    document.getElementById('approveName').textContent = name;
    document.getElementById('approveTipe').textContent = tipe;
    document.getElementById('approveModal').classList.remove('hidden');
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
    currentPengajuanId = null;
}

function rejectModal(id, name, tipe) {
    currentPengajuanId = id;
    document.getElementById('rejectName').textContent = name;
    document.getElementById('rejectTipe').textContent = tipe;
    document.getElementById('alasanPenolakan').value = '';
    document.getElementById('rejectError').classList.add('hidden');
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    currentPengajuanId = null;
}

// Approve Action
async function confirmApprove() {
    if (!currentPengajuanId) return;

    try {
        const response = await fetch(`/admin/presensi/${currentPengajuanId}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
            }
        });

        const data = await response.json();

        if (data.success) {
            showAlert('success', data.message);
            closeApproveModal();

            // Remove atau update element
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showAlert('error', data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat memproses persetujuan');
    }
}

// Reject Action
async function confirmReject() {
    if (!currentPengajuanId) return;

    const alasan = document.getElementById('alasanPenolakan').value.trim();
    const errorEl = document.getElementById('rejectError');

    if (alasan.length < 10) {
        errorEl.textContent = 'Alasan penolakan minimal 10 karakter';
        errorEl.classList.remove('hidden');
        return;
    }

    errorEl.classList.add('hidden');

    try {
        const response = await fetch(`/admin/presensi/${currentPengajuanId}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                alasan_penolakan: alasan
            })
        });

        const data = await response.json();

        if (data.success) {
            showAlert('success', data.message);
            closeRejectModal();

            // Reload page
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

// Close modals on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeApproveModal();
        closeRejectModal();
        closeImageModal();
    }
});

// Prevent image modal from closing when clicking on image
document.getElementById('imageModal')?.addEventListener('click', function(e) {
    if (e.target.id === 'imageModal') {
        closeImageModal();
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
