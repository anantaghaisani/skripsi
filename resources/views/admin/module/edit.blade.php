@extends('admin.layouts.app')

@section('title', 'Edit Modul')

@section('breadcrumb')
    @include('components.admin-breadcrumb', [
        'backUrl' => route('admin.module.index'),
        'previousPage' => 'Kelola Modul',
        'currentPage' => 'Edit Modul'
    ])
@endsection

@section('content')
<div class="p-8">

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Form Edit Modul</h2>

        <form action="{{ route('admin.module.update', $module->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Modul <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $module->title) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                           required>
                    @error('title')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">{{ old('description', $module->description) }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current File -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">File Saat Ini</label>
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $module->title }}</p>
                            <p class="text-xs text-gray-500">{{ strtoupper($module->file_type) }} • {{ number_format($module->file_size / 1024 / 1024, 2) }} MB</p>
                        </div>
                    </div>
                </div>

                <!-- File Upload (Optional) -->
                <div class="md:col-span-2">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        Ganti File (Opsional)
                    </label>
                    <input type="file" 
                           id="file" 
                           name="file" 
                           accept=".pdf"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah file. PDF only (Max. 10MB)</p>
                    @error('file')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Thumbnail (Optional) -->
                <div class="md:col-span-2">
                    @if($module->thumbnail)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Thumbnail Saat Ini</label>
                            <img src="{{ asset('storage/' . $module->thumbnail) }}" 
                                 alt="{{ $module->title }}" 
                                 class="w-48 h-32 object-cover rounded-lg border-2 border-gray-200">
                        </div>
                    @endif
                    
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $module->thumbnail ? 'Ganti Thumbnail (Opsional)' : 'Thumbnail (Opsional)' }}
                    </label>
                    <input type="file" 
                           id="thumbnail" 
                           name="thumbnail" 
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">{{ $module->thumbnail ? 'Kosongkan jika tidak ingin mengubah thumbnail. ' : '' }}JPG, PNG atau JPEG (Max. 2MB)</p>
                    @error('thumbnail')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Classes (Multiple Select) -->
                <div class="md:col-span-2">
                    <label for="class_ids" class="block text-sm font-medium text-gray-700 mb-2">
                        Kelas yang Dapat Mengakses <span class="text-red-600">*</span>
                    </label>
                    <div class="border border-gray-300 rounded-lg p-4 max-h-60 overflow-y-auto">
                        @foreach($classes as $class)
                            <label class="flex items-center py-2 hover:bg-gray-50 px-2 rounded cursor-pointer">
                                <input type="checkbox" 
                                       name="class_ids[]" 
                                       value="{{ $class->id }}"
                                       {{ in_array($class->id, old('class_ids', $module->classes->pluck('id')->toArray())) ? 'checked' : '' }}
                                       class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                <span class="ml-3 text-sm text-gray-900">{{ $class->full_name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Pilih satu atau lebih kelas</p>
                    @error('class_ids')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="md:col-span-2">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $module->is_active) ? 'checked' : '' }}
                               class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <span class="ml-3 text-sm font-medium text-gray-900">Aktifkan modul ini</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 ml-8">Modul aktif akan dapat diakses oleh siswa</p>
                </div>

                <!-- Buttons -->
                <div class="md:col-span-2 flex gap-4 pt-6 border-t">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Modul
                    </button>
                    <a href="{{ route('admin.module.index') }}" 
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                        Batal
                    </a>
                </div>

            </div>
        </form>
    </div>

</div>
@endsection