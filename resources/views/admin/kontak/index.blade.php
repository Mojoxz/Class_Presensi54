@extends('layouts.admin')

@section('title', 'Kelola Pesan Kontak')
@section('page-title', 'Kelola Pesan Kontak')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="admin-card bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Pesan</p>
                    <h3 class="text-3xl font-bold">{{ \App\Models\Kontak::count() }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="admin-card bg-gradient-to-br from-purple-500 to-purple-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Belum Dibaca</p>
                    <h3 class="text-3xl font-bold">{{ $unreadCount }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="admin-card bg-gradient-to-br from-green-500 to-green-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-1">Ditampilkan</p>
                    <h3 class="text-3xl font-bold">{{ \App\Models\Kontak::where('is_displayed', true)->count() }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="admin-card bg-gradient-to-br from-gray-500 to-gray-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-100 text-sm font-medium mb-1">Disembunyikan</p>
                    <h3 class="text-3xl font-bold">{{ \App\Models\Kontak::where('is_displayed', false)->count() }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="admin-card">
        <form method="GET" action="{{ route('admin.kontak.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, subjek, atau pesan..." class="admin-input pl-10">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="w-full md:w-48">
                <select name="status" class="admin-input">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="displayed" {{ request('status') == 'displayed' ? 'selected' : '' }}>Ditampilkan</option>
                    <option value="hidden" {{ request('status') == 'hidden' ? 'selected' : '' }}>Disembunyikan</option>
                </select>
            </div>

            <!-- Read Status Filter -->
            <div class="w-full md:w-48">
                <select name="read_status" class="admin-input">
                    <option value="all" {{ request('read_status') == 'all' ? 'selected' : '' }}>Semua Pesan</option>
                    <option value="read" {{ request('read_status') == 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                    <option value="unread" {{ request('read_status') == 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="admin-btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter
                </button>
                @if(request('search') || request('status') != 'all' || request('read_status') != 'all')
                <a href="{{ route('admin.kontak.index') }}" class="admin-btn-secondary">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Messages List -->
    <div class="admin-card">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900">Daftar Pesan</h2>
            @if($kontak->total() > 0)
            <form id="bulkDeleteForm" method="POST" action="{{ route('admin.kontak.bulk-delete') }}">
                @csrf
                @method('DELETE')
                <button type="button" onclick="confirmBulkDelete()" class="admin-btn-danger" id="bulkDeleteBtn" style="display: none;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Terpilih (<span id="selectedCount">0</span>)
                </button>
            </form>
            @endif
        </div>

        @if($kontak->count() > 0)
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="w-12">
                            <input type="checkbox" id="selectAll" class="admin-checkbox">
                        </th>
                        <th>Status</th>
                        <th>Pengirim</th>
                        <th>Kontak</th>
                        <th>Subjek</th>
                        <th>Pesan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kontak as $item)
                    <tr class="{{ !$item->is_read ? 'bg-blue-50' : '' }}">
                        <td>
                            <input type="checkbox" name="selected_ids[]" value="{{ $item->id }}" class="admin-checkbox message-checkbox">
                        </td>
                        <td>
                            <div class="flex flex-col gap-1">
                                <!-- Read Status Badge -->
                                @if(!$item->is_read)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                    Baru
                                </span>
                                @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M2.94 6.412A2 2 0 002 8.108V16a2 2 0 002 2h12a2 2 0 002-2V8.108a2 2 0 00-.94-1.696l-6-3.75a2 2 0 00-2.12 0l-6 3.75zm2.615 2.423a1 1 0 10-1.11 1.664l5 3.333a1 1 0 001.11 0l5-3.333a1 1 0 00-1.11-1.664L10 11.798 5.555 8.835z" clip-rule="evenodd"></path>
                                    </svg>
                                    Dibaca
                                </span>
                                @endif

                                <!-- Display Status Badge -->
                                @if($item->is_displayed)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Tampil
                                </span>
                                @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                    </svg>
                                    Tersembunyi
                                </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="font-semibold text-gray-900">{{ $item->nama }}</div>
                        </td>
                        <td>
                            <div class="text-sm">
                                <div class="flex items-center text-gray-600 mb-1">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <a href="mailto:{{ $item->email }}" class="hover:text-purple-600">{{ $item->email }}</a>
                                </div>
                                @if($item->telepon)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <a href="tel:{{ $item->telepon }}" class="hover:text-purple-600">{{ $item->telepon }}</a>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="text-sm font-medium text-gray-900">{{ $item->subjek }}</span>
                        </td>
                        <td>
                            <div class="text-sm text-gray-600 max-w-xs truncate" title="{{ $item->pesan }}">
                                {{ Str::limit($item->pesan, 50) }}
                            </div>
                        </td>
                        <td>
                            <div class="text-sm text-gray-600">
                                {{ $item->created_at->format('d M Y') }}<br>
                                <span class="text-xs text-gray-500">{{ $item->created_at->format('H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <!-- View Button -->
                                <a href="{{ route('admin.kontak.show', $item->id) }}" class="admin-btn-sm admin-btn-info" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                <!-- Toggle Display Button -->
                                <form method="POST" action="{{ route('admin.kontak.toggle-display', $item->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="admin-btn-sm {{ $item->is_displayed ? 'admin-btn-warning' : 'admin-btn-success' }}" title="{{ $item->is_displayed ? 'Sembunyikan' : 'Tampilkan' }}">
                                        @if($item->is_displayed)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                        </svg>
                                        @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        @endif
                                    </button>
                                </form>

                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('admin.kontak.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn-sm admin-btn-danger" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $kontak->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada pesan</h3>
            <p class="mt-2 text-sm text-gray-500">Belum ada pesan yang masuk.</p>
        </div>
        @endif
    </div>
</div>

<script>
// Select All Checkbox
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.message-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    updateBulkDeleteButton();
});

// Individual Checkbox
document.querySelectorAll('.message-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkDeleteButton);
});

function updateBulkDeleteButton() {
    const checkedBoxes = document.querySelectorAll('.message-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectedCount = document.getElementById('selectedCount');

    if (checkedBoxes.length > 0) {
        bulkDeleteBtn.style.display = 'inline-flex';
        selectedCount.textContent = checkedBoxes.length;
    } else {
        bulkDeleteBtn.style.display = 'none';
    }
}

function confirmBulkDelete() {
    const checkedBoxes = document.querySelectorAll('.message-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Pilih minimal satu pesan untuk dihapus');
        return;
    }

    if (confirm(`Apakah Anda yakin ingin menghapus ${checkedBoxes.length} pesan?`)) {
        const form = document.getElementById('bulkDeleteForm');
        checkedBoxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = checkbox.value;
            form.appendChild(input);
        });
        form.submit();
    }
}
</script>
@endsection
