@extends('tentor.layouts.app')

@section('title', isset($module) ? 'Edit Modul' : 'Tambah Modul')

@section('breadcrumb')
    @include('tentor.components.breadcrumb', [
        'backUrl' => route('tentor.modules.index'),
        'previousPage' => 'Kelola Modul',
        'currentPage' => isset($module) ? 'Edit Modul' : 'Tambah Modul'
    ])
@endsection

@section('content')
<div class="p-8">

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <form action="{{ isset($module) ? route('tentor.modules.update', $module->id) : route('tentor.modules.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @if(isset($module))
                    @method('PUT')
                @endif

                <!-- Title -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Modul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           value="{{ old('title', $module->title ?? '') }}"
                           placeholder="Contoh: Pengenalan Fotosintesis"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hm-blue focus:border-transparent @error('title') border-red-500 @enderror"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" 
                              rows="4"
                              placeholder="Jelaskan singkat tentang modul ini..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hm-blue focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $module->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Classes -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kelas yang Dapat Mengakses <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 border border-gray-300 rounded-lg bg-gray-50">
                        @php
                            $selectedClasses = old('class_ids', isset($module) ? $module->classes->pluck('id')->toArray() : []);
                        @endphp
                        @foreach($classes as $class)
                            <label class="flex items-center p-3 bg-white border border-gray-200 rounded-lg hover:border-hm-blue transition cursor-pointer">
                                <input type="checkbox" 
                                       name="class_ids[]" 
                                       value="{{ $class->id }}"
                                       {{ in_array($class->id, $selectedClasses) ? 'checked' : '' }}
                                       class="rounded text-hm-blue mr-2">
                                <span class="text-sm font-medium text-gray-700">{{ $class->full_name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('class_ids')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        File Modul @if(!isset($module))<span class="text-red-500">*</span>@endif
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-hm-blue transition">
                        <input type="file" 
                               name="file" 
                               id="file-input"
                               accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.avi,.mov"
                               class="hidden"
                               {{ !isset($module) ? 'required' : '' }}
                               onchange="updateFileName(this)">
                        <label for="file-input" class="cursor-pointer">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-sm font-semibold text-gray-700 mb-1">Klik untuk upload file</p>
                            <p id="file-name" class="text-xs text-gray-500">PDF, DOC, PPT, Video (Maks. 50MB)</p>
                            @if(isset($module) && $module->file_path)
                                <p class="text-xs text-blue-600 mt-2">File saat ini: {{ basename($module->file_path) }}</p>
                            @endif
                        </label>
                    </div>
                    @error('file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Thumbnail Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Thumbnail (Opsional)
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-hm-blue transition">
                        <input type="file" 
                               name="thumbnail" 
                               id="thumbnail-input"
                               accept="image/jpeg,image/jpg,image/png"
                               class="hidden"
                               onchange="previewThumbnail(this)">
                        <label for="thumbnail-input" class="cursor-pointer">
                            <div id="thumbnail-preview">
                                @if(isset($module) && $module->thumbnail)
                                    <img src="{{ asset('storage/' . $module->thumbnail) }}" 
                                         class="w-32 h-32 object-cover rounded-lg mx-auto mb-3">
                                @else
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                                <p class="text-sm font-semibold text-gray-700 mb-1">Klik untuk upload thumbnail</p>
                                <p class="text-xs text-gray-500">JPG, PNG (Maks. 2MB)</p>
                            </div>
                        </label>
                    </div>
                    @error('thumbnail')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               {{ old('is_active', $module->is_active ?? true) ? 'checked' : '' }}
                               class="rounded text-hm-blue">
                        <span class="ml-2 text-sm font-medium text-gray-700">Aktifkan modul</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 ml-6">Siswa dapat mengakses modul jika diaktifkan</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t">
                    <a href="{{ route('tentor.modules.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm">
                        {{ isset($module) ? 'Perbarui Modul' : 'Simpan Modul' }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
// Update file name display
function updateFileName(input) {
    const fileName = document.getElementById('file-name');
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const size = (file.size / 1024 / 1024).toFixed(2);
        fileName.textContent = `${file.name} (${size} MB)`;
    }
}

// Preview thumbnail
function previewThumbnail(input) {
    const preview = document.getElementById('thumbnail-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" class="w-32 h-32 object-cover rounded-lg mx-auto mb-3">
                <p class="text-sm font-semibold text-gray-700 mb-1">Klik untuk ganti thumbnail</p>
                <p class="text-xs text-gray-500">JPG, PNG (Maks. 2MB)</p>
            `;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection