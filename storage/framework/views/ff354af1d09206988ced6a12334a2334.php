

<?php $__env->startSection('title', 'Kelola Soal - Hakuna Matata Course'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('tentor.components.breadcrumb', [
        'backUrl' => route('tentor.tryout.index'),
        'previousPage' => 'Daftar Tryout',
        'currentPage' => 'Kelola Soal'
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8 space-y-6">

    <!-- Success/Error Message -->
    <?php if(session('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-red-800"><?php echo e(session('error')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Tryout Info Card -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2"><?php echo e($tryout->title); ?></h2>
                <p class="text-blue-100 mb-3"><?php echo e($tryout->code); ?></p>
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
                        Tersedia: <?php echo e($tryout->getQuestionCount()); ?> soal
                    </span>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm text-blue-100 mb-1">Progress</div>
                <div class="text-3xl font-bold">
                    <?php echo e($tryout->total_questions > 0 ? round(($tryout->getQuestionCount() / $tryout->total_questions) * 100) : 0); ?>%
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center justify-between">
        <h3 class="text-xl font-bold text-gray-900">Daftar Soal</h3>
        <div class="flex items-center space-x-3">
            <a href="<?php echo e(route('tentor.question.bulk-create', $tryout->id)); ?>" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Soal
            </a>
        </div>
    </div>

    <!-- Questions List -->
    <?php if($tryout->questions->isEmpty()): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Soal</h3>
            <p class="text-gray-600 mb-6">Mulai tambahkan soal untuk tryout ini</p>
            <div class="flex items-center justify-center space-x-3">
                <a href="<?php echo e(route('tentor.question.create', $tryout->id)); ?>" 
                   class="inline-flex items-center px-6 py-3 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Soal
                </a>
                <a href="<?php echo e(route('tentor.question.bulk-create', $tryout->id)); ?>" 
                   class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Bulk
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php $__currentLoopData = $tryout->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <!-- Question Header -->
                            <div class="flex items-start mb-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                    <span class="text-lg font-bold text-blue-600"><?php echo e($question->question_number); ?></span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-900 font-medium mb-2"><?php echo e($question->question_text); ?></p>
                                    <?php if($question->question_image): ?>
                                        <img src="<?php echo e(asset('storage/' . $question->question_image)); ?>" 
                                             alt="Question Image" 
                                             class="max-w-md rounded-lg border mb-3">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Answers -->
                            <div class="ml-14 space-y-2">
                                <?php $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-start p-3 rounded-lg <?php echo e($answer->is_correct ? 'bg-green-50 border border-green-200' : 'bg-gray-50'); ?>">
                                        <span class="font-semibold <?php echo e($answer->is_correct ? 'text-green-700' : 'text-gray-600'); ?> mr-3">
                                            <?php echo e($answer->option); ?>.
                                        </span>
                                        <div class="flex-1">
                                            <p class="<?php echo e($answer->is_correct ? 'text-green-900 font-medium' : 'text-gray-700'); ?>">
                                                <?php echo e($answer->answer_text); ?>

                                            </p>
                                            <?php if($answer->answer_image): ?>
                                                <img src="<?php echo e(asset('storage/' . $answer->answer_image)); ?>" 
                                                     alt="Answer Image" 
                                                     class="max-w-xs rounded mt-2 border">
                                            <?php endif; ?>
                                        </div>
                                        <?php if($answer->is_correct): ?>
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <!-- Explanation -->
                            <?php if($question->explanation): ?>
                                <div class="ml-14 mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                    <p class="text-sm font-semibold text-blue-900 mb-1">📖 Pembahasan:</p>
                                    <p class="text-sm text-blue-800"><?php echo e($question->explanation); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Action Buttons with Tooltip -->
                        <div class="flex-shrink-0 ml-4 flex space-x-2">
                            <!-- Edit -->
                            <div class="relative group">
                                <a href="<?php echo e(route('tentor.question.edit', [$tryout->id, $question->id])); ?>" 
                                   class="inline-flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none z-10">
                                    Edit
                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                        <div class="border-4 border-transparent border-t-gray-900"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hapus -->
                            <form action="<?php echo e(route('tentor.question.destroy', [$tryout->id, $question->id])); ?>" method="POST" class="relative group">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                        onclick="return confirm('Yakin ingin menghapus soal ini?')"
                                        class="inline-flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none z-10">
                                    Hapus
                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                        <div class="border-4 border-transparent border-t-gray-900"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('tentor.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/tentor/question/index.blade.php ENDPATH**/ ?>