@extends('layouts.admin')

@section('page-title', 'Tambah Berita Baru')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Tambah Berita Baru</h2>
        <p class="text-gray-600 text-sm mt-1">Buat berita baru untuk dipublikasikan</p>
    </div>
    <a href="{{ route('admin.berita.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
    </a>
</div>

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="px-8 pt-6 pb-8">
        <form method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data" id="beritaForm">
            @csrf

            <!-- Judul Berita -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="judul">
                    Judul Berita <span class="text-red-500">*</span>
                </label>
                <input class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('judul') border-red-500 @enderror"
                       id="judul"
                       name="judul"
                       type="text"
                       placeholder="Masukkan judul berita yang menarik"
                       value="{{ old('judul') }}"
                       required
                       maxlength="255">
                @error('judul')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Maksimal 255 karakter</p>
            </div>

            <!-- Upload Gambar -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="gambar">
                    Gambar Berita
                </label>

                <div class="flex items-center justify-center w-full">
                    <label for="gambar" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6" id="uploadPlaceholder">
                            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG atau GIF (MAX. 2MB)</p>
                        </div>
                        <img id="imagePreview" class="hidden w-full h-full object-cover rounded-lg" alt="Preview">
                        <input id="gambar"
                               name="gambar"
                               type="file"
                               class="hidden"
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               onchange="previewImage(event)">
                    </label>
                </div>

                @error('gambar')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror

                <button type="button"
                        id="removeImage"
                        class="hidden mt-2 text-sm text-red-600 hover:text-red-800 font-medium"
                        onclick="removeImage()">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Gambar
                </button>
            </div>

            <!-- Konten Berita -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="konten">
                    Konten Berita <span class="text-red-500">*</span>
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('konten') border-red-500 @enderror"
                          id="konten"
                          name="konten"
                          rows="12"
                          placeholder="Tulis konten berita di sini... Jelaskan dengan detail dan jelas."
                          required>{{ old('konten') }}</textarea>
                @error('konten')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
                <div class="flex justify-between items-center mt-1">
                    <p class="text-gray-500 text-xs">Minimal 50 karakter</p>
                    <p class="text-gray-500 text-xs" id="charCount">0 karakter</p>
                </div>
            </div>

            <!-- Status Publikasi -->
            <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                <label class="flex items-start cursor-pointer">
                    <div class="flex items-center h-5">
                        <input type="checkbox"
                               name="is_published"
                               value="1"
                               {{ old('is_published') ? 'checked' : '' }}
                               class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500 focus:ring-2">
                    </div>
                    <div class="ml-3">
                        <span class="font-medium text-gray-700">Publikasikan Berita</span>
                        <p class="text-sm text-gray-500 mt-1">Centang untuk langsung mempublikasikan berita setelah disimpan. Jika tidak dicentang, berita akan tersimpan sebagai draft.</p>
                    </div>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <div class="flex space-x-3">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline inline-flex items-center transition-colors duration-200"
                            type="submit">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Berita
                    </button>
                    <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline inline-flex items-center transition-colors duration-200"
                            type="button"
                            onclick="draftBerita()">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Simpan sebagai Draft
                    </button>
                </div>
                <a href="{{ route('admin.berita.index') }}"
                   class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Preview Image
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        const removeBtn = document.getElementById('removeImage');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                removeBtn.classList.remove('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove Image
    function removeImage() {
        const input = document.getElementById('gambar');
        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        const removeBtn = document.getElementById('removeImage');

        input.value = '';
        preview.src = '';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        removeBtn.classList.add('hidden');
    }

    // Character Counter
    const kontenTextarea = document.getElementById('konten');
    const charCount = document.getElementById('charCount');

    kontenTextarea.addEventListener('input', function() {
        const count = this.value.length;
        charCount.textContent = count + ' karakter';

        if (count < 50) {
            charCount.classList.add('text-red-500');
            charCount.classList.remove('text-green-500');
        } else {
            charCount.classList.add('text-green-500');
            charCount.classList.remove('text-red-500');
        }
    });

    // Draft Function
    function draftBerita() {
        const checkbox = document.querySelector('input[name="is_published"]');
        checkbox.checked = false;
        document.getElementById('beritaForm').submit();
    }

    // Form Validation
    document.getElementById('beritaForm').addEventListener('submit', function(e) {
        const konten = document.getElementById('konten').value;

        if (konten.length < 50) {
            e.preventDefault();
            alert('Konten berita minimal 50 karakter!');
            document.getElementById('konten').focus();
            return false;
        }
    });
</script>
@endpush

@endsection
