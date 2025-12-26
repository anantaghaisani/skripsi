@extends('tentor.layouts.app')

@section('title', 'Tambah Soal - Hakuna Matata Course')

@section('breadcrumb')
    @include('tentor.components.breadcrumb', [
        'backUrl' => route('tentor.question.index', $tryout->id),
        'previousPage' => 'Kelola Soal',
        'currentPage' => 'Tambah Soal Bulk'
    ])
@endsection

@section('content')
<div class="p-8">

    <div class="max-w-6xl mx-auto">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-6">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Tryout Info Card -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white shadow-lg mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">{{ $tryout->title }}</h2>
                    <p class="text-blue-100 mb-3">Token: <span class="font-mono font-bold">{{ $tryout->token }}</span></p>
                    <div class="flex items-center space-x-4 text-sm">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Target: {{ $tryout->total_questions }} soal
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Tersedia: <span id="current-count">{{ $tryout->getQuestionCount() }}</span> soal
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-blue-100 mb-1">Nomor Mulai</div>
                    <div class="text-3xl font-bold">{{ $startNumber }}</div>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Tambah Soal Sekaligus</h3>
                    <p class="text-sm text-gray-600 mt-1">Isi beberapa soal sekaligus untuk mempercepat proses</p>
                </div>
                <button type="button" onclick="addQuestion()" 
                        class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Soal
                </button>
            </div>

            <form action="{{ route('tentor.question.bulk-store', $tryout->id) }}" method="POST" id="bulk-form">
                @csrf

                <!-- Questions Container -->
                <div id="questions-container" class="space-y-6 mb-6">
                    <!-- Initial 5 questions will be added by JavaScript -->
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-6 border-t">
                    <a href="{{ route('tentor.question.index', $tryout->id) }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Lewati (Isi Nanti)
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm">
                        Simpan Semua Soal
                    </button>
                </div>
            </form>
        </div>

        <!-- Tips Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-blue-900 mb-1">💡 Tips Mengisi Soal:</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Klik "Tambah Soal" untuk menambah form soal baru</li>
                        <li>• Klik "Hapus" pada soal yang tidak diinginkan</li>
                        <li>• Pilih jawaban benar dari dropdown</li>
                        <li>• Pembahasan bersifat opsional tapi sangat membantu siswa</li>
                        <li>• Klik "Lewati" jika ingin mengisi soal nanti</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
let questionCount = 0;
const startNumber = {{ $startNumber }};

// Add initial 5 questions on page load
document.addEventListener('DOMContentLoaded', function() {
    for (let i = 0; i < 5; i++) {
        addQuestion();
    }
});

function addQuestion() {
    const container = document.getElementById('questions-container');
    const questionNumber = startNumber + questionCount;
    
    const questionHTML = `
        <div class="question-item border border-gray-200 rounded-lg p-6 bg-gray-50" data-index="${questionCount}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-bold text-gray-900">Soal #${questionNumber}</h4>
                <button type="button" onclick="removeQuestion(${questionCount})" 
                        class="text-red-600 hover:text-red-800 font-semibold text-sm">
                    Hapus Soal
                </button>
            </div>

            <!-- Question Text -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pertanyaan <span class="text-red-500">*</span>
                </label>
                <textarea name="questions[${questionCount}][question_text]" 
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Tulis pertanyaan di sini..."
                          required></textarea>
            </div>

            <!-- Answers A-E -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pilihan Jawaban <span class="text-red-500">*</span>
                </label>
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <span class="font-semibold text-gray-700 w-8">A.</span>
                        <input type="text" 
                               name="questions[${questionCount}][answers][0]" 
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               placeholder="Jawaban A"
                               required>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="font-semibold text-gray-700 w-8">B.</span>
                        <input type="text" 
                               name="questions[${questionCount}][answers][1]" 
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               placeholder="Jawaban B"
                               required>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="font-semibold text-gray-700 w-8">C.</span>
                        <input type="text" 
                               name="questions[${questionCount}][answers][2]" 
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               placeholder="Jawaban C"
                               required>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="font-semibold text-gray-700 w-8">D.</span>
                        <input type="text" 
                               name="questions[${questionCount}][answers][3]" 
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               placeholder="Jawaban D"
                               required>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="font-semibold text-gray-700 w-8">E.</span>
                        <input type="text" 
                               name="questions[${questionCount}][answers][4]" 
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               placeholder="Jawaban E"
                               required>
                    </div>
                </div>
            </div>

            <!-- Correct Answer -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kunci Jawaban <span class="text-red-500">*</span>
                </label>
                <select name="questions[${questionCount}][correct_answer]" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="">Pilih Jawaban Benar</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
            </div>

            <!-- Explanation (Optional) -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pembahasan (Opsional)
                </label>
                <textarea name="questions[${questionCount}][explanation]" 
                          rows="2"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Tuliskan pembahasan atau penjelasan untuk soal ini..."></textarea>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', questionHTML);
    questionCount++;
}

function removeQuestion(index) {
    const questionItem = document.querySelector(`[data-index="${index}"]`);
    if (questionItem) {
        questionItem.remove();
        // Renumber remaining questions
        renumberQuestions();
    }
}

function renumberQuestions() {
    const questions = document.querySelectorAll('.question-item');
    questions.forEach((q, idx) => {
        const header = q.querySelector('h4');
        if (header) {
            header.textContent = `Soal #${startNumber + idx}`;
        }
    });
}
</script>
@endpush
@endsection