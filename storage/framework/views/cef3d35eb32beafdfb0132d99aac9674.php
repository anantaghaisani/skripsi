

<?php $__env->startSection('title', 'Edit Soal - Hakuna Matata Course'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('components.admin-breadcrumb', [
        'backUrl' => route('admin.question.index', $tryout->id),
        'previousPage' => 'Kelola Soal',
        'currentPage' => 'Edit Soal'
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8">

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900">Edit Soal #<?php echo e($question->question_number); ?>: <?php echo e($tryout->title); ?></h2>
            <p class="text-sm text-gray-500 mt-1">Token: <span class="font-mono font-semibold"><?php echo e($tryout->token); ?></span></p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <form action="<?php echo e(route('admin.question.update', [$tryout->id, $question->id])); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

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
                              required><?php echo e(old('question_text', $question->question_text)); ?></textarea>
                    <?php $__errorArgs = ['question_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Current Question Image -->
                <?php if($question->question_image): ?>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Soal Saat Ini</label>
                        <img src="<?php echo e(asset('storage/' . $question->question_image)); ?>" 
                             alt="Question Image" 
                             class="max-w-md rounded-lg border">
                    </div>
                <?php endif; ?>

                <!-- Question Image (Optional) -->
                <div class="mb-6">
                    <label for="question_image" class="block text-sm font-semibold text-gray-700 mb-2">
                        <?php echo e($question->question_image ? 'Ganti Gambar Soal (Opsional)' : 'Gambar Soal (Opsional)'); ?>

                    </label>
                    <input type="file" 
                           id="question_image" 
                           name="question_image" 
                           accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, atau JPEG (Max. 2MB). Kosongkan jika tidak ingin mengubah.</p>
                    <?php $__errorArgs = ['question_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Answer Options -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Pilihan Jawaban <span class="text-red-500">*</span>
                    </label>
                    
                    <?php $__currentLoopData = $question->answers->sortBy('option'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-4 p-4 border border-gray-200 rounded-lg <?php echo e($answer->is_correct ? 'bg-green-50 border-green-300' : ''); ?>">
                            <div class="flex items-start gap-3">
                                <div class="flex items-center h-10">
                                    <input type="radio" 
                                           id="correct_<?php echo e($answer->option); ?>" 
                                           name="correct_answer" 
                                           value="<?php echo e($answer->option); ?>"
                                           <?php echo e(old('correct_answer', $answer->is_correct ? $answer->option : '') === $answer->option ? 'checked' : ''); ?>

                                           class="w-5 h-5 text-red-600 border-gray-300 focus:ring-red-500"
                                           required>
                                </div>
                                <div class="flex-1">
                                    <label for="correct_<?php echo e($answer->option); ?>" class="block text-sm font-medium text-gray-700 mb-2">
                                        Opsi <?php echo e($answer->option); ?> 
                                        <span class="text-xs text-gray-500">(Centang jika ini jawaban benar)</span>
                                    </label>
                                    
                                    <!-- Current Answer Image -->
                                    <?php if($answer->answer_image): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo e(asset('storage/' . $answer->answer_image)); ?>" 
                                                 alt="Answer <?php echo e($answer->option); ?>" 
                                                 class="max-w-xs rounded border">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <textarea name="answer_<?php echo e(strtolower($answer->option)); ?>_text" 
                                              rows="2"
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm"
                                              placeholder="Masukkan teks opsi <?php echo e($answer->option); ?>..."
                                              required><?php echo e(old('answer_' . strtolower($answer->option) . '_text', $answer->answer_text)); ?></textarea>
                                    
                                    <!-- Answer Image Upload -->
                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 mb-1">
                                            <?php echo e($answer->answer_image ? 'Ganti Gambar Jawaban (Opsional)' : 'Gambar Jawaban (Opsional)'); ?>

                                        </label>
                                        <input type="file" 
                                               name="answer_<?php echo e(strtolower($answer->option)); ?>_image" 
                                               accept="image/*"
                                               class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500">
                                    </div>
                                </div>
                            </div>
                            <?php $__errorArgs = ['answer_' . strtolower($answer->option) . '_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-red-600 mt-1 ml-8"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php $__errorArgs = ['correct_answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                              placeholder="Masukkan pembahasan atau penjelasan jawaban..."><?php echo e(old('explanation', $question->explanation)); ?></textarea>
                    <?php $__errorArgs = ['explanation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t">
                    <a href="<?php echo e(route('admin.question.index', $tryout->id)); ?>" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition shadow-sm">
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/admin/question/edit.blade.php ENDPATH**/ ?>