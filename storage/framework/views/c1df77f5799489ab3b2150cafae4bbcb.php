

<?php $__env->startSection('title', 'Tambah Soal - Hakuna Matata Course'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('tentor.components.breadcrumb', [
        'backUrl' => route('tentor.question.index', $tryout->id),
        'previousPage' => 'Kelola Soal',
        'currentPage' => 'Tambah Soal'
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8">

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-6">
            <div class="flex">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
            <div class="flex">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-red-800"><?php echo e(session('error')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Tryout Info Card -->
    <div class="bg-gradient-to-r from-hm-blue to-blue-700 rounded-xl p-6 text-white shadow-lg mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2"><?php echo e($tryout->title); ?></h2>
                <p class="text-blue-100 mb-3">Token: <span class="font-mono font-bold"><?php echo e($tryout->token); ?></span></p>
                <div class="flex items-center space-x-4 text-sm">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Target: <?php echo e($tryout->total_questions); ?> soal
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tersedia: <span id="current-count"><?php echo e($tryout->getQuestionCount()); ?></span> soal
                    </span>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm text-blue-100 mb-1">Nomor Mulai</div>
                <div class="text-3xl font-bold"><?php echo e($startNumber); ?></div>
            </div>
        </div>
    </div>

    <!-- Remaining Info -->
    <div id="remaining-info"></div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Tambah Soal</h3>
                <p class="text-sm text-gray-600 mt-1">Isi beberapa soal sekaligus untuk mempercepat proses</p>
            </div>
            <button type="button" onclick="addQuestion()" 
                    class="inline-flex items-center px-4 py-2 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Soal
            </button>
        </div>

        <form action="<?php echo e(route('tentor.question.bulk-store', $tryout->id)); ?>" method="POST" id="bulk-form" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <!-- Questions Container -->
            <div id="questions-container" class="space-y-6 mb-6">
                <!-- Questions will be added by JavaScript -->
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-between pt-6 border-t">
                <a href="<?php echo e(route('tentor.question.index', $tryout->id)); ?>" 
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
                    <li>• <strong>Pertanyaan wajib diisi</strong> agar soal tersimpan</li>
                    <li>• <strong>Minimal 3 pilihan jawaban (A, B, C) wajib diisi</strong></li>
                    <li>• Pilih jumlah opsi jawaban (3, 4, atau 5 opsi)</li>
                    <li>• Gambar soal dan jawaban bersifat opsional</li>
                    <li>• <strong>Kunci jawaban wajib dipilih</strong></li>
                    <li>• Pembahasan bersifat opsional tapi sangat membantu siswa</li>
                    <li>• Tryout belum bisa diakses student sampai soal lengkap</li>
                </ul>
            </div>
        </div>
    </div>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
let questionCount = 0;
let questionIndices = [];
const startNumber = <?php echo e($startNumber); ?>;
const targetQuestions = <?php echo e($tryout->total_questions); ?>;
const currentCount = <?php echo e($tryout->getQuestionCount()); ?>;
const remainingSlots = targetQuestions - currentCount;

document.addEventListener('DOMContentLoaded', function() {
    updateRemainingInfo();
    
    const questionsToAdd = Math.min(remainingSlots, 5);
    for (let i = 0; i < questionsToAdd; i++) {
        addQuestion();
    }
    
    checkSlotLimit();
    
    // ✅ ADD FORM VALIDATION
    const form = document.getElementById('bulk-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Stop submission
        
        // Validate all questions
        const questions = document.querySelectorAll('.question-item');
        let hasError = false;
        let errorMessages = [];
        
        questions.forEach((question, idx) => {
            const questionIndex = question.getAttribute('data-index');
            const questionText = question.querySelector(`textarea[name="questions[${questionIndex}][question_text]"]`);
            const correctAnswer = question.querySelector(`select[name="questions[${questionIndex}][correct_answer]"]`);
            const questionNumber = startNumber + idx;
            
            // Check if question text is empty
            if (!questionText.value.trim()) {
                hasError = true;
                errorMessages.push(`Soal #${questionNumber}: Pertanyaan wajib diisi!`);
                questionText.classList.add('border-red-500', 'bg-red-50');
            } else {
                questionText.classList.remove('border-red-500', 'bg-red-50');
            }
            
            // ✅ Check if answers are filled (at least 3 answers)
            const answerInputs = question.querySelectorAll(`input[name^="questions[${questionIndex}][answers]"]`);
            let filledAnswers = 0;
            answerInputs.forEach(input => {
                if (input.value.trim()) {
                    filledAnswers++;
                    input.classList.remove('border-red-500', 'bg-red-50');
                } else {
                    input.classList.add('border-red-500', 'bg-red-50');
                }
            });
            
            if (filledAnswers < 3) {
                hasError = true;
                errorMessages.push(`Soal #${questionNumber}: Minimal 3 pilihan jawaban harus diisi!`);
            }
            
            // Check if correct answer is selected
            if (!correctAnswer.value) {
                hasError = true;
                errorMessages.push(`Soal #${questionNumber}: Kunci jawaban wajib dipilih!`);
                correctAnswer.classList.add('border-red-500', 'bg-red-50');
            } else {
                correctAnswer.classList.remove('border-red-500', 'bg-red-50');
            }
        });
        
        if (hasError) {
            // Show error alert
            alert('⚠️ Ada field yang belum diisi:\n\n' + errorMessages.join('\n'));
            
            // Scroll to first error
            const firstError = document.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
            
            return false;
        }
        
        // If validation passes, submit the form
        form.submit();
    });
});

function updateRemainingInfo() {
    const infoDiv = document.getElementById('remaining-info');
    if (infoDiv) {
        infoDiv.innerHTML = `
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-blue-900">
                            Sisa slot soal: <span class="text-lg">${remainingSlots}</span> dari ${targetQuestions} soal
                        </p>
                        ${remainingSlots === 0 ? 
                            '<p class="text-xs text-blue-700 mt-1">✅ Soal sudah lengkap! Tryout siap diakses student.</p>' : 
                            '<p class="text-xs text-blue-700 mt-1">⚠️ Tryout belum bisa diakses student sampai soal lengkap.</p>'
                        }
                    </div>
                </div>
            </div>
        `;
    }
}

function addQuestion() {
    const activeQuestions = document.querySelectorAll('.question-item').length;
    
    if (activeQuestions >= remainingSlots) {
        alert(`Tidak bisa menambah soal lagi! Target maksimal: ${targetQuestions} soal. Sudah tersimpan: ${currentCount} soal.`);
        return;
    }
    
    const container = document.getElementById('questions-container');
    const currentIndex = questionCount;
    const questionNumber = startNumber + activeQuestions;
    
    const questionHTML = `
        <div class="question-item border-2 border-gray-300 rounded-xl p-6 bg-gray-50" data-index="${currentIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-bold text-gray-900">Soal #${questionNumber}</h4>
                <button type="button" onclick="removeQuestion(${currentIndex})" 
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition text-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Soal
                </button>
            </div>

            <!-- Question Text - REQUIRED -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pertanyaan <span class="text-red-500">*</span>
                </label>
                <textarea name="questions[${currentIndex}][question_text]" 
                          rows="3"
                          required
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Tulis pertanyaan di sini (wajib diisi)..."></textarea>
                <p class="text-xs text-red-500 mt-1">* Wajib diisi agar soal tersimpan</p>
            </div>

            <!-- Question Image -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Soal (Opsional)</label>
                <input type="file" 
                       name="question_images[${currentIndex}]" 
                       accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">JPG, PNG, atau JPEG (Max. 2MB)</p>
            </div>

            <!-- Points -->
            <input type="hidden" name="questions[${currentIndex}][points]" value="1">

            <!-- Number of Options -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Opsi Jawaban</label>
                <select onchange="updateAnswerOptions(${currentIndex}, this.value)" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 font-semibold"
                        id="option-count-${currentIndex}">
                    <option value="3">3 Opsi (A, B, C)</option>
                    <option value="4">4 Opsi (A, B, C, D)</option>
                    <option value="5" selected>5 Opsi (A, B, C, D, E)</option>
                </select>
            </div>

            <!-- Answers Container -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Pilihan Jawaban</label>
                <div id="answers-container-${currentIndex}" class="space-y-3">
                    ${generateAnswerOptions(currentIndex, 5)}
                </div>
            </div>

            <!-- Correct Answer -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kunci Jawaban <span class="text-red-500">*</span>
                </label>
                <select name="questions[${currentIndex}][correct_answer]" 
                        id="correct-answer-${currentIndex}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 font-semibold">
                    <option value="">-- Pilih Jawaban Benar --</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
            </div>

            <!-- Explanation -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pembahasan (Opsional)</label>
                <textarea name="questions[${currentIndex}][explanation]" 
                          rows="2"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Tuliskan pembahasan atau penjelasan untuk soal ini..."></textarea>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', questionHTML);
    questionCount++;
    questionIndices.push(currentIndex);
    checkSlotLimit();
}

function generateAnswerOptions(questionIndex, optionCount) {
    const options = ['A', 'B', 'C', 'D', 'E'];
    let html = '';
    
    for (let idx = 0; idx < optionCount; idx++) {
        const option = options[idx];
        const isRequired = idx < 3; // A, B, C wajib diisi
        html += `
            <div class="bg-white p-4 rounded-lg border border-gray-200 answer-option-${questionIndex}" data-option="${option}">
                <div class="flex items-center space-x-2 mb-2">
                    <span class="font-bold text-gray-700 w-8">${option}.</span>
                    <input type="text" 
                           name="questions[${questionIndex}][answers][${idx}]" 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                           placeholder="Jawaban ${option}${isRequired ? ' (wajib diisi)' : ' (opsional)'}">
                </div>
                <div class="ml-10">
                    <label class="block text-xs text-gray-600 mb-1">Gambar Jawaban ${option} (Opsional)</label>
                    <input type="file" 
                           name="answer_images[${questionIndex}][${idx}]" 
                           accept="image/*"
                           class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        `;
    }
    
    return html;
}

function updateAnswerOptions(questionIndex, optionCount) {
    const container = document.getElementById(`answers-container-${questionIndex}`);
    const correctAnswerSelect = document.getElementById(`correct-answer-${questionIndex}`);
    
    container.innerHTML = generateAnswerOptions(questionIndex, parseInt(optionCount));
    
    const options = ['A', 'B', 'C', 'D', 'E'];
    correctAnswerSelect.innerHTML = '<option value="">-- Pilih Jawaban Benar --</option>';
    
    for (let i = 0; i < parseInt(optionCount); i++) {
        const opt = document.createElement('option');
        opt.value = options[i];
        opt.textContent = options[i];
        correctAnswerSelect.appendChild(opt);
    }
}

function removeQuestion(index) {
    const questionItem = document.querySelector(`[data-index="${index}"]`);
    if (questionItem) {
        if (confirm('Yakin ingin menghapus soal ini?')) {
            questionItem.remove();
            questionIndices = questionIndices.filter(i => i !== index);
            renumberQuestions();
            checkSlotLimit();
        }
    }
}

function renumberQuestions() {
    const questions = document.querySelectorAll('.question-item');
    questions.forEach((q, displayIdx) => {
        const header = q.querySelector('h4');
        if (header) {
            header.textContent = `Soal #${startNumber + displayIdx}`;
        }
    });
}

function checkSlotLimit() {
    const activeQuestions = document.querySelectorAll('.question-item').length;
    const addButton = document.querySelector('button[onclick="addQuestion()"]');
    
    if (addButton) {
        if (activeQuestions >= remainingSlots) {
            addButton.disabled = true;
            addButton.classList.add('opacity-50', 'cursor-not-allowed');
            addButton.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Slot Penuh (${remainingSlots}/${targetQuestions})
            `;
        } else {
            addButton.disabled = false;
            addButton.classList.remove('opacity-50', 'cursor-not-allowed');
            addButton.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Soal (${activeQuestions}/${remainingSlots})
            `;
        }
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('tentor.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/tentor/question/bulk-create.blade.php ENDPATH**/ ?>