

<?php $__env->startSection('title', $tryout->title . ' - Hakuna Matata Course'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('tentor.components.breadcrumb', [
        'backUrl' => route('tryout.index'),
        'previousPage' => 'Daftar Tryout',
        'currentPage' => $tryout->title
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header Info -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white shadow-lg mb-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-blue-100 text-sm">Kode Tryout</p>
                            <p class="text-xl font-bold"><?php echo e($tryout->code); ?></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4 pt-4 border-t border-white/20">
                        <div>
                            <p class="text-blue-100 text-xs mb-1">Total Soal</p>
                            <p class="text-2xl font-bold"><?php echo e($tryout->total_questions); ?></p>
                        </div>
                        <div>
                            <p class="text-blue-100 text-xs mb-1">Durasi</p>
                            <p class="text-2xl font-bold"><?php echo e($tryout->duration_minutes); ?> <span class="text-sm">menit</span></p>
                        </div>
                        <div>
                            <p class="text-blue-100 text-xs mb-1">Poin per Soal</p>
                            <p class="text-2xl font-bold">5 <span class="text-sm">poin</span></p>
                        </div>
                    </div>
                </div>
                
                <!-- Timer -->
                <div class="text-center bg-white/20 rounded-xl px-8 py-4 ml-6">
                    <p class="text-blue-100 text-sm mb-2">Sisa Waktu</p>
                    <div id="timer" class="text-4xl font-bold" data-remaining="<?php echo e($remainingMinutes); ?>">
                        <span id="timer-display"><?php echo e(floor($remainingMinutes)); ?>:00</span>
                    </div>
                    <p class="text-blue-200 text-xs mt-2">Auto-submit jika habis</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <!-- Left: Question Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                    <h3 class="font-bold text-gray-900 mb-4">Navigasi Soal</h3>
                    
                    <div class="grid grid-cols-4 gap-2 mb-6">
                        <?php $__currentLoopData = $tryout->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="relative">
                                <button 
                                    onclick="goToQuestion(<?php echo e($index + 1); ?>)"
                                    id="nav-<?php echo e($question->id); ?>"
                                    class="nav-button w-full aspect-square rounded-lg font-semibold text-sm transition
                                           <?php echo e(isset($userAnswers[$question->id]) ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600 hover:bg-gray-300'); ?>">
                                    <?php echo e($index + 1); ?>

                                </button>
                                <!-- Flag Icon -->
                                <button 
                                    onclick="toggleFlag(<?php echo e($question->id); ?>); event.stopPropagation();"
                                    id="flag-<?php echo e($question->id); ?>"
                                    class="flag-button absolute -top-1 -right-1 w-5 h-5 rounded-full bg-white border-2 border-gray-300 flex items-center justify-center opacity-0 hover:opacity-100 transition">
                                    <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z"/>
                                    </svg>
                                </button>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Legend -->
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-green-500 rounded mr-2"></div>
                            <span class="text-gray-600">Sudah Dijawab</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-gray-200 rounded mr-2"></div>
                            <span class="text-gray-600">Belum Dijawab</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-gray-700 rounded mr-2 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z"/>
                                </svg>
                            </div>
                            <span class="text-gray-600">Ditandai</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        onclick="confirmSubmit()"
                        class="w-full mt-6 px-4 py-3 bg-white hover:bg-red-50 text-red-600 font-semibold rounded-lg transition border-2 border-red-600">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Submit Tryout
                    </button>
                </div>
            </div>

            <!-- Right: Question Display -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    
                    <?php $__currentLoopData = $tryout->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div 
                            id="question-<?php echo e($index + 1); ?>" 
                            class="question-container <?php echo e($index === 0 ? '' : 'hidden'); ?>">
                            
                            <!-- Question Number & Text -->
                            <div class="mb-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                        <span class="text-xl font-bold text-blue-600"><?php echo e($index + 1); ?></span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Soal <?php echo e($index + 1); ?> dari <?php echo e($tryout->questions->count()); ?></p>
                                        <p class="text-xs text-gray-400">Poin: <?php echo e($question->points); ?></p>
                                    </div>
                                </div>
                                
                                <div class="prose max-w-none">
                                    <p class="text-lg text-gray-900 leading-relaxed"><?php echo e($question->question_text); ?></p>
                                    
                                    <?php if($question->question_image): ?>
                                        <img src="<?php echo e(asset('storage/' . $question->question_image)); ?>" 
                                             alt="Question Image" 
                                             class="max-w-2xl rounded-lg border mt-4">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Answer Options -->
                            <div class="space-y-3">
                                <?php $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label 
                                        class="block p-4 border-2 rounded-lg cursor-pointer transition
                                               <?php echo e(isset($userAnswers[$question->id]) && $userAnswers[$question->id]->answer_id == $answer->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300 hover:bg-gray-50'); ?>">
                                        <div class="flex items-start">
                                            <input 
                                                type="radio" 
                                                name="question_<?php echo e($question->id); ?>" 
                                                value="<?php echo e($answer->id); ?>"
                                                data-question-id="<?php echo e($question->id); ?>"
                                                data-answer-id="<?php echo e($answer->id); ?>"
                                                onchange="saveAnswer(<?php echo e($question->id); ?>, <?php echo e($answer->id); ?>)"
                                                <?php echo e(isset($userAnswers[$question->id]) && $userAnswers[$question->id]->answer_id == $answer->id ? 'checked' : ''); ?>

                                                class="mt-1 w-5 h-5 text-blue-600">
                                            <div class="ml-4 flex-1">
                                                <div class="flex items-start">
                                                    <span class="font-semibold text-gray-700 mr-3"><?php echo e($answer->option); ?>.</span>
                                                    <div class="flex-1">
                                                        <p class="text-gray-900"><?php echo e($answer->answer_text); ?></p>
                                                        <?php if($answer->answer_image): ?>
                                                            <img src="<?php echo e(asset('storage/' . $answer->answer_image)); ?>" 
                                                                 alt="Answer Image" 
                                                                 class="max-w-md rounded mt-2 border">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="flex items-center justify-between mt-8 pt-6 border-t">
                                <button 
                                    onclick="previousQuestion()"
                                    <?php echo e($index === 0 ? 'disabled' : ''); ?>

                                    class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Sebelumnya
                                </button>

                                <?php if($index < $tryout->questions->count() - 1): ?>
                                    <button 
                                        onclick="nextQuestion()"
                                        class="px-6 py-3 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                        Selanjutnya
                                        <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                <?php else: ?>
                                    <button 
                                        onclick="confirmSubmit()"
                                        class="px-6 py-3 bg-white hover:bg-red-50 text-red-600 font-semibold rounded-lg transition border-2 border-red-600">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Submit Tryout
                                    </button>
                                <?php endif; ?>
                            </div>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Submit Form (Hidden) -->
<form id="submit-form" action="<?php echo e(route('tryout.submit', $tryout->id)); ?>" method="POST" class="hidden">
    <?php echo csrf_field(); ?>
</form>

<?php $__env->startPush('scripts'); ?>
<script>
let currentQuestion = 1;
const totalQuestions = <?php echo e($tryout->questions->count()); ?>;
const tryoutId = <?php echo e($tryout->id); ?>;
let remainingSeconds = <?php echo e(floor($remainingMinutes * 60)); ?>;
let flaggedQuestions = new Set();

// Timer
function startTimer() {
    const timerDisplay = document.getElementById('timer-display');
    
    setInterval(() => {
        remainingSeconds--;
        
        const minutes = Math.floor(remainingSeconds / 60);
        const seconds = remainingSeconds % 60;
        
        timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        // Warning if less than 5 minutes
        if (remainingSeconds <= 300 && remainingSeconds > 0) {
            timerDisplay.classList.add('text-red-600');
        }
        
        // Auto submit when time's up
        if (remainingSeconds <= 0) {
            alert('Waktu habis! Tryout akan di-submit otomatis.');
            document.getElementById('submit-form').submit();
        }
    }, 1000);
}

// Save Answer (AJAX)
function saveAnswer(questionId, answerId) {
    fetch(`/tryout/${tryoutId}/save-answer`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({
            question_id: questionId,
            answer_id: answerId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update navigation button to green
            const navButton = document.getElementById(`nav-${questionId}`);
            navButton.classList.remove('bg-gray-200', 'text-gray-600');
            navButton.classList.add('bg-green-500', 'text-white');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Flag functionality
function toggleFlag(questionId) {
    const navButton = document.getElementById(`nav-${questionId}`);
    const flagButton = document.getElementById(`flag-${questionId}`);
    
    if (flaggedQuestions.has(questionId)) {
        // Unflag
        flaggedQuestions.delete(questionId);
        navButton.classList.remove('bg-gray-700', 'text-white');
        if (!navButton.classList.contains('bg-green-500')) {
            navButton.classList.add('bg-gray-200', 'text-gray-600');
        }
        flagButton.querySelector('svg').classList.remove('text-white');
        flagButton.querySelector('svg').classList.add('text-gray-400');
    } else {
        // Flag
        flaggedQuestions.add(questionId);
        navButton.classList.remove('bg-gray-200', 'text-gray-600', 'bg-green-500');
        navButton.classList.add('bg-gray-700', 'text-white');
        flagButton.querySelector('svg').classList.remove('text-gray-400');
        flagButton.querySelector('svg').classList.add('text-white');
    }
}

// Show flag button on hover
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.nav-button').forEach((btn, index) => {
        btn.parentElement.addEventListener('mouseenter', function() {
            this.querySelector('.flag-button').classList.remove('opacity-0');
            this.querySelector('.flag-button').classList.add('opacity-100');
        });
        btn.parentElement.addEventListener('mouseleave', function() {
            this.querySelector('.flag-button').classList.remove('opacity-100');
            this.querySelector('.flag-button').classList.add('opacity-0');
        });
    });
});

// Navigation Functions
function goToQuestion(questionNumber) {
    // Hide current question
    document.getElementById(`question-${currentQuestion}`).classList.add('hidden');
    
    // Show target question
    document.getElementById(`question-${questionNumber}`).classList.remove('hidden');
    
    currentQuestion = questionNumber;
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function nextQuestion() {
    if (currentQuestion < totalQuestions) {
        goToQuestion(currentQuestion + 1);
    }
}

function previousQuestion() {
    if (currentQuestion > 1) {
        goToQuestion(currentQuestion - 1);
    }
}

function confirmSubmit() {
    const answered = document.querySelectorAll('.nav-button.bg-green-500').length;
    const unanswered = totalQuestions - answered;
    
    let message = 'Yakin ingin submit tryout sekarang?';
    if (unanswered > 0) {
        message += `\n\nMasih ada ${unanswered} soal yang belum dijawab!`;
    }
    
    if (confirm(message)) {
        document.getElementById('submit-form').submit();
    }
}

// Initialize
startTimer();

// Prevent accidental page leave
window.addEventListener('beforeunload', (e) => {
    e.preventDefault();
    e.returnValue = '';
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/student/tryout/work.blade.php ENDPATH**/ ?>