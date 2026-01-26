

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
    <div class="max-w-4xl mx-auto">

        <!-- Success Message -->
        <?php if(session('success')): ?>
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tryout Info Card -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-8 text-white shadow-lg mb-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold mb-2">Tryout Selesai!</h1>
                <p class="text-blue-200 text-sm mt-1"><?php echo e($tryout->code); ?></p>
            </div>
        </div>

        <!-- Score Card -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-12 mb-8">
            <div class="text-center">
                <p class="text-gray-600 text-lg mb-4">Nilai Kamu</p>
                <div class="relative inline-block">
                    <!-- Score Circle -->
                    <div class="w-48 h-48 rounded-full flex items-center justify-center mx-auto mb-6
                                <?php echo e($score >= 80 ? 'bg-green-100' : ($score >= 60 ? 'bg-yellow-100' : 'bg-red-100')); ?>">
                        <div>
                            <p class="text-6xl font-bold
                                      <?php echo e($score >= 80 ? 'text-green-600' : ($score >= 60 ? 'text-yellow-600' : 'text-red-600')); ?>">
                                <?php echo e(number_format($score, 0)); ?>

                            </p>
                            <p class="text-2xl font-semibold text-gray-600">/ 100</p>
                        </div>
                    </div>
                </div>

                <!-- Grade Badge -->
                <div class="inline-flex items-center px-6 py-3 rounded-full font-bold text-lg mb-4
                            <?php echo e($score >= 80 ? 'bg-green-100 text-green-700' : ($score >= 60 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')); ?>">
                    <?php if($score >= 80): ?>
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Excellent!
                    <?php elseif($score >= 60): ?>
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Good Job!
                    <?php else: ?>
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Keep Learning!
                    <?php endif; ?>
                </div>

                <p class="text-gray-600">
                    <?php if($score >= 80): ?>
                        Luar biasa! Kamu menguasai materi dengan sangat baik! 🎉
                    <?php elseif($score >= 60): ?>
                        Bagus! Terus tingkatkan pemahaman kamu! 💪
                    <?php else: ?>
                        Jangan menyerah! Pelajari lagi materi yang kurang dipahami! 📚
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <!-- Correct Answers -->
            <div class="bg-white rounded-xl shadow-sm border-2 border-green-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="text-4xl font-bold text-green-600"><?php echo e($correctAnswers); ?></span>
                </div>
                <p class="text-sm font-semibold text-gray-600">Jawaban Benar</p>
                <p class="text-xs text-gray-500 mt-1"><?php echo e(number_format(($correctAnswers / $totalQuestions) * 100, 1)); ?>% dari total soal</p>
            </div>

            <!-- Wrong Answers -->
            <div class="bg-white rounded-xl shadow-sm border-2 border-red-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="text-4xl font-bold text-red-600"><?php echo e($wrongAnswers); ?></span>
                </div>
                <p class="text-sm font-semibold text-gray-600">Jawaban Salah</p>
                <p class="text-xs text-gray-500 mt-1"><?php echo e(number_format(($wrongAnswers / $totalQuestions) * 100, 1)); ?>% dari total soal</p>
            </div>

            <!-- Unanswered -->
            <div class="bg-white rounded-xl shadow-sm border-2 border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="text-4xl font-bold text-gray-600"><?php echo e($unanswered); ?></span>
                </div>
                <p class="text-sm font-semibold text-gray-600">Tidak Dijawab</p>
                <p class="text-xs text-gray-500 mt-1"><?php echo e(number_format(($unanswered / $totalQuestions) * 100, 1)); ?>% dari total soal</p>
            </div>

        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-center space-x-4">
            <a href="<?php echo e(route('tryout.index')); ?>" 
               class="px-8 py-4 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Dashboard
            </a>
            
            <a href="<?php echo e(route('tryout.review', $tryout->id)); ?>" 
               class="px-8 py-4 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-lg">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Lihat Pembahasan
            </a>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/student/tryout/result.blade.php ENDPATH**/ ?>