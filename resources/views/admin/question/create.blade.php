@extends('admin.layouts.app')

@section('title', 'Tambah Soal - Hakuna Matata Course')

@section('breadcrumb')
    @include('components.admin-breadcrumb', [
        'backUrl' => route('admin.question.index', $tryout->id),
        'previousPage' => 'Kelola Soal',
        'currentPage' => 'Tambah Soal Baru'
    ])
@endsection

@section('content')
<div class="p-8">
    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900">Tambah Soal untuk: {{ $tryout->title }}</h2>
            <p class="text-sm text-gray-500 mt-1">Token: <span class="font-mono font-semibold">{{ $tryout->token }}</span></p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <form action="{{ route('admin.question.store', $tryout->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Question Text -->
                <div class="mb-6">
                    <label for="question_text" class="block text-sm font-semibold text-gray-700 mb-2">
                        Soal <span class="text-red-500">*</span>
                    </label>
                    <textarea id="question_text" 
                              name="question_text" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                              placeholder="Masukkan teks soal..."
                              required>{{ old('question_text') }}</textarea>
                    @error('question_text')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Question Image (Optional) -->
                <div class="mb-6">
                    <label for="question_image" class="block text-sm font-semibold text-gray-700 mb-2">
                        Gambar Soal (Opsional)
                    </label>
                    <input type="file" 
                           id="question_image" 
                           name="question_image" 
                           accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, atau JPEG (Max. 2MB)</p>
                    @error('question_image')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Answer Options -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Pilihan Jawaban <span class="text-red-500">*</span>
                    </label>
                    
                    @foreach(['A', 'B', 'C', 'D', 'E'] as $option)
                        <div class="mb-4 p-4 border border-gray-200 rounded-lg hover:border-red-300 transition">
                            <div class="flex items-start gap-3">
                                <div class="flex items-center h-10">
                                    <input type="radio" 
                                           id="correct_{{ $option }}" 
                                           name="correct_answer" 
                                           value="{{ $option }}"
                                           {{ old('correct_answer') === $option ? 'checked' : '' }}
                                           class="w-5 h-5 text-red-600 border-gray-300 focus:ring-red-500"
                                           required>
                                </div>
                                <div class="flex-1">
                                    <label for="correct_{{ $option }}" class="block text-sm font-medium text-gray-700 mb-2">
                                        Opsi {{ $option }} 
                                        <span class="text-xs text-gray-500">(Centang jika ini jawaban benar)</span>
                                    </label>
                                    <textarea name="answer_{{ strtolower($option) }}_text" 
                                              rows="2"
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm"
                                              placeholder="Masukkan teks opsi {{ $option }}..."
                                              required>{{ old('answer_' . strtolower($option) . '_text') }}</textarea>
                                </div>
                            </div>
                            @error('answer_' . strtolower($option) . '_text')
                                <p class="text-sm text-red-600 mt-1 ml-8">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach

                    @error('correct_answer')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Explanation (Optional) -->
                <div class="mb-6">
                    <label for="explanation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Pembahasan (Opsional)
                    </label>
                    <textarea id="explanation" 
                              name="explanation" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                              placeholder="Masukkan pembahasan atau penjelasan jawaban...">{{ old('explanation') }}</textarea>
                    @error('explanation')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t">
                    <a href="{{ route('admin.question.index', $tryout->id) }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition shadow-sm">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Soal
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection