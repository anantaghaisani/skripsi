

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
    <div class="max-w-5xl mx-auto">

        <!-- Header Info -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white shadow-lg mb-8">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-blue-100 text-sm">Kode Tryout</p>
                            <p class="text-xl font-bold"><?php echo e($tryout->code); ?></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-4 gap-4 pt-4 border-t border-white/20">
                        <div>
                            <p class="text-blue-100 text-xs mb-1">Total Soal</p>
                            <p class="text-2xl font-bold"><?php echo e($tryout->questions->count()); ?></p>
                        </div>
                        <div>
                            <p class="text-green-200 text-xs mb-1">Benar</p>
                            <p class="text-2xl font-bold text-green-300">
                                <?php echo e($userAnswers->where('is_correct', true)->count()); ?>

                            </p>
                        </div>
                        <div>
                            <p class="text-red-200 text-xs mb-1">Salah</p>
                            <p class="text-2xl font-bold text-red-300">
                                <?php echo e($userAnswers->where('is_correct', false)->count()); ?>

                            </p>
                        </div>
                        <div>
                            <p class="text-gray-200 text-xs mb-1">Kosong</p>
                            <p class="text-2xl font-bold text-gray-300">
                                <?php echo e($tryout->questions->count() - $userAnswers->count()); ?>

                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Score Display -->
                <?php
                    $totalQuestions = $tryout->questions->count();
                    $correctAnswers = $userAnswers->where('is_correct', true)->count();
                    $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 1) : 0;
                ?>
                <div class="text-center bg-white/20 rounded-xl px-8 py-4 ml-6">
                    <p class="text-blue-100 text-sm mb-2">Nilai Kamu</p>
                    <div class="text-5xl font-bold"><?php echo e($score); ?></div>
                    <p class="text-blue-200 text-xs mt-2">dari 100</p>
                </div>
            </div>
        </div>

        <!-- Quick Navigation -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6 sticky top-6 z-10">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-gray-900">Navigasi Cepat</h3>
                <div class="flex items-center space-x-4 text-sm">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                        <span class="text-gray-600">Benar</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-red-500 rounded mr-2"></div>
                        <span class="text-gray-600">Salah</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-gray-300 rounded mr-2"></div>
                        <span class="text-gray-600">Tidak Dijawab</span>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-10 gap-2 mt-4">
                <?php $__currentLoopData = $tryout->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $userAnswer = $userAnswers->get($question->id);
                        $isCorrect = $userAnswer && $userAnswer->is_correct;
                        $isAnswered = $userAnswer !== null;
                    ?>
                    <a href="#question-<?php echo e($question->id); ?>" 
                       class="w-10 h-10 rounded-lg font-semibold text-sm flex items-center justify-center transition
                              <?php echo e($isAnswered ? ($isCorrect ? 'bg-green-500 text-white' : 'bg-red-500 text-white') : 'bg-gray-300 text-gray-700'); ?>

                              hover:opacity-80">
                        <?php echo e($index + 1); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Questions List -->
        <div class="space-y-6">
            <?php $__currentLoopData = $tryout->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $userAnswer = $userAnswers->get($question->id);
                    $isCorrect = $userAnswer && $userAnswer->is_correct;
                    $isAnswered = $userAnswer !== null;
                    $correctAnswer = $question->answers->where('is_correct', true)->first();
                ?>

                <div id="question-<?php echo e($question->id); ?>" 
                     class="bg-white rounded-xl shadow-sm border-2 p-8
                            <?php echo e($isAnswered ? ($isCorrect ? 'border-green-500' : 'border-red-500') : 'border-gray-300'); ?>">
                    
                    <!-- Question Header -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4
                                        <?php echo e($isAnswered ? ($isCorrect ? 'bg-green-100' : 'bg-red-100') : 'bg-gray-100'); ?>">
                                <?php if($isAnswered): ?>
                                    <?php if($isCorrect): ?>
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                    </svg>
                                <?php endif; ?>
                            </div>
                            <div>
                                <p class="text-sm font-semibold
                                          <?php echo e($isAnswered ? ($isCorrect ? 'text-green-600' : 'text-red-600') : 'text-gray-500'); ?>">
                                    Soal <?php echo e($index + 1); ?>

                                </p>
                                <p class="text-xs text-gray-500">Poin: <?php echo e($question->points); ?></p>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <span class="px-4 py-2 rounded-lg text-sm font-semibold
                                     <?php echo e($isAnswered ? ($isCorrect ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') : 'bg-gray-100 text-gray-700'); ?>">
                            <?php if($isAnswered): ?>
                                <?php echo e($isCorrect ? 'Benar ✓' : 'Salah ✗'); ?>

                            <?php else: ?>
                                Tidak Dijawab
                            <?php endif; ?>
                        </span>
                    </div>

                    <!-- Question Text -->
                    <div class="mb-6">
                        <div class="prose max-w-none">
                            <p class="text-lg text-gray-900 leading-relaxed mb-4"><?php echo e($question->question_text); ?></p>
                            
                            <?php if($question->question_image): ?>
                                <img src="<?php echo e(asset('storage/' . $question->question_image)); ?>" 
                                     alt="Question Image" 
                                     class="max-w-2xl rounded-lg border">
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Answer Options -->
                    <div class="space-y-3 mb-6">
                        <?php $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $isUserAnswer = $userAnswer && $userAnswer->answer_id == $answer->id;
                                $isCorrectAnswer = $answer->is_correct;
                            ?>

                            <div class="p-4 border-2 rounded-lg
                                        <?php echo e($isCorrectAnswer ? 'border-green-500 bg-green-50' : ($isUserAnswer ? 'border-red-500 bg-red-50' : 'border-gray-200')); ?>">
                                <div class="flex items-start">
                                    <!-- Option Badge -->
                                    <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center mr-3
                                                <?php echo e($isCorrectAnswer ? 'bg-green-500 text-white' : ($isUserAnswer ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700')); ?>">
                                        <span class="font-bold text-sm"><?php echo e($answer->option); ?></span>
                                    </div>

                                    <!-- Answer Content -->
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <p class="text-gray-900 <?php echo e($isCorrectAnswer || $isUserAnswer ? 'font-semibold' : ''); ?>">
                                                    <?php echo e($answer->answer_text); ?>

                                                </p>
                                                <?php if($answer->answer_image): ?>
                                                    <img src="<?php echo e(asset('storage/' . $answer->answer_image)); ?>" 
                                                         alt="Answer Image" 
                                                         class="max-w-md rounded mt-2 border">
                                                <?php endif; ?>
                                            </div>

                                            <!-- Icons -->
                                            <div class="ml-4 flex items-center space-x-2">
                                                <?php if($isCorrectAnswer): ?>
                                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-green-500 text-white">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Kunci Jawaban
                                                    </span>
                                                <?php endif; ?>
                                                <?php if($isUserAnswer && !$isCorrectAnswer): ?>
                                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-red-500 text-white">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Jawaban Kamu
                                                    </span>
                                                <?php elseif($isUserAnswer && $isCorrectAnswer): ?>
                                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-green-500 text-white">
                                                        Jawaban Kamu
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Explanation -->
                    <?php if($question->explanation): ?>
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-blue-900 mb-2">Pembahasan:</h4>
                                    <p class="text-blue-800 leading-relaxed"><?php echo e($question->explanation); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Bottom Actions -->
        <div class="mt-8 flex items-center justify-between bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <a href="<?php echo e(route('tryout.result', $tryout->id)); ?>" 
               class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Hasil
            </a>

            <a href="<?php echo e(route('tryout.index')); ?>" 
               class="px-6 py-3 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                Kembali ke Dashboard
                <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </a>
        </div>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Smooth scroll to question
document.querySelectorAll('a[href^="#question-"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/student/tryout/review.blade.php ENDPATH**/ ?>