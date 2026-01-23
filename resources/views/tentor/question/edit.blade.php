@extends('tentor.layouts.app')

@section('title', 'Edit Soal - Hakuna Matata Course')

@section('breadcrumb')
    @include('tentor.components.breadcrumb', [
        'backUrl' => route('tentor.question.index', $tryout->id),
        'previousPage' => 'Kelola Soal',
        'currentPage' => 'Edit Soal'
    ])
@endsection

@section('content')
<div class="p-8">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900">Edit Soal #{{ $question->question_number }}: {{ $tryout->title }}</h2>
            <p class="text-sm text-gray-500 mt-1">Token: <span class="font-mono font-semibold">{{ $tryout->token }}</span></p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <form action="{{ route('tentor.question.update', [$tryout->id, $question->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Question Text -->
                <div class="mb-6">
                    <label for="question_text" class="block text-sm font-semibold text-gray-700 mb-2">
                        Soal <span class="text-red-500">*</span>
                    </label>
                    <textarea id="question_text" 
                              name="question_text" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Masukkan teks soal..."
                              required>{{ old('question_text', $question->question_text) }}</textarea>
                    @error('question_text')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Question Image -->
                @if($question->question_image)
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Soal Saat Ini</label>
                        <img src="{{ asset('storage/' . $question->question_image) }}" 
                             alt="Question Image" 
                             class="max-w-md rounded-lg border">
                    </div>
                @endif

                <!-- Question Image (Optional) -->
                <div class="mb-6">
                    <label for="question_image" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ $question->question_image ? 'Ganti Gambar Soal (Opsional)' : 'Gambar Soal (Opsional)' }}
                    </label>
                    <input type="file" 
                           id="question_image" 
                           name="question_image" 
                           accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, atau JPEG (Max. 2MB). Kosongkan jika tidak ingin mengubah.</p>
                    @error('question_image')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Answer Options -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Pilihan Jawaban <span class="text-red-500">*</span>
                    </label>
                    
                    @foreach($question->answers->sortBy('option') as $answer)
                        <div class="mb-4 p-4 border border-gray-200 rounded-lg {{ $answer->is_correct ? 'bg-green-50 border-green-300' : '' }}">
                            <div class="flex items-start gap-3">
                                <div class="flex items-center h-10">
                                    <input type="radio" 
                                           id="correct_{{ $answer->option }}" 
                                           name="correct_answer" 
                                           value="{{ $answer->option }}"
                                           {{ old('correct_answer', $answer->is_correct ? $answer->option : '') === $answer->option ? 'checked' : '' }}
                                           class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500"
                                           required>
                                </div>
                                <div class="flex-1">
                                    <label for="correct_{{ $answer->option }}" class="block text-sm font-medium text-gray-700 mb-2">
                                        Opsi {{ $answer->option }} 
                                        <span class="text-xs text-gray-500">(Centang jika ini jawaban benar)</span>
                                    </label>
                                    
                                    <!-- Current Answer Image -->
                                    @if($answer->answer_image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $answer->answer_image) }}" 
                                                 alt="Answer {{ $answer->option }}" 
                                                 class="max-w-xs rounded border">
                                        </div>
                                    @endif
                                    
                                    <textarea name="answer_{{ strtolower($answer->option) }}_text" 
                                              rows="2"
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                              placeholder="Masukkan teks opsi {{ $answer->option }}..."
                                              required>{{ old('answer_' . strtolower($answer->option) . '_text', $answer->answer_text) }}</textarea>
                                    
                                    <!-- Answer Image Upload -->
                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 mb-1">
                                            {{ $answer->answer_image ? 'Ganti Gambar Jawaban (Opsional)' : 'Gambar Jawaban (Opsional)' }}
                                        </label>
                                        <input type="file" 
                                               name="answer_{{ strtolower($answer->option) }}_image" 
                                               accept="image/*"
                                               class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                            @error('answer_' . strtolower($answer->option) . '_text')
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
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Masukkan pembahasan atau penjelasan jawaban...">{{ old('explanation', $question->explanation) }}</textarea>
                    @error('explanation')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t">
                    <a href="{{ route('tentor.question.index', $tryout->id) }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection