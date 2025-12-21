@extends('tentor.layout')

@section('title', 'Edit Tryout - Hakuna Matata Course')
@section('page-title', 'Edit Tryout')

@section('content')
<div class="p-8">

    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('tentor.tryout.index') }}" 
               class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Tryout
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Edit Tryout</h2>
                <div class="text-sm">
                    <span class="text-gray-500">Token:</span>
                    <span class="ml-2 font-mono font-bold text-blue-600">{{ $tryout->token }}</span>
                </div>
            </div>

            <form action="{{ route('tentor.tryout.update', $tryout->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Tryout <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $tryout->title) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('title')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Code -->
                <div>
                    <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kode Tryout <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="code" 
                           name="code" 
                           value="{{ old('code', $tryout->code) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('code')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $tryout->description) }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="start_date" 
                               name="start_date" 
                               value="{{ old('start_date', $tryout->start_date->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('start_date')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="end_date" 
                               name="end_date" 
                               value="{{ old('end_date', $tryout->end_date->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('end_date')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Questions and Duration -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="total_questions" class="block text-sm font-semibold text-gray-700 mb-2">
                            Jumlah Soal <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="total_questions" 
                               name="total_questions" 
                               value="{{ old('total_questions', $tryout->total_questions) }}"
                               min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('total_questions')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration_minutes" class="block text-sm font-semibold text-gray-700 mb-2">
                            Durasi (Menit) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="duration_minutes" 
                               name="duration_minutes" 
                               value="{{ old('duration_minutes', $tryout->duration_minutes) }}"
                               min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('duration_minutes')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Active Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               {{ old('is_active', $tryout->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm font-medium text-gray-700">Tryout Aktif</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 ml-6">Jika dinonaktifkan, siswa tidak dapat mengakses tryout ini</p>
                </div>

                <!-- Classes Selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Pilih Kelas <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-500 mb-3">Pilih satu atau lebih kelas yang bisa mengakses tryout ini</p>
                    
                    <div class="border border-gray-300 rounded-lg p-4 max-h-64 overflow-y-auto bg-gray-50">
                        @php
                            $groupedClasses = $classes->groupBy('grade_level');
                        @endphp
                        
                        @foreach($groupedClasses as $gradeLevel => $classList)
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-900 mb-2 text-sm">{{ $gradeLevel }}</h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @foreach($classList as $class)
                                        <label class="flex items-center p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer transition">
                                            <input type="checkbox" 
                                                   name="classes[]" 
                                                   value="{{ $class->id }}"
                                                   {{ in_array($class->id, old('classes', $selectedClasses)) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-900">
                                                {{ $class->grade_level }} {{ $class->class_number }}{{ $class->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @error('classes')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('tentor.tryout.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection